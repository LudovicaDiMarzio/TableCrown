<?php
namespace TableCrown\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use DateTime;
use InvalidArgumentException;
use Override;
use TableCrown\Entity\Enumerativi\StatoEvento;
use TableCrown\Entity\EPrezzo;
use TableCrown\Entity\EProdotto;
use TableCrown\Entity\ETorneo;

#[ORM\Entity]
#[ORM\Table(name: "challenge")]
class EChallenge extends EEvento {
    // Proprietà specifiche per la challenge
    #[ORM\OneToMany(targetEntity: ETorneo::class, mappedBy: "challenge", cascade: ["persist"])] //Non mettiamo remove, perché altrimenti in caso di cancellazione di una challenge verrebero eliminati anche tutti i relativi tornei.
    private Collection $tornei; //tornei della challenge

    #[ORM\OneToOne(targetEntity: EPrezzo::class, cascade: ["persist", "remove"])]
    #[ORM\JoinColumn(name: "quota_iscrizione_id", referencedColumnName: "idPrezzo")]
    private EPrezzo $quotaIscrizione; //costo di ingresso alla challenge

    #[ORM\ManyToOne(targetEntity: EProdotto::class)]
    #[ORM\JoinColumn(name: "premio_id", referencedColumnName: "idProdotto", nullable: true)]
    private EProdotto $premio; //premio della challenge

    #[ORM\Column(type: "integer")]
    private int $punteggioPrimoClassificato; //punteggio del primo classificato

    #[ORM\Column(type: "integer")]
    private int $punteggioSecondoClassificato; //punteggio del secondo classificato

    #[ORM\Column(type: "integer")]
    private int $punteggioTerzoClassificato; //punteggio del terzo classificato

    public function __construct(string $nomeEvento, string $imgEvento, string $descrizioneEvento, DateTime $dataInizio, int $maxPartecipanti, EPrezzo $quotaIscrizione, EProdotto $premio, int $punteggioPrimoClassificato, int $punteggioSecondoClassificato, int $punteggioTerzoClassificato, array $tornei) {
        parent::__construct($nomeEvento, $imgEvento, $descrizioneEvento, $dataInizio, $maxPartecipanti);
        $this->tornei = new ArrayCollection(); //inizializzo la collection vuota
        $this->verificaTornei($tornei); //verifica che il numero di tornei sia valido
        //Se la verifica non lancia eccezioni, popoliamo la collection in sicurezza
        foreach ($tornei as $torneo) {
            if ($torneo instanceof ETorneo) {
                $this->tornei->add($torneo);
                $torneo->impostaChallenge($this);
            }
        }
        $this->quotaIscrizione = $quotaIscrizione;
        $this->premio = $premio;
        $this->verificaPremio(); //verifica che il premio sia valido (che abbia lo stato disponibile)
        $this->punteggioPrimoClassificato = $punteggioPrimoClassificato;
        $this->punteggioSecondoClassificato = $punteggioSecondoClassificato;
        $this->punteggioTerzoClassificato = $punteggioTerzoClassificato;
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
    
    public function getTornei(): Collection {
        return $this->tornei;
    }

    //Metodi di dominio

    /**
     * Aggiunge un singolo torneo alla challenge 
     */
    public function aggiungiTorneo(ETorneo $torneo): void {
        if ($this-tornei->count() >=7) {
            throw new InvalidArgumentException("Impossibile aggiungere il torneo. Una challenge non può avere più di 7 tornei.");
        }

        if (!$this->tornei->contains($torneo)) {
            $this->tornei->add($torneo);
            $torneo->impostaChallenge($this);
        }
    }

    /**
     * Rimuove un singolo torneo dalla challenge
     */
    public function rimuoviTorneo(ETorneo $torneo): void {
        if ($this->tornei->count() <= 3) {
            throw new InvalidArgumentException("Impossibile rimuovere il torneo. Una challenge deve avere almeno 3 tornei.");
        }

        if ($this->tornei->contains($torneo)) {
            $this->tornei->removeElement($torneo);
            if ($torneo->getChallenge() === $this) {
                $torneo->impostaChallenge(null);
            }
        }
    }

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
    protected function verificaPunteggi(): void {
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
    protected function verificaPremio(): void {
        if (!$this->premio->isDisponibile()) {
            throw new InvalidArgumentException("Il premio non è disponibile.");
        }
    }

    /**
     * Verifica che il numero di tornei sia valido (minimo 3 e massimo 7).
     */
    protected function verificaTornei(array $tornei): void {
        $conteggio = count($tornei);
        if ($conteggio <= 2 || $conteggio >= 8) {
            throw new InvalidArgumentException("Il numero di tornei deve essere compreso tra 3 e 7.");
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