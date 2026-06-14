<?php
namespace TableCrown\Entity;

use Doctrine\ORM\Mapping as ORM;
use TableCrown\Entity\EPrezzo;
use InvalidArgumentException;
use DateTime;
use TableCrown\Entity\Enumerativi\DisponibilitaProdotto;
use TableCrown\Entity\Enumerativi\Categoria;

#[ORM\Entity]
#[ORM\Table(name: "gioco_da_tavolo")]
class EGiocoDaTavolo extends EProdotto {
    // Proprietà specifiche per il gioco da tavolo
    #[ORM\Column(type: "json")] //json è un tipo di dato che consente di serializzare e deserializzare un array in un formato leggibile e scrivibile
    private array $categoria; //es. strategia, famiglia, party game, ecc. (può essere un array di categorie, un gioco da tavolo può appartenere a più categorie)

    #[ORM\Column(type: "json")]
    private array $componenti; //elenco dei componenti del gioco (carte, pedine, tabellone, ecc.)

    #[ORM\ManyToOne(targetEntity: EGiocoDaTavolo::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?EGiocoDaTavolo $giocoBase = null; //riferimento a un eventuale gioco da tavolo di cui è espansione

    #[ORM\Column(type: "integer")]
    private int $numeroGiocatoriMin;

    #[ORM\Column(type: "integer")]
    private int $numeroGiocatoriMax;

    #[ORM\Column(type: "integer")]
    private int $etaMinima;

    #[ORM\Column(type: "integer")]
    private int $durataMedia; //in minuti

    #[ORM\ManyToOne(targetEntity: EDanno::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?EDanno $danno; //danno del gioco, se presente

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $descrizioneDanno; //descrizione del danno, se presente

    //Il costruttore, per effettuare i controlli sui vincoli, chiama al suo interno i metodi di verifica dei vincoli, che lanciano un'eccezione se i vincoli non sono rispettati
    public function __construct(string $nomeProdotto, string $descrizioneProdotto, DisponibilitaProdotto $disponibilitaProdotto, int $quantita, array $categoria, array $componenti, ?string $imgProdotto = null, ?EPrezzo $prezzo = null, ?EGiocoDaTavolo $giocoBase = null, int $numeroGiocatoriMin = 1, int $numeroGiocatoriMax = 1, int $etaMinima = 1, int $durataMedia = 1, ?EDanno $danno = null, ?string $descrizioneDanno = null) {
        parent::__construct($nomeProdotto, $descrizioneProdotto, $disponibilitaProdotto, $quantita, $imgProdotto, $prezzo);
        $this->categoria = $categoria;
        $this->verificaCategoria(); //se fallisce, l'eccezione viene lanciata e il gioco da tavolo non viene creato (per tutti i metodi di verifica)
        $this->componenti = $componenti;
        $this->verificaComponenti();
        $this->giocoBase = $giocoBase;
        $this->verificaVincoliEspansione();
        $this->numeroGiocatoriMin = $numeroGiocatoriMin;
        $this->numeroGiocatoriMax = $numeroGiocatoriMax;
        $this->verificaNumGiocatori();
        $this->etaMinima = $etaMinima;
        $this->verificaEtaMinima();
        $this->durataMedia = $durataMedia;
        $this->verificaDurataMedia();
        $this->danno = $danno;
        $this->descrizioneDanno = $descrizioneDanno;
        $this->verificaDanno();
        }

