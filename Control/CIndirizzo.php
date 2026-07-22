<?php
namespace TableCrown\Control;

use TableCrown\Utility\UHTTPMethods;
use TableCrown\Utility\UFlashMessage;
use TableCrown\Entity\EIndirizzo;
use TableCrown\Foundation\FPersistentManager;

/**
 * Controller deputato alla gestione degli indirizzi di spedizione dell'utente.
 */
class CIndirizzo extends BaseController {

    public function __construct() {
        parent::__construct();

        //Se è un gestore o un admin, lo spinge subito sulla sua dashboard
        $this->reindirizzaAdminGestore();
    }

    //==========================================================================
    // HELPER DI SUPPORTO INTERNO
    //==========================================================================

    /**
     * Rimuovo lo stato "predefinito" da tutti gli indirizzi di un determinato utente.
     * Utile quando se ne imposta uno nuovo come predefinito.
     */
    private function azzeraPredefinito(array $indirizzi): void {
        foreach ($indirizzi as $indirizzo) {
            if ($indirizzo->isPredefinito()) {
                $indirizzo->rimuoviPredefinito();
                FPersistentManager::PMsaveObj($indirizzo);
            }
        }
    }

    //==========================================================================
    // AZIONI OPERATIVE (POST)
    //==========================================================================

