<?php
namespace TableCrown\Foundation;

use Doctrine\DBAL\LockMode;
use TableCrown\Foundation\FEntityManager;
use Exception;

class FPersistentManager
{

    private static $persistentManager = null;

    //variabile che conterrà l'entity manager creato in FEntityManager
    private $emORM;

    private function __construct()
    {
        //non c'è bisogno di un costruttore, questa classe serve solo per incapsulare i metodi dello strato foundation, per farli usare al control
    }

    public static function getPersistentManager()
    {
        if (self::$persistentManager === null) {
            self::$persistentManager = new self();
        }
        return self::$persistentManager;
    }

    // Metodi per incapsulare le operazioni di doctrine e renderle fruibili dal controller 

    public static function beginTransaction() {
        return FEntityManager::getInstance()->getEntityManager()->getConnection()->beginTransaction();
    }

    public static function isTransactionActive(): bool {
        return FEntityManager::getInstance()->getEntityManager()->getConnection()->isTransactionActive();
    }

    public static function commit(){
        FentityManager::getInstance()->getEntityManager()->getConnection()->commit();
    }

    public static function rollback() {
        FentityManager::getInstance()->getEntityManager()->getConnection()->rollBack();
    }

    public static function flush(){
       FentityManager::getInstance()->getEntityManager()->flush();
    }

    public static function persist($obj){
        FentityManager::getInstance()->getEntityManager()->persist($obj);
    }

    /*metodo per bloccare le operazioni a tutti tranne ad un utente x che l'ha iniziata per primo 
     il LockMode è un enumerativo che può essere PESSIMISTIC_READ, PESSIMISTIC_WRITE o OPTIMISTIC
    */
    public static function locking($entityClass, $id, int $lockMode = LockMode::PESSIMISTIC_WRITE){
        return FEntityManager::getInstance()->getEntityManager()->find($entityClass, $id, $lockMode);
    }





    // <--------------------------CRUD METHODS FOR GENERIC OBJECTS---------------------------------->
     /**
     * @param Object $obj Oggetto da salvare nel db.
     * @return bool True se salvato con successo, false altrimenti.
     * @throws Exception
     */
    public static function PMsaveObj($obj): bool
    {
        return FEntityManager::getInstance()->saveObj($obj);
    }
    
    
    /**
     * @param string $class Nome della classe(tabella)
     * @param string $field attributo univoco dell'oggetto da recuperare
     * @param mixed $value valore dell'attributo dell'oggetto da recuperare
     * @return object || null
     * @throws Exception
     */
    public static function PMgetObjOnAttribute($class, $field, $value): ?object
    {
        return FEntityManager::getInstance()->getObjOnAttribute($class, $field, $value);
    }

     /**
     * @param string $class Nome della classe(tabella)
     * @param string $field attributo univoco dell'oggetto da recuperare
     * @param mixed $value valore dell'attributo dell'oggetto da recuperare
     * @return object || null
     * @throws Exception
     */
    public static function PMgetObjListOnAttribute($class, $field, $value): array
    {
        return FEntityManager::getInstance()->getObjListOnAttribute($class, $field, $value);
    }

     /**
     * @param string $class Nome della classe(tabella)
     * @param string $field attributo dell'oggetto da recuperare
     * @param mixed $value valore dell'attributo dell'oggetto da recuperare
     * @return object || null
     * @throws Exception
     */
    public static function PMgetObjListBetween($class, $field, $value): array
    {
        return FEntityManager::getInstance()->getObjListBetween($class, $field, $value);
    }

     /**
     * @param string $class Nome della classe(tabella)
     * @param string $field attributo dell'oggetto da recuperare
     * @param string $ordinationType ordinamento (ASC o DESC)
     * @param int $quantity numero massimo di elementi da recuperare
     * @return object || null
     * @throws Exception
     */
    public static function PMgetObjListOrdered($class, $field, $ordinationType, $quantity): array
    {
        return FEntityManager::getInstance()->getObjListOrdered($class, $field, $ordinationType, $quantity);
    }

    /**
     * @param string $table Nome della classe(tabella)
     * @param string $field attributo dell'oggetto da recuperare
     * @param mixed $value valore dell'attributo dell'oggetto da recuperare
     * @return bool 
     * @throws Exception
     */
    public static function PMverificaEsistenza($table, $field, $value): bool
    {
        return FEntityManager::getInstance()->verificaEsistenza($table, $field, $value);
    }

    /**
     * @param string $class Nome della classe(tabella)
     * @param string $str  parte dell' attributo dell'oggetto da recuperare
     * @param mixed $field valore dell'attributo dell'oggetto da recuperare
     * @return array
     * @throws Exception
     */
    public static function PMRicerca($class, $str, $field ): array
    {
        return FEntityManager::getInstance()->getRicerca($class, $str, $field);
    }   
     

    /**
     * @param Object $obj Oggetto da eliminare dal db.
     * @return bool True se eliminato con successo, false altrimenti.
     * @throws Exception
     */
    public static function PMdeleteObj($obj): bool
    {
        return FEntityManager::getInstance()->deleteObj($obj);
    }

    /** 
     * @param Object $obj Oggetto da salvare nel db.
     * @return bool True se salvato con successo, false altrimenti.
     * @throws Exception
     */
    public static function PMupdateObj($obj): bool
    {
        return FEntityManager::getInstance()->saveObj($obj);
    }

    /**
     * @param string $class nome dell'entity
     * @return array di oggetti
     * @throws Exception
     */
    public static function PMgetAll($class): array
    {
        return FEntityManager::getInstance()->getAll($class);
    }


    //METODI SPECIFICI PER LE ENTITY

    /**
     * @param array $filtri array associativo con i filtri da applicare per la ricerca dei giochi da tavolo
     * @param int $limit numero massimo di giochi da restituire
     * @param int $offset numero di giochi da saltare dall'inizio della lista
     * @return array con i giochi da tavolo risultanti dalla ricerca
     * @throws Exception
     */
    public static function PMfindGiochi(array $filtri, int $limit, int $offset): array
    {
        return FGiocoDaTavolo::findGiochi($filtri, $limit, $offset);
    }

    /**
     * @param array $filtri: un array associativo che contiene i filtri da applicare alla query. Le chiavi dell'array rappresentano i nomi dei filtri, mentre i valori rappresentano i valori dei filtri.
     * @param int $limit: il numero massimo di risultati da restituire. Questo parametro viene utilizzato per implementare la paginazione dei risultati.
     * @param int $offset: il numero di risultati da saltare prima di selezionare i risultati richiesti (utile sempre per la paginazione).
     * @return array con i risultati della ricerca, incluso il numero totale di risultati
     * @throws Exception
     */
    public static function PMfindBustine(array $filtri, int $limit, int $offset): array
    {
        return FBustine::findBustine($filtri, $limit, $offset);
    }

    /**
     * @param array $filtri: un array associativo che contiene i filtri da applicare alla query. Le chiavi dell'array rappresentano i nomi dei filtri, mentre i valori rappresentano i valori dei filtri.
     * @param int $limit: il numero massimo di risultati da restituire. Questo parametro viene utilizzato per implementare la paginazione dei risultati.
     * @param int $offset: il numero di risultati da saltare prima di selezionare i risultati richiesti (utile sempre per la paginazione).
     * @return array con i risultati della ricerca, incluso il numero totale di risultati
     * @throws Exception
     */
    public static function PMfindPortaDadi(array $filtri, int $limit, int $offset): array
    {
        return FPortaDadi::findPortaDadi($filtri, $limit, $offset);
    }

}