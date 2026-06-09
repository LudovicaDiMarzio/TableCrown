<?php
namespace TableCrown\Entity;

use TableCrown\Entity\Enumerativi\GravitaMotivazione;

class MotivazioneSegnalazione {
    private ?int $idmotivazione=null;
    private string $nomemotivazione; //es. "contenuto inappropriato", "spam", "altro"
    private GravitaMotivazione $gravita; //può essere "bassa", "media" o "alta"

    public function __construct(string $nomemotivazione, GravitaMotivazione $gravita) {
        $this-> impostaNomeMotivazione($nomemotivazione);
        $this->gravita = $gravita;
    }

    //questa entità ha solo metodi get perchè i dati vengono inseriti solo al momento della creazione e non devono essere modificati successivamente
    


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