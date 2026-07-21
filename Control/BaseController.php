<?php
/**
 * Il BaseController (astratto) centralizza la logica di controllo, sicurezza e sessione.
 */
namespace TableCrown\Control;

use TableCrown\Utility\USession;
use TableCrown\Utility\UHTTPMethods;
use TableCrown\Utility\UFlashMessage;
use TableCrown\Utility\UCookie;
use TableCrown\Entity\EUtente;
use TableCrown\Entity\EProdotto;
use TableCrown\Entity\Enumerativi\DisponibilitaProdotto;
use TableCrown\Entity\ERecensione;
use TableCrown\Foundation\FPersistentManager;
use TableCrown\Entity\EEvento;
use TableCrown\Entity\ESerata;
use TableCrown\Entity\ETorneo;
use TableCrown\Entity\EChallenge;
use TableCrown\Entity\EGiocoDaTavolo;
use TableCrown\Entity\EBustine;
use TableCrown\Entity\EPortaDadi;
use TableCrown\Entity\ECartaDiCredito;
use TableCrown\Entity\EIndirizzo;
use TableCrown\Entity\EMotivazione;
use TableCrown\Entity\Enumerativi\Categoria;
use TableCrown\Entity\Enumerativi\LivelloDannoGiochi;
use TableCrown\Entity\Enumerativi\DifficoltaGioco;
use TableCrown\Entity\Enumerativi\LinguaGioco;
use TableCrown\Entity\Enumerativi\StatoEvento;
use TableCrown\Foundation\PaymentInterface;
use TableCrown\Presentation\Views\ViewCatalogo;
use TableCrown\Presentation\Views\ViewEventi;
use TableCrown\Presentation\Views\ViewGestore;
use InvalidArgumentException;
use DateTime;


abstract class BaseController {

    protected array $validRoles; //Elenco di ruoli di sistema ammessi per il controllo dei permessi.

    //Definisco i tipi di prodotto validi per il catalogo, che a livello entity sono
    //classi diverse, in modo da poter restituire l'informazione sotto forma di array associativo.
    protected const TIPI_PRODOTTO = [
        'giochi-da-tavolo' => 'Gioco da Tavolo',
        'bustine' => 'Bustine',
        'porta-dadi' => 'Porta Dadi',
    ];

    protected const ORDINAMENTO_VALIDI = ['prezzo-asc', 'prezzo-desc', 'popolarita', 'rating'];
    protected const IN_EVIDENZA_VALIDI = ['sconti', 'novita'];
    protected const RISULTATI_PER_PAGINA = 20; //valore di default


    public function __construct() {

        //Definisco i ruoli validi del nostro sistema TableCrown
        $this->validRoles = [
            'utente',
            'gestore',
            'amministratore',
        ];
    }

    /**
     * Prepara i dati globali richiesti dal layout prima di passarli alla View reale.
     * $currentPage è il nome della pagina corrente, ad esempio "home", "catalogo", "dettaglio_prodotto", ecc.
     * $data è un array associativo che contiene i dati specifici passati dal controller figlio.
     * Restituisce l'array completo di tutti i dati uniti.
     */
    public function preparaDatiLayout(string $currentPage, $data = []): array {
        //Controllo automatico remember me prima di generare il layout
        $this->controllaRememberMe();

        //Variabili globali sempre richieste dal layout
        $globalData = [
            'base_url' => BASE_URL, 
            'current_page' => $currentPage, //Indica la pagina attiva (es. 'catalogo', 'eventi', ecc.)
            'breadcrumbs' => $this->getBreadcrumbs($currentPage), //Il percorso di navigazione
            'utente' => $this->utenteToArray(),
        ];

        //cart_count solo per gli utenti loggati con ruolo 'utente'
        if ($this->isLoggedIn() && USession::getSessionElement('ruolo') === 'utente') {
            $carrello = USession::getSessionElement('carrello') ?? [];
            $cartCount = array_sum($carrello);
            if ($cartCount > 0) {
                $globalData['cart_count'] = $cartCount; //Il badge appare solo se gli articoli sono > 0
            }
        }

        //Gestione dei Flash Messages
        if (UFlashMessage::hasMessage()) {
            $messaggiSalvati = UFlashMessage::getMessage();

            //Estraggo la stringa del messaggio e il tipo per Smarty
            foreach ($messaggiSalvati as $type => $messaggesArray) {
                if (!empty($messaggesArray)) {
                    $globalData['flash_message'] = $messaggesArray[0];//Prendiamo il primo messaggio di quel tipo
                    $globalData['flash_type'] = $type; //'success', 'danger', ecc.
                    break; //Ci fermiamo al primo tipo trovato (per non sovrascrivere i dati) per inviarlo al layout
                }
            }
        }

        //Unisco i dati globali e quelli specifici della pagina
        //array_merge() unisce i due array. Se ci sono chiavi doppie, quelle in $data sovrascrivono quelle in $globalData
        return array_merge($globalData, $data);
    }

    /**
     * Metodo di default per la gestione dei Breadcrumbs (le pagine interne faranno l'override per restituire il loro percorso specifico).
     * Restituisce un array vuoto perchè di default la homepage non mostra i breadcrumbs.
     */
    protected function getBreadcrumbs(string $currentPage = ''): array {
        return [];
    }


    /**
     * Controlla se l'utente è loggato nella sessione globale.
     */
    public function isLoggedIn(): bool {
        return USession::isSetSessionElement('id_persona');
    }

