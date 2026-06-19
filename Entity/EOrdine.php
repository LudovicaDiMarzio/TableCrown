<?php
namespace TableCrown\Entity;

use InvalidArgumentException;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use TableCrown\Entity\Enumerativi\StatoOrdine;

#[ORM\Entity]
#[ORM\Table(name: "ordine")]
class EOrdine {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $idOrdine = null;

    #[ORM\Column(type: "datetime")]
    private DateTime $data;

    #[ORM\Column(type: "string", enumType: StatoOrdine::class)]
    private StatoOrdine $stato;

    #[ORM\ManyToOne(targetEntity: EUtente::class, inversedBy: "ordini")]
    #[ORM\JoinColumn(name: "utente_id", referencedColumnName: "idpersona", nullable: false)]
    private EUtente $utente;

    #[ORM\ManyToOne(targetEntity: ECartaDiCredito::class)]
    #[ORM\JoinColumn(name: "carta_id", referencedColumnName: "idCartaDiCredito")]
    private ?ECartaDiCredito $cartaDiCredito = null;

    #[ORM\OneToMany(targetEntity: EOrdineItem::class, mappedBy: "ordine", cascade: ["persist", "remove"])]
    private Collection $ordineItems;

    public function __construct(EUtente $utente, StatoOrdine $stato = StatoOrdine::IN_LAVORAZIONE) {
        $this->data = new DateTime();
        $this->stato=$stato;
        $this->utente = $utente;
        $this->ordineItems = new ArrayCollection(); 
        $utente->riceviOrdine($this); 
    }

    // Metodi di dominio    
    public function spedisciOrdine(): void {
        if ($this->stato !== StatoOrdine::IN_LAVORAZIONE) {
            throw new \Exception("Solo un ordine in elaborazione può essere spedito.");
        }
        $this->stato = StatoOrdine::SPEDITO;
    }

    

    public function consegnaOrdine(): void {
        if ($this->stato !== StatoOrdine::SPEDITO) {
            throw new \Exception("Solo un ordine già spedito può essere consegnato.");
        }
        $this->stato = StatoOrdine::CONSEGNATO;
    }
    

    public function annulla(): void {
        if ($this->stato !== StatoOrdine::IN_LAVORAZIONE) {
            throw new \Exception("Solo un ordine in elaborazione può essere annullato.");
        }
        $this->stato = StatoOrdine::ANNULLATO;
    }
    
    public function associaMetodoDiPagamento(ECartaDiCredito $carta): void {
        // Invariante di dominio: non puoi cambiare o associare una carta se l'ordine non è in modifica
        if ($this->stato !== StatoOrdine::IN_LAVORAZIONE) {
            throw new \DomainException(
                "Impossibile associare un metodo di pagamento a un ordine in stato: " . $this->stato->value
            );
        }
        $this->cartaDiCredito = $carta;
    }

   
    public function addOrdineItem(EOrdineItem $item): void {
        if (!$this->ordineItems->contains($item)) {
            $this->ordineItems->add($item);
        }
    }

    public function removeOrdineItem(EOrdineItem $item): void {
        $this->ordineItems->removeElement($item);
    }

    // GET methods
    public function getIdOrdine(): ?int {
        return $this->idOrdine;
    }

    public function getData(): DateTime {
        return $this->data;
    }

    public function getStato(): StatoOrdine {
        return $this->stato;
    }

    public function getUtente(): EUtente {
        return $this->utente;
    }

    // Il getter serve solo per poter leggere la carta esternamente (es. nelle View)
    public function getCartaDiCredito(): ?ECartaDiCredito {
        return $this->cartaDiCredito;
    }

    public function getOrdineItems(): Collection {
        return $this->ordineItems;
    }
}