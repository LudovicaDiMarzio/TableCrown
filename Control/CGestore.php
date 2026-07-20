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
use TableCrown\Entity\Enumerativi\StatoEvento;
use TableCrown\Entity\EGiocoDaTavolo;
use TableCrown\Entity\EBustine;
use TableCrown\Entity\EPortaDadi;
use TableCrown\Entity\EPrezzo;
use TableCrown\Entity\EProdotto;
use TableCrown\Entity\EEvento;
use TableCrown\Entity\ESerata;
use TableCrown\Entity\ETorneo;
use TableCrown\Entity\EChallenge;
use TableCrown\Entity\EDanno;
use TableCrown\Foundation\FPersistentManager;
use TableCrown\Presentation\Views\ViewGestore;
use TableCrown\Presentation\Views\ViewEventi;
use InvalidArgumentException;
use RuntimeException;

class CGestore extends BaseController {

    private ?int $idEventoCorrente = null;
    private ?string $nomeEventoCorrente = null;
    private ?string $tipoEventoCorrente = null; // 'serata' | 'torneo' | 'challenge'

    public function __construct() {
        parent::__construct();

        //Protezione totale all'ingresso: solo il gestore può accedere a questi metodi
        $this->requireRole('gestore');
    }

    //==========================================================================
    // RICHIESTE GET - VISUALIZZAZIONE
    //==========================================================================

    // PRODOTTI

    /**
     * Mostra la dashboard principale del gestore con le statistiche quantitative.
     * URL: GET /gestore/dashboard
     */
    public function mostraDashboardGestore(): void {
        //Recupero dati statistici
        $ordiniTotali = FPersistentManager::PMcontaOrdiniTotali(); //TODO: metodo da implementare
        $venditeTotali = FPersistentManager::PMcontaVenditeTotali(); //TODO: metodo da implementare

        $prossiEventiGrezzi = FPersistentManager::PMgetProssimiEventi(5); //TODO: metodo da implementare
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
            $filtri = $this->estraiFiltriGiochi(); //sarà [] se non ci sono filtri
            $risultatoGrezzo = FPersistentManager::PMfindGiochi(
                filtri: $filtri,
                limit: self::RISULTATI_PER_PAGINA,
                offset: ($pagina - 1) * self::RISULTATI_PER_PAGINA
            );
            $filtri = $this->completaFiltriPrezzo($filtri, $risultatoGrezzo);
        }