    /**
     * Forza il login: se l'utente non è loggato, imposta un avviso e lo reindirizza alla pagina di login.
     */
    public function requireLogin(): void {
        if (!$this->isLoggedIn()) {
            //Pattern PRG: messaggio flash di avviso
            UFlashMessage::addMessage('warning', "È necessario effettuare l'accesso per visualizzare questa pagina.");

            //Eseguiamo il redirect alla rotta più pulita gestita dal FrontController
            header("Location: " . BASE_URL . "/accedi");
            exit();
        }
    }

    /**
     * Protezione degli accessi basata sul ruolo (es. solo l'Amministratore)
     * Controlla che l'utente sia loggato e che abbia il ruolo richiesto.
     */
    public function requireRole(string $role): void {
        //Verifica che il ruolo richiesto faccia parte dell'elenco di ruoli ammessi
        if (!in_array($role, $this->validRoles, true)) {
            throw new \Exception("Ruolo non valido: " . $role);
        }

        //Se la pagina richiede un ruolo specifico, l'utente deve essere innanzitutto loggato
        $this->requireLogin();

        //Recupera il ruolo (stringa) salvato in sessione al momento del login
        $userRole = USession::getSessionElement('ruolo');

        if ($userRole !== $role) {
            //Se l'utente è loggato ma non ha i permessi (es. cliente prova a entrare nella dashboard del gestore)
            header("HTTP/1.1 403 Forbidden");
            echo "Errore 403 - Accesso Negato: Non hai i permessi necessari per accedere a questa risorsa."; //Error 403: utente loggato ma con ruolo sbagliato
            exit();
        }
    }

    //==========================================================================
    // METODI UTILI PER PASSAGGIO DATI A PRESENTATION
    //==========================================================================

    // PRODOTTI

    /**
     * Converte un'entity EProdotto (e sottoclasse) in un array
     * per tutte le liste di prodotti (home, catalogo, carrello, etc.).
     */
    protected function prodottoToArray(EProdotto $prodotto): array {
        $prezzoObj = $prodotto->getPrezzo();
        $inSconto = $prezzoObj !== null && $prezzoObj->hasSconto();

        $immagineRaw = $prodotto->getImgProdotto();

        $danneggiato = false;
        $livelloDanno = null;
        if ($prodotto instanceof EGiocoDaTavolo && $prodotto->getDanno() !== null) {
            $danneggiato = true;
            $livelloDanno = $prodotto->getDanno()->getLivelloDanno()->value;
        }

        return [
            'id'                 => (int) $prodotto->getIdProdotto(),
            'nome'               => $prodotto->getNomeProdotto(),
            'immagine'           => $immagineRaw ? base64_encode($immagineRaw) : null,
            'valutazione_media'  => (float) $prodotto->getValutazioneMedia(),
            'prezzo'             => $prezzoObj?->getValore() ?? 0.0,
            'sconto'             => $inSconto,
            'prezzo_scontato'    => $inSconto ? (float) $prezzoObj->calcolaPrezzoScontato() : null,
            'percentuale_sconto' => $inSconto ? $prezzoObj->getSconto() : null,
            'disponibilita'      => $prodotto->getDisponibilitaProdotto()->value,
            'isAcquistabile'     => $prodotto->isAcquistabile(),
            'quantita'           => $prodotto->getQuantita(),
            'danneggiato'        => $danneggiato,
            'livello_danno'      => $livelloDanno,
        ];
    }

    /**
     * Applica prodottoToArray() ad una lista di prodotti
     */
    protected function prodottiToArray(iterable $prodotti): array { //iterable è un tipo di dato che consente di iterare sia su un array che, per esempio, su una Collection
        $result = [];
        foreach ($prodotti as $prodotto) {
            $result[] = self::prodottoToArray($prodotto);
        }
        return $result;
    }

    /**
     * Restituisce prodotti "correlati" delegando la ricerca al PersistentManager,
     * escludendo gli ID passati in idsEsclusi e limitando il risultato a $limit.
     */
    protected function prodottiCorrelati(array $idsEsclusi, int $limit = 8): array {
        $correlati = FPersistentManager::PMfindCorrelati($idsEsclusi, $limit);

        return $this->prodottiToArray($correlati);
    }

    /**
     * Determina l'URL del catalogo specifico in base alla classe 
     * dell'oggetto prodotto.
     */
    protected function urlCatalogo(EProdotto $prodotto): string {
        if ($prodotto instanceof EGiocoDaTavolo) {
            return '/catalogo/giochi-da-tavolo';
        } 

        if ($prodotto instanceof EBustine) {
            return '/catalogo/bustine';
        }

        if ($prodotto instanceof EPortaDadi) {
            return '/catalogo/porta-dadi';
        }

        //Fallback generico di sicurezza
        return '/';
    }


    // CATALOGO
    // MODIFICA: prima erano solo in CCatalogo, ma li spostiamo qui per riusarli in CGestore

