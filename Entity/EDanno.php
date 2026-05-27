<?php
namespace TableCrown\Entity;
use TableCrown\Entity\Enumerativi\LivelloDannoGiochi;

class EDanno {
    private LivelloDannoGiochi $livelloDanno; //enum per indicare il livello di danno del gioco
    private float $sconto;

    public function __construct(LivelloDannoGiochi $livelloDanno, float $sconto) {
        $this->livelloDanno = $livelloDanno;
        $this->sconto = $sconto;
    }

    //SET methods
    public function setLivelloDanno(LivelloDannoGiochi $livelloDanno) {
        $this->livelloDanno = $livelloDanno;
    }

    public function setSconto(float $sconto) {
        $this->sconto = $sconto;
    }

    //GET methods
    public function getLivelloDanno(): LivelloDannoGiochi {
        return $this->livelloDanno;
    }

    public function getSconto(): float {
        return $this->sconto;
    }
}