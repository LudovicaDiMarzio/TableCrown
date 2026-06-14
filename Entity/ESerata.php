<?php
namespace TableCrown\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Override;
use TableCrown\Entity\Enumerativi\StatoEvento;

#[ORM\Entity]
#[ORM\Table(name: "serata")]
class ESerata extends EEvento {
    // Proprietà specifiche per la serata
    #[ORM\Column(type: "string", length: 255)]
    private string $tipoSerata; //es. serata gioco libero, serata presentazione gioco, ecc.

    public function __construct(string $nomeEvento, string $imgEvento, string $descrizioneEvento, DateTime $dataInizio, int $maxPartecipanti, string $tipoSerata) {
        parent::__construct($nomeEvento, $imgEvento, $descrizioneEvento, $dataInizio, $maxPartecipanti);
        $this->aggiornaTipoSerata($tipoSerata); //utilizza il metodo di dominio per validare il tipo della serata
    }

    //GET methods
    public function getTipoSerata(): string {
        return $this->tipoSerata;
    }

    //Metodi di dominio

    /**
     * Aggiorna il tipo di serata.
     */
    public function aggiornaTipoSerata(string $tipoSerata): void {
        $this->tipoSerata = trim($tipoSerata);
    }

    /**
     * Implementazione del metodo astratto richiedeQuota() di EEvento
     */
    #[Override]
    public function richiedeQuota(): bool
    {
        return false;
    }
}