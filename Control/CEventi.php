<?php
namespace TableCrown\Control;

use TableCrown\Control\BaseController;
use TableCrown\Utility\USession;
use TableCrown\Utility\UHTTPMethods;
use TableCrown\Utility\UFlashMessage;
use TableCrown\Entity\EEvento;
use TableCrown\Entity\ESerata;
use TableCrown\Entity\ETorneo;
use TableCrown\Entity\EChallenge;
use TableCrown\Entity\EPrezzo;
use TableCrown\Entity\EProdotto;
use TableCrown\Foundation\FPersistentManager;
use TableCrown\Presentation\Views\ViewEventi;
use DateTime;

/**
 * Controller deputato alla gestione del ciclo di vita degli eventi.
 * Gestisce la visualizzazione pubblica, le iscrizioni (utenti) e la creazione/modifica (gestore).
 */
class CEventi extends BaseController {
    public function __construct() {
        parent::__construct();
    }

    //==========================================================================
    // AREA PUBBLICA / UTENTE
    //==========================================================================

    //VISUALIZZAZIONE

    /**
     * Mostra l'hub degli eventi.
     * Corrisponde alla pagina con le tre card ("Serate", "Tornei", "Challenge"),
     * che portano rispettivamente al catalogo delle serate, al catalogo dei tornei
     * e al catalogo delle challenge.
     */
    public function mostraHubEventi(): void {
        $datiPagina = ['vista' => 'eventi_home'];
        $datiLayout = $this->preparaDatiLayout('eventi_home', $datiPagina);

        //Chiamata alla View
        ViewEventi::mostraEventi($datiLayout); 
    }

    /**
     * Mostra la lista di eventi di tipo serata.
     * URL: /eventi/serata
     */
    public function mostraListaSerate(): void {
        $filtroData = $this->estraiFiltroData();

        $serate = FPersistentManager::PMfindSerate($filtroData); 

        $this->renderListaEventi('eventi_serate', $serate, $filtroData); 
        
    }

    /**
     * Mostra la lista di eventi di tipo torneo.
     * URL: /eventi/torneo
     */
    public function mostraListaTornei(): void {
        $filtroData = $this->estraiFiltroData();

        $tornei = FPersistentManager::PMfindTornei($filtroData);

        $this->renderListaEventi('eventi_tornei', $tornei, $filtroData); 
    }

    /**
     * Mostra la lista di eventi di tipo challenge.
     * URL: /eventi/challenge
     */
    public function mostraListaChallenge(): void {
        $filtroData = $this->estraiFiltroData();

        $challenge = FPersistentManager::PMfindChallenge($filtroData);

        $this->renderListaEventi('eventi_challenge', $challenge, $filtroData); 
    }

    /**
     * Mostra i risultati della ricerca per gli eventi.
     * La barra di ricerca dedicata agli eventi invierà una richiesta GET qui
     * URL: GET /eventi/ricerca
     */
    public function mostraRisultatiRicercaEventi(): void {
        $query = UHTTPMethods::get('q');

        if ($query === null || trim($query) === '') {
            //Se non c'è nessun termine di ricerca, reindirizziamo al catalogo principale dei giochi (DA DECIDERE!!!!!!!)
            header("Location: " . BASE_URL . "/eventi");
            exit();
        }

        $query = trim($query);

        //TODO: serve il metodo nel pm
        $eventiTrovati = FPersistentManager::PMricercaEventi($query);

        $this->renderListaEventi('ricerca', $eventiTrovati, null, $query); 
    }


    //==========================================================================
    // METODI PRIVATI CONDIVISI
    //==========================================================================

    /**
     * Costruisce i dati comuni a tutte le pagine lista eventi e delega il render.
     */
    private function renderListaEventi(string $vista, array $risultatoGrezzo, ?string $filtroData = null, ?string $ricerca = null): void { 

        $datiPagina = [
            'vista'  => $vista,
            'eventi' => $this->eventiToArray($risultatoGrezzo),
            'filtri' => [
                'filtro_data' => $filtroData,
                'ricerca' => $ricerca,
            ],
        ];

        $datiLayout = $this->preparaDatiLayout($vista, $datiPagina);
        ViewEventi::mostraEventi($datiLayout);
    }

    /**
     * Legge il filtro data dalla request (formato atteso: YYYY-MM-DD) e lo converte
     * in DateTime per l'uso interno nella query; ritorna null se assente/non valido.
     */
    private function estraiFiltroData(): ?string {
        $dataRaw = UHTTPMethods::get('filtro_data');
        if ($dataRaw === null || trim($dataRaw) === '') {
            return null;
        }
        //Validazione: verifichiamo che sia una data valida
        $d = DateTime::createFromFormat('Y-m-d', $dataRaw);
        return ($d && $d->format('Y-m-d') === $dataRaw) ? $dataRaw : null;
    }

