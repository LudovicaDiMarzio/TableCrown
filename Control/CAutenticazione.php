<?php
namespace TableCrown\Control;

use TableCrown\Utility\USession;
use TableCrown\Utility\UHTTPMethods;
use TableCrown\Utility\UFlashMessage;
use TableCrown\Entity\EUtente;
use TableCrown\Entity\EAmministratore;
use TableCrown\Entity\EGestore;
use TableCrown\Foundation\FPersistentManager;

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

        //TODO:
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

        //Verifichiamo le credenziali sul DB reale:
        //Chiediamo a Foundation di cercare la persona nel DB tramite la mail inserita
        $persona = FPersistentManager::PMgetObjOnAttribute(EUtente::class, 'emailpersona', $email);

        if(!$persona || !$persona->verificaPassword($password)) {
            UFlashMessage::addMessage('danger', 'Email o password errate. Riprova.');
            header('Location: /accedi');
            exit();
        }

        //Salviamo l'ID della persona in sessione
        USession::setSessionElement('id_persona', $persona->getIdPersona());

        //Controlliamo quale sottoclasse ha restituito Doctrine e mappiamo il ruolo testuale in sessione, così il BaseController può fare i controlli.
        if ($persona instanceof EAmministratore) {
            USession::setSessionElement('ruolo', 'amministratore');
            UFlashMessage::addMessage('success', 'Bentornato Amministratore!');
            header("Location: /admin/dashboard"); //reindirizza alla dashboard admin
        } elseif ($persona instanceof EGestore) {
            USession::setSessionElement('ruolo', 'gestore');
            UFlashMessage::addMessage('success', 'Bentornato Gestore!');
            header("Location: /gestore/dashboard"); //reindirizza alla dashboard gestore
        } elseif ($persona instanceof EUtente) {
            USession::setSessionElement('ruolo', 'utente');
            UFlashMessage::addMessage('success', 'Login effettuato con successo!');
            header("Location: /"); //reindirizza alla home
        } else {
            //Se le credenziali sono errate (mail non trovata o password sbagliata), impostiamo un messaggio di errore rapido
            UFlashMessage::addMessage('danger', 'Ruolo utente non riconosciuto. Riprova.');
            header('Location: /accedi');
        }

        exit();
    }

    /**
     * Gestisce la registrazione di un nuovo utente normale (Richiesta POST)
     * URL: /registrazione
     */
    public function registrazione(): void {
        //Recuperiamo i campi della registrazione
        $nome = UHTTPMethods::post('nome');
        $email = UHTTPMethods::post('email');
        $password = UHTTPMethods::post('password');
        $eta = UHTTPMethods::post('eta'); //OBBLIGATORIA?????????

        //Controllo di validità dei campi obbligatori
        if (!$nome || !$email || !$password) {
            //Se manca uno dei tre, impostiamo un messaggio di errore rapido
            UFlashMessage::addMessage('danger', 'Tutti i campi sono obbligatori.');
            //Pattern PRG: ricarichiamo la pagina del form per mostrare l'errore in sicurezza
            header('Location: /accedi');
            exit();
        }

        //Verifichiamo che l'email non sia già registrata nel DB per evitare duplicati
        $esiste = FPersistentManager::PMverificaEsistenza(EUtente::class, 'emailpersona', $email);

        if ($esiste) {
            UFlashMessage::addMessage('danger', 'Questa email è già registrata.');
            header('Location: /accedi');
            exit();
        }

        $passwordCriptata = password_hash($password, PASSWORD_BCRYPT);

        $nuovoUtente = new EUtente($nome, $email, $passwordCriptata, $eta); //MANCA IL PLAYERLEVEL (DA SISTEMAE NELL'ENTITY)

        $salvato = FPersistentManager::PMsaveObj($nuovoUtente);

        if ($salvato) {
            UFlashMessage::addMessage('success', 'Registrazione completata! Effettua il login.');
            header("Location: /accedi");
            exit();
        } else {
            UFlashMessage::addMessage('danger', 'Si è verificato un errore durante la registrazione. Riprova.');
            header("Location: /accedi");
        }

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

    /**
     * Sovrascrive il metodo del BaseController per definire il percorso del Login.
     */
    protected function getBreadcrumbs(): array {
        return [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Login', 'url' => '/accedi']
        ];
    }
}