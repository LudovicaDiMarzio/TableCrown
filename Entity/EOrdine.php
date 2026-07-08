<?php
namespace TableCrown\Entity;

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

    #[ORM\ManyToOne(targetEntity: EIndirizzo::class)]
    #[ORM\JoinColumn(name: "indirizzo_id", referencedColumnName: "idIndirizzo", nullable: false)]
    private EIndirizzo $indirizzoSpedizione;

    // ─── Snapshot carta di credito ───────────────────────────────────────
    // Non salviamo il riferimento alla carta ma solo i dati necessari
    // così se la carta viene eliminata o scade, lo storico degli ordini rimane intatto
    #[ORM\Column(type: "string", length: 4)]
    private string $ultimeQuattroCifreCarta;

    #[ORM\Column(type: "string", length: 100)]
    private string $nomeTitolareCarta;

    #[ORM\OneToMany(targetEntity: EOrdineItem::class, mappedBy: "ordine", cascade: ["persist", "remove"])]
    private Collection $ordineItems;

    // ─── Costruttore ─────────────────────────────────────────────────────
    public function __construct(
        EUtente $utente,
        EIndirizzo $indirizzo,
        ECartaDiCredito $carta
    ) {
        // verifica che la carta appartenga all'utente che sta ordinando
        $this->validaCartaUtente($carta, $utente);

        $this->data = new DateTime();
        $this->stato = StatoOrdine::IN_LAVORAZIONE; // nasce sempre in lavorazione
        $this->utente = $utente;
        $this->indirizzoSpedizione = $indirizzo;
        $this->ordineItems = new ArrayCollection();

        // salviamo snapshot della carta — non il riferimento
        $this->ultimeQuattroCifreCarta = substr($carta->getNumero(), -4);
        $this->nomeTitolareCarta = $carta->getNomeTitolare() ;

        // coerenza bidirezionale
        $utente->riceviOrdine($this);
    }

    // ─── Metodi di dominio ───────────────────────────────────────────────

    public function spedisciOrdine(): void
    {
        if ($this->stato !== StatoOrdine::IN_LAVORAZIONE) {
            throw new \DomainException("Solo un ordine in lavorazione può essere spedito.");
        }
        $this->stato = StatoOrdine::SPEDITO;
    }

    public function consegnaOrdine(): void
    {
        if ($this->stato !== StatoOrdine::SPEDITO) {
            throw new \DomainException("Solo un ordine già spedito può essere consegnato.");
        }
        $this->stato = StatoOrdine::CONSEGNATO;
    }

    public function annulla(): void
    {
        if ($this->stato === StatoOrdine::CONSEGNATO) {
            throw new \DomainException("Un ordine già consegnato non può essere annullato.");
        }
        if ($this->stato === StatoOrdine::ANNULLATO) {
            throw new \DomainException("L'ordine è già annullato.");
        }
        $this->stato = StatoOrdine::ANNULLATO;
    }

    // aggiunge un prodotto all'ordine — crea automaticamente l'item
    public function aggiungiProdotto(EProdotto $prodotto, int $quantita): void
    {
        if ($this->stato !== StatoOrdine::IN_LAVORAZIONE) {
            throw new \DomainException("Non puoi modificare un ordine che non è in lavorazione.");
        }

        // se il prodotto è già nell'ordine, aggiorniamo la quantità
        foreach ($this->ordineItems as $item) {
            if ($item->getProdotto() === $prodotto) {
                $item->impostaQuantita($item->getQuantita() + $quantita);
                return;
            }
        }

        // altrimenti creiamo un nuovo item
        // EOrdineItem chiama $ordine->addOrdineItem($this) nel costruttore
        new EOrdineItem($quantita, $this, $prodotto);
    }

    public function rimuoviProdotto(EProdotto $prodotto): void
    {
        if ($this->stato !== StatoOrdine::IN_LAVORAZIONE) {
            throw new \DomainException("Non puoi modificare un ordine che non è in lavorazione.");
        }

        foreach ($this->ordineItems as $item) {
            if ($item->getProdotto() === $prodotto) {
                $this->ordineItems->removeElement($item);
                return;
            }
        }

        throw new \DomainException("Il prodotto non è presente nell'ordine.");
    }

    // metodo chiamato da EOrdineItem nel costruttore per coerenza bidirezionale
    public function addOrdineItem(EOrdineItem $item): void
    {
        if (!$this->ordineItems->contains($item)) {
            $this->ordineItems->add($item);
        }
    }

    // calcola il totale dell'ordine sommando tutti gli item
    public function calcolaTotale(): float
    {
        $totale = 0.0;
        foreach ($this->ordineItems as $item) {
            $totale += $item->calcolaTotaleItem();
        }
        return $totale;
    }

    // ─── Getter ─────────────────────────────────────────────────────────
    public function getIdOrdine(): ?int                   { return $this->idOrdine; }
    public function getData(): DateTime                   { return $this->data; }
    public function getStato(): StatoOrdine               { return $this->stato; }
    public function getUtente(): EUtente                  { return $this->utente; }
    public function getIndirizzoSpedizione(): EIndirizzo  { return $this->indirizzoSpedizione; }
    public function getUltimeQuattroCifreCarta(): string  { return $this->ultimeQuattroCifreCarta; }
    public function getNomeTitolareCarta(): string         { return $this->nomeTitolareCarta; }
    public function getOrdineItems(): Collection          { return $this->ordineItems; }

    // ─── Metodi privati ──────────────────────────────────────────────────
    private function validaCartaUtente(ECartaDiCredito $carta, EUtente $utente): void
    {
        if ($carta->getUtente() !== $utente) {
            throw new \DomainException("La carta non appartiene all'utente che sta effettuando l'ordine.");
        }
    }
}