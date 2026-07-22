<?php
namespace TableCrown\Control;

use TableCrown\Utility\UHTTPMethods;
use TableCrown\Utility\UFlashMessage;
use TableCrown\Entity\ECartaDiCredito;
use TableCrown\Foundation\BancaMockService;
use TableCrown\Foundation\FPersistentManager;
use Exception;
use InvalidArgumentException;

/**
 * Controller deputato alla gestione delle operazioni CRUD sui metodi di pagamento dell'utente.
 * Per ora gestiamo solo le carte di credito, ma ci riferiamo a metodi di pagamento generici
 * per scalabilità.
 */
class CMetodiPagamento extends BaseController {

    public function __construct() {
        parent::__construct();

        //Se è un gestore o un admin, lo spinge subito sulla sua dashboard
        $this->reindirizzaAdminGestore();
    }

    /**
     * Gestisce il salvataggio di una nuova carta di credito nel DB.
     * URL: POST profilo/pagamenti/aggiungi
     */
    public function aggiungiCarta(): void {
        $utente = $this->utenteCorrente();

        if (!$utente) {
            UFlashMessage::addMessage('danger', 'L\'utente non è loggato.');
            header('Location: ' . BASE_URL . '/profilo/pagamenti');
            exit();
        }

        //Recuperiamo i dati inviati da form tramite POST
        $numeroCarta = UHTTPMethods::postString('numero_carta');
        $cvv = UHTTPMethods::postString('cvv');
        $titolare = UHTTPMethods::postString('titolare_carta');
        $scadenza = UHTTPMethods::postString('scadenza_carta');

        //Validazione base dei dati inviati
        if (empty($numeroCarta) || empty($cvv) || empty($titolare) || empty($scadenza)) {
            UFlashMessage::addMessage('danger', 'Tutti i campi sono obbligatori.');
            header('Location: ' . BASE_URL . '/profilo/pagamenti');
            exit();
        }

        try {
            //Contattiamo la banca mock per simulare la validazione reale e generare il token
            $bancaService = new BancaMockService();
            $datiToken = $bancaService->generaToken($numeroCarta, $cvv);
            $token = $datiToken['token'];

            //Estraiamo le ultime 4 cifre dal numero di carta inserito dall'utente
            $ultimeQuattroCifre = substr(trim($numeroCarta), -4);

            //Istanziamo l'entità ECartaDiCredito
            $nuovaCarta = new ECartaDiCredito($utente, $titolare, $scadenza, $ultimeQuattroCifre, $token);
            
            //Salvataggio della carta nel DB
            $salvato = FPersistentManager::PMsaveObj($nuovaCarta);

            if ($salvato) {
                UFlashMessage::addMessage('success', 'Metodo di pagamento salvato con successo!');
            } else {
                throw new Exception("Si è verificato un errore durante il salvataggio della carta di credito.");
            }
        } catch (InvalidArgumentException $e) {
            //Cattura i controlli di validità dell'entità ECartaDiCredito
            UFlashMessage::addMessage('danger', $e->getMessage());
        } catch (Exception $e) {
            //Cattura errori generici o di connessione con il servizio di pagamento
            UFlashMessage::addMessage('danger', $e->getMessage());
        }

        //Pattern PRG: reindirizziamo alla sezione visualizzazione nel profilo dell'utente
        header('Location: ' . BASE_URL . '/profilo/pagamenti');
        exit();
    }

    /**
     * Gestisce la rimozione sicura di una carta di credito salvata.
     * URL: POST profilo/pagamenti/elimina
     */
    public function eliminaCarta(): void {
        $utente = $this->utenteCorrente();

        $idCarta = UHTTPMethods::postInt('id_carta');

        if (!$idCarta) {
            UFlashMessage::addMessage('danger', 'Metodo di pagamento non valido o non specificato..');
            header('Location: ' . BASE_URL . '/profilo/pagamenti');
            exit();
        }

        try {
            //Recuperiamo l'entità ECartaDiCredito dal DB
            $cartaDaEliminare = FPersistentManager::PMgetObjOnAttribute(ECartaDiCredito::class, 'idCartaDiCredito', $idCarta);

            //Controlliamo se la carta esiste
            if (!$cartaDaEliminare) {
                UFlashMessage::addMessage('danger', 'La carta di credito selezionata non esiste.');
                header('Location: ' . BASE_URL . '/profilo/pagamenti');
                exit();
            }

            //Controllo di sicurezza: l'utente può eliminare solo una carta di sua proprietà
            if ($cartaDaEliminare->getUtente()->getIdPersona() !== $utente->getIdPersona()) {
                UFlashMessage::addMessage('danger', 'Non sei autorizzato ad eliminare questa carta di credito.');
                header('Location: ' . BASE_URL . '/profilo/pagamenti');
                exit();
            }

            //Se tutti i controlli passano, eliminiamo la carta in sicurezza
            $eliminata = FPersistentManager::PMdeleteObj($cartaDaEliminare);

            if ($eliminata) {
                UFlashMessage::addMessage('success', 'Metodo di pagamento eliminato con successo!');
            } else {
                throw new Exception("Si è verificato un errore durante la rimozione della carta di credito.");
            }
        } catch (Exception $e) {
            //Cattura errori generici o di connessione con il servizio di pagamento
            UFlashMessage::addMessage('danger', 'Impossibile completare l\'operazione: ' . $e->getMessage());
        }

        header('Location: ' . BASE_URL . '/profilo/pagamenti');
        exit();
    }
}