    protected function getBreadcrumbs(string $currentPage = ''): array {
        return [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Eventi', 'url' => '/eventi']
        ];
    }















//DA CANCELLARE TUTTO QUELLO CHE SEGUE
    
    //==========================================================================
    // AREA GESTORE
    //==========================================================================

    /**
     * Mostra il form per la creazione di un nuovo evento.
     * URL: /gestore/eventi/nuovo (Accesso Riservato Gestore)
     */
    public function mostraFormCreaEvento(): void {
        $this->requireRole('gestore');

        $datiLayout = $this->preparaDatiLayout('form_evento');
        //QUANDO SARÀ PRONTO PRESENTATION:
        //VGestioneEventi::mostraFormCreaEvento($datiLayout);
        echo "Area gestore: Form di creazione nuovo evento.";
    }

    /**
     * Gestisce l'invio dei dati del form di creazione (Richiesta POST).
     * URL: /gestore/eventi/crea (Accesso Riservato Gestore)
     */
    public function creaEvento(): void {
        $this->requireRole('gestore');

        //Raccogliamo i dati comuni a qualsiasi tipo di evento
        $nome = UHTTPMethods::post('nome');
        $descrizione = UHTTPMethods::post('descrizione');
        $dataInizio = UHTTPMethods::post('data_inizio'); //Arriva come stringe dal form (es. "2022-01-01 00:00:00")
        $maxPartecipanti = (int) UHTTPMethods::post('max_partecipanti'); //type casting
        $tipoEvento = UHTTPMethods::post('tipo_evento');//"serata", "torneo", "challenge"

        //Gestione dell'immagine (Arriva tramite $_FILES)
        /**
         * Per standard nativo di PHP, l'array $_FILES viene strutturato in questo modo (valori di esempio):
         * [
         *     'name' => 'nome_foto.jpg',
         *     'type' => 'image/jpeg',
         *     'tmp_name' => '/tmp/php7p9u0p', // percorso temporaneo del file sul server
         *     'error' => 0,
         *     'size' => 1024
         * ]
         */
        $fileImmagine = UHTTPMethods::postFile('img_evento'); //Riceve l'array del file dall'utility

        //Controllo validità campi minimi della classe madre
        //Per il file immagine controlliamo che l'array esista e che non ci siano errori di caricamento (error === 0)
        if (!$nome || !$descrizione || !$dataInizio || !$maxPartecipanti || !$tipoEvento || !$fileImmagine || $fileImmagine['error'] !== UPLOAD_ERR_OK) {
            //Se manca uno di questi campi, impostiamo un messaggio di errore rapido
            UFlashMessage::addMessage('danger', 'Tutti i campi sono obbligatori.');
            //Pattern PRG: ricarichiamo la pagina del form per mostrare l'errore in sicurezza
            header('Location: ' . BASE_URL . '/gestore/eventi/nuovo');
            exit();
        }

        //Trasformazione dell'immagine in stringa (blob)
        //Leggiamo il file dal suo percorso temporaneo sul server e lo convertiamo in stringa binaria tramite una funziona nativa di PHP
        $imgBlob = file_get_contents($fileImmagine['tmp_name']);

        //Se il controllo passa, convertiamo in sicurezza la data in oggetto DateTime
        $dataInizio = new DateTime($dataInizio);

        //Istanziamo la variabile per il polimorfismo
        $nuovoEvento = null;

        //==========================================================================
        // LOGICA DI ISTANZIAZIONE TRAMITE POLIMORFISMO
        //==========================================================================
        if ($tipoEvento === 'serata') {
            //Recupero i dati specifici della serata
            $tipoSerata = UHTTPMethods::postString('tipo_serata');
            //il costruttore di ESerata farà semplicemente da ponte verso parent::__construct
            $nuovoEvento = new ESerata($nome, $imgBlob, $descrizione, $dataInizio, $maxPartecipanti, $tipoSerata); 
        }
         
        elseif ($tipoEvento === 'torneo') {
            //Recupero i dati specifici del torneo
            $valoreQuota = UHTTPMethods::postInt('quota_iscrizione');
            $idpremio = UHTTPMethods::postInt('id_premio');
            $idgioco = UHTTPMethods::postInt('id_gioco');

            //QUANDO SARÀ PRONTO FOUNDATION:
            /* 
            $gioco = FPersistentManager::visualizza(EProdotto::class, 'idProdotto', $idgioco);
            
            if (!$gioco) {
                UFlashMessage::addMessage('danger', 'Il gioco selezionato non è valido.');
                header('Location: /gestore/eventi/nuovo');
                exit();
            }

            //Se l'id del premio c'è lo cerchiamo, altrimenti passiamo null (visto che è nullable nel DB)
            $premio = $idpremio ? FPersistentManager::visualizza(EProdotto::class, 'idProdotto', $idpremio) : null;

            $quotaIscrizione = new EPrezzo($valoreQuota);

            //Istanziamo il torneo passando i parametri richiesti dal suo costruttore
            $nuovoEvento = new ETorneo($nome, $imgBlob, $descrizione, $dataInizio, $maxPartecipanti, $quotaIscrizione, $premio, $gioco);
            */
        }

        elseif ($tipoEvento === 'challenge') {
            //Recupero i dati specifici della challenge dal POST
            $valoreQuota = UHTTPMethods::postInt('quota_iscrizione');
            $idpremio = UHTTPMethods::postInt('id_premio');
            $punti1 = UHTTPMethods::postInt('punteggio_primo');
            $punti2 = UHTTPMethods::postInt('punteggio_secondo');
            $punti3 = UHTTPMethods::postInt('punteggio_terzo');
            //Recuperiamo l'array di ID dei tornei selezionati nel form (es. nome="torni_selezionati[]")
            //Se nessun torneo è selezionato, di default impostiamo un array vuoto
            $idTorneiSelezionati = UHTTPMethods::postArray('torni_selezionati');

            //==========================================================================
            // QUANDO SARÀ PRONTO IL PERSISTENT MANAGER:
            //==========================================================================
           /*  //Caricamento delle relazioni (Premio o Quota)
            $premio = FPersistentManager::visualizza(EProdotto::class, 'idProdotto', $idpremio);

            if (!$premio) {
                UFlashMessage::addMessage('danger', 'Il premio selezionato non è valido.');
                header('Location: /gestore/eventi/nuovo');
                exit();
            }

            $quotaIscrizione = new EPrezzo($valoreQuota); //DA CORREGGERE (RICHIEDE VALUTA)

            //Recuperiamo gli oggetti ETorneo dal DB
            $listaTornei = [];
            foreach ($idTorneiSelezionati as $idTorneo) {
                $torneo = FPersistentManager::visualizza(ETorneo::class, 'idEvento', $idTorneo);
                if ($torneo) {
                    $listaTornei[] = $torneo;
                }
            }

            //Istanziamo la challenge passando i parametri richiesti dal costruttore
            $nuovoEvento = new EChallenge($nome, $imgBlob, $descrizione, $dataInizio, $maxPartecipanti, $quotaIscrizione, $premio, $punti1, $punti2, $punti3, $listaTornei);
 */
        }


         
    }

