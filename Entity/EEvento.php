<?php
namespace TableCrown\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use DateTime;
use InvalidArgumentException;
use TableCrown\Entity\Enumerativi\StatoEvento;

#[ORM\Entity]
#[ORM\Table(name: "evento")]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "tipo", type: "string")]
#[ORM\DiscriminatorMap([
    "serata" => ESerata::class,
    "torneo" => ETorneo::class,
    "challenge" => EChallenge::class,
])]
abstract class EEvento {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $idEvento;

    #[ORM\Column(type: "string", length: 255)]
    private string $nomeEvento;

    #[ORM\Column(type: "blob")]
    private string $imgEvento;

    #[ORM\Column(type: "text")]
    private string $descrizioneEvento;

    #[ORM\Column(type: "datetime")]
    private DateTime $dataInizio;

    #[ORM\Column(type: "integer")]
    private int $maxPartecipanti;

    #[ORM\Column(type: "string", enumType: StatoEvento::class)]
    private StatoEvento $statoEvento;

    #[ORM\OneToMany(targetEntity: EPartecipazione::class, mappedBy: "evento", cascade: ["persist", "remove"])]
    private Collection $partecipazioni; //array di EPartecipazione, rappresenta le partecipazioni all'evento

    public function __construct(string $nomeEvento, string $imgEvento, string $descrizioneEvento, DateTime $dataInizio, int $maxPartecipanti) {
        $this->rinominaEvento($nomeEvento); //utilizza il metodo di dominio per validare il nome dell'evento
        $this->aggiornaImg($imgEvento); //utilizza il metodo di dominio per validare l'immagine dell'evento
        $this->aggiornaDescrizione($descrizioneEvento); //utilizza il metodo di dominio per validare la descrizione dell'evento
        $this->dataInizio = $dataInizio;
        $this->verificaDataInizio();
        $this->maxPartecipanti = $maxPartecipanti;
        $this->verificaMaxPartecipanti();
        $this->statoEvento = StatoEvento::Programmato; //lo stato iniziale dell'evento è sempre "Programmato"
        $this->partecipazioni = new ArrayCollection(); //inizializzazione della collezione di partecipazioni
    }

    //GET methods
    public function getIdEvento(): int {
        return $this->idEvento;
    }  

    public function getNomeEvento(): string {
        return $this->nomeEvento;
    }       

    public function getImgEvento(): string {
        return $this->imgEvento;
    }

    public function getDescrizioneEvento(): string {
        return $this->descrizioneEvento;
    }

    public function getDataInizio(): DateTime {
        return $this->dataInizio;
    }

    public function getMaxPartecipanti(): int {
        return $this->maxPartecipanti;
    }

    public function getStatoEvento(): StatoEvento {
        return $this->statoEvento;
    }

    public function getPartecipazioni(): Collection {
        return $this->partecipazioni;
    }

    public function getNumeroPartecipanti(): int {
        return count($this->partecipazioni);
    }

    //Metodi di dominio

    /**
     * Aggiorna il nome dell'evento.
     */
    public function rinominaEvento(string $nomeEvento): void {
        if (trim($nomeEvento) === "") {
            throw new InvalidArgumentException("Il nome dell'evento non può essere vuoto.");
        }
        $this->nomeEvento = trim($nomeEvento);
    }

    /**
     * Aggiorna la descrizione dell'evento.
     */
    public function aggiornaDescrizione(string $descrizioneEvento): void {
        if (trim($descrizioneEvento) === "") {
            throw new InvalidArgumentException("La descrizione dell'evento non può essere vuota.");
        }
        $this->descrizioneEvento = trim($descrizioneEvento);
    }

    /**
     * Aggiorna l'immagine dell'evento.
     */
    public function aggiornaImg(string $imgEvento): void {
        $this->imgEvento = trim($imgEvento);
    }


    /**
     * Aggiorna il numero massimo di partecipanti all'evento.
     * Il numero massimo di partecipanti deve essere maggiore di 0.
     */
    public function aggiornaMaxPartecipanti(int $maxPartecipanti): void {
        if ($maxPartecipanti <= 0) {
            throw new InvalidArgumentException("Il numero massimo di partecipanti deve essere maggiore di 0.");
        }
        if (count($this->partecipazioni) > $maxPartecipanti) {
            throw new InvalidArgumentException("Il numero massimo di partecipanti non può essere inferiore al numero di partecipanti attuali.");
        }
        $this->maxPartecipanti = $maxPartecipanti;
    }

