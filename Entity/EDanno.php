<?php
namespace TableCrown\Entity;
use TableCrown\Entity\Enumerativi\LivelloDannoGiochi;
use InvalidArgumentException;

class EDanno {
    private LivelloDannoGiochi $livelloDanno; //enum per indicare il livello di danno del gioco
    
    private static array $scontiPerLivello = [
        'danno leggero' => 5.0,
        'danno moderato' => 10.0,
        'danno grave' => 15.0,
    ];

    public function __construct(LivelloDannoGiochi $livelloDanno) {
        $this->livelloDanno = $livelloDanno;
    }

    //GET methods
    public function getLivelloDanno(): LivelloDannoGiochi {
        return $this->livelloDanno;
    }

    public function getSconto(): float {
        return self::$scontiPerLivello[$this->livelloDanno->value];
    }

    public static function getScontiPerLivello(): array {
        return self::$scontiPerLivello;
    }

    //Metodi di dominio

    /**
     * Aggiorna il livello di danno
     */
    public function aggiornaLivelloDanno(LivelloDannoGiochi $livelloDanno): void {
        $this->livelloDanno = $livelloDanno;
    }

    /**
     * Verifica che lo sconto rispetti l'ordine danno leggero < danno moderato < danno grave.
     */
    private static function verificaOrdine(float $sconto, ?float $min, ?float $max): void {
        if ($min !== null && $sconto <= $min) {
            throw new InvalidArgumentException("Lo sconto deve essere maggiore dello sconto di livello inferiore ({$min}%).");
        }
        if ($max != null && $sconto >= $max) {
            throw new InvalidArgumentException("Lo sconto deve essere minore dello sconto del livello superiore ({$max}%).");
        }
    }

    /**
     * Aggiorna lo sconto per un livello di danno specifico.
     * Garantisce che danno leggero < danno moderato < danno grave.
     */
    public static function aggiornaSconto(LivelloDannoGiochi $livello, float $sconto): void {
        if ($sconto < 0 || $sconto > 100) {
            throw new InvalidArgumentException("Lo sconto deve essere compreso tra 0 e 100.");
        }
        
        $sconti = self::$scontiPerLivello; //copia dell'array per leggibilità e comodità

        match($livello) {
            LivelloDannoGiochi::L1 => self::verificaOrdine($sconto, null, $sconti['danno moderato']),
            LivelloDannoGiochi::L2 => self::verificaOrdine($sconto, $sconti['danno leggero'], $sconti['danno grave']),
            LivelloDannoGiochi::L3 => self::verificaOrdine($sconto, $sconti['danno moderato'], null),
        };

        self::$scontiPerLivello[$livello->value] = $sconto;
    }
}