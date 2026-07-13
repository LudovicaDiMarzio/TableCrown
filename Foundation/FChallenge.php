<?php
namespace TableCrown\Foundation;

use TableCrown\Entity\EChallenge;
use TableCrown\Entity\Enumerativi\StatoEvento;
use DateTime;
use Exception;

class FChallenge{
    /**
     * @param DateTime $filtroData data di inizio del filtro
     * @param string $ricerca stringa da ricercare nella colonna nomeEvento
     * @return array di oggetti
     * @throws Exception
     */
    public static function findChallenge(?DateTime $filtroData, ?string $ricerca): array{
        try{
            $qb=FEntityManager::getInstance()->getEntityManager()->createQueryBuilder();
            $qb->select('c')
                ->from(EChallenge::class, 'c')
                ->where('c.statoEvento=:statoEvento')
                ->setParameter('statoEvento', StatoEvento::Programmato);
            if($filtroData!==null){
                $qb->andWhere('c.dataInizio>=:dataEvento')
                    ->setParameter('dataEvento', $filtroData);
            }
            if ($ricerca !== null) {
                $qb->andWhere('c.nomeEvento LIKE :ricerca')
                    ->setParameter('ricerca', '%' . $ricerca . '%');
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