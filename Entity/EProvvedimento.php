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

    #[ORM\Column(type: "string", enumType: TipoProvvedimento::class)] 
    private TipoProvvedimento $tipoprovvedimento; //può essere  "sospensione" o "ban"
    /*la segnalazione a cui è associato il provvedimento, può essere null perchè l'admin potrebbe
    decidere di appplicare un provvedimento anche senza che gli arrivi una segnalazione, ad esempio scorrendo le recensioni
    */

    
    //una segnalazione può avere più provvedimenti (escalation sospensione -> ban), ma un provvedimento è associato ad una sola segnalazione (relazione molti a uno)
    //relazione unidirezionale perchè non ho bisogno di vedere tutti i provvedimenti legati ad una segnalazione, ma solo la segnalazione collegata ad un provvedimento
    #[ORM\ManyToOne(TargetEntity: ESegnalazione::class)]
    #[ORM\JoinColumn(nullable: true)] //
    private ?ESegnalazione $segnalazionecollegata;
    
    #[ORM\Column(type: "datetime")]
    private DateTime $dataemissione; //la data di inizio del provvedimento

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?DateTime $datascadenza=null; //la data di fine del provvedimento, se è una sospensione, altrimenti null

    #[ORM\Column(type: "string", enumType: StatoProvvedimento::class)]
    private StatoProvvedimento $statoprovvedimento; //può essere "attivo" o "revocato"

    //la relazione è unidirezionale perchè non ho bisogno di vedere tutti i provvedimenti legati ad una recensione
    #[ORM\ManyToOne(TargetEntity: ERecensione::class)]
    #[ORM\JoinColumn(name: "recensione_id", referencedColumnName: "id", nullable: true)] 
    private ?ERecensione $recensionecollegata=null; //la recensione a cui è associato il provvedimento, può essere null perchè l'admin potrebbe decidere di appplicare un provvedimento anche senza che gli arrivi una segnalazione, ad esempio scorrendo le recensioni
  
    //un utente può ricevere più provvedimenti, ma un provvedimento è associato ad un solo utente (relazione molti a uno)
    #[ORM\ManyToOne(TargetEntity: EUtente::class, inversedBy: "provvedimenti")] //la proprietà "provvedimenti" è quella che abbiamo definito nella classe EUtente per la relazione inversa
    #[ORM\JoinColumn(nullable: false)]
    private EUtente $utentesanzionato; //l'utente a cui è stato applicato il provvedimento 

    public function __construct(TipoProvvedimento $tipoprovvedimento, EUtente $utentesanzionato, ?DateTime $datascadenza, ?ERecensione $recensionecollegata=null, ?ESegnalazione $segnalazionecollegata=null) {
        $this->tipoprovvedimento = $tipoprovvedimento;
        $this->dataemissione = new DateTime();
        $this->statoprovvedimento = StatoProvvedimento::ATTIVO; // inizialmente sempre attivo
        $this->utentesanzionato = $utentesanzionato;
        $this->validaDataScadenza($datascadenza);
        $this->recensionecollegata = $recensionecollegata; // inizialmente non è associato a nessuna recensione, ma potrà essere associato in un secondo momento se l'admin decide di applicare un provvedimento ad una recensione specifica
        $this->segnalazionecollegata = $segnalazionecollegata;
        //manteniamo la coerenza nella relazione bidirezionale, aggiungendo il provvedimento alla collection provvedimenti di EUtente, altrimenti la collection sarebbe aggiornata solo dopo il flush
        //il this come parametro sta a rappresentare che stiamo passando esattamente questa istanza del provvedimento
        $utentesanzionato->riceviProvvedimento($this);
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
    
    
    // Associa una recensione al provvedimento come causa scatenante.
    public function associaRecensioneCausante(ERecensione $recensione): void {
        
        // Un provvedimento può essere legato a una sola recensione.
        if ($this->recensionecollegata !== null) {
            throw new \Exception("Errore: Questo provvedimento è già associato a una recensione. Non puoi sovrascriverla.");
        }

        // Non si può associare una recensione se il provvedimento è già scaduto o revocato
        if ($this->statoprovvedimento === StatoProvvedimento::REVOCATO) {
            throw new \Exception("Errore: Non puoi associare una recensione a un provvedimento già revocato.");
        }

        // Se supera i controlli, esegue l'azione
        $this->recensionecollegata = $recensione;
    }


    //Associa una segnalazione al provvedimento come causa scatenante. 
    public function associaSegnalazioneCausante(ESegnalazione $segnalazione): void {
        
        //Un provvedimento nasce da una singola segnalazione. 
        // Se è già associato a una segnalazione, blocchiamo la sovrascrittura.
        if ($this->segnalazionecollegata !== null) {
            throw new \Exception("Errore: Questo provvedimento è già stato generato da una segnalazione.");
        }

        //Impedisce di manomettere lo storico di un ban già chiuso/revocato.
        if ($this->statoprovvedimento === StatoProvvedimento::REVOCATO) {
            throw new \Exception("Errore: Impossibile associare una nuova segnalazione a un provvedimento già revocato.");
        }

        // Se supera i controlli di sicurezza, esegue l'assegnazione
        $this->segnalazionecollegata = $segnalazione;
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

    public function getRecensioneCollegata(): ?ERecensione {
        return $this->recensionecollegata;
    }

}