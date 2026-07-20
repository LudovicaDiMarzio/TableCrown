<?php
namespace TableCrown\Control;

use TableCrown\Utility\UHTTPMethods;
use TableCrown\Utility\UFlashMessage;
use TableCrown\Entity\EProdotto;
use TableCrown\Entity\EGiocoDaTavolo;
use TableCrown\Entity\EBustine;
use TableCrown\Entity\EPortaDadi;
use TableCrown\Entity\EMotivazione;
use TableCrown\Entity\EWishlist;
use TableCrown\Foundation\FPersistentManager;
use TableCrown\Presentation\Views\ViewProdotto;

/**
 * Controller dedicato alla gestione dei dettagli di un prodotto.
 * Gestisce la visualizzazione pubblica di uno specifico prodotto.
 */
class CProdotto extends BaseController {

    /**
     * Mostra la pagina di dettaglio di un prodotto specifico.
     * URL: GET /prodotto?id=X (Accesso libero)
     */
    public function mostraDettaglioProdotto(): void {
        $idProdottoRaw = UHTTPMethods::get('id');
        if ($idProdottoRaw === null || !is_numeric($idProdottoRaw)) {
            UFlashMessage::addMessage('danger', 'ID prodotto non valido.');
            header('Location: ' . BASE_URL . '/catalogo/giochi-da-tavolo');
            exit();
        }

        $idProdotto = (int) $idProdottoRaw;
        //Recuperiamo il prodotto dal DB
        $prodotto = FPersistentManager::PMgetObjOnAttribute(EProdotto::class, 'idProdotto', $idProdotto);

        if (!$prodotto) {
            UFlashMessage::addMessage('danger', 'Il prodotto non esiste o non è più disponibile.');
            header('Location: ' . BASE_URL . '/catalogo/giochi-da-tavolo');
            exit();
        }

        
        $datiPagina = $this->costruisciDatiVista($prodotto);
        $datiLayout = $this->preparaDatiLayout('prodotto', $datiPagina);

        //Chiamata alla View per renderizzare il template di Smarty passando i dati
        ViewProdotto::mostraDettaglioProdotto($datiLayout);

    }

    //==========================================================================
    // HELPER PRIVATI
    //==========================================================================

    /**
     * Costruisce l'array di dati da passare alla View 
     * per il rendering del dettaglio del prodotto.
     * Usa prodottoToArray() del BaseController per i dati comuni.
     * Aggiunge poi i campi esclusivi di questa vista e, se applicabile,
     * i campi specifici dei giochi da tavolo.
     */
    private function costruisciDatiVista(EProdotto $prodotto): array {
        $dati = array_merge($this->prodottoToArray($prodotto),[
            'descrizioneProdotto' => $prodotto->getDescrizioneProdotto(),
            'quantita' => $prodotto->getQuantita(),
            'dataPubblicazione' => $prodotto->getDataPubblicazione()->format('Y-m-d H:i:s'),
            'recensioni' => $this->recensioniToArray($prodotto->getRecensioni()),
            'correlati' => $this->prodottiCorrelati([$prodotto->getIdProdotto()]),
            'userHasPurchased' => $this->haAcquistatoProdotto($prodotto->getIdProdotto()),
            'isInWishlist' => $this->isProdottoInWishlist($prodotto->getIdProdotto()),
            'motivazioni' => $this->motivazioniToArray(FPersistentManager::PMgetAll(EMotivazione::class)),
        ]);
       
        //Attributi specifici dei giochi da tavolo
        if ($prodotto instanceof EGiocoDaTavolo) {
            $dati['categoria'] = $prodotto->getCategoria(); //poiché l'array di categorie è ha il tipo json di Doctrine, l'array nativo PHP viene serializzato automaticamente in una stringa JSON nel DB e deserializzato in un array primitivo di PHP quando ricarica l'oggetto dal DB
            $dati['componenti'] = $prodotto->getComponenti();

            $giocoBase = $prodotto->getGiocoBase();
            $dati['giocoBase'] = $giocoBase !== null
                ? ['id' => $giocoBase->getIdProdotto(), 'nome' => $giocoBase->getNomeProdotto()]
                : null;

            $dati['numeroGiocatoriMin'] = $prodotto->getNumeroGiocatoriMin();
            $dati['numeroGiocatoriMax'] = $prodotto->getNumeroGiocatoriMax();
            $dati['etaMinima'] = $prodotto->getEtaMinima();
            $dati['durataMedia'] = $prodotto->getDurataMedia();

            $danno = $prodotto->getDanno(); //se il danno è presente, EGiocoDaTavolo garantisce che descrizioneDanno non sia vuota
            $dati['danno'] = $danno?->getLivelloDanno()->value;
            $dati['descrizioneDanno'] = $prodotto->getDescrizioneDanno();

            $dati['lingua'] = $prodotto->getLingua()->value;
            $dati['difficolta'] = $prodotto->getDifficolta()->value;
        }

        //EBustine e EPortaDadi non hanno sttributi specifici aggiuntivi,
        //quindi per loro $dati resta con i soli campi comuni.
        
        return $dati;
    }

    /**
     * Verifica se l'utente loggato ha gia acquistato questo prodotto.
     */
    private function haAcquistatoProdotto(int $idProdotto): bool {
        $utente = $this->utenteCorrenteOpzionale();
        if (!$utente) {
            return false;
        }

        //TODO: 
        //$idUtente = USession::getSessionElement('id_persona');
        //if (!$idUtente) {
        //    return false;
        //}
        //FPersistentManager::PMuserHasPurchased($idUtente, $idProdotto);
        return false; //DA TOGLIERE QUANDO DISPONIBILE IL METODO DEL PM
    }

    /**
     * Verifica se il prodotto è già presente nella wishlist dell'utente loggato.
     */
    private function isProdottoInWishlist(int $idProdotto): bool {
        $utente = $this->utenteCorrenteOpzionale();
        if (!$utente) {
            return false;
        }

        $wishlist = FPersistentManager::PMgetObjOnAttribute(EWishlist::class, 'utente', $utente);

        if (!$wishlist) {
            return false;
        }

        foreach ($wishlist->getProdotti() as $prodotto) {
            if ($prodotto->getIdProdotto() === $idProdotto) {
                return true;
            }
        }

        return false;
    }

    protected function getBreadcrumbs(string $currentPage = ''): array {
        $breadcrumbs = [
            ['label' => 'Home', 'url' => BASE_URL . '/'],
        ];

        $idProdotto = UHTTPMethods::get('id') ?? 0;
        $prodotto = FPersistentManager::PMgetObjOnAttribute(EProdotto::class, 'idProdotto', $idProdotto);

        if ($prodotto) {
            if ($prodotto instanceof EGiocoDaTavolo) {
                $breadcrumbs[] = ['label' => 'Giochi da tavolo', 'url' => BASE_URL . '/catalogo/giochi-da-tavolo'];
            } elseif ($prodotto instanceof EBustine) {
                $breadcrumbs[] = ['label' => 'Bustine', 'url' => BASE_URL . '/catalogo/bustine'];
            } elseif ($prodotto instanceof EPortaDadi) {
                $breadcrumbs[] = ['label' => 'Porta dadi', 'url' => BASE_URL . '/catalogo/porta-dadi'];
            }

            $breadcrumbs[] = ['label' => $prodotto->getNomeProdotto(), 'url' => '#']; //'#' per dire che quel link non punta ad una nuova pagina, ma mantiene l'utente sulla pagina in cui si trova già.
        } else {
            $breadcrumbs[] = ['label' => 'Prodotti', 'url' => '#'];
        }

        return $breadcrumbs;
    }
}