<?php
namespace TableCrown\Foundation;

use TableCrown\Entity\EUtente;
use TableCrown\Entity\ESegnalazione;
use TableCrown\Entity\Enumerativi\StatoSegnalazione;
use TableCrown\Entity\Enumerativi\StatoUtente;
use Exception;

class FUtente{
    /**
     * @return int numero di utenti totali
     * @throws Exception
     */
    //posso usare getRepository per sfruttare i suoi metodi più veloci per il count
    public static function ContaUtentiTotali(): int {
        try{
            $em = FEntityManager::getInstance()->getEntityManager();
            return $em->getRepository(EUtente::class)->count();
        }
        catch(Exception $e){
            error_log("Errore in contaUtentiTotali: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * @return int numero di utenti nuovi oggi
     * @throws Exception
     */
    public static function contaUtentiNuoviOggi(): int{
        try{
            $qb=FEntityManager::getInstance()->getEntityManager()->createQueryBuilder();
            $qb->select('COUNT(u.idPersona)')
                ->from(EUtente::class, 'u')
                ->where('u.dataRegistrazione>=:dataRegistrazione')
                ->setParameter('dataRegistrazione', new \DateTime('today'));
            $risultato= $qb->getQuery()->getSingleScalarResult();
            //facciamo cat del risultato per evitare errori
            return (int) $risultato;

        }
        catch(Exception $e){
            error_log('Errore in contaUtentiNuoviOggi: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * @return int numero di utenti con sospensione attiva
     * @throws Exception
     */
    public static function contaUtentiSospesiTotali(): int{
        try{
            $qb=FEntityManager::getInstance()->getEntityManager()->createQueryBuilder();
            $qb->select('COUNT(u.idPersona)')
                ->from(EUtente::class, 'u')
                ->where('u.stato=:statoUtente')
                ->setParameter('statoUtente', StatoUtente::SOSPESO);
            $risultato= $qb->getQuery()->getSingleScalarResult();
            return $risultato;
        }
        catch(Exception $e){
            error_log('Errore in contaUtentiSOspesiTotali: ' . $e->getMessage());
            return 0;
        }
    }

    
    /**
     * @param string $ordinamento ordinamento degli utenti in base al numero di segnalazioni
     * @return array array di utenti e numero segnalazione per utente 
     * @throws Exception
     */
    public static function findUtentiConRecensioniSegnalate(string $ordinamento): array{
        try{
            $qb=FEntityManager::getInstance()->getEntityManager()->createQueryBuilder();
            $qb->select('u','COUNT(s.idsegnalazione) AS numeroSegnalazioni')
                ->from(ESegnalazione::class, 's')
                ->join('s.utente', 'u')
                ->where('s.statosegnalazione=:stato')
                ->setParameter('stato', StatoSegnalazione::IN_ATTESA)
                ->groupBy('u.idPersona')
                ->orderBy('numeroSegnalazioni', $ordinamento);
            //sono della tipologia [0 => EUtente, numeroSegnalazioni => int]
            $risultatiGrezzi = $qb->getQuery()->getResult();

            //creo array associativo con risultati e numerototale per utente
            $risultati= array_map(fn($riga)=>[
                    'utente' => $riga[0],
                    'numeroSegnalazioni' => (int )$riga['numeroSegnalazioni']], $risultatiGrezzi
            );

            

            return [
                'risultati' => $risultati,
                'totale' => count($risultati)
            ];

        }
        catch(Exception $e){
            error_log('Errore in findUtentiConRecensioniSegnalate: ' . $e->getMessage());
            return [
                'risultati' => [],
                'totale' => 0
            ];
        }
    }

    public static function getRecensioniSegnalateDiUtente(int $idUtente): array{
        try{
            $qb=FEntityManager::getInstance()->getEntityManager()->createQueryBuilder();
            $qb->select('DISTINCT r')
                ->from(ESegnalazione::class, 's')
                ->join('s.recensione', 'r')
                ->where('s.utente = :idUtente')
                ->andWhere('s.statosegnalazione = :stato')
                ->setParameter('idUtente', $idUtente)
                ->setParameter('stato', StatoSegnalazione::IN_ATTESA);
            
            $risultati = $qb->getQuery()->getResult();
            return $risultati;
                
        }
        catch(Exception $e){
            error_log('Errore in getRecensioniSegnalateDiUtente: ' . $e->getMessage());
            return [];
        }
    
    }




}