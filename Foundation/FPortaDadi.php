<?php
namespace TableCrown\Foundation;

use TableCrown\Entity\EPortaDadi;
<<<<<<< HEAD
use TableCrown\Entity\Enumerativi\DisponibilitaProdotto;
=======
>>>>>>> develop
use Exception;

class FPortaDadi{

    /**
     * @param array $filtri: un array associativo che contiene i filtri da applicare alla query. Le chiavi dell'array rappresentano i nomi dei filtri, mentre i valori rappresentano i valori dei filtri.
     * @param int $limit: il numero massimo di risultati da restituire. Questo parametro viene utilizzato per implementare la paginazione dei risultati.
     * @param int $offset: il numero di risultati da saltare prima di selezionare i risultati richiesti (utile sempre per la paginazione).
     * @return array con i risultati della ricerca, incluso il numero totale di risultati
     * @throws Exception
     */
    public static function findPortaDadi(array $filtri, int $limit, int $offset): array
    {
        try{
            $qb=FEntityManager::getInstance()->getEntityManager()->createQueryBuilder();
            $qb->select('p')
                ->from(EPortaDadi::class, 'p');

            //gestione dei filtri sul prezzo

            if (isset($filtri['prezzo_min'])) {
                $qb->andWhere('p.prezzo >= :prezzo_min')
                   ->setParameter('prezzo_min', $filtri['prezzo_min']);
            }

            if (isset($filtiri['prezzo_max'])){
                $qb->andwhere('p.prezzo <= :prezzo_max')
                   ->setParameter('prezzo_max', $filtri['prezzo_max']);
            }
<<<<<<< HEAD

            if (isset($filtri['disponibilita'])) {
                $disponibilitaEnum = DisponibilitaProdotto::tryFrom($filtri['disponibilita']);
                if ($disponibilitaEnum === null) {
                    throw new Exception("La stringa passata non corrsiponde a nessun enumerativo");
                }
                else{
                    $qb->andWhere('p.disponibilitaProdotto = :disponibilita')
                        ->setParameter('disponibilita', $filtri['disponibilita']);
                }
            }
=======
>>>>>>> develop
            
            //cloniamo la query per poterla modificare ed effettuarci un count
            $qbCount = clone $qb;
            $qbCount->select('count(p.id)');
            $totale = $qbCount->getQuery()->getSingleScalarResult();

            //sulla query iniziale applico le limitazioni per la paginazione
            $qb->setFirstResult($offset)
               ->setMaxResults($limit);
            $risultati = $qb->getQuery()->getResult();

<<<<<<< HEAD


=======
>>>>>>> develop
            return [
                //un array con i prodotti filtrati
                'risultati' => $risultati,
                'totale' => $totale
            ];
        }
        catch(Exception $e){
            error_log("Errore in findPortaDadi: " . $e->getMessage());
            return ['risultati' => [], 'totale' => 0];
        }
    }
}