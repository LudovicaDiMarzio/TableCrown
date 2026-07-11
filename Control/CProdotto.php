<?php
namespace TableCrown\Control;

use TableCrown\Utility\UHTTPMethods;
use TableCrown\Utility\UFlashMessage;
use TableCrown\Entity\EProdotto;
use TableCrown\Entity\EGiocoDaTavolo;
use TableCrown\Entity\EBustine;
use TableCrown\Entity\EPortaDadi;
use TableCrown\Foundation\FPersistentManager;
use TableCrown\Presentation\Views\ViewProdotto;

/**
 * Controller dedicato alla gestione dei dettagli di un prodotto.
 * Gestisce la visualizzazione pubblica di uno specifico prodotto.
 */
class CProdotto extends BaseController {

    /**
     * Mostra la pagina di dettaglio di un prodotto specifico.
     */
    public function mostraDettaglioProdotto(int $idProdotto): void {
        //Recuperiamo il prodotto dal DB
        $prodotto = FPersistentManager::PMgetObjOnAttribute(EProdotto::class, 'idProdotto', $idProdotto);

        if (!$prodotto) {
            UFlashMessage::addMessage('danger', 'Il prodotto non esiste o non è più disponibile.');
            header('Location: /catalogo/giochi-da-tavolo');
            exit();
        }

        
        $datiPagina = $this->costruisciDatiVista($prodotto);
        $datiLayout = $this->preparaDatiLayout('prodotto', $datiPagina);

        //Chiamata alla View per renderizzare il template di Smarty passando i dati
        ViewProdotto::mostraDettaglioProdotto($datiLayout);

    }

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
        ]);
       
        //Attributi specifici dei giochi da tavolo
        if ($prodotto instanceof EGiocoDaTavolo) {
            $dati['categoria'] = array_map(fn($c) => $c->value, $prodotto->getCategoria());
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
        if (!$this->isLoggedIn()) {
            return false;
        }
        //TODO: FPersistentManager::PMuserHasPurchased($idUtente, $idProdotto);
        return false; //DA TOGLIERE QUANDO DISPONIBILE IL METODO DEL PM
    }
}