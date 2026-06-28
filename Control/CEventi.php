<?php
namespace TableCrown\Control;

use TableCrown\Control\BaseController;
use TableCrown\Utility\USession;
use TableCrown\Utility\UHTTPMethods;
use TableCrown\Utility\UFlashMessage;
use TableCrown\Entity\EEvento;
use TableCrown\Entity\ESerata;
use TableCrown\Entity\ETorneo;
use Tablecrown\Entity\EChallenge;
use TableCrown\Entity\EPrezzo;
use TableCrown\Entity\EProdotto;
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

    /**
     * URL: /eventi (Accesso libero)
     */
    public function mostraEventi(): void {
        $eventi = [];
        //QUANDO SARÀ PRONTO FOUNDATION:
        //$eventi = FPersistentManager::getAll(EEvento::class);

        $datiLayout = $this->preparaDatiLayout('eventi', ['eventi' => $eventi]);
        //QUANDO SARÀ PRONTO PRESENTATION:
        //VEventi::mostraEventi($datiLayout);
        echo "Pagina pubblica: Elenco eventi";
    }

    /**
     * URL: /eventi/dettaglio?id=X (Accesso libero)
     */
    public function mostraDettaglioEvento(): void {
        //Recuperiamo l'ID dell'evento da visualizzare
        $idEvento = UHTTPMethods::get('id');
        if (!$idEvento) {
            header('Location: /eventi');
            exit();
        }

        $evento = null;
        //QUANDO SARÀ PRONTO FOUNDATION:
        //$evento = FPersistentManager::visualizza(EEvento::class, 'idEvento', $idEvento);

        $datiLayout = $this->preparaDatiLayout('eventi', ['evento' => $evento]);
        //QUANDO SARÀ PRONTO PRESENTATION:
        //VEventi::mostraDettaglioEvento($datiLayout);
        echo "Pagina pubblica: Dettaglio evento" . $idEvento;
    }

    /**
     * URL: /eventi/partecipa (Riservato Utente Loggato)
     */
    public function partecipaEvento(): void {
        $this->requireRole('utente');
        $idEvento = UHTTPMethods::post('id_evento');

        //QUANDO SARÀ PRONTO FOUNDATION:
        //Inserimento Entity EPartecipazione nel DB tramite FParsistentManager

        UFlashMessage::addMessage('success', 'Partecipazione effettuata con successo!');
        header('Location: /eventi/dettaglio?id=' . $idEvento);
        exit();
    }

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
            header('Location: /gestore/eventi/nuovo');
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
            header('Location: /gestore/eventi');
            exit();
        }

        //Interroghiamo Foundation per recuperare l'oggetto reale dal DB
        $evento = null;
        //QUANDO SARÀ PRONTO FOUNDATION:
        //$evento = FPersistentManager::visualizza(EEvento::class, 'idEvento', $idEvento);

        //Controllo di sicurezza (evento esistente)
        if (!$evento) {
            UFlashMessage::addMessage('danger', 'L\'evento selezionato non esiste.');
            header('Location: /gestore/eventi');
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