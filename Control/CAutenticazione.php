<?php
namespace TableCrown\Control;

use TableCrown\Utility\USession;
use TableCrown\Utility\UHTTPMethods;
use TableCrown\Utility\UFlashMessage;
use TableCrown\Utility\UCookie;
use TableCrown\Entity\EUtente;
use TableCrown\Entity\EAmministratore;
use TableCrown\Entity\EGestore;
use TableCrown\Foundation\FPersistentManager;
use TableCrown\Presentation\Views\ViewAutenticazione;
use InvalidArgumentException;

/**
 * Controller deputato alla gestione del ciclo di vita dell'autenticazione.
 * Gestisce la registrazione, il login, il logout e la profilazione in sessione delle persone.
 */
class CAutenticazione extends BaseController {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Mostra il form di login (Richesta GET).
     * URL: GET /accedi
     */
    public function mostraFormLogin(): void {
        //Se l'utente è già loggato, lo reindirizziamo alla home.
        if ($this->isLoggedIn()) {
            header('Location: ' . BASE_URL . '/');
            exit();
        }

        //Recupero del parametro redirect_to per mantenere la destinazione originale
        $redirectTo = UHTTPMethods::get('redirect_to');

        //Recupero dei valori vecchi salvati in sessione dopo un errore (Pattern PRG)
        $emailValue = USession::getSessionElement('old_email');
        $ricordami = USession::getSessionElement('old_ricordami');

        //Consumiamo i dati della sessione subito dopo la lettura per non lasciarli appesi al refresh successivo
        USession::unsetSessionElement('old_email');
        USession::unsetSessionElement('old_ricordami');

        //Prepariamo i dati del layout (in questo caso non servono dati specifici dal DB).
        $datiLayout = $this->preparaDatiLayout('accedi', [
            'redirect_to' => $redirectTo,
            'email_value' => $emailValue,
            'ricordami' => (bool)$ricordami,
        ]);

        //Chiamata alla View
        ViewAutenticazione::mostraFormLogin($datiLayout);
    }

    /**
     * Mostra il form di registrazione (Richesta GET).
     * URL: GET /registrati
     */
    public function mostraFormRegistrazione(): void {
        //Se l'utente è già loggato, lo reindirizziamo alla home.
        if ($this->isLoggedIn()) {
            header('Location: ' . BASE_URL . '/');
            exit();
        }

        //Prepariamo i dati del layout (in questo caso non servono dati specifici dal DB).
        $datiLayout = $this->preparaDatiLayout('registrati');

        //Chiamata alla View
        ViewAutenticazione::mostraFormRegistrazione($datiLayout);
    }

