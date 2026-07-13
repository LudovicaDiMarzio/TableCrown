<?php
namespace TableCrown\Entity;

use Doctrine\ORM\Mapping as ORM;
use TableCrown\Entity\Enumerativi\LivelloDannoGiochi;
use InvalidArgumentException;

#[ORM\Entity]
#[ORM\Table(name: "danno")]
class EDanno {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $iddanno=null;

    #[ORM\Column(type: "string", enumType: LivelloDannoGiochi::class)]
    private LivelloDannoGiochi $livelloDanno; //enum per indicare il livello di danno del gioco
    
    #[ORM\Column(type: "float")]
    private float $scontoDanno; //oggetto della classe EScontoDanno che contiene lo sconto per il livello di danno

    public function __construct(LivelloDannoGiochi $livelloDanno, float $scontoDanno) {
        $this->livelloDanno = $livelloDanno;
        $this->scontoDanno = $scontoDanno;
    }

    //GET methods
    public function getIddanno(): ?int {
        return $this->iddanno;
    }
    
    public function getLivelloDanno(): LivelloDannoGiochi {
        return $this->livelloDanno;
    }

    public function getScontoDanno(): float {
        return $this->scontoDanno;
    }

    //Metodi di dominio

    /**
     * Aggiorna il livello di danno
     */
    public function aggiornaLivelloDanno(LivelloDannoGiochi $livelloDanno): void {
        $this->livelloDanno = $livelloDanno;
    }

    /**
     * Aggiorna sconto.
     */
    public function aggiornaScontoDanno(float $scontoDanno): void {
        if ($scontoDanno < 0 || $scontoDanno > 100) {
            throw new InvalidArgumentException("Lo sconto deve essere compreso tra 0 e 100.");
        }
        $this->scontoDanno = $scontoDanno;
    }

    // /**
    //  * Verifica che lo sconto rispetti l'ordine danno leggero < danno moderato < danno grave.
    //  */
    // private static function verificaOrdine(float $sconto, ?float $min, ?float $max): void {
    //     if ($min !== null && $sconto <= $min) {
    //         throw new InvalidArgumentException("Lo sconto deve essere maggiore dello sconto di livello inferiore ({$min}%).");
    //     }
    //     if ($max != null && $sconto >= $max) {
    //         throw new InvalidArgumentException("Lo sconto deve essere minore dello sconto del livello superiore ({$max}%).");
    //     }
    // }

    // /**
    //  * Aggiorna lo sconto per un livello di danno specifico.
    //  * Garantisce che danno leggero < danno moderato < danno grave.
    //  */
    // public static function aggiornaSconto(LivelloDannoGiochi $livello, float $sconto): void {
    //     if ($sconto < 0 || $sconto > 100) {
    //         throw new InvalidArgumentException("Lo sconto deve essere compreso tra 0 e 100.");
    //     }
        
    //     $sconti = self::$scontiPerLivello; //copia dell'array per leggibilità e comodità

    //     match($livello) {
    //         LivelloDannoGiochi::L1 => self::verificaOrdine($sconto, null, $sconti['danno moderato']),
    //         LivelloDannoGiochi::L2 => self::verificaOrdine($sconto, $sconti['danno leggero'], $sconti['danno grave']),
    //         LivelloDannoGiochi::L3 => self::verificaOrdine($sconto, $sconti['danno moderato'], null),
    //     };

    //     self::$scontiPerLivello[$livello->value] = $sconto;
    // }
}