<?php
namespace TableCrown\Foundation;

use TableCrown\Entity\EBustine;
use Exception;

class FBustine{
    public static function findBustine(array $filtri, int $limit, int $offset): array
    {
        try{
            $qb=FEntityManager::getInstance()->getEntityManager()->createQueryBuilder();
            $qb->select('b')
                ->from(EBustine::class, 'b');

            //gestione dei filtri sul prezzo

            if (isset($filtri['prezzo_min'])) {
                $qb->andWhere('b.prezzo >= :prezzo_min')
                   ->setParameter('prezzo_min', $filtri['prezzo_min']);
            }

            if (isset($filtiri['prezzo_max'])){
                $qb->andwhere('b.prezzo <= :prezzo_max')
                   ->setParameter('prezzo_max', $filtri['prezzo_max']);
            }
            
            //cloniamo la query per poterla modificare ed effettuarci un count
            $qbCount = clone $qb;
            $qbCount->select('count(b.id)');
            $totale = $qbCount->getQuery()->getSingleScalarResult();

            //sulla query iniziale applico le limitazioni per la paginazione
            $qb->setFirstResult($offset)
               ->setMaxResults($limit);
            $risultati = $qb->getQuery()->getResult();

            return [
                //un array con i prodotti filtrati
                'risultati' => $risultati,
                'totale' => $totale
            ];

            //ci sono filtri sulla disponibilità?

        }
        catch(Exception $e){
            error_log("Errore in findBustine: " . $e->getMessage());
            return ['risultati' => [], 'totale' => 0];
        }
    }
}