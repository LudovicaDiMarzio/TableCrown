<?php
/**
 * Il BaseController (astratto) centralizza la logica di controllo, sicurezza e sessione.
 */
namespace TableCrown\Control;

use TableCrown\Utility\USession;
use TableCrown\Utility\UHTTPMethods;
use TableCrown\Utility\UFlashMessage;


abstract class BaseController {

    protected array $validRoles; //Elenco di ruoli di sistema ammessi per il controllo dei permessi.

    //Definisco i tipi di prodotto validi per il catalogo, che a livello entity sono
    //classi diverse, in modo da poter restituire l'informazione sotto forma di array associativo.
    protected const TIPI_PRODOTTO = [
        'giochi-da-tavolo' => 'Gioco da Tavolo',
        'bustine' => 'Bustine',
        'porta-dadi' => 'Porta Dadi',
    ];
    

    public function __construct() {

        //Definisco i ruoli validi del nostro sistema TableCrown
        $this->validRoles = [
            'utente',
            'gestore',
            'amministratore',
        ];
    }

    /**
     * Prepara i dati globali richiesti dal layout prima di passarli alla View reale.
     * $currentPage è il nome della pagina corrente, ad esempio "home", "catalogo", "dettaglio_prodotto", ecc.
     * $data è un array associativo che contiene i dati specifici passati dal controller figlio.
     * Restituisce l'array completo di tutti i dati uniti.
     */
    public function preparaDatiLayout(string $currentPage, $data = []): array {
        //Variabili globali sempre richieste dal layout
        $globalData = [
            'base_url' => 'https://tablecrown.it', 
            'current_page' => $currentPage, //Indica la pagina attiva (es. 'catalogo', 'eventi', ecc.)
            'breadcrumbs' => $this->getBreadcrumbs(), //Il percorso di navigazione
        ];

        //Controllo dell'utente (/persona) in sessione
        if (USession::isSetSessionElement('id_persona')) {
            //Utente loggato: costruiamo l'array minimo neccessario per Presentation
            $globalData['utente'] = [
                'nickname' => USession::getSessionElement('nickname'),
            ];

            //cart_count solo per gli utenti (non per gestore o amministratore)
            if (USession::getSessionElement('ruolo') === 'utente') {
                $carrello = USession::getSessionElement('carrello') ?? [];
                //array_column estrae la colonna 'quantita' da ogni riga del carrello
                //array_sum somma tutti i valori ottenuti
                $cartCount = array_sum(array_column($carrello, 'quantita'));
                if ($cartCount > 0) {
                    $globalData['cart_count'] = $cartCount; //Il badge appare solo se gli articoli sono > 0
                }
            }
        } else {
            //Utente non loggato
            $globalData['utente'] = null;
        }

        //Gestione dei Flash Messages
        if (UFlashMessage::hasMessage()) {
            $messaggiSalvati = UFlashMessage::getMessage();

            //Estraggo la stringa del messaggio e il tipo per Smarty
            foreach ($messaggiSalvati as $type => $messaggesArray) {
                if (!empty($messaggesArray)) {
                    $globalData['flash_message'] = $messaggesArray[0];//Prendiamo il primo messaggio di quel tipo
                    $globalData['flash_type'] = $type; //'success', 'danger', ecc.
                    break; //Ci fermiamo al primo tipo trovato (per non sovrascrivere i dati) per inviarlo al layout
                }
            }
        }

        //Unisco i dati globali e quelli specifici della pagina
        //array_merge() unisce i due array. Se ci sono chiavi doppie, quelle in $data sovrascrivono quelle in $globalData
        return array_merge($globalData, $data);
    }

    /**
     * Metodo di default per la gestione dei Breadcrumbs (le pagine interne faranno l'override per restituire il loro percorso specifico).
     * Restituisce un array vuoto perchè di default la homepage non mostra i breadcrumbs.
     */
    protected function getBreadcrumbs(): array {
        return [];
    }


    /**
     * Controlla se l'utente è loggato nella sessione globale.
     */
    public function isLoggedIn(): bool {
        return USession::isSetSessionElement('id_persona');
    }

    /**
     * Forza il login: se l'utente non è loggato, imposta un avviso e lo reindirizza alla pagina di login.
     */
    public function requireLogin(): void {
        if (!$this->isLoggedIn()) {
            //Pattern PRG: messaggio flash di avviso
            UFlashMessage::addMessage('warning', "È necessario effettuare l'accesso per visualizzare questa pagina.");

            //Eseguiamo il redirect alla rotta più pulita gestita dal FrontController
            header("Location: /accedi");
            exit();
        }
    }

    /**
     * Protezione degli accessi basata sul ruolo (es. solo l'Amministratore)
     * Controlla che l'utente sia loggato e che abbia il ruolo richiesto.
     */
    public function requireRole(string $role): void {
        //Verifica che il ruolo richiesto faccia parte dell'elenco di ruoli ammessi
        if (!in_array($role, $this->validRoles, true)) {
            throw new \Exception("Ruolo non valido: " . $role);
        }

        //Se la pagina richiede un ruolo specifico, l'utente deve essere innanzitutto loggato
        $this->requireLogin();

        //Recupera il ruolo (stringa) salvato in sessione al momento del login
        $userRole = USession::getSessionElement('ruolo');

        if ($userRole !== $role) {
            //Se l'utente è loggato ma non ha i permessi (es. cliente prova a entrare nella dashboard del gestore)
            header("HTTP/1.1 403 Forbidden");
            echo "Errore 403 - Accesso Negato: Non hai i permessi necessari per accedere a questa risorsa."; //Error 403: utente loggato ma con ruolo sbagliato
            exit();
        }
    }
}