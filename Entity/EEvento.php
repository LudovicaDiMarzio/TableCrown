<?php
namespace TableCrown\Entity;
use DateTime;
use InvalidArgumentException;
use TableCrown\Entity\Enumerativi\StatoEvento;

abstract class EEvento {
    private ?int $idEvento;
    private string $nomeEvento;
    private string $imgEvento; //da rivedere
    private string $descrizioneEvento;
    private DateTime $dataInizio;
    private int $maxPartecipanti;
    private StatoEvento $statoEvento;
    /** @var EPartecipazione[] */ //notazione per indicare che si tratta di un array di oggetti EPartecipazione, serve per la documentazione e per gli strumenti di sviluppo, non è una dichiarazione di tipo formale
    private array $partecipazioni; //array di EPartecipazione, rappresenta le partecipazioni all'evento

    public function __construct(?int $idEvento, string $nomeEvento, string $imgEvento, string $descrizioneEvento, DateTime $dataInizio, int $maxPartecipanti) {
        $this->idEvento = $idEvento;
        $this->nomeEvento = $nomeEvento;
        $this->imgEvento = $imgEvento;
        $this->descrizioneEvento = $descrizioneEvento;
        $this->dataInizio = $dataInizio;
        $this->maxPartecipanti = $maxPartecipanti;
        $this->statoEvento = StatoEvento::Programmato; //lo stato iniziale dell'evento è sempre "Programmato"
        $this->partecipazioni = [];
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

    public function getPartecipazioni(): array {
        return $this->partecipazioni;
    }

    public function getNumeroPartecipanti(): int {
        return count($this->partecipazioni);
    }

    //Metodi di dominio

    /**
     * Aggiorna il nome dell'evento.
     */
    public function rinominaEvento(string $nomeEvento) {
        if (trim($nomeEvento) === "") {
            throw new InvalidArgumentException("Il nome dell'evento non può essere vuoto.");
        }
        $this->nomeEvento = trim($nomeEvento);
    }

    /**
     * Aggiorna la descrizione dell'evento.
     */
    public function aggiornaDescrizione(string $descrizioneEvento) {
        if (trim($descrizioneEvento) === "") {
            throw new InvalidArgumentException("La descrizione dell'evento non può essere vuota.");
        }
        $this->descrizioneEvento = trim($descrizioneEvento);
    }

    /**
     * Aggiorna l'immagine dell'evento.
     */
    public function aggiornaImg(string $imgEvento) {
        $this->imgEvento = trim($imgEvento);
    }


    /**
     * Aggiorna il numero massimo di partecipanti all'evento.
     * Il numero massimo di partecipanti deve essere maggiore di 0.
     */
    public function aggiornaMaxPartecipanti(int $maxPartecipanti) {
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
    public function avviaEvento() {
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
    public function terminaEvento() {
        if ($this->statoEvento !== StatoEvento::InCorso) {
            throw new InvalidArgumentException("L'evento può essere terminato solo se è nello stato 'In corso'.");
        }
        $this->statoEvento = StatoEvento::Terminato;
    }

    /**
     * Annulla l'evento.
     * L'evento può essere annullato solo se è nello stato "Programmato".
     */
    public function annullaEvento() {
        if ($this->statoEvento !== StatoEvento::Programmato) {
            throw new InvalidArgumentException("L'evento può essere annullato solo se è nello stato 'Programmato'.");
        }
        $this->statoEvento = StatoEvento::Annullato;
    }

    /**
     * Riprogramma l'evento e rendi l'evento programmato.
     * L'evento può essere riprogrammato solo se è nello stato "Annullato" e se la data di inizio è una data futura rispetto alla data attuale.
     */
    public function riprogrammaEvento(DateTime $dataInizio) {
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
    public function addPartecipazione(EPartecipazione $partecipazione) {
        if (count($this->partecipazioni) >= $this->maxPartecipanti) {
            throw new InvalidArgumentException("Non è possibile partecipare, il numero massimo di partecipanti è stato raggiunto.");
        }
        $this->partecipazioni[] = $partecipazione;
    }

    /**
     * Rimuove una partecipazione dall'evento.
     */
    public function removePartecipazione(EPartecipazione $partecipazione) {
        $key = array_search($partecipazione, $this->partecipazioni); //array_search restituisce la chiave dell'elemento trovato nell'array, o false se non trovato
        if ($key !== false) { //se la partecipazione è stata trovata nell'array, procedo alla rimozione
            unset($this->partecipazioni[$key]); //unset rimuove l'elemento dall'array, ma non riorganizza le chiavi, quindi è possibile che si creino "buchi" nell'array, ad esempio se si rimuove l'elemento con chiave 2 da un array con chiavi 0, 1, 2, 3, si otterrà un array con chiavi 0, 1, 3
        }
    }

    /**
     * Verifica se ci sono posti disponibili per partecipare all'evento.
     */
    public function hasPostiDisponibili(): bool {
        return $this->statoEvento === StatoEvento::Programmato && count($this->partecipazioni) < $this->maxPartecipanti;
    }

}