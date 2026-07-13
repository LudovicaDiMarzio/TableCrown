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
    private const RISULTATI_PER_PAGINA = 20; //valore di default
    private const ORDINAMENTO_VALIDI = ['prezzo-asc', 'prezzo-desc', 'popolarita', 'rating'];
    private const IN_EVIDENZA_VALIDI = ['sconti', 'novita'];

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

        $this->renderCatalogo('ricerca', $risultatoGrezzo, $pagina, ['q' => $query], $query);
    }


    //==========================================================================
    // METODI PRIVATI CONDIVISI
    //==========================================================================

    /**
     * Costruisce un array $datiPagina e delega il render a ViewCatalogo.
     * Tramite questo metodo centralizziamo la logica comune alle 4 pagine
     * pubbliche, per evitare di ripetere la stessa struttura di array in ognuna.
     */
    private function renderCatalogo(string $vista, array $risultatoGrezzo, int $pagina, array $filtri, ?string $searchQuery = null): void {
        $totaleRisultati = $risultatoGrezzo['totale'] ?? 0;
        $totalePagine = $this->calcolaTotalePagine($totaleRisultati);
        $pagina = $this->clampPagina($pagina, $totalePagine);

        $datiPagina = [
            'vista'          => $vista,
            'prodotti'       => $this->prodottiToArray($risultatoGrezzo['risultati'] ?? []),
            'total_results'  => $totaleRisultati,
            'pagination'     => ['current_page' => $pagina, 'total_pages' => $totalePagine],
            'search_query'   => $searchQuery,
            'filtri'         => $filtri,
        ];

        $datiLayout = $this->preparaDatiLayout($vista, $datiPagina);
        ViewCatalogo::render($datiLayout);
    }

    /**
     * Valida il numero di pagina richiesto.
     * Ritorna sempre un numero intero >= 1: se valido, ritorna il numero letto, altrimenti 1 (pagina 1)
     */
    private function estraiPaginaRichiesta(): int {
        $pagina = UHTTPMethods::get('pagina');
        if ($pagina === null || !is_numeric($pagina) || $pagina < 1) {
            return 1; //se la pagina non è valida per qualche motivo, reindirizziamo l'utente alla pagina 1 del catalogo
        }

        return (int) $pagina;
    }

    /**
     * Riporta $pagina entro il range valido [1, $totalePagine].
     * Utile per il caso limite in cui l'utente richieda una pagina 
     * oltre l'ultima disponibile 
     * (es. dopo che i filtri hanno ridotto i risultati, o modificando manualmente l'url).
     */
    private function clampPagina(int $pagina, int $totalePagine): int {
        if ($totalePagine === 0) {
            return 1;
        }
        return max(1, min($pagina, $totalePagine));
    }

    /**
     * Calcola il numero totale di pagine disponibili, 
     * dato il numero totale di risultati e il numero di risultati per pagina (fisso a RISULTATI_PER_PAGINA).
     */
    private function calcolaTotalePagine(int $totaleRisultati): int {
        return (int) ceil($totaleRisultati / self::RISULTATI_PER_PAGINA); //ceil per evitare errori di arrotondamento
    }

    /**
     * Legge un parametro GET che può arrivare come valore singolo,
     * array, o essere assente, normalizzandolo sempre in array.
     */
    private function estraiArrayDaRequest(string $chiave): array {
        $valore = UHTTPMethods::get($chiave);
        if ($valore === null) {
            return [];
        }
        return is_array($valore) ? $valore : [$valore];
    }

    /**
     * Filtro prezzo + disponibilità + in_evidenza + rating + ordinamento,
     * condiviso da tutte le pagine del catalogo (giochi, bustine, porta dadi).
     */
    private function estraiFiltriPrezzo(): array {
        //TODO: price_range_min e price_range_max andranno calcolati da FPersistentManager
        //in base ai prodotti realmente presenti nel catalogo/risultato filtrato.
        //Per ora metto dei dafault fissi 
        $priceRangeMin = 0.0; //DA CAMBIARE!!!!!!!
        $priceRangeMax = 200.0; //DA CAMBIARE!!!!!!!

        //Valori selezionati dall'utente sullo slider
        $priceMinRaw = UHTTPMethods::get('price_min');  
        $priceMaxRaw = UHTTPMethods::get('price_max');

        $ratingMinRaw = UHTTPMethods::get('rating_min');
        $ordinamentoRaw = UHTTPMethods::get('ordinamento');

        return [
            'price_min'          => is_numeric($priceMinRaw) ? (float) $priceMinRaw : $priceRangeMin,
            'price_max'          => is_numeric($priceMaxRaw) ? (float) $priceMaxRaw : $priceRangeMax,
            'price_range_min'    => $priceRangeMin,
            'price_range_max'    => $priceRangeMax,
            'disponibilita'      => $this->validaValoriEnum($this->estraiArrayDaRequest('disponibilita'), DisponibilitaProdotto::class),
            'in_evidenza_filtro' => array_values(array_intersect($this->estraiArrayDaRequest('in_evidenza_filtro'), self::IN_EVIDENZA_VALIDI)),
            'rating_min'         => is_numeric($ratingMinRaw) ? (float) $ratingMinRaw : 0.0,
            'ordinamento'        => in_array($ordinamentoRaw, self::ORDINAMENTO_VALIDI, true) ? $ordinamentoRaw : null,
        ];
    }

    /**
     * Estende i filtri comuni con quelli specifici dei giochi da tavolo.
     */
    private function estraiFiltriGiochi(): array {
        $filtri = $this->estraiFiltriPrezzo();

        $ageMinRaw = UHTTPMethods::get('age_min');
        $playersMinRaw = UHTTPMethods::get('players_min');

        $filtri['categorie_enum'] = $this->enumToOptions(Categoria::cases(), ['gdr' => 'GDR']); 
        $filtri['categoria_selected'] = $this->validaValoriEnum($this->estraiArrayDaRequest('categoria_selected'), Categoria::class);

        //Nota: per le espansioni introduciamo un singolo filtro.
        //Se true, mostra giochi base + espansioni, se false solo giochi base.
        //Di default è true (checkbox checkata) per non nascondere contenuti a chi non applica filtri.
        $filtri['mostra_espansioni'] = UHTTPMethods::get('mostra_espansioni') !== '0';

        $filtri['age_min'] = is_numeric($ageMinRaw) ? (int) $ageMinRaw : null;
        $filtri['difficolta'] = $this->validaValoriEnum($this->estraiArrayDaRequest('difficolta'), DifficoltaGioco::class);
        $filtri['players_min'] = is_numeric($playersMinRaw) ? (int) $playersMinRaw : null;

        //per lingue_enum non uso enumToOptions perché il nome dei cases non è derivabile automaticamente dal value corrispondente che è un codice (es. 'EN', 'IT', ecc.)
        $filtri['lingue_enum'] = array_map(fn($c) => ['value' => $c->value, 'label' => $c->name], LinguaGioco::cases());
        $filtri['lingua_selected'] = $this->validaValoriEnum($this->estraiArrayDaRequest('lingua_selected'), LinguaGioco::class);

        $filtri['danno_enum'] = $this->enumToOptions(LivelloDannoGiochi::cases());
        $filtri['danno_selected'] = $this->validaValoriEnum($this->estraiArrayDaRequest('danno_selected'), LivelloDannoGiochi::class);

        return $filtri;
    }

    //MANCA IL METODO GETBREADCRUMBS!!!!!!!


}