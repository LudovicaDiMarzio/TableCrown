<?php
namespace TableCrown\Entity;
use DateTime;
use Override;
use TableCrown\Entity\Enumerativi\StatoEvento;

class ESerata extends EEvento {
    // Proprietà specifiche per la serata
    private string $tipo; //es. serata gioco libero, serata presentazione gioco, ecc.

    public function __construct(?int $idEvento, string $nomeEvento, string $imgEvento, string $descrizioneEvento, DateTime $dataInizio, int $maxPartecipanti, StatoEvento $statoEvento, array $partecipanti, string $tipo) {
        parent::__construct($idEvento, $nomeEvento, $imgEvento, $descrizioneEvento, $dataInizio, $maxPartecipanti);
        $this->aggiornaTipo($tipo); //utilizza il metodo di dominio per validare il tipo della serata
    }

    //GET methods
    public function getTipo(): string {
        return $this->tipo;
    }

    //Metodi di dominio

    /**
     * Aggiorna il tipo di serata.
     */
    public function aggiornaTipo(string $tipo): void {
        $this->tipo = trim($tipo);
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