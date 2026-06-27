<?php
namespace TableCrown\Control;

use TableCrown\Utility\USession;
use TableCrown\Utility\UHTTPMethods;
use TableCrown\Utility\UFlashMessage;
use TableCrown\Entity\EUtente;
use TableCrown\Entity\EAmministratore;
use TableCrown\Entity\EGestore;

/**
 * Controller deputato alla gestione del ciclo di vita dell'autenticazione.
 * Gestisce la registrazione, il login, il logout e la profilazione in sessione delle persone.
 */
class CAutenticazione extends BaseController {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Mostra la pagina con il form di login / registrazione (Richesta GET).
     * URL: /accedi
     */
    public function mostraForm(): void {
        //Se l'utente è già loggato, lo reindirizziamo alla home.
        if ($this->isLoggedIn()) {
            header('Location: /');
            exit();
        }

        //Prepariamo i dati del layout (in questo caso non servono dati specifici dal DB).
        $data = $this->preparaDatiLayout('autenticazione');

        //VAutenticazione::mostraForm($data);
        echo "Ecco il form di Login e Registrazione!"; //TEST PROVVISORIO (DA CANCELLARE)
    }

    /**
     * Gestisce l'invio dei dati del form di Login (Richiesta POST).
     * URL: /login
     */
    public function login(): void {
        //Recuperiamo i dati inseriti dall'utente nel form tramite l'utility HTTP
        $email = UHTTPMethods::post('email');
        $password = UHTTPMethods::post('password');

        //Controllo di validità dei campi obbligatori
        if (!$email || !$password) {
            //Se manca uno dei due, impostiamo un messaggio di errore rapido
            UFlashMessage::addMessage('danger', 'Tutti i campi sono obbligatori.');
            //Pattern PRG: ricarichiamo la pagina del form per mostrare l'errore in sicurezza
            header('Location: /accedi');
            exit();
        }

        //QUANDO SARà PRONTO FOUNDATION
        //Verifichiamo le credenziali sul DB reale:
        //Chiediamo a Foundation di cercare la persona nel DB tramite la mail inserita
        /* $persona = FPersistentManager::visualizza(EUtente::class, 'email', $email);

        //Se la mail esiste nel DB AND la password inserita corrisponde a quella criptata nel DB...
        if ($persona && password_verify($password, $persona->getPassword())) {
            //...salviamo l'ID universale della persona nella sessione, usando la chiave 'id_persona'
            USession::setSessionElement('id_persona', $persona->getIdPersona());

            //Controlliamo quale sottoclasse ha restituito Doctrine e mappiamo il ruolo testuale in sessione, così il BAseController può fare i controlli.
            if ($persona instanceof EAmministratore) {
                USession::setSessionElement('ruolo', 'amministratore');
                UFlashMessage::addMessage('success', 'Bentornato Amministratore!');
                header("Location: /admin/dashboard"); //reindirizza alla dashboard admin
                exit();
            } else if ($persona instanceof EGestore) {
                USession::setSessionElement('ruolo', 'gestore');
                UFlashMessage::addMessage('success', 'Bentornato Gestore!');
                header("Location: /gestore/dashboard"); //reindirizza alla dashboard gestore
                exit();
            } else if ($persona instanceof EUtente) {
                USession::setSessionElement('ruolo', 'utente');
                UFlashMessage::addMessage('success', 'Login effettuato con successo!');
                header("Location: /"); //reindirizza alla home
                exit();
            }
        } else {
            //Se le credenziali sono errate (mail non trovata o password sbagliata), impostiamo un messaggio di errore rapido
            UFlashMessage::addMessage('danger', 'Email o password errate. Riprova.');
            header('Location: /accedi');
            exit();
        }
     */

        //SIMULAZIONE TEMPORANEA PER I TEST IN LOCALE (DA ELIMINARE QUANDO FOUNDATION È PRONTO)
        if ($email === 'admin@test.it') {
            USession::setSessionElement('id_persona', 99);
            USession::setSessionElement('ruolo', 'amministratore');
            UFlashMessage::addMessage('success', 'Simulazione: Accesso Admin eseguito!');
        } else {
            USession::setSessionElement('id_persona', 1);
            USession::setSessionElement('ruolo', 'utente');
            UFlashMessage::addMessage('success', 'Simulazione: Accesso Utente eseguito!');
        }
        header("Location: /");
        exit();
    }

    /**
     * Gestisce la registrazione di un nuovo utente normale (Richiesta POST)
     * URL: /registrazione
     */
    public function registrazione(): void {
        //Recuperiamo i campi tipici di una registrazione
        $nome = UHTTPMethods::post('nome');
        $email = UHTTPMethods::post('email');
        $password = UHTTPMethods::post('password');

        //Controllo di validità dei campi obbligatori
        if (!$nome || !$email || !$password) {
            //Se manca uno dei tre, impostiamo un messaggio di errore rapido
            UFlashMessage::addMessage('danger', 'Tutti i campi sono obbligatori.');
            //Pattern PRG: ricarichiamo la pagina del form per mostrare l'errore in sicurezza
            header('Location: /accedi');
            exit();
        }

        //QUANDO SARÀ PRONTO FOUNDATION
        /**
         * Verifichiamo se l'email è già registrata nel DB per evitare duplicati
         * $esiste = FPersistentManager::verificaEsistenza(EUtente::class, 'email', $email);
         * 
         * if ($esiste) {
         *     //Se esiste, impostiamo un messaggio di errore rapido
         *     UFlashMessage::addMessage('danger', 'Questa email è già registrata.');
         *     //Pattern PRG: ricarichiamo la pagina del form per mostrare l'errore in sicurezza
         *     header('Location: /accedi');
         *     exit();
         * }
         */
        
        /**
         * //Criptiamo la password prima di passarla all'Entity
         * $passwordCriptata = password_hash($password, PASSWORD_BCRYPT);
         * 
         * //Creiamo l'istanza dell'Entity EUtente (passando i parametri richiesti dal suo costruttore)
         * $nuovoUtente = new EUtente($nome, $email, $passwordCriptata);
         * 
         * //Salviamo l'Entity nel DB tramite Foundation
         * $salvato = FPersistentManager::inserisci($nuovoUtente);
         * 
         * if ($salvato) {
         *     UFlashMessage::addMessage('success', 'Registrazione completata!');
         * } else {
         *     UFlashMessage::addMessage('danger', 'Si è verificato un errore durante la registrazione. Riprova.');
         * }
         * header("Location: /"); //L'UTENTE DOVREBBE FARE IL LOGIN DOPO LA REGISTRAZIONE? NEL CASO DOVREBBE ESSERE header('Location: /accedi')
         * exit();
         */

        //SIMULAZIONE TEMPORANEA PER I TEST IN LOCALE (DA ELIMINARE QUANDO FOUNDATION È PRONTO)
        UFlashMessage::addMessage('success', 'Simulazione: Registrazione completata con successo!');
        header("Location: /");
        exit();
    }

    /**
     * Gestisce il logout dell'utente (Richiesta GET o POST).
     * URL: /logout
     */
    public function logout(): void {
        //Distruggiamo la sessione corrente, svuotando i token di autenticazione
        USession::destroySession();

        //Messaggio di conferma di avvenuto logout
        UFlashMessage::addMessage('success', 'Disconnessione effettuata. A presto!');

        //Reindirizziamo l'utente alla home
        header('Location: /');
        exit();
    }
}