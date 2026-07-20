<?php
namespace TableCrown\Foundation;

use TableCrown\Entity\EOrdine;
use TableCrown\Entity\EOrdineItem;
use TableCrown\Entity\Enumerativi\StatoOrdine;
use Exception;

class FOrdini{
    /**
     * @return int numero di ordini totali
     * @throws Exception
     */
    public static function contaOrdiniTotali(): int{
        try{
            $em = FEntityManager::getInstance()->getEntityManager();
            return $em->getRepository(EOrdine::class)->count([]);
        }
        catch(Exception $e){
            error_log("Errore in contaOrdiniTotali: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * @return int numero totale vendite (in euro)
     * @throws Exception
     */
    public static function contaVenditeTotali(): float{
        try{
            $qb=FEntityManager::getInstance()->getEntityManager()->createQueryBuilder();
            //1-oi.scontoApplicato/100 per caclolare il prezzo scontato, se è il 20%, 1-0.2=0.8, quindi il mio prodotto vale l'80% (è stato scontato del 20%)
            $qb->select('SUM(oi.quantita*oi.prezzoUnitario*(1-(oi.scontoApplicato/100))) AS totale') 
                ->from(EOrdineItem::class, 'oi')
                ->join('oi.ordine', 'o')
                ->where('o.stato=:stato')
                ->setParameter('stato', StatoOrdine::CONSEGNATO);

            $risultato= $qb->getQuery()->getSingleScalarResult();
            return (float) ($risultato ?? 0.0);
        }
        catch(Exception $e){
            error_log("Errore in contaVenditeTotali: " . $e->getMessage());
            return 0.0;
        }
    }
}
