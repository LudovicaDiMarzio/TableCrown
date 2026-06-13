<?php
namespace TableCrown\Entity;

use InvalidArgumentException;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: "ordine")]
class EOrdine {

    private static array $statiValidi = ['in attesa', 'confermato', 'spedito', 'consegnato', 'annullato'];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $idOrdine = null;

    #[ORM\Column(type: "datetime")]
    private DateTime $data;

    #[ORM\Column(type: "string", length: 20)]
    private string $stato;

    #[ORM\ManyToOne(targetEntity: EUtente::class)]
    #[ORM\JoinColumn(name: "utente_id", referencedColumnName: "idpersona", nullable: false)]
    private EUtente $utente;

    #[ORM\ManyToMany(targetEntity: ECartaDiCredito::class)]
    #[ORM\JoinTable(name: "ordine_carta_di_credito")]
    private Collection $carteDiCredito;

    #[ORM\OneToMany(targetEntity: EOrdineItem::class, mappedBy: "ordine", cascade: ["persist", "remove"])]
    private Collection $ordineItems;

    public function __construct(EUtente $utente, string $stato = 'in attesa') {
        $this->data = new DateTime();
        $this->impostaStato($stato);
        $this->utente = $utente;
        $this->carteDiCredito = new ArrayCollection();
        $this->ordineItems = new ArrayCollection();
    }

    // Metodi di dominio
    public function impostaStato(string $stato): void {
        $stato = trim($stato);
        if (!in_array($stato, self::$statiValidi)) {
            throw new InvalidArgumentException("Stato ordine non valido. Valori accettati: " . implode(", ", self::$statiValidi));
        }
        $this->stato = $stato;
    }

    public function confermato(): void {
        $this->impostaStato('confermato');
    }

    public function spedito(): void {
        $this->impostaStato('spedito');
    }

    public function consegnato(): void {
        $this->impostaStato('consegnato');
    }

    public function annulla(): void {
        $this->impostaStato('annullato');
    }

    public function addCartaDiCredito(ECartaDiCredito $carta): void {
        if (!$this->carteDiCredito->contains($carta)) {
            $this->carteDiCredito->add($carta);
        }
    }

    public function removeCartaDiCredito(ECartaDiCredito $carta): void {
        $this->carteDiCredito->removeElement($carta);
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

    public function getStato(): string {
        return $this->stato;
    }

    public function getUtente(): EUtente {
        return $this->utente;
    }

    public function getCarteDiCredito(): Collection {
        return $this->carteDiCredito;
    }

    public function getOrdineItems(): Collection {
        return $this->ordineItems;
    }
}