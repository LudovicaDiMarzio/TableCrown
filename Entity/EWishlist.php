<?php
namespace TableCrown\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: "wishlist")]
class EWishlist {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $idWishlist = null;

    #[ORM\Column(type: "datetime")]
    private DateTime $dataCreazione;

    #[ORM\OneToOne(targetEntity: EUtente::class)]
    #[ORM\JoinColumn(name: "utente_id", referencedColumnName: "idpersona", nullable: false)]
    private EUtente $utente;

    #[ORM\ManyToMany(targetEntity: EProdotto::class)]
    #[ORM\JoinTable(name: "wishlist_prodotto")]
    private Collection $prodotti;

    public function __construct(EUtente $utente) {
        $this->dataCreazione = new DateTime();
        $this->utente = $utente;
        $this->prodotti = new ArrayCollection();
    }

    // Metodi di dominio
    public function addProdotto(EProdotto $prodotto): void {
        if (!$this->prodotti->contains($prodotto)) {
            $this->prodotti->add($prodotto);
        }
    }

    public function removeProdotto(EProdotto $prodotto): void {
        $this->prodotti->removeElement($prodotto);
    }

    // GET methods
    public function getIdWishlist(): ?int {
        return $this->idWishlist;
    }

    public function getDataCreazione(): DateTime {
        return $this->dataCreazione;
    }

    public function getUtente(): EUtente {
        return $this->utente;
    }

    public function getProdotti(): Collection {
        return $this->prodotti;
    }
}