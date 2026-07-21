<?php
namespace TableCrown\Control;

use TableCrown\Control\BaseController;
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
     * URL: GET /eventi
     */
    public function mostraHubEventi(): void {
        $datiPagina = ['vista' => 'eventi_home'];
        $datiLayout = $this->preparaDatiLayout('eventi_home', $datiPagina);

        //Chiamata alla View
        ViewEventi::mostraEventi($datiLayout); 
    }

    /**
     * Mostra la lista di eventi di tipo serata.
     * URL: /eventi/serate
     */
    public function mostraListaSerate(): void {
        $filtroData = $this->estraiFiltroData();

        $serate = FPersistentManager::PMfindSerate($filtroData); 

        $this->renderListaEventi('eventi_serate', $serate, $filtroData); 
        
    }

    /**
     * Mostra la lista di eventi di tipo torneo.
     * URL: /eventi/tornei
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


    protected function getBreadcrumbs(string $currentPage = ''): array {
        $breadcrumbs = [
            ['label' => 'Home', 'url' => BASE_URL . '/'],
            ['label' => 'Eventi', 'url' => BASE_URL . '/eventi']
        ];

        //Mappiamo il nome della vista sull'etichetta visualizzata nell'interfaccia
        $label = match($currentPage) {
            'eventi_serate' => 'Serate',
            'eventi_tornei' => 'Tornei',
            'eventi_challenge' => 'Challenge',
            default => '',
        };

        //Se siamo in una sottopagina (es. "Serate", "Tornei", "Challenge"),
        //la aggiungiamo alla fine senza URL in modo che non sia cliccabile.
        if (!empty($label)) {
            $breadcrumbs[] = [
                'label' => $label,
                'url' => null, //l'ultima voce è la pagina corrente, non cliccabile
            ];
        }
        return $breadcrumbs;
    }
}