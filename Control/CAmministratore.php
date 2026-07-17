<?php
namespace TableCrown\Control;

use TableCrown\Utility\UFlashMessage;
use TableCrown\Utility\UHTTPMethods;
use TableCrown\Entity\EUtente;
use TableCrown\Entity\ERecensione;
use TableCrown\Entity\ESegnalazione;
use TableCrown\Foundation\FPersistentManager;
use TableCrown\Presentation\Views\ViewAdminFactory;
use DateTime;

class CAmministratore extends BaseController {

    private const DURATA_SOSPENSIONE = '+3 months';
    private const PESI_GRAVITA = [
        'bassa' => 1,
        'media' => 2,
        'alta' => 3,
    ];

    public function __construct() {
        parent::__construct(); 
        $this->requireRole('amministratore');
    }

    //==========================================================================
    // RICHIESTE GET
    //==========================================================================

    /**
     * Mostra la dashboard dell'amministratore.
     * URL: GET /admin/dashboard
     */
    public function mostraDashboardAdmin(): void {
        //Recupero dati statistici quantitativi
        $segnalazioniInSospeso = FPersistentManager::PMcontaSegnalazioniInSospeso(); //TODO: metodo da implementare

        $utentiTotali = FPersistentManager::PMcontaUtentiTotali(); //TODO: metodo da implementare
        $utentiNuoviOggi = FPersistentManager::PMcontaUtentiNuoviOggi(); //TODO: metodo da implementare

        $utentiSospesiTotali = FPersistentManager::PMcontaUtentiSospesiTotali(); //TODO: metodo da implementare
        $utentiSospesiOggi = FPersistentManager::PMcontaUtentiSospesiOggi(); //TODO: metodo da implementare

        //TODO: aggiungere ordinamento in base alla gravità delle motivazioni delle segnalazioni?
        $segnalazioniUrgentiGrezze = FPersistentManager::PMgetSegnalazioniUrgenti('ASC', 5); //TODO: DA CAMBIARE, NE SERVONO 5 MA BISOGNA ORDINARE I CASE DI GRAVITAMOTIVAZIONE
        $segnalazioniUrgenti = $this->segnalazioniToArray($segnalazioniUrgentiGrezze); //TODO: metodo da implementare

        //Impacchettiamo i dati per Presentation
        $datiPagina = [
            'vista' => 'admin_dashboard',
            'segnalazioniInSospeso' => $segnalazioniInSospeso,
            'utentiTotali' => $utentiTotali,
            'utentiNuoviOggi' => $utentiNuoviOggi,
            'utentiSospesiTotali' => $utentiSospesiTotali,
            'utentiSospesiOggi' => $utentiSospesiOggi,
            'segnalazioniUrgenti' => $segnalazioniUrgenti,
        ];

        //Se marco vuole seguire la struttura delle View usata per il profilo degli utenti (con ViewProfiloFactory che prende tutte le chiamate e indirizza poi alle singole View)
        $datiLayout = $this->preparaDatiLayout('admin_dashboard', $datiPagina);
        ViewAdminFactory::mostraDashboard($datiLayout);
    }

    /**
     * Mostra la lista degli utenti che hanno almeno una recensione segnalata.
     * URL: GET /admin/utenti
     */
    public function mostraListaUtentiAdmin(): void {
        //TODO: metodo del pm da implementare
        //dovrebbe restituire un array di righe tipo ['utente' => EUtente, 'numeroSegnalazioni' => int], una
        //per ogni utente che ha almeno una recensione con almeno una segnalazione in sospeso.
        $righeGrezze = FPersistentManager::PMfindUtentiConRecensioniSegnalate('DESC'); 

        $utenti = array_map(
            fn($riga) => $this->utenteAdminToArray($riga['utente'], $riga['numeroSegnalazioni']),
            $righeGrezze
        );

        $datiLayout = $this->preparaDatiLayout('admin_lista_utenti', ['utenti' => $utenti]);

        ViewAdminFactory::mostraListaUtenti($datiLayout);
    }

    /**
     * Visualizza il profilo di uno specifico utente dal punto di vista dell'amministratore.
     * URL: GET /admin/utente/profilo?id=XX
     */
    public function mostraProfiloUtenteAdmin(): void {
        try {
            $idUtente = UHTTPMethods::get('id');
        } catch (\InvalidArgumentException $e) {
            UFlashMessage::addMessage('danger', 'ID utente non valido.' . $e->getMessage());
            header('Location: ' . BASE_URL . '/admin/dashboard');
            exit();
        }

        //Recuperiamo l'utente specifico
        $utente = FPersistentManager::PMgetObjOnAttribute(EUtente::class, 'idPersona', $idUtente);

        if (!$utente) {
            UFlashMessage::addMessage('danger', 'L\'utente non esiste.');
            header('Location: ' . BASE_URL . '/admin/dashboard');
            exit();
        }

        //Recuperiamo lo storico delle recensioni di questo utente che hanno ricevuto almeno una segnalazione
        $recensioniSegnalate = FPersistentManager::PMgetObjListOnAttribute(ERecensione::class, 'idPersona', $idUtente); 

        $datiLayout = $this->preparaDatiLayout('admin_profilo_utente', [
            'utente' => $utente->utenteAdminToArray(),
            'recensioniSegnalate' => $this->recensioniToArray($recensioniSegnalate),
        ]);

        ViewAdminFactory::mostraProfiloUtente($datiLayout);
    }

