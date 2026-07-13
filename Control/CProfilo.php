<?php
namespace TableCrown\Control;

use TableCrown\Utility\USession;
use TableCrown\Utility\UHTTPMethods;
use TableCrown\Utility\UFlashMessage;
use TableCrown\Entity\EUtente;
use TableCrown\Entity\ETorneo;
use TableCrown\Entity\EOrdine;
use TableCrown\Entity\EOrdineItem;
use TableCrown\Entity\EWishlist;
use TableCrown\Entity\EIndirizzo;
use TableCrown\Entity\Enumerativi\PlayerLevel;
use TableCrown\Entity\Enumerativi\StatoOrdine;
use TableCrown\Foundation\FPersistentManager;
use TableCrown\Presentation\Views\ViewProfiloFactory;

/**
 * Controller deputato alla gestione del profilo dell'utente.
 * In particolare gestisce la visualizzazione delle pagine pubbliche del profilo,
 * quindi le richieste in GET (visaulizzazione dello storico). Ha il compito 
 * di prendere i dati dal DB e passarli a Presentation.
 * Gestisce anche la modifica dell'account, in quanto costituisce azioni CRUD sull'entity EUtente.
 */
class CProfilo extends BaseController {

    private const SOGLIE_LIVELLO = [
        'intermedio' => 3,
        'avanzato' => 10,
    ];

    private const MENU_VOCI = [
        ['label' => 'Modifica account', 'url' => '/profilo/modifica'],
        ['label' => 'I Miei Ordini', 'url' => '/profilo/ordini'],
        ['label' => 'Le Mie Recensioni', 'url' => '/profilo/recensioni'],
        ['label' => 'Wishlist', 'url' => 'profilo/wishlist'], //Non dovrebbe essere solo /wishlist, visto che ci si può accedere anche da altre pagine?
        ['label' => 'Eventi', 'url' => '/profilo/eventi'],
        ['label' => 'I Miei Indirizzi', 'url' => '/profilo/indirizzi'],
    ];

    public function __construct() {
        parent::__construct();
    }

    //==========================================================================
    // HELPER PRIVATO CONDIVISO
    //==========================================================================

    /**
     * Recupera l'utente loggato nel DB. Centralizzato qui perché ogni metodo 
     * pubblico di questo controller ne ha bisogno.
     */
    private function utenteCorrente(): EUtente {
        $this->requireRole('utente');
        $idUtente = USession::getSessionElement('id_persona');
        return FPersistentManager::PMgetObjOnAttribute(EUtente::class, 'idPersona', $idUtente);
    }

    //==========================================================================
    // HUB
    //==========================================================================

    /**
     * URL: /profilo
     */
    public function mostraHub(): void{
        $utente = $this->utenteCorrente();

        $datiPagina = array_merge(
            ['vista' => 'profilo_hub', 'menuVoci' => self::MENU_VOCI],
            $this->datiHub($utente)
        );

        $datiLayout = $this->preparaDatiLayout('profilo_hub', $datiPagina);
        ViewProfiloFactory::render($datiLayout);
    }

    private function datiHub(EUtente $utente): array {
        $partecipazioniTornei = array_filter(
            //toArray metodo nativo di PHP per trasformare una Collection in un array semplice in modo da far girare array_filter
            $utente->getPartecipazioni()->toArray(), //array di EPartecipazione (tutte, di ogni tipo di evento)
            fn($p) => $p->getEvento() instanceof ETorneo //tiene solo quelle il cui evento collegato è un torneo
        );

        $torneiTotali = count($partecipazioniTornei);
        $torneiVinti = count(array_filter(
            $partecipazioniTornei,
            fn($p) => $p->getPosizioneInClassifica() === 1
        ));

        $livelloAttuale = $utente->getPlayerLevel();
        [$livelloSuccessivo, $torneiMancanti] = $this->calcolaProssimoLivello($livelloAttuale, $torneiVinti);

        return [
            'nomeUtente' => $utente->getNomePersona(),
            'immagineUtente' => $utente->getImgPersona(),
            'torneiVinti' => $torneiVinti,
            'torneiTotali' => $torneiTotali,
            'playerLevel' => $livelloAttuale->value,
            'livelloSuccessivo' => $livelloSuccessivo,
            'torneiMancanti' => $torneiMancanti,
        ];
    }

