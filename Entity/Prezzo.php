<?php
class Prezzo {
    private int $idPrezzo;
    private float $value;
    private string $valuta;
    private ?float $sconto;

    public function __construct(int $idPrezzo, float $value, string $valuta, ?float $sconto) {
        $this->idPrezzo = $idPrezzo;
        $this->value = $value;
        $this->valuta = $valuta;
        $this->sconto = $sconto;
    }

    //SET methods
    public function setValue(float $value) {
        $this->value = $value;
    }

    public function setValuta(string $valuta) {
        // Definisco una lista di valute valide (Whitelist)
        $valuteValide = ['EUR', 'USD'];
        if (in_array(trim($valuta), $valuteValide)) {
            $this->valuta = trim($valuta);
        } else {
            throw new InvalidArgumentException("Valuta non valida. Valori accettati: " . implode(", ", $valuteValide));
        }
    }

    public function setSconto(?float $sconto) {
        $this->sconto = $sconto;
    }

    //GET methods
    public function getIdPrezzo(): int {
        return $this->idPrezzo;
    }

    public function getValue(): float {
        return $this->value;
    }

    public function getValuta(): string {
        return $this->valuta;
    }

    public function getSconto(): ?float {
        return $this->sconto;
    }

}