<?php
namespace TableCrown\Control;

use TableCrown\Utility\UHTTPMethods;
use TableCrown\Utility\UFlashMessage;
use TableCrown\Entity\Enumerativi\Valuta;
use TableCrown\Entity\Enumerativi\LivelloDannoGiochi;
use TableCrown\Entity\Enumerativi\DisponibilitaProdotto;
use TableCrown\Entity\Enumerativi\LinguaGioco;
use TableCrown\Entity\Enumerativi\DifficoltaGioco;
use TableCrown\Entity\Enumerativi\Categoria;
use TableCrown\Entity\EGiocoDaTavolo;
use TableCrown\Entity\EBustine;
use TableCrown\Entity\EPortaDadi;
use TableCrown\Entity\EPrezzo;
use TableCrown\Entity\EProdotto;
use TableCrown\Foundation\FPersistentManager;
use TableCrown\Presentation\Views\ViewGestore;
use InvalidArgumentException;

class CGestore extends BaseController {

    public function __construct() {
        parent::__construct();

        //Protezione totale all'ingresso: solo il gestore può accedere a questi metodi
        $this->requireRole('gestore');
    }

    //==========================================================================
    // RICHIESTE GET - VISUALIZZAZIONE
    //==========================================================================

    /**
     * Mostra la dashboard principale del gestore con le statistiche quantitative.
     * URL: GET /gestore/dashboard
     */
    public function mostraDashboardGestore(): void {
        //Recupero dati statistici
        $ordiniTotali = FPersistentManager::PMcontaOrdiniTotali(); //TODO: metodo da implementare
        $venditeTotali = FPersistentManager::PMcontaVenditeTotali(); //TODO: metodo da implementare

        $prossiEventiGrezzi = FPersistentManager::PMgetProssiEventi(5); //TODO: metodo da implementare
        $prossimiEventi = $this->eventiToArray($prossiEventiGrezzi);

        $datiPagina = [
            'vista' => 'gestore_dashboard',
            'ordiniTotali' => $ordiniTotali,
            'venditeTotali' => $venditeTotali,
            'prossimiEventi' => $prossimiEventi,
        ];

        $datiLayout = $this->preparaDatiLayout('gestore_dashboard', $datiPagina);
        ViewGestore::mostraDashboard($datiLayout);
    }


    /**
     * Mostra il catalogo dei giochi da tavolo specifico per il gestore.
     * URL: GET /gestore/catalogo/giochi-da-tavolo
     */
    public function mostraCatalogoGiochiGestore(): void {
        $pagina = $this->estraiPaginaRichiesta();
        $filtri = $this->estraiFiltriGiochi(); //sarà [] se non ci sono filtri

        $risultatoGrezzo = FPersistentManager::PMfindGiochi(
            filtri: $filtri,
            limit: self::RISULTATI_PER_PAGINA,
            offset: ($pagina - 1) * self::RISULTATI_PER_PAGINA
        );

        $this->renderCatalogo('gestore_catalogo_giochi', $risultatoGrezzo, $pagina, $filtri, modalita: 'gestore');
    }

    /**
     * Mostra il catalogo delle bustine specifico per il gestore.
     * URL: GET /gestore/catalogo/bustine
     */
    public function mostraCatalogoBustineGestore(): void {
        $pagina = $this->estraiPaginaRichiesta();
        $filtri = $this->estraiFiltriPrezzo();

        $risultatoGrezzo = FPersistentManager::PMfindBustine(
            filtri: $filtri,
            limit: self::RISULTATI_PER_PAGINA,
            offset: ($pagina - 1) * self::RISULTATI_PER_PAGINA
        );

        $this->renderCatalogo('gestore_catalogo_bustine', $risultatoGrezzo, $pagina, $filtri, modalita: 'gestore');
    }

