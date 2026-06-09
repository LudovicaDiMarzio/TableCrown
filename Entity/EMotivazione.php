<?php
namespace TableCrown\Entity;

use TableCrown\Entity\Enumerativi\GravitaMotivazione;

class MotivazioneSegnalazione {
    private ?int $idmotivazione=null;
    private string $nomemotivazione; //es. "contenuto inappropriato", "spam", "altro"
    private GravitaMotivazione $gravita; //può essere "bassa", "media" o "alta"

    public function __construct(string $nomemotivazione, GravitaMotivazione $gravita) {
        $this->validaNomeMotivazione($nomemotivazione); //il nome sarà assegnato solo dopo la validazione
        $this->gravita = $gravita;
    }

    /*  questa entità serve per permettere all'admin di creare nuove motivazioni di segnalazione. 
        Se l'admin non avrà ancor ainserito motivazioni, ci saranno delle motivazioni di default che saranno "contenuto inappropriato", "spam" e "altro".
        L'admin potrà anche modificare o eliminare le motivazioni esistenti, ma non potrà eliminare quelle di default, ma questo sarà gestito tutto in foundation.
        Nel momento in cui viene creata una segnalazione, l'utente dovrà scegliere una motivazione tra quelle disponibili, e questa motivazione sarà associata alla segnalazione.
    */

    
    //metodi di dominio
    private function validaNomeMotivazione(string $nome): void
    {
        $nome = trim($nome);
        if (empty($nome)) {
            throw new \InvalidArgumentException("Il nome della motivazione non può essere vuoto.");
        }
        $this->nomemotivazione = $nome;
    }

    //GET methods
    public function getIdMotivazione(): ?int {
        return $this->idmotivazione;
    }

    public function getNomeMotivazione(): string {
        return $this->nomemotivazione;
    }

    public function getGravitaMotivazione(): GravitaMotivazione {
        return $this->gravita;
    }
}