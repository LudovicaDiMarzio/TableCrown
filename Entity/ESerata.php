<?php
namespace TableCrown\Entity;
use DateTime;
use TableCrown\Entity\Enumerativi\StatoEvento;

class ESerata extends EEvento {
    // Proprietà specifiche per la serata
    private string $tipo; //es. serata gioco libero, serata presentazione gioco, ecc.

    public function __construct(?int $idEvento, string $nomeEvento, string $imgEvento, string $descrizioneEvento, DateTime $dataInizio, int $maxPartecipanti, StatoEvento $statoEvento, string $tipo) {
        parent::__construct($idEvento, $nomeEvento, $imgEvento, $descrizioneEvento, $dataInizio, $maxPartecipanti, $statoEvento);
        $this->tipo = trim($tipo);
    }

    //SET methods
    public function setTipo(string $tipo) {
        $this->tipo = trim($tipo);
    }

    //GET methods
    public function getTipo(): string {
        return $this->tipo;
    }
}