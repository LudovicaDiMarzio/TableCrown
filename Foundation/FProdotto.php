<?php
namespace TableCrown\Foundation;

use TableCrown\Entity\EProdotto;
use Exception;

class FProdotto{

    /** 
     * @param string $StringaDiRicerca stringa da ricercare nella colonna nomeProdotto o descrizioneProdotto 
     * @return array di oggetti
     * @throws Exception
    */
    public static function ricercaProdotto(string $StringaDiRicerca): array{

        try{

            $testoPulito = trim($StringaDiRicerca);
            //Se dopo aver tolto gli spazi, la stringa è vuota, non effettuo la ricerca
            if (empty($testoPulito)) {
                return []; // Restituiamo un array vuoto immediato
            }

            $qb=FEntityManager::getInstance()->getEntityManager()->createQueryBuilder();
            $qb->select('p')
                ->from(EProdotto::class, 'p');
            $qb->where('p.nomeProdotto LIKE :ricerca OR p.descrizioneProdotto LIKE :ricerca')
               ->setParameter('ricerca', '%' . $testoPulito . '%');
            
               return $qb->getQuery()->getResult();
        }
        catch(Exception $e){
            error_log("Errore nella ricerca del prodotto: " . $e->getMessage());
            return [];
        }
        
    }

    /**
     *Ritorna tutti i prodotti che hanno uno sconto applicato (sconto > 0) 
     * @return array di oggetti
     */
    public static function findProdottiInOfferta(): array {
    try {
            $em = FEntityManager::getInstance()->getEntityManager();
            $qb = $em->createQueryBuilder();

            //seleziona i prodotti con uno sconto applicato e il corrispondente prezzo
            $qb->select('p', 'pr') 
            ->from(EProdotto::class, 'p')
            ->innerJoin('p.prezzo', 'pr')
            ->where('pr.sconto > 0'); 

            return $qb->getQuery()->getResult();
        } 
        catch (Exception $e) {
            error_log("Errore in findProdottiInOfferta: " . $e->getMessage());
            return [];
        }
    }
} 