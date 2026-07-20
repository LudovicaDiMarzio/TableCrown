<?php
namespace TableCrown\Control;

use TableCrown\Control\BaseController;
use TableCrown\Utility\UHTTPMethods;
use TableCrown\Foundation\FPersistentManager;
use TableCrown\Presentation\Views\ViewEventi;

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


    protected function getBreadcrumbs(string $currentPage = ''): array {
        return [
            ['label' => 'Home', 'url' => BASE_URL . '/'],
            ['label' => 'Eventi', 'url' => BASE_URL . '/eventi']
        ];
    }
}