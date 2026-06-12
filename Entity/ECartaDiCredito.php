<?php
namespace TableCrown\Entity;
 
use InvalidArgumentException;
use DateTime;
 
class ECartaDiCredito {
    private int $idCartaDiCredito;
    private string $nomeTitolare;
    private string $cognomeTitolare;
    private DateTime $dataScadenza;
    private string $numero; // conservato come stringa per preservare eventuali zeri iniziali
    private string $ccv;
    private Eutente $Utente; // FK -> EUtente
 
    public function __construct(int $idCartaDiCredito, string $nomeTitolare, string $cognomeTitolare, DateTime $dataScadenza, string $numero, string $ccv, Eutente $Utente) {
        $this->idCartaDiCredito = $idCartaDiCredito;
        $this->Utente = $Utente;
 
        if (trim($nomeTitolare) === '') {
            throw new InvalidArgumentException("Il nome del titolare non può essere vuoto.");
        }
        $this->nomeTitolare = trim($nomeTitolare);
 
        if (trim($cognomeTitolare) === '') {
            throw new InvalidArgumentException("Il cognome del titolare non può essere vuoto.");
        }
        $this->cognomeTitolare = trim($cognomeTitolare);
 
        if ($dataScadenza < new DateTime()) {
            throw new InvalidArgumentException("La carta di credito è scaduta.");
        }
        $this->dataScadenza = $dataScadenza;
 
        if (!preg_match('/^\d{16}$/', trim($numero))) {
            throw new InvalidArgumentException("Il numero della carta deve essere composto da 16 cifre.");
        }
        $this->numero = trim($numero);
 
        if (!preg_match('/^\d{3}$/', trim($ccv))) {
            throw new InvalidArgumentException("Il CCV deve essere composto da 3 cifre.");
        }
        $this->ccv = trim($ccv);
 
        $this->idUtente = $idUtente;
    }
 
    // SET methods
    public function setNomeTitolare(string $nomeTitolare): void {
        if (trim($nomeTitolare) === '') {
            throw new InvalidArgumentException("Il nome del titolare non può essere vuoto.");
        }
        $this->nomeTitolare = trim($nomeTitolare);
    }
 
    public function setCognomeTitolare(string $cognomeTitolare): void {
        if (trim($cognomeTitolare) === '') {
            throw new InvalidArgumentException("Il cognome del titolare non può essere vuoto.");
        }
        $this->cognomeTitolare = trim($cognomeTitolare);
    }
 
    public function setDataScadenza(DateTime $dataScadenza): void {
        if ($dataScadenza < new DateTime()) {
            throw new InvalidArgumentException("La carta di credito è scaduta.");
        }
        $this->dataScadenza = $dataScadenza;
    }
 
    public function setNumero(string $numero): void {
        if (!preg_match('/^\d{16}$/', trim($numero))) {
            throw new InvalidArgumentException("Il numero della carta deve essere composto da 16 cifre.");
        }
        $this->numero = trim($numero);
    }
 
    public function setCcv(string $ccv): void {
        if (!preg_match('/^\d{3}$/', trim($ccv))) {
            throw new InvalidArgumentException("Il CCV deve essere composto da 3 cifre.");
        }
        $this->ccv = trim($ccv);
    }
 
    public function setIdUtente(int $idUtente): void {
        $this->idUtente = $idUtente;
    }
 
    // GET methods
    public function getIdCartaDiCredito(): int {
        return $this->idCartaDiCredito;
    }
 
    public function getNomeTitolare(): string {
        return $this->nomeTitolare;
    }
 
    public function getCognomeTitolare(): string {
        return $this->cognomeTitolare;
    }
 
    public function getDataScadenza(): DateTime {
        return $this->dataScadenza;
    }
 
    public function getNumero(): string {
        return $this->numero;
    }
 
    public function getCcv(): string {
        return $this->ccv;
    }
 
    public function getIdUtente(): int {
        return $this->idUtente;
    }
}