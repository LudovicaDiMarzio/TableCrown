<?php
/**
 * Controller deputato alla gestione della navigazione generica e delle pagine principali pubbliche.
 */
namespace TableCrown\Control;

use TableCrown\Control\BaseController;
use TableCrown\Entity\EProdotto;
use TableCrown\Presentation\Views\ViewHome;
use TableCrown\Foundation\FPersistentManager;

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
        $offerte = FPersistentManager::PMfindProdottiInOfferta(5, 0); //DA CREARE
        $nuoviArrivi = FPersistentManager::PMgetObjListOrdered(EProdotto::class, 'dataPubblicazione', 'DESC', 5);

        //Convertiamo gli oggetti Entity in array associativi per Presentation
        $offerteArray = array_map(fn($p) => $p->toArray(), $offerte);
        $nuoviArriviArray = array_map(fn($p) => $p->toArray(), $nuoviArrivi);

        
        //TODO: capire cosa serve dell'utente, recuperarlo dal DB e restituirlo assieme ai dati globali


        //Impacchettiamo i dati specifici richiesti da home.tpl
        $datiPagina = [
            'offerte' => $offerteArray,
            'nuovi_arrivi' => $nuoviArriviArray,
            'categorie' => self::TIPI_PRODOTTO, //Passiamo anche le categorie valide per il catalogo
        ];

        //Uniamo i dati specifici con quello globali del layout
        //Passiamo "home" come pagina corrente per attivare la voce giusta nella navbar.
        $datiLayout = $this->preparaDatiLayout('home', $datiPagina);

        /**
         * Passiamo i dati al layer Presentation:
         * poichè il metodo render() è statico, non serve istanziare la classe View.
         * Sarà poi la View a fare gli assign su Smarty e il display('home.tpl').  
         */
        ViewHome::render($datiLayout);

    }


}