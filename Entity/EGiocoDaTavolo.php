<?php
namespace TableCrown\Entity;
use TableCrown\Entity\EDanno;
use InvalidArgumentException;
use DateTime;
use TableCrown\Entity\Enumerativi\DisponibilitaProdotto;

class EGiocoDaTavolo extends EProdotto {
    // Proprietà specifiche per il gioco da tavolo
    private string $categoria; //es. strategia, famiglia, party game, ecc.
    private array $componenti; //elenco dei componenti del gioco (carte, pedine, tabellone, ecc.)
    private ?EGiocoDaTavolo $giocoBase; //riferimento a un eventuale gioco da tavolo di cui è espansione
    private int $numeroGiocatoriMin;
    private int $numeroGiocatoriMax;
    private int $etaMinima;
    private int $durataMedia; //in minuti
    private ?EDanno $danno; //danno del gioco, se presente
    private ?string $descrizioneDanno; //descrizione del danno, se presente

    public function __construct(?int $idProdotto, string $nomeProdotto, string $imgProdotto, string $descrizioneProdotto, DisponibilitaProdotto $disponibilitaProdotto, int $quantita, DateTime $dataPubblicazione, string $categoria, array $componenti, ?EGiocoDaTavolo $giocoBase, int $numeroGiocatoriMin, int $numeroGiocatoriMax, int $etaMinima, int $durataMedia, ?EDanno $danno = null, ?string $descrizioneDanno = null) {
        parent::__construct($idProdotto, $nomeProdotto, $imgProdotto, $descrizioneProdotto, $disponibilitaProdotto, $quantita, $dataPubblicazione);
        
        $this->categoria = trim($categoria);

        $this->componenti = $componenti;

        if ($giocoBase !== null && $giocoBase->getGiocoBase() !== null) {
            throw new InvalidArgumentException("Il gioco base non può essere a sua volta un'espansione.");
        }
        if ($giocoBase !== null && $giocoBase->getIdProdotto() === $this->getIdProdotto()) {
            throw new InvalidArgumentException("Un gioco da tavolo non può essere un'espansione di se stesso.");
        }
        $this->giocoBase = $giocoBase;

        if ($numeroGiocatoriMin > 0 && $numeroGiocatoriMax >= $numeroGiocatoriMin) {
            $this->numeroGiocatoriMin = $numeroGiocatoriMin;
            $this->numeroGiocatoriMax = $numeroGiocatoriMax;
        } else {
            throw new InvalidArgumentException("Il numero minimo di giocatori deve essere maggiore di 0 e il numero massimo deve essere maggiore o uguale al numero minimo.");
        }

        if ($etaMinima >= 0) {
            $this->etaMinima = $etaMinima;
        } else {
            throw new InvalidArgumentException("L'età minima deve essere maggiore o uguale a 0.");
        }

        if ($durataMedia > 0) {
            $this->durataMedia = $durataMedia;
        } else {
            throw new InvalidArgumentException("La durata media deve essere maggiore di 0.");
        }

        $this->danno = $danno;
        if ($danno !== null && trim($descrizioneDanno) === "") {
            throw new InvalidArgumentException("Se è presente un danno, la descrizione del danno non può essere vuota.");
        }
        if ($danno === null && trim($descrizioneDanno) !== "") {
            throw new InvalidArgumentException("Se non è presente un danno, la descrizione del danno deve essere vuota.");
        }
        $this->descrizioneDanno = $descrizioneDanno;
}

    //SET methods
    public function setCategoria(string $categoria) {
        $this->categoria = trim($categoria);
    }

    public function setComponenti(array $componenti) {
        $this->componenti = $componenti;
    }

    /**
     * per non ripetere gli stessi controlli del costruttore, si potrebbe richiamare il setGiocoBase all'interno del costruttore 
     * e lasciare i controlli solo in setGiocoBase; stessa cosa vale per setNumeroGiocatoriMin, setNumeroGiocatoriMax, setEtaMinima, setDurataMedia e setDanno/setDescrizioneDanno
     */
    public function setGiocoBase(?EGiocoDaTavolo $giocoBase) {
        if ($giocoBase !== null && $giocoBase->getGiocoBase() !== null) {
            throw new InvalidArgumentException("Il gioco base non può essere a sua volta un'espansione.");
        }
        if ($giocoBase !== null && $giocoBase->getIdProdotto() === $this->getIdProdotto()) {
            throw new InvalidArgumentException("Un gioco da tavolo non può essere un'espansione di se stesso.");
        }
        $this->giocoBase = $giocoBase;
    }

    public function setNumeroGiocatoriMin(int $numeroGiocatoriMin) {
        if ($numeroGiocatoriMin > 0 && $numeroGiocatoriMin <= $this->numeroGiocatoriMax) {
            $this->numeroGiocatoriMin = $numeroGiocatoriMin;
        } else {
            throw new InvalidArgumentException("Il numero minimo di giocatori deve essere maggiore di 0 e minore o uguale al numero massimo.");
        }
    }

    public function setNumeroGiocatoriMax(int $numeroGiocatoriMax) {
        if ($numeroGiocatoriMax >= $this->numeroGiocatoriMin) {
            $this->numeroGiocatoriMax = $numeroGiocatoriMax;
        } else {
            throw new InvalidArgumentException("Il numero massimo di giocatori deve essere maggiore o uguale al numero minimo.");
        }
    }

    public function setEtaMinima(int $etaMinima) {
        if ($etaMinima >= 0) {
            $this->etaMinima = $etaMinima;
        } else {
            throw new InvalidArgumentException("L'età minima deve essere maggiore o uguale a 0.");
        }
    }

    public function setDurataMedia(int $durataMedia) {
        if ($durataMedia > 0) {
            $this->durataMedia = $durataMedia;
        } else {
            throw new InvalidArgumentException("La durata media deve essere maggiore di 0.");
        }
    }

    //aggiungere i controlli?
    public function setDanno(?EDanno $danno) {
        $this->danno = $danno;
    }

    public function setDescrizioneDanno(string $descrizioneDanno) {
        $this->descrizioneDanno = trim($descrizioneDanno);
    }

    //GET methods
    public function getCategoria(): string {
        return $this->categoria;
    }

    public function getComponenti(): array {
        return $this->componenti;
    }

    public function getGiocoBase(): ?EGiocoDaTavolo {
        return $this->giocoBase;
    }

    public function getNumeroGiocatoriMin(): int {
        return $this->numeroGiocatoriMin;
    }

    public function getNumeroGiocatoriMax(): int {
        return $this->numeroGiocatoriMax;
    }

    public function getEtaMinima(): int {
        return $this->etaMinima;
    }

    public function getDurataMedia(): int {
        return $this->durataMedia;
    }

    public function getDanno(): ?EDanno {
        return $this->danno;
    }

    public function getDescrizioneDanno(): ?string {
        return $this->descrizioneDanno;
    }
}