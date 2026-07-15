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
     * URL: POST /checkout/acquista
     */
    public function elaboraAcquisto(): void { //DA RIVEDERE, C'è DUPLICAZIONE DEL CODICE (SI PUò OTTIMIZZARE!!!)
        $utente = $this->utenteCorrente();

        //Recuperiamo i dati inviati dal form tramite POST
        $idIndirizzo = UHTTPMethods::postInt('id_indirizzo');
        $sceltaCarta = UHTTPMethods::postString('scelta_carta');
        $idCartaSalvata = UHTTPMethods::postInt('id_carta_salvata');

        if (!$idIndirizzo) {
            UFlashMessage::addMessage('danger', 'È necessario selezionare un indirizzo di spedizione.');
            header('Location: /checkout');
            exit();
        }

        $indirizzo = FPersistentManager::PMgetObjOnAttribute(EIndirizzo::class, 'idIndirizzo', $idIndirizzo);
        if (!$indirizzo || $indirizzo->getUtente()->getIdPersona() !== $utente->getIdPersona()) {
            UFlashMessage::addMessage('danger', 'L\'indirizzo selezionato non è valido.');
            header('Location: /checkout');
            exit();
        }

        //Recupero o creazione della carta di credito per la transazione
        $cartaDaUsare = null;
        $bancaService = new BancaMockService();

        try {
            if ($sceltaCarta === 'salvata') {
                if (!$idCartaSalvata) {
                    throw new \InvalidArgumentException("Seleziona una delle tue carte salvate.");
                }
                $cartaDaUsare = FPersistentManager::PMgetObjOnAttribute(ECartaDiCredito::class, 'idCartaDiCredito', $idCartaSalvata);

                if (!$cartaDaUsare || $cartaDaUsare->getUtente()->getIdPersona() !== $utente->getIdPersona()) {
                    throw new \InvalidArgumentException("La carta selezionata non è valida.");
                }
            } elseif ($sceltaCarta === 'nuova') {
                //Recuperiamo i dati della nuova carta inseriti al momento
                $numeroCarta = UHTTPMethods::postString('numero_carta');
                $cvv = UHTTPMethods::postString('cvv');
                $titolare = UHTTPMethods::postString('titolare_carta');
                $scadenza = UHTTPMethods::postString('scadenza_carta');
                $salvaCarta = UHTTPMethods::postBool('salva_carta_profilo');

                if (empty($numeroCarta) || empty($cvv) || empty($titolare) || empty($scadenza)) {
                    throw new \InvalidArgumentException("Tutti i campi di pagamento sono obbligatori.");
                }

                //Generiamo il token bancario fittizio
                $risultatoToken = $bancaService->generaToken($numeroCarta, $cvv);
                $token = $risultatoToken['token'];
                $ultimeQuattroCifre = $risultatoToken['ultimeQuattroCifre'];

                //Istanziamo la carta
                $cartaDaUsare = new ECartaDiCredito($utente, $titolare, $scadenza, $ultimeQuattroCifre, $token);

                //Se richiesto, la salviamo sul DB
                if ($salvaCarta) {
                    FPersistentManager::PMsaveObj($cartaDaUsare);
                }
            } else {
                throw new \InvalidArgumentException("Seleziona un metodo di pagamento valido.");
            }

            if ($cartaDaUsare->isScaduta()) {
                throw new \InvalidArgumentException("La carta di credito utilizzata è scaduta.");
            }

            //Recupero dei prodotti dal carrello in sessione
            $carrello = USession::getSessionElement('carrello') ?? [];
            if (empty($carrello)) {
                throw new \InvalidArgumentException("Il carrello è vuoto. Impossibile completare l'ordine.");
            }

            $carrelloItems = $this->buildCarrelloItems($carrello);

            //Creazione dell'istanza dell'oggetto ordine
            $ordine = new EOrdine($utente, $indirizzo, $cartaDaUsare);

            //Associazione dei prodotti all'ordine recuperando l'entità dal DB tramite ID
            foreach ($carrelloItems as $item) {
                $idProdotto = $item['prodotto']['id']; //ID dell'array "piatto
                //Recuperiamo l'oggetto reale dal DB
                $prodottoEntity = FPersistentManager::PMgetObjOnAttribute(EProdotto::class, 'idProdotto', $idProdotto);

                if ($prodottoEntity) {
                    $ordine->aggiungiProdotto($prodottoEntity, $item['quantita']);
                } else {
                    throw new Exception("Il prodotto '{$item['prodotto']['nome']}' non è disponibile nel catalogo.");
                }
            }

            //Calcoliamo il totale effettivo (calcolato direttamente dall'entity EOrdine)
            $totaleOrdine = $ordine->calcolaTotale();
            
            //Addebito effettivo tramite il mock della banca
            $pagamentoAvvenuto = $bancaService->effettuaPagamento($cartaDaUsare->getToken(), $totaleOrdine);

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

}