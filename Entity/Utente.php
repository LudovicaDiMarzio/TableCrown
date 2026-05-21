<?php
class Utente {
    private int $iduser;
    private string $nomeuser;
    private mixed $imgprofilouser;
    private string $emailuser;
    private string $passworduser;
    private int $eta;
    private string $stato;
    private DateTime $dataFineSospensione;
    private string$PlayerLevel;
   

    public function __construct(int $iduser, string $nomeuser, mixed $imgprofilouser, string $emailuser, string $passworduser, int $eta, string $stato='attivo', DateTime $dataFineSospensione, string $PlayerLevel) {
        $this->iduser = $iduser;
        $this->nomeuser = $nomeuser;
        $this->imgprofilouser = $imgprofilouser;
        $this->emailuser = $emailuser;
        $this->passworduser = $passworduser;
        $this->eta = $eta;
        $this->stato = $stato; //un utente appena creato è attivo di default 
        $this->dataFineSospensione = $dataFineSospensione;
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
        $nuovoStato = strtolower($nuovoStato);
        // Controlliamo se lo stato passato è tra quelli permessi
        if (!in_array($nuovoStato, $statiValidi)) {
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

    public function setPlayerLevel(string $PlayerLevel) {
            $livelliValidi = ['principiante', 'intermedio', 'avanzato'];
            if (!in_array($PlayerLevel, $livelliValidi)) {
                throw new Exception("Livello del giocatore '$PlayerLevel' non valido. Usa solo: principiante, intermedio o avanzato.");
            }
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