<?php
namespace Foundation;

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
        $this->emORM = FEntityManager::getEntityManager();
    }

    public static function getPersistentManager()
    {
        if (self::$persistentManager === null) {
            new self();
        }
        return self::$persistentManager;
    }

    // Metodi per incapsulare le operazioni di doctrine e renderle fruibili dal controller 

    public function beginTransaction() {
        $this->emORM->getConnection()->beginTransaction();
    }

    public function isTransactionActive(): bool {
        return $this->emORM->getConnection()->isTransactionActive();
    }

    public function commit(){
        $this->emORM->getConnection()->commit();
    }

    public function rollback() {
        $this->emORM->getConnection()->rollBack();
    }

    public function flush(){
        $this->emORM->flush();
    }

    public function persist($obj){
        $this->emORM->persist($obj);
    }

    /*metodo per bloccare le operazioni a tutti tranne ad un utente x che l'ha iniziata per primo 
     il LockMode è un enumerativo che può essere PESSIMISTIC_READ, PESSIMISTIC_WRITE o OPTIMISTIC
    */
    public function locking($entityClass, $id, int $lockMode = LockMode::PESSIMISTIC_WRITE){
        return $this->emORM->find($entityClass, $id, $lockMode);
    }





    // <--------------------------CRUD METHODS FOR GENERIC OBJECTS---------------------------------->
     /**
     * @param Object $obj Oggetto da salvare nel db.
     * @return bool True se salvato con successo, false altrimenti.
     * @throws Exception
     */
    public static function PMsaveObj($obj): bool
    {
        return FEntityManager::getEntityManager()->saveObj($obj);
    }
    
    
    /**
     * @param string $class Nome della classe(tabella)
     * @param string $field attributo univoco dell'oggetto da recuperare
     * @param mixed $value valore dell'attributo dell'oggetto da recuperare
     * @return object || null
     * @throws Exception
     */
    public function PMgetObjOnAttribute($class, $field, $value): ?object
    {
        return FEntityManager::getEntityManager()->getObjOnAttribute($class, $field, $value);
    }

     /**
     * @param string $class Nome della classe(tabella)
     * @param string $field attributo univoco dell'oggetto da recuperare
     * @param mixed $value valore dell'attributo dell'oggetto da recuperare
     * @return object || null
     * @throws Exception
     */
    public function PMgetObjListOnAttribute($class, $field, $value): array
    {
        return FEntityManager::getEntityManager()->getObjListOnAttribute($class, $field, $value);
    }

     /**
     * @param string $class Nome della classe(tabella)
     * @param string $field attributo dell'oggetto da recuperare
     * @param mixed $value valore dell'attributo dell'oggetto da recuperare
     * @return object || null
     * @throws Exception
     */
    public function PMgetObjListBetween($class, $field, $value): array
    {
        return FEntityManager::getEntityManager()->getObjListBetween($class, $field, $value);
    }

    /**
     * @param string $table Nome della classe(tabella)
     * @param string $field attributo dell'oggetto da recuperare
     * @param mixed $value valore dell'attributo dell'oggetto da recuperare
     * @return bool 
     * @throws Exception
     */
    public function PMverificaEsistenza($table, $field, $value): bool
    {
        return FEntityManager::getEntityManager()->verificaEsistenza($table, $field, $value);
    }

    /**
     * @param string $class Nome della classe(tabella)
     * @param string $str  parte dell' attributo dell'oggetto da recuperare
     * @param mixed $field valore dell'attributo dell'oggetto da recuperare
     * @return array
     * @throws Exception
     */
    public function PMRicerca($class, $str, $field ): array
    {
        return FEntityManager::getEntityManager()->getRicerca($class, $str, $field);
    }   
     

    /**
     * @param Object $obj Oggetto da eliminare dal db.
     * @return bool True se eliminato con successo, false altrimenti.
     * @throws Exception
     */
    public static function PMdeleteObj($obj): bool
    {
        return FEntityManager::getEntityManager()->deleteObj($obj);
    }

    /** 
     * @param Object $obj Oggetto da salvare nel db.
     * @return bool True se salvato con successo, false altrimenti.
     * @throws Exception
     */
    public static function PMupdateObj($obj): bool
    {
        return FEntityManager::getEntityManager()->saveObj($obj);
    }

    /**
     * @param string $class nome dell'entity
     * @return array di oggetti
     * @throws Exception
     */
    public static function PMgetAll($class): array
    {
        return FEntityManager::getEntityManager()->getAll($class);
    }


}