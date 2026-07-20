<?php
namespace TableCrown\Foundation;

use Doctrine\DBAL\LockMode;
use TableCrown\Foundation\FEntityManager;
use DateTime;
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
        FEntityManager::getInstance()->getEntityManager()->getConnection()->commit();
    }

    public static function rollback() {
        FEntityManager::getInstance()->getEntityManager()->getConnection()->rollBack();
    }

    public static function flush(){
       FEntityManager::getInstance()->getEntityManager()->flush();
    }

    public static function persist($obj){
        FEntityManager::getInstance()->getEntityManager()->persist($obj);
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
     */
    public static function PMRicerca($class, $str, $field, int $limit, int $offset): array
    {
        return FEntityManager::getInstance()->getRicerca($class, $str, $field, $limit, $offset);
    }   
     

    /**
     * @param Object $obj Oggetto da eliminare dal db.
     * @return bool True se eliminato con successo, false altrimenti.
     */
    public static function PMdeleteObj($obj): bool
    {
        return FEntityManager::getInstance()->deleteObj($obj);
    }

    /** 
     * @param Object $obj Oggetto da salvare nel db.
     * @return bool True se salvato con successo, false altrimenti.
     */
    public static function PMupdateObj($obj): bool
    {
        return FEntityManager::getInstance()->saveObj($obj);
    }

    /**
     * @param string $class nome dell'entity
     * @return array di oggetti
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
     */
    public static function PMfindPortaDadi(array $filtri, int $limit, int $offset): array
    {
        return FPortaDadi::findPortaDadi($filtri, $limit, $offset);
    }

    /**
     * @param string $StringaDiRicerca stringa da ricercare nella colonna nomeProdotto o descrizioneProdotto 
     * @param int $limit numero massimo di prodotti da restituire
     * @param int $offset numero di prodotti da saltare dall'inizio della lista
     * @return array di oggetti
     */
    public static function PMricercaProdotto(string $StringaDiRicerca, int $limit, int $offset): array
    {
        return FGiocoDaTavolo::ricercaProdotto($StringaDiRicerca, $limit, $offset);
    }

    /**
     *Ritorna tutti i prodotti che hanno uno sconto applicato (sconto > 0) 
     * @param int $limit numero massimo di prodotti da restituire
     * @param int $offset numero di prodotti da saltare dall'inizio della lista
     * @return array di oggetti
     */
    public static function PMfindProdottiInOfferta(int $limit, int $offset): array {
        return FProdotto::findProdottiInOfferta($limit, $offset);
    }

    /**
     * @param string $filtroData data di inizio del filtro
     * @return array di oggetti
     */
    public static function PMfindSerate(?string $filtroData): array {
        return FSerate::findSerate($filtroData);
    }

    /**
     * @param string $filtroData data di inizio del filtro
     * @return array di oggetti
     */
    public static function PMfindTornei(?string $filtroData): array {
        return FTornei::findTornei($filtroData);
    }

    /**
     * @param string $filtroData data di inizio del filtro
     * @return array di oggetti
     */
    public static function PMfindChallenge(?string $filtroData): array {
        return FChallenge::findChallenge($filtroData);
    }

    /**
     * @param string $ricerca stringa da ricercare nella colonna nomeEvento
     * @return array di oggetti
     */
    public static function PMricercaEventi(?string $ricerca): array {
        return FEventi::ricercaEventi($ricerca);
    }

    /**
     * @param int $iduser id dell'utente da controllare
     * @param int $idprodotto id del prodotto da controllare
     * @return bool 
    */
    public static function PMutenteHasProdotto(int $iduser, int $idprodotto): bool {
        return FProdotto::utenteHasProdotto($iduser, $idprodotto);
    }

    /**
     * @param array $prodottiesclusi array di id prodotti da escludere dalla ricerca
     * @param int $limit numero massimo di prodotti da restituire
     * @return array di oggetti
     */
    public static function PMfindCorrelati(array $prodottiesclusi, int $limit): array {
        return FProdotto::findCorrelati($prodottiesclusi, $limit);
    }

    /**
     * @return int numero utenti totali
     */
    public static function PMcontaUtentiTotali(): int {
        return FUtente::ContaUtentiTotali();
    }

    /**
     * @return int numero di utenti nuovi oggi
     */
    public static function PMcontaUtentiNuoviOggi(): int {
        return FUtente::contaUtentiNuoviOggi();
    }

    /**
     * @return int numero di utenti con sospensione attiva
     */
    public static function PMcontaUtentiSospesiTotali(): int {
        return FUtente::contaUtentiSospesiTotali();
    }

    /**
     * @param string $ordinamento ordinamento degli utenti in base al numero di segnalazioni
     * @return array array di utenti e numero segnalazione per utente 
     */
    public static function PMfindUtentiConRecensioniSegnalate(string $ordinamento): array {
        return FUtente::findUtentiConRecensioniSegnalate($ordinamento);
    }

    /**
     * @param int $idUtente id dell'utente
     * @return array array di oggetti
     */
    public static function PMgetRecensioniSegnalateDiUtente(int $idUtente): array {
        return FUtente::getRecensioniSegnalateDiUtente($idUtente);
    }

    /**
     * @return int numero  utenti sospesi oggi
    */
    public static function PMcontaUtentiSospesiOggi(): int {
        return FSegnalazione::contaUtentiSospesiOggi();
    }

    /**
     * @param string $order 'ASC' = più urgenti prima (ALTA -> MEDIA -> BASSA), 'DESC' = inverso
     * @param int $limit numero massimo di segnalazioni da restituire
     * @return array di oggetti ESegnalazione
     */
    public static function PMgetSegnalazioniUrgenti(string $order, int $limit ): array {
        return FSegnalazione::getSegnalazioniUrgenti($order, $limit);
    }

    /**
     * @return int numero di segnalazioni in attesa
     */
    public static function PMcontaSegnalazioniInSospeso(): int {
        return FSegnalazione::contaSegnalazioniInSospeso();
    }

    /**
     * @param string $ordinamento ordiniamo in base al numero di segnalazioni ricevute
     * @return array di oggetti
     */
    public static function PMfindRecensioniConSegnalazioni(string $ordinamento): array {
        return FSegnalazione::findRecensioniConSegnalazione($ordinamento);
    }
    

    /**
     * @return int numero di ordini totali                                  
     */
    public static function PMcontaOrdiniTotali(): int {
        return FOrdini::contaOrdiniTotali();
    }

    /**
     * @return int numero totale vendite (in euro)                          
     */
    public static function PMcontaVenditeTotali(): int {
        return FOrdini::contaVenditeTotali();
    }

    /**
     * @param int $limit numero mx di eventi da restituire
     * @return array di oggetti
     */
    public static function PMgetProssimiEventi(int $limit): array {
        return FEventi::getProssimiEventi($limit);
    }

    /**
     * @param string $filtroData data di inizio del filtro
     * @return array di oggetti
     */
    public static function PMfindSerateGestore(?string $filtroData): array {
        return FSerate::findSerateGestore($filtroData);
    }

    /**
     * @param string $filtroData data di inizio del filtro
     * @return array di oggetti
     */
    public static function PMfindChallengeGestore(?string $filtroData): array {
        return FChallenge::findChallengeGestore($filtroData);
    }

    /**
     * @param string $filtroData data di inizio del filtro
     * @return array di oggetti
     */
    public static function PMfindTorneiGestore(?string $filtroData): array {
        return FTornei::findTorneiGestore($filtroData);
    }

}