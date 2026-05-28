<?php
namespace TableCrown\Entity;
 
use InvalidArgumentException;
 
class ECarrelloItem {
    private int $idCarrelloItem;
    private int $quantita;
    private int $idCarrello; // FK -> ECarrello
    private int $idProdotto; // FK -> EProdotto
 
    public function __construct(int $idCarrelloItem, int $quantita, int $idCarrello, int $idProdotto) {
        $this->idCarrelloItem = $idCarrelloItem;
 
        if ($quantita <= 0) {
            throw new InvalidArgumentException("La quantità deve essere maggiore di 0.");
        }
        $this->quantita = $quantita;
 
        $this->idCarrello = $idCarrello;
        $this->idProdotto = $idProdotto;
    }
 
    // SET methods
    public function setQuantita(int $quantita): void {
        if ($quantita <= 0) {
            throw new InvalidArgumentException("La quantità deve essere maggiore di 0.");
        }
        $this->quantita = $quantita;
    }
 
    public function setIdCarrello(int $idCarrello): void {
        $this->idCarrello = $idCarrello;
    }
 
    public function setIdProdotto(int $idProdotto): void {
        $this->idProdotto = $idProdotto;
    }
 
    // GET methods
    public function getIdCarrelloItem(): int {
        return $this->idCarrelloItem;
    }
 
    public function getQuantita(): int {
        return $this->quantita;
    }
 
    public function getIdCarrello(): int {
        return $this->idCarrello;
    }
 
    public function getIdProdotto(): int {
        return $this->idProdotto;
    }
}