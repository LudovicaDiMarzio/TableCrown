<?php
namespace TableCrown\Entity;
 
use DateTime;
 
class ECarrello {
    private int $idCarrello;
    private DateTime $dataCreazione;
    private DateTime $ultimaModifica;
    private Eutente $Utente;
    private array $carrelloItems; // lista di oggetti ECarrelloItem
 
    public function __construct(int $idCarrello, DateTime $dataCreazione, DateTime $ultimaModifica, Eutente $Utente, array $carrelloItems = []) {
        $this->idCarrello = $idCarrello;
        $this->dataCreazione = $dataCreazione;
        $this->ultimaModifica = $ultimaModifica;
        $this->Utente = $Utente;
        $this->carrelloItems = $carrelloItems;
    }
 
    // SET methods
    public function setDataCreazione(DateTime $dataCreazione): void {
        $this->dataCreazione = $dataCreazione;
    }
 
    public function setUltimaModifica(DateTime $ultimaModifica): void {
        $this->ultimaModifica = $ultimaModifica;
    }
 
    public function setIdUtente(int $idUtente): void {
        $this->idUtente = $idUtente;
    }
 
    public function setCarrelloItems(array $carrelloItems): void {
        $this->carrelloItems = $carrelloItems;
    }
 
    public function addCarrelloItem(ECarrelloItem $item): void {
        $this->carrelloItems[] = $item;
    }
 
    public function removeCarrelloItem(int $idCarrelloItem): void {
        $this->carrelloItems = array_values(array_filter($this->carrelloItems, fn($item) => $item->getIdCarrelloItem() !== $idCarrelloItem));
    }
 
    // GET methods
    public function getIdCarrello(): int {
        return $this->idCarrello;
    }
 
    public function getDataCreazione(): DateTime {
        return $this->dataCreazione;
    }
 
    public function getUltimaModifica(): DateTime {
        return $this->ultimaModifica;
    }
 
    public function getIdUtente(): int {
        return $this->idUtente;
    }
 
    public function getCarrelloItems(): array {
        return $this->carrelloItems;
    }
}