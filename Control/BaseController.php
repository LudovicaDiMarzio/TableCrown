<?php
/**
 * Il BaseController (astratto) centralizza la logica di controllo, sicurezza e sessione.
 */
namespace TableCrown\Control;

use TableCrown\Utility\USession;
use TableCrown\Utility\UHTTPMethods;
use TableCrown\Utility\UFlashMessage;
use TableCrown\Entity\EProdotto;
use TableCrown\Entity\Enumerativi\DisponibilitaProdotto;


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
        //Variabili globali sempre richieste dal layout
        $globalData = [
            'base_url' => 'https://tablecrown.it', 
            'current_page' => $currentPage, //Indica la pagina attiva (es. 'catalogo', 'eventi', ecc.)
            'breadcrumbs' => $this->getBreadcrumbs(), //Il percorso di navigazione
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
    protected function getBreadcrumbs(): array {
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
            'disponibilita'      => self::disponibilitaToString($prodotto->getDisponibilitaProdotto()),
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
     * Mappa l'enum DisponibilitaProdotto a delle stringhe fisse
     */
    private function disponibilitaToString(DisponibilitaProdotto $disponibilita): string {
        return match ($disponibilita) {
            DisponibilitaProdotto::Disponibile => 'disponibile',
            DisponibilitaProdotto::NonDisponibile => 'non_disponibile',
            DisponibilitaProdotto::Esaurito => 'esaurito',
            DisponibilitaProdotto::InArrivo => 'in_arrivo',
        };
    }

    /**
     * Converte l'utente loggato (se presente) nella forma minimale richiesta dal layout
     */
    protected function utenteToArray(): ?array {
        if (!$this->isLoggedIn()) {
            return null;
        }
        return [
            'name' => USession::getSessionElement('nickname'), //La sessione salva 'nickname' (PERCHè? COME LO SO?), esposto come 'name' verso Presentation
        ];
    }

}