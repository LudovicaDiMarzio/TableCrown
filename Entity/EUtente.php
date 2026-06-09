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
        if ($eta < 0) { throw new \Exception("L'età non può essere negativa."); }
        $this->eta = $eta;
        $this->stato = 'attivo'; //un utente appena creato è attivo di default 
        $this->dataFineSospensione = null;
        $this->PlayerLevel = $PlayerLevel;
    }

    //inserire tutte le eccezioni per i set, ad esempio se l'email non è valida, se la password è troppo corta, se l'età è negativa, ecc.
    //SET methods
    public function setNome(string $nome) {
        $this->nomeuser = trim($nome);
    }

    public function setImgprofilo(mixed $imgprofilo) {
        $this->imgprofilouser = $imgprofilo;
    }

    public function setEmail(string $email) {
        /*FILTER_VALIDATE_EMAIL è una costante predefinita in PHP che 
        viene utilizzata con la funzione filter_var() per validare se una stringa è un indirizzo email valido.*/
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Indirizzo email non valido.");
        }
        $this->emailuser = trim($email);
    }

    public function setPassword(string $password) {
        if (strlen($password) < 8) {
            throw new Exception("La password deve essere lunga almeno 8 caratteri.");
        }
        $this->passworduser = trim($password);
    }

    public function setEta(int $eta) {
        if ($eta < 0) {
            throw new Exception("L'età non può essere negativa.");
        }
        $this->eta = $eta;
    }

    public function setStato(string $newstate){
        // Definiamo una lista di stati validi (Whitelist)
        $statiValidi = ['attivo', 'bannato', 'sospeso'];

        // Convertiamo in minuscolo per evitare problemi con "Attivo" o "ATTIVO"
        $nuovoStato = strtolower($newstate);
        // Controlliamo se lo stato passato è tra quelli permessi
        if (!in_array($nuovostato, $statiValidi)) {
            /*throw blocca l'esecuzioe del codice, new Exception crea un oggetto di tipo Exception con il messaggio dell'errore,
            viene poi creato quando setStato viene chiamato da un codice esterno, se lo stato passato non è valido, l'eccezione viene lanciata e 
            può essere gestita con un blocco try-catch, utile per preservarsi in caso si tentati attacchi esterni*/ 
            throw new Exception("Stato '$nuovoStato' non valido. Usa solo: attivo, bannato o sospeso.");
        }
        $this->stato = $newstate;
    }

    public function setdataFineSospensione(DateTime $dataFineSospensione) {

        if ($dataFineSospensione < new DateTime()) {
            throw new Exception("La data di fine sospensione deve essere nel futuro.");
        }
        $this->dataFineSospensione = $dataFineSospensione;
    }

    public function setPlayerLevel(PlayerLevel $PlayerLevel) {
            $this->PlayerLevel = $PlayerLevel;
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