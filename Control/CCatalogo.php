<?php
namespace TableCrown\Control;

use TableCrown\Foundation\FPersistentManager;
use TableCrown\Utility\UHTTPMethods;

class CCatalogo extends BaseController {
    
    //==========================================================================
    // METODI PUBBLICI - uno per ciascuna sottoRoute del catalogo.
    //==========================================================================

    /**
     * Mostra la pagina del catalogo dei giochi da tavolo.
     * Gestisce sia filtri che barra di ricerca.
     * Nota: la ricerca avviene O tramite filtri O tramite barra di ricerca.
     * URL: GET /catalogo/giochi-da-tavolo
     */
    public function mostraCatalogoGiochi(): void {
        //Per le azioni condivise fra i tre metodi, implementiamo dei metodi privati, in modo da non ripetere il codice ogni volta.
        $pagina = $this->estraiPaginaRichiesta();
        $query = UHTTPMethods::get('q');
        $query = ($query !== null) ? trim($query) : null;

        if ($query !== null) {
            // --- CASO BARRA DI RICERCA ---
            //I filtri vengono annullati/resettati
            $filtri = [];
            $risultatoGrezzo = FPersistentManager::PMricercaGiochi(
                stringaDiRicerca: $query,
                limit: self::RISULTATI_PER_PAGINA,
                offset: ($pagina - 1) * self::RISULTATI_PER_PAGINA
            );
        } else {
            // --- CASO FILTRI ---
            // Il metodo findGiochi(), così come quelli per gli altri tipi di prodotto,
            // restituisce un array di questo tipo ['tisultati', 'totale', 'rangemin', 'rangemax']
            // rangemin non ci serve, lo impostiamo a 0.
            $filtri = $this->estraiFiltriGiochi(); //sarà [] se non ci sono filtri
            $risultatoGrezzo = FPersistentManager::PMfindGiochi(
                filtri: $filtri,
                limit: self::RISULTATI_PER_PAGINA,
                offset: ($pagina - 1) * self::RISULTATI_PER_PAGINA
            );
            //Aggiorniamo i filtri con il rangemax calcolato dal pm
            $filtri = $this->completaFiltriPrezzo($filtri, $risultatoGrezzo);
        }
        
        //Passiamo sia i filtri (vuoti se c'è una query) sia la query di ricerca al render
        $this->renderCatalogo('catalogo_giochi', $risultatoGrezzo, $pagina, $filtri, $query);
    }

    /**
     * URL: GET /catalogo/bustine
     */
    public function mostraCatalogoBustine(): void { 
        $pagina = $this->estraiPaginaRichiesta();
        $query = UHTTPMethods::get('q');
        $query = ($query !== null) ? trim($query) : null;

        if ($query !== null) {
            // --- CASO BARRA DI RICERCA ---
            //I filtri vengono annullati/resettati
            $filtri = [];
            $risultatoGrezzo = FPersistentManager::PMricercaBustine(
                stringaDiRicerca: $query,
                limit: self::RISULTATI_PER_PAGINA,
                offset: ($pagina - 1) * self::RISULTATI_PER_PAGINA
            );
        } else {
            // --- CASO FILTRI ---
            $filtri = $this->estraiFiltriPrezzo(); 
            $risultatoGrezzo = FPersistentManager::PMfindBustine(
                filtri: $filtri,
                limit: self::RISULTATI_PER_PAGINA,
                offset: ($pagina - 1) * self::RISULTATI_PER_PAGINA
            );
            $filtri = $this->completaFiltriPrezzo($filtri, $risultatoGrezzo);
        }
        
        $this->renderCatalogo('catalogo_bustine', $risultatoGrezzo, $pagina, $filtri, $query);
    }

    /**
     * URL: GET /catalogo/porta-dadi
     */
    public function mostraCatalogoPortaDadi(): void { 
        $pagina = $this->estraiPaginaRichiesta();
        $query = UHTTPMethods::get('q');
        $query = ($query !== null) ? trim($query) : null;

        if ($query !== null) {
            // --- CASO BARRA DI RICERCA ---
            //I filtri vengono annullati/resettati
            $filtri = [];
            $risultatoGrezzo = FPersistentManager::PMricercaPortaDadi(
                stringaDiRicerca: $query,
                limit: self::RISULTATI_PER_PAGINA,
                offset: ($pagina - 1) * self::RISULTATI_PER_PAGINA
            );
        } else {
            // --- CASO FILTRI ---
            $filtri = $this->estraiFiltriPrezzo(); 
            $risultatoGrezzo = FPersistentManager::PMfindPortaDadi(
                filtri: $filtri,
                limit: self::RISULTATI_PER_PAGINA,
                offset: ($pagina - 1) * self::RISULTATI_PER_PAGINA
            );
            $filtri = $this->completaFiltriPrezzo($filtri, $risultatoGrezzo);
        }

        $this->renderCatalogo('catalogo_portadadi', $risultatoGrezzo, $pagina, $filtri, $query);
    }

    //==========================================================================
    // CATALOGO OFFERTE
    //==========================================================================

    /**
     * Mostra il catalogo unico delle offerte: prodotti di qualsiasi tipo
     * (giochi da tavolo, bustine, porta dadi, ecc.), purché in sconto attivo.
     * URL: GET /offerte
     */
    public function mostraOfferte(): void {
        $pagina = $this->estraiPaginaRichiesta();

        $risultatoGrezzo = FPersistentManager::PMfindProdottiInOfferta(
            limit: self::RISULTATI_PER_PAGINA,
            offset: ($pagina - 1) * self::RISULTATI_PER_PAGINA
        );
        
        $this->renderCatalogo('offerte', $risultatoGrezzo, $pagina, []);
    }


    protected function getBreadcrumbs(string $currentPage = ''): array {
        $breadcrumbs = [['label' => 'Home', 'url' => BASE_URL . '/']];

        switch ($currentPage) {
            case 'catalogo_giochi':
                $breadcrumbs[] = ['label' => 'Giochi da tavolo', 'url' => BASE_URL . '/catalogo/giochi-da-tavolo'];
                break;
            case 'catalogo_bustine':
                $breadcrumbs[] = ['label' => 'Bustine', 'url' => BASE_URL . '/catalogo/bustine'];
                break;
            case 'catalogo_portadadi':
                $breadcrumbs[] = ['label' => 'Porta Dadi', 'url' => BASE_URL . '/catalogo/porta-dadi'];
                break;
            case 'ricerca':
                $breadcrumbs[] = ['label' => 'Risultati ricerca', 'url' => BASE_URL . '/ricerca'];
                break;
            case 'offerte':
                $breadcrumbs[] = ['label' => 'Offerte', 'url' => BASE_URL . '/offerte'];
                break;
        }

        return $breadcrumbs;
    }


}