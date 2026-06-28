<?php
namespace TableCrown\Control;

use TableCrown\Utility\UHTTPMethods;

class CFrontController {

    //Il metodo run() riceve l'URL già formattato da index.php (es. "/catalogo" o "/prodotto/45")
    public function run(string $url): void {
        //Visto che l'URL inizia con '/', facciamo il trim dello slash, così l'explode non creerà un primo elemento vuoto.
        $cleanUrl = ltrim($url, '/');

        //Se l'URL era solo "/", dopo il trim sarà una stringa vuota. In tal caso andiamo su 'home'.
        if ($cleanUrl === '') {
            $routePrincipale = 'home';
            $sottoRoute = null;
        } else {
            //Spacchiamo l'URL nei vari segmenti, usando lo slash come separatore
            //es. "profilo/ordini" -> [0 => "profilo", 1 => "ordini"]
            $urlParts = explode('/', $cleanUrl);
            $routePrincipale = strtolower($urlParts[0]);
            //Il sottoRoute conterrà l'azione o l'ID (es. "ordini" o "45")
            $sottoRoute = isset($urlParts[1]) ? strtolower($urlParts[1]) : null;
        }

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

            case 'catalogo':
                //Corrisponde a: GET /catalogo
                //Nota: se l'utente richiede /catalogo?ordinamento=novita, i parametri in query string non alterano il routing principale e verranno letti direttamente dentro la classe CCatalogo.
                $controller = new CCatalogo();
                $controller->mostraCatalogo();
                break;

            case 'eventi':
                //Corrisponde a: GET /eventi
                $controller = new CEventi();
                $controller->mostraEventi();
                break;

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
                //Corrisponde a: GET /wishlist
                $controller = new CWishlist();
                $controller->mostraWishlist();
                break;

            case 'carrello':
                $controller = new CCarrello();
                //Verifico il metodo HTTP: se l'utente ha cliccato su "Aggiungi" nella Home, invierà una richiesta POST a /carrello/aggiungi
                if ($metodoHTTP === 'POST') {
                    if ($sottoRoute === 'aggiungi') {
                        $controller->aggiungiAlCarrello();
                    } elseif ($sottoRoute === 'rimuovi') {
                        $controller->rimuoviDalCarrello();
                    }
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

            case 'recensioni':
                //Corrisponde a: GET /recensioni/nuova (o POST se invia il form, gestibile dentro il metodo)
                if ($sottoRoute === 'nuova') {
                    $controller = new CRecensioni();
                    $controller->nuovaRecensione();
                } else {
                    $this->mostra404();
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