    /**
     * Mostra il catalogo delle porte dadi specifico per il gestore.
     * URL: GET /gestore/catalogo/porta-dadi
     */
    public function mostraCatalogoPortaDadiGestore(): void {
        $pagina = $this->estraiPaginaRichiesta();
        $filtri = $this->estraiFiltriPrezzo();

        $risultatoGrezzo = FPersistentManager::PMfindPortaDadi(
            filtri: $filtri,
            limit: self::RISULTATI_PER_PAGINA,
            offset: ($pagina - 1) * self::RISULTATI_PER_PAGINA
        );

        $this->renderCatalogo('gestore_catalogo_portadadi', $risultatoGrezzo, $pagina, $filtri, modalita: 'gestore');
    }

    /**
     * Mostra i risultati della ricerca lato gestore.
     */
    public function mostraRisultatiRicercaProdottiGestore(): void {
        $query = UHTTPMethods::get('q');
        $pagina = $this->estraiPaginaRichiesta();

        if ($query === null || trim($query) === '') {
            //Se non c'è nessun termine di ricerca, reindirizziamo alla pagina precedente. Fallback: la home
            header("Location: " . UHTTPMethods::getReferer(BASE_URL . '/gestore/dashboard'));
            exit();
        }

        $query = trim($query);

        //Cerca solo giochi da tavolo
        $risultatoGrezzo = FPersistentManager::PMricercaProdotto(
            StringaDiRicerca:$query,
            limit: self::RISULTATI_PER_PAGINA,
            offset: ($pagina - 1) * self::RISULTATI_PER_PAGINA
        );

        $this->renderCatalogo('gestore_risultati_ricerca', $risultatoGrezzo, $pagina, ['q' => $query], $query, modalita: 'gestore');
    }


    //==========================================================================
    // AZIONI CRUD SU PRODOTTI
    //==========================================================================

    /**
     * Crea un nuovo gioco da tavolo a partire dai dati del form.
     * Il wizard a 3 pagine è gestito client-side da Presentation: qui 
     * arriva un'unica POST con tutti i dati già uniti, solo al click su "Pubblica".
     * URL: POST /gestore/catalogo/giochi-da-tavolo/nuovo
     */
    public function creaGiocoDaTavolo(): void {
        try { 
            // --- PAGINA 1: dati base ---
            $nomeProdotto = UHTTPMethods::postString('nomeProdotto', maxLength: 255);
            $descrizioneProdotto = UHTTPMethods::postString('descrizioneProdotto');
            $categoria = $this->validaValoriEnum(UHTTPMethods::postArray('categoria', required: true), Categoria::class);
            //filtra eventuali righe vuote lasciate dall'input dinamico "aggiungi componente" di Presentation
            $componenti = array_values(array_filter(array_map('trim', UHTTPMethods::postArray('componenti', required: true))));
            $imgProdotto = $this->estraiImmagineProdotto();

            // --- PAGINA 2: prezzo, magazzino, stato/danno ---
            $prezzo = $this->costruisciPrezzo();
            $quantita = UHTTPMethods::postInt('quantita', min: 0);
            $disponibilita = $this->postEnum('disponibilita', DisponibilitaProdotto::class);
            [$danno, $descrizioneDanno] = $this->gestisciDanno();

            // --- PAGINA 3: caratteristiche di gioco ---
            $difficolta = $this->postEnum('difficolta', DifficoltaGioco::class);
            $lingua = $this->postEnum('lingua', LinguaGioco::class);
            $numeroGiocatoriMin = UHTTPMethods::postInt('numeroGiocatoriMin', min: 1);
            $numeroGiocatoriMax = UHTTPMethods::postInt('numeroGiocatoriMax', min: 1);
            $etaMinima = UHTTPMethods::postInt('etaMinima', min: 1);
            $durataMedia = UHTTPMethods::postInt('durataMedia', min: 1);

            $giocoBaseId = UHTTPMethods::post('giocoBaseId'); //presente solo se il gioco è un'espansione
            $giocoBase = ($giocoBaseId !== null && $giocoBaseId !== '')
                ? FPersistentManager::PMgetObjOnAttribute(EGiocoDaTavolo::class, 'idProdotto', $giocoBaseId)
                : null;

            $gioco = new EGiocoDaTavolo( //named arguments invece di notazione posizionale per non sbagliare
                nomeProdotto: $nomeProdotto,
                descrizioneProdotto: $descrizioneProdotto,
                disponibilitaProdotto: $disponibilita,
                quantita: $quantita,
                categoria: $categoria,
                componenti: $componenti,
                difficolta: $difficolta,
                lingua: $lingua,
                imgProdotto: $imgProdotto,
                prezzo: $prezzo,
                giocoBase: $giocoBase,
                numeroGiocatoriMin: $numeroGiocatoriMin,
                numeroGiocatoriMax: $numeroGiocatoriMax,
                etaMinima: $etaMinima,
                durataMedia: $durataMedia,
            );

            //Il danno va assegnato dopo la creazione
            if ($danno !== null) {
                $gioco->aggiungiDanno($danno, $descrizioneDanno);
            }

            FPersistentManager::PMsaveObj($gioco);

            UFlashMessage::addMessage('success', 'Prodotto pubblicato con successo!');
            header('Location: ' . BASE_URL . '/gestore/catalogo/giochi-da-tavolo');
            exit();

        } catch (\Exception $e) {
            UFlashMessage::addMessage('danger', $e->getMessage());
            header('Location: ' . UHTTPMethods::getReferer(BASE_URL . '/gestore/catalogo/giochi-da-tavolo'));
            exit();
        }
    }

