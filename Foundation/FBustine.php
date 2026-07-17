<?php
namespace TableCrown\Foundation;

use TableCrown\Entity\EBustine;
use TableCrown\Entity\Enumerativi\DisponibilitaProdotto;
use Exception;

class FBustine{

    /**
     * @param array $filtri: un array associativo che contiene i filtri da applicare alla query. Le chiavi dell'array rappresentano i nomi dei filtri, mentre i valori rappresentano i valori dei filtri.
     * @param int $limit: il numero massimo di risultati da restituire. Questo parametro viene utilizzato per implementare la paginazione dei risultati.
     * @param int $offset: il numero di risultati da saltare prima di selezionare i risultati richiesti (utile sempre per la paginazione).
     * @return array con i risultati della ricerca, incluso il numero totale di risultati
     * @throws Exception
     */
    public static function findBustine(array $filtri, int $limit, int $offset): array
    {
        try{
            $qb=FEntityManager::getInstance()->getEntityManager()->createQueryBuilder();
            $qb->select('b', 'pr')
                ->from(EBustine::class, 'b')
                ->innerJoin('b.prezzo', 'pr');

            //gestione dei filtri sul prezzo

            if (isset($filtri['price_min'])) {
                $qb->andWhere('pr.valore >= :price_min')
                   ->setParameter('price_min', $filtri['price_min']);
            }

            if (isset($filtiri['price_max'])){
                $qb->andwhere('pr.valore <= :price_max')
                   ->setParameter('price_max', $filtri['price_max']);
            }

            if (!empty($filtri['disponibilita'])) {
                $qb->andWhere('b.disponibilitaProdotto = :disponibilita')
                    ->setParameter('disponibilita', $filtri['disponibilita']);
            }

               //filtro per l'ordinamento dei risultati
            //usiamo switch case perchè serve la mutua esclusione per l'ordinamento
            if (!empty($filtri['ordinamento'])) {
                switch ($filtri['ordinamento']) {
                    case 'prezzo-asc':
                        $qb->orderBy('pr.valore', 'ASC'); // Dal più economico
                        break;
                    case 'prezzo-desc':
                        $qb->orderBy('pr.valore', 'DESC'); // Dal più costoso
                        break;
                    case 'popolarita':
                        $qb->orderBy('b.numeroVendite', 'DESC'); // dal più venduto al meno venduto
                        break;
                    case 'rating':
                        $qb->orderBy('b.valutazioneMedia', 'DESC'); // Dalla media voto più alta alla più bassa
                        break;
                }
            }
            else {
                //in generale diamo un ordinamento di default per i giochi mostranodli dal più recente al meno recente
                $qb->orderBy('b.dataPubblicazione', 'DESC');
            }

            //posso voler vedere sia le novità che i prodotti in sconto
            if (!empty($filtri['in_evidenza_filtro'])) {
                //recupero i giochi pubblicati nell'ultimo mese e li ordino per data di pubblicazione decrescente (dal più recente al meno recente)
                if (in_array('novita', $filtri['in_evidenza_filtro'])) {
                    $datalimite = new \DateTime();
                    $datalimite->modify('-1 month');
                    $qb->andWhere('b.dataPubblicazione >= :datalimite')
                        ->setParameter('datalimite', $datalimite);
                }   
                
                if (in_array('sconti', $filtri['in_evidenza_filtro'])) {
                    $qb->andWhere('pr.sconto > 0');
                }
            }
            
            //per recuperare i giochi con valutazione media superiore ad una certa soglia
            if (isset ($filtri['rating_min'])&& $filtri['rating_min'] >0) { 
                $qb->andWhere('b.valutazioneMedia >= :ratingMin')
                    ->setParameter('ratingMin', $filtri['rating_min']);
            }
            
            //cloniamo la query per poterla modificare ed effettuarci un count
            $qbCount = clone $qb;
            $qbCount->select('count(b.id)');
            $qbCount->resetDQLPart('orderBy');
            $totale = $qbCount->getQuery()->getSingleScalarResult();
                    
            $qbEstremi = clone $qb;
            $qbEstremi->select('MIN(pr.valore) AS min_price', 'MAX(pr.valore) AS max_price');
            $qbEstremi->resetDQLPart('orderBy');
            $estremi = $qbEstremi->getQuery()->getSingleResult();

            $prezzoMinimo = $estremi['min_price'] !== null ? (float) $estremi['min_price'] : 0.0;
            $prezzoMassimo = $estremi['max_price'] !== null ? (float) $estremi['max_price'] : 50.0;


            //sulla query iniziale applico le limitazioni per la paginazione
            $qb->setFirstResult($offset)
               ->setMaxResults($limit);
            $risultati = $qb->getQuery()->getResult();

            return [
                //un array con i prodotti filtrati
                'risultati' => $risultati,
                'totale' => $totale,
                'rangemin' => $prezzoMinimo,
                'rangemax' => $prezzoMassimo
            ];

            //ci sono filtri sulla disponibilità?

        }
        catch(Exception $e){
            error_log("Errore in findBustine: " . $e->getMessage());
            return ['risultati' => [], 
            'totale' => 0,
            'rangemin' => 0.0,
            'rangemax' => 50.0
            ];
        }
    }
}