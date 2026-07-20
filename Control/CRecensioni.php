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

    //==========================================================================
    // UTENTI
    //==========================================================================

    /**
     * Crea e memorizza una nuova recensione per un prodotto.
     * URL: POST /recensioni/aggiungi
     */
    public function aggiungiRecensione(): void {
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
            header('Location: ' . UHTTPMethods::getReferer(BASE_URL . $this->urlCatalogo($prodotto)));
            exit();

        } catch (\Exception $e) {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
                exit();
            }

            UFlashMessage::addMessage('danger', $e->getMessage());
            header('Location: ' . UHTTPMethods::getReferer(BASE_URL . '/'));
            exit();
        }
    }

    /**
     * Rimuove una recensione esistente.
     * URL: POST /recensioni/elimina
     */
    public function eliminaRecensione(): void {
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
            header('Location: ' . UHTTPMethods::getReferer(BASE_URL . $this->urlCatalogo($prodotto)));
            exit();

        } catch (\Exception $e) {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
                exit();
            }

            UFlashMessage::addMessage('danger', $e->getMessage());
            header('Location: ' . UHTTPMethods::getReferer(BASE_URL . '/'));
            exit();
        }
    }

    /**
     * Segnala una recensione.
     * URL: POST /recensioni/segnala
     */
    public function segnalaRecensione(): void {
        $utenteSegnalante = $this->utenteCorrente(); //controllo di sicurezza
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
            $segnalazione = new ESegnalazione($motivazione, $recensione, $utenteSegnalante);

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
            header('Location: ' . UHTTPMethods::getReferer(BASE_URL . $this->urlCatalogo($recensione->getProdotto())));
            exit();

        } catch (\Exception $e) {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
                exit();
            }

            UFlashMessage::addMessage('danger', $e->getMessage());
            header('Location: ' . UHTTPMethods::getReferer(BASE_URL . '/'));
            exit();
        }
    }

    //==========================================================================
    // ADMIN
    //==========================================================================

    /**
     * Elimina una recensione. (Accesso Riservato Amministratore)
     * URL: POST admin/recensioni/elimina 
     */
    public function eliminaRecensioneAdmin(): void {
        //Verifichiamo che sia l'admin a fare l'azione
        $this->requireRole('amministratore');
        $isAjax = UHTTPMethods::isAjax();

        try {
            $idRecensione = UHTTPMethods::postInt('id_recensione');
        } catch (\InvalidArgumentException $e) {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
                exit();
            }
            UFlashMessage::addMessage('danger', 'Parametri non validi: ' . $e->getMessage());
            header('Location: ' . BASE_URL . '/admin/dashboard');
            exit();
        }

        //Recuperiamo la recensione per eliminarla
        $recensione = FPersistentManager::PMgetObjOnAttribute(ERecensione::class, 'idRecensione', $idRecensione);

        if (!$recensione) {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'La recensione non esiste o è già stata rimossa.']);
                exit();
            }
            UFlashMessage::addMessage('danger', 'La recensione non esiste o è già stata rimossa.');
            header('Location: ' . BASE_URL . '/admin/dashboard');
            exit();
        }

        //Risolviamo logicamente tutte le segnalazioni collegate a questa recensione prima di eliminarla
        foreach ($recensione->getSegnalazioni() as $segnalazione) {
            $segnalazione->risolvi();
            FPersistentManager::PMsaveObj($segnalazione);
        }

        //Eliminiamo fisicamente la recensione dal DB
        $successo = FPersistentManager::PMdeleteObj($recensione); 

        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode([
                'status' => $successo ? 'ok' : 'error',
                'message' => $successo ? 'La recensione è stata rimossa dal sito.' : 'Si è verificato un errore durante la rimozione della recensione.'
            ]);
            exit();
        }

        if ($successo) {
            UFlashMessage::addMessage('success', 'La recensione è stata rimossa dal sito.');
        } else {
            UFlashMessage::addMessage('danger', 'Si è verificato un errore durante la rimozione della recensione.');
        }

        header('Location: ' . BASE_URL . '/admin/dashboard');
        exit();
    }

    /**
     * Rigetta una segnalazione ritenuta infondata, senza eliminare la recensione.
     * URL: POST /admin/recensioni/rigetta
     */
    public function rigettaSegnalazioneAdmin(): void {
        $this->requireRole('amministratore');

        try {
            $idSegnalazione = UHTTPMethods::postInt('id_segnalazione');
        } catch (\InvalidArgumentException $e) {
            UFlashMessage::addMessage('danger', 'Parametri non validi: ' . $e->getMessage());
            header('Location: ' . BASE_URL . '/admin/dashboard');
            exit();
        }

        $segnalazione = FPersistentManager::PMgetObjOnAttribute(ESegnalazione::class, 'idSegnalazione', $idSegnalazione);

        if (!$segnalazione) {
            UFlashMessage::addMessage('danger', 'La segnalazione non esiste o è già stata gestita.');
            header('Location: ' . BASE_URL . '/admin/dashboard');
            exit();
        }

        try {
            $segnalazione->risolvi();
            FPersistentManager::PMsaveObj($segnalazione);
            UFlashMessage::addMessage('success', 'La segnalazione è stata rigettata; la recensione resta pubblicata.');
        } catch (\DomainException | \InvalidArgumentException $e) {
            UFlashMessage::addMessage('danger', 'Impossibile rigettare la segnalazione: ' . $e->getMessage());
        }

        header('Location: ' . BASE_URL . '/admin/recensioni');
        exit();
    }

}