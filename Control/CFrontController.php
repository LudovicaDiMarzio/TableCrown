<?php
namespace TableCrown\Control;

use TableCrown\Utility\UHTTPMethods;

class CFrontController {

    //Il metodo run() riceve l'URL già formattato da index.php (es. "/catalogo" o "/prodotto/45")
    public function run(string $url): void {
        //Visto che l'URL inizia con '/', facciamo il trim dello slash, così l'explode non creerà un primo elemento vuoto.
        $cleanUrl = ltrim($url, '/');
        //Spacchiamo l'URL nei vari segmenti, usando lo slash come separatore
        //es. "profilo/ordini" -> [0 => "profilo", 1 => "ordini"]
        //Se l'URL era solo "/", dopo il trim sarà una stringa vuota. In tal caso andiamo su 'home'.
        $urlParts = $cleanUrl === '' ? ['home'] : explode('/', $cleanUrl);

        $routePrincipale = strtolower($urlParts[0]);
        $sottoRoute = isset($urlParts[1]) ? strtolower($urlParts[1]) : null;
        $sottoRoute2 = isset($urlParts[2]) ? strtolower($urlParts[2]) : null;

        $metodoHTTP = UHTTPMethods::method();

        
        /**
         * Lo switch è una struttura di controllo che serve a sostituire una 
         * lunga catena di if/elseif.
         * switch($routePrincipale) dice a PHP di prendere il valore contenuto 
         * in $routePrincipale e di iniziare a confrontarlo dall'alto verso il basso con i
         * vari casi (case) disponibili.
         * break serve ad uscire immediatamente dallo switch nel caso in cui sia stato trovato il caso giusto ed eseguito il codice.
         * Tramite default: , se il valore non corrisponde a nessuno dei case elencati, PHP esegue automaticamente le istruzioni del default.
         */
        switch ($routePrincipale) {

            case 'home':
                //Corrisponde a: GET / o GET /home
                $controller = new CNavigazione();
                $controller->mostraHome();
                break;

            case 'ricerca':
                //Corrisponde a: GET /ricerca
                $controller = new CCatalogo();

                if ($metodoHTTP === 'GET') {
                    $controller->mostraRisultatiRicerca();
                }
                break;

            case 'catalogo':
                $controller = new CCatalogo();

                if ($sottoRoute === 'giochi-da-tavolo' && $metodoHTTP === 'GET') {
                    $controller->mostraCatalogoGiochi(); //GET /catalogo/giochi-da-tavolo
                } elseif ($sottoRoute === 'bustine' && $metodoHTTP === 'GET') {
                    $controller->mostraCatalogoBustine(); //GET /catalogo/bustine
                } elseif ($sottoRoute === 'porta-dadi' && $metodoHTTP === 'GET') {
                    $controller->mostraCatalogoPortaDadi(); //GET /catalogo/porta-dadi
                }
                break;

            case 'eventi':
                /* //Corrisponde a: GET /eventi
                $controller = new CEventi();
                if ($sottoRoute === null) { //Corrisponde a: GET /eventi (Lista completa degli eventi)
                    $controller->mostraEventi();
                }
                
                elseif (is_numeric($sottoRoute)) { //Corrisponde a: GET /eventi/{id} (es. /eventi/45)
                    $controller->mostraDettaglioEvento();
                }

                //ROTTE DEDICATE AL GESTORE:
                elseif ($sottoRoute === 'nuovo' && $metodoHTTP === 'GET') { //Corrisponde a: GET /eventi/nuovo (Creazione di un nuovo evento)
                    $controller->mostraFormCreaEvento();
                }

                elseif ($sottoRoute === 'crea' && $metodoHTTP === 'POST') { //Corrisponde a: POST /eventi/crea (Creazione di un nuovo evento)
                    $controller->creaEvento();
                }

                elseif ($sottoRoute === 'modifica' && $metodoHTTP === 'GET') { //Corrisponde a: GET /eventi/modifica (Modifica di un evento esistente)
                    $controller->mostraFormModificaEvento();
                }

                else {
                    //Se l'URL non corrisponde a nessuna rotta definita nel sistema, intercettiamo l'errore.
                    $this->mostra404();
                }
                break;
 */
            case 'offerte':
                //Corrisponde a: GET /offerte
                $controller = new COfferte();
                $controller->mostraOfferte();
                break;

            case 'prodotto':
                //Corrisponde a: GET /prodotto/{id} (es. /prodotto/45)
                if ($sottoRoute !== null && is_numeric($sottoRoute)) {
                    $controller = new CProdotto();
                    $controller->mostraDettaglioProdotto((int)$sottoRoute);
                } else {
                    $this->mostra404();
                }
                break;

            case 'accedi':
                //Corrisponde a: GET /accedi
                $controller = new CAutenticazione();
                $controller->mostraForm();
                break;

            case 'registrati':
                //Corrisponde a: GET /registrati
                $controller = new CAutenticazione();
                $controller->mostraForm();
                break;

            case 'logout':
                //Corrisponde a: GET /logout
                $controller = new CAutenticazione();
                $controller->logout();
                break;

            case 'wishlist':
                $controller = new CWishlist();
                if ($sottoRoute === 'aggiungi' && $metodoHTTP === 'POST') {
                    $controller->aggiungiAllaWishlist();
                } else {
                    $controller->mostraWishlist();
                }
                break;

            case 'carrello':
                $controller = new CCarrello();
                //Verifico il metodo HTTP: se l'utente ha cliccato su "Aggiungi" nella Home, invierà una richiesta POST a /carrello/aggiungi
                if ($sottoRoute === 'aggiungi' && $metodoHTTP === 'POST') {
                    $controller->aggiungiAlCarrello();
                } elseif ($sottoRoute === 'rimuovi' && $metodoHTTP === 'GET') {
                    $controller->rimuoviDalCarrello((int)$sottoRoute2);
                } elseif ($sottoRoute === 'aggiorna' && $metodoHTTP === 'GET'){
                    $controller->aggiornaQuantita((int)$sottoRoute2);
                } else {
                    //Altrimenti, di default con una normale GET, mostra la pagina del carrello
                    $controller->mostraCarrello();
                }
                break;

            case 'profilo':
                $controller = new CProfilo();
                //Gestione delle sotto-rotte dell'area riservata
                if ($sottoRoute === 'ordini') {
                    //Corrisponde a: GET /profilo/ordini
                    $controller->mostraOrdini();
                } elseif ($sottoRoute === 'eventi') {
                    //Corrisponde a: GET /profilo/eventi
                    $controller->mostraEventiUtente();
                } else {
                    //Corrisponde a: GET /profilo (Dati generali)
                    $controller->mostraProfiloGenerale();
                }
                break;

            case 'chi-siamo':
                $controller = new CPagineStatiche();
                $controller->chiSiamo();
                break;

            case 'contatti':
                $controller = new CPagineStatiche();
                $controller->contatti();
                break;

            case 'dove-siamo':
                $controller = new CPagineStatiche();
                $controller->doveSiamo();
                break;

            case 'recensione':
                if ($sottoRoute === 'aggiungi' && $metodoHTTP === 'POST') {
                    $idProdotto = $sottoRoute2 !== null ? (int)$sottoRoute2 : null;
                    if ($idProdotto) {
                        $controller = new CRecensioni();
                        $controller->aggiungiRecensione($idProdotto);
                    } else {
                        $this->mostra404();
                    }
                } else {
                    $this->mostra404(); //Se l'URL non corrisponde a nessuna rotta definita nel sistema, intercettiamo l'errore.
                }
                break;

            case 'checkout':
                $controller = new COrdine();
                $controller->mostraCheckout();
                break;

            case 'ordini':
                $controller = new COrdine();
                if ($sottoRoute !== null && is_numeric($sottoRoute)) {
                    //Corrisponde a: GET /ordini/{id} (es. /ordini/45) - dettaglio singolo ordine
                    $controller->mostraDettaglioOrdine((int)$sottoRoute);
                } else {
                    //Corrisponde a: GET /ordini - storico ordini (redirect a /profilo/ordini)
                    $controller->mostraStoricoOrdini();
                }
                break;

            default:
                //Se l'URL non corrisponde a nessuna rotta definita nel sistema, intercettiamo l'errore.
                $this->mostra404();
                break;
        }
    }

    /**
     * Gestione standard dell'errore 404 (Risorsa non trovata).
     */
    private function mostra404(): void {
            header("HTTP/1.1 404 Not Found");
            echo "<h1>404 - Pagina non trovata</h1>";
            echo "La risorsa richiesta non è disponibile su TableCrown.";
            exit(); //Interrompe l'esecuzione dello script
        }
}