    /**
     * URL: POST /gestore/catalogo/bustine/nuovo
     */
    public function creaBustine(): void {
        try {
            $nomeProdotto = UHTTPMethods::postString('nomeProdotto', maxLength: 255);
            $descrizioneProdotto = UHTTPMethods::postString('descrizioneProdotto');
            $imgProdotto = $this->estraiImmagineProdotto();
            $prezzo = $this->costruisciPrezzo();
            $quantita = UHTTPMethods::postInt('quantita', min: 0);
            $disponibilita = $this->postEnum('disponibilita', DisponibilitaProdotto::class);

            $bustina = new EBustine(
                $nomeProdotto,
                $descrizioneProdotto,
                $disponibilita,
                $quantita,
                $imgProdotto,
                $prezzo
            );

            FPersistentManager::PMsaveObj($bustina);

            UFlashMessage::addMessage('success', 'Prodotto pubblicato con successo!');
            header('Location: ' . BASE_URL . '/gestore/catalogo/bustine');
            exit();

        } catch (\Exception $e) {
            UFlashMessage::addMessage('danger', $e->getMessage());
            header('Location: ' . UHTTPMethods::getReferer(BASE_URL . '/gestore/catalogo/bustine'));
            exit();
        }
    }

    /**
     * URL: POST /gestore/catalogo/porta-dadi/nuovo
     */
    public function creaPortaDadi(): void {
        try {
            $nomeProdotto = UHTTPMethods::postString('nomeProdotto', maxLength: 255);
            $descrizioneProdotto = UHTTPMethods::postString('descrizioneProdotto');
            $imgProdotto = $this->estraiImmagineProdotto();
            $prezzo = $this->costruisciPrezzo();
            $quantita = UHTTPMethods::postInt('quantita', min: 0);
            $disponibilita = $this->postEnum('disponibilita', DisponibilitaProdotto::class);

            $portaDadi = new EPortaDadi(
                $nomeProdotto,
                $descrizioneProdotto,
                $disponibilita,
                $quantita,
                $imgProdotto,
                $prezzo
            );

            FPersistentManager::PMsaveObj($portaDadi);

            UFlashMessage::addMessage('success', 'Prodotto pubblicato con successo!');
            header('Location: ' . BASE_URL . '/gestore/catalogo/porta-dadi');
            exit();

        } catch (\Exception $e) {
            UFlashMessage::addMessage('danger', $e->getMessage());
            header('Location: ' . UHTTPMethods::getReferer(BASE_URL . '/gestore/catalogo/porta-dadi'));
            exit();
        }
    }

