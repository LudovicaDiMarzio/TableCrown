<?php
namespace TableCrown\Entity;
use DateTime;
use InvalidArgumentException;
use Override;
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
        parent::__construct($idEvento, $nomeEvento, $imgEvento, $descrizioneEvento, $dataInizio, $maxPartecipanti);
        $this->quotaIscrizione = $quotaIscrizione;
        $this->premio = $premio;
        $this->verificaPremio(); //verifica che il premio sia valido (che abbia lo stato disponibile)
        $this->aggiornaPunteggioPrimoClassificato($punteggioPrimoClassificato); //utilizza il metodo di dominio per validare il punteggio del primo classificato
        $this->aggiornaPunteggioSecondoClassificato($punteggioSecondoClassificato); //utilizza il metodo di dominio per validare il punteggio del secondo classificato
        $this->aggiornaPunteggioTerzoClassificato($punteggioTerzoClassificato); //utilizza il metodo di dominio per validare il punteggio del terzo classificato
        $this->verificaPunteggi(); //verifica i vincoli sui punteggi dei classificati
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

    //Metodi di dominio

    /**
     * Aggiorna il punteggio del primo classificato.
     */
    public function aggiornaPunteggioPrimoClassificato(int $punteggioPrimoClassificato): void {
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

    /**
     * Aggiorna il punteggio del secondo classificato.
     */
    public function aggiornaPunteggioSecondoClassificato(int $punteggioSecondoClassificato): void {
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

    /**
     * Aggiorna il punteggio del terzo classificato.
     */
    public function aggiornaPunteggioTerzoClassificato(int $punteggioTerzoClassificato): void {
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

    /**
     * Verifica i vincoli sui punteggi dei classificati.
     */
    public function verificaPunteggi(): void {
        if ($this->punteggioPrimoClassificato <= 0 || $this->punteggioSecondoClassificato < 0 || $this->punteggioTerzoClassificato < 0) {
            throw new InvalidArgumentException("I punteggi del primo, del secondo e del terzo classificato devono essere numeri interi positivi.");
        }
        if (!($this->punteggioPrimoClassificato > $this->punteggioSecondoClassificato && $this->punteggioSecondoClassificato > $this->punteggioTerzoClassificato)) {
            throw new InvalidArgumentException("Il punteggio del primo classificato deve essere maggiore di quello del secondo classificato e il punteggio del secondo classificato deve essere maggiore di quello del terzo classificato.");
        }
    }

    /**
     * Verifica che il premio sia valido (che abbia lo stato disponibile).
     */
    public function verificaPremio(): void {
        if (!$this->premio->isDisponibile()) {
            throw new InvalidArgumentException("Il premio non è disponibile.");
        }
    }

    /**
     * Implementazione del metodo astratto richiedeQuota() di EEvento
     */
    #[Override]
    public function richiedeQuota(): bool
    {
        return true;
    }

}