    /**
     * Gestisce l'invio dei dati del form di Login (Richiesta POST).
     * URL: POST /login
     */
    public function login(): void { 
        try {
            //Recuperiamo i dati inseriti dall'utente nel form tramite l'utility HTTP
            $email = UHTTPMethods::postString('email');
            $password = UHTTPMethods::postString('password');
            $redirectTo = UHTTPMethods::post('redirect_to'); //legge il campo hidden del form
            $ricordamiBox = UHTTPMethods::post('ricordami'); //può essere null se non spuntato
        } catch (\InvalidArgumentException $e) {
            UFlashMessage::addMessage('danger', $e->getMessage());
            header('Location: ' . BASE_URL . '/accedi');
            exit();
        }
       
        //Controllo di validità dei campi obbligatori
        if (!$email || !$password) {
            //Se manca uno dei due, impostiamo un messaggio di errore rapido
            UFlashMessage::addMessage('danger', 'Tutti i campi sono obbligatori.');

            //UX: Salviamo l'email in sessione per ripopolare il form nel form successivo
            USession::setSessionElement('old_email', $email);
            USession::setSessionElement('old_ricordami', $ricordamiBox !== null);

            //Costruiamo la query string per non perdere il redirect_to originale durante il PRG
            $urlRedirect = BASE_URL . '/accedi' . ($redirectTo ? '?redirect_to=' . urlencode($redirectTo) : '');
            header('Location: ' . $urlRedirect);
            exit();
        }

        //Verifichiamo le credenziali sul DB reale:
        //EPersona è una MappedSuperclass (non esiste una tabella comune da interrogare).
        //Dobbiamo provare le tre tabelle in sequenza, finché una non risponde.
        $persona = FPersistentManager::PMgetObjOnAttribute(EUtente::class, 'emailpersona', $email)
            ?? FPersistentManager::PMgetObjOnAttribute(EAmministratore::class, 'emailpersona', $email)
            ?? FPersistentManager::PMgetObjOnAttribute(EGestore::class, 'emailpersona', $email);

        if(!$persona || !$persona->verificaPassword($password)) {
            UFlashMessage::addMessage('danger', 'Email o password errate. Riprova.');

            //UX: Salviamo i vecchi calori prima del redirect PRG
            USession::setSessionElement('old_email', $email);
            USession::setSessionElement('old_ricordami', $ricordamiBox !== null);

            $urlRedirect = BASE_URL . '/accedi' . ($redirectTo ? '?redirect_to=' . urlencode($redirectTo) : '');
            header('Location: ' . $urlRedirect);
            exit();
        }

        //Salviamo l'ID della persona in sessione
        USession::setSessionElement('id_persona', $persona->getIdPersona());
        USession::setSessionElement('nickname', $persona->getNomePersona());

        //Gestione "Ricordami" (REMEMBER ME) tramite cookie
        if ($ricordamiBox !== null) {
            //Generiamo un token sicuro, unico e casuale
            $remeberToken = bin2hex(random_bytes(32));

            //Salviamo il token nel database sull'oggetto persona loggato
            //Nota: l'entity EUtente deve avere il setter impostaRememberToken() DA AGGIUNGERE
            $persona->impostaRememberToken($remeberToken);
            FPersistentManager::PMsaveObj($persona); //Aggiorna l'utente sul DB

            //Inviamo il cookie al browser dell'utente (scadenza 30 giorni)
            UCookie::setCookie('remember_me', $remeberToken, 30);
        } else {
            //Se l'utente fa il login senza spuntare "ricordami", puliamo vecchi cookie residui
            if (UCookie::getCookie('remember_me')) {
                UCookie::deleteCookie('remember_me');
                $persona->impostaRememberToken(null);
                FPersistentManager::PMsaveObj($persona);
            }

        }

        //Controlliamo quale sottoclasse ha restituito Doctrine e mappiamo il ruolo testuale in sessione, così il BaseController può fare i controlli.
        if ($persona instanceof EAmministratore) {
            USession::setSessionElement('ruolo', 'amministratore');
            UFlashMessage::addMessage('success', 'Bentornato Amministratore!');
            header("Location: " . BASE_URL . "/admin/dashboard"); //reindirizza alla dashboard admin
        } elseif ($persona instanceof EGestore) {
            USession::setSessionElement('ruolo', 'gestore');
            UFlashMessage::addMessage('success', 'Bentornato Gestore!');
            header("Location: " . BASE_URL . "/gestore/dashboard"); //reindirizza alla dashboard gestore
        } else { //in questo caso è un EUtente
            USession::setSessionElement('ruolo', 'utente');
            UFlashMessage::addMessage('success', 'Login effettuato con successo!');
            header("Location: " . BASE_URL . "/"); //reindirizza alla home
        }

        exit();
    }

