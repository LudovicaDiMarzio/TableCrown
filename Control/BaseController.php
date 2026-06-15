<?php
/**
 * Il BaseController (astratto) centralizza la logica di controllo, sicurezza e sessione.
 */
namespace TableCrown\Control;


abstract class BaseController {
    //riferimento al livello FOundation da inserire
    //protected FPersistentManager $persistentManager;
    protected array $validRoles;

    public function __construct() {
        //$this->persistentManager = FPersistentManager::getInstance();
        
        //Definisco i ruoli validi del nostro sistema TableCrown
        $this->validRoles = [
            'utente',
            'gestore',
            'amministratore',
        ];
    }

    /**
     * Controlla se l'utente è loggato nella sessione globale.
     */
    public function isLoggedIn(): bool {
        return isset($_SESSION['utente']);
    }

    /**
     * Forza il login: se l'utente non è loggato, lo reindirizza alla pagina di login.
     */
    public function requireLogin(): void {
        if (!$this->isLoggedIn()) {
            //Pattern PRG: messaggio flash di avviso
            $_SESSION['flash_message'] = "È necessario effettuare l'accesso per visualizzare questa pagina.";
            $_SESSION['flash_type'] = "warning";

            header("Location: /login");
            exit();
        }
    }

    /**
     * Protezione per il ruolo singolo (es. solo l'Amministratore)
     */
    public function requireRole(string $role): void {
        if (!in_array($role, $this->validRoles, true)) {
            throw new \Exception("Ruolo non valido: " . $role);
        }

        $this->requireLogin();

        //Supponendo che $_SESSION['utente'] sia un oggetto EUtente con il metodo getRuolo()
        $userRole = $_SESSION['utente']->getRuolo();

        if ($userRole !== $role) {
            echo "Errore 403 - Accesso Negato: Non hai i permessi necessari.";
        }
    }

    /**
     * Inietta le variabili fisse richieste dal layout globale nel controller specifico
     * prima di passarle alla View di Presentation.
     */
    protected function preparaVariabiliGlobali($view, $currentPage) {
        $baseUrl = "http://" . $_SERVER['HTTP_HOST'];

        //Uso i metodi wrapper 'assign' definiti in VView
        $view->assign('baseUrl', $baseUrl);
        $view->assign('currentPage', $currentPage);

        if ($this->isLoggedIn()) {
            $view->assign('utente', $_SESSION['utente']);
            //Conteggio carrello (finto per ora, poi leggerà la sessione o il DB)
            $cartCount = isset($_SESSION['carrello']) ? count($_SESSION['carrello']) : 0;
            $view->assign('cart_count', $cartCount);
        }

        //Gestione Flash Masseges
        if (isset($_SESSION['flash_message'])) {
            $view->assign('flash_message', $_SESSION['flash_message']);
            $view->assign('flash_type', $_SESSION['flash_type']);
            unset($_SESSION['flash_message']);
            unset($_SESSION['flash_type']);
        }
    }


}