<?php
namespace TableCrown\Control;

use TableCrown\Foundation\FPersistentManager;
use TableCrown\Utility\UHTTPMethods;

class CCatalogo extends BaseController {
    private const RISULTATI_PER_PAGINA = 20; //valore di default

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
        $risultatoGrezzo = FPersistentManager::PMfindGiochi(  //SE $filtri E' VUOTO, RESTITUISCE TUTTI I GIOCHI DA TAVOLO
            filtri: $filtri,
            limit: self::RISULTATI_PER_PAGINA,
            offset: ($pagina - 1) * self::RISULTATI_PER_PAGINA
            );

        
        $totaleRisultati = $risultatoGrezzo['totale'] ?? 0; //se non c'è la chiave 'totale', assumiamo 0 risultati
        $totalePagine = $this->calcolaTotalePagine($totaleRisultati);
        $pagina = $this->clampPagina($pagina, $totalePagine);
        

        $prodottiMappati = $this->mappaProdottiPerCatalogo($risultatoGrezzo['risultati'] ?? []); //se non c'è la chiave 'risultati', assumiamo []

        //Impacchettiamo i dati secondo la ViewCatalogo //DA CAMBIAREEEEEEEEEE!!!!
        $datiPagina = [
            'prodotti' => $prodottiMappati,
            'filtri' => $filtri,
            'pagina' => $pagina,
            'totale_pagine' => $totalePagine,
            'categorie' => ['Giochi da tavolo', 'Bustine', 'Porta dadi'],
        ];

