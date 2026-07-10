<?php
namespace TableCrown\Control;

use TableCrown\Utility\UHTTPMethods;
use TableCrown\Entity\EProdotto;
use TableCrown\Entity\EGiocoDaTavolo;
use TableCrown\Entity\EBustine;
use TableCrown\Entity\EPortaDadi;
use TableCrown\Foundation\FPersistentManager;
use TableCrown\Presentation\Views\VProdotto;

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
            //TODO: gestire errore
        }

        //Recuperiamo i dati specifici del prodotto
        $datiVista = $this->costruisciDatiVista($prodotto);

        //Chiamata alla View per renderizzare il template di Smarty passando i dati
        //VProdotto::render($datiVista);

    }

    /**
     * Costruisce l'array di dati da passare alla View 
     * per il rendering del dettaglio del prodotto,
     * includendo gli attributi comuni a tutti i prodotti e quelli
     * specifici in base al tipo di prodotto (grazie all'inheritance mapping di Doctrine).
     */
    private function costruisciDatiVista(EProdotto $prodotto): array {
        //Attributi comuni a tutti i prodotti (di EProdotto), presenti per qualunque tipo di prodotto
        $dati = [
            'idProdotto' => $prodotto->getIdProdotto(),
            'nomeProdotto' => $prodotto->getNomeProdotto(),
            'imgProdotto' => $prodotto->getImgProdotto(),
            'descrizioneProdotto' => $prodotto->getDescrizioneProdotto(),
            'disponibilitaProdotto' => $prodotto->getDisponibilitaProdotto(),
            'quantita' => $prodotto->getQuantita(),
            'dataPubblicazione' => $prodotto->getDataPubblicazione(),
            'prezzo' => $prodotto->getPrezzo(),
            'valutazioneMedia' => $prodotto->getValutazioneMedia(),
            'recensioni' => $prodotto->getRecensioni(),
            //isAcquistabile() o isDisponibile() si possono eventualmente aggiungere
            //TODO: $correlati ?
        ];

        //Attributi specifici dei giochi da tavolo
        if ($prodotto instanceof EGiocoDaTavolo) {
            $dati['categoria'] = $prodotto->getCategoria();
            $dati['componenti'] = $prodotto->getComponenti();
            $dati['giocoBase'] = $prodotto->getGiocoBase(); //da decidere come restituirlo
            $dati['numeroGiocatoriMin'] = $prodotto->getNumeroGiocatoriMin();
            $dati['numeroGiocatoriMax'] = $prodotto->getNumeroGiocatoriMax();
            $dati['etaMinima'] = $prodotto->getEtaMinima();
            $dati['durataMedia'] = $prodotto->getDurataMedia();
            $dati['danno'] = $prodotto->getDanno(); //da decidere come restituirlo
            $dati['descrizioneDanno'] = $prodotto->getDescrizioneDanno();
            $dati['lingua'] = $prodotto->getLingua();
            $dati['difficolta'] = $prodotto->getDifficolta();
        }

        //EBustine e EPortaDadi non hanno sttributi specifici aggiuntivi,
        //quindi per loro $dati resta con i soli campi comuni.
        
        return $dati;
    }
}