    /**
     * Mostra il form per modificare un evento esistente.
     * URL: /gestore/eventi/modifica?=X (Accesso Riservato Gestore)
     */
    public function mostraFormModificaEvento(): void {
        $this->requireRole('gestore');

        //Recuperiamo l'ID dell'evento da modificare
        $idEvento = UHTTPMethods::get('id');
        if (!$idEvento) {
            UFlashMessage::addMessage('danger', 'ID evento non valido o mancante.');
            header('Location: ' . BASE_URL . '/gestore/eventi');
            exit();
        }

        //Interroghiamo Foundation per recuperare l'oggetto reale dal DB
        $evento = null;
        //QUANDO SARÀ PRONTO FOUNDATION:
        //$evento = FPersistentManager::visualizza(EEvento::class, 'idEvento', $idEvento);

        //Controllo di sicurezza (evento esistente)
        if (!$evento) {
            UFlashMessage::addMessage('danger', 'L\'evento selezionato non esiste.');
            header('Location: ' . BASE_URL . '/gestore/eventi');
            exit();
        }

        $datiLayout = $this->preparaDatiLayout('form_evento');

        //Inseriamo l'oggetto evento nei dati: serve alla View per precompilare i campi HTML
        $datiLayout['evento'] = $evento;
/* 
        //Se l'evento è un torneo o una challenge, la View potrebbe aver bisogno della lista di giochi o premi per popolare le tendine di select di modifica
        if ($evento instanceof ETorneo || $evento instanceof EChallenge) {
            $datiLayout['premi_disponibili'] = FPersistentManager::visualizzaTutti(EProdotto::class);
        }
        if ($evento instanceof EChallenge) {
            $datiLayout['tornei_disponibili'] = FPersistentManager::visualizzaTutti(ETorneo::class);
        }
 */
        
        //QUANDO SARÀ PRONTO PRESENTATION:
        //VGestioneEventi::mostraFormModificaEvento($datiLayout);
        echo "Area gestore: Form di modifica per l'evento" . $idEvento;
    }

    
}