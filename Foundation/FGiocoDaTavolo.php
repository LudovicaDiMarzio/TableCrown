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
            $qb->select('g')
                ->from(EGiocoDaTavolo::class, 'g');

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

            if (isset($filtri['lingua'])) {
                $linguaEnum = LinguaGioco::tryFrom($filtri['lingua']);
                if ($linguaEnum === null) {
                    throw new Exception("La stringa passata non corrsiponde a nessun enumerativo");
                }
                else{
                    $qb->andWhere('g.lingua = :lingua')
                       ->setParameter('lingua', $linguaEnum);
                }
            }

            if (isset($filtri['prezzo_min'])) {
                $qb->andWhere('g.prezzo >= :prezzo_min')
                   ->setParameter('prezzo_min', $filtri['prezzo_min']);
            }

            if (isset($filtri['prezzo_max'])) {
                $qb->andWhere('g.prezzo <= :prezzo_max')
                   ->setParameter('prezzo_max', $filtri['prezzo_max']);
            }

            if (isset($filtri['categoria'])) {
                // 1. Verifichiamo che la categoria esista davvero nel tuo Enum (sicurezza!)
                $categoriaEnum = Categoria::tryFrom($filtri['categoria']);
                if ($categoriaEnum === null) {
                    throw new Exception("La stringa passata non corrsiponde a nessun enumerativo");
                }
                else {
                    $qb->andWhere('g.categoria LIKE :categoria')
                    // Usiamo ->value per estrarre la stringa (es. "strategia") dall'oggetto Enum
                    // e la avvolgiamo tra virgolette doppie e percentuali per cercare nel JSON
                    ->setParameter('categoria', '%"' . $categoriaEnum->value . '"%');
                }
            }

            if (isset($filtri['giocoBase'])) {
                $qb->andWhere('g.giocoBase = :giocoBase')
                   ->setParameter('giocoBase', $filtri['giocoBase']);
            }

            if (isset($filtri['numeroGiocatoriMin'])) {
                $qb->andWhere('g.numeroGiocatoriMin = :numeroGiocatoriMin')
                   ->setParameter('numeroGiocatoriMin', $filtri['numeroGiocatoriMin']);
            }

            if (isset($filtri['numeroGiocatoriMax'])) {
                $qb->andWhere('g.numeroGiocatoriMax = :numeroGiocatoriMax')
                   ->setParameter('numeroGiocatoriMax', $filtri['numeroGiocatoriMax']);
            }

            if (isset($filtri['etaMinima'])) {
                $qb->andWhere('g.etaMinima = :etaMinima')
                   ->setParameter('etaMinima', $filtri['etaMinima']);
            }

            if (isset($filtri['durataMedia'])) {
                $qb->andWhere('g.durataMedia = :durataMedia')
                   ->setParameter('durataMedia', $filtri['durataMedia']);
            }

            if (isset($filtri['danno'])) {
                $dannoEnum = LivelloDannoGiochi::tryFrom($filtri['danno']);
                if ($dannoEnum === null) {
                    throw new Exception("La stringa passata non corrsiponde a nessun enumerativo");
                }
                else {
                    $qb->andWhere('g.danno = :danno')
                       ->setParameter('danno', $dannoEnum);
                }
            }

            if( isset($filtri['disponibilita'])) {
                $disponibilitaEnum = DisponibilitaProdotto::tryFrom($filtri['disponibilita']);
                if ($disponibilitaEnum === null) {
                    throw new Exception("La stringa passata non corrsiponde a nessun enumerativo");
                }
                else{
                    $qb->andWhere('g.disponibilita = :disponibilita')
                        ->setParameter('disponibilita', $filtri['disponibilita']);
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