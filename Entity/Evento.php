<?php
abstract class Evento {
    private int $idEvento;
    private string $nomeEvento;
    private string $imgEvento; //da rivedere
    private string $descrizioneEvento;
    private DateTime $dataInizio;
    private int $maxPartecipanti;
    private string $statoEvento;

    public function __construct(int $idEvento, string $nomeEvento, string $imgEvento, string $descrizioneEvento, DateTime $dataInizio, int $maxPartecipanti, string $statoEvento) {
        $this->idEvento = $idEvento;
        $this->nomeEvento = $nomeEvento;
        $this->imgEvento = $imgEvento;
        $this->descrizioneEvento = $descrizioneEvento;
        $this->dataInizio = $dataInizio;
        $this->maxPartecipanti = $maxPartecipanti;
        $this->statoEvento = $statoEvento;
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

    public function setStatoEvento(string $statoEvento) {
        // Definisco una lista di stati validi (Whitelist)
        $statiValidi = ['programmato', 'in corso', 'completato', 'annullato'];
        if (in_array(trim($statoEvento), $statiValidi)) {
            $this->statoEvento = trim($statoEvento);
        } else {
            throw new InvalidArgumentException("Stato evento non valido. Valori accettati: " . implode(", ", $statiValidi));
        }
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

    public function getStatoEvento(): string {
        return $this->statoEvento;
    }


}