<?php
namespace TableCrown\Entity;

use DateTime;
use TableCrown\Entity\Enumerativi\StatoProvvedimento;
use TableCrown\Entity\Enumerativi\TipoProvvedimento;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "provvedimento" )]

class EProvvedimento {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $idprovvedimento=null;

    #[ORM\Column(type: "string", enumType: TipoProvvedimento:: class)] 
    private TipoProvvedimento $tipoprovvedimento; //può essere  "sospensione" o "ban"
    /*la segnalazione a cui è associato il provvedimento, può essere null perchè l'admin potrebbe
    decidere di appplicare un provvedimento anche senza che gli arrivi una segnalazione, ad esempio scorrendo le recensioni
    */

    //TODO: aggiungere annotation doctrine per la relazione con l'entity ESegnalazione
    private ?ESegnalazione $segnalazionecollegata;
    
    #[ORM\Column(type: "datetime")]
    private DateTime $dataemissione; //la data di inizio del provvedimento

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?DateTime $datascadenza=null; //la data di fine del provvedimento, se è una sospensione, altrimenti null

    #[ORM\Column(type: "string", enumType: StatoProvvedimento:: class)]
    private StatoProvvedimento $statoprovvedimento; //può essere "attivo" o "revocato"
  
    //TODO: aggiungere annotation doctrine per la relazione con l'entity EUtente
    private EUtente $utentesanzionato; //l'utente a cui è stato applicato il provvedimento 

    public function __construct(TipoProvvedimento $tipoprovvedimento, ESegnalazione $segnalazionecollegata,  ?DateTime $datascadenza, EUtente $utentesanzionato) {
        $this->tipoprovvedimento = $tipoprovvedimento;
        $this->segnalazionecollegata = $segnalazionecollegata;
        $this->dataemissione = new DateTime();
        $this->validaDataScadenza($datascadenza);
        $this->statoprovvedimento = StatoProvvedimento::ATTIVO; // inizialmente sempre attivo
        $this->utentesanzionato = $utentesanzionato;
    }

    //metodi di dominio
    public function revoca(): void
    {
        if ($this->statoprovvedimento === StatoProvvedimento::REVOCATO) {
            throw new \DomainException("Il provvedimento è già revocato.");
        }
        $this->statoprovvedimento = StatoProvvedimento::REVOCATO;
        $this->datascadenza = null;
    }

    //validazione data di scadenza
    private function validaDataScadenza(?DateTime $datascadenza): void     {
        if ($this->tipoprovvedimento === TipoProvvedimento::SOSPENSIONE) {
            if ($datascadenza === null) {
                throw new \InvalidArgumentException("Una sospensione richiede una data di scadenza.");
            }
            if ($datascadenza <= new DateTime()) {
                throw new \InvalidArgumentException("La data di scadenza deve essere nel futuro.");
            }
            $this->datascadenza = $datascadenza;
        } else {
            $this->datascadenza = null; // per i ban, la data di scadenza è sempre null
        }
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

    public function getUtenteSanzionato(): EUtente {
        return $this->utentesanzionato;
    }

    public function getSegnalazioneCollegata(): ?ESegnalazione {
        return $this->segnalazionecollegata;
    }

}