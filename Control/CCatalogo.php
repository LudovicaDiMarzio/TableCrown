<?php
namespace TableCrown\Control;

use TableCrown\Foundation\FPersistentManager;
use TableCrown\Utility\UHTTPMethods;
use TableCrown\Entity\Enumerativi\DisponibilitaProdotto;
use TableCrown\Entity\Enumerativi\LinguaGioco;
use TableCrown\Entity\Enumerativi\DifficoltaGioco;
use TableCrown\Entity\Enumerativi\Categoria;
use TableCrown\Entity\Enumerativi\LivelloDannoGiochi;
use TableCrown\Presentation\Views\ViewCatalogo;

class CCatalogo extends BaseController {
    
    //==========================================================================
    // METODI PUBBLICI - uno per ciascuna sottoRoute del catalogo.
    //==========================================================================

    /**
     * Mostra la pagina del catalogo dei giochi da tavolo.
     * URL: GET /catalogo/giochi-da-tavolo
     */
    public function mostraCatalogoGiochi(): void {
        //Per le azioni condivise fra i tre metodi, implementiamo dei metodi privati, in modo da non ripetere il codice ogni volta.
        $pagina = $this->estraiPaginaRichiesta();
        $filtri = $this->estraiFiltriGiochi(); //sarà [] se non ci sono filtri

        //Chiamata a Foundation
        //Nota: PMfindGiochi(), così come i metodi successivi del pm, restituiscono
        //un array [risultati, totaleRisultati], in cui risultati è a sua volta un array
        //contenente tutti i prodotti che soddisfano i filtri richiesti.
        $risultatoGrezzo = FPersistentManager::PMfindGiochi(  //SE $filtri E' VUOTO, RESTITUISCE TUTTI I GIOCHI DA TAVOLO
            filtri: $filtri,
            limit: self::RISULTATI_PER_PAGINA,
            offset: ($pagina - 1) * self::RISULTATI_PER_PAGINA
        );

        $this->renderCatalogo('catalogo_giochi', $risultatoGrezzo, $pagina, $filtri);
    }

    /**
     * URL: GET /catalogo/bustine
     */
    public function mostraCatalogoBustine(): void { 
        $pagina = $this->estraiPaginaRichiesta();
        $filtri = $this->estraiFiltriPrezzo(); 

        $risultatoGrezzo = FPersistentManager::PMfindBustine(
            filtri: $filtri,
            limit: self::RISULTATI_PER_PAGINA,
            offset: ($pagina - 1) * self::RISULTATI_PER_PAGINA
        );

        $this->renderCatalogo('catalogo_bustine', $risultatoGrezzo, $pagina, $filtri);
    }

    /**
     * URL: GET /catalogo/porta-dadi
     */
    public function mostraCatalogoPortaDadi(): void { 
        $pagina = $this->estraiPaginaRichiesta();
        $filtri = $this->estraiFiltriPrezzo(); 

        $risultatoGrezzo = FPersistentManager::PMfindPortaDadi(
            filtri: $filtri,
            limit: self::RISULTATI_PER_PAGINA,
            offset: ($pagina - 1) * self::RISULTATI_PER_PAGINA
        );

        $this->renderCatalogo('catalogo_portadadi', $risultatoGrezzo, $pagina, $filtri);
    }

    /**
     * Mostra i risultati della ricerca
     * La barra di ricerca è un componente del layout globale,
     * ma una ricerca eseguita in questo modo (effettuata in una qualunque
     * delle pagine del sito), viene sempre gestita dal controller del catalogo
     * i risultati di ricerca sono limitati a prodotti di tipo gioco da tavolo
     * URL: GET /ricerca
     */
    public function mostraRisultatiRicercaProdotti(): void {
        $query = UHTTPMethods::get('q');
        $pagina = $this->estraiPaginaRichiesta();

        if ($query === null || trim($query) === '') {
            //Se non c'è nessun termine di ricerca, reindirizziamo alla pagina precedente. Fallback: la home
            header("Location: " . UHTTPMethods::getReferer(BASE_URL . '/'));
            exit();
        }

        $query = trim($query);

        //Cerca solo giochi da tavolo
        $risultatoGrezzo = FPersistentManager::PMricercaProdotto(
            StringaDiRicerca:$query,
            limit: self::RISULTATI_PER_PAGINA,
            offset: ($pagina - 1) * self::RISULTATI_PER_PAGINA
        );

        $this->renderCatalogo('ricerca', $risultatoGrezzo, $pagina, ['q' => $query], $query);
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