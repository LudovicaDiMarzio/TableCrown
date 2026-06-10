<?php
namespace TableCrown\Entity;
use TableCrown\Entity\Enumerativi\LivelloDannoGiochi;
use InvalidArgumentException;

class EDanno {
    private LivelloDannoGiochi $livelloDanno; //enum per indicare il livello di danno del gioco
    private float $sconto;

    public function __construct(LivelloDannoGiochi $livelloDanno, float $sconto) {
        $this->livelloDanno = $livelloDanno;
        $this->aggiornaSconto($sconto); //utilizza il metodo di dominio per validare lo sconto
    }

    //GET methods
    public function getLivelloDanno(): LivelloDannoGiochi {
        return $this->livelloDanno;
    }

    public function getSconto(): float {
        return $this->sconto;
    }

    //Metodi di dominio

    /**
     * Aggiorna il livello di danno
     */
    public function aggiornaLivelloDanno(LivelloDannoGiochi $livelloDanno): void {
        $this->livelloDanno = $livelloDanno;
    }

    /**
     * Aggiorna lo sconto del danno.
     */
    public function aggiornaSconto(float $sconto): void {
        if ($sconto < 0 || $sconto > 100) {
            throw new InvalidArgumentException("Lo sconto deve essere compreso tra 0 e 100.");
        }
        $this->sconto = $sconto;
    }
}