<?php
namespace TableCrown\Foundation;

use TableCrown\Entity\EGiocoDaTavolo;
use TableCrown\Entity\Enumerativi\Categoria;
use TableCrown\Entity\Enumerativi\LinguaGioco;
use TableCrown\Entity\Enumerativi\DifficoltaGioco;
use TableCrown\Entity\Enumerativi\LivelloDannoGiochi;
use TableCrown\Entity\Enumerativi\DisponibilitaProdotto;
use Exception;

class FGiocoDaTavolo 
{
    /**
     * @param array $filtri: un array associativo che contiene i filtri da applicare alla query. Le chiavi dell'array rappresentano i nomi dei filtri, mentre i valori rappresentano i valori dei filtri.
     * @param int $limit: il numero massimo di risultati da restituire. Questo parametro viene utilizzato per implementare la paginazione dei risultati.
     * @param int $offset: il numero di risultati da saltare prima di selezionare i risultati richiesti (utile sempre per la paginazione).
     * @return array con i risultati della ricerca, incluso il numero totale di risultati
     * @throws Exception
     */
    public static function findGiochi(array $filtri, int $limit, int $offset): array
    {
        try {
            $qb=FEntityManager::getInstance()->getEntityManager()->createQueryBuilder();
            $qb->select('g', 'pr')
                ->from(EGiocoDaTavolo::class, 'g')
                ->innerJoin('g.prezzo', 'pr');

            //gestione dei filtri dinamica

            if (isset($filtri['difficolta'])){
                // Prova a creare l'Enum. Se la stringa non corrisponde ad uno degli enumerativi, restituisce null
                $difficoltaEnum = DifficoltaGioco::tryFrom($filtri['difficolta']);
                if ($difficoltaEnum === null) {
                    throw new Exception("La stringa passata non corrsiponde a nessun enumerativo");
                } 
                else {
                    $qb->andWhere('g.difficolta = :difficolta')
                        ->setParameter('difficolta', $difficoltaEnum);
                }
            }

            if (!empty($filtri['categoria_selected'])) {
                // Se l'utente ha spuntato [Fantasy, Fantascienza]
                // Doctrine traduce in: WHERE categoria IN ('Fantasy', 'Fantascienza')
                $qb->andWhere($qb->expr()->in('g.categoria', ':categorie'))
                ->setParameter('categorie', $filtri['categoria_selected']);
            }

            if (!empty($filtri['lingua_selected'])) {
                $qb->andWhere($qb->expr()->in('g.lingua', ':lingue'))
                ->setParameter('lingue', $filtri['lingua_selected']);
            }

            if (isset($filtri['price_min'])) {
                $qb->andWhere('g.prezzo >= :price_min')
                   ->setParameter('price_min', $filtri['price_min']);
            }

            if (isset($filtri['price_max'])) {
                $qb->andWhere('g.prezzo <= :price_max')
                   ->setParameter('price_max', $filtri['price_max']);
            }

            
            //se è settato questo filtro e il suo valore è flse mostriamo solo i giochi base (quelli che non hanno riferimento al giooo padre))
            if (isset($filtri['mostra_espansioni']) && $filtri['mostra_espansioni'] === false) {
                $qb->andWhere('g.gioco_base_id IS NULL');
            }

            if (isset($filtri['players_min'])) {
                $qb->andWhere('g.numeroGiocatoriMin = :players_min')
                   ->setParameter('players_min', $filtri['players_min']);
            }

            if (isset($filtri['players_max'])) {
                $qb->andWhere('g.numeroGiocatoriMax = :players_max')
                   ->setParameter('players_max', $filtri['players_max']);
            }

            if (isset($filtri['age_min'])) {
                $qb->andWhere('g.etaMinima = :age_min')
                   ->setParameter('age_min', $filtri['age_min']);
            }

            /*forse non serve, non lo so, non c'è nei filtri 
            if (isset($filtri['durataMedia'])) {
                $qb->andWhere('g.durataMedia = :durataMedia')
                   ->setParameter('durataMedia', $filtri['durataMedia']);
            }
            */

           //usiamo !empty e non isset perchè se il filtro è settato ma è un array vuoto, non vogliamo filtrare nulla
            if (!empty($filtri['danno_selected'])) {
               $qb->innerJoin('g.livelloDanno', 'ld')
               //controllo se il livello di danno del gioco è uno di quello passato nellarray filtro
                ->andWhere($qb->expr()->in('ld.nome', ':danni')) 
                ->setParameter('danni', $filtri['danno_selected']);
            }

            /*non so se lo volgiamo includere
            if( isset($filtri['disponibilita'])) {
                $disponibilitaEnum = DisponibilitaProdotto::tryFrom($filtri['disponibilita']);
                if ($disponibilitaEnum === null) {
                    throw new Exception("La stringa passata non corrsiponde a nessun enumerativo");
                }
                else{
                    $qb->andWhere('g.disponibilita = :disponibilita')
                        ->setParameter('disponibilita', $filtri['disponibilita']);
                }
            }*/

            //filtro per l'ordinamento dei risultati
            if (!empty($filtri['ordinamento'])) {
                switch ($filtri['ordinamento']) {
                    case 'prezzo_asc':
                        $qb->orderBy('pr.valore', 'ASC'); // Dal più economico
                        break;
                    case 'prezzo_desc':
                        $qb->orderBy('pr.valore', 'DESC'); // Dal più costoso
                        break;
                    case 'piu_venduti':
                        $qb->orderBy('g.numeroVendite', 'DESC'); // I più venduti
                        break;
                }
            }


            /*clono la query appena creata per poterla modificare ed effettuare un count su tutti i prodotti filtrati e 
              sapere quanti prodotti sono usciti in tutto dalla query fatta 
            */
            //la clonatura della query viene fatta prima della suddivisione dei risultati per le pagine, perchè altrimenti il count sarebbe falzato e basato sui risultati "limitati" della query
            $qbCount = clone $qb;
            $qbCount->select('count(g.id)');
            //poichè count restituisce un numero scalare non possiamo usare il getResult(), ma usiamo il getSingleScalarResult() che restituisce un numero scalare
            $totale = $qbCount->getQuery()->getSingleScalarResult();

            //sulla query effettuata inizialmete applichiamo il limit e l'offset per la paginazione (per dividere i risultati in pagine)
            
            $qb->setFirstResult($offset)
               ->setMaxResults($limit);
            $risultati = $qb->getQuery()->getResult();

            return [
                'risultati' => $risultati,
                'totale' => $totale
            ];

        }
        //eccezione di tutto il metodo
        catch(Exception $e){
            error_log("Errore in findGiochi: " . $e->getMessage());
            return ['risultati' => [], 'totale' => 0];
        }
    }
}