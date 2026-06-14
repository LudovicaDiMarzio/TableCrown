<?php
namespace TableCrown\Entity;

use Doctrine\ORM\Mapping as ORM;
use TableCrown\Entity\Enumerativi\LivelloDannoGiochi;

#[ORM\Entity]
#[ORM\Table(name: "scontodanno")]
class EScontoDanno {

    #[ORM\Id]
    #[ORM\Column(type: "string", enumType: LivelloDannoGiochi::class)]
    private LivelloDannoGiochi $livelloDanno;

    #[ORM\Column(type: "float")]
    private float $sconto;

    public function __construct(LivelloDannoGiochi $livelloDanno, float $sconto) {
        $this->livelloDanno = $livelloDanno;
        $this->sconto = $sconto;
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
     * Aggiorna lo sconto controllando che sia compreso tra 0 e 100.
     */
    public function aggiornaSconto(float $sconto): void {
        if ($sconto < 0 || $sconto > 100) {
            throw new \InvalidArgumentException("Lo sconto deve essere compreso tra 0 e 100.");
        }
        $this->sconto = $sconto;
    }
 }