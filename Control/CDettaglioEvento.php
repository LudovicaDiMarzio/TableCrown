<?php
namespace TableCrown\Control;

use TableCrown\Utility\UHTTPMethods;
use TableCrown\Utility\UFlashMessage;
use TableCrown\Entity\EEvento;
use TableCrown\Entity\ETorneo;
use TableCrown\Entity\EChallenge;
use TableCrown\Entity\ESerata;
use TableCrown\Entity\EPartecipazione;
use TableCrown\Entity\ECartaDiCredito;
use TableCrown\Foundation\FPersistentManager;
use TableCrown\Foundation\BancaMockService;
use TableCrown\Presentation\Views\ViewDettaglioEvento;
use TableCrown\Presentation\Views\ViewCheckout;

class CDettaglioEvento extends BaseController {

    private ?int $idEventoCorrente = null; 

    public function __construct() {
        parent::__construct();

        //Se è un gestore o un admin, lo spinge subito sulla sua dashboard
        $this->reindirizzaAdminGestore();
    }

    /**
     * Mostra la pagina di dettaglio di un evento specifico.
     * URL: GET /eventi/dettaglio?id=X (Accesso libero)
     */
    public function mostraDettaglioEvento(): void {
        $idEventoRaw = UHTTPMethods::get('id');
        if ($idEventoRaw === null || !is_numeric($idEventoRaw)) {
            UFlashMessage::addMessage('danger', 'ID evento non valido.');
            header('Location: ' . BASE_URL . '/eventi');
            exit();
        }

        $idEvento = (int) $idEventoRaw;
        $this->idEventoCorrente = $idEvento;

        $evento = FPersistentManager::PMgetObjOnAttribute(EEvento::class, 'idEvento', $idEvento);

        if (!$evento) {
            UFlashMessage::addMessage('danger', 'L\'evento richiesto non esiste o non è più disponibile.');
            header('Location: ' . BASE_URL . '/eventi');
            exit();
        }

        $datiPagina = $this->costruisciDatiVistaEvento($evento, modalita: 'utente');
        $datiLayout = $this->preparaDatiLayout('evento', $datiPagina);

        //Chiamata alla View
        ViewDettaglioEvento::mostraDettaglioEvento($datiLayout);
    }

    /**
     * Mostra la pagina di checkout specifica per il pagamento della quota di iscrizione di un evento
     * URL: GET /eventi/checkout?id=X
     */
    public function mostraCheckoutEvento(): void {
        $idEventoRaw = UHTTPMethods::get('id');
        if ($idEventoRaw === null || !is_numeric($idEventoRaw)) {
            UFlashMessage::addMessage('danger', 'ID evento non valido.');
            header('Location: ' . BASE_URL . '/eventi');
            exit();
        }

        $idEvento = (int) $idEventoRaw;
        $utente = $this->utenteCorrente();

        $evento = FPersistentManager::PMgetObjOnAttribute(EEvento::class, 'idEvento', $idEvento);

        if (!$evento) {
            UFlashMessage::addMessage('danger', 'L\'evento richiesto non esiste o non è più disponibile.');
            header('Location: ' . BASE_URL . '/eventi');
            exit();
        }

        if (!$evento->richiedeQuota()) {
            //Se levento è gratuito, non serve il checkout
            header('Location: ' . BASE_URL . '/eventi/dettaglio/' . $idEvento);
            exit();
        }

        //Regole di business:
        if ($evento instanceof ETorneo && $evento->getChallenge() !== null) {
            UFlashMessage::addMessage('danger', 'Non puoi iscriverti a questo torneo singolarmente, perché fa parte di una Challenge. Iscriviti alla Challenge associata.');
            header('Location: ' . BASE_URL . '/eventi/dettaglio/' . $evento->getChallenge()->getIdEvento());
            exit();
        }

        //Recuperiamo le carte salvate dell'utente dal DB tramite il pm
        $carteUtente = FPersistentManager::PMgetObjListOnAttribute(ECartaDiCredito::class, 'utente', $utente);

        //Prepariamo i dati unendo il mapping dell'evento e le informazioni per il checkout
        $datiPagina = [
            'vista' => 'checkout',
            'tipo_checkout' => 'evento',
            'azione_checkout' => BASE_URL . '/eventi/partecipa',
            'evento' => $this->mappaEvento($evento),
            'quota' => $evento instanceof ETorneo || $evento instanceof EChallenge ? $evento->getQuotaIscrizione()->getValore(): 0.0,
            'carte' => $this->carteToArray($carteUtente),
        ];

        $datiLayout = $this->preparaDatiLayout('checkout_evento', $datiPagina);
        ViewCheckout::mostraCheckout($datiLayout);
    }
    
