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

    public function __construct(
        string $nome,
        string $via,
        string $citta,
        string $cap,
        string $provincia,
        string $nazione,
        string $nomeCitofono,
        EUtente $utente
    ) {
        $this->impostaNome($nome);
        $this->impostaVia($via);
        $this->impostaCitta($citta);
        $this->impostaCap($cap);
        $this->impostaProvincia($provincia);
        $this->impostaNazione($nazione);
        $this->impostaNomeCitofono($nomeCitofono);
        $this->utente = $utente;
    }

    // ─── Metodi di dominio ───────────────────────────────────────────────
    public function impostaNome(string $nome): void {
        $nome = trim($nome);
        if (empty($nome)) {
            throw new InvalidArgumentException("Il nome dell'indirizzo non può essere vuoto.");
        }
        $this->nome = $nome;
    }

    public function impostaVia(string $via): void {
        $via = trim($via);
        if (empty($via)) {
            throw new InvalidArgumentException("La via non può essere vuota.");
        }
        $this->via = $via;
    }

    public function impostaCitta(string $citta): void {
        $citta = trim($citta);
        if (empty($citta)) {
            throw new InvalidArgumentException("La città non può essere vuota.");
        }
        $this->citta = $citta;
    }

    public function impostaCap(string $cap): void {
        if (!preg_match('/^\d{5}$/', trim($cap))) {
            throw new InvalidArgumentException("CAP non valido. Deve essere composto da 5 cifre.");
        }
        $this->cap = trim($cap);
    }

    public function impostaProvincia(string $provincia): void {
        $provincia = trim($provincia);
        if (empty($provincia)) {
            throw new InvalidArgumentException("La provincia non può essere vuota.");
        }
        $this->provincia = $provincia;
    }

    public function impostaNazione(string $nazione): void {
        $nazione = trim($nazione);
        if (empty($nazione)) {
            throw new InvalidArgumentException("La nazione non può essere vuota.");
        }
        $this->nazione = $nazione;
    }

    public function impostaNomeCitofono(string $nomeCitofono): void {
        $nomeCitofono = trim($nomeCitofono);
        if (empty($nomeCitofono)) {
            throw new InvalidArgumentException("Il nome del citofono non può essere vuoto.");
        }
        $this->nomeCitofono = $nomeCitofono;
    }

    // ─── Getter ─────────────────────────────────────────────────────────
    public function getIdIndirizzo(): ?int    { return $this->idIndirizzo; }
    public function getNome(): string         { return $this->nome; }
    public function getVia(): string          { return $this->via; }
    public function getCitta(): string        { return $this->citta; }
    public function getCap(): string          { return $this->cap; }
    public function getProvincia(): string    { return $this->provincia; }
    public function getNazione(): string      { return $this->nazione; }
    public function getNomeCitofono(): string { return $this->nomeCitofono; }
    public function getUtente(): EUtente      { return $this->utente; }
}