    //GET methods
    public function getCategoria(): array {
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

    //Metodi di dominio

    /**
     * Aggiunge una categoria al gioco da tavolo.
     */
    public function aggiungiCategoria(Categoria $categoria): void {
        if (!in_array($categoria, $this->categoria)) {
            $this->categoria[] = $categoria;
        }
    }

    /**
     * Rimuove una categoria dal gioco da tavolo.
     */
    public function rimuoviCategoria(Categoria $categoria): void {
        $key = array_search($categoria, $this->categoria);
        if ($key !== false) {
            unset($this->categoria[$key]);
        }
    }

    /**
     * Aggiunge un componente al gioco da tavolo.
     */
    public function aggiungiComponente(string $componente): void {
        $componente = trim($componente);
        if ($componente !== "" && !in_array($componente, $this->componenti)) {
            $this->componenti[] = $componente;
        }
    }

    /**
     * Rimuove un componente dal gioco da tavolo.
     */
    public function rimuoviComponente(string $componente): void {
        $key = array_search($componente, $this->componenti);
        if ($key !== false) {
            unset($this->componenti[$key]);
        }
    }

    /**
     * Aggiungi un danno al gioco da tavolo.
     * Se è già presente un danno, sovrascrive il danno esistente.
     * Quando si aggiunge un danno, è necessario fornire anche una descrizione del danno, che non può essere vuota.
     */
    public function aggiungiDanno(EDanno $danno, string $descrizioneDanno): void {
        if (trim($descrizioneDanno) === "") {
            throw new InvalidArgumentException("La descrizione del danno non può essere vuota.");
        }
        $this->danno = $danno;
        $this->descrizioneDanno = trim($descrizioneDanno);
    }

    /**
     * Metodo di validazione del danno. (Private perché viene chiamato solo all'interno del costruttore e dei metodi che modificano il danno, per garantire che i vincoli vengano sempre rispettati; come per tutti gli altri metodi di verifica dei vincoli)
     * Controlla che vengano rispettati i vincoli relativi al danno, ovvero che se è presente un danno, sia presente anche una descrizione del danno, e che la descrizione del danno non sia vuota.
     */
    private function verificaDanno(): void {
        if ($this->danno !== null) {
            if (trim($this->descrizioneDanno) === "") {
                throw new InvalidArgumentException("La descrizione del danno non può essere vuota se è presente un danno.");
            }
        } else {
            if ($this->descrizioneDanno !== null) {
                throw new InvalidArgumentException("Non può essere presente una descrizione del danno se non è presente un danno.");
            }
        }
    }

    /**
     * Controlla che vengano rispettati i vincoli relativi alle espansioni.
     * Se il gioco da tavolo è un'espansione, verifica che il gioco base non sia a sua volta un'espansione e che non sia lo stesso gioco da tavolo.
     */
    private function verificaVincoliEspansione(): void {
        if ($this->giocoBase !== null) {
            if ($this->giocoBase->getGiocoBase() !== null) {
                throw new InvalidArgumentException("Il gioco base non può essere a sua volta un'espansione.");
            }
            if ($this->giocoBase->getIdProdotto() === $this->getIdProdotto()) {
                throw new InvalidArgumentException("Un gioco da tavolo non può essere un'espansione di se stesso.");
            }
        }
    }

    /**
     * Controlla che vengano rispettati i vincoli relativi al numero minimo e massimo di giocatori.
     * Il numero minimo di giocatori deve essere maggiore di 0 e minore o uguale al numero massimo di giocatori.
     */
    private function verificaNumGiocatori(): void {
        if ($this->numeroGiocatoriMin <= 0) {
            throw new InvalidArgumentException("Il numero minimo di giocatori deve essere maggiore di 0.");
        }
        if ($this->numeroGiocatoriMin > $this->numeroGiocatoriMax) {
            throw new InvalidArgumentException("Il numero minimo di giocatori non può essere maggiore del numero massimo di giocatori.");
        }
    }
    

    /**
     * Controlla che vengano rispettati i vincoli relativi all'età minima.
     * L'età minima deve essere maggiore di 0.
     */
    private function verificaEtaMinima(): void {
        if ($this->etaMinima <= 0) {
            throw new InvalidArgumentException("L'età minima deve essere maggiore di 0.");
        }
    }

    /**
     * Controlla che vengano rispettati i vincoli relativi alla durata media.
     * La durata media deve essere maggiore di 0.
     */
    private function verificaDurataMedia(): void {
        if ($this->durataMedia <= 0) {
            throw new InvalidArgumentException("La durata media deve essere maggiore di 0.");
        }
    }

    /**
     * Verifica della categoria del gioco da tavolo.
     */
    private function verificaCategoria(): void {
        if (empty($this->categoria)) {
            throw new InvalidArgumentException("Il gioco da tavolo deve appartenere ad almeno una categoria.");
        }
    }

    /**
     * Verifica dei componenti del gioco da tavolo.
     */
    private function verificaComponenti(): void {
        if (empty($this->componenti)) {
            throw new InvalidArgumentException("Il gioco da tavolo deve avere almeno un componente.");
        }
    }
    
}