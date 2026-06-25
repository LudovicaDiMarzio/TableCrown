<?php
namespace TableCrown\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;
use TableCrown\Entity\Enumerativi\StatoEvento;
use TableCrown\Entity\EPrezzo;
use TableCrown\Entity\EProdotto;
use InvalidArgumentException;
use Override;

#[ORM\Entity]
#[ORM\Table(name: "torneo")]
class ETorneo extends EEvento {
    // Proprietà specifiche per il torneo
    #[ORM\OneToOne(targetEntity: EPrezzo::class, cascade: ["persist", "remove"])]
    #[ORM\JoinColumn(name: "prezzo_id", referencedColumnName: "idPrezzo", nullable: true)]
    private EPrezzo $quotaIscrizione; //quota di iscrizione al torneo

    #[ORM\ManyToOne(targetEntity: EProdotto::class)]
    #[ORM\JoinColumn(name: "premio_id", referencedColumnName: "idProdotto", nullable: true)]
    private EProdotto $premio; //premio del torneo

    #[ORM\ManyToOne(targetEntity: EProdotto::class)]
    #[ORM\JoinColumn(name: "giocoTorneoid", referencedColumnName: "idProdotto", nullable: false)]
    private EProdotto $gioco; //gioco da tavolo su cui si svolge il torneo
    

    public function __construct(string $nomeEvento, string $imgEvento, string $descrizioneEvento, DateTime $dataInizio, int $maxPartecipanti, EPrezzo $quotaIscrizione, EProdotto $premio, EProdotto $gioco) {
        parent::__construct($nomeEvento, $imgEvento, $descrizioneEvento, $dataInizio, $maxPartecipanti);
        $this->quotaIscrizione = $quotaIscrizione;
        $this->premio = $premio;
        $this->verificaPremio(); //verifica che il premio sia valido (che abbia lo stato disponibile)
        $this->gioco = $gioco;
    }

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