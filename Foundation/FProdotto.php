<?php
namespace TableCrown\Foundation;

use TableCrown\Entity\EProdotto;
use TableCrown\Entity\EOrdine;
use TableCrown\Entity\EOrdineItem;
use TableCrown\Entity\Enumerativi\StatoOrdine;
use Exception;

class FProdotto{

    

    /**
     *Ritorna tutti i prodotti che hanno uno sconto applicato (sconto > 0) 
    * @param int $limit numero massimo di prodotti da restituire
    * @param int $offset numero di prodotti da saltare dall'inizio della lista
     * @return array di oggetti
     */
    public static function findProdottiInOfferta(int $limit, int $offset): array {
    try {
            $qb=FEntityManager::getInstance()->getEntityManager()->createQueryBuilder();
            //seleziona i prodotti con uno sconto applicato e il corrispondente prezzo
            $qb->select('p', 'pr') 
            ->from(EProdotto::class, 'p')
            ->innerJoin('p.prezzo', 'pr')
            ->where('pr.sconto > 0');
            /*mettiamo un altro parametro di seleizone nella query fatta prima, con CASE WHEN restituiamo 1 se è null e 0 se non è null, per ogni prodotto
            0<1 quindi i prodotti senza scadenzaOfferta (null) verranno messi in fondo alla lista, mentre quelli con scadenzaOfferta (non null) verranno messi in cima alla lista
            AS HIDDEN crea una colonna virtuale, con un alias, che viene usata internamente nella query ma non esiste realmente
            */
            $qb->addSelect('(CASE WHEN pr.scadenzaOfferta IS NULL THEN 1 ELSE 0 END) AS HIDDEN prodottiSenzaScadenza');

            //mettiamo prima tutti i prodotti con scadenza offerta e poi quelli senza 
            $qb->orderBy('prodottiSenzaScadenza', 'ASC');
            //i prodotti con scadenza offerta li ordiniamo per data di scadenza
            $qb->addOrderBy('pr.scadenzaOfferta', 'ASC');

            /*clono la query appena creata per poterla modificare ed effettuare un count su tutti i prodotti filtrati e 
              sapere quanti prodotti sono usciti in tutto dalla query fatta 
            */
            //la clonatura della query viene fatta prima della suddivisione dei risultati per le pagine, perchè altrimenti il count sarebbe falzato e basato sui risultati "limitati" della query
            $qbCount = clone $qb;
            $qbCount->select('count(p.idProdotto)');
            $qbCount->resetDQLPart('orderBy');//questa query ereditava l'order by, ma su una count questo potrebbe portare ad errori quindi l'order by va rimosso
            //poichè count restituisce un numero scalare non possiamo usare il getResult(), ma usiamo il getSingleScalarResult() che restituisce un numero scalare
            $totale = $qbCount->getQuery()->getSingleScalarResult();

            //sulla query effettuata inizialmete applichiamo il limit e l'offset per la paginazione (per dividere i risultati in pagine)
            
            $qb->setFirstResult($offset)
               ->setMaxResults($limit);
            $risultati = $qb->getQuery()->getResult();
            
            return [
                'risultati' => $risultati,
                'totale' => $totale
            ];

            
        } 
        catch (Exception $e) {
            error_log("Errore in findProdottiInOfferta: " . $e->getMessage());
            return [
                'risultati' => [],
                'totale' => 0
            ];
        }
    }

    public static function utenteHasProdotto(int $iduser, int $idprodotto): bool {
        try {
            $qb=FEntityManager::getInstance()->getEntityManager()->createQueryBuilder();
            $qb->select('COUNT(o.idOrdine)')
                ->from(EOrdine::class, 'o')
                ->join('o.ordineItems', 'oi')
                ->join('oi.prodotto', 'p')
                ->where('o.utente = :idUtente')
                ->andWhere('p.idProdotto = :idProdotto') 
                ->andWhere("o.stato = :statoCompletato")
                ->setParameter('idUtente', $iduser)
                ->setParameter('idProdotto', $idprodotto)
                ->setParameter('statoCompletato', StatoOrdine::CONSEGNATO);

            $risultato = (int) $qb->getQuery()->getSingleScalarResult();
            return $risultato > 0;
        }
        catch (Exception $e) {
            error_log("Errore in utenteHasProdotto: " . $e->getMessage());
            return false;
        }
    } 

    public static function findCorrelati(array $prodottiesclusi, int $limit): array {
        try {
            $qb=FEntityManager::getInstance()->getEntityManager()->createQueryBuilder();
            $qb->select(' p')
                ->from(EProdotto::class, 'p')
                //suggeriamo solo i prodotti non esauriti in magazzino
                ->andWhere('p.quantita > 0')
                ->setParameter('esclusi', $prodottiesclusi)
                ->orderBy('p.numeroVendite', 'DESC')
                ->setMaxResults($limit);
            //selezioniamo solo i prodotti che non sono presenti nel carrello dell'utente
            if (!empty($prodottiesclusi)) {
                $qb->andWhere($qb->expr()->notIn('p.idProdotto', ':esclusi'))
                ->setParameter('esclusi', $prodottiesclusi);
            }

                
            $risultati = $qb->getQuery()->getResult();
            return $risultati;
        }
        catch (Exception $e) {
            error_log("Errore in findCorrelati: " . $e->getMessage());
            return [];
        }
    }

    public static function getRangePrezzo(): array{
        try{
            $qb=FEntityManager::getInstance()->getEntityManager()->createQueryBuilder();
            $qb->select('MIN(pr.valore) as min, MAX(pr.valore) as max')
                ->from(EProdotto::class, 'p')
                ->join('p.prezzo', 'pr');
            $risultati = $qb->getQuery()->getSingleResult();
            return $risultati=[
                'min' => (int) $risultati['min'],
                'max' => (int) $risultati['max']
            ];
        }
        catch(Exception $e){
            error_log("Errore in getRangePrezzo: " . $e->getMessage());
            return ['min' => 0, 'max' => 200];

        }
    }
}