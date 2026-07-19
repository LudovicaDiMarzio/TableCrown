<?php
namespace TableCrown\Foundation;

use TableCrown\Entity\ESegnalazione;
use TableCrown\Entity\EProvvedimento;
use TableCrown\Entity\Enumerativi\TipoProvvedimento;
use TableCrown\Entity\Enumerativi\StatoSegnalazione;
use TableCrown\Entity\Enumerativi\StatoUtente;
use Exception;

class FSegnalazione{
    
    /**
     * @return int numero di utenti con sospensione attiva oggi
     * @throws Exception     
     */
    public static function contaUtentiSospesiOggi(): int{
        try{
            $qb=FEntityManager::getInstance()->getEntityManager()->createQueryBuilder();
            $qb->select('COUNT(p.idProvvediemnto)')
                ->from(EProvvedimento::class, 'p')
                ->where('p.TipoProvvedimento=:tipo')
                ->andWhere('p.dataemissione>=:data')
                ->setParameter('tipo', TipoProvvedimento::SOSPENSIONE)
                ->setParameter('data', new \DateTime('today'));
            $risultato= $qb->getQuery()->getSingleScalarResult();
            return $risultato;
        }
        catch(Exception $e){
            error_log('Errore in contaUtentiSOspesiOggi: ' . $e->getMessage());
            return 0;
        }
    }

    

}