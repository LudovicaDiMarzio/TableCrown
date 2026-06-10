<?php
namespace TableCrown\Entity;
use DateTime;
use TableCrown\Entity\Enumerativi\StatoEvento;
use TableCrown\Entity\EPrezzo;
use TableCrown\Entity\EProdotto;
use InvalidArgumentException;
use Override;

class ETorneo extends EEvento {
    // Proprietà specifiche per il torneo
    private EPrezzo $quotaIscrizione; //quota di iscrizione al torneo
    private EProdotto $premio; //premio del torneo
    private EProdotto $gioco; //gioco da tavolo su cui si svolge il torneo
    

    public function __construct(?int $idEvento, string $nomeEvento, string $imgEvento, string $descrizioneEvento, DateTime $dataInizio, int $maxPartecipanti, StatoEvento $statoEvento, EPrezzo $quotaIscrizione, EProdotto $premio, EProdotto $gioco) {
        parent::__construct($idEvento, $nomeEvento, $imgEvento, $descrizioneEvento, $dataInizio, $maxPartecipanti);
        $this->quotaIscrizione = $quotaIscrizione;
        $this->premio = $premio;
        $this->gioco = $gioco;
    }

    // //SET methods
    // public function setQuotaIscrizione(EPrezzo $quotaIscrizione) {
    //     $this->quotaIscrizione = $quotaIscrizione;
    // }

    // public function setPremio(EProdotto $premio) {
    //     $this->premio = $premio;
    // }

    // public function setGioco(EProdotto $gioco) {
    //     $this->gioco = $gioco;
    // }

    //GET methods
    public function getQuotaIscrizione(): EPrezzo {
        return $this->quotaIscrizione;
    }

    public function getPremio(): EProdotto {
        return $this->premio;
    }

    public function getGioco(): EProdotto {
        return $this->gioco;
    }

    //Metodi di dominio

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