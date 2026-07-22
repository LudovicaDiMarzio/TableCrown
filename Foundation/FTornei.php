<?php
namespace TableCrown\Foundation;

use TableCrown\Entity\ETorneo;
use TableCrown\Entity\EBustine;
use TableCrown\Entity\EPortaDadi;
use TableCrown\Entity\EProdotto;
use TableCrown\Entity\Enumerativi\StatoEvento;
use TableCrown\Entity\Enumerativi\DisponibilitaProdotto;
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


    /**
     * @param string $filtroData data di inizio del filtro
     * @return array di oggetti
     * @throws Exception     
     */
    public static function findTorneiGestore(?string $filtroData): array
    {
        try{
            $qb=FEntityManager::getInstance()->getEntityManager()->createQueryBuilder();
            $qb->select('t')
                ->from(ETorneo::class, 't');
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

    /**
     * @return array di oggetti +int
     * @throws Exception
     */
    public static function findPremiTornei(): array {
    try {
        $qb = FEntityManager::getInstance()->getEntityManager()->createQueryBuilder();
        $qb->select('bd')
            ->from(EProdotto::class, 'bd')
            ->where('bd INSTANCE OF ' . EBustine::class . ' OR bd INSTANCE OF ' . EPortaDadi::class)
            ->andWhere('bd.disponibilitaProdotto = :disponibilita')
            ->setParameter('disponibilita', DisponibilitaProdotto::Disponibile)
            ->andWhere('bd.quantita > 0');

        $risultati = $qb->getQuery()->getResult();

        $qbCount = clone $qb;
        $qbCount->select('COUNT(bd.idProdotto)');
        $totale = $qbCount->getQuery()->getSingleScalarResult();

        return [
            'risultati' => $risultati,
            'totale' => (int) $totale
        ];

    } catch (Exception $e) {
        error_log("Errore in findPremiTornei: " . $e->getMessage());
        return ['risultati' => [], 'totale' => 0];
    }
}

}