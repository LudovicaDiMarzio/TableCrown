<?php
namespace TableCrown\Entity;

use InvalidArgumentException;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "recensione")]
class ERecensione {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $idRecensione = null;

    #[ORM\Column(type: "integer")]
    private int $valutazione;

    #[ORM\Column(type: "text")]
    private string $testo;

    #[ORM\Column(type: "datetime")]
    private DateTime $data;

    #[ORM\Column(type: "boolean")]
    private bool $segnalazione;

    #[ORM\ManyToOne(targetEntity: EUtente::class)]
    #[ORM\JoinColumn(name: "utente_id", referencedColumnName: "idpersona", nullable: false)]
    private EUtente $utente;

    public function __construct(int $valutazione, string $testo, EUtente $utente) {
        $this->impostaValutazione($valutazione);
        $this->impostaTesto($testo);
        $this->data = new DateTime();
        $this->segnalazione = false;
        $this->utente = $utente;
    }

    // Metodi di dominio
    public function impostaValutazione(int $valutazione): void {
        if ($valutazione < 1 || $valutazione > 5) {
            throw new InvalidArgumentException("La valutazione deve essere compresa tra 1 e 5.");
        }
        $this->valutazione = $valutazione;
    }

    public function impostaTesto(string $testo): void {
        if (trim($testo) === '') {
            throw new InvalidArgumentException("Il testo della recensione non può essere vuoto.");
        }
        $this->testo = trim($testo);
    }

    public function segnala(): void {
        $this->segnalazione = true;
    }

    public function rimuoviSegnalazione(): void {
        $this->segnalazione = false;
    }

    // GET methods
    public function getIdRecensione(): ?int {
        return $this->idRecensione;
    }

    public function getValutazione(): int {
        return $this->valutazione;
    }

    public function getTesto(): string {
        return $this->testo;
    }

    public function getData(): DateTime {
        return $this->data;
    }

    public function getSegnalazione(): bool {
        return $this->segnalazione;
    }

    public function getUtente(): EUtente {
        return $this->utente;
    }
}