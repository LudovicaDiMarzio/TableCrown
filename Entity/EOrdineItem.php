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

    #[ORM\ManyToOne(targetEntity: EOrdine::class, inversedBy: "ordineItems")]
    #[ORM\JoinColumn(name: "ordine_id", referencedColumnName: "idOrdine", nullable: false)]
    private EOrdine $ordine;

    #[ORM\ManyToOne(targetEntity: EProdotto::class)]
    #[ORM\JoinColumn(name: "prodotto_id", referencedColumnName: "idprodotto", nullable: false)]
    private EProdotto $prodotto;

    public function __construct(int $quantita, EOrdine $ordine, EProdotto $prodotto) {
        $this->impostaQuantita($quantita);
        $this->ordine = $ordine;
        $this->prodotto = $prodotto;
    }

    // Metodi di dominio
    public function impostaQuantita(int $quantita): void {
        if ($quantita <= 0) {
            throw new InvalidArgumentException("La quantità deve essere maggiore di 0.");
        }
        $this->quantita = $quantita;
    }

    // GET methods
    public function getIdOrdineItem(): ?int {
        return $this->idOrdineItem;
    }

    public function getQuantita(): int {
        return $this->quantita;
    }

    public function getOrdine(): EOrdine {
        return $this->ordine;
    }

    public function getProdotto(): EProdotto {
        return $this->prodotto;
    }
}