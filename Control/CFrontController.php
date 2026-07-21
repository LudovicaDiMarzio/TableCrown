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
        $sottoRoute3 = isset($urlParts[3]) ? strtolower($urlParts[3]) : null;

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
                        $controller->mostraListaSerate(); //GET /eventi/serate
                    } elseif ($sottoRoute === 'tornei') {
                        $controller = new CEventi();
                        $controller->mostraListaTornei(); //GET /eventi/tornei
                    } elseif ($sottoRoute === 'challenge') {
                        $controller = new CEventi();
                        $controller->mostraListaChallenge(); //GET /eventi/challenge
                    } elseif ($sottoRoute === 'dettaglio') {
                        $controller = new CDettaglioEvento();
                        $controller->mostraDettaglioEvento(); //GET /eventi/dettaglio?id=X
                    } elseif ($sottoRoute === 'checkout') {
                        $controller = new CDettaglioEvento();
                        $controller->mostraCheckoutEvento(); //GET /eventi/checkout?id=X
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
                //Corrisponde a: GET /prodotto?id=X (es. /prodotto?id=45)
                if ($metodoHTTP === 'GET' &&$sottoRoute === null) {
                    $controller = new CProdotto();
                    $controller->mostraDettaglioProdotto();
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
                if ($sottoRoute === 'aggiungi' && $metodoHTTP === 'POST') { //POST /carrello/aggiungi
                    $controller->aggiungiAlCarrello();
                } elseif ($sottoRoute === 'rimuovi' && $metodoHTTP === 'POST') { //POST /carrello/rimuovi
                    $controller->rimuoviDalCarrello();
                } elseif ($sottoRoute === 'aggiorna' && $metodoHTTP === 'POST'){ //POST /carrello/aggiorna
                    $controller->aggiornaQuantita();
                } elseif ($sottoRoute === null && $metodoHTTP === 'GET') { //GET /carrello
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
                    } elseif ($sottoRoute === 'pagamenti') {
                        $controller->mostraMetodiPagamento();
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
                    } elseif ($sottoRoute === 'pagamenti') {
                        $controllerPagamento = new CMetodiPagamento();
                        if ($sottoRoute2 === 'aggiungi') {
                            $controllerPagamento->aggiungiCarta();
                        } elseif ($sottoRoute2 === 'elimina') {
                            $controllerPagamento->eliminaCarta();
                        } else {
                            $this->mostra404();
                        }
                    } else {
                        $this->mostra404();
                    }
                } else {
                    $this->mostra404();
                }
                break;


            case 'checkout':
                $controller = new CCheckout();
                if ($sottoRoute === null && $metodoHTTP === 'GET') {
                    $controller->mostraCheckout(); //GET /checkout
                } elseif ($sottoRoute === 'acquista' && $metodoHTTP === 'POST') {
                    $controller->elaboraAcquisto(); //POST /checkout/acquista
                } else {
                    $this->mostra404();
                }
                break;

            
            case 'offerte':
                if ($metodoHTTP === 'GET') {
                    $controller = new CCatalogo();
                    $controller->mostraOfferte(); //GET /offerte
                } else {
                    $this->mostra404();
                }
                break;


            case 'admin':
                if ($metodoHTTP === 'GET') {
                    $controller = new CAmministratore();
                    if ($sottoRoute === 'dashboard') { //GET /admin/dashboard
                        $controller->mostraDashboardAdmin();
                    } elseif ($sottoRoute === 'utenti') { //GET /admin/utenti
                        $controller->mostraListaUtentiAdmin();
                    } elseif ($sottoRoute === 'recensioni') { //GET /admin/recensioni
                        $controller->mostraListaRecensioniAdmin();
                    } elseif ($sottoRoute === 'utente' && $sottoRoute2 === 'profilo') { //GET /admin/utente/profilo?id=XX
                        $controller->mostraProfiloUtenteAdmin();
                    } else {
                        $this->mostra404();
                    }
                } elseif ($metodoHTTP === 'POST') {
                    if ($sottoRoute === 'utente' && $sottoRoute2 === 'sospendi') { //POST /admin/utente/sospendi
                        $controller = new CAmministratore();
                        $controller->sospendiUtenteAdmin();
                    } elseif ($sottoRoute === 'utente' && $sottoRoute2 === 'banna') { //POST /admin/utente/banna
                        $controller = new CAmministratore();
                        $controller->bannaUtenteAdmin();
                    } elseif ($sottoRoute === 'recensioni' && $sottoRoute2 === 'elimina') { //POST /admin/recensioni/elimina
                        $controller = new CRecensioni();
                        $controller->eliminaRecensioneAdmin();
                    } elseif ($sottoRoute === 'recensioni' && $sottoRoute2 === 'rigetta') { //POST /admin/recensioni/rigetta
                        $controller = new CRecensioni();
                        $controller->rigettaSegnalazioneAdmin();
                    } else {
                        $this->mostra404();
                    }
                } else {
                    $this->mostra404();
                }
                break;


                case 'gestore':
                    $controller = new CGestore();
                    if ($metodoHTTP === 'GET') {
                        if ($sottoRoute === 'dashboard') { //GET /gestore/dashboard
                            $controller->mostraDashboardGestore();
                        } elseif ($sottoRoute === 'crea') {
                            if ($sottoRoute2 === 'giochi-da-tavolo') { //GET /gestore/crea/giochi-da-tavolo
                                $controller->mostraFormCreaGiocoGestore();
                            } elseif ($sottoRoute2 === 'bustine') { //GET /gestore/crea/bustine
                                $controller->mostraFormCreaBustineGestore();
                            } elseif ($sottoRoute2 === 'porta-dadi') { //GET /gestore/crea/porta-dadi
                                $controller->mostraFormCreaPortaDadiGestore();
                            } elseif ($sottoRoute2 === 'serata') { //GET /gestore/crea/serata
                                $controller->mostraFormCreaSerata();
                            } elseif ($sottoRoute2 === 'torneo') { //GET /gestore/crea/torneo
                                $controller->mostraFormCreaTorneo();
                            } elseif ($sottoRoute2 === 'challenge') { //GET /gestore/crea/challenge
                                $controller->mostraFormCreaChallenge();
                            } else {
                                $this->mostra404();
                            }
                        }
                        elseif ($sottoRoute === 'catalogo') {
                            if ($sottoRoute2 === 'giochi-da-tavolo') { //GET /gestore/catalogo/giochi-da-tavolo
                                $controller->mostraCatalogoGiochiGestore();
                            } elseif ($sottoRoute2 === 'bustine') { //GET /gestore/catalogo/bustine
                                $controller->mostraCatalogoBustineGestore();
                            } elseif ($sottoRoute2 === 'porta-dadi') { //GET /gestore/catalogo/porta-dadi
                                $controller->mostraCatalogoPortaDadiGestore();
                            } else {
                                $this->mostra404();
                            }
                        } elseif ($sottoRoute === 'eventi') {
                            if ($sottoRoute2 === 'serate') { //GET /gestore/eventi/serate
                                $controller->mostraListaSerateGestore();
                            } elseif ($sottoRoute2 === 'tornei') { //GET /gestore/eventi/tornei
                                $controller->mostraListaTorneiGestore();
                            } elseif ($sottoRoute2 === 'challenge') { //GET /gestore/eventi/challenge
                                $controller->mostraListaChallengeGestore();
                            } elseif ($sottoRoute2 === 'dettaglio') { //GET /gestore/eventi/dettaglio?id=X
                                $controller->mostraDettaglioEventoGestore();
                            } else {
                                $this->mostra404();
                            }
                        } else {
                            $this->mostra404();
                        }
                    } elseif ($metodoHTTP === 'POST') {
                        if ($sottoRoute === 'catalogo') {
                            if ($sottoRoute3 === 'nuovo') {
                                if ($sottoRoute2 === 'giochi-da-tavolo') { //POST /gestore/catalogo/giochi-da-tavolo/nuovo
                                    $controller->creaGiocoDaTavolo();
                                } elseif ($sottoRoute2 === 'bustine') { //POST /gestore/catalogo/bustine/nuovo
                                    $controller->creaBustine();
                                } elseif ($sottoRoute2 === 'porta-dadi') { //POST /gestore/catalogo/porta-dadi/nuovo
                                    $controller->creaPortaDadi();
                                } else {
                                    $this->mostra404();
                                }
                            } elseif ($sottoRoute2 === 'prodotto' && $sottoRoute3 === 'elimina') { //POST /gestore/catalogo/prodotto/elimina
                                $controller->eliminaProdottoGestore();
                            } else {
                                $this->mostra404();
                            }
                        } elseif ($sottoRoute === 'prodotti') {
                            if ($sottoRoute2 === 'quantita') { //POST /gestore/prodotti/quantita
                                $controller->aggiornaQuantitaProdottoGestore();
                            } elseif ($sottoRoute2 === 'modifica') { //POST /gestore/prodotti/modifica
                                $controller->modificaProdottoGestore();
                            } else {
                                $this->mostra404();
                            }
                        } elseif ($sottoRoute === 'eventi') {
                            if ($sottoRoute3 === 'nuovo') {
                                if ($sottoRoute2 === 'serate') { //POST /gestore/eventi/serate/nuovo
                                    $controller->creaSerata();
                                } elseif ($sottoRoute2 === 'tornei') { //POST /gestore/eventi/tornei/nuovo
                                    $controller->creaTorneo();
                                } elseif ($sottoRoute2 === 'challenge') { //POST /gestore/eventi/challenge/nuovo
                                    $controller->creaChallenge();
                                } else {
                                    $this->mostra404();
                                }
                            } elseif ($sottoRoute2 === 'tornei' && $sottoRoute3 === 'esito') { //POST /gestore/eventi/tornei/esito
                                $controller->inserisciEsitoTorneoGestore();
                            } elseif ($sottoRoute2 === 'challenge' && $sottoRoute3 === 'genera-classifica') { //POST /gestore/eventi/challenge/genera-classifica
                                $controller->generaClassificaChallengeGestore();
                            } elseif ($sottoRoute2 === 'attiva') { //POST /gestore/eventi/attiva
                                $controller->attivaEventoGestore();
                            } elseif ($sottoRoute2 === 'concludi') { //POST /gestore/eventi/concludi
                                $controller->concludiEventoGestore();
                            } elseif ($sottoRoute2 === 'annulla') { //POST /gestore/eventi/annulla
                                $controller->annullaEventoGestore();
                            } elseif ($sottoRoute2 === 'riprogramma') { //POST /gestore/eventi/riprogramma
                                $controller->riprogrammaEventoGestore();
                            } elseif ($sottoRoute2 === 'modifica') { //POST /gestore/eventi/modifica
                                $controller->modificaEventoGestore();
                            } else {
                                $this->mostra404();
                            }
                        } else {
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