<?php
namespace TableCrown\Foundation;

use TableCrown\Entity\EGiocoDaTavolo;
use TableCrown\Entity\Enumerativi\Categoria;
use TableCrown\Entity\Enumerativi\LinguaGioco;
use TableCrown\Entity\Enumerativi\DifficoltaGioco;
use Exception;

class FGiocoDaTavolo 
{
    public static function findGiochi(array $filtri, int $limit, int $offset): array
    {
        try {
            $qb=FEntityManager::getInstance()->getEntityManager()->createQueryBuilder();
            $qb->select('e')
                ->from(EGiocoDaTavolo::class, 'e');

            //gestione dei filtri dinamica

            if (isset($filtri['difficolta'])){
                // Prova a creare l'Enum. Se la stringa non corrisponde ad uno degli enumerativi, restituisce null
                $difficoltaEnum = DifficoltaGioco::tryFrom($filtri['difficolta']);
                if ($difficoltaEnum === null) {
                    throw new Exception("La stringa passata non corrsiponde a nessun enumerativo");
                } 
                else {
                    $qb->andWhere('e.difficolta = :difficolta')
                        ->setParameter('difficolta', $difficoltaEnum);
                }
            }

            if (isset($filtri['lingua'])) {
                $linguaEnum = LinguaGioco::tryFrom($filtri['lingua']);
                if ($linguaEnum === null) {
                    throw new Exception("La stringa passata non corrsiponde a nessun enumerativo");
                }
                else{
                    $qb->andWhere('e.lingua = :lingua')
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

            //clono la query appena creata per poterla modificare ed effettuare un count su tutti i prodotti filtrati e 
            //sapere quanti prodotti sono usciti in tutto dalla query fatta 
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