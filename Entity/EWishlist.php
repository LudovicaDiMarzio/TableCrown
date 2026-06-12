<?php
namespace TableCrown\Entity;
 
use DateTime;
 
class EWishlist {
    private int $idWishlist;
    private DateTime $dataCreazione;
    private array $idProdotti; // array di int (FK -> EProdotto)
    private Eutente $Utente; // FK -> EUtente (1 a 1)
 
    public function __construct(DateTime $dataCreazione, array $idProdotti, Eutente $Utente) {
        
        $this->dataCreazione = $dataCreazione;
        $this->idProdotti = $idProdotti;
        $this->Utente = $Utente;
    }
 
    // SET methods
    public function setDataCreazione(DateTime $dataCreazione): void {
        $this->dataCreazione = $dataCreazione;
    }
 
    public function setIdProdotti(array $idProdotti): void {
        $this->idProdotti = $idProdotti;
    }
 
    public function addIdProdotto(int $idProdotto): void {
        if (!in_array($idProdotto, $this->idProdotti)) {
            $this->idProdotti[] = $idProdotto;
        }
    }
 
    public function removeIdProdotto(int $idProdotto): void {
        $this->idProdotti = array_values(array_filter($this->idProdotti, fn($id) => $id !== $idProdotto));
    }
 
    public function setIdUtente(int $idUtente): void {
        $this->idUtente = $idUtente;
    }
 
    // GET methods
    public function getIdWishlist(): int {
        return $this->idWishlist;
    }
 
    public function getDataCreazione(): DateTime {
        return $this->dataCreazione;
    }
 
    public function getIdProdotti(): array {
        return $this->idProdotti;
    }
 
    public function getIdUtente(): int {
        return $this->idUtente;
    }
}