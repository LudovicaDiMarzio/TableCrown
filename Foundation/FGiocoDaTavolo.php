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
                $qb->andWhere($qb->expr()->in('g.difficolta',':difficolta'))
                    ->setParameter('difficolta',$filtri['difficolta']);
            }

            if (!empty($filtri['categoria_selected'])) {
                // Se l'utente ha spuntato [Fantasy, Fantascienza]
                // Dcerco tramit eil like
                            $orX = $qb->expr()->orX();
                foreach ($filtri['categoria_selected'] as $i => $cat) {
                    $param = 'cat' . $i;
                    $orX->add($qb->expr()->like('g.categoria', ':' . $param));
                    $qb->setParameter($param, '%"' . $cat . '"%');
                }
                $qb->andWhere($orX);
            }

            if (!empty($filtri['lingua_selected'])) {
                $qb->andWhere($qb->expr()->in('g.lingua', ':lingue'))
                ->setParameter('lingue', $filtri['lingua_selected']);
            }

            if (isset($filtri['price_min'])) {
                $qb->andWhere('pr.valore>= :price_min')
                   ->setParameter('price_min', $filtri['price_min']);
            }

            
            if (isset($filtri['price_max'])) {
                $qb->andWhere('pr.valore <= :price_max')
                   ->setParameter('price_max', $filtri['price_max']);
            }

            
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
               $qb->join('g.danno', 'ld')
                //controllo se il livello di danno del gioco è uno di quello passato nellarray filtro
                    ->andWhere($qb->expr()->in('ld.livelloDanno', ':danni')) 
                    ->setParameter('danni', $filtri['danno_selected']);
            }

            if (!empty($filtri['disponibilita'])) {
                $enumDisponibilita = [];
    
                foreach ($filtri['disponibilita'] as $valoreScelto) {
                    // Se il Control ci sta già passando l'Enum, lo teniamo
                    if ($valoreScelto instanceof DisponibilitaProdotto) {
                        $enumDisponibilita[] = $valoreScelto;
                    } else {
                        // Altrimenti, convertiamo la stringa proveniente dall'HTML nell'Enum ufficiale
                        $enumObj = DisponibilitaProdotto::tryFrom($valoreScelto);
                        if ($enumObj !== null) {
                            $enumDisponibilita[] = $enumObj;
                        }
                    }
                    $qb->andWhere($qb->expr()->in('g.disponibilitaProdotto',':disponibilita'))
                        ->setParameter('disponibilita',$filtri['disponibilita']);
                }
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
                        // Stiamo dicendo a Doctrine di usare la proprietà della classe EProdotto
                        $qb->orderBy('g.valutazioneMedia', 'DESC'); 
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
                       ->andWhere('g.disponibilitaProdotto=: disponibilita')  
                        ->setParameter('datalimite', $datalimite)
                        ->setParameter('disponibilita', DisponibilitaProdotto::Disponibile);
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
            

            // Clono di nuovo la query per trovare il prezzo min e max dei prodotti filtrati
            $qbEstremi = clone $qb;
            $qbEstremi->select('MIN(pr.valore) AS min_price', 'MAX(pr.valore) AS max_price');
            $qbEstremi->resetDQLPart('orderBy'); // Togliamo l'ordinamento anche qui per performance
            $estremi = $qbEstremi->getQuery()->getSingleResult();


            //operatore ternario, facciamo un controllo sulla condizione e scriviamo cosa fare se risulta true o false
            //ciò che si trova prima dei : è cosa fare se la condizione è true, dopo i : cosa fare se è false
            $prezzoMinimo = $estremi['min_price'] !== null ? (float) $estremi['min_price'] : 0.0; 
            $prezzoMassimo = $estremi['max_price'] !== null ? (float) $estremi['max_price'] : 200.0;

            //sulla query effettuata inizialmete applichiamo il limit e l'offset per la paginazione (per dividere i risultati in pagine)
            
            $qb->setFirstResult($offset)
               ->setMaxResults($limit);
            $risultati = $qb->getQuery()->getResult();

            return [
                'risultati' => $risultati,
                'totale' => $totale,
                'rangemin' => $prezzoMinimo,
                'rangemax' => $prezzoMassimo
            ];

        }
        //eccezione di tutto il metodo
        catch(Exception $e){
            error_log("Errore in findGiochi: " . $e->getMessage());
            return ['risultati' => [], 
                    'totale' => 0,
                    'rangemin' => 0.0,
                    'rangemax' => 200.0
            ];
        }
    }

    /** 
     * @param string $StringaDiRicerca stringa da ricercare nella colonna nomeProdotto o descrizioneProdotto 
     * @param int $limit numero massimo di prodotti da restituire
     * @param int $offset numero di prodotti da saltare dall'inizio della lista
     * @return array di oggetti
     * @throws Exception
    */
    public static function ricercaGiochi(string $StringaDiRicerca, int $limit, int $offset): array{

        try{

            $testoPulito = trim($StringaDiRicerca);
            //Se dopo aver tolto gli spazi, la stringa è vuota, non effettuo la ricerca
            if (empty($testoPulito)) {
                return []; // Restituiamo un array vuoto immediato
            }

            $qb=FEntityManager::getInstance()->getEntityManager()->createQueryBuilder();
            $qb->select('g')
                ->from(EGiocoDaTavolo::class, 'g')
                ->where('g.nomeProdotto LIKE :ricerca OR g.descrizioneProdotto LIKE :ricerca')
                ->setParameter('ricerca', '%' . $testoPulito . '%');

            /*clono la query appena creata per poterla modificare ed effettuare un count su tutti i prodotti filtrati e 
              sapere quanti prodotti sono usciti in tutto dalla query fatta 
            */
            //la clonatura della query viene fatta prima della suddivisione dei risultati per le pagine, perchè altrimenti il count sarebbe falzato e basato sui risultati "limitati" della query
            $qbCount = clone $qb;
            $qbCount->select('count(g.idProdotto)');
            //poichè count restituisce un numero scalare non possiamo usare il getResult(), ma usiamo il getSingleScalarResult() che restituisce un numero scalare
            $totale = $qbCount->getQuery()->getSingleScalarResult();

          

            //sulla query effettuata inizialmete applichiamo il limit e l'offset per la paginazione (per dividere i risultati in pagine)
            
            $qb->setFirstResult($offset)
               ->setMaxResults($limit);
            //error_log("SQL Eseguito: " . $qb->getQuery()->getSQL());
            $risultati = $qb->getQuery()->getResult();
            
            return [
                'risultati' => $risultati,
                'totale' => $totale
            ];
        }
        catch(Exception $e){
            error_log("Errore nella ricerca del prodotto: " . $e->getMessage());
            return [
                'risultati' => [],
                'totale' => 0
            ];
        }
        
    }

  
}