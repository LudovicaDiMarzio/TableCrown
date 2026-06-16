<?php
// Includiamo i file dei controller (ancora da creare)
require_once 'CNavigazioneController.php';
require_once 'CCarrelloController.php';

class CFrontController {

    public function run($url) {
        $metodo = $_SERVER['REQUEST_METHOD'];

        if ($metodo === 'GET') {
            // Gestione Rotte Statiche principali
            switch ($url) {
                case '/':
                    $controller = new CNavigazioneController();
                    $controller->mostraHome();
                    break;

                case '/catalogo':
                    $controller = new CNavigazioneController();
                    // Gestisce la rotta /catalogo?ordinamento=novita chiesta dalla home
                    if (isset($_GET['ordinamento']) && $_GET['ordinamento'] === 'novita') {
                        $controller->mostraNovita();
                    } else {
                        $controller->mostraCatalogo();
                    }
                    break;

                case '/offerte':
                    $controller = new CNavigazioneController();
                    $controller->mostraOfferte();
                    break;

                case '/carrello':
                    // Corrisponde all'operazione SSD UC1 -> procediConOrdine() 
                    $controller = new CCarrelloController();
                    $controller->mostraCarrello();
                    break;

                // Gestione Rotta Dinamica: /prodotto/{id} 
                default:
                    if (preg_match('/^\/prodotto\/(\d+)$/', $url, $matches)) {
                        $idProdotto = (int)$matches[1];
                        // Corrisponde all'operazione SSD UC1 -> selezionaProdotto(idProdotto)
                        $controller = new CNavigazioneController();
                        $controller->mostraDettaglioProdotto($idProdotto);
                    } else {
                        // Pagina 404 se l'URL non esiste
                        echo "Errore 404 - Pagina non trovata";
                    }
                    break;
            }
        } 
        elseif ($metodo === 'POST') {
            switch ($url) {
                case '/carrello/aggiungi':
                    // Corrisponde all'operazione SSD UC1 -> aggiungiAlCarrello(idProdotto, quantita)
                    $controller = new CCarrelloController();
                    $controller->aggiungi();
                    break;
            }
        }
    }
}