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

            if (!empty($filtri['difficolta'])){
                $qb->andWhere('g.difficolta = :difficolta')
                   ->setParameter('difficolta', $filtri['difficolta']);
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
                $qb->andWhere('pr.valore>= :price_min')
                   ->setParameter('price_min', $filtri['price_min']);
            }

            /*non c'è come filtro, ma se va aggiunto già pronto
            if (isset($filtri['price_max'])) {
                $qb->andWhere('pr.valore <= :price_max')
                   ->setParameter('price_max', $filtri['price_max']);
            }*/

            
            //se è settato questo filtro e il suo valore è flse mostriamo solo i giochi base (quelli che non hanno riferimento al giooo padre))
            if (isset($filtri['mostra_espansioni']) && $filtri['mostra_espansioni'] === false) {
                $qb->andWhere('g.giocoBase IS NULL');
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
               $qb->innerJoin('g.danno', 'ld')
                //controllo se il livello di danno del gioco è uno di quello passato nellarray filtro
                    ->andWhere($qb->expr()->in('ld.livelloDanno', ':danni')) 
                    ->setParameter('danni', $filtri['danno_selected']);
            }

            if (!empty($filtri['disponibilita'])) {
                $qb->andWhere('g.disponibilitaProdotto = :disponibilita')
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
                        $qb->orderBy('g.numeroVendite', 'DESC'); // dal più venduto al meno venduto
                        break;
                    case 'rating':
                        $qb->orderBy('g.valutazioneMedia', 'DESC'); // Dalla media voto più alta alla più bassa
                        break;
                }
            }
            else {
                //in generale diamo un ordinamento di default per i giochi mostranodli dal più recente al meno recente
                $qb->orderBy('g.dataPubblicazione', 'DESC');
            }

            //posso voler vedere sia le novità che i prodotti in sconto
            if (!empty($filtri['in_evidenza_filtro'])) {
                //recupero i giochi pubblicati nell'ultimo mese e li ordino per data di pubblicazione decrescente (dal più recente al meno recente)
                if (in_array('novita', $filtri['in_evidenza_filtro'])) {
                    $datalimite = new \DateTime();
                    $datalimite->modify('-1 month');
                    $qb->andWhere('g.dataPubblicazione >= :datalimite')
                        ->setParameter('datalimite', $datalimite);
                }   
                
                if (in_array('sconti', $filtri['in_evidenza_filtro'])) {
                    $qb->andWhere('pr.sconto > 0');
                }
            }
            
            //per recuperare i giochi con valutazione media superiore ad una certa soglia
            if (isset ($filtri['rating_min'])&& $filtri['rating_min'] >0) { 
                $qb->andWhere('g.valutazioneMedia >= :ratingMin')
                    ->setParameter('ratingMin', $filtri['rating_min']);
            }

            /*clono la query appena creata per poterla modificare ed effettuare un count su tutti i prodotti filtrati e 
              sapere quanti prodotti sono usciti in tutto dalla query fatta 
            */
            //la clonatura della query viene fatta prima della suddivisione dei risultati per le pagine, perchè altrimenti il count sarebbe falzato e basato sui risultati "limitati" della query
            $qbCount = clone $qb;
            $qbCount->select('count(g.idProdotto)');
            $qbCount->resetDQLPart('orderBy');//cancelliamo l'ordinamento della query clonata, perchè non serve per il count e potrebbe rallentare la query o generare errori
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