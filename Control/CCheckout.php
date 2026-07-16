<?php
namespace TableCrown\Control;

use TableCrown\Utility\USession;
use TableCrown\Utility\UHTTPMethods;
use TableCrown\Utility\UFlashMessage;
use TableCrown\Foundation\BancaMockService;
use TableCrown\Entity\EOrdine;
use TableCrown\Entity\ECartaDiCredito;
use TableCrown\Entity\EProdotto;
use TableCrown\Entity\EIndirizzo;
use TableCrown\Entity\EUtente;
use TableCrown\Foundation\FPersistentManager;
use TableCrown\Presentation\Views\ViewCheckout;
use Exception;
use InvalidArgumentException;

/**
 * Controller deputato alla gestione del processo di acquisto (checkout) dei prodotti nel catalogo.
 * Nota: i pagamenti relativi alle quote di iscrizione degli eventi sono invece
 * gestiti in CDettaglioEvento.
 */
class CCheckout extends BaseController {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Mostra la pagina di checkout con il riepilogo del carrello,
     * indirizzi e carte salvate.
     * URL: GET /checkout
     */
    public function mostraCheckout(): void {
        $utente = $this->utenteCorrente();

        //Recuperiamo il carrello dalla sessione
        $carrello = USession::getSessionElement('carrello') ?? [];
        if (empty($carrello)) {
            UFlashMessage::addMessage('danger', 'Il tuo carrello è vuoto. Aggiungi dei prodotto prima di procedere.');
            header('Location: /catalogo/giochi-da-tavolo');
            exit();
        }

        //Recuperiamo le entità reali dei prodotti nel carrello e calcoliamo il totale provvisorio (centralizzato nel BaseController)
        $carrelloItems = $this->buildCarrelloItems($carrello);
        $carrelloSummary = $this->buildCarrelloSummary($carrelloItems, $carrello);

        //Prepariamo la lista dei prodotti, convertendoli per il template
        $prodottiCheckout = [];
        foreach ($carrelloItems as $item) {
            $prodottiCheckout[] = [
                'prodotto' => $item['prodotto'],
                'quantita' => $item['quantita'],
                'prezzoScontato' => $item['prodotto']['prezzo_scontato'],
                'subtotale' => $item['subtotale'],
            ];
        }

        $indirizziUtente = FPersistentManager::PMgetObjListOnAttribute(EIndirizzo::class, 'utente', $utente);

        //Ordianiamo gli indirizzi facendo in modo che l'indirizzo predefinito, se c'è, sia il primo dell'elenco
        $indirizzoPredefinito = null;
        $altriIndirizzi = [];

        foreach ($indirizziUtente as $indirizzo) {
            if ($indirizzo->isPredefinito()) {
                $indirizzoPredefinito = $indirizzo;
            } else {
                $altriIndirizzi[] = $indirizzo;
            }
        }

        //Ricostruiamo la lista ordinata: se c'è un predefinito va in cima, seguito dagli altri
        $indirizziOrdinati = [];
        if ($indirizzoPredefinito !== null) {
            $indirizziOrdinati[] = $indirizzoPredefinito;
        }
        foreach ($altriIndirizzi as $ind) {
            $indirizziOrdinati[] = $ind;
        }

        //Recuperiamo le carte
        $carteUtente = FPersistentManager::PMgetObjListOnAttribute(ECartaDiCredito::class, 'utente', $utente);

        $datiPagina = [
            'vista' => 'checkout',
            'prodotti_carrello' => $prodottiCheckout,
            'totale_carrello' => $carrelloSummary['totale'],
            'indirizzi' => $this->indirizziToArray($indirizziOrdinati),
            'carte' => $this->carteToArray($carteUtente),
        ];

        $datiLayout = $this->preparaDatiLayout('checkout', $datiPagina);
        ViewCheckout::mostraCheckout($datiLayout);
        
    }

