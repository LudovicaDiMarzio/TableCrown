<?php
namespace TableCrown\Entity;
/*namespace è un modo per includere classi, funzioni e costanti in un contesto specifico, evitando conflitti di nomi con altre parti del codice.
in questo caso, stiamo definendo la classe Utente all'interno del namespace TableCrown\Entity, il che significa che per accedere a questa classe 
da un'altra parte del codice, dovremo fare riferimento a TableCrown\Entity\Utente o utilizzare una dichiarazione use per importarla (use TableCrown\Entity\Utente;).
non è quindi necessario usare il require_once per includere la classe EPersona, poiché è già definita nello stesso namespace e può essere utilizzata direttamente.
*/

use Doctrine\ORM\Mapping as ORM;

/* #[ORM\MappedSuperclass]indica che questa classe è una superclasse mappata su una tabella del database, 
ma non avrà una tabella associata direttamente, poiché è destinata ad essere estesa da altre classi (come EUtente) 
che rappresentano entità concrete con tabelle specifiche nel database.*/
#[ORM\MappedSuperclass]
abstract class EPersona { 

    #[ORM\Id]
    #[ORM\GeneratedValue]//si comporta di default come auto_increment, ma potrebbe essere esplicitato come strategy: "AUTO"
    #[ORM\Column(type: "integer")]  
    private ?int $idpersona=null;

    #[ORM\Column(type: "string", length: 100)]
    private string $nomepersona;

    //sarà di tipo blob nel db, quindi per ora prendiamo l'immagine come se fosse una stringa, poi dovrà subire un processo di conversione 
    // in blob prima di essere salvata nel db, e una volta recuperata dal db dovrà essere convertita nuovamente in stringa per poter essere visualizzata
    #[ORM\Column(type: "blob", nullable:true)]
    private ?string $imgpersona=null; 
    
    #[ORM\Column(type: "string", length: 180, unique:true)]
    private string $emailpersona;

    #[ORM\Column(type: "string")]
    private string $passwordpersona;
    
    //EPersona si occupa di gestire le proprietà comuni a tutte le persone (Utente, Admin, ecc.), mentre le classi figlie (EUtente, EAdmin, ecc.) si occuperanno di gestire le proprietà specifiche di ciascun tipo di persona.
    public function __construct(string $nomepersona, string $emailpersona, string $passwordpersona, ?string $imgpersona = null)
    {
        $this->impostaNome($nomepersona);
        $this->impostaEmail($emailpersona);
        $this->impostaPassword($passwordpersona);
        $this->imgpersona = $imgpersona;
    }

    public function impostaNome(string $nuovoNome): void
    {
        $this->validaNome($nuovoNome);
    }

    public function impostaEmail(string $nuovaEmail): void
    {
        $this->validaEmail($nuovaEmail);
    }

    public function impostaPassword(string $nuovaPassword): void
    {
        $this->validaPassword($nuovaPassword);
    }

    public function aggiornaImmagine(?string $imgBlob): void
    {
        $this->imgpersona = $imgBlob;
    }


    private function validaNome(string $nome): void
    {   
        $nome = trim($nome); // Rimuove spazi bianchi all'inizio e alla fine   
        if (empty($nome)) {
            throw new \InvalidArgumentException("Il nome non può essere vuoto."); 
        }
        $this->nomepersona = $nome;
    }

    private function validaEmail(string $email): void
    {
        $email = trim($email); // Rimuove spazi bianchi all'inizio e alla fine
        //filter_var è una funzione di PHP che filtra una variabile con un filtro specificato, in questo caso FILTER_VALIDATE_EMAIL verifica se la stringa è un indirizzo email valido
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
            throw new \InvalidArgumentException("Email non valida.");
        }
        $this->emailpersona = $email;
    }

    private function validaPassword(string $password): void
    {
        if (strlen($password) < 8) { // Verifica che la password abbia almeno 8 caratteri
            throw new \InvalidArgumentException("La password deve essere lunga almeno 8 caratteri.");
        }
        $this->passwordpersona = password_hash($password, PASSWORD_BCRYPT); // Hash della password per una maggiore sicurezza ;
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

    // La verifica della password avviene confrontando la password fornita con l'hash memorizzato utilizzando la funzione password_verify, che restituisce true se la password è corretta e false altrimenti.
      public function verificaPassword(string $password): bool
    {
        return password_verify($password, $this->passwordpersona);
    }

}