    /**
     * Rendi l'evento in corso.
     * L'evento può essere avviato solo se è nello stato "Programmato" e se la data di inizio è passata rispetto alla data attuale.
     */
    public function avviaEvento(): void {
        if ($this->statoEvento !== StatoEvento::Programmato) {
            throw new InvalidArgumentException("L'evento può essere avviato solo se è nello stato 'Programmato'.");
        }
        if ($this->dataInizio > new DateTime()) {
            throw new InvalidArgumentException("L'evento non può essere avviato prima della data di inizio.");
        }
        $this->statoEvento = StatoEvento::InCorso;
    }

    /**
     * Rendi l'evento terminato.
     * L'evento può essere terminato solo se è nello stato "In corso".
     */
    public function terminaEvento(): void {
        if ($this->statoEvento !== StatoEvento::InCorso) {
            throw new InvalidArgumentException("L'evento può essere terminato solo se è nello stato 'In corso'.");
        }
        $this->statoEvento = StatoEvento::Terminato;
    }

    /**
     * Annulla l'evento.
     * L'evento può essere annullato solo se è nello stato "Programmato".
     */
    public function annullaEvento(): void {
        if ($this->statoEvento !== StatoEvento::Programmato) {
            throw new InvalidArgumentException("L'evento può essere annullato solo se è nello stato 'Programmato'.");
        }
        $this->statoEvento = StatoEvento::Annullato;
    }

    /**
     * Riprogramma l'evento e rendi l'evento programmato.
     * L'evento può essere riprogrammato solo se è nello stato "Annullato" e se la data di inizio è una data futura rispetto alla data attuale.
     */
    public function riprogrammaEvento(DateTime $dataInizio): void {
        if ($this->statoEvento !== StatoEvento::Annullato) {
            throw new InvalidArgumentException("L'evento può essere riprogrammato solo se è nello stato 'Annullato'.");
        }
        if ($dataInizio <= new DateTime()) {
            throw new InvalidArgumentException("La data di inizio dell'evento deve essere una data futura.");
        }
        $this->dataInizio = $dataInizio;
        $this->statoEvento = StatoEvento::Programmato;
    }

    /**
     * Aggiunge una partecipazione all'evento.
     * La partecipazione viene aggiunta solo se il numero di partecipanti attuali è inferiore al numero massimo di partecipanti consentiti per l'evento.
     */
    public function addPartecipazione(EPartecipazione $partecipazione): void {
        if (count($this->partecipazioni) >= $this->maxPartecipanti) {
            throw new InvalidArgumentException("Il numero massimo di partecipanti è stato raggiunto.");
        }
        if (!$this->partecipazioni->contains($partecipazione)) {
            $this->partecipazioni->add($partecipazione);
        }
    }

    /**
     * Rimuove una partecipazione dall'evento.
     */
    public function removePartecipazione(EPartecipazione $partecipazione): void {
        $this->partecipazioni->removeElement($partecipazione);
    }

    /**
     * Verifica se ci sono posti disponibili per partecipare all'evento.
     */
    public function hasPostiDisponibili(): bool {
        return $this->statoEvento === StatoEvento::Programmato && count($this->partecipazioni) < $this->maxPartecipanti;
    }

    /**
     * Verfica la validità della data di inizio dell'evento.
     */
    public function verificaDataInizio(): void {
        if ($this->dataInizio < new DateTime()) {
            throw new InvalidArgumentException("La data di inizio dell'evento deve essere successiva alla data attuale.");
        }
    }

    /**
     * Verifica la validità del numero massimo di partecipanti.
     */
    public function verificaMaxPartecipanti(): void {
        if ($this->maxPartecipanti < 1) {
            throw new InvalidArgumentException("Il numero massimo di partecipanti deve essere un numero intero positivo.");
        }
    }

    /**
     * Metodo astratto implementato dalle classi figlie (Serata, Torneo, Challenge)
     */
    abstract public function richiedeQuota(): bool;

}