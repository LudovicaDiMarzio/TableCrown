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
            header('Location: /eventi');
            exit();
        }

        $datiPagina = $this->costruisciDatiVista($evento);
        $datiLayout = $this->preparaDatiLayout('evento', $datiPagina);

        //Chiamata alla View
        ViewDettaglioEvento::mostraDettaglioEvento($datiLayout);
    }
    
    /**
     * Gestisce la prenotazione a un evento.
     * URL: POST /eventi/partecipa
     */
    public function partecipaEvento(): void {
        $this->requireRole('utente');

        $idEvento = UHTTPMethods::postInt('id_evento');
        if (!$idEvento) {
            UFlashMessage::addMessage('danger', 'Evento non specificato.');
            header('Location: /eventi');
            exit();
        }

        $evento = FPersistentManager::PMgetObjOnAttribute(EEvento::class, 'idEvento', $idEvento);
        if (!$evento) {
            UFlashMessage::addMessage('danger', 'L\'evento selezionato non esiste.');
            header('Location: /eventi');
            exit();
        }

        $idUtente = USession::getSessionElement('id_persona');
        $utente = FPersistentManager::PMgetObjOnAttribute(EUtente::class, 'idPersona', $idUtente);

        if ($this->utenteIscritto($evento)) {
            UFlashMessage::addMessage('danger', 'Sei già iscritto a questo evento.');
            header('Location: /eventi/dettaglio/' . $idEvento);
            exit();
        }

        try {
            $nuovaPartecipazione = new EPartecipazione($utente, $evento);
        } catch (\InvalidArgumentException $e) {
            UFlashMessage::addMessage('danger', $e->getMessage());
            header('Location: /eventi/dettaglio/' . $idEvento);
            exit();
        }

        //Gestione del pagamento 
        if ($evento->richiedeQuota()) {
            try {
                //Recuperiamo i dati della carta inviati dal form
                $numeroCarta = UHTTPMethods::postString('numero_carta');
                $cvv = UHTTPMethods::postString('cvv');
                $titoloCarta = UHTTPMethods::postString('titolare_carta');
                $scadenzaCarta = UHTTPMethods::postString('scadenza_carta');

                if (empty($numeroCarta) || empty($cvv) || empty($titoloCarta) || empty($dataScadenza)) {
                    throw new \InvalidArgumentException("Tutti i campi di pagamento sono obbligatori.");
                }

                $quota = null;
                if ($evento instanceof ETorneo || $evento instanceof EChallenge) {
                    $quota = $evento->getQuotaIscrizione();
                }

                if ($quota === null) {
                    throw new \InvalidArgumentException("Impossibile determinare la quota per questo evento.");
                }

                //Chiamata all'helper privato per processare la transazione
                $pagamentoAvvenuto = $this->processaPagamento($utente, $numeroCarta, $cvv, $titoloCarta, $scadenzaCarta, $quota);

                if ($pagamentoAvvenuto) {
                    //Aggiorniamo lo stato della partecipazione prima del salvataggio
                    $nuovaPartecipazione->aggiornaPagamento();
                }
            } catch (\Exception $e) {
                //Se il pagamento fallisce, interrompiamo tutto e mostriamo l'errore della banca
                UFlashMessage::addMessage('danger', 'Pagamento rifiutato: ' . $e->getMessage());
                header('Location: /eventi/dettaglio/' . $idEvento);
                exit();
            }
        }

        //Salvataggio finale solo se gratuito o se il pagamento è andato a buon fine
        $salvato = FPersistentManager::PMsaveObj($nuovaPartecipazione);

        if ($salvato) {
            UFlashMessage::addMessage('success', 'Partecipazione effettuata con successo!');
        } else {
            UFlashMessage::addMessage('danger', 'Si è verificato un errore durante la prenotazione. Riprova.');
        }

        header('Location: /eventi/dettaglio/' . $idEvento);
        exit();
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

    /**
     * Helper privato per dialogare con la classe BancaMockService in Foundation.
     */
    private function processaPagamento(EUtente $utente, string $numeroCarta, string $cvv, string $titolare, string $scadenza, EPrezzo $quota): bool {
        $bancaService = new BancaMockService();

        //Genera il token monouso
        $datiToken = $bancaService->generaToken($numeroCarta, $cvv);

        //Costruzione "usa e getta", non salviamo la carta
        $cartaTemporanea = new ECartaDiCredito ($utente, $titolare, $scadenza, substr(trim($numeroCarta), -4), $datiToken['token']);

        //Se la carta è scaduta o i dati non validi, il costruttore lancia InvalidArgumentException, che viene catturata dal chiamante

        //Addebita l'importo
        return $bancaService->effettuaPagamento($cartaTemporanea->getToken(), $quota->getValore());
    }

    protected function getBreadcrumbs(string $currentPage = ''): array {
        return [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Eventi', 'url' => '/eventi'],
            ['label' => 'Dettaglio evento', 'url' => '/eventi/dettaglio/' . $this->idEventoCorrente],
        ];
    }

}