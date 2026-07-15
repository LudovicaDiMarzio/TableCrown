<?php
namespace TableCrown\Control;

use TableCrown\Utility\USession;
use TableCrown\Utility\UHTTPMethods;
use TableCrown\Entity\EProdotto;
use TableCrown\Foundation\FPersistentManager;
use TableCrown\Presentation\Views\ViewCarrello;

/**
 * Controller dedicato alla gestione del carrello acquisti.
 * I dati del carrello risiedono esclusivamente nella sessione utente.
 * Dialoga principalmente tramite JSON per supportare le chiamate asincrone (AJAX).
 */

class CCarrello extends BaseController {

    //URL base del sito, usato per costruire URL assoluti nelle risposte JSON
    //(il JS ha bisogno di URL completi per costruire il DOM senza passare da Smarty).
    private const BASE_URL = 'https://tablecrown.it'; //FORSE DA CAMBIARE, ANDREBBE DEFINITA IN UN FILE PIù GENERALE TIPO DI config

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

        //Costruiamo le tre sezioni di dati richieste dalla view, delegandone la costruzione a metodi specifici.
        //buildCarrelloSummary riceve carrelloItems già costruito, così non deve ricalcolare nulla dal DB
        $carrelloItems = $this->buildCarrelloItems($carrello);
        $carrelloSummary = $this->buildCarrelloSummary($carrelloItems, $carrello);
        $correlati = $this->prodottiCorrelati(array_keys($carrello));
 
        //Impacchettiamo i dati specifici per carrello.tpl
        $datiPagina = [
            'carrello_items' => $carrelloItems,
            'carrello_summary' => $carrelloSummary,
            'correlati' => $correlati,
        ];
 
        //Uniamo i dati specifici della pagina con i dati globali del layout
        $datiLayout = $this->preparaDatiLayout('carrello', $datiPagina);
 
