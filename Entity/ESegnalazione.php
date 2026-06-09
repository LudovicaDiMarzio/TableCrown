<?php
namespace TableCrown\Entity;
/*namespace è un modo per includere classi, funzioni e costanti in un contesto specifico, evitando conflitti di nomi con altre parti del codice.
in questo caso, stiamo definendo la classe Utente all'interno del namespace TableCrown\Entity, il che significa che per accedere a questa classe 
da un'altra parte del codice, dovremo fare riferimento a TableCrown\Entity\Utente o utilizzare una dichiarazione use per importarla (use TableCrown\Entity\Utente;).
non è quindi necessario usare il require_once per includere la classe EPersona, poiché è già definita nello stesso namespace e può essere utilizzata direttamente.
*/
use DateTime;
use TableCrown\Entity\Enumerativi\StatoSegnalazione;
//l'enumerativo StatoSegnalazione che utilizziamo è definito in una cartella separata, pertanto dobbiamo importarlo con la dichiarazione use,
// altrimenti dovremmo fare riferimento a esso con il suo namespace completo ogni volta che lo utilizziamo (TableCrown\Entity\Enumerativi\StatoSegnalazione).
class ESegnalazione{
    private ?int $idsegnalazione=null;
    private DateTime $datasegnalazione;
    private StatoSegnalazione $statosegnalazione; //può essere "in attesa" o "risolta"
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

    public function getUtente(): Utente {
        return $this->utente;
    }   
}