    /**
     * Gestisce la registrazione di un nuovo utente normale (Richiesta POST)
     * URL: POST /registrazione
     */
    public function registrazione(): void { 
        //Recuperiamo i campi della registrazione
        try {
            $nome = UHTTPMethods::postString('nome');
            $email = UHTTPMethods::postString('email');
            $password = UHTTPMethods::postString('password');
            $confermaPassword = UHTTPMethods::postString('conferma_password');
            $dataNascita = UHTTPMethods::postString('data_nascita');
        } catch (\InvalidArgumentException $e) {
            UFlashMessage::addMessage('danger', $e->getMessage());
            header('Location: ' . BASE_URL . '/registrati');
            exit();
        }
         
        //Controllo di validità dei campi obbligatori
        if (!$nome || !$email || !$password || !$confermaPassword || !$dataNascita) {
            //Se manca uno dei tre, impostiamo un messaggio di errore rapido
            UFlashMessage::addMessage('danger', 'Tutti i campi sono obbligatori.');
            //Pattern PRG: ricarichiamo la pagina del form per mostrare l'errore in sicurezza
            header('Location: ' . BASE_URL . '/registrati');
            exit();
        }

        //Verifichiamo che password e confermaPassword coincidano
        if ($password !== $confermaPassword) {
            UFlashMessage::addMessage('danger', 'Le password non coincidono.');
            header('Location: ' . BASE_URL . '/registrati');
            exit();
        }

        //Verifichiamo che l'email non sia già registrata nel DB per evitare duplicati
        $esiste = FPersistentManager::PMverificaEsistenza(EUtente::class, 'emailpersona', $email);

        if ($esiste) {
            UFlashMessage::addMessage('danger', 'Questa email è già registrata.');
            header('Location: ' . BASE_URL . '/registrati');
            exit();
        }

        try {
            try {
                $dataObj = new \DateTime($dataNascita);
            } catch (\Exception $e) {
                throw new InvalidArgumentException("La data di nascita non è valida.");
            }

            //Il costruttore di EUtente valida internamente nome, email, password e data di nascita e
            //lancia InvalidArgumentException se qualcosa non va; qui la intercettiamo
            //per mostrare un messaggio leggibile invece di un errore fatale.
            $nuovoUtente = new EUtente($nome, $email, $password, $dataObj); //la password viene criptata nell'entity
        } catch (InvalidArgumentException $e) {
            //Se l'utente non ha completato i campi obbligatori, mostriamo un messaggio di errore
            UFlashMessage::addMessage('danger', $e->getMessage());
            header('Location: ' . BASE_URL . '/registrati');
            exit();
        }

        $salvato = FPersistentManager::PMsaveObj($nuovoUtente);

        if ($salvato) {
            UFlashMessage::addMessage('success', 'Registrazione completata! Effettua il login.');
            header("Location: " . BASE_URL . "/accedi");
            exit();
        } else {
            UFlashMessage::addMessage('danger', 'Si è verificato un errore durante la registrazione. Riprova.');
            header("Location: " . BASE_URL . "/registrati");
        }

        exit();
    }

    /**
     * Gestisce il logout dell'utente (Richiesta GET o POST).
     * URL: GET /logout
     */
    public function logout(): void {
        //Prima di distruggere la sessione, recuperiamo l'utente per pulire il DB
        $idPersona = USession::getSessionElement('id_persona');
        $ruolo = USession::getSessionElement('ruolo');

        if ($idPersona && $ruolo === 'utente') {
            $utente = FPersistentManager::PMgetObjOnAttribute(EUtente::class, 'idPersona', $idPersona);
            if ($utente) {
                $utente->impostaRememberToken(null);
                FPersistentManager::PMsaveObj($utente);
            }
        }

        //Cancelliamo fisicamente il cookie dal browser dell'utente
        UCookie::deleteCookie('remember_me');

        //Distruggiamo la sessione corrente
        USession::destroySession();

        //Messaggio di conferma di avvenuto logout
        UFlashMessage::addMessage('success', 'Disconnessione effettuata. A presto!');

        //Reindirizziamo l'utente alla home
        header('Location: ' . BASE_URL . '/');
        exit();
    }

    /**
     * Sovrascrive il metodo del BaseController.
     * Breadcrumb differenziato in pase alla pagina corrente (login vs registrazione).
     */
    protected function getBreadcrumbs(string $currentPage = ''): array {
        return match ($currentPage) {
            'registrati' => [
                ['label' => 'Home', 'url' => BASE_URL . '/'],
                ['label' => 'Registrati', 'url' => BASE_URL . '/registrati']
            ],
            default => [
                ['label' => 'Home', 'url' => BASE_URL . '/'],
                ['label' => 'Login', 'url' => BASE_URL . '/accedi']
            ],
        };
    }
}