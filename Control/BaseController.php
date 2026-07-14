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



abstract class BaseController {

    protected array $validRoles; //Elenco di ruoli di sistema ammessi per il controllo dei permessi.

    //Definisco i tipi di prodotto validi per il catalogo, che a livello entity sono
    //classi diverse, in modo da poter restituire l'informazione sotto forma di array associativo.
    protected const TIPI_PRODOTTO = [
        'giochi-da-tavolo' => 'Gioco da Tavolo',
        'bustine' => 'Bustine',
        'porta-dadi' => 'Porta Dadi',
    ];
    

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
            'base_url' => 'https://tablecrown.it', 
            'current_page' => $currentPage, //Indica la pagina attiva (es. 'catalogo', 'eventi', ecc.)
            'breadcrumbs' => $this->getBreadcrumbs($currentPage), //Il percorso di navigazione
            'utente' => $this->utenteToArray(),
        ];

        //cart_count solo per gli utenti loggati con ruolo 'utente'
        if ($this->isLoggedIn() && USession::getSessionElement('ruolo') === 'utente') {
            $carrello = USession::getSessionElement('carrello') ?? [];
            $cartCount = array_sum(array_column($carrello, 'quantita')); //array_column estrae la colonna 'quantita' da ogni riga del carrello
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
            header("Location: /accedi");
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

    /**
     * Converte un'entity EProdotto (e sottoclasse) in un array
     * per tutte le liste di prodotti (home, catalogo, carrello, etc.).
     */
    protected function prodottoToArray(EProdotto $prodotto): array {
        $prezzoObj = $prodotto->getPrezzo();
        $inSconto = $prezzoObj !== null && $prezzoObj->hasSconto();

        return [
            'id'                 => (int) $prodotto->getIdProdotto(),
            'nome'               => $prodotto->getNomeProdotto(),
            'immagine'           => $prodotto->getImgProdotto(),
            'valutazione_media'  => (float) $prodotto->getValutazioneMedia(),
            'prezzo'             => $prezzoObj?->getValore() ?? 0.0,
            'sconto'             => $inSconto,
            'prezzo_scontato'    => $inSconto ? (float) $prezzoObj->calcolaPrezzoScontato() : null,
            'percentuale_sconto' => $inSconto ? $prezzoObj->getSconto() : null,
            'disponibilita'      => $prodotto->getDisponibilitaProdotto()->value,
            'isAcquistabile'     => $prodotto->isAcquistabile(),
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

    /**
     * Converte una ERecensione in un array associativo per Presentation.
     */
    protected function recensioneToArray(ERecensione $recensione): array {
        return [
            'id'          => (int) $recensione->getIdRecensione(),
            'valutazione' => $recensione->getValutazione(),
            'testo'       => $recensione->getTesto(),
            'data'        => $recensione->getData(),
            'utente'      => $recensione->getUtente()->getNomePersona(),
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

    /**
     * Converte un EEvento in un array associativo per Presentation.
     * (considera solo i campi comuni a tutti i tipi di evento)
     */
    protected function eventoToArray(EEvento $evento): array {
        return [
            'idEvento'          => (int) $evento->getIdEvento(),
            'nomeEvento'        => $evento->getNomeEvento(),
            'imgEvento'         => $evento->getImgEvento(),
            'dataInizio'        => $evento->getDataInizio()->format('Y-m-d H:i:s'),
            'maxPartecipanti'   => $evento->getMaxPartecipanti(),
            'statoEvento'       => $evento->getStatoEvento()->value, //valori non ancora "puliti", da rivedere se/quando serve esporli come identificatore tecnico altrove
            'numeroPartecipanti'=> $evento->getNumeroPartecipanti(),
            'richiedeQuota'     => $evento->richiedeQuota(),
        ];
    }

    /**
     * Converte un ESerata in un array associativo per Presentation.
     */
    protected function serataToArray(ESerata $serata): array {
        return array_merge($this->eventoToArray($serata), [
            'tipoSerata' => $serata->getTipoSerata(),
        ]);
    }

    /**
     * Converte un ETorneo in un array associativo per Presentation.
     */
    protected function torneoToArray(ETorneo $torneo): array {
        $challenge = $torneo->getChallenge();
        return array_merge($this->eventoToArray($torneo), [
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
            'quotaIscrizione' => $challenge->getQuotaIscrizione()->getValore(),
            'premio' => $challenge->getPremio()->getNomeProdotto(),
            'tornei' => array_map(fn($t) => $this->eventoLinkMinimo($t), $challenge->getTornei()->toArray()),
        ]);
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
     * Restituisce prodotti "correlati" con CRITERIO PROVVISORIO: TUTTI I PRODOTTI
     * DISPONIBILI NEL CATALOGO, ESCLUSI QUELLI IN $idEsclusi, LIMITATI A $limit.
     * DA SOSTITUIRE QUANDO DISPONIBILE IL METODO NEL PM.
     */
    //DA MODIFICAREEEEE!!!!!!
    protected function prodottiCorrelati(array $idsEsclusi, int $limit = 8): array {
        $tuttiProdotti = FPersistentManager::PMgetAll(EProdotto::class);

        $correlati = array_filter(
            $tuttiProdotti,
            fn($p) => !in_array($p->getIdProdotto(), $idsEsclusi) 
        );

        $correlati = array_slice(array_values($correlati), 0, $limit);

        return $this->prodottiToArray($correlati);
    }

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
     * Recupera l'utente correntemente loggato nel DB, verificando che abbia il 
     * ruolo 'utente'.
     */
    protected function utenteCorrente(): EUtente {
        $this->requireRole('utente');
        $idUtente = USession::getSessionElement('id_persona');
        return FPersistentManager::PMgetObjOnAttribute(EUtente::class, 'idPersona', $idUtente);
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