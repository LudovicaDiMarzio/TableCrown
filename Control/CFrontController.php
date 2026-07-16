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
                if ($metodoHTTP === 'GET') {
                    $controller = new CCatalogo();
                    $controller->mostraRisultatiRicercaProdotti();
                } else {
                    $this->mostra404();
                }
                break;


            case 'catalogo':
                if ($metodoHTTP !== 'GET') {
                    $this->mostra404();
                    break;
                }
                $controller = new CCatalogo();
                if ($sottoRoute === 'giochi-da-tavolo') {
                    $controller->mostraCatalogoGiochi(); //GET /catalogo/giochi-da-tavolo
                } elseif ($sottoRoute === 'bustine') {
                    $controller->mostraCatalogoBustine(); //GET /catalogo/bustine
                } elseif ($sottoRoute === 'porta-dadi') {
                    $controller->mostraCatalogoPortaDadi(); //GET /catalogo/porta-dadi
                } else {
                    $this->mostra404();
                }
                break;


            case 'eventi':
                if ($metodoHTTP === 'GET') {
                    if ($sottoRoute === null) {
                        $controller = new CEventi();
                        $controller->mostraHubEventi();
                    } elseif ($sottoRoute === 'serate') {
                        $controller = new CEventi();
                        $controller->mostraListaSerate(); //GET /catalogo/serate
                    } elseif ($sottoRoute === 'tornei') {
                        $controller = new CEventi();
                        $controller->mostraListaTornei(); //GET /catalogo/tornei
                    } elseif ($sottoRoute === 'challenge') {
                        $controller = new CEventi();
                        $controller->mostraListaChallenge(); //GET /catalogo/challenge
                    } elseif ($sottoRoute === 'dettaglio') {
                        if ($sottoRoute2 === null || !is_numeric($sottoRoute2)) {
                            $this->mostra404();
                            break;
                        }
                        $controller = new CDettaglioEvento();
                        $controller->mostraDettaglioEvento((int)$sottoRoute2);
                    } elseif ($sottoRoute === 'risultati') {
                        //TODO: implementare il metodo mostraRisultatiRicerca() in CEventi()
                        $this->mostra404(); //DA TOGLIERE POI
                    } else {
                        $this->mostra404();
                    }
                } elseif ($metodoHTTP === 'POST' && $sottoRoute === 'partecipa') {
                    //POST /eventi/partecipa - unico endpoint per serate/tornei/challenge (la differenza di comportamento è gestita internamente nel metodo)
                    $controller = new CDettaglioEvento();
                    $controller->partecipaEvento();
                } else {
                    $this->mostra404();
                }
                break;


            case 'prodotto':
                //Corrisponde a: GET /prodotto/{id} (es. /prodotto/45)
                if ($metodoHTTP === 'GET' &&$sottoRoute !== null && is_numeric($sottoRoute)) {
                    $controller = new CProdotto();
                    $controller->mostraDettaglioProdotto((int)$sottoRoute);
                } else {
                    $this->mostra404();
                }
                break;


            case 'accedi':
                //Corrisponde a: GET /accedi
                if ($metodoHTTP === 'GET') {
                    $controller = new CAutenticazione();
                    $controller->mostraFormLogin();
                } else {
                    $this->mostra404();
                }
                break;


            case 'registrati':
                //Corrisponde a: GET /registrati
                if ($metodoHTTP === 'GET') {
                    $controller = new CAutenticazione();
                    $controller->mostraFormRegistrazione();
                } else {
                    $this->mostra404();
                }
                break;


            case 'logout':
                //Corrisponde a: GET /logout
                if ($metodoHTTP === 'GET') {
                    $controller = new CAutenticazione();
                    $controller->logout();
                } else {
                    $this->mostra404();
                }
                break;


            case 'login':
                //Corrisponde a: POST /login
                if ($metodoHTTP === 'POST') {
                    $controller = new CAutenticazione();
                    $controller->login();
                } else {
                    $this->mostra404();
                }
                break;


            case 'registrazione':
                //Corrisponde a: POST /registrazione
                if ($metodoHTTP === 'POST') {
                    $controller = new CAutenticazione();
                    $controller->registrazione();
                } else {
                    $this->mostra404();
                }
                break;


            case 'carrello':
                $controller = new CCarrello();
                if ($sottoRoute === 'aggiungi' && $metodoHTTP === 'POST') {
                    $controller->aggiungiAlCarrello();
                } elseif ($sottoRoute === 'rimuovi' && $metodoHTTP === 'POST') { 
                    $controller->rimuoviDalCarrello();
                } elseif ($sottoRoute === 'aggiorna' && $metodoHTTP === 'POST'){ 
                    $controller->aggiornaQuantita();
                } elseif ($sottoRoute === null && $metodoHTTP === 'GET') {
                    $controller->mostraCarrello();
                } else {
                    $this->mostra404();
                }
                break;


            case 'wishlist': //Solo azioni di mutazione; la visualizzazione passa da profilo/wishlist
                if ($metodoHTTP !== 'POST') {
                    $this->mostra404();
                    break;
                }
                $controller = new CWishlist();
                if ($sottoRoute === 'aggiungi') {
                    $controller->aggiungiAllaWishlist();
                } elseif ($sottoRoute === 'rimuovi') {
                    $controller->rimuoviDallaWishlist();
                } else {
                    $this->mostra404();
                }
                break;

            
            case 'recensioni':
                if ($metodoHTTP !== 'POST') {
                    $this->mostra404();
                    break;
                }
                $controller = new CRecensioni();
                if ($sottoRoute === 'aggiungi') {
                    $controller->aggiungiRecensione();
                } elseif ($sottoRoute === 'elimina') {
                    $controller->eliminaRecensione();
                } elseif ($sottoRoute === 'segnala') {
                    $controller->segnalaRecensione();
                } else {
                    $this->mostra404();
                }
                break;


            case 'profilo':
                $controller = new CProfilo();
                
                if ($metodoHTTP === 'GET') {
                    if ($sottoRoute === null) {
                        $controller->mostraHub();
                    } elseif ($sottoRoute === 'modifica') {
                        $controller->mostraAccount();
                    } elseif ($sottoRoute === 'ordini') {
                        $controller->mostraOrdini();
                    } elseif ($sottoRoute === 'eventi') {
                        $controller->mostraEventi();
                    } elseif ($sottoRoute === 'indirizzi') {
                        $controller->mostraIndirizzi();
                    } elseif ($sottoRoute === 'recensioni') {
                        $controller->mostraRecensioni();
                    } elseif ($sottoRoute === 'wishlist') {
                        $controller->mostraWishlist();
                    } else {
                        $this->mostra404();
                    }
                } elseif ($metodoHTTP === 'POST') {
                    if ($sottoRoute === 'modifica') {
                        if ($sottoRoute2 === 'password') {
                            $controller->cambiaPassword();
                        } elseif ($sottoRoute2 === 'elimina') {
                            $controller->eliminaAccount();
                        } elseif ($sottoRoute2 === null) {
                            $controller->aggiornaAccount();
                        } else {
                            $this->mostra404();
                        }
                    } elseif ($sottoRoute === 'indirizzi') {
                        $controllerIndirizzo = new CIndirizzo();
                        if ($sottoRoute2 === 'aggiungi') {
                            $controllerIndirizzo->aggiungiIndirizzo();
                        } elseif ($sottoRoute2 === 'elimina') {
                            $controllerIndirizzo->eliminaIndirizzo();
                        } elseif ($sottoRoute2 === 'predefinito') {
                            $controllerIndirizzo->impostaPredefinito();
                        } else {
                            $this->mostra404();
                        }
                    } //TODO: elseif ($sottoRoute === 'ordini' &&)
                    else {
                        $this->mostra404();
                    }
                } else {
                    $this->mostra404();
                }
                break;

/* 
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


            case 'offerte':
                //Corrisponde a: GET /offerte
                $controller = new COfferte();
                $controller->mostraOfferte();
                break;
*/

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