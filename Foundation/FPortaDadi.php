<?php
namespace TableCrown\Foundation;

use TableCrown\Entity\EPortaDadi;
use Exception;

class FPortaDadi{
    public static function findPortaDadi(array $filtri, int $limit, int $offset): array
    {
        try{
            $qb=FEntityManager::getInstance()->getEntityManager()->createQueryBuilder();
            $qb->select('p')
                ->from(EPortaDadi::class, 'p');

            //gestione dei filtri sul prezzo

            if (isset($filtri['prezzo_min'])) {
                $qb->andWhere('p.prezzo >= :prezzo_min')
                   ->setParameter('prezzo_min', $filtri['prezzo_min']);
            }

            if (isset($filtiri['prezzo_max'])){
                $qb->andwhere('p.prezzo <= :prezzo_max')
                   ->setParameter('prezzo_max', $filtri['prezzo_max']);
            }
            
            //cloniamo la query per poterla modificare ed effettuarci un count
            $qbCount = clone $qb;
            $qbCount->select('count(p.id)');
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
        }
        catch(Exception $e){
            error_log("Errore in findPortaDadi: " . $e->getMessage());
            return ['risultati' => [], 'totale' => 0];
        }
    }
}