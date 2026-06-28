<?php
/**
 * Controller deputato alla gestione della navigazione generica e delle pagine principali pubbliche.
 */
namespace TableCrown\Control;

use TableCrown\Control\BaseController;
use TableCrown\Entity\EProdotto;

/**
 * QUANDO SARANNO PRONTI I RISPETTIVI LAYER, L'AUTOLOADER TROVERà QUESTE CLASSI:
 * use TableCrown\Presentation\VNavigazione;
 */

class CNavigazione extends BaseController {

    public function __construct() {
        //Richiama il costruttore di BaseController per inizializzare i ruoli validi di TableCrown
        parent::__construct();
    }

    /**
     * Mostra la Homepage del sito.
     * Recupera i nuovi arrivi e i prodotti in offerta da mostrare nei caroselli del template.
     */
    public function mostraHome(): void {
        /**
         * PER ORA INIZIALIZZO GLI ARRAY DEI PRODOTTI COME VUOTI.
         * SE PASSO ARRAY VUOTI O NULL, LA home.tpl MOSTRA CARD DEMO FITTIZIE. QUESTO CI PERMETTE
         * DI TESTARE LA PAGINE ANCHE SE IL DB NON è ANCORA PRONTO.
         */
        $offerte = [];
        $nuoviArrivi = [];

        //QUANDO SARÀ PRONTO FOUNDATION:
        /* //Interfaccia con il livello Foundation
         try {
            //SE NEL PERSISTENT MANAGER VENGONO IMPLEMENTATI METODI COMPLESSI O QUERY CONDIZIONALI,
            //USERò DEI METODI AD HOC PER LE LISTE FILTRATE, AD ESEMPIO:
            //$offerte = FPersistentManager::getObjListOnAttribute(EProdotto::class, 'inOfferta', true); //ipotizzando un metodo che restituisca tutti i prodotti in base ad un certo attributo, in questo caso 'inOfferta'
            //$nuoviArrivi = FPersistentManager::visualizzaListaOrdinata(EProdotto::class, 'dataPubblicazione', 'DESC', 5); //ipotizzando un metodo che restituisca una lista dei 5 ultimi prodotti aggiunti al catalogo
        } catch (\Exception $e) {
            //Gestione dell'errore di connessione al db: logghiamo l'errore e lasciamo gli array vuoti per non far crashare l'intera pagina visibile all'utente.
        }  
         */

        //Impacchettiamo i dati specifici richiesti da home.tpl
        $datiPagina = [
            'offerte' => $offerte,
            'nuovi_arrivi' => $nuoviArrivi
        ];

        //Prepariamo i dati globali del layout (URL base, utente in sessione, badge carrello, flash messages)
        //Passiamo "home" come nome della pagine corrente per attivare la classe "active" sulla barra di navigazione.
        $datiLayout = $this->preparaDatiLayout('home', $datiPagina);

        //QUANDO SARÀ PRONTO PRESENTATION:
        /**
         * Passiamo i dati al layer Presentation:
         * Istanziamo la View specifica e gli passiamo l'array dei dati.
         * Sarà poi la View a fare gli assign su Smarty e il display('home.tpl').  
         */
        /* $view = new VNavigazione();
        $view->mostraHome($datiLayout);
         */

        //TEMPORANEO PER IL TESTING: finchè non è pronto il file VNavigazione
        echo '<h1>Benvenuto sulla Home di TableCrown!</h1>';
        echo "<pre>";
        print_r($datiLayout);
        echo "</pre>";

    }


}