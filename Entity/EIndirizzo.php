<?php
namespace TableCrown\Entity;

use InvalidArgumentException;

class EIndirizzo {
    private int $idIndirizzo;
    private string $nome; // es. Casa, Ufficio, ...
    private string $via;
    private string $citta;
    private string $cap;
    private string $provincia;
    private string $nazione;
    private string $nomeCitofono;

    public function __construct(int $idIndirizzo, string $nome, string $via, string $citta, string $cap, string $provincia, string $nazione, string $nomeCitofono) {
        $this->idIndirizzo = $idIndirizzo;
        $this->nome = trim($nome);
        $this->via = trim($via);
        $this->citta = trim($citta);

        if (!preg_match('/^\d{5}$/', trim($cap))) {
            throw new InvalidArgumentException("CAP non valido. Deve essere composto da 5 cifre.");
        }
        $this->cap = trim($cap);

        $this->provincia = trim($provincia);
        $this->nazione = trim($nazione);
        $this->nomeCitofono = trim($nomeCitofono);
    }

    // SET methods
    public function setNome(string $nome): void {
        $this->nome = trim($nome);
    }

    public function setVia(string $via): void {
        $this->via = trim($via);
    }

    public function setCitta(string $citta): void {
        $this->citta = trim($citta);
    }

    public function setCap(string $cap): void {
        if (!preg_match('/^\d{5}$/', trim($cap))) {
            throw new InvalidArgumentException("CAP non valido. Deve essere composto da 5 cifre.");
        }
        $this->cap = trim($cap);
    }

    public function setProvincia(string $provincia): void {
        $this->provincia = trim($provincia);
    }

    public function setNazione(string $nazione): void {
        $this->nazione = trim($nazione);
    }

    public function setNomeCitofono(string $nomeCitofono): void {
        $this->nomeCitofono = trim($nomeCitofono);
    }

    // GET methods
    public function getIdIndirizzo(): int {
        return $this->idIndirizzo;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function getVia(): string {
        return $this->via;
    }

    public function getCitta(): string {
        return $this->citta;
    }

    public function getCap(): string {
        return $this->cap;
    }

    public function getProvincia(): string {
        return $this->provincia;
    }

    public function getNazione(): string {
        return $this->nazione;
    }

    public function getNomeCitofono(): string {
        return $this->nomeCitofono;
    }
}