<?php
namespace TableCrown\Control;

use TableCrown\Foundation\FPersistentManager;
use TableCrown\Utility\UHTTPMethods;

class CCatalogo extends BaseController {
    private const RISULTATI_PER_PAGINA = 20; //valore di default

    //==========================================================================
    // METODI PUBBLICI - uno per ciascuna sottoRoute del catalogo.
    //==========================================================================

    public function mostraCatalogoGiochi(): void {
        //Per le azioni condivise fra i tre metodi, implementiamo dei metodi privati, in modo da non ripetere il codice ogni volta.
        $pagina = $this->estraiPaginaRichiesta();
        $filtri = $this->estraiFiltriGiochi(); //sarà [] se non ci sono filtri

        //TODO: l'array dei risultati deve essere di questo tipo $risultato = ['risultati' => [], 'totaleRisultati' => 0];
        /* 
        $risultato = FPersistentManager::findGiochi(  //SE $filtri E' VUOTO, RESTITUISCE TUTTI I GIOCHI DA TAVOLO
            $filtri,
            offset: ($pagina - 1) * self::RISULTATI_PER_PAGINA,
            limit: self::RISULTATI_PER_PAGINA
            );
 */
        
/* 
        $totalePagine = $this->calcolaTotalePagine($risultato['totaleRisultati']);
        $pagina = $this->clampPagina($pagina, $totalePagine);
         */


/* 
        AGGIUNGERE CHIAMATA ALLA VIEW???
        $this->render('catalogo_giochi', [
            'giochi' => $risultato['risultati'],
            'paginaCorrente' => $pagina,
            'totalePagine' => $totalePagine,
        ]);
 */
    }

    public function mostraCatalogoBustine(): void {
        //TODO
    }

    public function mostraCatalogoPortaDadi(): void {
        //TODO
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
            //Se non c'è nessun termine di ricerca:
            //TODO: decidere il comportamento (mostrare la 
            //prima pagina dei giochi da tavolo? Reindirizzare alla home?)

        }

        $query = trim($query);
/*      //TODO: Implementare la ricerca nel database, con paginazione.
        //Cerca su tutti e 3 i tipi di prodotto
        $risultati = FPersistentManager::findProdottiBySearchQuery(
            $query,
            offset: ($pagina - 1) * self::RISULTATI_PER_PAGINA,
            limit: self::RISULTATI_PER_PAGINA
        );
 */
        $risultati = ['risultati' => [], 'totaleRisultati' => 0]; //DA RIMUOVERE QUANDO TOLGO LA PARTE COMMENTATA

        $totalePagine = $this->calcolaTotalePagine($risultati['totaleRisultati']);
        $pagina = $this->clampPagina($pagina, $totalePagine);

        //TODO: Chiamata alla view
/* 
        $this->render('risultati_ricerca', [
            'prodotti' => $risultati['risultati'],
            'terminecercato' => $query,
            'paginaCorrente' => $pagina,
            'totalePagine' => $totalePagine,
        ]);
         */
    }


    //==========================================================================
    //METODI PRIVATI CONDIVISI
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


}