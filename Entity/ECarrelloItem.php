<?php
namespace TableCrown\Entity;

use InvalidArgumentException;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "carrello_item")]
class ECarrelloItem {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $idCarrelloItem = null;

    #[ORM\Column(type: "integer")]
    private int $quantita;

    #[ORM\ManyToOne(targetEntity: ECarrello::class, inversedBy: "carrelloItems")]
    #[ORM\JoinColumn(name: "carrello_id", referencedColumnName: "idCarrello", nullable: false)]
    private ECarrello $carrello;

    #[ORM\ManyToOne(targetEntity: EProdotto::class)]
    #[ORM\JoinColumn(name: "prodotto_id", referencedColumnName: "idProdotto", nullable: false)]
    private EProdotto $prodotto;

    public function __construct(int $quantita, ECarrello $carrello, EProdotto $prodotto) {
        $this->impostaQuantita($quantita);
        $this->carrello = $carrello;
        $this->prodotto = $prodotto;
    }

    // Metodi di dominio
    public function impostaQuantita(int $quantita): void {
        if ($quantita <= 0) {
            throw new InvalidArgumentException("La quantità deve essere maggiore di 0.");
        }
        $this->quantita = $quantita;
    }

    public function incrementaQuantita(int $valore = 1): void {
        $this->impostaQuantita($this->quantita + $valore);
    }

    // GET methods
    public function getIdCarrelloItem(): ?int {
        return $this->idCarrelloItem;
    }

    public function getQuantita(): int {
        return $this->quantita;
    }

    public function getCarrello(): ECarrello {
        return $this->carrello;
    }

    public function getProdotto(): EProdotto {
        return $this->prodotto;
    }
}