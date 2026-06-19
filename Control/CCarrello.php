<?php
namespace TableCrown\Control;

use TableCrown\Utility\USession;
use TableCrown\Utility\UHTTPMethods;

/**
 * Controller dedicato alla gestione del carrello acquisti.
 * Dialoga principalmente tramite JSON per supportare le chiamate asincrone (AJAX).
 */

class CCarrello extends BaseController {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Mostra la pagina principale del carrello.
     * URL: /carrello
     */
    public function mostraCarrello(): void {
        //Il carrello è accessibile solo agli utenti normali
        $this->requireRole('utente');

        $datiCarrello = [];

        //QUANDO SARà PRONTO FOUNDATION:
        /* $idPersona = USession::getSessionElement('id_persona');
        $carrello = FCarrello::getCarrelloByUtente($idPersona);
        $datiCarrello['prodotti'] = $carrello->getProdotti();
        $datiCarrello['totale'] = $carrello->getTotale();
         */

        //Prepariamo i dati per il layout per passarli alla View.
        $data = $this->preparaDatiLayout('carrello', $datiCarrello);

        //VCarrello::mostraCarrello($data);
        echo "Ecco la pagine del tuo carrello!";
    }

    /**
     * Aggiunge un prodotto al carrello (chiamata AJAX).
     * Risponde in JSON.
     * URL: /carrello/aggiungi
     */
    public function aggiungiAlCarrello(): void {
        //Impostiamo l'header per far capire al browser che stiamo inviando JSON
        header('Content-Type: application/json');

        //Controllo sicurezza: solo i clienti loggati hanno un carrello
        if (!$this->isLoggedIn() || USession::getSessionElement('ruolo') !== 'utente') {
            //blocca subito l'operazione e risponde con un JSON di errore
            //json_encode() trasforma un array PHP in una stringa JSON leggibile da JavaScript.
            echo json_encode([
                'success' => false,
                'error' => 'Devi effettuare il login come utente per aggiungere prodotti al carrelo.'
            ]);
            exit(); //interrompe immediatamente l'esecuzione dello script
        }

        //Recuperiamo i dati inviati dal browser tramite la richiesta.
        //Usiamo l'utility per prendere il parametro 'id_prodotto' inviato in POST.
        $idProdotto = UHTTPMethods::post('id_prodotto');
        //Prendiamo anche la quantità. Se nel form non c'era questo campo, di default impostiamo 1.
        $quantita = UHTTPMethods::post('quantita', 1);

        //Controllo di validità dei dati:
        //Se l'ID del prodotto è vuoto o non è arrivato...
        if(!$idProdotto){
            //...segnala a JavaScript l'errore con un messaggio JSON
            echo json_encode([
                'success' => false,
                'error' => 'Prodotto non specificato.'
            ]);
            exit();
        }

        //QUANDO SARÀ PRONTO FOUNDATION:
        /* 
        //Recuperiamo l'ID dell'utente loggato dalla sessione
        $idPersona = USession::getSessionElement('id_persona');
        //Comunichiamo a Foundation di salvare il prodotto nel carrello di quell'utente sul DB
        FCarrello::aggiungiProdotto($idPersona, $idProdotto, $quantita);
        //Chiediamo a Foundation quanti articoli ci sono ora nel carrello
        $nuovoConteggio = FCarrello::getCountByUtente($idPersona);
         */

        //SIMULIAMO UNA RISPOSTA DI SUCCESSO PER I TEST INIZIALI (DA ELIMINARE QUANDO SARà DISPONIBILE FOUNDATION)
        $nuovoConteggio = 3;

        //Risposta finale di successo:
        //generiamo il JSON definitivo che JavaScript riceverà indietro
        echo json_encode([
            'success' => true,
            'message' => 'Prodotto aggiunto al carrello',
            'cart_count' => $nuovoConteggio //serve a Presentation per aggiornare il numero sul badge in tempo reale
        ]);
        exit();
    }

    /**
     * Rimuove o decrementa un prodotto dal carrello (chiamata AJAX).
     * Risponde in JSON.
     * URL: /carrello/rimuovi
     */
    public function rimuoviDalCarrello(): void {
        header('Content-Type: application/json');

        if (!$this->isLoggedIn() || USession::getSessionElement('ruolo') !== 'utente') {
            echo json_encode([
                'success' => false,
                'error' => 'Non autorizzato.'
            ]);
            exit();
        }

        //Recuperiamo via POST l'ID del prodotto che l'utente vuole rimuovere dal carrello
        $idProdotto = UHTTPMethods::post('id_prodotto');

        //QUANDO SARÀ PRONTO FOUNDATION:
        /* $idPersona = USession::getSessionElement('id_persona');
        FCarrello::rimuoviProdotto($idPersona, $idProdotto); //Rimuove la riga dal DB
        $nuovoConteggio = FCarrello::getCountByUtente($idPersona); //Ricalcola quanti oggetti restano nel carrello
        $nuovoTotale = FCarrello::getCarrelloByUtente($idPersona)->getTotale(); //Ricalcola il prezzo totale
         */

        echo json_encode([
            'success' => true,
            'message' => 'Prodotto rimosso dal carrello',
            'cart_count' => 2, //Esempio simulato
            'totale' => '15.50' //Serve a Presentation per aggiornare il prezzo totale senza ricare la pagina
        ]);
        exit();
    }

    /**
     * Sovrascrive il metodo del BaseController per definire il percorso del Carrello.
     */
    protected function getBreadcrumbs(): array {
        return [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Carrello', 'url' => '/carrello']
        ];
    }

}