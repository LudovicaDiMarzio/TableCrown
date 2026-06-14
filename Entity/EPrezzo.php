<?php
namespace TableCrown\Entity;

use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use TableCrown\Entity\Enumerativi\Valuta;

#[ORM\Entity]
#[ORM\Table(name: 'prezzo')]
class EPrezzo {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $idPrezzo;

    #[ORM\Column(type: 'float')]
    private float $valore;

    #[ORM\Column(type: 'string', enumType: Valuta::class)]
    private Valuta $valuta;

    #[ORM\Column(type: 'float')]
    private float $sconto; //sconto in percentuale, ad esempio 20 per uno sconto del 20% (Se non viene specificato, lo sconto è 0, ovvero nessuno sconto)

    public function __construct(float $valore, Valuta $valuta, float $sconto = 0) {
        $this->sconto = 0; //inizializzazione dello sconto (necessaria per aggiornaSconto() che usa += che richiede inizializzazione)
        $this->aggiornaValore($valore); //utilizza il metodo di dominio per validare il valore del prezzo
        $this->aggiornaValuta($valuta); //utilizza il metodo di dominio per validare la valuta del prezzo
        $this->aggiornaSconto($sconto); //utilizza il metodo di dominio per validare lo sconto
    }

    //GET methods
    public function getIdPrezzo(): ?int {
        return $this->idPrezzo;
    }

    public function getValore(): float {
        return $this->valore;
    }

    public function getValuta(): Valuta {
        return $this->valuta;
    }

    public function getSconto(): float {
        return $this->sconto;
    }

    //Metodi di dominio

    /**
     * Aggiorna il valore del prezzo.
     */
    public function aggiornaValore(float $valore): void {
        if ($valore < 0) {
            throw new InvalidArgumentException("Il valore del prezzo non può essere negativo.");
        }
        $this->valore = $valore;
    }

    /**
     * Aggiorna la valuta del prezzo.
     */
    public function aggiornaValuta(Valuta $valuta): void {
        $this->valuta = $valuta;
    }

    /**
     * Aggiorna lo sconto del prezzo. (Se è già presente uno sconto, aggiunge il nuovo sconto a quello esistente, invece di sovrascriverlo, per permettere di applicare più sconti cumulativi).
     * La somma degli sconti supera 100, lo sconto viene impostato a 100 (lo sconto massimo è 100%).
     */
    public function aggiornaSconto(float $sconto): void {
        if ($sconto < 0 || $sconto > 100) {
            throw new InvalidArgumentException("Lo sconto deve essere compreso tra 0 e 100.");
        }
        $this->sconto += $sconto;
        if ($this->sconto > 100) {
            $this->sconto = 100; //lo sconto massimo è 100%
        }
    }

    /**
     * Rimuove lo sconto, impostandolo a zero.
     */
    public function rimuoviSconto(): void {
        $this->sconto = 0;
    }

    /**
     * Calcola il prezzo finale, applicando lo sconto al valore del prezzo.
     */
    public function calcolaPrezzoScontato(): float {
        if ($this->sconto !== 0) {
            return $this->valore * (1 - $this->sconto / 100);
        }
        return $this->valore;
    }

    /**
     * Controlla se il prezzo è in sconto, ovvero se lo sconto è diverso da 0.
     */
    public function hasSconto(): bool {
        return $this->sconto !== 0;
    }


}