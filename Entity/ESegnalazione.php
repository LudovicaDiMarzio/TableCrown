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

    #[ORM\ID]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $idsegnalazione=null;

    #[ORM\Column(type: "datetime")]
    private DateTime $datasegnalazione;

    #[ORM\Column(type: "string", enumType: StatoSegnalazione:: class)]
    private StatoSegnalazione $statosegnalazione; //può essere "in attesa" o "risolta"

    //TODO: aggiungere annotation doctrine per le relazioni con le altre entity MotivazioneSegnalazione e EUtente
    private MotivazioneSegnalazione $motivazione; 
    private EUtente $utente; //l'utente che ha fatto la segnalazione

    public function __construct(      MotivazioneSegnalazione $motivazione,
        EUtente $utente
    ) {
        $this->datasegnalazione = new DateTime();  //la segnalazione avviene nel momento in cui viene creata la sua istanza
        $this->statosegnalazione = StatoSegnalazione::IN_ATTESA; // inizialmente sempre InAttesa
        $this->motivazione = $motivazione;
        $this->utente = $utente;
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

    public function getMotivazione(): MotivazioneSegnalazione {
        return $this->motivazione;
    }

    public function getUtente(): EUtente {
        return $this->utente;
    }   
}