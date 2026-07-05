<?php
/**
 * Controller deputato alla gestione della navigazione generica e delle pagine principali pubbliche.
 */
namespace TableCrown\Control;

use TableCrown\Control\BaseController;
use TableCrown\Entity\EProdotto;
//use TableCrown\Presentation\VHome;

class CNavigazione extends BaseController {

    public function __construct() {
        //Richiama il costruttore di BaseController che inizializza:
        //- $this->validRoles (array di ruoli validi)
        parent::__construct();
    }

    /**
     * Mostra la Homepage del sito.
     * Recupera i nuovi arrivi e i prodotti in offerta da mostrare nei caroselli del template.
     */
    public function mostraHome(): void {
        //Recuperiamo i prodotti in offerta e i nuovi arrivi tramite il pm
        //Il pm gestisce già gli errori internamente e restituisce [] in caso di fallimento
        $offerte = FPersistentManager::PMgetObjListOnAttribute(EProdotto::class, 'inOfferta', true);
        $nuoviArrivi = FPersistentManager::PMgetObjListOrdered(EProdotto::class, 'dataPubblicazione', 'DESC', 5);//metodo da creare

        //Convertiamo gli oggetti Entity in array associativi per Presentation
        $offerteArray = array_map(fn($p) => $p->toArray(), $offerte);
        $nuoviArriviArray = array_map(fn($p) => $p->toArray(), $nuoviArrivi);

        //Impacchettiamo i dati specifici richiesti da home.tpl
        $datiPagina = [
            'offerte' => $offerteArray,
            'nuovi_arrivi' => $nuoviArriviArray
        ];

        //Uniamo i dati specifici con quello globali del layout
        //Passiamo "home" come pagina corrente per attivare la voce giusta nella navbar.
        $datiLayout = $this->preparaDatiLayout('home', $datiPagina);

        /**
         * Passiamo i dati al layer Presentation:
         * Istanziamo la View specifica e gli passiamo l'array dei dati.
         * Sarà poi la View a fare gli assign su Smarty e il display('home.tpl').  
         */
        //$view = new VHome();
        //$view->render($datiLayout);

    }


}