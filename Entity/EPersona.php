<?php
namespace TableCrown\Entity;
/*namespace è un modo per includere classi, funzioni e costanti in un contesto specifico, evitando conflitti di nomi con altre parti del codice.
in questo caso, stiamo definendo la classe Utente all'interno del namespace TableCrown\Entity, il che significa che per accedere a questa classe 
da un'altra parte del codice, dovremo fare riferimento a TableCrown\Entity\Utente o utilizzare una dichiarazione use per importarla (use TableCrown\Entity\Utente;).
non è quindi necessario usare il require_once per includere la classe EPersona, poiché è già definita nello stesso namespace e può essere utilizzata direttamente.
*/
abstract class EPersona {
    private ?int $idpersona=null;
    private string $nomepersona;
    //sarà di tipo blob nel db, quindi per ora prendiamo l'immagine come se fosse una stringa, poi dovrà subire un processo di conversione 
    // in blob prima di essere salvata nel db, e una volta recuperata dal db dovrà essere convertita nuovamente in stringa per poter essere visualizzata
    private ?string $imgpersona=null; 
    private string $emailpersona;
    private string $passwordpersona;
    
    //EPersona si occupa di gestire le proprietà comuni a tutte le persone (Utente, Admin, ecc.), mentre le classi figlie (EUtente, EAdmin, ecc.) si occuperanno di gestire le proprietà specifiche di ciascun tipo di persona.
    public function __construct( string $nomepersona, string $imgpersona, string $emailpersona, string $passwordpersona) {

        if (empty(trim($nomepersona))) { throw new \Exception("Nome vuoto"); }
        $this->nomepersona = trim($nomepersona);
        $this->imgpersona = $imgpersona;
        $this->validaEImpostaEmail($emailpersona); // metodo privato di validazione
        $this->validaEImpostaPassword($passwordpersona); // metodo privato di validazione
    }

    // setter per le proprietà comuni a tutte le persone
    public function setNomePersona(string $nomepersona): void {
        $this->nomepersona = $nomepersona;
    }

    public function setImgPersona(?string $imgpersona): void {
        $this->imgpersona = $imgpersona;
    }
    public function setEmailPersona(string $emailpersona): void {
        $this->emailpersona = $emailpersona;
    }

    public function setPasswordPersona(string $passwordpersona): void {
        $this->passwordpersona = $passwordpersona;
    }

    // Getter per le proprietà comuni a tutte le persone
    public function getIdPersona(): ?int {
        return $this->idpersona;
    }

    public function getNomePersona(): string {
        return $this->nomepersona;
    }

    public function getImgPersona(): ?string {
        return $this->imgpersona;
    }

    public function getEmailPersona(): string {
        return $this->emailpersona;
    }

    public function getPasswordPersona(): string {
        return $this->passwordpersona;
    }

}