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
}