        //Chiamata alla View per renderizzare il template di Smarty passando i dati
        ViewCarrello::mostraCarrello($datiLayout); 
    }

    //==========================================================================
    // METODI PRIVATI - per costruire i dati richiesti dalla view del carrello
    //==========================================================================
    /**
     * Costruisce l'array di righe del carrello, ciascuna con i dati reali del prodotto
     * (tramite prodottoToArray, stessa convenzione usata in home/catalogo/prodotto),
     * più i campi specifici della riga carrello (quantità, subtotale, url azioni).
     */
    private function buildCarrelloItems(array &$carrello): array { //con & prima di $carrello la funzione riceve un riferimento diretto alla variabile originale (per aggiornare la quantità)
        if (empty($carrello)) {
            return [];
        }
 
        $carrelloItems = [];
        $idsDaRimuovere = [];
        $idsProdotto = array_keys($carrello);

        $prodottiCaricati = FPersistentManager::PMgetObjListOnAttribute(EProdotto::class, 'idProdotto', $idsProdotto);

        //Indicizzazione per evitare query nel ciclo
        $prodottiIndicizzati = [];
        foreach ($prodottiCaricati as $prodotto) {
            $prodottiIndicizzati[$prodotto->getIdProdotto()] = $prodotto;
        }
 
        //Scorriamo il carrello prendendo la chiave (id prodotto) e il valore (quantità)
        foreach ($carrello as $idProdotto => $quantita) {
            //Chiediamo a Foundation di caricarci l'oggetto Entity del prodotto dal DB
            $prodotto = $prodottiIndicizzati[$idProdotto] ?? null;
 
            if (!$prodotto) {
                $idsDaRimuovere[] = $idProdotto; //così verrà rimosso e non verrà contato in aggiornaQuantita()
                continue; //salta il prodotto e passa al prossimo
            }
 
            $prodottoArray = $this->prodottoToArray($prodotto);
            //Prezzo effettivo da usare per i calcoli: scontato se presente, altrimenti pieno
            $prodottoArray['prezzo_unitario'] = $prodottoArray['prezzo_scontato'] ?? $prodottoArray['prezzo'];

            //Costruiamo la struttura esatta richiesta dalla View
            $carrelloItems[] = [
                'quantita' => $quantita,
                'subtotale' => $prodottoArray['prezzo_unitario'] * $quantita,
                'update_url' => '/carrello/aggiorna/' . $idProdotto,
                'remove_url' => '/carrello/rimuovi/' . $idProdotto,
                'prodotto' => $prodottoArray,
            ];
        }

        //Pulizia: rimuove dalla sessione i prodotti non più trovati nel DB,
        //così n_articoli e il carrello restanp coearenti con ciò che l'utente vede.
        if (!empty($idsDaRimuovere)) {
            foreach ($idsDaRimuovere as $idProdotto) {
                unset($carrello[$idProdotto]);
            }
            USession::setSessionElement('carrello', $carrello);
        }
 
        return $carrelloItems;
    }

    /**
     * Calcola i totali del carrello a partire dalle righe già costruite da buildCarrelloItems,
     * evitando di ricalcolare prezzi o ricontattare il DB.
     */
    private function buildCarrelloSummary(array $carrelloItems, array $carrello): array {
        $totale = 0.00;
        $totaleSconto = 0.00;
 
        foreach ($carrelloItems as $item) {
            $totale += $item['subtotale'];
 
            if ($item['prodotto']['sconto']) {
                $risparmioUnitario = $item['prodotto']['prezzo'] - $item['prodotto']['prezzo_unitario'];
                $totaleSconto += $risparmioUnitario * $item['quantita'];
            }
        }
 
        return [
            'n_articoli' => array_sum($carrello), //somma tutte le quantità nel carrello (0 se carrello vuoto)
            'sconto' => $totaleSconto,
            'totale' => $totale,
        ];
    }

    //==========================================================================
    // AZIONI AJAX
    //==========================================================================
 
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
        //Usiamo il metodo postInt che fa anche la validazione, ma poiché in caso di fallimento il metodo lancia un'eccezione, wrappiamo il blocco in try/catch.
        try {
            $idProdotto = UHTTPMethods::postInt('id_prodotto');
            //Prendiamo anche la quantità. Se nel form non c'era questo campo, di default impostiamo 1.
            $quantita = (int) UHTTPMethods::postInt('quantita', 1);
        } catch (\InvalidArgumentException $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
            exit();
        }


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

        //Recuperiamo il prodotto dal DB per construire la risposta JSON completa.
        //Il JS ne ha bisogno per costruire la card HTML da zero senza passare da Smarty.
        $prodotto = FPersistentManager::PMgetObjOnAttribute(EProdotto::class, 'idProdotto', $idProdotto);
        if (!$prodotto) {
            echo json_encode([
                'success' => false,
                'message' => 'Prodotto non trovato.'
            ]);
            exit();
        }

        //Controlliamo che un prodotto esaurito/non disponibile/ senza prezzo non vada nel carrello
        if (!$prodotto->isAcquistabile()) {
            echo json_encode([
                'success' => false,
                'message' => 'Prodotto non disponibile per l\'acquisto.'
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

        $prodottoArray = $this->prodottoToArray($prodotto);
        $prezzoUnitario = $prodottoArray['prezzo_scontato'] ?? $prodottoArray['prezzo'];
        $quantitaAggiornata = $carrello[$idProdotto];

        //Risposta finale di successo:
        //generiamo il JSON definitivo che JavaScript riceverà indietro (ha campi "piatti")
        //usiamo URL assoluti perché il JS non passa da Smarty e non ha accesso a base_url.
        echo json_encode([
            'id' => $prodottoArray['id'],
            'nome' => $prodottoArray['nome'],
            'immagine_url' => self::BASE_URL . '/img/prodotti/' . $prodottoArray['immagine'], //DA VERIFICARE
            'product_url' => self::BASE_URL . '/prodotto/' . $prodottoArray['id'],
            'prezzo_unitario' => $prezzoUnitario,
            'sconto' => $prodottoArray['sconto'],
            'prezzo_originale' => $prodottoArray['prezzo'],
            'percentuale_sconto' => $prodottoArray['percentuale_sconto'],
            'quantita' => $quantitaAggiornata,
            'subtotale' => $prezzoUnitario * $quantitaAggiornata,
            'update_url' => self::BASE_URL . '/carrello/aggiorna/' . $idProdotto,
            'remove_url' => self::BASE_URL . '/carrello/rimuovi/' . $idProdotto,
            'cart_count' => array_sum($carrello), //per aggiornare il badge navbar
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
        if (!isset($carrello[$idItem])) {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'message' => 'Prodotto non trovato nel carrello.'
            ]);
            exit();
        }

        $carrello[$idItem] = $nuovaQuantita;
        USession::setSessionElement('carrello', $carrello);

        //Riusiamo la stessa logica di mostraCarrello per i totali, evitando di 
        //duplicare e disallineare il calcolo dei prezzi.
        $carrelloItems = $this->buildCarrelloItems($carrello);
        $carrelloSummary = $this->buildCarrelloSummary($carrelloItems, $carrello);

        $itemAggiornato = null;
        foreach ($carrelloItems as $item) {
            if ($item['prodotto']['id'] === $idItem) {
                $itemAggiornato = $item;
                break;
            }
        }

        echo json_encode([
            'success' => true,
            'message' => 'Prodotto aggiornato nel carrello.',
            'subtotale' => $itemAggiornato['subtotale'] ?? 0.00,
            'cart_count' => array_sum($carrello),
            'totale' => $carrelloSummary['totale'],
            'sconto' => $carrelloSummary['sconto'],
        ]);
        exit();
    }

    /**
     * Rimuove o decrementa un prodotto dal carrello (chiamata AJAX).
     * URL: GET /carrello/rimuovi/{id_item} (DOVREBBE ESSERE POST!!!!!!!!!!)
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

        $carrelloItems = $this->buildCarrelloItems($carrello);
        $carrelloSummary = $this->buildCarrelloSummary($carrelloItems, $carrello);

        echo json_encode([
            'success' => true,
            'message' => 'Prodotto rimosso dal carrello',
            'cart_count' => $carrelloSummary['n_articoli'],
            'totale' => number_format($carrelloSummary['totale'], 2, '.', ''), //number_format forza 2 decimali con il punto come separatore, formato standard per JSON/JS
        ]);
        exit();
    }

    /**
     * Sovrascrive il metodo del BaseController per definire il percorso del Carrello.
     */
    protected function getBreadcrumbs(string $currentPage = ''): array {
        return [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Carrello', 'url' => '/carrello']
        ];
    }

}