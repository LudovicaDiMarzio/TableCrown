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

//Per creare relazione bidirezionale
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: "utente")]

class EUtente extends EPersona {

    #[ORM\Column(type: "datetime")]
    private DateTime $dataNascita;

    #[ORM\Column(type: "string", enumType: StatoUtente::class)] //enumType: StatoUtente::class restituisce "TableCrown\Entity\Enumerativi\StatoUtente" per sapere quale enum usare per la conversione automatica
    private StatoUtente $stato;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?DateTime $dataFineSospensione;

    #[ORM\Column(type: "string", enumType: PlayerLevel::class)]
    private PlayerLevel $PlayerLevel;

    //crea la relazione bidirezionale con ESegnalazione, questo è una lista di segnalazioni legate all'utente esplicitato nella classe ESegnalazione
    #[ORM\OneToMany(targetEntity: ESegnalazione::class, mappedBy: "utente")]
    private Collection $segnalazioni;

    //crea la relazione bidirezionale con EProvvedimento, questo è una lista di provvedimenti legati all'utente esplicitato nella classe EProvvedimento
    #[ORM\OneToMany(targetEntity: EProvvedimento::class, mappedBy: "utentesanzionato")]
    private Collection $provvedimenti;

    #[ORM\OneToMany(targetEntity: EPartecipazione::class, mappedBy: "utente")]
    private Collection $partecipazioni; //la lista di tutte le partecipazioni effettuate dall'utente

    #[ORM\OneToMany(targetEntity: ERecensione::class, mappedBy: "utente")]
    private Collection $recensioni;

    #[ORM\OneToMany(targetEntity: EOrdine::class, mappedBy: "utente")]
    private Collection $ordini;

    #[ORM\OneToMany(targetEntity: EIndirizzo::class, mappedBy: "utente")]
    private Collection $indirizzi; //elenco di tutti gli indirizzi associati all'utente

    #[ORM\Column(type:"string",length:64,nullable:true)]
    private?string$rememberToken=null;
        
   

    public function __construct(string $nomeuser, string $emailuser, string $passworduser, DateTime $dataNascita, PlayerLevel $PlayerLevel= PlayerLevel::PRINCIPIANTE, mixed $imgprofilouser=null) {
        //invoca il costruttore della classe padre (EPersona) per inizializzare le proprietà comuni a tutte le persone, e poi inizializziamo le proprietà specifiche dell'utente (EUtente).
        parent::__construct($nomeuser, $emailuser, $passworduser, $imgprofilouser);
       
        //Gestiamo i dati specifici dell'utente
        $this->impostaDataNascita($dataNascita); 
        $this->stato = StatoUtente::ATTIVO; //un utente appena creato è attivo di default 
        $this->dataFineSospensione = null;
        $this->PlayerLevel = $PlayerLevel;
        $this->segnalazioni = new ArrayCollection(); //inizializziamo la collezione di segnalazioni come un ArrayCollection vuoto
        $this->provvedimenti = new ArrayCollection(); //inizializziamo la collezione di provvedimenti come un ArrayCollection vuoto
        $this->partecipazioni = new ArrayCollection(); //inizializziamo la collezione di partecipazioni come un ArrayCollection vuoto
        $this->recensioni = new ArrayCollection(); //inizializziamo la collezione di recensioni come un ArrayCollection vuoto
        $this->ordini = new ArrayCollection(); //inizializziamo la collezione di ordini come un ArrayCollection vuoto
        $this->indirizzi = new ArrayCollection(); //inizializziamo la collezione di indirizzi come un ArrayCollection vuoto
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

    public function aggiornaDataNascita(DateTime $nuovaDataNascita): void
    {
        $this->impostaDataNascita($nuovaDataNascita);
    }

    // per validare l'età quando viene impostata o aggiornata
    private function impostaDataNascita(DateTime $dataNascita): void
    {
        if ($dataNascita > new DateTime()) {
            throw new \InvalidArgumentException("La data di nascita non può essere nel futuro.");
        }

        $eta = $this->calcolaEta($dataNascita);

        if ($eta < 18) {
            throw new \InvalidArgumentException("Devi avere almeno 18 anni per registrarti.");
        }

        $this->dataNascita = $dataNascita;
    }

    private function calcolaEta(DateTime $dataNascita): int {
        $oggi = new DateTime();
        return $oggi->diff($dataNascita)->y;
    }
   

    //Aggiunge un nuovo provvedimento allo storico dell'utente in RAM
    public function riceviProvvedimento(EProvvedimento $nuovoProvvedimento): void {
        
        // Controllo di sicurezza: se il provvedimento non è già nella lista, lo aggiungiamo
        if (!$this->provvedimenti->contains($nuovoProvvedimento)) {
            $this->provvedimenti->add($nuovoProvvedimento);
        }
    }

    //Aggiunge una nuova segnalazione allo storico di quelle ricevute dall'utente.
    public function riceviSegnalazione(ESegnalazione $nuovaSegnalazione): void {
        
        // Verifica che questa specifica segnalazione non sia già stata inserita nella lista
        if (!$this->segnalazioni->contains($nuovaSegnalazione)) {
            $this->segnalazioni->add($nuovaSegnalazione);
        }
    }

    public function riceviRecensione(ERecensione $recensione): void
    {
        if (!$this->recensioni->contains($recensione)) {
            $this->recensioni->add($recensione);
        }
    }

    public function riceviOrdine(EOrdine $ordine): void
    {
        if (!$this->ordini->contains($ordine)) {
            $this->ordini->add($ordine);
        }
    }

    public function riceviPartecipazione(EPartecipazione $partecipazione): void
    {
        if (!$this->partecipazioni->contains($partecipazione)) {
            $this->partecipazioni->add($partecipazione);
        }
    }

    public function riceviIndirizzo(EIndirizzo $indirizzo): void {
        if (!$this->indirizzi->contains($indirizzo)) {
            $this->indirizzi->add($indirizzo);
        }
    }

    public function impostaRememberToken(?string$token):void{
        $this->rememberToken=$token;
    }



    //GET methods
 

    public function getEta(): int {
        return $this->calcolaEta($this->dataNascita);
    }

    public function getDataNascita(): DateTime {
        return $this->dataNascita;
    }

    public function getStato(): StatoUtente {
        return $this->stato;
    }

    public function getDataFineSospensione(): ?\DateTime {
        return $this->dataFineSospensione;
    }

    public function getPlayerLevel(): PlayerLevel {
        return $this->PlayerLevel;
    }

    
    //Restituisce lo storico completo di tutti i provvedimenti subiti dall'utente.
    public function getProvvedimenti(): Collection {
        return $this->provvedimenti;
    }

    public function getSegnalazioni(): Collection {
        return $this->segnalazioni;
    }

    public function getRecensioni(): Collection {
         return $this->recensioni; 
    }

    public function getOrdini(): Collection {
         return $this->ordini; 
    }

    public function getPartecipazioni(): Collection { 
        return $this->partecipazioni; 
    }

    public function getIndirizzi(): Collection {
        return $this->indirizzi;
    }

    public function getRememberToken():?string{
        return$this->rememberToken;
    }
}