    /**
     * La risoluzione di indirizzo e carta è stata estratta in due metodi privati dedicati.
     * Qui restano solo l'orchestrazione dell'ordine e la gestione degli esiti.
     * URL: POST /checkout/acquista
     */
    public function elaboraAcquisto(): void {
        $utente = $this->utenteCorrente();
        $bancaService = new BancaMockService();

        try {
            $indirizzo = $this->risolviIndirizzo(UHTTPMethods::postInt('id_indirizzo'), $utente);

            $carta = $this->risolviCartaPagamento(UHTTPMethods::postString('scelta_carta'), UHTTPMethods::postInt('id_carta_salvata'), $utente, $bancaService);

            //Recupero dei prodotti dal carrello in sessione
            $carrello = USession::getSessionElement('carrello') ?? [];
            if (empty($carrello)) {
                throw new \InvalidArgumentException("Il carrello è vuoto. Impossibile completare l'ordine.");
            }

            $righeCarrello = $this->buildCarrelloEntities($carrello);

            if (empty($righeCarrello)) {
                //Difensivo: può succedere se tutti i prodotti nel carrello sono stati rimossi
                //dal catalogo nel frattempo (buildCarrelloEntities li ha già ripuliti dalla sessione)
                throw new \InvalidArgumentException("Nessuno dei prodotti nel carrello è più disponibile.");
            }

            //Creazione e popolamento dell'ordine
            $ordine = new EOrdine($utente, $indirizzo, $carta);

            //Associazione dei prodotti all'ordine
            foreach ($righeCarrello as $riga) {
                $ordine->aggiungiProdotto($riga['prodotto'], $riga['quantita']);
            }
            
            //Addebito effettivo tramite il mock della banca
            $pagamentoAvvenuto = $bancaService->effettuaPagamento($carta->getToken(), $ordine->calcolaTotale());

            if (!$pagamentoAvvenuto) {
                throw new \RuntimeException("Si è verificato un errore durante la transazione.");
            }

            //Salvataggio dell'ordine e dei suoi elementi nel DB
            $ordineSalvato = FPersistentManager::PMsaveObj($ordine);

            if (!$ordineSalvato) {
                throw new \RuntimeException("Si è verificato un errore durante il salvataggio dell'ordine.");
            }

            //Successo: svuotiamo il carrello in sessione
            USession::unsetSessionElement('carrello');

            UFlashMessage::addMessage('success', 'Acquisto completato con successo!');
            header('Location: /profilo/ordini');
            exit();

        } catch (InvalidArgumentException $e) {
            UFlashMessage::addMessage('danger', 'Errore nei dati: ' . $e->getMessage());
            header('Location: /checkout');
            exit();
        } catch (Exception $e) {
            UFlashMessage::addMessage('danger', 'Si è verificato un errore durante l\'acquisto: ' . $e->getMessage());
            header('Location: /checkout');
            exit();
        }
    }

    //==========================================================================
    // HELPER PRIVATI
    //==========================================================================

    /**
     * Recupera l'indirizzo di spedizione indicato dall'utente e ne verifica la proprietà.
     * Lancia InvalidArgumentException se l'id manca, non esiste, o non appartiene all'utente.
     */
    private function risolviIndirizzo(?int $idIndirizzo, EUtente $utente): EIndirizzo {
        if (!$idIndirizzo) {
            throw new InvalidArgumentException("È necessario selezionare un indirizzo di spedizione.");
        }

        $indirizzo = FPersistentManager::PMgetObjOnAttribute(EIndirizzo::class, 'idIndirizzo', $idIndirizzo);

        if (!$indirizzo || $indirizzo->getUtente()->getIdPersona() !== $utente->getIdPersona()) {
            throw new InvalidArgumentException("L'indirizzo selezionato non è valido.");
        }

        return $indirizzo;
    }

    /**
     * Recupera (se 'salvata') o crea ed eventualmente persiste (se 'nuova') la carta di
     * credito da usare per il pagamento. Centralizza qui anche il controllo di scadenza,
     * che vale per entrambi i casi (per le carte nuove è ridondante col controllo già
     * fatto nel costruttore di ECartaDiCredito, ma lo teniamo per sicurezza e uniformità).
     */
    private function risolviCartaPagamento(string $sceltaCarta, ?int $idCartaSalvata, EUtente $utente, BancaMockService $bancaService): ECartaDiCredito {
        if ($sceltaCarta === 'salvata') {
            if (!$idCartaSalvata) {
                throw new InvalidArgumentException("Seleziona una delle tue carte salvate.");
            }

            $carta = FPersistentManager::PMgetObjOnAttribute(ECartaDiCredito::class, 'idCartaDiCredito', $idCartaSalvata);

            if (!$carta || $carta->getUtente()->getIdPersona() !== $utente->getIdPersona()) {
                throw new InvalidArgumentException("La carta selezionata non è valida.");
            }
        } elseif ($sceltaCarta === 'nuova') {
            //Recuperiamo i dati della nuova carta inseriti al momento
            $numeroCarta = UHTTPMethods::postString('numero_carta');
            $cvv = UHTTPMethods::postString('cvv');
            $titolare = UHTTPMethods::postString('titolare_carta');
            $scadenza = UHTTPMethods::postString('scadenza_carta');
            $salvaCarta = UHTTPMethods::postBool('salva_carta_profilo');

            if (empty($numeroCarta) || empty($cvv) || empty($titolare) || empty($scadenza)) {
                throw new InvalidArgumentException("Tutti i campi di pagamento sono obbligatori.");
            }

            //Generazione del token
            $risultatoToken = $bancaService->generaToken($numeroCarta, $cvv);

            $carta = new ECartaDiCredito($utente, $titolare, $scadenza, $risultatoToken['ultimeQuattroCifre'], $risultatoToken['token']);

            //Salvataggio della carta nel DB
            if ($salvaCarta) {
                FPersistentManager::PMsaveObj($carta);
            }
        } else {
            throw new InvalidArgumentException("Seleziona un metodo di pagamento valido.");
        }

        if ($carta->isScaduta()) {
            throw new InvalidArgumentException("La carta di credito utilizzata è scaduta.");
        }

        return $carta;
    }

}