    private function calcolaProssimoLivello(PlayerLevel $attuale, int $torneiVinti): array {
        $ordine = [PlayerLevel::PRINCIPIANTE, PlayerLevel::INTERMEDIO, PlayerLevel::AVANZATO];
        $indiceAttuale = array_search($attuale, $ordine, true);

        if ($indiceAttuale === count($ordine) - 1) {
            return [null, null];
        }

        $prossimo = $ordine[$indiceAttuale + 1];
        $soglia = self::SOGLIE_LIVELLO[$prossimo->value];
        $mancanti = max(0, $soglia - $torneiVinti); //per gestire casi in cui torneiVinti>soglia (livello avanzato)

        return [$prossimo->value, $mancanti];
    }

    //==========================================================================
    // MODIFICA ACCOUNT
    //==========================================================================

    /**
     * URL: GET /profilo/modifica
     */
    public function mostraAccount(): void {
        $utente = $this->utenteCorrente();

        $datiPagina = [
            'vista' => 'profilo_account',
            'nomeUtente' => $utente->getNomePersona(),
            'emailUtente' => $utente->getEmailPersona(),
            'immagineUtente' => $utente->getImgPersona(),
            'etaUtente' => $utente->getEta(),
        ];

        $datiLayout = $this->preparaDatiLayout('profilo_account', $datiPagina);
        ViewProfiloFactory::render($datiLayout);
    }

    /**
     * Aggiorna nome/email/immagine (Richiesta POST, submit di form normale,
     * non AJAX --a differenza di password ed eliminazione).
     * URL: POST /profilo/modifica
     */
    public function aggiornaAccount(): void {
        $utente = $this->utenteCorrente();

        try {
            $nome = UHTTPMethods::postString('nome');
            $email = UHTTPMethods::postString('email');
        } catch (\InvalidArgumentException $e) {
            UFlashMessage::addMessage('danger', $e->getMessage());
            header('Location: /profilo/modifica');
            exit();
        }
        

        try {
            $utente->rinomina($nome);
            $utente->cambiaEmail($email);

            //L'immagine è opzionale: trattiamo sia "campo assente" sia "errore di
            //uplaod" allo stesso modo per ora (nessuna modifica all'immagine esistente).
            //DA CAMBIARE
            try {
                $immagine = UHTTPMethods::postFile('img_profilo'); //opzionale, l'utente potrebbe non cambiarla!
                $imgBlob = file_get_contents($immagine['tmp_name']);
                $utente->aggiornaImmagine($imgBlob);
            } catch (\InvalidArgumentException $e) {
                //Nessuna nuova immagine caricata, si mantiene quella esistente
            }
        } catch (\InvalidArgumentException $e) {
            UFlashMessage::addMessage('danger', $e->getMessage());
            header('Location: /profilo/modifica');
            exit();
        }

        $salvato = FPersistentManager::PMsaveObj($utente);

        UFlashMessage::addMessage(
            $salvato ? 'success' : 'danger',
            $salvato ? 'Account modificato con successo!' : 'Si è verificato un errore durante la modifica del profilo. Riprova.'
        );

        header('Location: /profilo/modifica');
        exit();
    }

    /**
     * Cambio password via AKAX.
     * URL: POST /profilo/modifica/password
     * Risponde JSON: {status: 'ok'} oppure {status: 'error', reason: '...'}
     */
    public function cambiaPassword(): void {
        header('Content-Type: application/json');
        $utente = $this->utenteCorrente();

        //DA CONTROLLARE IL METODO post
        $vecchiaPassword = UHTTPMethods::post('vecchia_password');
        $nuovaPassword = UHTTPMethods::post('nuova_password');
        $confermaPassword = UHTTPMethods::post('conferma_password');

        if (!$utente->verificaPassword($vecchiaPassword)) {
            echo json_encode(['status' => 'error', 'reason' => 'vecchia_errata']);
            exit();
        }

        if (!$nuovaPassword || $nuovaPassword !== $confermaPassword || strlen($nuovaPassword) < 8) {
            echo json_encode(['status' => 'error', 'reason' => 'nuova_non_valida']);
            exit();
        }

        try {
            $utente->cambiaPassword($nuovaPassword);
        } catch (\InvalidArgumentException $e) {
            echo json_encode(['status' => 'error', 'reason' => 'nuova_non_valida']);
            exit();
        }

        $salvato = FPersistentManager::PMsaveObj($utente);

        echo json_encode($salvato
            ? ['status' => 'ok']
            : ['status' => 'error', 'reason' => 'errore_salvaggio'] //REASON EXTRA DA DIRE A MARCO
            );
            exit();
    }

