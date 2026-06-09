<?php
namespace TableCrown\Entity;
 
use InvalidArgumentException;
use DateTime;
 
class ERecensione {
    private int $idRecensione;
    private int $valutazione; // es. 1-5
    private string $testo;
    private DateTime $data;
    private bool $segnalazione;
    private EUtente $utente;
 
    public function __construct(int $idRecensione, int $valutazione, string $testo, DateTime $data, bool $segnalazione, int $idUtente) {
        $this->idRecensione = $idRecensione;
 
        if ($valutazione < 1 || $valutazione > 5) {
            throw new InvalidArgumentException("La valutazione deve essere compresa tra 1 e 5.");
        }
        $this->valutazione = $valutazione;
 
        if (trim($testo) === '') {
            throw new InvalidArgumentException("Il testo della recensione non può essere vuoto.");
        }
        $this->testo = trim($testo);
 
        $this->data = $data;
        $this->segnalazione = $segnalazione;
        $this->idUtente = $idUtente;
    }
 
    // SET methods
    public function setValutazione(int $valutazione): void {
        if ($valutazione < 1 || $valutazione > 5) {
            throw new InvalidArgumentException("La valutazione deve essere compresa tra 1 e 5.");
        }
        $this->valutazione = $valutazione;
    }
 
    public function setTesto(string $testo): void {
        if (trim($testo) === '') {
            throw new InvalidArgumentException("Il testo della recensione non può essere vuoto.");
        }
        $this->testo = trim($testo);
    }
 
    public function setData(DateTime $data): void {
        $this->data = $data;
    }
 
    public function setSegnalazione(bool $segnalazione): void {
        $this->segnalazione = $segnalazione;
    }
 
    public function setIdUtente(int $idUtente): void {
        $this->idUtente = $idUtente;
    }
 
    // GET methods
    public function getIdRecensione(): int {
        return $this->idRecensione;
    }
 
    public function getValutazione(): int {
        return $this->valutazione;
    }
 
    public function getTesto(): string {
        return $this->testo;
    }
 
    public function getData(): DateTime {
        return $this->data;
    }
 
    public function getSegnalazione(): bool {
        return $this->segnalazione;
    }
 
    public function getIdUtente(): int {
        return $this->idUtente;
    }
}
