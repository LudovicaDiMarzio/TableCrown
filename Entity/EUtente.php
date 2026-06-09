<?php
namespace TableCrown\Entity;
/*namespace è un modo per includere classi, funzioni e costanti in un contesto specifico, evitando conflitti di nomi con altre parti del codice.
in questo caso, stiamo definendo la classe Utente all'interno del namespace TableCrown\Entity, il che significa che per accedere a questa classe 
da un'altra parte del codice, dovremo fare riferimento a TableCrown\Entity\Utente o utilizzare una dichiarazione use per importarla (use TableCrown\Entity\Utente;).
non è quindi necessario usare il require_once per includere la classe EPersona, poiché è già definita nello stesso namespace e può essere utilizzata direttamente.
*/
use DateTime;
USE TableCrown\Entity\Enumerativi\PlayerLevel; //importiamo l'enumerativo PlayerLevel che abbiamo definito in una cartella separata, altrimenti dovremmo fare riferimento a esso con il suo namespace completo ogni volta che lo utilizziamo (TableCrown\Entity\Enumerativi\PlayerLevel).
class EUtente extends EPersona {
    
    private int $eta;
    private string $stato;
    private DateTime $dataFineSospensione;
    private PlayerLevel $PlayerLevel;
   

    public function __construct(string $nomeuser, mixed $imgprofilouser, string $emailuser, string $passworduser, int $eta, PlayerLevel $PlayerLevel) {
        //invoca il costruttore della classe padre (EPersona) per inizializzare le proprietà comuni a tutte le persone, e poi inizializziamo le proprietà specifiche dell'utente (EUtente).
        parent::__construct($nomeuser, $imgprofilouser, $emailuser, $passworduser);
       
        //Gestiamo i dati specifici dell'utente
        $this->ImpostaEta($eta); 
        $this->stato = 'attivo'; //un utente appena creato è attivo di default 
        $this->dataFineSospensione = null;
        $this->PlayerLevel = $PlayerLevel;
    }

    //Metodi di dominio
        // Invece di setStato() generico, metodi che esprimono un'azione precisa
    public function sospendi(DateTime $dataFine): void
    {
        if ($this->stato === 'bannato') {
            throw new \DomainException("Un utente bannato non può essere sospeso.");
        }
        if ($dataFine <= new DateTime()) { 
            throw new \InvalidArgumentException("La data di fine sospensione deve essere nel futuro.");
        }
        $this->stato = 'sospeso';
        $this->dataFineSospensione = $dataFine;
    }

    public function banna(): void
    {
        if ($this->stato === 'bannato') {
            throw new \DomainException("L'utente è già bannato.");
        }
        $this->stato = 'bannato';
        $this->dataFineSospensione = null;  // non serve più
    }

    public function riattiva(): void
    {
        if ($this->stato === 'attivo') {
            throw new \DomainException("L'utente è già attivo.");
        }
        $this->stato = 'attivo';
        $this->dataFineSospensione = null;
    }

    public function aggiornaLivello(PlayerLevel $nuovoLivello): void
    {
        $this->playerLevel = $nuovoLivello;
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
    public function getIduser() {
        return $this->iduser;
    }

    public function getNome() {
        return $this->nomeuser;
    }

    public function getImgprofilo() {
        return $this->imgprofilouser;
    }

    public function getEmail() {
        return $this->emailuser;
    }

    public function getPassword() {
        return $this->passworduser;
    }

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