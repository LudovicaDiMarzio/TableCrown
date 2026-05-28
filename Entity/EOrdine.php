<?php
namespace TableCrown\Entity;
 
use InvalidArgumentException;
use DateTime;
 
class EOrdine {
    private int $idOrdine;
    private DateTime $data;
    private string $stato;
    private int $idUtente;
    private array $carteDiCredito; // lista di oggetti ECartaDiCredito
    private array $ordineItems;    // lista di oggetti EOrdineItem
 
    private static array $statiValidi = ['in attesa', 'confermato', 'spedito', 'consegnato', 'annullato'];
 
    public function __construct(int $idOrdine, DateTime $data, string $stato, int $idUtente, array $carteDiCredito = [], array $ordineItems = []) {
        $this->idOrdine = $idOrdine;
        $this->data = $data;
 
        if (!in_array(trim($stato), self::$statiValidi)) {
            throw new InvalidArgumentException("Stato ordine non valido. Valori accettati: " . implode(", ", self::$statiValidi));
        }
        $this->stato = trim($stato);
 
        $this->idUtente = $idUtente;
        $this->carteDiCredito = $carteDiCredito;
        $this->ordineItems = $ordineItems;
    }
 
    // SET methods
    public function setData(DateTime $data): void {
        $this->data = $data;
    }
 
    public function setStato(string $stato): void {
        if (!in_array(trim($stato), self::$statiValidi)) {
            throw new InvalidArgumentException("Stato ordine non valido. Valori accettati: " . implode(", ", self::$statiValidi));
        }
        $this->stato = trim($stato);
    }
 
    public function setIdUtente(int $idUtente): void {
        $this->idUtente = $idUtente;
    }
 
    public function setCarteDiCredito(array $carteDiCredito): void {
        $this->carteDiCredito = $carteDiCredito;
    }
 
    public function addCartaDiCredito(ECartaDiCredito $carta): void {
        $this->carteDiCredito[] = $carta;
    }
 
    public function removeCartaDiCredito(int $idCartaDiCredito): void {
        $this->carteDiCredito = array_values(array_filter($this->carteDiCredito, fn($c) => $c->getIdCartaDiCredito() !== $idCartaDiCredito));
    }
 
    public function setOrdineItems(array $ordineItems): void {
        $this->ordineItems = $ordineItems;
    }
 
    public function addOrdineItem(EOrdineItem $item): void {
        $this->ordineItems[] = $item;
    }
 
    public function removeOrdineItem(int $idOrdineItem): void {
        $this->ordineItems = array_values(array_filter($this->ordineItems, fn($item) => $item->getIdOrdineItem() !== $idOrdineItem));
    }
 
    // GET methods
    public function getIdOrdine(): int {
        return $this->idOrdine;
    }
 
    public function getData(): DateTime {
        return $this->data;
    }
 
    public function getStato(): string {
        return $this->stato;
    }
 
    public function getIdUtente(): int {
        return $this->idUtente;
    }
 
    public function getCarteDiCredito(): array {
        return $this->carteDiCredito;
    }
 
    public function getOrdineItems(): array {
        return $this->ordineItems;
    }
}