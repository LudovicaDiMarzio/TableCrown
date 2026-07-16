<?php
namespace TableCrown\Foundation;

use TableCrown\Entity\ESerata;
use TableCrown\Entity\Enumerativi\StatoEvento;
use DateTime;
use Exception;

class FSerate{

    /**
     * @param string $filtroData data di inizio del filtro
     * @return array di oggetti
     * @throws Exception
     */
    public static function findSerate(?string $filtroData): array{
        try{
            $qb=FEntityManager::getInstance()->getEntityManager()->createQueryBuilder();
            $qb->select('s')
                ->from(ESerata::class, 's')
                ->where('s.statoEvento=:statoEvento')
                ->setParameter('statoEvento', StatoEvento::Programmato);
            
            if ($filtroData !== null) {
                $dataObj = new DateTime($filtroData);
                $qb->andWhere('s.dataInizio >= :dataEvento')
                    ->setParameter('dataEvento', $dataObj);
            }

            $qb->orderBy('s.dataInizio', 'ASC');

            $risultati = $qb->getQuery()->getResult();

            return $risultati;
        }
        catch(Exception $e){
            error_log("Errore in findSerata: " . $e->getMessage());
            return [];
        }
    }    
}