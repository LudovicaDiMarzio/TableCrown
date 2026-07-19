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
    
    
    private const SCONTI_PER_LIVELLO=[
        'danno_leggero' => 0.0,
        'danno_moderato' => 10.0,
        'danno_alto' => 15.0,    
    ];

    public function __construct(LivelloDannoGiochi $livelloDanno) {
        $this->livelloDanno = $livelloDanno;
    }

    //GET methods
    public function getIddanno(): ?int {
        return $this->iddanno;
    }
    
    public function getLivelloDanno(): LivelloDannoGiochi {
        return $this->livelloDanno;
    }

    public function getScontoDanno(): float {
        return self::SCONTI_PER_LIVELLO[$this->livelloDanno->value];
    }

    //Metodi di dominio

    /**
     * Aggiorna il livello di danno
     */
    public function aggiornaLivelloDanno(LivelloDannoGiochi $livelloDanno): void {
        $this->livelloDanno = $livelloDanno;
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