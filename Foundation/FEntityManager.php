<?php
namespace Foundation;

//per la gestione delle eccezioni in try catch
use Exception;

require_once 'bootstrap.php'; //per creare attivare l'entity manager e creare il collegamento con il db

class FEntityManager {
    
    // creo l'entity manager seguendo il pattern singleton, solo una connessione al db alla volta deve essere attiva, il pattern singleton mi garantisce questo
    //lo implemtento dichiarando l'attributo statico, che può quindi esistere solo una volta in tutta l'app web
    private static $entityManager = null;
    
    // Il costruttore privato garantisce che nessuno possa fare "new FEntityManager()"
    private function __construct() {
        //self è per fare riferimento al'oggetto unico che esiste in tutta l'app web (quello restituito da new EntityManager($connection, $config); in bootstrap.php
        //in generale si usa per costanti o variabili statiche 
        self::$entityManager = getEntityManagerBoot(); // ottiene l'entity manager dalla funzione di bootstrap.php
    }
    
    //Per creare un oggetto con il costruttore di FentityManager
    public static function getEntityManager() {
        // Se la variabile entity manager è vuota (non esiste ancora), chiamiamo il costruttore di FEntityManager per riempirla (Singleton)
        if (self::$entityManager === null) {
            new self();
        }
        // consegnamo l'entity manager appena creata (se non esisteva) oppure quella già esistente
        return self::$entityManager;
    }

    //Metodi della classe FEntityManager//

    /** 
    *Salva un oggetto nel db.
    *@param Object $obj Oggetto da salvare nel db.
    *@return bool True se salvato con successo, false altrimenti.
    *@throws Exception Se il salvataggio fallisce.
    */
    public function saveObj(Object $obj): bool{
        try{
            self::$entityManager->persist($obj);
            self::$entityManager->flush();
            //il salvataggio è andato a buon fine
            return true;
        }
        catch(Exception $e){
            //salvataggio fallito
            echo "Errore salvataggio: ".$e->getMessage()."\n";
            return false;
        }
    }

     /**
     * Metodo per recuperare un oggetto a partire da una classe e un id
     * @param string $class Nome della classe(tabella)
     * @param string $field attributo univoco dell'oggetto da recuperare
     * @param mixed $value valore dell'attributo dell'oggetto da recuperare
     * @return object || null  
     * @throws Exception
     */
    public static function getObjOnAttribute($class, $field, $value): ?object
    {
        try{
            //echo "Cerca in $class dove $field = $value\n";
            return self::$entityManager->getRepository($class)->findOneBy([$field => $value]);
        }
        catch (Exception $e){
            echo "Errore: " . $e->getMessage();
            return null;
        }
    }

    /**
     * Metodo per recuperare una lista di oggetti a partire da una classe e un attributo 
     * @param string $table Nome della tabella
     * @param string $field attributo dell'oggetto da recuperare
     * @param mixed $value valore dell'attributo dell'oggetto da recuperare
     * @return object || null  
     * @throws Exception
     */
    public static function getObjListOnAttribute($table, $field, $value): array
    {
        try{
            return self::$entityManager->getRepository($table)->findBy([$field => $value]);

        } catch(Exception $e){
            echo "Errore: " . $e->getMessage();
            return [];
        }
    }


    /**
     * Metodo per recuperare tutti gli attributi di un'entità con un intervallo di un campo (tipo tutti i prodotti con sconto tra 20% e 50%)
     * @param string $table nome dell'entity
     * @param string $field nome del campo
     * @param array $value array con i valori di inizio e fine dell'intervallo
     * @return array con gli oggetti risultati dalla query
     * @throws Exception
     */ 
    public static function getObjListBetween($table, $field, $value): array{
            try {
                //createQueryBuilder() è un metodo dell'entity manager che restituisce un oggetto QueryBuilder
                $qb = self::$entityManager->createQueryBuilder();
                //questi sono tutti metodi del QueryBuilder che modificano il suo oggetto
                $qb->select('e')//prendo tutti i campi dell'entità
                    ->from($table, 'e') //e è l'alias dell'entità che stiamo interrogando
                    ->where($qb->expr()->between("e.$field", ':start', ':end'))//query con parametri da sanitizzare
                    //sanitizzazione dei parametri
                    ->setParameter('start', $value[0])
                    ->setParameter('end', $value[1]);
                //creazione ed esecuzione della query
                return $qb->getQuery()->getResult();

            } catch (\Exception $e) {
                echo "Errore: " . $e->getMessage();
                return [];
            }
    }

    /**
    * Metodo per verificare l'esistenza di un oggetto nel db
    * @param string $nomeColonnaId nome della colonna che identifica l'oggetto
    * @param string $table nome dell'entity
    * @param string $field nome del campo
    * @param mixed $value valore della colonna identificativa
    * @return bool true se esiste, false altrimenti
    * @throws Exception
    */
    public function verificaEsistenza($nomeColonnaId, $table, $field, $value,): bool 
    {
       try {
        $qb = self::$entityManager->createQueryBuilder();
        
        // contiamo le righe restituite
        $qb->select('COUNT(u.id' . $nomeColonnaId. ')')
           ->from($table, 'u')
           ->where('u.' . $field . ' = :value') 
           ->setParameter('value', $value);

        // getSingleScalarResult() serve per prendere un singolo valore numerico (es. 0 o 1)
        $conteggio = $qb->getQuery()->getSingleScalarResult();
        
        // Se il conteggio è maggiore di zero, l'elemento esiste (true)
        return $conteggio > 0;

        } catch (Exception $e) {
            echo "Errore: " . $e->getMessage();
            return false;
        }
    }
}