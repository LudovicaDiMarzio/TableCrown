<?php
namespace TableCrown\Entity;

use InvalidArgumentException;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

//Per creare relazione bidirezionale
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: "recensione")]
class ERecensione {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $idRecensione = null;

    #[ORM\Column(type: "integer")]
    private int $valutazione;

    #[ORM\Column(type: "text")]
    private string $testo;

    #[ORM\Column(type: "datetime")]
    private DateTime $data;

    #[ORM\ManyToOne(targetEntity: EUtente::class, inversedBy: "recensioni")]
    #[ORM\JoinColumn(name: "utente_id", referencedColumnName: "idpersona", nullable: false)]
    private EUtente $utente;

    #[ORM\ManyToOne(targetEntity: EProdotto::class, inversedBy: "recensioni")]
    #[ORM\JoinColumn(name: "prodotto_id", referencedColumnName: "idProdotto", nullable: false)]
    private EProdotto $prodotto;

    //crea la relazione bidirezionale con ESegnalazione, questo è una lista di segnalazioni legate all'utente esplicitato nella classe ESegnalazione
    #[ORM\OneToMany(targetEntity: ESegnalazione::class, mappedBy: "recensione", cascade: ["persist"])]
    private Collection $segnalazioni;


    public function __construct(int $valutazione, string $testo, EUtente $utente, EProdotto $prodotto) {
        $this->impostaValutazione($valutazione);
        $this->impostaTesto($testo);
        $this->data = new DateTime();
        $this->utente = $utente;
        $utente->riceviRecensione($this);
        $this->prodotto = $prodotto;
        $prodotto->addRecensione($this);
        $this->segnalazioni = new ArrayCollection();
    }

    // Metodi di dominio
    public function impostaValutazione(int $valutazione): void {
        if ($valutazione < 1 || $valutazione > 5) {
            throw new InvalidArgumentException("La valutazione deve essere compresa tra 1 e 5.");
        }
        $this->valutazione = $valutazione;
    }

    public function impostaTesto(string $testo): void {
        if (trim($testo) === '') {
            throw new InvalidArgumentException("Il testo della recensione non può essere vuoto.");
        }
        $this->testo = trim($testo);
    }

    //Aggiunge una nuova segnalazione allo storico di quelle ricevute da questa recensione.
    public function riceviSegnalazione(ESegnalazione $nuovaSegnalazione): void {
        
        // Verifica che questa specifica segnalazione non sia già stata inserita nella lista
        if (!$this->segnalazioni->contains($nuovaSegnalazione)) {
            $this->segnalazioni->add($nuovaSegnalazione);
        }
    }

    public function isSegnalata(): bool {
        // Restituisce TRUE se la lista delle vere segnalazioni NON è vuota
        return !$this->segnalazioni->isEmpty();
    }

    // GET methods
    public function getIdRecensione(): ?int {
        return $this->idRecensione;
    }

    public function getValutazione(): int {
        return $this->valutazione;
    }

    public function getTesto(): string {
        return $this->testo;
    }

    public function getData(): DateTime {
        return $this->data;
    }

    public function getUtente(): EUtente {
        return $this->utente;
    }

    public function getProdotto(): EProdotto {
        return $this->prodotto;
    }

    // Restituisce l'elenco (collection) di tutte le segnalazioni ricevute.
    public function getSegnalazioni(): Collection 
    {
        return $this->segnalazioni;
    }
}