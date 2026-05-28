<?php
namespace TableCrown\Entity;
 
use InvalidArgumentException;
 
class EOrdineItem {
    private int $idOrdineItem;
    private int $quantita;
    private EOrdine $ordine; // oggetto EOrdine (1 a 1)
    private int $idProdotto;
 
    public function __construct(int $idOrdineItem, int $quantita, EOrdine $ordine, int $idProdotto) {
        $this->idOrdineItem = $idOrdineItem;
 
        if ($quantita <= 0) {
            throw new InvalidArgumentException("La quantità deve essere maggiore di 0.");
        }
        $this->quantita = $quantita;
 
        $this->ordine = $ordine;
        $this->idProdotto = $idProdotto;
    }
 
    // SET methods
    public function setQuantita(int $quantita): void {
        if ($quantita <= 0) {
            throw new InvalidArgumentException("La quantità deve essere maggiore di 0.");
        }
        $this->quantita = $quantita;
    }
 
    public function setOrdine(EOrdine $ordine): void {
        $this->ordine = $ordine;
    }
 
    public function setIdProdotto(int $idProdotto): void {
        $this->idProdotto = $idProdotto;
    }
 
    // GET methods
    public function getIdOrdineItem(): int {
        return $this->idOrdineItem;
    }
 
    public function getQuantita(): int {
        return $this->quantita;
    }
 
    public function getOrdine(): EOrdine {
        return $this->ordine;
    }
 
    public function getIdProdotto(): int {
        return $this->idProdotto;
    }
}