<?php
namespace TableCrown\Entity;
/*namespace è un modo per includere classi, funzioni e costanti in un contesto specifico, evitando conflitti di nomi con altre parti del codice.
in questo caso, stiamo definendo la classe Utente all'interno del namespace TableCrown\Entity, il che significa che per accedere a questa classe 
da un'altra parte del codice, dovremo fare riferimento a TableCrown\Entity\Utente o utilizzare una dichiarazione use per importarla (use TableCrown\Entity\Utente;).
non è quindi necessario usare il require_once per includere la classe EPersona, poiché è già definita nello stesso namespace e può essere utilizzata direttamente.
*/
use DateTime;
use TableCrown\Entity\Enumerativi\PlayerLevel; //importiamo l'enumerativo PlayerLevel che abbiamo definito in una cartella separata, altrimenti dovremmo fare riferimento a esso con il suo namespace completo ogni volta che lo utilizziamo (TableCrown\Entity\Enumerativi\PlayerLevel).
use TableCrown\Entity\Enumerativi\StatoUtente; //importiamo l'enumerativo StatoUtente che abbiamo definito in una cartella separata, altrimenti dovremmo fare riferimento a esso con il suo namespace completo ogni volta che lo utilizziamo (TableCrown\Entity\Enumerativi\StatoUtente).
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "utente")]

class EUtente extends EPersona {

    #[ORM\column(type: "integer")]
    private int $eta;

    #[ORM\column(type: "string", enumType: StatoUtente:: class)] //enumType: StatoUtente::class restituisce "TableCrown\Entity\Enumerativi\StatoUtente" per sapere quale enum usare per la conversione automatica
    private StatoUtente $stato;

    #[ORM\column(type: "datetime", nullable: true)]
    private ?DateTime $dataFineSospensione;

    #[ORM\column(type: "string", enumType: PlayerLevel:: class)]
    private PlayerLevel $PlayerLevel;
   

    public function __construct(string $nomeuser, mixed $imgprofilouser, string $emailuser, string $passworduser, int $eta, PlayerLevel $PlayerLevel) {
        //invoca il costruttore della classe padre (EPersona) per inizializzare le proprietà comuni a tutte le persone, e poi inizializziamo le proprietà specifiche dell'utente (EUtente).
        parent::__construct($nomeuser, $imgprofilouser, $emailuser, $passworduser);
       
        //Gestiamo i dati specifici dell'utente
        $this->impostaEta($eta); 
        $this->stato = StatoUtente::ATTIVO; //un utente appena creato è attivo di default 
        $this->dataFineSospensione = null;
        $this->PlayerLevel = $PlayerLevel;
    }

    //Metodi di dominio
        // Invece di setStato() generico, metodi che esprimono un'azione precisa
    public function sospendi(DateTime $dataFine): void
    {
        if ($this->stato === StatoUtente::BANNATO) {
            throw new \DomainException("Un utente bannato non può essere sospeso.");
        }
        if ($dataFine <= new DateTime()) { 
            throw new \InvalidArgumentException("La data di fine sospensione deve essere nel futuro.");
        }
        $this->stato = StatoUtente::SOSPESO;
        $this->dataFineSospensione = $dataFine;
    }

    public function banna(): void
    {
        if ($this->stato === StatoUtente::BANNATO) {
            throw new \DomainException("L'utente è già bannato.");
        }
        $this->stato = StatoUtente::BANNATO;
        $this->dataFineSospensione = null;  // non serve più
    }

    public function riattiva(): void
    {
        if ($this->stato === StatoUtente::ATTIVO) {
            throw new \DomainException("L'utente è già attivo.");
        }
        $this->stato = StatoUtente::ATTIVO;
        $this->dataFineSospensione = null;
    }

    public function aggiornaLivello(PlayerLevel $nuovoLivello): void
    {
        $this->PlayerLevel = $nuovoLivello;
    }

    // per modificare un'età già impostata
    public function aggiornaEta(int $nuovaEta): void
    {
        $this->impostaEta($nuovaEta);
    }

    // per validare l'età quando viene impostata o aggiornata, non èuò essere negativa
    private function impostaEta(int $eta): void
    {
        if ($eta < 0) {
            throw new \InvalidArgumentException("L'età non può essere negativa.");
        }
        $this->eta = $eta;
    }
   

    //GET methods
 

    public function getEta() {
        return $this->eta; 
    }

    public function getStato() {
        return $this->stato;
    }

    public function getDataFineSospensione() {
        return $this->dataFineSospensione;
    }

    public function getPlayerLevel() {
        return $this->PlayerLevel;
    }
}