<?php
namespace TableCrown\Entity;

use InvalidArgumentException;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Exception;

#[ORM\Entity]
#[ORM\Table(name: "carta_di_credito")]
class ECartaDiCredito {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $idCartaDiCredito = null;

    #[ORM\Column(type: "string", length: 100)]
    private string $titolare;

    #[ORM\Column(type: "datetime")]
    private DateTime $dataScadenza;

    #[ORM\Column(type: "string", length: 4)]
    private string $ultimeQuattroCifre;

    //ogni token generato sarà della tipologia tok_<odice random generato dalla mock lungo 16 caratteri>
    //la lunghezza del token è 255 perchè nella realtà stripe usa lunghezze diverse per i token, quindi limitarlo a 20 sarebbe rischioso nel caso di un'evoluzione del sistema di pagamento
    #[ORM\Column(type: "string", length: 255, unique: true)]
    private string $token;

    #[ORM\ManyToOne(targetEntity: EUtente::class)]
    #[ORM\JoinColumn(name: "utente_id", referencedColumnName: "idpersona", nullable: false, onDelete: 'CASCADE')]
    private EUtente $utente;

    public function __construct(EUtente $utente, string $titolare, string $ultimeQuattroCifre, string $dataScadenza, string $token) {
        $this->utente = $utente;
        $this->impostaNomeTitolare($titolare);
        $this->traduciStringaData($dataScadenza);
        $this->impostaUltimeQuattroCifre($ultimeQuattroCifre);
        $this->token = $token;
    }

    // Metodi di dominio

    public function impostaNomeTitolare(string $titolare): void 
    {
        $titolarePulito = trim($titolare);
        if (empty($titolarePulito)) {
            throw new InvalidArgumentException("Il nome del titolare non può essere vuoto.");
        }
        $this->titolare = strtoupper($titolarePulito); // Salviamo sempre in maiuscolo per pulizia
    }

    public function impostaUltimeQuattroCifre(string $ultimeQuattroCifre): void 
    {
        if (strlen($ultimeQuattroCifre) !== 4 || !is_numeric($ultimeQuattroCifre)) {
            throw new Exception("Le ultime cifre devono essere esattamente 4 numeri.");
        }
        $this->ultimeQuattroCifre = $ultimeQuattroCifre;
    }

    //trasformo la stringa "12/26" in un oggetto DateTime da inserire nel db
    public function traduciStringaData(string $scadenzaStringa): void 
    {
        // 1. Validiamo la stringa con la Regex come prima
        if (!preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', $scadenzaStringa)) {
            throw new Exception("La scadenza deve essere nel formato MM/AA.");
        }

        // 2. Rompiamo la stringa "12/26" -> mese = 12, anno = 26
        [$mese, $anno] = explode('/', $scadenzaStringa);
        
        // 3. Creiamo il DateTime impostandolo al PRIMO giorno di quel mese (es. "2026-12-01")
        // Usiamo l'eccezione se la creazione fallisce per date assurde
        try {
            $this->dataScadenza = new \DateTime("20$anno-$mese-01 00:00:00");
        } 
        catch (Exception $e) {
            throw new \InvalidArgumentException("Data di scadenza non valida.");
        }

        //controllo se la carta è già scaduta
        if ($this->isScaduta()) {
            throw new \InvalidArgumentException("La carta è già scaduta.");
        }
    }

    public function isScaduta(): bool 
    {
        $fineValidita = clone $this->dataScadenza;  // ← clone per non modificare l'originale
        $fineValidita->modify('last day of this month');
        return new \DateTime() > $fineValidita;
    }

    // GET methods

    public function getScadenzaFormattata(): string 
    {
        // ->format('m/y') trasforma il DateTime direttamente in "12/26"
        return $this->dataScadenza->format('m/y');
    }

    public function getNumeroMascherato(): string 
    {
        return '**** **** **** ' . $this->ultimeQuattroCifre;
    }

    public function getUtente(): EUtente 
    {
        return $this->utente;
    }

    public function getIdCartaDiCredito(): ?int 
    {
         return $this->idCartaDiCredito; 
    }

    public function getTitolare(): string        
    {
         return $this->titolare;
    }

    public function getDataScadenza(): DateTime  
    {
         return $this->dataScadenza; 
    }

    public function getUltimeQuattroCifre(): string 
    {
         return $this->ultimeQuattroCifre; 
    }

    public function getToken(): string        
    {
         return $this->token; 
    }
   
}