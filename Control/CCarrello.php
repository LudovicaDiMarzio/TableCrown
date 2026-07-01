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
     * URL: GET /carrello
     */
    public function mostraCarrello(): void {
        //Il carrello è accessibile solo agli utenti normali
        $this->requireRole('utente');

        //Recuperiamo il carrello attuale memorizzato nella sessione. Se non esiste, ne creiamo uno vuoto
        $carrello = USession::getSessionElement('carrello') ?? [];

        //Le seguenti variabili accumuleranno i dati mentre scorriamo il carrello:
        $carrelloItems = []; //inizializziamo l'array principale che conterrà tutti i dati da passare alla View
        $totale = 0.00; //il prezzo totale non è salvato nella sessione, lo ricalcoliamo ogni volta che l'utente carica la pagina
        $totaleSconto = 0.00; //totale degli sconti applicati

        //Se l'array non è vuoto, significa che ci sono prodotti da elaborare
        if (!empty($carrello)) {
            //Ciclo sugli ID presenti nel carrello per caricare i dati reali dal DB
            //Scorriamo il carrello prendendo la chiave (id prodotto) e il valore (quantità)
            foreach ($carrello as $idProdotto => $quantita) {
                //Chiediamo a Foundation di caricarci l'oggetto Entity del prodotto dal DB
                $prodotto = $this->pm->PMgetObjOnAttribute(EProdotto::class, 'idProdotto', $idProdotto);

                if (!$prodotto) {
                    continue; //salta il prodotto e passa al prossimo
                } 

                //Determiniamo il prezzo unitario corretto:
                //se il prodotto è in sconto usiamo il prezzo scontato, altrimenti il prezzo pieno
                $hasSconto = $prodotto->getPrezzo()->hasSconto();
                $prezzoOriginale = $prodotto->getPrezzo()->getValore();
                $prezzoUnitario = $hasSconto ? $prodotto->getPrezzo()->calcolaValoreScontato() : $prezzoOriginale;

                //Calcoliamo il subtotale di questa riga (prezzo * quantità)
                $subtotale = $prezzoUnitario * $quantita;

                //Aggiorniamo i totali complessivi
                $totale += $subtotale;
 
                //Con totaleSconto intendiamo l'importo totale risparmiato considerando tutti i prodotti scontati presenti nel carrello
                if ($hasSconto) {
                    //Lo sconto totale è la differenza tra prezzo pieno e prezzo scontato, per la quantità
                    $totaleSconto += ($prezzoOriginale - $prezzoUnitario) * $quantita;
                }
                

                //Costruiamo la struttura esatta richiesta dalla View
                $carrelloItems[] = [
                    'quantita' => $quantita,
                    'subtotale' => $subtotale,
                    'update_url' => '/carrello/aggiorna/' . $idProdotto,
                    'remove_url' => '/carrello/rimuovi/' . $idProdotto,
                    'prodotto' => [
                        'id' => $prodotto->getIdProdotto(),
                        'nome' => $prodotto->getNomeProdotto(),
                        'immagine' => $prodotto->getImgProdotto(),
                        'prezzo_unitario' => $prezzoUnitario,
                        'sconto' => $hasSconto,
                        'prezzo_originale' => $prezzoOriginale,
                    ],
                ];
            }
        } //FORSE ANCHE LA COSTRUZIONE DEGLI ALTRI ARRAY VA DENTRO QUESTO IF??????

        //Costruiamo il riepilogo totali richiesto da View
        $carrelloSummary = [
            'n_articoli' => array_sum($carrello), //somma tutte le quantità nel carrello
            'sconto' => $totaleSconto, //sconto totale
            'totale' => $totale, //totale del carrello
        ];

        //Recuperiamo i prodotti correlati per il carosello "Potrebbe interessarti".
        //CRITERIO PROVVISIORIO: TUTTI I PRODOTTI DISPONIBILI, ESCLUSI QUELLI GIà NEL CARRELLO, LIMITATI AI PRIMI 4.
        $tuttiProdotti = $this->pm->PMgetAll(EProdotto::class);

        //Escludiamo i prodotti già presenti nel carrello usando i loro ID come filtro
        $idNelCarrello = array_keys($carrello);
        $correlati = array_filter(
            $tuttiProdotti, 
            fn($p) => !in_array($p->getIdProdotto(), $idNelCarrello) //arrow function: $p è il nome che assume temporaneamente ogni elemento dell'array, mentre array_filter lo itera
            );

        //Prendiamo solo i primi 4 e reindicizziamo l'array
        //array_filter mantiene gli indici originali, array_values li azzera.
        $correlati = array_slice(array_values($correlati), 0, 4);

        //Convertiamo in array nel formato richiesto dalla View
        $correlatiArray = array_map(fn($p) => [
            'id' => $p->getIdProdotto(),
            'nome' => $p->getNomeProdotto(),
            'immagine' => $p->getImgProdotto(),
            'valutazione_media' => $p->getValutazioneMedia(),
            'prezzo' => $p->hasSconto() ? null : $p->getPrezzo()->getValore(),
            'prezzo_scontato' => $p->hasSconto() ? $p->getPrezzo()->calcolaValoreScontato() : null,
            'sconto' => $p->hasSconto(),
        ], $correlati);

        //Impacchettiamo i dati specifici per carrello.tpl
        $datiPagina = [
            'carrello_items' => $carrelloItems,
            'carrello_summary' => $carrelloSummary,
            'correlati' => $correlatiArray, //omesso se vuoto (la view lo gestisce con isset)
        ];

        //Uniamo i dati specifi della pagina con i dati globali del layout
        $data = $this->preparaDatiLayout('carrello', $datiPagina);

        //Chiamata alla View per renderizzare il template di Smarty passando i dati
        //VCarrello::mostraCarrello($data);

        //Stampiamo un testo di controllo provvisorio a schermo
        echo "Pagina carrello - dati pronti:";
        echo "<pre>" . print_r($data, true) . "</pre>";
    }

    /**
     * Aggiunge un prodotto al carrello (chiamata AJAX).
     * Risponde in JSON.
     * URL: POST /carrello/aggiungi
     */
    public function aggiungiAlCarrello(): void {
        //Impostiamo l'header per far capire al browser che stiamo inviando JSON
        header('Content-Type: application/json');

        //Controllo sicurezza: solo i clienti loggati hanno un carrello
        if (!$this->isLoggedIn() || USession::getSessionElement('ruolo') !== 'utente') {
            //rispondiamo con HTTP 401. Il JS di Presentation intercetta questo status
            //e apre il modal login lato client da JavaScript.
            http_response_code(401);
            echo json_encode(['error' => 'auth_required']);
            exit(); //interrompe immediatamente l'esecuzione dello script
        }

        //Recuperiamo i dati inviati dal browser tramite la richiesta.
        //Usiamo l'utility per prendere il parametro 'id_prodotto' inviato in POST.
        $idProdotto = UHTTPMethods::post('id_prodotto');
        //Prendiamo anche la quantità. Se nel form non c'era questo campo, di default impostiamo 1.
        $quantita = (int) UHTTPMethods::post('quantita', 1);

        //Controllo di validità dei dati:
        //Se l'ID del prodotto è vuoto o non è arrivato...
        if(!$idProdotto){
            //...segnala a JavaScript l'errore con un messaggio JSON
            echo json_encode([
                'success' => false,
                'message' => 'Prodotto non specificato.'
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
            'cart_count' => $nuovoConteggio, //serve a Presentation per aggiornare il numero sul badge in tempo reale
            'message' => 'Prodotto aggiunto al carrello',
        ]);
        exit();
    }

    /**
     * Aggiorna la quantità di un prodotto nel carrello (chiamata AJAX).
     * L'id_item arriva come segmento URL, la nuova quantità come query string.
     * URL: GET /carrello/aggiorna{id_item}?qty={quantita}
     * Risponde in JSON.
     */
    public function aggiornaQuantita(int $idItem): void {
        header('Content-Type: application/json');

        if (!$this->isLoggedIn() || USession::getSessionElement('ruolo') !== 'utente') {
            http_response_code(401);
            echo json_encode(['error' => 'auth_required']);
            exit(); //interrompe immediatamente l'esecuzione dello script
        }

        //La nuova quantità arriva come paramtro GET nella query string (?qty=N)
        $nuovaQuantita = (int) UHTTPMethods::get('qty', 1);

        //La quantità deve essere almeno 1 (il template ha min = 1, ma validiamo anche server-side)
        if ($nuovaQuantita < 1) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Quantità non valida.'
            ]);
            exit();
        }

        $carrello = USession::getSessionElement('carrello') ?? [];

        //Aggiorniamo la quantità solo se il prodotto esiste nel carrello
        if (isset($carrello[$idItem])) {
            $carrello[$idItem] = $nuovaQuantita;
            USession::setSessionElement('carrello', $carrello);
        }

        echo json_encode([
            'success' => true,
            'message' => 'Prodotto aggiornato nel carrello',
        ]);
        exit();
    }

    /**
     * Rimuove o decrementa un prodotto dal carrello (chiamata AJAX).
     * URL: GET /carrello/rimuovi/{id_item}
     * Risponde in JSON. Se dopo la rimozione il carrello è vuoto,
     * il JS ricarica la pagina automaticamente
     */
    public function rimuoviDalCarrello(int $idItem): void {
        header('Content-Type: application/json');

        //Controllo sicurezza: impedisce l'azione se l'utente non è autenticato
        if (!$this->isLoggedIn() || USession::getSessionElement('ruolo') !== 'utente') {
            http_response_code(401);
            echo json_encode(['error' => 'auth_required']);
            exit();
        }

        $carrello = USession::getSessionElement('carrello') ?? [];

        //unset() rimuove completamente la chiave dall'array corrispondente al prodotto
        if (isset($carrello[$idItem])) {
            unset($carrello[$idItem]);
        }

        //Salviamo lo stato del carrello aggiornato in sessione (potrebbe risultare vuoto a questo punto)
        USession::setSessionElement('carrello', $carrello);

        //Ricalcoliamo il totale degli elementi rimasti
        $nuovoConteggio = array_sum($carrello);

        //Ricalcoliamo anche il nuovo totale, scorrendo i prodotti rimasti nel carrello
        //e recuperando i prezzi reali dal DB tramite il pm
        $nuovoTotale = 0.00;
        foreach ($carrello as $idProdotto => $quantita) {
            $prodotto = $this->pm->PMgetObjOnAttribute(EProdotto::class, 'idProdotto', $idProdotto);
            if ($prodotto) {
                //Usiamo il prezzo scontato se presente, altrimenti il prezzo pieno
                $prezzoUnitario = $prodotto->hasSconto() ? $prodotto->getPrezzo()->calcolaValoreScontato() : $prodotto->getPrezzo()->getValore();
                $nuovoTotale += ($prezzoUnitario * $quantita);
            }
        }

        echo json_encode([
            'success' => true,
            'cart_count' => $nuovoConteggio,
            'message' => 'Prodotto rimosso dal carrello',
            'totale' => number_format($nuovoTotale, 2, '.', '') //number_format forza 2 decimali con il punto come separatore, formato standard per JSON/JS
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