    /**
     * Rimuove (soft-delete) un prodotto dal catalogo.
     * Non cancella il record dal DB: EProdotto::rimuoviProdotto() imposta
     * solo la disponibilità a "Non disponibile", per mantenere l'integrità
     * referenziale con le recensioni collegate.
     * URL: POST /gestore/catalogo/prodotto/elimina
     */
    public function eliminaProdottoGestore(): void {
        $isAjax = UHTTPMethods::isAjax();
        try {
            $idProdotto = UHTTPMethods::postInt('id_prodotto');

            $prodotto = FPersistentManager::PMgetObjOnAttribute(EProdotto::class, 'idProdotto', $idProdotto);
            if ($prodotto === null) {
                throw new \InvalidArgumentException("Il prodotto selezionato non esiste.");
            }

            $prodotto->rimuoviProdotto();

            $salvato = FPersistentManager::PMsaveObj($prodotto);

            if (!$salvato) {
                throw new \RuntimeException("Si è verificato un errore durante la rimozione del prodotto.");
            }

            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'ok', 'message' => 'Prodotto rimosso con successo!']);
                exit();
            }

            UFlashMessage::addMessage('success', 'Prodotto rimosso con successo!');
            header('Location: ' . UHTTPMethods::getReferer(BASE_URL . '/gestore/dashboard'));
            exit();

        } catch (\Exception $e) {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
                exit();
            }

            UFlashMessage::addMessage('danger', $e->getMessage());
            header('Location: ' . UHTTPMethods::getReferer(BASE_URL . '/gestore/dashboard'));
            exit();
        }
    }

    /**
     * Aggiorna la quantità in magazzino.
     * Nota: EProdotto::aggiornaQuantita() imposta un valore assoluto, non una
     * differenza; quindi calcoliamo qui la nuova quantità sommando il delta ricevuto
     * a quella attuale, prima di passarla al metodo di dominio.
     * URL: POST /gestore/prodotti/quantita
     */
    public function aggiornaQuantitaProdottoGestore(): void {
        $isAjax = UHTTPMethods::isAjax();
        try {
            $idProdotto = UHTTPMethods::postInt('id_prodotto');
            $deltaQuantita = UHTTPMethods::postInt('delta_quantita');

            $prodotto = FPersistentManager::PMgetObjOnAttribute(EProdotto::class, 'idProdotto', $idProdotto);
            if ($prodotto === null) {
                throw new \InvalidArgumentException("Il prodotto selezionato non esiste.");
            }

            $nuovaQuantita = $prodotto->getQuantita() + $deltaQuantita;
            //aggiornaQuantita() lancerebbe comunque un'eccezione se negativa, ma
            //controllarlo qui permette un messaggio più chiaro per l'utente
            if ($nuovaQuantita < 0) {
                throw new \InvalidArgumentException("La quantità non può essere negativa.");
            }

            $prodotto->aggiornaQuantita($nuovaQuantita); //aggiorna anche la disponibiltà in automatico, se serve

            $salvato = FPersistentManager::PMsaveObj($prodotto);

            if (!$salvato) {
                throw new \RuntimeException("Si è verificato un errore durante l'aggiornamento della quantità.");
            }

            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'ok',
                    'quantita' => $prodotto->getQuantita(),
                    'disponibilita' => $prodotto->getDisponibilitaProdotto()->value,
                ]);
                exit();
            }

            UFlashMessage::addMessage('success', 'La quantità del prodotto è stata aggiornata con successo!');
            header('Location: ' . UHTTPMethods::getReferer(BASE_URL . '/gestore/dashboard'));
            exit();

        } catch (\Exception $e) {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
                exit();
            }

            UFlashMessage::addMessage('danger', $e->getMessage());
            header('Location: ' . UHTTPMethods::getReferer(BASE_URL . '/gestore/dashboard'));
            exit();
        }
    }
    
    /**
     * Modifica un prodotto: 
     * in particolare, si può modificare lo sconto promozionale (modificarlo o rimuoverlo)
     * oppure applicare un danno (solo per i giochi da tavolo).
     * URL: POST /gestore/prodotti/modifica
     */
    public function modificaProdottoGestore(): void {
        $isAjax = UHTTPMethods::isAjax();
        try {
            $idProdotto = UHTTPMethods::postInt('id_prodotto');
            $prodotto = FPersistentManager::PMgetObjOnAttribute(EProdotto::class, 'idProdotto', $idProdotto);
            if ($prodotto === null) {
                throw new \InvalidArgumentException("Il prodotto selezionato non esiste.");
            }

            // --- Sconto promozionale, con scadenza opzionale ---
            if (UHTTPMethods::postBool('modificaSconto')) {
                $prezzo = $prodotto->getPrezzo();
                if ($prezzo === null) {
                    throw new \InvalidArgumentException("Il prodotto non ha un prezzo definito. Impossibile applicare uno sconto.");
                }

                $valoreSconto = UHTTPMethods::postFloat('valoreSconto', min: 0, max: 100);
                $scadenzaRaw = UHTTPMethods::post('scadenzaOfferta'); //opzionale
                $scadenza = ($scadenzaRaw !== null && trim($scadenzaRaw) !== '') 
                    ? UHTTPMethods::postDate('scadenzaOfferta', 'Y-m-d')
                    : null; //nessuna scadenza => sconto permanente

                $prezzo->aggiornaSconto($valoreSconto, $scadenza);
            }

            if (UHTTPMethods::postBool('rimuoviSconto')) {
                $prodotto->getPrezzo()?->rimuoviSconto();
            }

            // --- Danno, solo per i giochi da tavolo ---
            if ($prodotto instanceof EGiocoDaTavolo && UHTTPMethods::postBool('danneggiato')) {
                $livello = $this->postEnum('livelloDanno', LivelloDannoGiochi::class);
                $descrizioneDanno = UHTTPMethods::postString('descrizioneDanno', maxLength: 500);
                $danno = FPersistentManager::PMfindDannoByLivello($livello); //TODO: metodo da implementare
                $prodotto->aggiungiDanno($danno, $descrizioneDanno);
            }

            $salvato = FPersistentManager::PMsaveObj($prodotto);

            if (!$salvato) {
                throw new \RuntimeException("Si è verificato un errore durante il salvataggio delle modifiche.");
            }

            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'ok', 'message' => 'Prodotto aggiornato con successo!']);
                exit();
            }

            UFlashMessage::addMessage('success', 'Prodotto aggiornato con successo!');
            header('Location: ' . UHTTPMethods::getReferer(BASE_URL . '/gestore/dashboard'));
            exit();

        } catch (\Exception $e) {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
                exit();
            }

            UFlashMessage::addMessage('danger', $e->getMessage());
            header('Location: ' . UHTTPMethods::getReferer(BASE_URL . '/gestore/dashboard'));
            exit();
        }
    }

    //==========================================================================
    // HELPER PRIVATI CONDIVISI
    //==========================================================================

    /**
     * Costruisce l'oggetto EPrezzo a partire dai dati POST (di pagina 2).
     * Lo sconto qui è quello "manuale/promozionale" scelto dal gestore,
     * separato da quello automatico da danno (che viene eventualmente applicato
     * più avanti, in cascata, da EGiocoDaTavolo::aggiungiDanno()).
     */
    private function costruisciPrezzo(): EPrezzo { 
        $valore = UHTTPMethods::postFloat('prezzoListino', min: 0);
        $valuta = $this->postEnum('valuta', Valuta::class);

        $prezzo = new EPrezzo($valore, $valuta); //sconto iniziale a 0 di default

        $scontoAttivo = UHTTPMethods::postBool('scontoAttivo'); //checkbox "si/no"
        if ($scontoAttivo) {
            $valoreSconto = UHTTPMethods::postFloat('valoreSconto', min: 0, max: 100);
            //scadenza facoltativa: se il campo non è compilato, lo sconto sarà permanente
            $scadenzaRaw = UHTTPMethods::post('scadenzaOfferta'); //opzionale
            $scadenza = ($scadenzaRaw !== null && trim($scadenzaRaw) !== '') 
                ? UHTTPMethods::postDate('scadenzaOfferta', 'Y-m-d')
                : null;
            $prezzo->aggiornaSconto($valoreSconto, $scadenza);
        }

        return $prezzo;
    }

    /**
     * Legge i dati della sezione "Danneggiato" (pagina 2).
     * Restituisce [null, null] se la checkbox non è spuntata.
     * Il livello di danno selezionato NON crea un nuovo EDanno: recupera
     * il record già esistente e condiviso per quel livello (sconto fisso)
     */
    private function gestisciDanno(): array { 
        if (!UHTTPMethods::postBool('danneggiato')) {
            return [null, null];
        }

        $livello = $this->postEnum('livelloDanno', LivelloDannoGiochi::class);
        $descrizioneDanno = UHTTPMethods::postString('descrizioneDanno', maxLength: 500);

        //Recuperiamo il record EDanno già esistente e condiviso per quel livello (sconto fisso)
        //TODO: metodo del pm da implementare
        $danno = FPersistentManager::PMfindDannoByLivello($livello);

        return [$danno, $descrizioneDanno];
    }

    /**
     * Legge un valore enum-backed dal form POST e lo valid.
     * Uniforma il comportamento di errore a InvalidArgumentException:
     * Enum::from() lancerebbe un ValueError, che appartiene ad una gerarchia
     * di eccezioni diversa (\Error, non \Exception) e sfuggirebbe al catch
     * usato per le altre validazioni di questo controller.
     */
    private function postEnum(string $key, string $enumClass): mixed {
        $value = UHTTPMethods::postString($key);
        $case = $enumClass::tryFrom($value); //tryfrom() restituisce null se non è valido
        if ($case === null) {
            throw new InvalidArgumentException("Il campo '$key' non è valido.");
        }

        return $case;
    }


    /**
 * Costruisce i breadcrumb per le pagine del pannello gestore.
 * Tutte le pagine condividono la stessa radice (Home > Dashboard Gestore);
 * $currentPage aggiunge l'eventuale terzo livello specifico della pagina.
 */
