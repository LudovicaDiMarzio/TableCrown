<?php
namespace TableCrown\Entity;
/*namespace è un modo per includere classi, funzioni e costanti in un contesto specifico, evitando conflitti di nomi con altre parti del codice.
in questo caso, stiamo definendo la classe Utente all'interno del namespace TableCrown\Entity, il che significa che per accedere a questa classe 
da un'altra parte del codice, dovremo fare riferimento a TableCrown\Entity\Utente o utilizzare una dichiarazione use per importarla (use TableCrown\Entity\Utente;).
non è quindi necessario usare il require_once per includere la classe EPersona, poiché è già definita nello stesso namespace e può essere utilizzata direttamente.
*/
use DateTime;
use TableCrown\Entity\Enumerativi\StatoSegnalazione;
use Doctrine\ORM\Mapping as ORM;
//l'enumerativo StatoSegnalazione che utilizziamo è definito in una cartella separata, pertanto dobbiamo importarlo con la dichiarazione use,
// altrimenti dovremmo fare riferimento a esso con il suo namespace completo ogni volta che lo utilizziamo (TableCrown\Entity\Enumerativi\StatoSegnalazione).

#[ORM\Entity]
#[ORM\Table(name: "segnalazione")]

class ESegnalazione{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $idsegnalazione=null;

    #[ORM\Column(type: "datetime")]
    private DateTime $datasegnalazione;

    #[ORM\Column(type: "string", enumType: StatoSegnalazione::class)]
    private StatoSegnalazione $statosegnalazione; //può essere "in attesa" o "risolta"

    //segnalazione è l'owning side sia per motivazione che per utente, quindi contiene la fk
    //una segnalazione può avere una sola motivazione, ma una motivazione può essere associata a più segnalazioni (relazione molti a uno)
    //non è necessario mostrare tutte le segnalazioni legate ad una motivazione, quindi lasceremo la relazione unidirezionale
    #[ORM\ManyToOne(targetEntity: EMotivazione::class)]
    #[ORM\JoinColumn(name: "motivazione_id", referencedColumnName: "idmotivazione", nullable: false)]
    private EMotivazione $motivazione; 

    //una segnalazione è relativa ad un utente, ma un utente può ricevere più segnalazioni (relazione molti a uno)
    //può essere utile vedere tutte le segnalazioni legate ad un utente, quindi rendiamo la relazione bidirezionale inserendo i riferimenti alle segnalazioni con una collection di segnalazioni in utente
    #[ORM\ManyToOne(targetEntity: EUtente::class, inversedBy: "segnalazioni")]
    #[ORM\JoinColumn(name: "utente_id", referencedColumnName: "idpersona", nullable: false)]
    private EUtente $utente; //l'utente che ha subito la segnalazione

    //una segnalazione è relativa ad una recensione, ma una recensione può ricevere più segnalazioni (relazione molti a uno)
    //può essere utile vedere tutte le segnalazioni legate ad una recensione, quindi rendiamo la relazione bidirezionale inserendo i riferimenti alle segnalazioni con una collection di segnalazioni in recensione
    #[ORM\ManyToOne(targetEntity: ERecensione::class, inversedBy: "segnalazioni")]
    #[ORM\JoinColumn(name: "recensione_id", referencedColumnName: "idRecensione", nullable: false)]
    private ERecensione $recensione; //la recensione che ha subito la segnalazione

    #[ORM\ManyToOne(targetEntity: EUtente::class, inversedBy: "segnalazioni")]
    #[ORM\JoinColumn(name: "utente_segnalante_id", referencedColumnName: "idpersona", nullable: false)]
    private EUtente $utenteSegnalante; //l'utente che ha segnalato (serve per tracciabilità e per prevenire spam di segnalazioni da parte di malintenzionati)

    public function __construct(EMotivazione $motivazione, ERecensione $recensione, EUtente $utenteSegnalante) {
        $this->datasegnalazione = new DateTime();  //la segnalazione avviene nel momento in cui viene creata la sua istanza
        $this->statosegnalazione = StatoSegnalazione::IN_ATTESA; // inizialmente sempre InAttesa
        $this->motivazione = $motivazione;
        $this->recensione = $recensione;
        $this->utente = $recensione->getUtente();
        $this->utenteSegnalante = $utenteSegnalante;
        //manteniamo la coerenza nella relazione bidirezionale, aggiungendo la segnalazione alla collection segnalazione di EUtente, altrimenti la collection sarebbe aggiornata solo dopo il flush
        //il this come parametro sta a rappresentare che stiamo passando esattamente questa istanza della segnalazione
        $recensione->riceviSegnalazione($this);
    }

    //metodi di dominio
    public function risolvi(): void
    {
        if ($this->statosegnalazione === StatoSegnalazione::RISOLTA) {
            throw new \DomainException("La segnalazione è già risolta.");
        }
        $this->statosegnalazione = StatoSegnalazione::RISOLTA;
    }
       

    //GET methods
    public function getIdSegnalazione(): ?int {
        return $this->idsegnalazione;
    }

    public function getDataSegnalazione(): DateTime {
        return $this->datasegnalazione;
    }

    public function getStatoSegnalazione(): StatoSegnalazione {
        return $this->statosegnalazione;
    }   

    public function getMotivazione(): EMotivazione {
        return $this->motivazione;
    }

    public function getRecensione(): ERecensione {
        return $this->recensione;
    }   

    public function getUtente(): EUtente {
        return $this->utente;
    }

    public function getUtenteSegnalante(): EUtente {
        return $this->utenteSegnalante;
    }
}