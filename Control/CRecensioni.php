<?php
namespace TableCrown\Control;

use TableCrown\Utility\UHTTPMethods;
use TableCrown\Utility\UFlashMessage;
use TableCrown\Entity\EProdotto;
use TableCrown\Entity\ERecensione;
use TableCrown\Entity\EMotivazione;
use TableCrown\Entity\ESegnalazione;

use TableCrown\Foundation\FPersistentManager;

/**
 * Controller deputato alla gestione del ciclo di vita 
 * delle Recensioni e delle Segnalazioni.
 */
class CRecensioni extends BaseController {

    public function __construct() {
        parent::__construct();
    }

    //==========================================================================
    // AZIONI OPERATIVE (POST)
    //==========================================================================

    /**
     * Crea e memorizza una nuova recensione per un prodotto.
     * URL: POST /recensioni/aggiungi
     */
    public function aggiungi(): void {
        $utente = $this->utenteCorrente();
        $isAjax = UHTTPMethods::isAjax();

        try {
            $idProdotto = UHTTPMethods::postInt('id_prodotto');
            $valutazione = UHTTPMethods::postInt('valutazione');
            $testo = UHTTPMethods::postString('testo');

            $prodotto = FPersistentManager::PMgetObjOnAttribute(EProdotto::class, 'idProdotto', $idProdotto);

            if ($prodotto == null) {
                throw new \InvalidArgumentException("Il prodotto selezionato non esiste.");
            }

            //Istanziamo la recensione
            $recensione = new ERecensione($valutazione, $testo, $utente, $prodotto);

            //Salviamo l'oggetto recensione
            $salvato = FPersistentManager::PMsaveObj($recensione);

            if (!$salvato) {
                throw new \RuntimeException("Si è verificato un errore durante il salvataggio della recensione.");
            }

            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'ok', 'message' => 'Recensione pubblicata con successo!']);
                exit();
            }

            UFlashMessage::addMessage('success', 'Recensione pubblicata con successo!');
            header('Location: ' . UHTTPMethods::getReferer($this->urlCatalogo($prodotto)));
            exit();

        } catch (\Exception $e) {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
                exit();
            }

            UFlashMessage::addMessage('danger', $e->getMessage());
            header('Location: ' . UHTTPMethods::getReferer('/'));
            exit();
        }
    }

    /**
     * Rimuove una recensione esistente.
     * URL: POST /recensioni/rimuovi
     */
    public function elimina(): void {
        $utente = $this->utenteCorrente();
        $isAjax = UHTTPMethods::isAjax();

        try {
            $idRecensione = UHTTPMethods::postInt('id_recensione');
            $recensione = FPersistentManager::PMgetObjOnAttribute(ERecensione::class, 'idRecensione', $idRecensione);

            if ($recensione === null) {
                throw new \InvalidArgumentException("La recensione selezionata non esiste.");
            }

            //Controllo di sicurezza: l'utente può eliminare solo la propria recensione
            if ($recensione->getUtente()->getIdPersona() !== $utente->getIdPersona()) {
                throw new \DomainException("Non sei autorizzato a eliminare questa recensione.");
            }

            $prodotto = $recensione->getProdotto();

            //Rimuoviamo il link lato memoria prima della cancellazione fisica dal DB
            $prodotto->removeRecensione($recensione);

            //Cancellazione fisica tramite il pm
            $eliminato = FPersistentManager::PMdeleteObj($recensione);

            if (!$eliminato) {
                throw new \RuntimeException("Si è verificato un errore durante la cancellazione della recensione.");
            }

            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'ok', 'message' => 'Recensione eliminata con successo!']);
                exit();
            }

            UFlashMessage::addMessage('success', 'Recensione eliminata con successo!');
            header('Location: ' . UHTTPMethods::getReferer($this->urlCatalogo($prodotto)));
            exit();

        } catch (\Exception $e) {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
                exit();
            }

            UFlashMessage::addMessage('danger', $e->getMessage());
            header('Location: ' . UHTTPMethods::getReferer('/'));
            exit();
        }
    }

    /**
     * Segnala una recensione.
     * URL: POST /recensioni/segnala
     */
    public function segnala(): void {
        $this->utenteCorrente(); //controllo di sicurezza
        $isAjax = UHTTPMethods::isAjax();

        try {
            $idRecensione = UHTTPMethods::postInt('id_recensione');
            $idMotivazione = UHTTPMethods::postInt('id_motivazione');

            $recensione = FPersistentManager::PMgetObjOnAttribute(ERecensione::class, 'idRecensione', $idRecensione);

            $motivazione = FPersistentManager::PMgetObjOnAttribute(EMotivazione::class, 'idmotivazione', $idMotivazione);

            if ($recensione === null) {
                throw new \InvalidArgumentException("La recensione da segnalare non esiste.");
            }

            if ($motivazione === null) {
                throw new \InvalidArgumentException("La motivazione selezionata non esiste.");
            }

            //Istanziamo la segnalazione
            $segnalazione = new ESegnalazione($motivazione, $recensione);//PROBLEMA: BISGONA AGGIUNGERE L'ATTRIBUTO UTENTE ALL'ENTITY SEGNALAZIONE PER POTER RISALIRE ALL'UTENTE CHE L'HA INVIATA (EVITA SPAMMING DI MALINTENZIONATI)

            $salvato = FPersistentManager::PMsaveObj($segnalazione);

            if (!$salvato) {
                throw new \RuntimeException("Si è verificato un errore durante il salvataggio della segnalazione.");
            }

            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'ok', 'message' => 'Segnalazione effettuata con successo!']);
                exit();
            }

            UFlashMessage::addMessage('success', 'Grazie per la segnalazione. Sarà presa in carico dallo staff.');
            header('Location: ' . UHTTPMethods::getReferer($this->urlCatalogo($recensione->getProdotto())));
            exit();

        } catch (\Exception $e) {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
                exit();
            }

            UFlashMessage::addMessage('danger', $e->getMessage());
            header('Location: ' . UHTTPMethods::getReferer('/'));
            exit();
        }
    }

    /**
     * Essendo questo un controller che gestisce solo azioni operative in POST,
     * non verrà mai chiamato direttamente questo metodo per fare il rendering
     * di un layout; ma lo inseriamo per non violare l'ereditarietà 
     */
    protected function getBreadcrumbs(string $currentPage = ''): array {
        return [
            ['label' => 'Home', 'url' => '/'],
        ];
    }
}