<?php
abstract class Prodotto {
    private int $idProdotto;
    private string $nomeProdotto;
    private string $imgProdotto; //da rivedere
    private string $descrizioneProdotto;
    private string $disponibilitaProdotto;
    private int $quantita;
    private DateTime $dataPubblicazione;

    public function __construct(int $idProdotto, string $nomeProdotto, string $imgProdotto, string $descrizioneProdotto, string $disponibilitaProdotto, int $quantita, DateTime $dataPubblicazione) {
        $this->idProdotto = $idProdotto;
        $this->nomeProdotto = $nomeProdotto;
        $this->imgProdotto = $imgProdotto;
        $this->descrizioneProdotto = $descrizioneProdotto;
        $this->disponibilitaProdotto = $disponibilitaProdotto;
        $this->quantita = $quantita;
        $this->dataPubblicazione = $dataPubblicazione;
    }

    //SET methods
    public function setNomeProdotto(string $nomeProdotto) {
        $this->nomeProdotto = trim($nomeProdotto);
    }

    public function setImgProdotto(string $imgProdotto) {
        $this->imgProdotto = trim($imgProdotto);
    }

    public function setDescrizioneProdotto(string $descrizioneProdotto) {
        $this->descrizioneProdotto = trim($descrizioneProdotto);
    }

    public function setDisponibilitaProdotto(string $disponibilita) {
            // Definisco una lista di disponibilità valide (Whitelist)
            $disponibilitaValide = ['disponibile', 'non disponibile', 'esaurito', 'in arrivo'];
        if (in_array(trim($disponibilita), $disponibilitaValide)) {
            $this->disponibilitaProdotto = trim($disponibilita);
        } else {
            throw new InvalidArgumentException("Disponibilità non valida. Valori accettati: " . implode(", ", $disponibilitaValide));
        }
    }

    public function setQuantita(int $quantita) {
        $this->quantita = $quantita;
    }

    public function setDataPubblicazione(DateTime $dataPubblicazione) {
        $this->dataPubblicazione = $dataPubblicazione;
    }

    //GET methods
    public function getIdProdotto(): int {
        return $this->idProdotto;
    }
    public function getNomeProdotto(): string {
        return $this->nomeProdotto;
    }
    public function getImgProdotto(): string {
        return $this->imgProdotto;
    }
    public function getDescrizioneProdotto(): string {
        return $this->descrizioneProdotto;
    }
    public function getDisponibilitaProdotto(): string {
        return $this->disponibilitaProdotto;
    }
    public function getQuantita(): int {
        return $this->quantita;
    }
    public function getDataPubblicazione(): DateTime {
        return $this->dataPubblicazione;
    }
}
