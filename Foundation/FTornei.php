<?php
namespace TableCrown\Foundation;

use TableCrown\Entity\ETorneo;
use TableCrown\Entity\Enumerativi\StatoEvento;
use DateTime;
use Exception;

class FTornei{
    /**
     * @param DateTime $filtroData data di inizio del filtro
     * @param string $ricerca stringa da ricercare nella colonna nomeEvento
     * @return array di oggetti
     * @throws Exception     
     */
    public static function findTornei(?DateTime $filtroData, ?string $ricerca): array
    {
        try{
            $qb=FEntityManager::getInstance()->getEntityManager()->createQueryBuilder();
            $qb->select('t')
                ->from(ETorneo::class, 't')
                ->where('t.statoEvento=:statoEvento')
                  ->setParameter('statoEvento', StatoEvento::Programmato);
            if($filtroData!==null){
                $qb->andWhere('t.dataInizio>=:dataEvento')
                    ->setParameter('dataEvento', $filtroData);
            }
            if ($ricerca !== null) {
                $qb->andWhere('t.nomeEvento LIKE :ricerca')
                    ->setParameter('ricerca', '%' . $ricerca . '%');
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