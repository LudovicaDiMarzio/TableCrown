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
        $offerte = FPersistentManager::PMfindProdottiInOfferta(5, 0); 
        $nuoviArrivi = FPersistentManager::PMgetObjListOrdered(EProdotto::class, 'dataPubblicazione', 'DESC', 5);


        //Impacchettiamo i dati specifici richiesti da home.tpl
        $datiPagina = [
            'offerte' => $this->prodottiToArray($offerte['risultati'] ?? []),
            'nuovi_arrivi' => $this->prodottiToArray($nuoviArrivi),
        ];

        //Uniamo i dati specifici con quello globali del layout
        //Passiamo "home" come pagina corrente per attivare la voce giusta nella navbar.
        $datiLayout = $this->preparaDatiLayout('home', $datiPagina);

        /**
         * Passiamo i dati al layer Presentation:
         * poichè il metodo mostraHome() è statico, non serve istanziare la classe View.
         * Sarà poi la View a fare gli assign su Smarty e il display('home.tpl').  
         */
        ViewHome::mostraHome($datiLayout);

    }

    protected function getBreadcrumbs(string $currentPage = ''): array {
        return [
            ['label' => 'Home', 'url' => '/'],
        ];
    }


}