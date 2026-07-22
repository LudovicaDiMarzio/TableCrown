<?php
namespace TableCrown\Control;

use TableCrown\Utility\UHTTPMethods;
use TableCrown\Utility\UFlashMessage;
use TableCrown\Entity\EProdotto;
use TableCrown\Entity\ERecensione;
use TableCrown\Entity\EMotivazione;
use TableCrown\Entity\ESegnalazione;
use TableCrown\Entity\Enumerativi\StatoSegnalazione;

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

            //Regole di business: l'utente può recensire un prodotto solo se l'ha già acquistato
            $haAcquistato = FPersistentManager::PMutenteHasProdotto($utente->getIdPersona(), $idProdotto);

            if (!$haAcquistato) {
                throw new \InvalidArgumentException("Puoi recensire solo i prodotti che hai acquistato.");
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
        $referer = UHTTPMethods::getReferer(BASE_URL . '/admin/recensioni');

        try {
            $idRecensione = UHTTPMethods::postInt('id_recensione');

            //Recuperiamo la recensione per eliminarla
            $recensione = FPersistentManager::PMgetObjOnAttribute(ERecensione::class, 'idRecensione', $idRecensione);

            if (!$recensione) {
                throw new \InvalidArgumentException("La recensione non esiste o è già stata rimossa.");
            }

            //Risolviamo logicamente tutte le segnalazioni collegate a questa recensione prima di eliminarla
            foreach ($recensione->getSegnalazioni() as $segnalazione) {
                if ($segnalazione->getStatoSegnalazione() !== StatoSegnalazione::RISOLTA) {
                    $segnalazione->risolvi();
                    FPersistentManager::PMsaveObj($segnalazione);
                }
            }

            //Aggiornamento della media recensioni del prodotto associato
            $prodotto = $recensione->getProdotto();
            if ($prodotto) {
                $prodotto->removeRecensione($recensione);
                FPersistentManager::PMsaveObj($prodotto);
            }

            //Eliminiamo fisicamente la recensione dal DB
            $successo = FPersistentManager::PMdeleteObj($recensione); 

            if (!$successo) {
                throw new \RuntimeException("Si è verificato un errore durante la rimozione della recensione.");
            }

            //Esito positivo
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'ok',
                    'message' => 'La recensione è stata rimossa dal sito.'
                ]);
                exit();
            }
            UFlashMessage::addMessage('success', 'La recensione è stata rimossa dal sito.');
            header('Location: ' . $referer);
            exit();

        } catch (\Exception $e) {
            //Esito negativo
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
                exit();
            }

            UFlashMessage::addMessage('danger', $e->getMessage());
            header('Location: ' . $referer);
            exit();
        }
    }

    /**
     * Rigetta una segnalazione ritenuta infondata, senza eliminare la recensione.
     * URL: POST /admin/recensioni/rigetta
     */
    public function rigettaSegnalazioneAdmin(): void {
        $this->requireRole('amministratore');
        $isAjax = UHTTPMethods::isAjax();
        $referer = UHTTPMethods::getReferer(BASE_URL . '/admin/recensioni');

        try {
            $idSegnalazione = UHTTPMethods::postInt('id_segnalazione');
        } catch (\InvalidArgumentException $e) {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
                exit();
            }
            UFlashMessage::addMessage('danger', 'Parametri non validi: ' . $e->getMessage());
            header('Location: ' . $referer);
            exit();
        }

        $segnalazione = FPersistentManager::PMgetObjOnAttribute(ESegnalazione::class, 'idsegnalazione', $idSegnalazione);

        //Verifichiamo che esista una segnalazione
        if (!$segnalazione) {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'La segnalazione non esiste o è già stata gestita.']);
                exit();
            }
            UFlashMessage::addMessage('danger', 'La segnalazione non esiste o è già stata gestita.');
            header('Location: ' . $referer);
            exit();
        }

        //Verifichiamo se è già stata risolta/gestita!
        if ($segnalazione->getStatoSegnalazione() === StatoSegnalazione::RISOLTA) {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Questa segnalazione è già stata risolta/gestita.']);
                exit();
            }
            UFlashMessage::addMessage('warning', 'Questa segnalazione è già stata risolta/gestita.');
            header('Location: ' . $referer);
            exit();
        }

        try {
            $segnalazione->risolvi();
            FPersistentManager::PMsaveObj($segnalazione);

            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'ok', 'message' => 'La segnalazione è stata rigettata; la recensione resta pubblicata.']);
                exit();
            }

            UFlashMessage::addMessage('success', 'La segnalazione è stata rigettata; la recensione resta pubblicata.');
        } catch (\DomainException | \InvalidArgumentException $e) {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Impossibile rigettare la segnalazione: ' . $e->getMessage()]);
                exit();
            }
            UFlashMessage::addMessage('danger', 'Impossibile rigettare la segnalazione: ' . $e->getMessage());
        }

        header('Location: ' . $referer);
        exit();
    }

}