protected function getBreadcrumbs(string $currentPage = ''): array {
    $breadcrumbs = [
        ['label' => 'Home', 'url' => BASE_URL . '/'],
        ['label' => 'Dashboard Gestore', 'url' => BASE_URL . '/gestore/dashboard'],
    ];

    return match ($currentPage) { //DECIDERE SE USARE match COME IN CAmministratore O switch COME IN CCatalogo
        'gestore_dashboard' => $breadcrumbs,
        'gestore_catalogo_giochi' => array_merge($breadcrumbs, [
            ['label' => 'Giochi da tavolo', 'url' => BASE_URL . '/gestore/catalogo/giochi-da-tavolo'],
        ]),
        'gestore_catalogo_bustine' => array_merge($breadcrumbs, [
            ['label' => 'Bustine', 'url' => BASE_URL . '/gestore/catalogo/bustine'],
        ]),
        'gestore_catalogo_portadadi' => array_merge($breadcrumbs, [
            ['label' => 'Porta Dadi', 'url' => BASE_URL . '/gestore/catalogo/porta-dadi'],
        ]),
        'gestore_risultati_ricerca' => array_merge($breadcrumbs, [
            ['label' => 'Risultati ricerca', 'url' => BASE_URL . '/gestore/ricerca'],
        ]),
        default => $breadcrumbs,
    };
}


}