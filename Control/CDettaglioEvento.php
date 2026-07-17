<?php
namespace TableCrown\Control;

use TableCrown\Utility\UHTTPMethods;
use TableCrown\Utility\UFlashMessage;
use TableCrown\Utility\USession;
use TableCrown\Entity\EEvento;
use TableCrown\Entity\ESerata;
use TableCrown\Entity\ETorneo;
use TableCrown\Entity\EChallenge;
use TableCrown\Entity\EPartecipazione;
use TableCrown\Entity\EUtente;
use TableCrown\Entity\ECartaDiCredito;
use TableCrown\Entity\EPrezzo;
use TableCrown\Foundation\FPersistentManager;
use TableCrown\Foundation\BancaMockService;
use TableCrown\Presentation\Views\ViewDettaglioEvento;
use TableCrown\Presentation\Views\ViewCheckout;

class CDettaglioEvento extends BaseController {

    private ?int $idEventoCorrente = null; 

    public function __construct() {
        parent::__construct();
    }

    /**
     * Mostra la pagina di dettaglio di un evento specifico.
     * URL: GET /eventi/dettaglio?id=X (Accesso libero)
     */
    public function mostraDettaglioEvento(int $idEvento): void {
        $this->idEventoCorrente = $idEvento;

        $evento = FPersistentManager::PMgetObjOnAttribute(EEvento::class, 'idEvento', $idEvento);

        if (!$evento) {
            UFlashMessage::addMessage('danger', 'L\'evento richiesto non esiste o non è più disponibile.');
            header('Location: ' . BASE_URL . '/eventi');
            exit();
        }

        $datiPagina = $this->costruisciDatiVista($evento);
        $datiLayout = $this->preparaDatiLayout('evento', $datiPagina);

        //Chiamata alla View
        ViewDettaglioEvento::mostraDettaglioEvento($datiLayout);
    }

    /**
     * Mostra la pagina di checkout specifica per il pagamento della quota di iscrizione di un evento
     * URL: GET /eventi/checkout?id=X
     */
    public function mostraCheckoutEvento(int $idEvento): void {
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

        try {
            $nuovaPartecipazione = new EPartecipazione($utente, $evento);
        } catch (\InvalidArgumentException $e) {
            UFlashMessage::addMessage('danger', $e->getMessage());
            header('Location: ' . BASE_URL . '/eventi/dettaglio/' . $idEvento);
            exit();
        }

        //Gestione del pagamento 
        if ($evento->richiedeQuota()) {
            try {
                $quota = null;
                if ($evento instanceof ETorneo || $evento instanceof EChallenge) {
                    $quota = $evento->getQuotaIscrizione();
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

                if ($pagamentoAvvenuto) {
                    //Aggiorniamo lo stato della partecipazione prima del salvataggio
                    $nuovaPartecipazione->aggiornaPagamento(); //aggiornaPagamento() rifà internamente il controllo richiedeQuota, ma è una ridondanza innocua
                } else {
                    throw new \RuntimeException("Si è verificato un errore durante il pagamento.");
                }

            } catch (\Exception $e) {
                //Se il pagamento fallisce, interrompiamo tutto e mostriamo l'errore della banca
                UFlashMessage::addMessage('danger', 'Pagamento rifiutato: ' . $e->getMessage());
                header('Location: ' . UHTTPMethods::getReferer(BASE_URL . $this->urlCatalogo($evento)));
                exit();
            }
        }
    }

    //==========================================================================
    // HELPER PRIVATI 
    //==========================================================================

    /**
     * Costruisce i dati di dettaglio partendo dagli helper già esistenti
     * nel BaseController (serataToArray, torneoToArray, challengeToArray),
     * aggiungendo i campi extra necessari solo alla pagina di dettaglio.
     */
    private function costruisciDatiVista(EEvento $evento): array {
        if ($evento instanceof ESerata) {
            $dati = $this->serataToArray($evento);
            $vista = 'dettaglio_serata';
        } elseif ($evento instanceof ETorneo) {
            $dati = $this->torneoToArray($evento);
            //Nel catalogo 'premio' è un link minimale (id, nome, immagine); qui invece
            //per la view serve la card completa del prodotto, come nel catalogo dei prodotti.
            $dati['premio'] = $this->prodottoToArray($evento->getPremio());
            $vista = 'dettaglio_torneo';
        } elseif ($evento instanceof EChallenge) {
            $dati = $this->challengeToArray($evento);
            $dati['premio'] = $this->prodottoToArray($evento->getPremio());
            //'tornei' nel catalogo è un array di link minimali (id, nome); qui invece
            //serve la card completa di ogni torneo, quindi sostituiamo con torneoToArray().
            //Nota: con torneoToArray() ogni torneo avra a sua volta un link minimale alla 
            //challenge, ma nella UI quel campo può semplicemente essere ignorato
            $dati['tornei'] = array_map(
                fn($t) => $this->torneoToArray($t),
                $evento->getTornei()->toArray()
            );
            $dati['punteggi'] = [ //i punteggi non ci sono in challengeToArray() perché non servono nel catalogo, qui li aggiungiamo
                'primo' => $evento->getPunteggioPrimoClassificato(),
                'secondo' => $evento->getPunteggioSecondoClassificato(),
                'terzo' => $evento->getPunteggioTerzoClassificato(),
            ];
            $vista = 'dettaglio_challenge';
        } else {
            //Difensivo: non dovrebbe mai accadere dato il DiscriminatorMap di EEvento, ma lo aggiungiamo per sicurezza
            throw new \LogicException('Tipo di evento non riconosciuto: ' . get_class($evento));
        }

        $dati['vista'] = $vista;
        $dati['descrizioneEvento'] = $evento->getDescrizioneEvento();
        $dati['postiRimanenti'] = $evento->getMaxPartecipanti() - $evento->getNumeroPartecipanti();
        $dati['hasPostiDisponibili'] = $evento->hasPostiDisponibili();
        $dati['userIscritto'] = $this->utenteIscritto($evento);

        return $dati;
    }

    /**
     * Verifica se l'utente attualmente loggato è già iscritto a questo evento.
     */
    private function utenteIscritto(EEvento $evento): bool {
        if (!$this->isLoggedIn() || USession::getSessionElement('ruolo') !== 'utente') {
            return false;        
        }
        $idUtente = USession::getSessionElement('id_persona');

        foreach ($evento->getPartecipazioni() as $partecipazione) {
            if ($partecipazione->getUtente()->getIdPersona() === $idUtente) {
                return true;
            }
        }

        return false;
    }

    protected function getBreadcrumbs(string $currentPage = ''): array {
        return [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Eventi', 'url' => '/eventi'],
            ['label' => 'Dettaglio evento', 'url' => '/eventi/dettaglio/' . $this->idEventoCorrente],
        ];
    }

}