    /**
     * Mostra la lista delle recensioni che hanno ricevuto almeno una segnalazione.
     * URL: GET /admin/recensioni
     */
    public function mostraListaRecensioniAdmin(): void {
        //TODO: metodo del pm da implementare
        //dovrebbe restituire un array di righe tipo ['recensione' => ERecensione, 'numeroSegnalazioni' => int]
        $righeGrezze = FPersistentManager::PMfindRecensioniConSegnalazioni('DESC'); 

        //TODO: aggiungere filtro ordinamento con opzioni 'grevita' e 'recenti'???

        $recensioni = array_map(
            fn($riga) => $this->recensioneAdminToArray($riga['recensione'], $riga['numeroSegnalazioni']),
            $righeGrezze
        );

        $datiLayout = $this->preparaDatiLayout('admin_lista_recensioni', ['recensioni' => $recensioni]);

        ViewAdminFactory::mostraListaRecensioni($datiLayout);

    }

    //==========================================================================
    // RICHIESTE POST (OPERAZIONI CRUD)
    //==========================================================================

    /**
     * Sospende un utente per una durata fissa di 3 mesi.
     * URL: POST /admin/utente/sospendi
     */
    public function sospendiUtenteAdmin(): void {
        try {
            $idUtente = UHTTPMethods::postInt('id_persona');
        } catch (\InvalidArgumentException $e) {
            UFlashMessage::addMessage('danger', 'Impossibile elaborare la richiesta: ' . $e->getMessage());
            header('Location: ' . BASE_URL . '/admin/dashboard');
            exit();
        }

        $utente = FPersistentManager::PMgetObjOnAttribute(EUtente::class, 'idPersona', $idUtente);

        if (!$utente) {
            UFlashMessage::addMessage('danger', 'L\'utente non esiste.');
            header('Location: ' . BASE_URL . '/admin/dashboard');
            exit();
        }

        try {
            //Calcoliamo la data di fine sospensione, aggiungendo esattamente 3 mesi alla data di oggi
            $dataFine = new DateTime();
            $dataFine->modify(self::DURATA_SOSPENSIONE); //DA CAMBIARE: FORSE MEGLIO FARE UNA COSTANTE ALL'INIZIO TIPO DURATASOSPENSIONE E POI USARE QUELLA?

            //Applichiamo la sospensione tramite il metodo dell'entity
            $utente->sospendi($dataFine);

            //Salviamo lo stato aggiornato nel DB
            FPersistentManager::PMsaveObj($utente);

            UFlashMessage::addMessage('success', 'L\'utente è stato sospeso fino al ' . $dataFine->format('d/m/Y') . '.');
        } catch (\DomainException | \InvalidArgumentException $e) {
            UFlashMessage::addMessage('danger', 'Impossibile sospendere l\'utente: ' . $e->getMessage());
        } 

        //Reindirizziamo alla pagina del profilo dell'utente appena modificato
        header('Location: ' . BASE_URL . '/admin/utente/profilo?id=' . $idUtente);
        exit();
    }

    /**
     * Banna permanentemente un utente.
     * URL: POST /admin/utente/banna
     */
    public function bannaUtenteAdmin(): void {
        try {
            $idUtente = UHTTPMethods::postInt('id_persona');
        } catch (\InvalidArgumentException $e) {
            UFlashMessage::addMessage('danger', 'Impossibile elaborare la richiesta: ' . $e->getMessage());
            header('Location: ' . BASE_URL . '/admin/dashboard');
            exit();
        }

        $utente = FPersistentManager::PMgetObjOnAttribute(EUtente::class, 'idPersona', $idUtente);

        if (!$utente) {
            UFlashMessage::addMessage('danger', 'L\'utente non esiste.');
            header('Location: ' . BASE_URL . '/admin/dashboard');
            exit();
        }

        try {
            $utente->banna();

            //Salviamo lo stato del utente nel DB
            FPersistentManager::PMsaveObj($utente);

            UFlashMessage::addMessage('success', 'L\'utente è stato permanentemente bannato con successo!');
        } catch (\DomainException | \InvalidArgumentException $e) {
            UFlashMessage::addMessage('danger', 'Impossibile bannare l\'utente: ' . $e->getMessage());
        }

        header('Location: ' . BASE_URL . '/admin/utente/profilo?id=' . $idUtente);
        exit();
    }

    //==========================================================================
    // HELPER PRIVATI
    //==========================================================================

