<?php
namespace TableCrown\Entity;

use InvalidArgumentException;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "indirizzo")]
class EIndirizzo {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $idIndirizzo = null;

    #[ORM\Column(type: "string", length: 100)]
    private string $nome;

    #[ORM\Column(type: "string", length: 255)]
    private string $via;

    #[ORM\Column(type: "string", length: 100)]
    private string $citta;

    #[ORM\Column(type: "string", length: 5)]
    private string $cap;

    #[ORM\Column(type: "string", length: 100)]
    private string $provincia;

    #[ORM\Column(type: "string", length: 100)]
    private string $nazione;

    #[ORM\Column(type: "string", length: 100)]
    private string $nomeCitofono;

    #[ORM\ManyToOne(targetEntity: EUtente::class)]
    #[ORM\JoinColumn(name: "utente_id", referencedColumnName: "idpersona", nullable: false)]
    private EUtente $utente;

    public function __construct(string $nome, string $via, string $citta, string $cap, string $provincia, string $nazione, string $nomeCitofono, EUtente $utente) {
        $this->nome = trim($nome);
        $this->via = trim($via);
        $this->citta = trim($citta);
        $this->impostaCap($cap);
        $this->provincia = trim($provincia);
        $this->nazione = trim($nazione);
        $this->nomeCitofono = trim($nomeCitofono);
        $this->utente = $utente;
    }

    // Metodi di dominio
    public function impostaCap(string $cap): void {
        if (!preg_match('/^\d{5}$/', trim($cap))) {
            throw new InvalidArgumentException("CAP non valido. Deve essere composto da 5 cifre.");
        }
        $this->cap = trim($cap);
    }

    // SET methods
    public function setNome(string $nome): void {
        $this->nome = trim($nome);
    }

    public function setVia(string $via): void {
        $this->via = trim($via);
    }

    public function setCitta(string $citta): void {
        $this->citta = trim($citta);
    }

    public function setProvincia(string $provincia): void {
        $this->provincia = trim($provincia);
    }

    public function setNazione(string $nazione): void {
        $this->nazione = trim($nazione);
    }

    public function setNomeCitofono(string $nomeCitofono): void {
        $this->nomeCitofono = trim($nomeCitofono);
    }

    // GET methods
    public function getIdIndirizzo(): ?int {
        return $this->idIndirizzo;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function getVia(): string {
        return $this->via;
    }

    public function getCitta(): string {
        return $this->citta;
    }

    public function getCap(): string {
        return $this->cap;
    }

    public function getProvincia(): string {
        return $this->provincia;
    }

    public function getNazione(): string {
        return $this->nazione;
    }

    public function getNomeCitofono(): string {
        return $this->nomeCitofono;
    }

    public function getUtente(): EUtente {
        return $this->utente;
    }
}