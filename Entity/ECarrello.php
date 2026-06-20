<?php
namespace TableCrown\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

//#[ORM\Entity]
//#[ORM\Table(name: "carrello")]
class ECarrello {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $idCarrello = null;

    #[ORM\Column(type: "datetime")]
    private DateTime $dataCreazione;

    #[ORM\Column(type: "datetime")]
    private DateTime $ultimaModifica;

    #[ORM\OneToOne(targetEntity: EUtente::class)]
    #[ORM\JoinColumn(name: "utente_id", referencedColumnName: "idpersona", nullable: false)]
    private EUtente $utente;

    #[ORM\OneToMany(targetEntity: ECarrelloItem::class, mappedBy: "carrello", cascade: ["persist", "remove"])]
    private Collection $carrelloItems;

    public function __construct(EUtente $utente) {
        $this->dataCreazione = new DateTime();
        $this->ultimaModifica = new DateTime();
        $this->utente = $utente;
        $this->carrelloItems = new ArrayCollection();
    }

    // Metodi di dominio
    public function aggiornaUltimaModifica(): void {
        $this->ultimaModifica = new DateTime();
    }

    public function addCarrelloItem(ECarrelloItem $item): void {
        if (!$this->carrelloItems->contains($item)) {
            $this->carrelloItems->add($item);
            $this->aggiornaUltimaModifica();
        }
    }

    public function removeCarrelloItem(ECarrelloItem $item): void {
        if ($this->carrelloItems->contains($item)) {
            $this->carrelloItems->removeElement($item);
            $this->aggiornaUltimaModifica();
        }
    }

    // GET methods
    public function getIdCarrello(): ?int {
        return $this->idCarrello;
    }

    public function getDataCreazione(): DateTime {
        return $this->dataCreazione;
    }

    public function getUltimaModifica(): DateTime {
        return $this->ultimaModifica;
    }

    public function getUtente(): EUtente {
        return $this->utente;
    }

    public function getCarrelloItems(): Collection {
        return $this->carrelloItems;
    }
}