    /**
     * Converte un ESegnalazione in un array associativo per Presentation.
     * Se serve anche in altre parti, spostare in BaseController.
     */
    private function segnalazioneToArray(ESegnalazione $segnalazione): array {
        return [
            'id' => $segnalazione->getIdSegnalazione(),
            'data' => $segnalazione->getDataSegnalazione()->format('Y-m-d H:i:s'),
            'stato' => $segnalazione->getStatoSegnalazione()->value, 
            'motivazione' => [
                'id' => $segnalazione->getMotivazione()->getIdMotivazione(),
                'nome' => $segnalazione->getMotivazione()->getNomeMotivazione(),
                'gravita' => $segnalazione->getMotivazione()->getGravitaMotivazione()->value,
            ],
            'utenteSegnalante' => [
                'id' => $segnalazione->getUtenteSegnalante()->getIdPersona(),
                'nome' => $segnalazione->getUtenteSegnalante()->getNomePersona(),
            ],
            'autoreRecensione' => [
                'id' => $segnalazione->getRecensione()->getUtente()->getIdPersona(),
                'nome' => $segnalazione->getRecensione()->getUtente()->getNomePersona(),
            ],
            'prodotto' => [
                'id' => $segnalazione->getRecensione()->getProdotto()->getIdProdotto(),
                'nome' => $segnalazione->getRecensione()->getProdotto()->getNomeProdotto(),
            ]
        ];
    }

    /**
     * Converte un array di ESegnalazione in array associativo per Presentation.
     * Se serve anche in altre parti, spostare in BaseController.
     */
    private function segnalazioniToArray(array $segnalazioni): array {
        $risultato = [];
        foreach ($segnalazioni as $segnalazione) {
            $risultato[] = $this->segnalazioneToArray($segnalazione);
        }
        return $risultato;
    }

    /**
     * Converte un EUtente in un array associativo per la card admin, con conteggio segnalazioni.
     */
    private function utenteAdminToArray(EUtente $utente, int $numeroSegnalazioni): array {
        return [
            'id' => $utente->getIdPersona(),
            'nome' => $utente->getNomePersona(),
            'stato' => $utente->getStato()->value,
            'numeroSegnalazioni' => $numeroSegnalazioni,
        ];
    }

    /**
     * Converte un ERecensione in un array associativo per la card admin, con conteggio segnalazioni.
     * TODO: NON MI PIACEEEE, DA OTTIMIZZARE/MODIFICARE
     */
    private function recensioneAdminToArray(ERecensione $recensione, int $numeroSegnalazioni): array {
        $segnalazioni = $recensione->getSegnalazioni();

        $gravitaMax = 'bassa';
        $idPuntaSegnalazione = null;
        $puntaggioMax = 0;
        foreach ($segnalazioni as $segnalazione) {
            //Estraggo il valore stringa dell'enum ('bassa'|'media'|'alta')
            $stringaGravita = $segnalazione->getMotivazione()->getGravitaMotivazione()->value;

            //Recupero il peso numerico dalla costante del controller
            $pesoCorrente = self::PESI_GRAVITA[$stringaGravita] ?? 0;

            if ($pesoCorrente > $puntaggioMax) {
                $punteggioMax = $pesoCorrente;
                $gravitaMax = $stringaGravita;
                $idPuntaSegnalazione = $segnalazione->getIdSegnalazione();
            }
        }

        return [
            'id' => $recensione->getIdRecensione(),
            'testo' => $recensione->getTesto(),
            'data' => $recensione->getData()->format('Y-m-d H:i:s'),
            'gravita' => $gravitaMax, //stringa 'bassa'|'media'|'alta'
            'idSegnalazioneDaRisolvere' => $idPuntaSegnalazione, //per POST /admin/recensioni/rigetta
            'autore' => [
                'id' => $recensione->getUtente()->getIdPersona(),
                'nome' => $recensione->getUtente()->getNomePersona(),
            ],
            'prodotto' => [
                'id' => $recensione->getProdotto()->getIdProdotto(),
                'nome' => $recensione->getProdotto()->getNomeProdotto(),
            ],
            'numeroSegnalazioni' => $numeroSegnalazioni,
        ];
    }

    public function getBreadcrumbs(string $currentPage = ''): array { //DA RIVEDERE: A COSA SERVE currentPage? FORSE PER PAGINE DELL'ADMIN NON DOVREI METTERE 'Home' MA DIRETTAMENTE 'Dashboard Admin'?
        $breadcrumbs = [
            ['label' => 'Home', 'url' => BASE_URL . '/'],
            ['label' => 'Dashboard Admin', 'url' => BASE_URL . '/admin/dashboard'],
        ];
        return match ($currentPage) {
            'dashboard' => [
                ['label' => 'Home', 'url' => BASE_URL . '/'],
                ['label' => 'Dashboard Admin', 'url' => BASE_URL . '/admin/dashboard'],
            ],
            'lista_utenti' => array_merge($breadcrumbs, [
                ['label' => 'Utenti Segnalati', 'url' => BASE_URL . '/admin/utenti'],
            ]),
            'lista_recensioni' => array_merge($breadcrumbs, [
                ['label' => 'Recensioni Segnalate', 'url' => BASE_URL . '/admin/recensioni'],
            ]),
            default => array_merge($breadcrumbs, [
                ['label' => 'Utenti Segnalati', 'url' => BASE_URL . '/admin/utenti'],
                ['label' => 'Profilo: ' . $currentPage, 'url' => '#']
            ]),
        };
    }

}