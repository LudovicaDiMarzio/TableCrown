<?php
namespace TableCrown\Control;

use TableCrown\Utility\USession;
use TableCrown\Utility\UHTTPMethods;
use TableCrown\Entity\EProdotto;

/**
 * Controller dedicato alla gestione del carrello acquisti.
 * I dati del carrello risiedono esclusivamente nella sessione utente.
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

        //Inizializziamo l'array principale che conterrà tutti i dati da passare a Smarty
        $datiCarrello = [];
        //Inizializziamo la sotto-chiave dei prodotti come array vuoto (evita errori se il carrello è vuoto)
        $datiCarrello['prodotti'] = [];
        //Impostiamo il prezzo totale iniziale a zero con formato decimale
        $datiCarrello['totale'] = 0.00; //il prezzo totale non è salvato nella sessione, lo ricalcoliamo ogni volta che l'utente carica la pagina

        //Recuperiamo il carrello attuale memorizzato nella sessione. Se non esiste, ne creiamo uno vuoto
        $carrello = USession::getSessionElement('carrello') ?? [];

        //Se l'array non è vuoto, significa che ci sono prodotti da elaborare
        if (!empty($carrello)) {
            //QUANDO SARÀ PRONTO FOUNDATION:
            //Ciclo sugli ID presenti nel carrello per caricare i dati reali dal DB
            /* 
            //Scorriamo il carrello prendendo la chiave (id prodotto) e il valore (quantità)
            foreach ($carrello as $idProdotto => $quantita) {
                //Chiediamo a Foundation di caricarci l'oggetto Entity del prodotto dal DB
                $prodotto = FPersistentManager::visualizza(EProdotto::class, 'idProdotto', $idProdotto);

                //Se il prodotto esiste nel DB...
                if ($prodotto) {
                    //...lo aggiungiamo all'elenco dei prodotti da mandare alla View, insieme alla sua quantità
                    $datiCarrello['prodotti'][] = [
                        'oggetto' => $prodotto,
                        'quantita' => $quantita
                    ];
                    //Sommiamo al totale generale il prezzo del prodotto moltiplicato per la sua quantità
                    $datiCarrello['totale'] += ($prodotto->getPrezzo() * $quantita);
                } 
            }*/
        

            //PER ORA SIMULIAMO UN TOTALE FISSO PER EVITARE CHE LA PAGINA VISUALIZZI DATI VUOTI NEI TEST
            $datiCarrello['totale'] = 15.50;
        }


        //Prepariamo i dati per il layout per passarli alla View, unendo i dati specifici del carrello con i dati globali del layout (base_url, breadcrumbs, ecc.).
        $data = $this->preparaDatiLayout('carrello', $datiCarrello);

        //Chiamata alla View per renderizzare il template di Smarty passando i dati
        //VCarrello::mostraCarrello($data);

        //Stampiamo un testo di controllo provvisorio a schermo
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

        //Recuperiamo l'array del carrello attuale dalla sessione o ne creiamo uno vuoto se non esiste
        $carrello = USession::getSessionElement('carrello') ?? [];

        //Aggiorniamo la quantità del prodotto se è già presente, altrimenti lo inseriamo
        if (isset($carrello[$idProdotto])) {
            $carrello[$idProdotto] += $quantita;
        } else {
            $carrello[$idProdotto] = $quantita;
        }

        //Salviamo nuovamente il carrello aggiornato in sessione
        USession::setSessionElement('carrello', $carrello);

        //Calcoliamo il numero totale di elementi (somma delle singole quantità)
        $nuovoConteggio = array_sum($carrello);

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

        //Controllo sicurezza: impedisce l'azione se l'utente non è autenticato
        if (!$this->isLoggedIn() || USession::getSessionElement('ruolo') !== 'utente') {
            echo json_encode([
                'success' => false,
                'error' => 'Non autorizzato.'
            ]);
            exit();
        }

        //Recuperiamo via POST l'ID del prodotto che l'utente vuole rimuovere dal carrello
        $idProdotto = UHTTPMethods::post('id_prodotto');

        if (!$idProdotto) {
            echo json_encode([
                'success' => false,
                'error' => 'Prodotto non valido.'
            ]);
            exit();
        }

        //Recuperiamo il carrello dalla sessione
        $carrello = USession::getSessionElement('carrello') ?? [];

        //Se il prodotto esiste nel carrello, eliminiamo direttemente la sua chiave
        if (isset($carrello[$idProdotto])) {
            unset($carrello[$idProdotto]); 
        }

        //Salviamo lo stato del carrello aggiornato in sessione
        USession::setSessionElement('carrello', $carrello);

        //Ricalcoliamo il totale degli elementi rimasti
        $nuovoConteggio = array_sum($carrello);

        //Calcolo il nuovo prezzo totale
        //QUANDO SARÀ PRONTO FOUNDATION (CLASSE FPRODOTTO):
        //Scorriamo il nuovo carrello aggiornato e sommiamo i prezzi reali presi dal DB
        /* $nuovoTotale = 0.00;
        foreach ($carrello as $idProdotto => $quantita) {
            $prodotto = FPersistentManager::visualizza(EProdotto::class, 'idProdotto', $idProdotto);
            if ($prodotto) {
                $nuovoTotale += ($prodotto->getPrezzo() * $quantita);
            }
        } */

        //PER I TEST IMMEDIATI SIMULIAMO UN VALORE DI RITORNO
        $nuovoTotale = 15.50;

        echo json_encode([
            'success' => true,
            'message' => 'Prodotto rimosso dal carrello',
            'cart_count' => $nuovoConteggio, //Esempio simulato
            'totale' => number_format($nuovoTotale, 2, '.', '') //Serve a Presentation per aggiornare il prezzo totale senza ricare la pagina
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