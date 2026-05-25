<?php
namespace TableCrown\Entity;
abstract class EPersona {
    protected ?int $idpersona=null;
    protected string $nomepersona;
    //sarà di tipo blob nel db, quindi per ora prendiamo l'immagine come se fosse una stringa, poi dovrà subire un processo di conversione 
    // in blob prima di essere salvata nel db, e una volta recuperata dal db dovrà essere convertita nuovamente in stringa per 
    // poter essere visualizzata
    protected ?string $imgperosna=null; 
    protected string $emailpersona;
    protected string $passwordpersona;
    

    public function __construct( string $nomepersona, string $imgperosna, string $emailpersona, string $passwordpersona) {
        
        $this->nomepersona = $nomepersona;
        $this->imgperosna = $imgperosna;
        $this->emailpersona = $emailpersona;
        $this->passwordpersona = $passwordpersona;
        
    }

    // setter per le proprietà comuni a tutte le persone
    public function setNomePersona(string $nomepersona): void {
        $this->nomepersona = $nomepersona;
    }

    public function setImgPersona(?string $imgperosna): void {
        $this->imgperosna = $imgperosna;
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
        return $this->imgperosna;
    }

    public function getEmailPersona(): string {
        return $this->emailpersona;
    }

    public function getPasswordPersona(): string {
        return $this->passwordpersona;
    }

}