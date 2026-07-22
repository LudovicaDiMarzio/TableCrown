<?php
namespace TableCrown\Foundation;

use TableCrown\Entity\ESegnalazione;
use TableCrown\Entity\ERecensione;
use TableCrown\Entity\EProvvedimento;
use TableCrown\Entity\Enumerativi\GravitaMotivazione;
use TableCrown\Entity\Enumerativi\TipoProvvedimento;
use TableCrown\Entity\Enumerativi\StatoSegnalazione;
use Exception;

class FSegnalazione{
    
    /**
     * @return int numero di sospensioni assegnate oggi
     * @throws Exception     
     */
    public static function contaUtentiSospesiOggi(): int{
        try{
            $qb=FEntityManager::getInstance()->getEntityManager()->createQueryBuilder();
            $qb->select('COUNT(p.idprovvediemnto)')
                ->from(EProvvedimento::class, 'p')
                ->where('p.tipoprovvedimento=:tipo')
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

    /**
     * @param string $order 'ASC' = più urgenti prima (ALTA -> MEDIA -> BASSA), 'DESC' = inverso
     * @param int $limit numero massimo di segnalazioni da restituire
     * @return array di oggetti ESegnalazione
     * @throws Exception
     */
    public static function getSegnalazioniUrgenti(string $order, int $limit = 5): array {
        try {
            $qb = FEntityManager::getInstance()->getEntityManager()->createQueryBuilder();

            $qb->select('s')
                //creo una colonna nascosta che mi permette di ordinare le segnalazioni in base alla gravità della motivazione
                ->addSelect(
                    "CASE WHEN m.gravita = :alta THEN 1 " .
                    "WHEN m.gravita = :media THEN 2 " .
                    "ELSE 3 END AS HIDDEN gravitaOrdine"
                )
                ->from(ESegnalazione::class, 's')
                ->join('s.motivazione', 'm')
                ->where('s.statosegnalazione = :stato')
                ->setParameter('stato', StatoSegnalazione::IN_ATTESA)
                ->setParameter('alta', GravitaMotivazione::ALTA)
                ->setParameter('media', GravitaMotivazione::MEDIA)
                ->orderBy('gravitaOrdine', $order)
                ->setMaxResults($limit);

            return $qb->getQuery()->getResult();
        } catch (Exception $e) {
            error_log('Errore in getSegnalazioniUrgenti: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * @return int numero di segnalazioni in attesa
     * @throws Exception
     */
    public static function contaSegnalazioniInSospeso(): int {
        try{
            $qb=FEntityManager::getInstance()->getEntityManager()->createQueryBuilder();
            $qb->select('COUNT(s.idsegnalazione)')
                ->from(ESegnalazione::class, 's')
                ->where('s.statosegnalazione=:stato')
                ->setParameter('stato', StatoSegnalazione::IN_ATTESA);
            $risultato= $qb->getQuery()->getSingleScalarResult();
            return $risultato;
        }
        catch(Exception $e){
            error_log('Errore in contaSegnalazioniInSospeso: ' . $e->getMessage());
            return 0;
        }
    }
    

    /**
     * @param string $ordinamento ordiniamo in base al numero di segnalazioni ricevute
     * @return array di oggetti
     * @throws Exception
     */
    public static function findRecensioniConSegnalazione(string $ordinamento): array {
        try{
            $qb=FEntityManager::getInstance()->getEntityManager()->createQueryBuilder();
            $qb->select('r', 'COUNT(s.idsegnalazione) AS numerosegnalazioni')
                ->from(ERecensione::class, 'r')
                ->join('r.segnalazioni', 's')
                ->where('s.statosegnalazione=:stato')
                ->setParameter('stato', StatoSegnalazione::IN_ATTESA)
                ->groupBy('r.idRecensione')
                ->orderBy('numerosegnalazioni', $ordinamento);
            $risultatiGrezzi = $qb->getQuery()->getResult();

            //creo array associativo con risultati e numerototale per utente
            $risultati= array_map(fn($riga)=>[
                    'recensione' => $riga[0],
                    'numerosegnalazioni' => (int )$riga['numerosegnalazioni']], $risultatiGrezzi
            );
            return [
                'risultati' => $risultati,
                'totale' => count($risultati)
            ];
        }

        catch(Exception $e){
            error_log('Errore in findRecensioniConSegnalazione: ' . $e->getMessage());
            return [
                'risultati' => [],
                'totale' => 0
            ];
        }   
    }
}