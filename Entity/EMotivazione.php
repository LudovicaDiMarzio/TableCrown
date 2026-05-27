<?php
namespace TableCrown\Entity;

use TableCrown\Entity\Enumerativi\GravitaMotivazione;

class MotivazioneSegnalazione {
    private ?int $idmotivazione=null;
    private string $nomemotivazione; //es. "contenuto inappropriato", "spam", "altro"
    private GravitaMotivazione $gravita; //può essere "bassa", "media" o "alta"

    public function __construct(string $nomemotivazione, GravitaMotivazione $gravita) {
        $this->nomemotivazione = $nomemotivazione;
        $this->gravita = $gravita;
    }

    //SET methods
    public function setNomeMotivazione(string $nomemotivazione) {
        $this->nomemotivazione = $nomemotivazione;
    }

    public function setGravitaMotivazione(GravitaMotivazione $gravita) {
        $this->gravita = $gravita;
    }

    //GET methods
    public function getIdMotivazione(): ?int {
        return $this->idmotivazione;
    }

    public function getNomeMotivazione(): string {
        return $this->nomemotivazione;
    }

    public function getGravitaMotivazione(): GravitaMotivazione {
        return $this->gravita;
    }
}