<?php
namespace TableCrown\Foundation;

use TableCrown\Entity\EChallenge;
use TableCrown\Entity\Enumerativi\StatoEvento;
use DateTime;
use Exception;

class FChallenge{
    /**
     * @param string $filtroData data di inizio del filtro
     * @return array di oggetti
     * @throws Exception
     */
    public static function findChallenge(?string $filtroData): array{
        try{
            $qb=FEntityManager::getInstance()->getEntityManager()->createQueryBuilder();
            $qb->select('c')
                ->from(EChallenge::class, 'c')
                ->where('c.statoEvento=:statoEvento')
                ->setParameter('statoEvento', StatoEvento::Programmato);
            if($filtroData!==null){
                $dataObj = new \DateTime($filtroData);
                $qb->andWhere('c.dataInizio>=:dataEvento')
                    ->setParameter('dataEvento', $dataObj);
            }
        
            $qb->orderBy('c.dataInizio', 'ASC');
            $risultati = $qb->getQuery()->getResult();
            return $risultati;
        }
        catch(Exception $e){
            error_log("Errore in findChallenge: " . $e->getMessage());
            return [];
        }
    }
}