<?php
namespace TableCrown\Foundation;

use TableCrown\Entity\ESerata;
use TableCrown\Entity\Enumerativi\StatoEvento;
use DateTime;
use Exception;

class FSerate{

    /**
     * @param DateTime $filtroData data di inizio del filtro
     * @param string $ricerca stringa da ricercare nella colonna nomeEvento
     * @return array di oggetti
     * @throws Exception
     */
    public static function findSerate(?DateTime $filtroData, ?string $ricerca): array{
        try{
            $qb=FEntityManager::getInstance()->getEntityManager()->createQueryBuilder();
            $qb->select('s')
                ->from(ESerata::class, 's')
                ->where('s.statoEvento=:statoEvento')
                ->setParameter('statoEvento', StatoEvento::Programmato);
            
            if ($filtroData !== null) {
                $qb->andWhere('s.dataInizio >= :dataEvento')
                    ->setParameter('dataEvento', $filtroData);
            }

            if ($ricerca !== null) {
                $qb->andWhere('s.nomeEvento LIKE :ricerca')
                    ->setParameter('ricerca', '%' . $ricerca . '%');
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