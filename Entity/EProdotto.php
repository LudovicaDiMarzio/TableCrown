<?php
namespace TableCrown\Entity;
use DateTime;
use InvalidArgumentException;
use TableCrown\Entity\EPrezzo;
use TableCrown\Entity\Enumerativi\DisponibilitaProdotto;
use TableCrown\Entity\ERecensione;

abstract class EProdotto {
    private ?int $idProdotto;
    private string $nomeProdotto;
    private string $imgProdotto; //da rivedere
    private string $descrizioneProdotto;
    private DisponibilitaProdotto $disponibilitaProdotto;
    private int $quantita;
    private DateTime $dataPubblicazione;
    private ?EPrezzo $prezzo; //prezzo del prodotto, se presente
    /** @var ERecensione[] */ //notazione per indicare che si tratta di un array di oggetti ERecensione, serve per la documentazione e per gli strumenti di sviluppo, non è una dichiarazione di tipo formale
    private array $recensioni; //elenco delle recensioni del prodotto

    public function __construct(?int $idProdotto, string $nomeProdotto, string $imgProdotto, string $descrizioneProdotto, DisponibilitaProdotto $disponibilitaProdotto, int $quantita, DateTime $dataPubblicazione, ?EPrezzo $prezzo = null, array $recensioni = []) {
        $this->idProdotto = $idProdotto;
        $this->nomeProdotto = $nomeProdotto;
        $this->imgProdotto = $imgProdotto;
        $this->descrizioneProdotto = $descrizioneProdotto;
        $this->disponibilitaProdotto = $disponibilitaProdotto;
        $this->quantita = $quantita;
        $this->dataPubblicazione = $dataPubblicazione;
        $this->prezzo = $prezzo;
        $this->recensioni = $recensioni;
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

    public function setDisponibilitaProdotto(DisponibilitaProdotto $disponibilita) {
        $this->disponibilitaProdotto = $disponibilita;
    }

    public function setQuantita(int $quantita) {
        $this->quantita = $quantita;
    }

    public function setDataPubblicazione(DateTime $dataPubblicazione) {
        $this->dataPubblicazione = $dataPubblicazione;
    }

    public function setPrezzo(?EPrezzo $prezzo) {
        $this->prezzo = $prezzo;
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

    public function getDisponibilitaProdotto(): DisponibilitaProdotto {
        return $this->disponibilitaProdotto;
    }

    public function getQuantita(): int {
        return $this->quantita;
    }

    public function getDataPubblicazione(): DateTime {
        return $this->dataPubblicazione;
    }

    public function getPrezzo(): ?EPrezzo {
        return $this->prezzo;
    }

    public function getRecensioni(): array {
        return $this->recensioni;
    }

    /**
     * Per le recensioni, visto che si tratta di un array, piuttosto che un setRecensioni, 
     * implemento i metodi per aggiungere e rimuovere recensioni, 
     * in questo modo si evita di sovrascrivere l'intero array di recensioni quando si vuole aggiungere o rimuovere una singola recensione
     */
    public function addRecensione(ERecensione $recensione) {
        $this->recensioni[] = $recensione;
    }

    public function removeRecensione(ERecensione $recensione) {
        $key = array_search($recensione, $this->recensioni); //array_search restituisce la chiave dell'elemento trovato nell'array, o false se non trovato
        if ($key !== false) { //se la recensione è stata trovata nell'array, procedo alla rimozione
            unset($this->recensioni[$key]); //unset rimuove l'elemento dall'array, ma non riorganizza le chiavi, quindi è possibile che si creino "buchi" nell'array, ad esempio se si rimuove l'elemento con chiave 2 da un array con chiavi 0, 1, 2, 3, si otterrà un array con chiavi 0, 1, 3
        }
    }

}