    /**
     * Valida il numero di pagina richiesto.
     * Ritorna sempre un numero intero >= 1: se valido, ritorna il numero letto, altrimenti 1 (pagina 1)
     */
    protected function estraiPaginaRichiesta(): int {
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
    protected function clampPagina(int $pagina, int $totalePagine): int {
        if ($totalePagine === 0) {
            return 1;
        }
        return max(1, min($pagina, $totalePagine));
    }

    /**
     * Calcola il numero totale di pagine disponibili, 
     * dato il numero totale di risultati e il numero di risultati per pagina (fisso a RISULTATI_PER_PAGINA).
     */
    protected function calcolaTotalePagine(int $totaleRisultati): int {
        return (int) ceil($totaleRisultati / self::RISULTATI_PER_PAGINA); //ceil per evitare errori di arrotondamento
    }

    /**
     * Costruisce un array $datiPagina e delega il render a ViewCatalogo.
     * Tramite questo metodo centralizziamo la logica comune alle 4 pagine
     * pubbliche, per evitare di ripetere la stessa struttura di array in ognuna.
     */
    protected function renderCatalogo(string $vista, array $risultatoGrezzo, int $pagina, array $filtri, ?string $searchQuery = null, string $modalita = 'utente'): void {
        $totaleRisultati = $risultatoGrezzo['totale'] ?? 0;
        $totalePagine = $this->calcolaTotalePagine($totaleRisultati);
        $pagina = $this->clampPagina($pagina, $totalePagine);

        $datiPagina = [
            'vista'          => $vista,
            'modalita'       => $modalita,
            'prodotti'       => $this->prodottiToArray($risultatoGrezzo['risultati'] ?? []),
            'total_results'  => $totaleRisultati,
            'pagination'     => ['current_page' => $pagina, 'total_pages' => $totalePagine],
            'search_query'   => $searchQuery,
            'filtri'         => $filtri,
        ];

        $datiLayout = $this->preparaDatiLayout($vista, $datiPagina);

        if ($modalita === 'gestore') {
            match ($vista) {
                'gestore_catalogo_giochi' => ViewGestore::mostraCatalogoGiochi($datiLayout),
                'gestore_catalogo_bustine' => ViewGestore::mostraCatalogoBustine($datiLayout),
                'gestore_catalogo_portadadi' => ViewGestore::mostraCatalogoPortaDadi($datiLayout),
                default => throw new \InvalidArgumentException("La vista '$vista' non è valida per la modalità '$modalita'."),
            };
        } else {
            ViewCatalogo::render($datiLayout);
        }

    }

    /**
     * Legge un parametro GET che può arrivare come valore singolo,
     * array, o essere assente, normalizzandolo sempre in array.
     */
    protected function estraiArrayDaRequest(string $chiave): array {
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
    protected function estraiFiltriPrezzo(): array {
        $priceRangeMin = 0.0; //fisso a 0

        //Valori selezionati dall'utente sullo slider (se presenti in GET)
        $priceMinRaw = UHTTPMethods::get('price_min');  
        $priceMaxRaw = UHTTPMethods::get('price_max');

        $ratingMinRaw = UHTTPMethods::get('rating_min');
        $ordinamentoRaw = UHTTPMethods::get('ordinamento');

        return [
            'price_min'          => is_numeric($priceMinRaw) ? (float) $priceMinRaw : $priceRangeMin,
            //Se non specificato dall'utente, lasciamo null: verrà impostato dopo la query con rangemax
            'price_max'          => is_numeric($priceMaxRaw) ? (float) $priceMaxRaw : null,
            'price_range_min'    => $priceRangeMin,
            'price_range_max'    => null, // Verrà popolato dinamicamente da rangemax del PM
            'disponibilita'      => $this->validaValoriEnum($this->estraiArrayDaRequest('disponibilita'), DisponibilitaProdotto::class),
            'in_evidenza_filtro' => array_values(array_intersect($this->estraiArrayDaRequest('in_evidenza_filtro'), self::IN_EVIDENZA_VALIDI)),
            'rating_min'         => is_numeric($ratingMinRaw) ? (float) $ratingMinRaw : 0.0,
            'ordinamento'        => in_array($ordinamentoRaw, self::ORDINAMENTO_VALIDI, true) ? $ordinamentoRaw : null,
        ];
    }

    /**
     * Estende i filtri comuni con quelli specifici dei giochi da tavolo.
     */
    protected function estraiFiltriGiochi(): array {
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

    /**
     * Completa l'array $filtri iniettando il valore rangemax restituito dal pm
     */
    protected function completaFiltriPrezzo(array $filtri, array $risultatoGrezzo): array {
        //Recuperiamo il rangemax calcolato dal pm (con fallback a 0.0 per sicurezza)
        $reangeMax = (float) ($risultatoGrezzo['rangemax'] ?? 0.0);
        $filtri['price_range_max'] = $reangeMax;

        //Se l'utente non aveva impostato il limite massimo, impostiamo lo slider al massimo del range
        if ($filtri['price_max'] === null) {
            $filtri['price_max'] = $reangeMax;
        }

        return $filtri;
    }



    // UTENTE

    /**
     * Converte l'utente loggato (se presente) nella forma minimale richiesta dal layout
     */
    protected function utenteToArray(): ?array {
        if (!$this->isLoggedIn()) {
            return null;
        }
        return [
            'name' => USession::getSessionElement('nickname'), //La sessione salva 'nickname', esposto come 'name' verso Presentation
        ];
    }

    /**
     * Recupera l'utente correntemente loggato nel DB, verificando che abbia il 
     * ruolo 'utente'.
     */
    protected function utenteCorrente(): EUtente {
        $this->requireRole('utente');
        $idUtente = USession::getSessionElement('id_persona');

        $utente = $this->utenteCorrenteOpzionale(); //recupera internamente l'oggetto dal db

        //Difensivo: se per qualsiasi motivo non troviamo l'utente nel db,
        //puliamo la sessione e lo reindirizziamo al login anziché far generare un errore.
        if (!$utente) {
            USession::unsetSession(); //svuota l'array $_SESSION in memoria
            USession::destroySession(); //cancella il file/dati della sessione sul server
            //Ripuliamo anche il cookie Remember Me
            UCookie::deleteCookie('remember_me');
            UFlashMessage::addMessage('danger', 'Sessione non valida o scaduta. Effettuare nuovamente il login.');
            header('Location: ' . BASE_URL . '/accedi');
            exit();
        }

        return $utente;
    }

    /**
     * Simile a utenteCorrente(), ma utile in contesti in cui il login è facoltativo
     * (es. pagine pubbliche che mostrano contenuto diverso se l'utente è loggato).
     * Non forza mai un redirect: restituisce null se non loggato o senza ruolo 'utente',
     * lasciando decidere al chiamante cosa fare in quel caso.
     */
    protected function utenteCorrenteOpzionale(): ?EUtente {
        if (!$this->isLoggedIn() || USession::getSessionElement('ruolo') !== 'utente') {
            return null;
        }
        $idUtente = USession::getSessionElement('id_persona');
        if (!$idUtente) {
            return null;
        }
        return FPersistentManager::PMgetObjOnAttribute(EUtente::class, 'idpersona', $idUtente);
    }

    // ENUM

    /**
     * Converte i case di un enum PHP nativo in coppie {value, label} per i dropdown.
     * Modifica i values dei cases in un formato maggiormente leggibile per il front-end.
     */
    protected function enumToOptions(array $cases, array $labelOverrides = []): array {
        return array_map(fn($c) => [
            'value' => $c->value,
            //tramite ?? controlliamo se esiste un override manuale in $labelOverrides per quel valore specifico; se sì usa quello, altrimenti usa il calcolo automatico
            'label' => $labelOverrides[$c->value] ?? ucwords(str_replace('_', ' ', $c->value)), //ucwords rende il primo carattere di ogni parola maiuscolo
        ], $cases);
    }

    /**
     * Filtra un array di valori stringa provenienti dalla request, mantenendo solo
     * quelli quelli ammessi dall'enum indicato. Valori non validi vengono scartati silenziosamente
     * (scelta esplicita: un valore inventato in query string non deve rompere la pagina).
     */
    protected function validaValoriEnum(array $valori, string $enumClass): array {
        $validi = array_column($enumClass::cases(), 'value');
        return array_values(array_intersect($valori, $validi));
    }

    // RECENSIONI

    /**
     * Converte una ERecensione in un array associativo per Presentation.
     */
    protected function recensioneToArray(ERecensione $recensione): array {
        return [
            'id'          => (int) $recensione->getIdRecensione(),
            'valutazione' => $recensione->getValutazione(),
            'testo'       => $recensione->getTesto(),
            'data'        => $recensione->getData(),
            'id_utente'   => (int) $recensione->getUtente()->getIdPersona(),
            'utente'      => $recensione->getUtente()->getNomePersona(),
            'prodotto'    => [
                'id'          => (int) $recensione->getProdotto()->getIdProdotto(),
                'nome'        => $recensione->getProdotto()->getNomeProdotto(),
                'immagine'    => $recensione->getProdotto()->getImgProdotto() ? base64_encode($recensione->getProdotto()->getImgProdotto()) : null,
            ]
        ];
    }

    /**
     * Applica recensioneToArray() ad una lista/collezione di recensioni.
     */
    protected function recensioniToArray(iterable $recensioni): array {
        $result = [];
        foreach ($recensioni as $recensione) {
            $result[] = $this->recensioneToArray($recensione);
        }
        return $result;
    }

    // MOTIVAZIONI SEGNALAZIONE

    /**
     * Converte una EMotivazione in array associativo per Presentation.
     */
    protected function motivazioneToArray(EMotivazione $motivazione): array {
        return [
            'id' => $motivazione->getIdMotivazione(),
            'label' => $motivazione->getNomeMotivazione(),
            'gravita' => $motivazione->getGravitaMotivazione()->value,
        ];
    }

    /**
     * Converte un array di EMotivazione in array associativo per Presentation.
     */
    protected function motivazioniToArray(array $motivazioni): array {
        $risultato = [];
        foreach ($motivazioni as $motivazione) {
            $risultato[] = $this->motivazioneToArray($motivazione);
        }
        return $risultato;
    }

    // EVENTI

    /**
     * Converte un EEvento in un array associativo per Presentation.
     * (considera solo i campi comuni a tutti i tipi di evento)
     */
    protected function eventoToArray(EEvento $evento): array {
        return [
            'idEvento'          => (int) $evento->getIdEvento(),
            'nomeEvento'        => $evento->getNomeEvento(),
            'imgEvento'         => $evento->getImgEvento() ? base64_encode($evento->getImgEvento()) : null,
            'dataInizio'        => $evento->getDataInizio()->format('Y-m-d H:i:s'),
            'maxPartecipanti'   => $evento->getMaxPartecipanti(),
            'statoEvento'       => $evento->getStatoEvento()->value, //valori non ancora "puliti", da rivedere se/quando serve esporli come identificatore tecnico altrove
            'numeroPartecipanti'=> $evento->getNumeroPartecipanti(),
            'richiedeQuota'     => $evento->richiedeQuota(),
            'postiDisponibili'  => $evento->getMaxPartecipanti() - $evento->getNumeroPartecipanti(),
        ];
    }

    /**
     * Converte un ESerata in un array associativo per Presentation.
     */
    protected function serataToArray(ESerata $serata): array {
        return array_merge($this->eventoToArray($serata), [
            'tipo'       => 'serata',
            'tipoSerata' => $serata->getTipoSerata(),
        ]);
    }

    /**
     * Converte un ETorneo in un array associativo per Presentation.
     */
    protected function torneoToArray(ETorneo $torneo): array {
        $challenge = $torneo->getChallenge();
        return array_merge($this->eventoToArray($torneo), [
            'tipo'            => 'torneo',
            'quotaIscrizione' => $torneo->getQuotaIscrizione()->getValore(),
            'premio' => $torneo->getPremio()->getNomeProdotto(),
            'gioco' => $torneo->getGioco()->getNomeProdotto(),
            'challenge' => $challenge !== null ? $this->eventoLinkMinimo($challenge): null,
        ]);
    }

    /**
     * Converte un EChallenge in un array associativo per Presentation.
     */
    protected function challengeToArray(EChallenge $challenge): array {
        return array_merge($this->eventoToArray($challenge), [
            'tipo'            => 'challenge',
            'quotaIscrizione' => $challenge->getQuotaIscrizione()->getValore(),
            'premio' => $challenge->getPremio()->getNomeProdotto(),
            'tornei' => array_map(fn($t) => $this->eventoLinkMinimo($t), $challenge->getTornei()->toArray()),
        ]);
    }

    /**
     * Riconosce il tipo effettivo di EEvento e chiama il corretto metodo di mapping
     * ereditato dal BaseController.
     */
    protected function mappaEvento(EEvento $evento): array {
        if ($evento instanceof ESerata) {
            return $this->serataToArray($evento);
        }
        
        if ($evento instanceof ETorneo) {
            return $this->torneoToArray($evento);
        }

        if ($evento instanceof EChallenge) {
            return $this->challengeToArray($evento);
        }

        //Difensivo: non dovrebbe mai accadere dato il DiscriminatorMap di EEvento, ma lo aggiungiamo per sicurezza
        return $this->eventoToArray($evento);
    }

    /**
     * Trasforma un array di EEvento in un array di array per Presentation,
     * preservando i dettagli polimorfici di ciascun tipo di evento.
     */
    protected function eventiToArray(array $eventi): array {
        $risultato = [];
        foreach ($eventi as $evento) {
            if ($evento instanceof EEvento) {
                $risultato[] = $this->mappaEvento($evento);
            }
        }
        
        // Se non ci sono eventi, restituisce un array vuoto
        return $risultato;
    }


    /**
     * Rappresentazione minimale di un EEvento, per link cliccabili.
     */
    protected function eventoLinkMinimo(EEvento $evento): array {
        return [
            'idEvento'          => (int) $evento->getIdEvento(),
            'nomeEvento'        => $evento->getNomeEvento(),
        ];
    }


    /**
     * Costruisce i dati comuni a tutte le pagine lista eventi e delega il render.
     */
    protected function renderListaEventi(string $vista, array $risultatoGrezzo, ?string $filtroData = null, $modalita = 'utente'): void { 

        $datiPagina = [
            'vista'  => $vista,
            'eventi' => $this->eventiToArray($risultatoGrezzo),
            'filtro_data' => $filtroData,
            'modalita' => $modalita,
        ];

        $datiLayout = $this->preparaDatiLayout($vista, $datiPagina);

        //Smistamento in base alla modalità (utente vs gestore)
        if ($modalita === 'gestore') {
            match ($vista) {
                'gestore_eventi_serate' => ViewGestore::mostraEventiSerate($datiLayout),
                'gestore_eventi_tornei' => ViewGestore::mostraEventiTornei($datiLayout),
                'gestore_eventi_challenge' => ViewGestore::mostraEventiChallenge($datiLayout),
                default => throw new \InvalidArgumentException("La vista '$vista' non è valida per la modalità '$modalita'."),
            };
        } else {
            //vista pubblica per utenti semplici
            ViewEventi::mostraEventi($datiLayout);
        }
    }

    /**
     * Legge il filtro data dalla request (formato atteso: YYYY-MM-DD) e lo converte
     * in DateTime per l'uso interno nella query; ritorna null se assente/non valido.
     */
    protected function estraiFiltroData(): ?string {
        $dataRaw = UHTTPMethods::get('filtro_data');
        if ($dataRaw === null || trim($dataRaw) === '') {
            return null;
        }
        //Validazione: verifichiamo che sia una data valida
        $d = DateTime::createFromFormat('Y-m-d', $dataRaw);
        return ($d && $d->format('Y-m-d') === $dataRaw) ? $dataRaw : null;
    }

    /**
     * Costruisce i dati di dettaglio partendo dagli helper già esistenti
     * nel BaseController (serataToArray, torneoToArray, challengeToArray),
     * aggiungendo i campi extra necessari solo alla pagina di dettaglio.
     * Condiviso tra CDettaglioEvento (vista utente) e CGestore (vista gestore,
     * che ne ha bisogno per rivedere podio/classifica prima di pubblicarli).
     */
    protected function costruisciDatiVistaEvento(EEvento $evento, string $modalita = 'utente'): array {
        //Mappatura base ereditata da mappaEvento()
        $dati = $this->mappaEvento($evento);
        
        //Personalizzazioni specifiche per tipo di evento
        if ($evento instanceof ESerata) {
            $vista = $modalita === 'gestore' ? 'gestore_dettaglio_serata' : 'dettaglio_serata';
        } elseif ($evento instanceof ETorneo) {
            //Nel catalogo 'premio' è un link minimale (id, nome, immagine); qui invece
            //per la view serve la card completa del prodotto, come nel catalogo dei prodotti.
            $dati['premio'] = $this->prodottoToArray($evento->getPremio());
            $vista = $modalita === 'gestore' ? 'gestore_dettaglio_torneo' : 'dettaglio_torneo';
        } elseif ($evento instanceof EChallenge) {
            $dati['premio'] = $this->prodottoToArray($evento->getPremio());
            //'tornei' nel catalogo è un array di link minimali (id, nome); qui invece
            //serve la card completa di ogni torneo, quindi sostituiamo con torneoToArray().
            //Nota: con torneoToArray() ogni torneo avra a sua volta un link minimale alla 
            //challenge, ma nella UI quel campo può semplicemente essere ignorato
            $dati['tornei'] = array_map(
                fn($t) => $this->torneoToArray($t),
                $evento->getTornei()->toArray()
            );
            $dati['punteggi'] = [ //i punteggi non ci sono in challengeToArray() perché non servono nel catalogo, qui li aggiungiamo
                'primo' => $evento->getPunteggioPrimoClassificato(),
                'secondo' => $evento->getPunteggioSecondoClassificato(),
                'terzo' => $evento->getPunteggioTerzoClassificato(),
            ];
            $vista = $modalita === 'gestore' ? 'gestore_dettaglio_challenge' : 'dettaglio_challenge';

            if ($evento->getStatoEvento() === StatoEvento::Terminato) {
                $dati['classificaGenerata'] = $this->isClassificaChallengeGenerata($evento);
                if ($dati['classificaGenerata']) {
                    $dati['classificaFinale'] = $this->estraiClassificaChallenge($evento);
                } elseif ($modalita === 'gestore') {
                    //utile solo al gestore, per capire cosa manca prima di poter generare la classifica
                    $dati['torneiSenzaEsito'] = $this->torneiSenzaEsito($evento);
                }
            }
        } else {
            //Difensivo: non dovrebbe mai accadere dato il DiscriminatorMap di EEvento, ma lo aggiungiamo per sicurezza
            throw new \LogicException('Tipo di evento non riconosciuto: ' . get_class($evento));
        }

        $dati['vista'] = $vista;
        $dati['descrizioneEvento'] = $evento->getDescrizioneEvento();
        $dati['postiRimanenti'] = $evento->getMaxPartecipanti() - $evento->getNumeroPartecipanti();
        $dati['hasPostiDisponibili'] = $evento->hasPostiDisponibili();
        $dati['userIscritto'] = $this->utenteIscritto($evento);

        return $dati;
    }

    /**
     * Verifica se l'utente attualmente loggato è già iscritto a questo evento.
     */
    protected function utenteIscritto(EEvento $evento): bool {
        if (!$this->isLoggedIn() || USession::getSessionElement('ruolo') !== 'utente') {
            return false;        
        }
        $idUtente = USession::getSessionElement('id_persona');

        foreach ($evento->getPartecipazioni() as $partecipazione) {
            if ($partecipazione->getUtente()->getIdPersona() === $idUtente) {
                return true;
            }
        }

        return false;
    }

    /**
     * Estrae il podio (1°/2°/3°) di un torneo concluso. Restituisce solo le
     * posizioni effettivamente assegnate.
     */
    protected function estraiPodioTorneo(ETorneo $torneo): array {
        $podio = [];
        foreach ($torneo->getPartecipazioni() as $partecipazione) {
            $posizione = $partecipazione->getPosizioneInClassifica();
            if ($posizione !== null && $posizione >= 1 && $posizione <= 3) {
                $podio[$posizione] = [
                    'posizione' => $posizione,
                    'utente' => [
                        'id' => $partecipazione->getUtente()->getIdPersona(),
                        'nome' => $partecipazione->getUtente()->getNomePersona(),
                    ],
                ];
            }
        }
        ksort($podio); //ksort() ordina un array in base alla chiave, in ordine crescente
        return array_values($podio);
    }

    /**
     * Verifica se la classifica finale di una challenge è già stata generata,
     * controllando se almeno una partecipazione "di challenge" ha già una
     * posizione asseganta (prima della generazione sono tutte null).
     */
    protected function isClassificaChallengeGenerata(EChallenge $challenge): bool {
        foreach ($challenge->getPartecipazioni() as $partecipazione) {
            if ($partecipazione->getPosizioneInClassifica() !== null) {
                return true;
            }
        }
        return false;
    }

    /**
     * Estrae la classifica finale completa (non solo il podio) di una challenge
     * già generata, ordinata per posizione crescente.
     */
    protected function estraiClassificaChallenge(EChallenge $challenge): array {
        $classifica = [];
        foreach ($challenge->getPartecipazioni() as $partecipazione) {
            if ($partecipazione->getPosizioneInClassifica() !== null) {
                $classifica[] = [
                    'posizione' => $partecipazione->getPosizioneInClassifica(),
                    'punteggioTotale' => $partecipazione->getPunteggioTotale(),
                    'utente' => [
                        'id' => $partecipazione->getUtente()->getIdPersona(),
                        'nome' => $partecipazione->getUtente()->getNomePersona(),
                    ],
                ];
            }
        }
        //usort() ordina un array in base ai valori, usando una funzione di confronto 
        //(qui ksort() non funzionerebbe perché $classifica è un array).
        usort($classifica, fn($a, $b) => $a['posizione'] <=> $b['posizione']); //<=> restituisce -1, 0, 1 se $a è minore, uguale o maggiore di $b
        return $classifica;
    }

    /**
     * Elenco dei tornei di una challenge senza podio ancora registrato:
     * usato solo lato gestore, per sapere cosa manca prima di poter generare
     * la classifica finale (stessa verifica fatta anche dentro generaClassificaChallenge()). 
     */
    protected function torneiSenzaEsito(EChallenge $challenge): array {
        $mancanti = [];
        foreach ($challenge->getTornei() as $torneo) {
            $haPodio = false;
            foreach ($torneo->getPartecipazioni() as $partecipazione) {
                if ($partecipazione->getPosizioneInClassifica() === 1) {
                    $haPodio = true;
                    break;
                }
            }
            if (!$haPodio) {
                $mancanti[] = ['id' => $torneo->getIdEvento(), 'nome' => $torneo->getNomeEvento()];
            }
        }
        return $mancanti;
    }

    // INDIRIZZI 
    /**
     * Converte un EIndirizzo in array associativo per Presentation.
     */
    protected function indirizzoToArray(EIndirizzo $indirizzo): array {
        return [
            'id'            => $indirizzo->getIdIndirizzo(),
            'nome'          => $indirizzo->getNome(),
            'via'           => $indirizzo->getVia(),
            'citta'         => $indirizzo->getCitta(),
            'cap'           => $indirizzo->getCap(),
            'provincia'     => $indirizzo->getProvincia(),
            'nazione'       => $indirizzo->getNazione(),
            'nome_citofono' => $indirizzo->getNomeCitofono(),
            'predefinito'   => $indirizzo->isPredefinito(),
        ];
    }

    /**
     * Converte un array di EIndirizzo in array associativo per Presentation.
     */
    protected function indirizziToArray(array $indirizzi): array {
        $risultato = [];
        foreach ($indirizzi as $indirizzo) {
            $risultato[] = $this->indirizzoToArray($indirizzo);
        }
        return $risultato;
    }

    // METODI DI PAGAMENTO

    /**
     * Converte un ECartaDiCredito in array associativo per Presentation.
     */
    protected function cartaToArray(ECartaDiCredito $carta): array {
        return [
            'id' => $carta->getIdCartaDiCredito(),
            'titolare' => $carta->getNomeTitolare(),
            'ultimeQuattroCifre' => $carta->getNumeroMascherato(),
            'scadenza' => $carta->getScadenzaFormattata(),
        ];
    }

    /**
     * Converte un array di ECartaDiCredito in array associativo per Presentation.
     */
    protected function carteToArray(array $carte): array {
        $risultato = [];
        foreach ($carte as $carta) {
            $risultato[] = $this->cartaToArray($carta);
        }
        return $risultato;
    }

    /**
     * Recupera (se 'salvata') o crea ed eventualmente persiste (se 'nuova') la carta di
     * credito da usare per il pagamento. Centralizza qui anche il controllo di scadenza,
     * che vale per entrambi i casi (per le carte nuove è ridondante col controllo già
     * fatto nel costruttore di ECartaDiCredito, ma lo teniamo per sicurezza e uniformità).
     */
    protected function risolviCartaPagamento(string $sceltaCarta, ?int $idCartaSalvata, EUtente $utente, PaymentInterface $bancaService): ECartaDiCredito {
        if ($sceltaCarta === 'salvata') {
            if (!$idCartaSalvata) {
                throw new InvalidArgumentException("Seleziona una delle tue carte salvate.");
            }

            $carta = FPersistentManager::PMgetObjOnAttribute(ECartaDiCredito::class, 'idCartaDiCredito', $idCartaSalvata);

            if (!$carta || $carta->getUtente()->getIdPersona() !== $utente->getIdPersona()) {
                throw new InvalidArgumentException("La carta selezionata non è valida.");
            }
        } elseif ($sceltaCarta === 'nuova') {
            //Recuperiamo i dati della nuova carta inseriti al momento
            $numeroCarta = UHTTPMethods::postString('numero_carta');
            $cvv = UHTTPMethods::postString('cvv');
            $titolare = UHTTPMethods::postString('titolare_carta');
            $scadenza = UHTTPMethods::postString('scadenza_carta');
            $salvaCarta = UHTTPMethods::postBool('salva_carta_profilo');

            if (empty($numeroCarta) || empty($cvv) || empty($titolare) || empty($scadenza)) {
                throw new InvalidArgumentException("Tutti i campi di pagamento sono obbligatori.");
            }

            //Generazione del token
            $risultatoToken = $bancaService->generaToken($numeroCarta, $cvv);

            $carta = new ECartaDiCredito($utente, $titolare, $scadenza, $risultatoToken['ultimeQuattroCifre'], $risultatoToken['token']);

            //Salvataggio della carta nel DB
            if ($salvaCarta) {
                FPersistentManager::PMsaveObj($carta);
            }
        } else {
            throw new InvalidArgumentException("Seleziona un metodo di pagamento valido.");
        }

        if ($carta->isScaduta()) {
            throw new InvalidArgumentException("La carta di credito utilizzata è scaduta.");
        }

        return $carta;
    }


    // CARRELLO (metodi utili sia per CCarrello che per CCheckout)

    /**
     * Costruisce le righe del carrello con le entity reali dei prodotti (non array),
     * più la quantità di ciascuna riga. Pensato per manipolare i prodotti
     * (es. creare un ordine), non solo per visualizzarli.
     */
    protected function buildCarrelloEntities(array &$carrello): array {
        if (empty($carrello)) {
            return [];
        }

        $idsProdotto = array_keys($carrello);
        $prodottiCaricati = FPersistentManager::PMgetObjListOnAttribute(EProdotto::class, 'idProdotto', $idsProdotto);

        $prodottiIndicizzati = [];
        foreach ($prodottiCaricati as $prodotto) {
            $prodottiIndicizzati[$prodotto->getIdProdotto()] = $prodotto;
        }

        $righeCarrello = [];
        $idsDaRimuovere = [];

        foreach ($carrello as $idProdotto => $quantita) {
            $prodotto = $prodottiIndicizzati[$idProdotto] ?? null;

            if (!$prodotto) {
                $idsDaRimuovere[] = $idProdotto; //così verrà rimosso e non verrà contato in aggiornaQuantita()
                continue; //salta il prodotto e passa al prossimo
            }

            $righeCarrello[] = [
                'prodotto' => $prodotto, //qui c'è l'entity vera, non l'array
                'quantita' => $quantita,
            ];
        }

        //Pulizia: rimuove dalla sessione i prodotti non più trovati nel DB,
        //così n_articoli e il carrello restano coearenti con ciò che l'utente vede.
        if (!empty($idsDaRimuovere)) {
            foreach ($idsDaRimuovere as $idProdotto) {
                unset($carrello[$idProdotto]);
            }
            USession::setSessionElement('carrello', $carrello);
        }

        return $righeCarrello;

    }


    /**
     * Costruisce l'array di righe del carrello, ciascuna con i dati reali del prodotto
     * (tramite prodottoToArray, stessa convenzione usata in home/catalogo/prodotto),
     * più i campi specifici della riga carrello (quantità, subtotale, url azioni).
     * E' un wrapper "di presentazione" sul metodo buildCarrelloEntities. Ci limitiamo qui
     * a convertire le entity in array per la View.
     */
    protected function buildCarrelloItems(array &$carrello): array { //con & prima di $carrello la funzione riceve un riferimento diretto alla variabile originale (per aggiornare la quantità)
        $righeCarrello = $this->buildCarrelloEntities($carrello);
 
        $carrelloItems = [];
        foreach ($righeCarrello as $riga) {
            $prodottoArray = $this->prodottoToArray($riga['prodotto']);
            //Prezzo effettivo da usare per i calcoli: scontato se presente, altrimenti pieno
            $prodottoArray['prezzo_unitario'] = $prodottoArray['prezzo_scontato'] ?? $prodottoArray['prezzo'];

            $carrelloItems[] = [
                'quantita' => $riga['quantita'],
                'subtotale' => $prodottoArray['prezzo_unitario'] * $riga['quantita'],
                'prodotto' => $prodottoArray,
            ];
        }
 
        return $carrelloItems;
    }

    /**
     * Calcola i totali del carrello a partire dalle righe già costruite da buildCarrelloItems,
     * evitando di ricalcolare prezzi o ricontattare il DB.
     */
    protected function buildCarrelloSummary(array $carrelloItems, array $carrello): array {
        $totale = 0.00;
        $totaleSconto = 0.00;
 
        foreach ($carrelloItems as $item) {
            $totale += $item['subtotale'];
 
            if ($item['prodotto']['sconto']) {
                $risparmioUnitario = $item['prodotto']['prezzo'] - $item['prodotto']['prezzo_unitario'];
                $totaleSconto += $risparmioUnitario * $item['quantita'];
            }
        }
 
        return [
            'n_articoli' => array_sum($carrello), //somma tutte le quantità nel carrello (0 se carrello vuoto)
            'sconto' => $totaleSconto,
            'totale' => $totale,
        ];
    }

    // GENERICI 

    /**
     * Formatta un importo come stringa con 2 decimali fissi, usando il 
     * punto come separatore. Necessario perché alcuni .tpl in Presentation
     * non applicano number_format(), quindi il dato deve arrivare già pronto
     * per la stampa duretta.
     */
    protected function formattaImporto(float $importo): string {
        return number_format($importo, 2, '.', '');
    }

    /**
     * Estrae il contenuto binario dell'immagine caricata via form, se presente (opzionale).
     * L'immagine è opzionale: se non viene caricata, restituisce null
     * senza sollevare errori. Se invece è stato tentato un upload ma è fallito
     * per un motivo reale (file troppo grande, tipo non valido, ecc.),
     * lasciamo che postFile() lanci l'eccezione, che verrà gestita dal chiamante.
     */
    protected function estraiImmagine(string $nomeCampo = 'imgProdotto'): ?string { 
        if (!isset($_FILES[$nomeCampo]) || $_FILES[$nomeCampo]['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }
        $file = UHTTPMethods::postFile($nomeCampo); //se arriviamo qui, un file c'era: se fallisce ora è un vero errore
        return file_get_contents($file['tmp_name']);
    }

    //==========================================================================
    // HELPER PRIVATI
    //==========================================================================

    /**
     * Verifica la presenza del cookie Remember Me e, se valido,
     * ripristina la sessione dell'utente in modo trasparente.
     */
    private function controllaRememberMe(): void {
        //Se l'utente è già loggaro in sessione, non dobbiamo fare nulla
        if ($this->isLoggedIn()) {
            return;
        }

        //Cerchiamo se il browser ha il cookie del "Remember Me"
        $token = UCookie::getCookie('remember_me');

        if ($token) {
            //Chiediamo al DB se esiste un utente con questo token preciso
            $utente = FPersistentManager::PMgetObjOnAttribute(EUtente::class, 'rememberToken', $token);

            if ($utente) {
                //Se il token coincide, ripristiniamo la sessione
                USession::setSessionElement('id_persona', $utente->getIdPersona());
                USession::setSessionElement('ruolo', 'utente');
                USession::setSessionElement('nickname', $utente->getNomePersona());
            } else {
                //Se il cookie sul PC è alterato o scaduto sul DB, lo cancelliamo per sicurezza
                UCookie::deleteCookie('remember_me');
            }
        }
    }

}