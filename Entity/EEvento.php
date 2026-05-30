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

    public function __construct(?int $idEvento, string $nomeEvento, string $imgEvento, string $descrizioneEvento, DateTime $dataInizio, int $maxPartecipanti, StatoEvento $statoEvento) {
        $this->idEvento = $idEvento;
        $this->nomeEvento = $nomeEvento;
        $this->imgEvento = $imgEvento;
        $this->descrizioneEvento = $descrizioneEvento;
        $this->dataInizio = $dataInizio;
        $this->maxPartecipanti = $maxPartecipanti;
        $this->statoEvento = $statoEvento;
        $this->partecipazioni = [];
    }

    //SET methods
    public function setNomeEvento(string $nomeEvento) {
        $this->nomeEvento = trim($nomeEvento);
    }

    public function setImgEvento(string $imgEvento) {
        $this->imgEvento = trim($imgEvento);
    }

    public function setDescrizioneEvento(string $descrizioneEvento) {
        $this->descrizioneEvento = trim($descrizioneEvento);
    }

    public function setDataInizio(DateTime $dataInizio) {
        $this->dataInizio = $dataInizio;
    }

    public function setMaxPartecipanti(int $maxPartecipanti) {
        $this->maxPartecipanti = $maxPartecipanti;
    }

    public function setStatoEvento(StatoEvento $statoEvento) {
        $this->statoEvento = $statoEvento;
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

    //metodo per aggiungere una partecipazione all'evento
    public function addPartecipazione(EPartecipazione $partecipazione) {
        $this->partecipazioni[] = $partecipazione;
    }
}