        $this->renderCatalogo('gestore_catalogo_giochi', $risultatoGrezzo, $pagina, $filtri, $query, modalita: 'gestore');
    }

    /**
     * Mostra il catalogo delle bustine specifico per il gestore.
     * URL: GET /gestore/catalogo/bustine
     */
    public function mostraCatalogoBustineGestore(): void {
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

        $this->renderCatalogo('gestore_catalogo_bustine', $risultatoGrezzo, $pagina, $filtri, $query, modalita: 'gestore');
    }

    /**
     * Mostra il catalogo delle porte dadi specifico per il gestore.
     * URL: GET /gestore/catalogo/porta-dadi
     */
    public function mostraCatalogoPortaDadiGestore(): void {
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

        $this->renderCatalogo('gestore_catalogo_portadadi', $risultatoGrezzo, $pagina, $filtri, $query, modalita: 'gestore');
    }


    // EVENTI

    /**
     * URL: GET /gestore/eventi/serate
     */
    public function mostraListaSerateGestore(): void {
        $filtroData = $this->estraiFiltroData();
        $serate = FPersistentManager::PMfindSerate($filtroData);
        $this->renderListaEventi('gestore_eventi_serate', $serate, $filtroData, modalita: 'gestore');
    }

    /**
     * URL: GET /gestore/eventi/tornei
     */
    public function mostraListaTorneiGestore(): void {
        $filtroData = $this->estraiFiltroData();
        $tornei = FPersistentManager::PMfindTornei($filtroData);
        $this->renderListaEventi('gestore_eventi_tornei', $tornei, $filtroData, modalita: 'gestore');
    }

    /**
     * URL: GET /gestore/eventi/challenge
     */
    public function mostraListaChallengeGestore(): void {
        $filtroData = $this->estraiFiltroData();
        $challenge = FPersistentManager::PMfindChallenge($filtroData);
        $this->renderListaEventi('gestore_eventi_challenge', $challenge, $filtroData, modalita: 'gestore');
    }


    /**
     * Mostra il dettaglio di un evento lato gestore. Stessa struttura dati della
     * vista utente (riusa costruisceDatiVistaEvento()), ma con le informazioni
     * aggiuntive utili al gestore per decidere se pubblicare la classifica.
     * URL: GET /gestore/eventi/dettaglio?id=X
     */
    public function mostraDettaglioEventoGestore(): void {
        $idEventoRaw = UHTTPMethods::get('id');
        if ($idEventoRaw === null || !is_numeric($idEventoRaw)) {
            UFlashMessage::addMessage('danger', 'ID evento non valido.');
            header('Location: ' . BASE_URL . '/gestore/dashboard');
            exit();
        }

        $idEvento = (int) $idEventoRaw;
        $evento = FPersistentManager::PMgetObjOnAttribute(EEvento::class, 'idEvento', $idEvento);

        if ($evento === null) {
            UFlashMessage::addMessage('danger', 'L\'evento richiesto non esiste.');
            header('Location: ' . UHTTPMethods::getReferer(BASE_URL . '/gestore/dashboard'));
            exit();
        }

        //(per getBreadcrumbs())
        $this->idEventoCorrente = $evento->getIdEvento();
        $this->nomeEventoCorrente = $evento->getNomeEvento();
        $this->tipoEventoCorrente = match (true) {
            $evento instanceof ESerata => 'serata',
            $evento instanceof ETorneo => 'torneo',
            $evento instanceof EChallenge => 'challenge',
        };

        $datiPagina = $this->costruisciDatiVistaEvento($evento, modalita: 'gestore');
        $datiLayout = $this->preparaDatiLayout($datiPagina['vista'], $datiPagina);

        //Chiamata alla View
        ViewEventi::mostraDettaglioEvento($datiLayout); //TODO: nome del metodo da confermare
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
            $imgProdotto = $this->estraiImmagine('img_prodotto');

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
            $imgProdotto = $this->estraiImmagine('img_prodotto');
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
            $imgProdotto = $this->estraiImmagine('img_prodotto');
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
                $danno = FPersistentManager::PMgetObjOnAttribute(EDanno::class, 'livelloDanno', $livello);
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
    // AZIONI CRUD SU EVENTI
    //==========================================================================

    /**
     * URL: POST /gestore/eventi/serate/nuovo
     */
    public function creaSerata(): void {
        try {
            $nomeEvento = UHTTPMethods::postString('nomeEvento', maxLength: 255);
            $descrizioneEvento = UHTTPMethods::postString('descrizioneEvento');
            $dataInizio = UHTTPMethods::postDate('dataInizio', 'Y-m-d H:i:s');
            $maxPartecipanti = UHTTPMethods::postInt('maxPartecipanti', min: 1);
            $tipoSerata = UHTTPMethods::postString('tipoSerata');

            $fileImg = UHTTPMethods::postFile('imgEvento'); //qui è obbligatoria l'immagine
            $imgEvento = file_get_contents($fileImg['tmp_name']);

            $serata = new ESerata($nomeEvento, $imgEvento, $descrizioneEvento, $dataInizio, $maxPartecipanti, $tipoSerata);

            $salvato = FPersistentManager::PMsaveObj($serata);

            if (!$salvato) {
                throw new \RuntimeException("Si è verificato un errore durante la creazione della serata.");
            }

            UFlashMessage::addMessage('success', 'Serata pubblicata con successo!');
            header('Location: ' . BASE_URL . '/gestore/eventi/serate');
            exit();

        } catch (\Exception $e) {
            UFlashMessage::addMessage('danger', $e->getMessage());
            header('Location: ' . UHTTPMethods::getReferer(BASE_URL . '/gestore/eventi/serate'));
            exit();
        }
    }

    /**
     * URL: POST /gestore/eventi/tornei/nuovo
     */
    public function creaTorneo(): void {
        try {
            $nomeEvento = UHTTPMethods::postString('nomeEvento', maxLength: 255);
            $descrizioneEvento = UHTTPMethods::postString('descrizioneEvento');
            $dataInizio = UHTTPMethods::postDate('dataInizio', 'Y-m-d H:i:s');
            $maxPartecipanti = UHTTPMethods::postInt('maxPartecipanti', min: 1);

            $fileImg = UHTTPMethods::postFile('imgEvento'); //qui è obbligatoria l'immagine
            $imgEvento = file_get_contents($fileImg['tmp_name']);

            $quotaIscrizione = $this->costruisciQuotaIscrizione();

            $idPremio = UHTTPMethods::postInt('idPremio');
            $premio = FPersistentManager::PMgetObjOnAttribute(EProdotto::class, 'idProdotto', $idPremio);
            if ($premio === null) {
                throw new InvalidArgumentException("Il premio selezionato non esiste.");
            }

            $idGioco = UHTTPMethods::postInt('idGioco');
            $gioco = FPersistentManager::PMgetObjOnAttribute(EGiocoDaTavolo::class, 'idProdotto', $idGioco);
            if ($gioco === null) {
                throw new InvalidArgumentException("Il gioco selezionato non esiste.");
            }
            //il costruttore esegue già verificaPremio()
            $torneo = new ETorneo($nomeEvento, $imgEvento, $descrizioneEvento, $dataInizio, $maxPartecipanti, $quotaIscrizione, $premio, $gioco);

            $salvato = FPersistentManager::PMsaveObj($torneo);

            if (!$salvato) {
                throw new RuntimeException("Si è verificato un errore durante la creazione del torneo.");
            }

            UFlashMessage::addMessage('success', 'Torneo pubblicato con successo!');
            header('Location: ' . BASE_URL . '/gestore/eventi/torneo');
            exit();

        } catch (\Exception $e) {
            UFlashMessage::addMessage('danger', $e->getMessage());
            header('Location: ' . UHTTPMethods::getReferer(BASE_URL . '/gestore/eventi/torneo'));
            exit();
        }

    }

    /**
     * URL: POST /gestore/eventi/challenge/nuovo
     */
    public function creaChallenge(): void {
        try {
            $nomeEvento = UHTTPMethods::postString('nomeEvento', maxLength: 255);
            $descrizioneEvento = UHTTPMethods::postString('descrizioneEvento');
            $dataInizio = UHTTPMethods::postDate('dataInizio', 'Y-m-d H:i:s');
            $maxPartecipanti = UHTTPMethods::postInt('maxPartecipanti', min: 1);

            $fileImg = UHTTPMethods::postFile('imgEvento'); //qui è obbligatoria l'immagine
            $imgEvento = file_get_contents($fileImg['tmp_name']);

            $quotaIscrizione = $this->costruisciQuotaIscrizione();

            $idPremio = UHTTPMethods::postInt('idPremio');
            $premio = FPersistentManager::PMgetObjOnAttribute(EProdotto::class, 'idProdotto', $idPremio);
            if ($premio === null) {
                throw new InvalidArgumentException("Il premio selezionato non esiste.");
            }

            $punti1 = UHTTPMethods::postInt('punteggioPrimoClassificato');
            $punti2 = UHTTPMethods::postInt('punteggioSecondoClassificato');
            $punti3 = UHTTPMethods::postInt('punteggioTerzoClassificato');

            $idTorneiSelezionati = UHTTPMethods::postArray('idTorneiSelezionati', required: true);
            $tornei = [];
            foreach ($idTorneiSelezionati as $idTorneo) {
                $torneo = FPersistentManager::PMgetObjOnAttribute(ETorneo::class, 'idEvento', $idTorneo);
                if ($torneo === null) {
                    throw new InvalidArgumentException("Il torneo selezionato non esiste.");
                }
                //Controllo che il torneo non sia già assegnato ad un'altra challenge
                if ($torneo->getChallenge() !== null) {
                    throw new InvalidArgumentException("Il torneo '{$torneo->getNomeEvento()}' è già assegnato ad un'altra challenge.");
                }
                $tornei[] = $torneo;
            }

            //il costruttore esegue già verificaTornei() (3-7 tornei), verificaPremio(), verificaPunteggi() (ordine primo > secondo > terzo)
            $challenge = new EChallenge($nomeEvento, $imgEvento, $descrizioneEvento, $dataInizio, $maxPartecipanti, $quotaIscrizione, $premio, $punti1, $punti2, $punti3, $tornei);

            $salvato = FPersistentManager::PMsaveObj($challenge);

            if (!$salvato) {
                throw new RuntimeException("Si è verificato un errore durante la creazione della challenge.");
            }

            UFlashMessage::addMessage('success', 'Challenge pubblicata con successo!');
            header('Location: ' . BASE_URL . '/gestore/eventi/challenge');
            exit();

        } catch (\Exception $e) {
            UFlashMessage::addMessage('danger', $e->getMessage());
            header('Location: ' . UHTTPMethods::getReferer(BASE_URL . '/gestore/eventi/challenge'));
            exit();
        }

    }

    // Transizioni di stato

    /**
     * URL: POST /gestore/eventi/attiva
     */
    public function attivaEventoGestore(): void {
        $isAjax = UHTTPMethods::isAjax();
        try {
            $idEvento = UHTTPMethods::postInt('id_evento');
            $evento = $this->recuperaEvento($idEvento);

            $evento->avviaEvento(); //validazioni interne al metodo

            $salvato = FPersistentManager::PMsaveObj($evento);

            if (!$salvato) {
                throw new RuntimeException("Si è verificato un errore durante l'avvio dell'evento.");
            }

            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'ok', 'statoEvento' => $evento->getStatoEvento()->value]);
                exit();
            }

            UFlashMessage::addMessage('success', 'L\'evento è stato avviato con successo!');
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
     * URL: POST /gestore/eventi/concludi
     */
    public function concludiEventoGestore(): void {
        $isAjax = UHTTPMethods::isAjax();
        try {
            $idEvento = UHTTPMethods::postInt('id_evento');
            $evento = $this->recuperaEvento($idEvento);

            $evento->terminaEvento(); //validazioni interne al metodo

            $salvato = FPersistentManager::PMsaveObj($evento);

            if (!$salvato) {
                throw new RuntimeException("Si è verificato un errore durante la conclusione dell'evento.");
            }

            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'ok', 'statoEvento' => $evento->getStatoEvento()->value]);
                exit();
            }

            UFlashMessage::addMessage('success', 'L\'evento è stato concluso con successo!');
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
     * URL: POST /gestore/eventi/annulla
     */
    public function annullaEventoGestore(): void {
        $isAjax = UHTTPMethods::isAjax();
        try {
            $idEvento = UHTTPMethods::postInt('id_evento');
            $evento = $this->recuperaEvento($idEvento);

            $evento->annullaEvento(); //validazioni interne al metodo

            $salvato = FPersistentManager::PMsaveObj($evento);

            if (!$salvato) {
                throw new RuntimeException("Si è verificato un errore durante l'annullamento dell'evento.");
            }

            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'ok', 'statoEvento' => $evento->getStatoEvento()->value]);
                exit();
            }

            UFlashMessage::addMessage('success', 'L\'evento è stato annullato con successo!');
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
     * Riprogramma un evento annullato, riportandolo a "Programmato" con una nuova data. 
     * URL: POST /gestore/eventi/riprogramma
     */
    public function riprogrammaEventoGestore(): void {
        $isAjax = UHTTPMethods::isAjax();
        try {
            $idEvento = UHTTPMethods::postInt('id_evento');
            $evento = $this->recuperaEvento($idEvento);

            $nuovaData = UHTTPMethods::postDate('nuovaDataInizio', 'Y-m-d H:i:s');
            $evento->riprogrammaEvento($nuovaData); //valida stato Annullato + data futura

            $salvato = FPersistentManager::PMsaveObj($evento);
            if (!$salvato) {
                throw new RuntimeException("Si è verificato un errore durante la riprogrammazione dell'evento.");
            }

            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'ok',
                    'statoEvento' => $evento->getStatoEvento()->value,
                    'dataInizio' => $evento->getDataInizio()->format('Y-m-d H:i:s'),
                ]);
                exit();
            }

            UFlashMessage::addMessage('success', 'L\'evento è stato riprogrammato con successo!');
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

    // Modifica dati generici

    /**
     * Modifica i soli campi anagrafici di un evento (nome, descrzione, capienza,
     * immagine). Non tocca lo stato né la dat: quella passa da riprogrammaEventoGestore().
     * URL: POST /gestore/eventi/modifica
     */
    public function modificaEventoGestore(): void {
        $isAjax = UHTTPMethods::isAjax();
        try {
            $idEvento = UHTTPMethods::postInt('id_evento');
            $evento = $this->recuperaEvento($idEvento);

            $evento->rinominaEvento(UHTTPMethods::postString('nomeEvento', maxLength: 255));
            $evento->aggiornaDescrizione(UHTTPMethods::postString('descrizioneEvento'));
            $evento->aggiornaMaxPartecipanti(UHTTPMethods::postInt('maxPartecipanti', min: 1));

            // Immagine opzionale in modifica (a differenza della creazione): la si tocca
            // solo se il gestore ne carica effettivamente una nuova. 
            if (isset($_FILES['imgEvento']) && $_FILES['imgEvento']['error'] === UPLOAD_ERR_NO_FILE) {
                $fileImg = UHTTPMethods::postFile('imgEvento');
                $evento->aggiornaImg(file_get_contents($fileImg['tmp_name']));
            }

            $salvato = FPersistentManager::PMsaveObj($evento);

            if (!$salvato) {
                throw new RuntimeException("Si è verificato un errore durante la modifica dell'evento.");
            }

            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'ok', 'message' => 'Evento aggiornato con successo!']);
                exit();
            }

            UFlashMessage::addMessage('success', 'Evento aggiornato con successo!');
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
     * Assegna il podio (1°/2°/3° posto) ai partecipanti di un torneo concluso.
     * Funziona identico sia per tornei standalone sia per tornei che fanno parte 
     * di una challenge, perché in entrambi i casi esiste una EPartecipazione
     * dedicata a livello di singolo torneo.
     * URL: POST /gestore/eventi/tornei/esito
     */
    public function inserisciEsitoTorneoGestore(): void {
        try {
            $idEvento = UHTTPMethods::postInt('id_evento');
            $torneo = FPersistentManager::PMgetObjOnAttribute(ETorneo::class, 'idEvento', $idEvento);
            if ($torneo === null) {
                throw new InvalidArgumentException("L'evento selezionato non esiste.");
            }
            if ($torneo->getStatoEvento() !== StatoEvento::Terminato) {
                throw new InvalidArgumentException("L'evento non è ancora terminato. Puoi inserire l'esito solo per un torneo concluso.");
            }
            
            //id_secondo e id_terzo sono opzionali: un torneo potrebbe avere meno
            //di 3 partecipanti totali.
            $idPrimoRaw = UHTTPMethods::postInt('id_primo');
            $idSecondoRaw = UHTTPMethods::post('id_secondo');
            $idTerzoRaw = UHTTPMethods::post('id_terzo');

            $mappaPosizioni = [$idPrimoRaw => 1];
            if ($idSecondoRaw !== null && $idSecondoRaw !== '') {
                $mappaPosizioni[(int) $idSecondoRaw] = 2;
            }
            if ($idTerzoRaw !== null && $idTerzoRaw !== '') {
                $mappaPosizioni[(int) $idTerzoRaw] = 3;
            }

            if (count($mappaPosizioni) !== count(array_unique(array_keys($mappaPosizioni)))) {
                throw new InvalidArgumentException("L'esito contiene posizioni duplicati.");
            }

            //Verifica che tutti gli id selezionati siano effettivamente iscritti a questo torneo
            $idIscritti = array_map(
                fn($p) => $p->getUtente()->getIdPersona(),
                $torneo->getPartecipazioni()->toArray()
            );
            foreach (array_keys($mappaPosizioni) as $idUtente) {
                if (!in_array($idUtente, $idIscritti, true)) {
                    throw new InvalidArgumentException("L'utente con ID $idUtente non ha partecipato a questo torneo.");
                }
            }

            //Applica (o azzera) la posizione su ogni partecipazione del torneo:
            //reimpostare esplicitamente a null chi non è nel podio permette anche
            //di correggere un esito inserito per errore in precedenza.
            foreach ($torneo->getPartecipazioni() as $partecipazione) {
                $idUtente = $partecipazione->getUtente()->getIdPersona();
                $partecipazione->aggiornaPosizioneInClassifica($mappaPosizioni[$idUtente] ?? null);
                FPersistentManager::PMsaveObj($partecipazione);
            }

            UFlashMessage::addMessage('success', 'Esito del torneo inserito con successo!');
            header('Location: ' . UHTTPMethods::getReferer(BASE_URL . '/gestore/dashboard'));
            exit();

        } catch (\Exception $e) {
            UFlashMessage::addMessage('danger', $e->getMessage());
            header('Location: ' . UHTTPMethods::getReferer(BASE_URL . '/gestore/dashboard'));
            exit();
        }
    }

    /**
     * Calcola e salva la classifica finale di una challenge, sommando i punti
     * guadagnati da ciascun utente in base al podio ottenuto in ogni torneo incluso.
     * Richiede che tutti i tornei della challenge abbiano già un esito registrato.
     * URL: POST /gestore/eventi/challenge/genera-classifica
     */
    public function generaClassificaChallengeGestore(): void {
        try {
            $idChallenge = UHTTPMethods::postInt('id_challenge');
            $challenge = FPersistentManager::PMgetObjOnAttribute(EChallenge::class, 'idEvento', $idChallenge);
            if ($challenge === null) {
                throw new InvalidArgumentException("L'evento selezionato non esiste.");
            }
            if ($challenge->getStatoEvento() !== StatoEvento::Terminato) {
                throw new InvalidArgumentException("L'evento non è ancora terminato. Puoi generare la classifica solo per un challenge concluso.");
            }

            //Verifica che ogni torneo abbia già un podio inserito
            foreach ($challenge->getTornei() as $torneo) {
                $haPodio = false;
                foreach ($torneo->getPartecipazioni() as $p) {
                    if ($p->getPosizioneInClassifica() === 1) {
                        $haPodio = true;
                        break;
                    }
                }
                if (!$haPodio) {
                    throw new InvalidArgumentException("Il torneo '{$torneo->getNomeEvento()}' non ha ancora un esito registrato.");
                }
            }

            //Somma i punti challenge di ogni utente, sui tornei in cui è arrivato sul podio
            $puntiPerUtente = []; //[idUtente => punti]
            foreach ($challenge->getTornei() as $torneo) {
                foreach ($torneo->getPartecipazioni() as $p) {
                    $punti = match ($p->getPosizioneInClassifica()) {
                        1 => $challenge->getPunteggioPrimoClassificato(),
                        2 => $challenge->getPunteggioSecondoClassificato(),
                        3 => $challenge->getPunteggioTerzoClassificato(),
                        default => 0,
                    };
                    $idUtente = $p->getUtente()->getIdPersona();
                    $puntiPerUtente[$idUtente] = ($puntiPerUtente[$idUtente] ?? 0) + $punti;
                }
            }

            //Ordina per punti decrescenti: chi ha più punti è primo in classifica
            arsort($puntiPerUtente);

            //Applica punteggio totale e posizione a ciascuna partecipazione "di challenge"
            //(distinta da quelle "di torneo" già gestite sopra)
            $posizione = 1;
            foreach (array_keys($puntiPerUtente) as $idUtente) {
                foreach ($challenge->getPartecipazioni() as $partecipazioneChallenge) {
                    if ($partecipazioneChallenge->getUtente()->getIdPersona() === $idUtente) {
                        $partecipazioneChallenge->aggiornaPunteggioTotale($puntiPerUtente[$idUtente]);
                        $partecipazioneChallenge->aggiornaPosizioneInClassifica($posizione);
                        FPersistentManager::PMsaveObj($partecipazioneChallenge);
                        break;
                    }
                }
                $posizione++;
            }

            UFlashMessage::addMessage('success', 'Classifica della challenge generata con successo!');
            header('Location: ' . UHTTPMethods::getReferer(BASE_URL . '/gestore/dashboard'));
            exit();

        } catch (\Exception $e) {
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
        $danno = FPersistentManager::PMgetObjOnAttribute(EDanno::class, 'livelloDanno', $livello);

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
     * Recupera un evento per id, sollevando un'eccezione coerente con il resto
     * del controller se non esiste. Usato in tutte le azioni CRUD sugli eventi.
     */
    private function recuperaEvento(int $idEvento): EEvento {
        $evento = FPersistentManager::PMgetObjOnAttribute(EEvento::class, 'idEvento', $idEvento);
        if ($evento === null) {
            throw new InvalidArgumentException("L'evento selezionato non esiste.");
        }
        return $evento;
    }

    /**
     * Costruisce la quota di iscrizione per Torneo/Challenge.
     * A differenza di costruisciPrezzo(), usato per i prodotti, qui non c'è
     * un concetto di sconti promozionale: una quota di iscrizione è un valore fisso.
     */
    private function costruisciQuotaIscrizione(): EPrezzo {
        $valore = UHTTPMethods::postFloat('valoreQuota', min: 0); //TODO. niente try/catch??
        $valuta = $this->postEnum('valuta', Valuta::class);
        return new EPrezzo($valore, $valuta);
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

            'gestore_eventi_serate' => array_merge($breadcrumbs, [
                ['label' => 'Serate', 'url' => BASE_URL . '/gestore/eventi/serate'],
            ]),
            'gestore_eventi_tornei' => array_merge($breadcrumbs, [
                ['label' => 'Tornei', 'url' => BASE_URL . '/gestore/eventi/tornei'],
            ]),
            'gestore_eventi_challenge' => array_merge($breadcrumbs, [
                ['label' => 'Challenge', 'url' => BASE_URL . '/gestore/eventi/challenge'],
            ]),
            'gestore_eventi_ricerca' => array_merge($breadcrumbs, [
                ['label' => 'Ricerca', 'url' => BASE_URL . '/gestore/eventi/ricerca'],
            ]),
            'gestore_dettaglio_serata' => array_merge($breadcrumbs, [
                ['label' => 'Serate', 'url' => BASE_URL . '/gestore/eventi/serate'],
                ['label' => $this->nomeEventoCorrente ?? 'Dettaglio', 'url' => '#'],
            ]),
            'gestore_dettaglio_torneo' => array_merge($breadcrumbs, [
                ['label' => 'Tornei', 'url' => BASE_URL . '/gestore/eventi/tornei'],
                ['label' => $this->nomeEventoCorrente ?? 'Dettaglio', 'url' => '#'],
            ]),
            'gestore_dettaglio_challenge' => array_merge($breadcrumbs, [
                ['label' => 'Challenge', 'url' => BASE_URL . '/gestore/eventi/challenge'],
                ['label' => $this->nomeEventoCorrente ?? 'Dettaglio', 'url' => '#'],
            ]),
            
            default => $breadcrumbs,
        };
    }


}