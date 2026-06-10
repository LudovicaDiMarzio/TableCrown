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
    private ?string $imgProdotto;
    private string $descrizioneProdotto;
    private DisponibilitaProdotto $disponibilitaProdotto; //(Disponibile, Non disponibile, Esaurito, In arrivo)
    private int $quantita; //quantità disponibile in magazzino del prodotto, deve essere maggiore o uguale a 0
    private DateTime $dataPubblicazione;
    private ?EPrezzo $prezzo; //prezzo del prodotto, se presente (se il prodotto è esaurito o in arrivo, il prezzo potrebbe non essere disponibile, quindi è nullable)
    /** @var ERecensione[] */ //notazione per indicare che si tratta di un array di oggetti ERecensione, serve per la documentazione e per gli strumenti di sviluppo, non è una dichiarazione di tipo formale
    private array $recensioni; //elenco delle recensioni del prodotto

    public function __construct(?int $idProdotto, string $nomeProdotto, ?string $imgProdotto, string $descrizioneProdotto, DisponibilitaProdotto $disponibilitaProdotto, int $quantita, DateTime $dataPubblicazione, ?EPrezzo $prezzo = null, array $recensioni = []) {
        $this->idProdotto = $idProdotto;
        $this->rinominaProdotto($nomeProdotto); //utilizza il metodo di dominio per validare il nome del prodotto
        $this->aggiornaImg($imgProdotto); //utilizza il metodo di dominio per validare l'immagine del prodotto
        $this->aggiornaDescrizione($descrizioneProdotto); //utilizza il metodo di dominio per validare la descrizione del prodotto
        $this->disponibilitaProdotto = $disponibilitaProdotto;
        $this->aggiornaQuantita($quantita); //utilizza il metodo di dominio per validare la quantità del prodotto
        $this->dataPubblicazione = $dataPubblicazione;
        $this->prezzo = $prezzo;
        $this->recensioni = $recensioni;
    }

    //GET methods
    public function getIdProdotto(): ?int {
        return $this->idProdotto;
    }

    public function getNomeProdotto(): string {
        return $this->nomeProdotto;
    }

    public function getImgProdotto(): ?string {
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

    //Metodi di dominio

    /**
     * Aggiorna il nome del prodotto.
     */
    public function rinominaProdotto(string $nomeProdotto): void {
        if (trim($nomeProdotto) === "") {
            throw new InvalidArgumentException("Il nome del prodotto non può essere vuoto.");
        }
        $this->nomeProdotto = $nomeProdotto;
    }

    /**
     * Aggiorna la descrizione del prodotto.
     */
    public function aggiornaDescrizione(string $descrizioneProdotto): void {
        if (trim($descrizioneProdotto) === "") {
            throw new InvalidArgumentException("La descrizione del prodotto non può essere vuota.");
        }
        $this->descrizioneProdotto = $descrizioneProdotto;
    }

    /**
     * Aggiorna l'immagine del prodotto.
     * Può essere null se si vuole rimuovere l'immagine, ma se non è null, non può essere una stringa vuota.
     */
    public function aggiornaImg(?string $imgProdotto): void {
        if ($imgProdotto !== null && trim($imgProdotto) === "") {
            throw new InvalidArgumentException("L'immagine del prodotto non può essere una stringa vuota.");
        }
        $this->imgProdotto = $imgProdotto;
    }

    /**
     * Aggiorna la quantità disponibile del prodotto.
     * La quantità non può essere negativa.
     * Se la quantità scende a 0, la disponibilità del prodotto viene automaticamente aggiornata a "Esaurito".
     * Se era esaurito e la quantità torna >0, la disponibilità viene aggiornata a "Disponibile".
     */
    public function aggiornaQuantita(int $quantita): void {
        if ($quantita < 0) {
            throw new InvalidArgumentException("La quantità del prodotto non può essere negativa.");
        }
        $this->quantita = $quantita;
        if ($this->quantita === 0) {
            $this->disponibilitaProdotto = DisponibilitaProdotto::Esaurito;
        } elseif ($this->disponibilitaProdotto === DisponibilitaProdotto::Esaurito) {
            $this->disponibilitaProdotto = DisponibilitaProdotto::Disponibile;
        }
    }

    /**
     * Segna il prodotto come disponibile.
     * Non ha senso rendere disponibile un prodotto con quantità 0.
     */
    public function rendiDisponibile(): void {
        if ($this->quantita === 0) {
            throw new InvalidArgumentException("Non è possibile rendere disponibile un prodotto con quantità 0.");
        }
        $this->disponibilitaProdotto = DisponibilitaProdotto::Disponibile;
    }

    /**
     * Segna il prodotto come in arrivo (ordinato ma non ancora disponibile).
     */
    public function rendiInArrivo(): void {
        $this->disponibilitaProdotto = DisponibilitaProdotto::InArrivo;
    }

    /**
     * Rimuove il prodotto dal catalogo attivo.
     * Un prodotto rimosso non è più visibile agli utenti, ma rimane nel database per motivi di integrità referenziale (ad esempio per mantenere le recensioni collegate al prodotto).
     */
    public function rimuoviProdotto(): void {
        $this->disponibilitaProdotto = DisponibilitaProdotto::NonDisponibile;
    }

    /**
     * Assegna o aggiorna il prezzo del prodotto.
     */
    public function assegnaPrezzo(EPrezzo $prezzo): void {
        $this->prezzo = $prezzo;
    }

    /**
     * Rimuove il prezzo del prodotto.
     */
    public function rimuoviPrezzo(): void {
        $this->prezzo = null;
    }

    /**
     * Verifica se il prodotto è attualmente disponibile per l'acquisto.
     */
    public function isAcquistabile(): bool {
        return $this->disponibilitaProdotto === DisponibilitaProdotto::Disponibile && $this->quantita > 0 && $this->prezzo !== null;
    }

    /**
     * Verifica se il prodotto è disponibile.
     */
    public function isDisponibile(): bool {
        return $this->disponibilitaProdotto === DisponibilitaProdotto::Disponibile && $this->quantita > 0;
    }

    /**
     * Aggiunge una recensione al prodotto.
     */
    public function addRecensione(ERecensione $recensione) {
        $this->recensioni[] = $recensione;
    }

    /**
     * Rimuove una recensione dal prodotto.
     */
    public function removeRecensione(ERecensione $recensione) {
        $key = array_search($recensione, $this->recensioni); //array_search restituisce la chiave dell'elemento trovato nell'array, o false se non trovato
        if ($key !== false) { //se la recensione è stata trovata nell'array, procedo alla rimozione
            unset($this->recensioni[$key]); //unset rimuove l'elemento dall'array, ma non riorganizza le chiavi, quindi è possibile che si creino "buchi" nell'array, ad esempio se si rimuove l'elemento con chiave 2 da un array con chiavi 0, 1, 2, 3, si otterrà un array con chiavi 0, 1, 3
        }
    }

}
