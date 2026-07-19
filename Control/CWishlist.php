<?php
namespace TableCrown\Control;

use TableCrown\Utility\USession;
use TableCrown\Utility\UHTTPMethods;
use TableCrown\Utility\UFlashMessage;
use TableCrown\Entity\EUtente;
use TableCrown\Entity\EWishlist;
use TableCrown\Entity\EProdotto;
use TableCrown\Foundation\FPersistentManager;

/**
 * Controller deputato alla gestione operativa della wishlist (Aggiunta e Rimozione)
 * La sola visualizzazione della Wishlista è delegata a CProfilo::mostraWishlist()
 */
class CWishlist extends BaseController {

    public function __construct() {
        parent::__construct();
    }

    //==========================================================================
    // AZIONI OPERATIVE (CRUD / MUTAMENTO)
    //==========================================================================

    /**
     * Aggiunge un prodotto alla wishlist.
     * Accetta chiamate POST standard o AJAX.
     * URL: POST /wishlist/aggiungi
     */
    public function aggiungiAllaWishlist(): void {
        $utente = $this->utenteCorrente();

        //Determiniamo se la richiesta è AJAX
        $isAjax = UHTTPMethods::isAjax();

        try {
            $idProdotto = UHTTPMethods::postInt('id_prodotto');
            $prodotto = FPersistentManager::PMgetObjOnAttribute(EProdotto::class, 'idProdotto', $idProdotto);

            if ($prodotto === null) {
                throw new \InvalidArgumentException("Il prodotto selezionato non esiste.");
            }

            $wishlist = $this->recuperaWishlist($utente);
            $wishlist->addProdotto($prodotto);

            $salvato = FPersistentManager::PMsaveObj($wishlist);

            if (!$salvato) {
                throw new \RuntimeException("Si è verificato un errore durante l'aggiunta alla wishlist.");
            }

            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'ok', 'message' => 'Prodotto aggiunto alla wishlist!']);
                exit();
            }

            UFlashMessage::addMessage('success', 'Prodotto aggiunto alla wishlist!');
            header('Location: ' . UHTTPMethods::getReferer(BASE_URL . $this->urlCatalogo($prodotto)));
            exit();

        } catch (\Exception $e) {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
                exit();
            }

            UFlashMessage::addMessage('danger', $e->getMessage());
            header('Location: ' . UHTTPMethods::getReferer(BASE_URL . '/'));
            exit();
        }
    }

    /**
     * Rimuove un prodotto dalla wishlist dell'utente.
     * Gestisce la richiesta standard o asincrona.
     * URL: POST /wishlist/rimuovi
     */
    public function rimuoviDallaWishlist(): void {
        $utente = $this->utenteCorrente();
        $isAjax = UHTTPMethods::isAjax();

        try {
            $idProdotto = UHTTPMethods::postInt('id_prodotto');
            $prodotto = FPersistentManager::PMgetObjOnAttribute(EProdotto::class, 'idProdotto', $idProdotto);

            if ($prodotto === null) {
                throw new \InvalidArgumentException("Il prodotto selezionato non esiste.");
            }

            $wishlist = FPersistentManager::PMgetObjOnAttribute(EWishlist::class, 'utente', $utente);

            if ($wishlist !== null) {
                if ($wishlist->getProdotti()->contains($prodotto)) {
                    $wishlist->removeProdotto($prodotto);
                    FPersistentManager::PMsaveObj($wishlist);
                }
                
            }

            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'ok', 'message' => 'Prodotto rimosso dalla wishlist!']);
                exit();
            }

            UFlashMessage::addMessage('success', 'Prodotto rimosso dalla wishlist!');
            header('Location: ' . UHTTPMethods::getReferer(BASE_URL . '/profilo/wishlist'));
            exit();

        } catch (\Exception $e) {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
                exit();
            }

            UFlashMessage::addMessage('danger', $e->getMessage());
            header('Location: ' . UHTTPMethods::getReferer(BASE_URL . '/profilo/wishlist'));
            exit();
        }
    }

    //==========================================================================
    // HELPER PRIVATI
    //==========================================================================

    /**
     * Recupera o crea da zero la wishlist dell'utente.
     * Garantisce che l'utente abbia sempre una wishlist attiva su cui operare.
     */
    private function recuperaWishlist(EUtente $utente): EWishlist {
        $wishlist = FPersistentManager::PMgetObjOnAttribute(EWishlist::class, 'utente', $utente);

        if ($wishlist === null) {
            $wishlist = new EWishlist($utente);
            FPersistentManager::PMsaveObj($wishlist);
        }

        return $wishlist;
    }
}