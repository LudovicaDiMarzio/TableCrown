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
    private string $nome; //es. serata gioco libero, serata presentazione gioco, ecc.

    public function __construct(string $nomeEvento, string $imgEvento, string $descrizioneEvento, DateTime $dataInizio, int $maxPartecipanti, string $nome) {
        parent::__construct($nomeEvento, $imgEvento, $descrizioneEvento, $dataInizio, $maxPartecipanti);
        $this->aggiornaNome($nome); //utilizza il metodo di dominio per validare il tipo della serata
    }

    //GET methods
    public function getNome(): string {
        return $this->nome;
    }

    //Metodi di dominio

    /**
     * Aggiorna il tipo di serata.
     */
    public function aggiornaNome(string $nome): void {
        $this->nome = trim($nome);
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