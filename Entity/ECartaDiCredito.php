<?php
namespace TableCrown\Entity;

use InvalidArgumentException;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "carta_di_credito")]
class ECartaDiCredito {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $idCartaDiCredito = null;

    #[ORM\Column(type: "string", length: 100)]
    private string $nomeTitolare;

    #[ORM\Column(type: "string", length: 100)]
    private string $cognomeTitolare;

    #[ORM\Column(type: "datetime")]
    private DateTime $dataScadenza;

    #[ORM\Column(type: "string", length: 16)]
    private string $numero;

    #[ORM\Column(type: "string", length: 3)]
    private string $ccv;

    #[ORM\ManyToOne(targetEntity: EUtente::class)]
    #[ORM\JoinColumn(name: "utente_id", referencedColumnName: "idpersona", nullable: false)]
    private EUtente $utente;

    public function __construct(string $nomeTitolare, string $cognomeTitolare, DateTime $dataScadenza, string $numero, string $ccv, EUtente $utente) {
        $this->utente = $utente;
        $this->impostaNomeTitolare($nomeTitolare);
        $this->impostaCognomeTitolare($cognomeTitolare);
        $this->impostaDataScadenza($dataScadenza);
        $this->impostaNumero($numero);
        $this->impostaCcv($ccv);
    }

    // Metodi di dominio
    public function impostaNomeTitolare(string $nomeTitolare): void {
        if (trim($nomeTitolare) === '') {
            throw new InvalidArgumentException("Il nome del titolare non può essere vuoto.");
        }
        $this->nomeTitolare = trim($nomeTitolare);
    }

    public function impostaCognomeTitolare(string $cognomeTitolare): void {
        if (trim($cognomeTitolare) === '') {
            throw new InvalidArgumentException("Il cognome del titolare non può essere vuoto.");
        }
        $this->cognomeTitolare = trim($cognomeTitolare);
    }

    public function impostaDataScadenza(DateTime $dataScadenza): void {
        if ($dataScadenza < new DateTime()) {
            throw new InvalidArgumentException("La carta di credito è scaduta.");
        }
        $this->dataScadenza = $dataScadenza;
    }

    public function impostaNumero(string $numero): void {
        if (!preg_match('/^\d{16}$/', trim($numero))) {
            throw new InvalidArgumentException("Il numero della carta deve essere composto da 16 cifre.");
        }
        $this->numero = trim($numero);
    }

    public function impostaCcv(string $ccv): void {
        if (!preg_match('/^\d{3}$/', trim($ccv))) {
            throw new InvalidArgumentException("Il CCV deve essere composto da 3 cifre.");
        }
        $this->ccv = trim($ccv);
    }

    // GET methods
    public function getIdCartaDiCredito(): ?int {
        return $this->idCartaDiCredito;
    }

    public function getNomeTitolare(): string {
        return $this->nomeTitolare;
    }

    public function getCognomeTitolare(): string {
        return $this->cognomeTitolare;
    }

    public function getDataScadenza(): DateTime {
        return $this->dataScadenza;
    }

    public function getNumero(): string {
        return $this->numero;
    }

    public function getCcv(): string {
        return $this->ccv;
    }

    public function getUtente(): EUtente {
        return $this->utente;
    }
}