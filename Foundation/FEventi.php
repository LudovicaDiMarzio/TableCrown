<?php
namespace TableCrown\Foundation;

use TableCrown\Entity\EEvento;
use TableCrown\Entity\Enumerativi\StatoEvento;
use Exception;

class FEventi{
    public static function ricercaEventi(?string $ricerca): array{
        try{
            $em = FEntityManager::getInstance()->getEntityManager();
            $qb = $em->createQueryBuilder();

            $qb->select('e')
               ->from(EEvento::class, 'e')
               ->where('e.statoEvento = :statoEvento')
               ->setParameter('statoEvento', StatoEvento::Programmato)
               ->andWhere('e.nome LIKE :testo')
               ->setParameter('testo', '%' . $ricerca . '%')
               ->orderBy('e.dataInizio', 'ASC');

            return $qb->getQuery()->getResult();
            
        }
        catch(Exception $e){
            error_log("Errore in ricercaEventi: " . $e->getMessage());
            return [];
        }
    }

    public static function getProssimiEventi(int $limit): array{
        try{
            $qb=FEntityManager::getInstance()->getEntityManager()->createQueryBuilder();
            $qb->select('e')
                ->from(EEvento::class, 'e')
                ->where('e.statoEvento = :statoEvento')
                ->setParameter('statoEvento', StatoEvento::Programmato)
                ->orderBy('e.dataInizio', 'ASC')
                ->setMaxResults($limit);
            $risultati= $qb->getQuery()->getResult();
            return $risultati;

        }
        catch(Exception $e){
            error_log("Errore in getProssimiEventi: " . $e->getMessage());
            return [];
        }
    }
}