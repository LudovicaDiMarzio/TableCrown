<?php
namespace TableCrown\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;
use TableCrown\Entity\EEvento;
use TableCrown\Entity\EUtente;
use InvalidArgumentException;

#[ORM\Entity]
#[ORM\Table(name: 'partecipazione')]
class EPartecipazione {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $idPartecipazione = null;

    #[ORM\Column(type: 'datetime')]
    private DateTime $dataIscrizione;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $posizioneInClassifica; //posizione in classifica, se prevista per l'evento, altrimenti null (al momento della partecipazione, la posizione in classifica è sempre null, viene aggiornata solo alla fine dell'evento)

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $punteggioTotale; //punteggio totale ottenuto dal partecipante alla fine della challenge, in caso di altri eventi può essere null (al momento della partecipazione, il punteggio totale è sempre null, viene aggiornato solo alla fine dell'evento)

    #[ORM\ManyToOne(targetEntity: EUtente::class)]
    #[ORM\JoinColumn(nullable: false)]
    private EUtente $utente; //l'utente a cui è riferita la partecipazione

    #[ORM\ManyToOne(targetEntity: EEvento::class, inversedBy: 'partecipazioni')]
    #[ORM\JoinColumn(nullable: false)]
    private EEvento $evento; //l'evento a cui l'utente partecipa

    #[ORM\Column(type: 'boolean')]
    private bool $quotaPagata; //indica se la quota di iscrizione è stata pagata, se prevista per l'evento

    public function __construct(DateTime $dataIscrizione, ?int $posizioneInClassifica = null, ?int $punteggioTotale = null, EUtente $utente, EEvento $evento, bool $quotaPagata = false) {
        $this->dataIscrizione = $dataIscrizione;
        $this->verificaDataIscrizione();
        $this->posizioneInClassifica = $posizioneInClassifica;
        $this->punteggioTotale = $punteggioTotale;
        $this->utente = $utente;
        $this->evento = $evento;
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

    //Metodi di dominio

    /**
    * Aggiorna la posizione in classifica del partecipante.
    */
    public function aggiornaPosizioneInClassifica(?int $posizioneInClassifica): void {
        if ($posizioneInClassifica !== null && $posizioneInClassifica < 1) {
            throw new InvalidArgumentException("La posizione in classifica deve essere un intero positivo o null.");
        }
        $this->posizioneInClassifica = $posizioneInClassifica;
    }

    /**
    * Aggiorna il punteggio totale del partecipante.
    */
    public function aggiornaPunteggioTotale(?int $punteggioTotale): void {
        if ($punteggioTotale !== null && $punteggioTotale < 0) {
            throw new InvalidArgumentException("Il punteggio totale deve essere un intero non negativo o null.");
        }
        $this->punteggioTotale = $punteggioTotale;
    }

    /**
     * Aggiorna lo stato di pagamento della quota di iscrizione
     */
    public function aggiornaPagamento(): void {
        if ($this->evento->richiedeQuota()) {
            $this->quotaPagata = true;
        }
        else {
            throw new InvalidArgumentException("Questo evento non richiede una quota di iscrizione. Impossibile effettuare il pagamento.");
        }
    }

    /**
     * Verifica la validità della data di iscrizione, che non può essere successiva alla data di inizio dell'evento.
     */
    public function verificaDataIscrizione(): void {
        if ($this->dataIscrizione > $this->evento->getDataInizio()) {
            throw new InvalidArgumentException("La data di iscrizione non può essere successiva alla data di inizio dell'evento.");
        }
    }

    
}