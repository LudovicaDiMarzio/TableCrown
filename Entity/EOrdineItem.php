<?php
namespace TableCrown\Entity;

use InvalidArgumentException;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "ordine_item")]
class EOrdineItem {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $idOrdineItem = null;

    #[ORM\Column(type: "integer")]
    private int $quantita;

    // ─── Snapshot prezzo al momento dell'acquisto ────────────────────────
    // Se il prezzo del prodotto cambia in futuro, la fattura rimane corretta
    #[ORM\Column(type: "float")]
    private float $prezzoUnitario;

    #[ORM\Column(type: "float")]
    private float $scontoApplicato;

    #[ORM\ManyToOne(targetEntity: EOrdine::class, inversedBy: "ordineItems")]
    #[ORM\JoinColumn(name: "ordine_id", referencedColumnName: "idOrdine", nullable: false)]
    private EOrdine $ordine;

    #[ORM\ManyToOne(targetEntity: EProdotto::class)]
    #[ORM\JoinColumn(name: "prodotto_id", referencedColumnName: "idProdotto", nullable: false)]
    private EProdotto $prodotto;

    public function __construct(int $quantita, EOrdine $ordine, EProdotto $prodotto) {
        $this->impostaQuantita($quantita);
        $this->ordine = $ordine;
        $this->prodotto = $prodotto;

        // snapshot del prezzo attuale del prodotto
        $this->prezzoUnitario = $prodotto->getPrezzo()->getValore();
        $this->scontoApplicato = $prodotto->getPrezzo()->getSconto();

        // coerenza bidirezionale con EOrdine
        $ordine->addOrdineItem($this);
    }

    // ─── Metodi di dominio ───────────────────────────────────────────────
    public function impostaQuantita(int $quantita): void {
        if ($quantita <= 0) {
            throw new InvalidArgumentException("La quantità deve essere maggiore di 0.");
        }
        $this->quantita = $quantita;
    }

    public function calcolaTotaleItem(): float {
        return $this->prezzoUnitario * $this->quantita * (1 - $this->scontoApplicato / 100);
    }

    // ─── Getter ─────────────────────────────────────────────────────────
    public function getIdOrdineItem(): ?int    { return $this->idOrdineItem; }
    public function getQuantita(): int         { return $this->quantita; }
    public function getOrdine(): EOrdine       { return $this->ordine; }
    public function getProdotto(): EProdotto   { return $this->prodotto; }
    public function getPrezzoUnitario(): float { return $this->prezzoUnitario; }
    public function getScontoApplicato(): float { return $this->scontoApplicato; }
}