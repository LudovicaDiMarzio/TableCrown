<?php
namespace TableCrown\Entity;
use DateTime;
use TableCrown\Entity\EEvento;
use TableCrown\Entity\EUtente;

class EPartecipazione {
    private ?int $idPartecipazione;
    private DateTime $dataIscrizione;
    private ?int $posizioneInClassifica; //posizione in classifica, se prevista per l'evento, altrimenti null
    private ?int $punteggioTotale; //punteggio totale ottenuto dal partecipante alla fine della challenge, in caso di altri eventi può essere null
    private EUtente $utente; //l'utente a cui è riferita la partecipazione
    private EEvento $evento; //l'evento a cui l'utente partecipa
    private bool $quotaPagata; //indica se la quota di iscrizione è stata pagata, se prevista per l'evento

    public function __construct(?int $idPartecipazione, DateTime $dataIscrizione, ?int $posizioneInClassifica, ?int $punteggioTotale, EUtente $utente, EEvento $evento, bool $quotaPagata) {
        $this->idPartecipazione = $idPartecipazione;
        $this->dataIscrizione = $dataIscrizione;
        $this->posizioneInClassifica = $posizioneInClassifica;
        $this->punteggioTotale = $punteggioTotale;
        $this->utente = $utente;
        $this->evento = $evento;
        $this->quotaPagata = $quotaPagata;
    }

    //SET methods
    public function setDataIscrizione(DateTime $dataIscrizione) {
        $this->dataIscrizione = $dataIscrizione;
    }

    public function setPosizioneInClassifica(?int $posizioneInClassifica) {
        $this->posizioneInClassifica = $posizioneInClassifica;
    }

    public function setPunteggioTotale(?int $punteggioTotale) {
        $this->punteggioTotale = $punteggioTotale;
    }

    public function setUtente(EUtente $utente) {
        $this->utente = $utente;
    }

    public function setEvento(EEvento $evento) {
        $this->evento = $evento;
    }

    public function setQuotaPagata(bool $quotaPagata) {
        $this->quotaPagata = $quotaPagata;
    }

    //GET methods
    public function getIdPartecipazione(): ?int {
        return $this->idPartecipazione;
    }

    public function getDataIscrizione(): DateTime {
        return $this->dataIscrizione;
    }

    public function getPosizioneInClassifica(): ?int {
        return $this->posizioneInClassifica;
    }

    public function getPunteggioTotale(): ?int {
        return $this->punteggioTotale;
    }

    public function getUtente(): EUtente {
        return $this->utente;
    }

    public function getEvento(): EEvento {
        return $this->evento;
    }

    public function getQuotaPagata(): bool {
        return $this->quotaPagata;
    }
}