        $datiLayout = $this->preparaDatiLayout('catalogo_giochi', $datiPagina);
        ViewCatalogo::render($datiLayout);

    }

    public function mostraCatalogoBustine(): void { //DA RIVEDEREEEEE!!!!!!
        $pagina = $this->estraiPaginaRichiesta();
        $filtri = $this->estraiFiltriPrezzo(); 

        $risultatoGrezzo = FPersistentManager::PMfindBustine(
            filtri: $filtri,
            limit: self::RISULTATI_PER_PAGINA,
            offset: ($pagina - 1) * self::RISULTATI_PER_PAGINA
        );

        $totaleRisultati = $risultatoGrezzo['totale'] ?? 0;
        $totalePagine = $this->calcolaTotalePagine($totaleRisultati);
        $pagina = $this->clampPagina($pagina, $totalePagine);

        $prodottiMappati = $this->mappaProdottiPerCatalogo($risultatoGrezzo['risultati'] ?? []);

        $datiPagina = [
            'prodotti'       => $prodottiMappati,
            'filtri'         => $filtri,
            'pagina'         => $pagina,
            'totale_pagine'  => $totalePagine
        ];

        $datiLayout = $this->preparaDatiLayout('catalogo_bustine', $datiPagina);
        ViewCatalogo::render($datiLayout);
    }

    public function mostraCatalogoPortaDadi(): void { //DA RIVEDEREEEEE!!!!!!
        $pagina = $this->estraiPaginaRichiesta();
        $filtri = $this->estraiFiltriPrezzo(); 

        $risultatoGrezzo = FPersistentManager::PMfindPortaDadi(
            filtri: $filtri,
            limit: self::RISULTATI_PER_PAGINA,
            offset: ($pagina - 1) * self::RISULTATI_PER_PAGINA
        );

        $totaleRisultati = $risultatoGrezzo['totale'] ?? 0;
        $totalePagine = $this->calcolaTotalePagine($totaleRisultati);
        $pagina = $this->clampPagina($pagina, $totalePagine);

        $prodottiMappati = $this->mappaProdottiPerCatalogo($risultatoGrezzo['risultati'] ?? []);

        $datiPagina = [
            'prodotti'       => $prodottiMappati,
            'filtri'         => $filtri,
            'pagina'         => $pagina,
            'totale_pagine'  => $totalePagine
        ];

        $datiLayout = $this->preparaDatiLayout('catalogo_portadadi', $datiPagina);
        ViewCatalogo::render($datiLayout);
    }

    /**
     * Mostra i risultati della ricerca
     * La barra di ricerca è un componente del layout globale,
     * ma una ricerca eseguita in questo modo (effettuata in una qualunque
     * delle pagine del sito), viene sempre gestita dal controller del catalogo
     */
    public function mostraRisultatiRicerca(): void {
        $query = UHTTPMethods::get('q');
        $pagina = $this->estraiPaginaRichiesta();

        if ($query === null || trim($query) === '') {
            //Se non c'è nessun termine di ricerca, reindirizziamo al catalogo principale dei giochi (DA DECIDERE!!!!!!!)
            header("Location: /catalogo/giochi-da-tavolo");
            exit();
        }

        $query = trim($query);

        //Cerca su tutti e 3 i tipi di prodotto
        $risultatoGrezzo = FPersistentManager::PMricercaProdotto(
            StringaDiRicerca:$query,
            limit: self::RISULTATI_PER_PAGINA,
            offset: ($pagina - 1) * self::RISULTATI_PER_PAGINA
        );


        $totaleRisultati = $risultatoGrezzo['totale'] ?? 0;
        $totalePagine = $this->calcolaTotalePagine($totaleRisultati);
        $pagina = $this->clampPagina($pagina, $totalePagine);

        $prodottiMappati = $this->mappaProdottiPerCatalogo($risultatoGrezzo['risultati'] ?? []);

        $datiPagina = [
            'prodotti' => $prodottiMappati,
            'pagina' => $pagina,
            'totale_pagine' => $totalePagine,
            'filtri' => ['q' => $query], //Conserviamo la query testuale per poterla mostrare a schermo o paginare
        ];

        $datiLayout = $this->preparaDatiLayout('ricerca', $datiPagina);
        ViewCatalogo::render($datiLayout);
        
    }


    //==========================================================================
    // METODI PRIVATI CONDIVISI
    //==========================================================================

    /**
     * Valida il numero di pagina richiesto.
     * Ritorna sempre un numero intero >= 1: se valido, ritorna il numero letto, altrimenti 1 (pagina 1)
     */
    private function estraiPaginaRichiesta(): int {
        $pagina = UHTTPMethods::get('pagina');
        if ($pagina === null || !is_numeric($pagina) || $pagina < 1) {
            return 1; //se la pagina non è valida per qualche motivo, reindirizziamo l'utente alla pagina 1 del catalogo
        }

        $pagina = (int) $pagina;
        return $pagina;
    }

    /**
     * Riporta $pagina entro il range valido [1, $totalePagine].
     * Utile per il caso limite in cui l'utente richieda una pagina 
     * oltre l'ultima disponibile (es. dopo che i filtri hanno ridotto i risultati).
     */
    private function clampPagina(int $pagina, int $totalePagine): int {
        if ($totalePagine === 0) {
            return 1;
        }
        return max(1, min($pagina, $totalePagine));
    }

    /**
     * Calcola il numero totale di pagine disponibili, 
     * dato il numero totale di risultati e il numero di risultati per pagina.
     */
    private function calcolaTotalePagine(int $totaleRisultati): int {
        return (int) ceil($totaleRisultati / self::RISULTATI_PER_PAGINA);
    }

    /**
     * Estrae e valida i filtri specifici per i giochi da tavolo 
     * (prezzo, disponibilità, categoria, espansioni, rating, lingua, 
     * età, difficoltà, numero giocatori, condizione danno).
     */
    private function estraiFiltriGiochi(): array {
        //TODO
        return [];
    }

    /**
     * Estrae e valida il filtro prezzo, condiviso tra Bustine e Porta dadi.
     */
    private function estraiFiltriPrezzo(): array {
        //TODO
        return [];
    }

    //==========================================================================
    // DA RIVEDERE
    //==========================================================================
    /**
     * Metodo helper centralizzato per convertire un array di oggetti Entity Prodotto
     * in array associativi piatti compatibili con il file catalogo.tpl di Marco.
     */
    private function mappaProdottiPerCatalogo(array $prodottiEntity): array {
        $arrayMappato = [];
        foreach ($prodottiEntity as $prod) {
            $prezzoObj = $prod->getPrezzo();
            $hasSconto = $prezzoObj->hasSconto();
            $prezzoOriginale = (float) $prezzoObj->getValore();

            $arrayMappato[] = [
                'id'                 => (int) $prod->getIdProdotto(),
                'nome'               => $prod->getNomeProdotto(),
                'immagine'           => $prod->getImgProdotto(),
                'valutazione_media'  => (float) $prod->getMediaValutazioni(), 
                'sconto'             => $hasSconto,
                'prezzo_originale'   => $prezzoOriginale,
                'prezzo_unitario'    => $hasSconto ? (float) $prezzoObj->calcolaPrezzoScontato() : $prezzoOriginale,
                'percentuale_sconto' => $hasSconto ? $prezzoObj->getSconto() : 0
            ];
        }
        return $arrayMappato;
    }


}