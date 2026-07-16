<?php
namespace TableCrown\Foundation;

use TableCrown\Entity\ETorneo;
use TableCrown\Entity\Enumerativi\StatoEvento;
use DateTime;
use Exception;

class FTornei{
    /**
     * @param string $filtroData data di inizio del filtro
     * @return array di oggetti
     * @throws Exception     
     */
    public static function findTornei(?string $filtroData): array
    {
        try{
            $qb=FEntityManager::getInstance()->getEntityManager()->createQueryBuilder();
            $qb->select('t')
                ->from(ETorneo::class, 't')
                ->where('t.statoEvento=:statoEvento')
                  ->setParameter('statoEvento', StatoEvento::Programmato);
            if($filtroData!==null){
                $dataObj = new DateTime($filtroData);
                $qb->andWhere('t.dataInizio>=:dataEvento')
                    ->setParameter('dataEvento', $dataObj);
            }
    
            $qb->orderBy('t.dataInizio', 'ASC');
            $risultati = $qb->getQuery()->getResult();
            return $risultati;
        }
        catch(Exception $e){
            error_log("Errore in findTornei: " . $e->getMessage());
            return [];
        }
    }

}