    /**
     * Gestisce la prenotazione a un evento.
     * URL: POST /eventi/partecipa
     */
    public function partecipaEvento(): void { 
        $utente = $this->utenteCorrente();

        $idEvento = UHTTPMethods::postInt('id_evento');
        if (!$idEvento) {
            UFlashMessage::addMessage('danger', 'Evento non specificato.');
            header('Location: ' . BASE_URL . '/eventi');
            exit();
        }

        $evento = FPersistentManager::PMgetObjOnAttribute(EEvento::class, 'idEvento', $idEvento);
        if (!$evento) {
            UFlashMessage::addMessage('danger', 'L\'evento selezionato non esiste.');
            header('Location: ' . BASE_URL . '/eventi');
            exit();
        }
        
        if ($this->utenteIscritto($evento)) {
            UFlashMessage::addMessage('danger', 'Sei già iscritto a questo evento.');
            header('Location: ' . BASE_URL . '/eventi/dettaglio/' . $idEvento);
            exit();
        }

        //Regole di business: controllo disponibilità posti
        if (!$evento->hasPostiDisponibili()) {
            UFlashMessage::addMessage('danger', 'Spiacenti, i posti per questo evento sono esauriti.');
            header('Location: ' . BASE_URL . '/eventi/dettaglio/' . $idEvento);
            exit();
        }

        //Regole di business: se l'utente prova ad iscriversi ad un torneo che fa parte di una challenge, lo blocchiamo
        if ($evento instanceof ETorneo && $evento->getChallenge() !== null) {
            UFlashMessage::addMessage('danger', 'Questo torneo fa parte di una Challenge. Iscriviti direttamente alla Challenge associata per partecipare.');
            header('Location: ' . BASE_URL . '/eventi/dettaglio/' . $evento->getChallenge()->getIdEvento());
            exit();
        }

        try {
            //INIZIO TRANSAZIONE E ISCRIZIONE
            FPersistentManager::beginTransaction();

            //Re-check difensivo dei posti disponibili
            if (!$evento->hasPostiDisponibili()) {
                throw new \RuntimeException("I posti per questo evento sono esauriti.");
            }
                
            //Gestione del pagamento (se richiesto dall'evento) 
            if ($evento->richiedeQuota()) {
                $quota = null;
                if ($evento instanceof ETorneo || $evento instanceof EChallenge || $evento instanceof ESerata) {
                    $quota = $evento->getQuotaIscrizione(); //se è un torneo o un serata, la quota è definita nell'evento
                }

                if ($quota === null) {
                    throw new \InvalidArgumentException("Impossibile determinare la quota per questo evento.");
                }

                $bancaService = new BancaMockService();

                //Se arriva solo una nuova carta, 'scelta_carta' sarà forzato a 'nuova' nel form POST
                $sceltaCarta = UHTTPMethods::postString('scelta_carta') ?? 'nuova';
                $idCartaSalvata = UHTTPMethods::postInt('id_carta_salvata');

                //Risoluzione centralizzata della carta
                $carta = $this->risolviCartaPagamento($sceltaCarta, $idCartaSalvata, $utente, $bancaService);

                //Addebito effettivo
                $pagamentoAvvenuto = $bancaService->effettuaPagamento($carta->getToken(), $quota->getValore());

                if (!$pagamentoAvvenuto) {
                    throw new \RuntimeException("Si è verificato un errore durante il pagamento.");
                } 
            }
            
            //Regole di business: creazione delle partecipazioni
            //Prepariamo la lista di partecipazioni da salvare
            $partecipazioniDaSalvare = [];

            //Partecipazione all'evento principale richiesto (Serata, Torneo Singolo o Challenge)
            $pPrincipale = new EPartecipazione($utente, $evento);
            if ($evento->richiedeQuota()) { 
                $pPrincipale->aggiornaPagamento(); //aggiornaPagamento() rifà internamente il controllo richiedeQuota, ma è una ridondanza innocua
            }
            $partecipazioniDaSalvare[] = $pPrincipale;

            //Se l'evento è una challenge, iscriviamo automaticamente l'utente a tutti i tornei inclusi
            if ($evento instanceof EChallenge) {
                foreach ($evento->getTornei() as $torneo) {
                    if (!$this->utenteIscritto($torneo)) {
                        $pTorneo = new EPartecipazione($utente, $torneo);
                        if ($torneo->richiedeQuota()) {
                            $pTorneo->aggiornaPagamento();
                        }
                        $partecipazioniDaSalvare[] = $pTorneo;
                    }
                }
            } 

            //Salviamo tutto in blocco nel db tramite il pm
            foreach ($partecipazioniDaSalvare as $partecipazione) {
                $salvato =FPersistentManager::PMsaveObj($partecipazione);
                if (!$salvato) {
                    throw new \RuntimeException("Si è verificato un errore durante la salvataggio della partecipazione.");
                }
            }

            //CONFERMA TRANSAZIONE
            FPersistentManager::commit();

            UFlashMessage::addMessage('success', 'Iscrizione effettuata con successo!');
            header('Location: ' . BASE_URL . '/eventi/dettaglio/' . $idEvento);
            exit();

        } catch (\Exception $e) {
            //ANNULLA TUTTE LE OPERAZIONI DB SE QUALCOSA VA STORTO
            FPersistentManager::rollback();

            UFlashMessage::addMessage('danger', 'Errore durante l\iscrizione: ' . $e->getMessage());
            header('Location: ' . BASE_URL . '/eventi/dettaglio/' . $idEvento); 
            exit();
        }
    }


    protected function getBreadcrumbs(string $currentPage = ''): array {
        return [
            ['label' => 'Home', 'url' => BASE_URL . '/'],
            ['label' => 'Eventi', 'url' => BASE_URL . '/eventi'],
            ['label' => 'Dettaglio evento', 'url' => BASE_URL . '/eventi/dettaglio/' . $this->idEventoCorrente],
        ];
    }

}