    /**
     * Eliminazione account via AJAX.
     * URL: POST /profilo/modifica/elimina
     * Risponde JSON: {status: 'ok'} oppure {status: 'error', reason: 'password_errata'}
     */
    public function eliminaAccount(): void {
        header('Content-Type: application/json');
        $utente = $this->utenteCorrente();

        $password = UHTTPMethods::post('password'); //DA CONTROLLARE IL METODO post

        if (!$utente->verificaPassword($password)) {
            echo json_encode(['status' => 'error', 'reason' => 'password_errata']);
            exit();
        }

        //TODO: valutare un soft-delete invece di cancellazione fisica
        //soprattutto perché EUtente ha relazioni con ordini/recensioni/...
        $eliminato = FPersistentManager::PMdeleteObj($utente);

        if ($eliminato) {
            USession::destroySession();
            echo json_encode(['status' => 'ok']);
        } else {
            echo json_encode(['status' => 'error', 'reason' => 'errore_eliminazione']);
        }
        exit();
    }

    protected function getBreadcrumbs(string $currentPage = ''): array {
        return match ($currentPage) {
            'profilo_hub' => [
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'Area personale', 'url' => '/profilo'],
            ],
            default => [
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'Area personale', 'url' => '/profilo'],
                ['label' => 'Dettaglio', 'url' => '#'],
            ],
        };
    }

    //==========================================================================
    // ORDINI
    //==========================================================================

    /**
     * URL: GET /profilo/ordini
     */
    public function mostraOrdini(): void {
        $utente = $this->utenteCorrente();

        $ordini = array_map(
            fn($o) => $this->ordineToArray($o),
            $utente->getOrdini()->toArray()
        );

        $datiPagina = [
            'vista' => 'profilo_ordini',
            'ordini' => $ordini,
        ];

        $datiLayout = $this->preparaDatiLayout('profilo_ordini', $datiPagina);
        ViewProfiloFactory::render($datiLayout);
    }

    /**
     * Privato: usato solo qui, converte EOrdine nella struttura utile a Presentation
     */
    private function ordineToArray(EOrdine $ordine): array { //SPOSTARE IN BASE CONTROLLER SE SERVE DA ALTRE PARTI
        $indirizzo = $ordine->getIndirizzoSpedizione();

        return [
            'id' => $ordine->getIdOrdine(),
            'data' => $ordine->getData()->format('Y-m-d H:i:s'),
            'stato' => $ordine->getStato()->value,
            'totale' => $this->formattaImporto($ordine->calcolaTotale()),
            'indirizzoSpedizione' => [
                'via' => $indirizzo->getVia(),
                'citta' => $indirizzo->getCitta(),
                'cap' => $indirizzo->getCap(),
                'provincia' => $indirizzo->getProvincia(),
                'nazione' => $indirizzo->getNazione(),
            ],
            'ultimeQuattroCifreCarta' => $ordine->getUltimeQuattroCifreCarta(),
            'nomeTitolareCarta' => $ordine->getNomeTitolareCarta(),
            'items' => array_map(
                fn($item) => $this->ordineItemToArray($item),
                $ordine->getOrdineItems()->toArray() //DA RIVEDERE
            ),
        ];
    }

    private function ordineItemToArray(EOrdineItem $ordineItem): array { //SPOSTARE IN BASE CONTROLLER SE SERVE DA ALTRE PARTI
        $prodotto = $ordineItem->getProdotto();

        return [
            'prodotto' => [
                'id' => $prodotto->getIdProdotto(),
                'nome' => $prodotto->getNomeProdotto(),
                'immagine' => $prodotto->getImgProdotto(),
            ],
            'quantita' => $ordineItem->getQuantita(),
            'prezzoUnitario' => $this->formattaImporto($ordineItem->getPrezzoUnitario()),
            'scontoApplicato' => $ordineItem->getScontoApplicato(),
            'totaleItem' => $this->formattaImporto($ordineItem->calcolaTotaleItem()),
        ];
    }


    //==========================================================================
    //WISHLIST
    //==========================================================================

    /**
     * URL: GET /profilo/wishlist
     */
    public function mostraWishlist(): void {
        $utente = $this->utenteCorrente();

        //Recuperiamo la wishlist dal DB
        $wishlist = FPersistentManager::PMgetObjOnAttribute(EWishlist::class, 'utente', $utente);

        $prodottiCollection = $wishlist ? $wishlist->getProdotti() : [];

        //Convertiamo i prodotti della wishlist in array usando il metodo ereditato da BaseController
        $prodottiWishlist = $this->prodottiToArray($prodottiCollection);

        $datiPagina = [
            'vista' => 'profilo_wishlist',
            'prodotti' => $prodottiWishlist,
        ];

        $datiLayout = $this->preparaDatiLayout('profilo_wishlist', $datiPagina);
        ViewProfiloFactory::render($datiLayout);
    }

    //==========================================================================
    // EVENTI
    //==========================================================================

    /**
     * URL: GET /profilo/eventi
     */
    public function mostraEventi(): void {
        $utente = $this->utenteCorrente();

        //Recuperiamo tutte le partecipazioni dell'utente
        $partecipazioni = $utente->getPartecipazioni()->toArray();
        $eventiIscritto = [];

        foreach ($partecipazioni as $p) {
            $evento = $p->getEvento();
            $eventoArray = $this->eventoToArray($evento);

            //Aggiungiamo informazioni specifiche della partecipazione utili a Presentation
            $eventoArray['dataiscrizione'] = $p->getDataIscrizione()->format('Y-m-d H:i:s');
            $eventoArray['posizioneClassifica'] = $p->getPosizioneInClassifica();

            $eventiIscritto[] = $eventoArray;
        }

        $datiPagina = [
            'vista' => 'profilo_eventi',
            'eventi' => $eventiIscritto,
        ];

        $datiLayout = $this->preparaDatiLayout('profilo_eventi', $datiPagina);
        ViewProfiloFactory::render($datiLayout);
    }


    //==========================================================================
    // INDIRIZZI
    //==========================================================================

    /**
     * URL: GET /profilo/indirizzi
     */
    public function mostraIndirizzi(): void {
        $utente = $this->utenteCorrente();

        $indirizziArray = [];
        foreach ($utente->getIndirizzi() as $indirizzo) {
            $indirizziArray[] = $this->indirizzoToArray($indirizzo);
        }
        
        $datiPagina = [
            'vista' => 'profilo_indirizzi',
            'indirizzi' => $indirizziArray,
        ];
        
        $datiLayout = $this->preparaDatiLayout('profilo_indirizzi', $datiPagina);
        ViewProfiloFactory::render($datiLayout);
    }

    /**
     * Privato: usato solo qui, converte EIndirizzo nella struttura utile a Presentation
     */
    private function indirizzoToArray(EIndirizzo $indirizzo): array { //SPOSTARE IN BASE CONTROLLER SE SERVE DA ALTRE PARTI
        return [
            'id' => $indirizzo->getIdIndirizzo(),
            'nome' => $indirizzo->getNome(),
            'via' => $indirizzo->getVia(),
            'citta' => $indirizzo->getCitta(),
            'cap' => $indirizzo->getCap(),
            'provincia' => $indirizzo->getProvincia(),
            'nazione' => $indirizzo->getNazione(),
            'nomeCitofono' => $indirizzo->getNomeCitofono(),
            'predefinito' => $indirizzo->isPredefinito(),
        ];
    }


    //==========================================================================
    // RECENSIONI
    //==========================================================================

    /**
     * URL: GET /profilo/recensioni
     */
    public function mostraRecensioni(): void {
        $utente = $this->utenteCorrente();

        $recensioniArray = $this->recensioniToArray($utente->getRecensioni());

        $datiPagina = [
            'vista' => 'profilo_recensioni',
            'recensioni' => $recensioniArray,
        ];

        $datiLayout = $this->preparaDatiLayout('profilo_recensioni', $datiPagina);
        ViewProfiloFactory::render($datiLayout);
    }
}