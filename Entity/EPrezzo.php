<?php
namespace TableCrown\Entity;
use InvalidArgumentException;
use TableCrown\Entity\Enumerativi\Valuta;

class EPrezzo {
    private ?int $idPrezzo;
    private float $valore;
    private Valuta $valuta;
    private ?float $sconto;

    public function __construct(int $idPrezzo, float $valore, Valuta $valuta, ?float $sconto) {
        $this->idPrezzo = $idPrezzo;
        $this->valore = $valore;
        $this->valuta = $valuta;
        $this->sconto = $sconto;
    }

    //SET methods
    public function setValore(float $valore) {
        $this->valore = $valore;
    }

    public function setValuta(Valuta $valuta) {
        $this->valuta = $valuta;
    }

    public function setSconto(?float $sconto) {
        $this->sconto = $sconto;
    }

    //GET methods
    public function getIdPrezzo(): int {
        return $this->idPrezzo;
    }

    public function getValore(): float {
        return $this->valore;
    }

    public function getValuta(): Valuta {
        return $this->valuta;
    }

    public function getSconto(): ?float {
        return $this->sconto;
    }

}