    /**
     * Aggiunge un nuovo indirizzo al profilo utente.
     * URL: POST profilo/indirizzi/aggiungi
     */
    public function aggiungiIndirizzo(): void {
        $utente = $this->utenteCorrente();
        $isAjax = UHTTPMethods::isAjax();

        try {
            $nome = UHTTPMethods::postString('nome');
            $via = UHTTPMethods::postString('via');
            $citta = UHTTPMethods::postString('citta');
            $cap = UHTTPMethods::postString('cap');
            $provincia = UHTTPMethods::postString('provincia');
            $nazione = UHTTPMethods::postString('nazione');
            $nomeCitofono = UHTTPMethods::postString('nomeCitofono');
            $voglioPredefinito = UHTTPMethods::postBool('predefinito');

            //Recuperiamo gli indirizzi esistenti per capire se è il primo
            $indirizziEsistenti = FPersistentManager::PMgetObjListOnAttribute(EIndirizzo::class, 'utente', $utente);
            $haGiaIndirizzi = !empty($indirizziEsistenti);

            //Se è il primo indirizzo in assoluto, deve essere predefinito a prescindere
            $predefinito = !$haGiaIndirizzi || $voglioPredefinito;

            //Se il nuovo indirizzo deve essere predefinito, azzeriamo i vecchi prima di salvare
            if ($predefinito) {
                $this->azzeraPredefinito($indirizziEsistenti);
            }

            $nuovoIndirizzo = new EIndirizzo($nome, $via, $citta, $cap, $provincia, $nazione, $nomeCitofono, $utente, $predefinito);

            $salvato = FPersistentManager::PMsaveObj($nuovoIndirizzo);

            if (!$salvato) {
                throw new \RuntimeException("Si è verificato un errore durante l'aggiunta dell'indirizzo.");
            }

            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'ok', 'message' => 'Indirizzo salvato con successo!']);
                exit();
            }

            UFlashMessage::addMessage('success', 'Nuovo indirizzo salvato!');
            header('Location: ' . BASE_URL . '/profilo/indirizzi');
            exit();

        } catch (\Exception $e) {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
                exit();
            }

            UFlashMessage::addMessage('danger', $e->getMessage());
            header('Location: ' . UHTTPMethods::getReferer(BASE_URL . '/profilo/indirizzi'));
            exit();
        }
    }

    /**
     * Imposta un indirizzo esistente come predefinito.
     * URL: POST profilo/indirizzi/predefinito
     */
    public function impostaPredefinito(): void {
        $utente = $this->utenteCorrente();
        $isAjax = UHTTPMethods::isAjax();

        try {
            $idIndirizzo = UHTTPMethods::postInt('id_indirizzo');
            $indirizzo = FPersistentManager::PMgetObjOnAttribute(EIndirizzo::class, 'idIndirizzo', $idIndirizzo);

            if ($indirizzo === null) {
                throw new \InvalidArgumentException("L'indirizzo selezionato non esiste.");
            }

            //Controllo di sicurezza: l'indirizzo deve appartenere all'utente loggato
            if ($indirizzo->getUtente()->getIdPersona() !== $utente->getIdPersona()) {
                throw new \DomainException("Non sei autorizzato a modificare questo indirizzo.");
            }

            //Recuperiamo tutti gli indirizzi associati all'utente
            $indirizziUtente = FPersistentManager::PMgetObjListOnAttribute(EIndirizzo::class, 'utente', $utente);

            //Azzeriamo i predefiniti correnti
            $this->azzeraPredefinito($indirizziUtente);

            //Impostiamo questo come predefinito
            $indirizzo->impostaPredefinito();
            $salvato = FPersistentManager::PMsaveObj($indirizzo);

            if (!$salvato) {
                throw new \RuntimeException("Si è verificato un errore durante l'impostazione dell'indirizzo come predefinito.");
            }

            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'ok', 'message' => 'Indirizzo impostato come predefinito!']);
                exit();
            }

            UFlashMessage::addMessage('success', 'Indirizzo predefinito aggiornato con successo!');
            header('Location: ' . BASE_URL . '/profilo/indirizzi');
            exit();

        } catch (\Exception $e) {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
                exit();
            }

            UFlashMessage::addMessage('danger', $e->getMessage());
            header('Location: ' . BASE_URL . '/profilo/indirizzi');
            exit();
        }
            
    }

    /**
     * Elimina un indirizzo.
     * URL: POST profilo/indirizzi/elimina
     */
    public function eliminaIndirizzo(): void {
        $utente = $this->utenteCorrente();
        $isAjax = UHTTPMethods::isAjax();

        try {
            $idIndirizzo = UHTTPMethods::postInt('id_indirizzo');
            $indirizzoDaEliminare = FPersistentManager::PMgetObjOnAttribute(EIndirizzo::class, 'idIndirizzo', $idIndirizzo);

            if ($indirizzoDaEliminare === null) {
                throw new \InvalidArgumentException("L'indirizzo selezionato non esiste.");
            }

            //Controllo di sicurezza: l'indirizzo deve appartenere all'utente loggato
            if ($indirizzoDaEliminare->getUtente()->getIdPersona() !== $utente->getIdPersona()) {
                throw new \DomainException("Non sei autorizzato a eliminare questo indirizzo.");
            }

            $eraPredefinito = $indirizzoDaEliminare->isPredefinito();

            //Rimuoviamo l'indirizzo fisicamente
            $eliminato = FPersistentManager::PMdeleteObj($indirizzoDaEliminare);

            if (!$eliminato) {
                throw new \RuntimeException("Si è verificato un errore durante l'eliminazione dell'indirizzo.");
            }

            //Se abbiamo eliminato l'indirizzo predefinito, dobbiamo promuoverne un altro tra quelli rimasti
            if ($eraPredefinito) {
                $indirizziRimasti = FPersistentManager::PMgetObjListOnAttribute(EIndirizzo::class, 'utente', $utente);

                if (!empty($indirizziRimasti)) {
                    $nuovoPredefinito = $indirizziRimasti[0]; //Promuoviamo il primo della lista a predefinito
                    $nuovoPredefinito->impostaPredefinito();
                    FPersistentManager::PMsaveObj($nuovoPredefinito);
                }
            }

            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'ok', 'message' => 'Indirizzo eliminato con successo!']);
                exit();
            }

            UFlashMessage::addMessage('success', 'Indirizzo eliminato con successo!');
            header('Location: ' . BASE_URL . '/profilo/indirizzi');
            exit();

        } catch (\Exception $e) {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
                exit();
            }

            UFlashMessage::addMessage('danger', $e->getMessage());
            header('Location: ' . BASE_URL . '/profilo/indirizzi');
            exit();
        }
    }

        


}