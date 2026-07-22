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
        $segnalazioniInSospeso = FPersistentManager::PMcontaSegnalazioniInSospeso(); 

        $utentiTotali = FPersistentManager::PMcontaUtentiTotali(); 
        $utentiNuoviOggi = FPersistentManager::PMcontaUtentiNuoviOggi(); 

        $utentiSospesiTotali = FPersistentManager::PMcontaUtentiSospesiTotali(); 
        $utentiSospesiOggi = FPersistentManager::PMcontaUtentiSospesiOggi(); 

        $segnalazioniUrgentiGrezze = FPersistentManager::PMgetSegnalazioniUrgenti('ASC', 5); 
        $segnalazioniUrgenti = $this->segnalazioniToArray($segnalazioniUrgentiGrezze); 

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
        $datiGrezzi = FPersistentManager::PMfindUtentiConRecensioniSegnalate('DESC'); //restituisce ['risultati' => [['utente' => EUtente, 'numeroSegnalazioni' => int],[],...], 'totale' => int]

        //Gestione difensiva se $datiGrezzi è null o non ha la chiave 'risultati'
        $listaRisultati = $datiGrezzi['risultati'] ?? (is_array($datiGrezzi) ? $datiGrezzi : null);

        $utenti = [];
        foreach ($listaRisultati as $riga) {
            if (!is_array($riga)) {
                continue;
            }
            $utente = $riga['utente'] ?? null;
            $numeroSegnalazioni = $riga['numeroSegnalazioni'] ?? 0;
            if ($utente instanceof EUtente) { //verifichiamo se abbiamo un'istanza valida di EUtente
                $utenti[] = $this->utenteAdminToArray($utente, $numeroSegnalazioni);
            }
        }

        $datiLayout = $this->preparaDatiLayout('admin_lista_utenti', ['utenti' => $utenti, 'totale' => $datiGrezzi['totale'] ?? count($utenti)]);

        ViewAdminFactory::mostraListaUtenti($datiLayout);
    }

    /**
     * Visualizza il profilo di uno specifico utente dal punto di vista dell'amministratore.
     * URL: GET /admin/utente/profilo?id=XX
     */
    public function mostraProfiloUtenteAdmin(): void {
        $idUtenteRaw = UHTTPMethods::get('id');
        if ($idUtenteRaw === null || !is_numeric($idUtenteRaw)) {
            UFlashMessage::addMessage('danger', 'ID utente non valido.');
            header('Location: ' . BASE_URL . '/admin/dashboard');
            exit();
        }
        
        $idUtente = (int) $idUtenteRaw;

        //Recuperiamo l'utente specifico
        $utente = FPersistentManager::PMgetObjOnAttribute(EUtente::class, 'idpersona', $idUtente);

        if (!$utente) {
            UFlashMessage::addMessage('danger', 'L\'utente non esiste.');
            header('Location: ' . BASE_URL . '/admin/dashboard');
            exit();
        }

        //Calcoliamo il numero totale di segnalazioni ricevute dall'utente
        $conteggioSegnalazioni = 0;
        $recensioniSegnalate = [];

        foreach ($utente->getRecensioni() as $recensione) {
            $segnalazioniDellaRecensione = $recensione->getSegnalazioni();
            $numeroSegnalazioniRecensione = count($segnalazioniDellaRecensione);

            if ($numeroSegnalazioniRecensione > 0) {
                $conteggioSegnalazioni += $numeroSegnalazioniRecensione;
                $recensioniSegnalate[] = $recensione; //teniamo solo quelle effettivamente segnalate
            }
        }

        $datiLayout = $this->preparaDatiLayout('admin_profilo_utente', [
            'utenteProfilo' => $this->utenteAdminToArray($utente, $conteggioSegnalazioni), 
            'recensioniSegnalate' => $this->recensioniToArray($recensioniSegnalate),
        ]);

        ViewAdminFactory::mostraProfiloUtente($datiLayout);
    }

    /**
     * Mostra la lista delle recensioni che hanno ricevuto almeno una segnalazione.
     * URL: GET /admin/recensioni
     */
    public function mostraListaRecensioniAdmin(): void {
        $righeGrezze = FPersistentManager::PMfindRecensioniConSegnalazioni('DESC'); //restituisce ['risultati' => [['recensione' => ERecensione, 'numerosegnalazioni' => int],[],...], 'totale' => int]

        $listaRisultati = $righeGrezze['risultati'] ?? [];

        $recensioni = [];
        foreach ($listaRisultati as $riga) {
            $recensione = $riga['recensione'] ?? null;
            $numeroSegnalazioni = $riga['numerosegnalazioni'] ?? 0;

            $recensioni[] = $this->recensioneAdminToArray($recensione, (int)$numeroSegnalazioni);
        }
        
        $datiPagina = [
            'recensioni' => $recensioni,
            'totale' => $righeGrezze['totale'] ?? count($recensioni),
        ];

        $datiLayout = $this->preparaDatiLayout('admin_lista_recensioni', $datiPagina);

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
        $isAjax = UHTTPMethods::isAjax();
        //Recuperiamo la pagina di provenienza, con un fallback su /admin/dashboard
        $referer = UHTTPMethods::getReferer(BASE_URL . '/admin/dashboard');

        try {
            $idUtente = UHTTPMethods::postInt('id_persona');
        } catch (\InvalidArgumentException $e) {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
                exit();
            }
            UFlashMessage::addMessage('danger', 'Impossibile elaborare la richiesta: ' . $e->getMessage());
            header('Location: ' . $referer);
            exit();
        }

        $utente = FPersistentManager::PMgetObjOnAttribute(EUtente::class, 'idpersona', $idUtente);

        if (!$utente) {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'L\'utente non esiste.']);
                exit();
            }
            UFlashMessage::addMessage('danger', 'L\'utente non esiste.');
            header('Location: ' . $referer);
            exit();
        }

        try {
            //Calcoliamo la data di fine sospensione, aggiungendo esattamente 3 mesi alla data di oggi
            $dataFine = new DateTime();
            $dataFine->modify(self::DURATA_SOSPENSIONE); 

            //Applichiamo la sospensione tramite il metodo dell'entity
            $utente->sospendi($dataFine);

            //Salviamo lo stato aggiornato nel DB
            FPersistentManager::PMsaveObj($utente);

            $msg = 'L\'utente è stato sospeso fino al ' . $dataFine->format('d/m/Y') . '.';

            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'ok', 'message' => $msg, 'id_persona' => $idUtente]);
                exit();
            }

            UFlashMessage::addMessage('success', 'L\'utente è stato sospeso fino al ' . $dataFine->format('d/m/Y') . '.');
        } catch (\DomainException | \InvalidArgumentException $e) {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Impossibile sospendere l\'utente: ' . $e->getMessage()]);
                exit();
            }
            UFlashMessage::addMessage('danger', 'Impossibile sospendere l\'utente: ' . $e->getMessage());
        } 

        //Reindirizziamo alla pagina del profilo dell'utente appena modificato
        header('Location: ' . $referer);
        exit();
    }

    /**
     * Banna permanentemente un utente.
     * URL: POST /admin/utente/banna
     */
    public function bannaUtenteAdmin(): void {
        $isAjax = UHTTPMethods::isAjax();
        //Recuperiamo la pagina di provenienza, con un fallback su /admin/dashboard
        $referer = UHTTPMethods::getReferer(BASE_URL . '/admin/dashboard');
        try {
            $idUtente = UHTTPMethods::postInt('id_persona');
        } catch (\InvalidArgumentException $e) {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Parametri non validi: ' . $e->getMessage()]);
                exit();
            }
            UFlashMessage::addMessage('danger', 'Impossibile elaborare la richiesta: ' . $e->getMessage());
            header('Location: ' . $referer);
            exit();
        }

        $utente = FPersistentManager::PMgetObjOnAttribute(EUtente::class, 'idpersona', $idUtente);

        if (!$utente) {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'L\'utente non esiste.']);
                exit();
            }
            UFlashMessage::addMessage('danger', 'L\'utente non esiste.');
            header('Location: ' . $referer);
            exit();
        }

        try {
            $utente->banna();

            //Salviamo lo stato del utente nel DB
            FPersistentManager::PMsaveObj($utente);

            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'ok', 'message' => 'L\'utente è stato permanentemente bannato con successo!', 'id_persona' => $idUtente]);
                exit();
            }

            UFlashMessage::addMessage('success', 'L\'utente è stato permanentemente bannato con successo!');
        } catch (\DomainException | \InvalidArgumentException $e) {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Impossibile bannare l\'utente: ' . $e->getMessage()]);
                exit();
            }
            UFlashMessage::addMessage('danger', 'Impossibile bannare l\'utente: ' . $e->getMessage());
        }

        header('Location: ' . $referer);
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
                $puntaggioMax = $pesoCorrente;
                $gravitaMax = $stringaGravita;
                $idPuntaSegnalazione = $segnalazione->getIdSegnalazione();
            }
        }

        $utente = $recensione->getUtente();
        $prodotto = $recensione->getProdotto();

        return [
            'id' => $recensione->getIdRecensione(),
            'testo' => $recensione->getTesto(),
            'data' => $recensione->getData() ? $recensione->getData()->format('Y-m-d H:i:s') : null,
            'gravita' => $gravitaMax, //stringa 'bassa'|'media'|'alta'
            'idSegnalazioneDaRisolvere' => $idPuntaSegnalazione, //per POST /admin/recensioni/rigetta
            'autore' => [
                'id' => $utente ? $utente->getIdPersona() : null,
                'nome' => $utente ? $utente->getNomePersona() : 'Utente Sconosciuto',
            ],
            'prodotto' => [
                'id' => $prodotto ? $prodotto->getIdProdotto() : null,
                'nome' => $prodotto ? $prodotto->getNomeProdotto() : 'Prodotto Sconosciuto',
            ],
            'numeroSegnalazioni' => $numeroSegnalazioni,
        ];
    }

    public function getBreadcrumbs(string $currentPage = ''): array {
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