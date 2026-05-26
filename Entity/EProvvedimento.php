<?php
namespace TableCrown\Entity;

use DateTime;
use TableCrown\Entity\Enumerativi\StatoProvvedimento;
use TableCrown\Entity\Enumerativi\TipoProvvedimento;

class EProvvedimento {
    private ?int $idprovvedimento=null;
    private TipoProvvedimento $tipoprovvedimento; //può essere  "sospensione" o "ban"
    private ESegnalazione $segnalazione; //la segnalazione a cui è associato il provvedimento
    private DateTime $dataemissione; //la data di inizio del provvedimento
    private ?DateTime $datascadenza=null; //la data di fine del provvedimento, se è una sospensione, altrimenti null
    private StatoProvvedimento $statoprovvedimento; //può essere "attivo" o "revocato"
    private EUtente $utente; //l'utente a cui è stato applicato il provvedimento 

    public function __construct(TipoProvvedimento $tipoprovvedimento, ESegnalazione $segnalazione, DateTime $dataemissione, ?DateTime $datascadenza, StatoProvvedimento $statoprovvedimento) {
        $this->tipoprovvedimento = $tipoprovvedimento;
        $this->segnalazione = $segnalazione;
        $this->dataemissione = $dataemissione;
        $this->datascadenza = $datascadenza;
        $this->statoprovvedimento = $statoprovvedimento;
    }

    //SET methods
    public function setTipoProvvedimento(TipoProvvedimento $tipoprovvedimento) {
        $this->tipoprovvedimento = $tipoprovvedimento;
    }

   
    public function setDataEmissione(DateTime $dataemissione) {
        $this->dataemissione = $dataemissione;
    }

    public function setDataScadenza(?DateTime $datascadenza) {
        $this->datascadenza = $datascadenza;
    }

    public function setStatoProvvedimento(StatoProvvedimento $statoprovvedimento) {
        $this->statoprovvedimento = $statoprovvedimento;
    }

    //GET methods
    public function getIdProvvedimento(): ?int {
        return $this->idprovvedimento;
    }

    public function getTipoProvvedimento(): TipoProvvedimento {
        return $this->tipoprovvedimento;
    }

   
    public function getDataEmissione(): DateTime {
        return $this->dataemissione;
    }

    public function getDataScadenza(): ?DateTime {
        return $this->datascadenza;
    }

    public function getStatoProvvedimento(): StatoProvvedimento {
        return $this->statoprovvedimento;
    }


}