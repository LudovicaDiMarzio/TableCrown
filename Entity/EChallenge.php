<?php
namespace TableCrown\Entity;
use DateTime;
use InvalidArgumentException;
use TableCrown\Entity\Enumerativi\StatoEvento;
use TableCrown\Entity\EPrezzo;
use TableCrown\Entity\EProdotto;

class EChallenge extends EEvento {
    // Proprietà specifiche per la challenge
    private EPrezzo $quotaIscrizione; //costo di ingresso alla challenge
    private EProdotto $premio; //premio della challenge
    private int $punteggioPrimoClassificato; //punteggio del primo classificato
    private int $punteggioSecondoClassificato; //punteggio del secondo classificato
    private int $punteggioTerzoClassificato; //punteggio del terzo classificato

    public function __construct(?int $idEvento, string $nomeEvento, string $imgEvento, string $descrizioneEvento, DateTime $dataInizio, int $maxPartecipanti, StatoEvento $statoEvento, EPrezzo $quotaIscrizione, EProdotto $premio, int $punteggioPrimoClassificato, int $punteggioSecondoClassificato, int $punteggioTerzoClassificato) {
        parent::__construct($idEvento, $nomeEvento, $imgEvento, $descrizioneEvento, $dataInizio, $maxPartecipanti, $statoEvento);
        $this->quotaIscrizione = $quotaIscrizione;
        $this->premio = $premio;
        //validazione dei punteggi
        if ($punteggioPrimoClassificato > 0 && $punteggioSecondoClassificato >= 0 && $punteggioTerzoClassificato >= 0) {
            if ($punteggioPrimoClassificato > $punteggioSecondoClassificato && $punteggioSecondoClassificato > $punteggioTerzoClassificato) {
                $this->punteggioPrimoClassificato = $punteggioPrimoClassificato;
                $this->punteggioSecondoClassificato = $punteggioSecondoClassificato;
                $this->punteggioTerzoClassificato = $punteggioTerzoClassificato;
            } else {
                throw new InvalidArgumentException("Il punteggio del primo classificato deve essere maggiore di quello del secondo classificato e il punteggio del secondo classificato deve essere maggiore di quello del terzo classificato.");
            }
        } else {
            throw new InvalidArgumentException("I punteggi del primo, del secondo e del terzo classificato devono essere numeri interi positivi.");
        }
    }

    //SET methods
    public function setQuotaIscrizione(EPrezzo $quotaIscrizione) {
        $this->quotaIscrizione = $quotaIscrizione;
    }

    public function setPremio(EProdotto $premio) {
        $this->premio = $premio;
    }

    public function setPunteggioPrimoClassificato(int $punteggioPrimoClassificato) {
        if ($punteggioPrimoClassificato > 0) {
            if ($punteggioPrimoClassificato > $this->punteggioSecondoClassificato && $this->punteggioSecondoClassificato > $this->punteggioTerzoClassificato) {
                $this->punteggioPrimoClassificato = $punteggioPrimoClassificato;
            } else {
                throw new InvalidArgumentException("Il punteggio del primo classificato deve essere maggiore di quello del secondo classificato e il punteggio del secondo classificato deve essere maggiore di quello del terzo classificato.");
            }
        } else {
            throw new InvalidArgumentException("Il punteggio del primo classificato deve essere un numero intero positivo.");
        }
    }

    public function setPunteggioSecondoClassificato(int $punteggioSecondoClassificato) {
        if ($punteggioSecondoClassificato >= 0) {
            if ($this->punteggioPrimoClassificato > $punteggioSecondoClassificato && $punteggioSecondoClassificato > $this->punteggioTerzoClassificato) {
                $this->punteggioSecondoClassificato = $punteggioSecondoClassificato;
            } else {
                throw new InvalidArgumentException("Il punteggio del secondo classificato deve essere minore di quello del primo classificato e maggiore di quello del terzo classificato.");
            }
        } else {
            throw new InvalidArgumentException("Il punteggio del secondo classificato deve essere un numero intero non negativo.");
        }
    }

    public function setPunteggioTerzoClassificato(int $punteggioTerzoClassificato) {
        if ($punteggioTerzoClassificato >= 0) {
            if ($this->punteggioSecondoClassificato > $punteggioTerzoClassificato) {
                $this->punteggioTerzoClassificato = $punteggioTerzoClassificato;
            } else {
                throw new InvalidArgumentException("Il punteggio del terzo classificato deve essere minore di quello del secondo classificato.");
            }
        } else {
            throw new InvalidArgumentException("Il punteggio del terzo classificato deve essere un numero intero non negativo.");
        }
    }

    //GET methods
    public function getQuotaIscrizione(): EPrezzo {
        return $this->quotaIscrizione;
    }

    public function getPremio(): EProdotto {
        return $this->premio;
    }

    public function getPunteggioPrimoClassificato(): int {
        return $this->punteggioPrimoClassificato;
    }

    public function getPunteggioSecondoClassificato(): int {
        return $this->punteggioSecondoClassificato;
    }

    public function getPunteggioTerzoClassificato(): int {
        return $this->punteggioTerzoClassificato;
    }
}