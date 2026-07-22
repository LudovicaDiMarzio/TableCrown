<?php
namespace TableCrown\Foundation;

use TableCrown\Entity\EChallenge;
use TableCrown\Entity\EGiocoDaTavolo;
use TableCrown\Entity\Enumerativi\DisponibilitaProdotto;
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


    /**
     * @param string $filtroData data di inizio del filtro
     * @return array di oggetti
     * @throws Exception
     */
    public static function findChallengeGestore(?string $filtroData): array{
        try{
            $qb=FEntityManager::getInstance()->getEntityManager()->createQueryBuilder();
            $qb->select('c')
                ->from(EChallenge::class, 'c');
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

    /**
     * @return array di oggetti +int
     * @throws Exception
     */
    public static function findPremiChallenge(): array {
        try{
            $qb=FEntityManager::getInstance()->getEntityManager()->createQueryBuilder();
            $qb->select('g')
                ->from(EGiocoDaTavolo::class, 'g')
                ->where('g.disponibilitaProdotto=:disponibilita')
                ->setParameter('disponibilita', DisponibilitaProdotto::Disponibile)
                ->andWhere('g.quantita > 0');

            $risultati = $qb->getQuery()->getResult();

            $qbCount = clone $qb;
            $qbCount->select('COUNT(g.idProdotto)');
            $totale = $qbCount->getQuery()->getSingleScalarResult();

            return [
                'risultati' => $risultati,
                'totale' => $totale
            ];

        }
        catch(Exception $e){
            error_log("Errore in findPremiChallenge: " . $e->getMessage());
            return [
                'risultati' => [],
                'totale' => 0
            ];
        }
    }
}