<?php
namespace TableCrown\Foundation;

//per la gestione delle eccezioni in try catch
use Exception;
require_once 'bootstrap.php'; //per creare attivare l'entity manager e creare il collegamento con il db

class FEntityManager {
    
    // creo l'entity manager seguendo il pattern singleton, solo una connessione al db alla volta deve essere attiva, il pattern singleton mi garantisce questo
    //lo implemtento dichiarando l'attributo statico, che può quindi esistere solo una volta in tutta l'app web
    private  $entityManager = null;
    private static $instance = null;
    // Il costruttore privato garantisce che nessuno possa fare "new FEntityManager()"
    private function __construct() {
        //self è per fare riferimento al'oggetto unico che esiste in tutta l'app web (quello restituito da new EntityManager($connection, $config); in bootstrap.php
        //in generale si usa per costanti o variabili statiche 
        $this->entityManager = getEntityManagerBoot(); // ottiene l'entity manager dalla funzione di bootstrap.php
    }
    /**
     * Metodo per ottenere l'istanza della classe
     */
    public static function getInstance(){
        if (self::$instance == null) {
            self::$instance = new self(); //crea un'istanza della classe
        }
        return self::$instance;
    }

    //Per creare un oggetto con il costruttore di FentityManager
    public function getEntityManager() {
       return $this->entityManager;
    }

    //Metodi della classe FEntityManager//

    /** 
    *Salva o aggiorna un oggetto nel db.
    *@param Object $obj Oggetto da salvare nel db.
    *@return bool True se salvato con successo, false altrimenti.
    *@throws Exception Se il salvataggio fallisce.
    */
    public function saveObj(Object $obj): bool{
        try{
            /**
             * potevano essere usati anche i metodi doctrine specifici pe rla gestione delle transaction  self::$entityManager->getConnection()->beginTransaction(); 
             *$this->$entityManager->getConnection()->commit(); ma non è necessario usarlo, perchè la classe EntityManager si occupa già di gestire le transazioni con flush
             *se l'esecuzione di una query non va a buon fine  e si verifica un errore, nessuna query sarà eseguita, 
             *la transazione sarà annullata e sarà generato un rollback automatico
            */

            //se si effettua l'aggiornamento di un oggetto già tracciato da doctrine (ad esempio a causa dell'esecuzione di un'altra query precedente), persist viene ignorato da doctrine, l'oggetto non viene tracciato di nuovo
            $this->entityManager->persist($obj);
            $this->entityManager->flush();
            //il salvataggio è andato a buon fine
            return true;
        }
        catch(Exception $e){
            //salvataggio fallito
            //getMessage() restituisce il messaggio di errore lanciato dall'eccezione php
            error_log("Errore durante il salvataggio dell'oggetto: " . $e->getMessage());
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
    public function getObjOnAttribute($class, $field, $value): ?object
    {
        try{
            //echo "Cerca in $class dove $field = $value\n";
            return $this->entityManager->getRepository($class)->findOneBy([$field => $value]);
        }
        catch (Exception $e){
            error_log("Errore durante il recupero dell'oggetto: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Metodo per recuperare una lista di oggetti a partire da una classe e un attributo 
     * @param string $table Nome della tabella
     * @param string $field attributo dell'oggetto da recuperare
     * @param mixed $value valore dell'attributo dell'oggetto da recuperare
     * @return array || null  
     * @throws Exception
     */
    public  function getObjListOnAttribute($table, $field, $value): array
    {
        try{
            return $this->entityManager->getRepository($table)->findBy([$field => $value]);

        } catch(Exception $e){
            error_log("Errore durante il recupero degli oggetti: " . $e->getMessage());
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
    public function getObjListBetween($table, $field, $value): array{
            try {
                //createQueryBuilder() è un metodo dell'entity manager che restituisce un oggetto QueryBuilder
                $qb = $this->entityManager->createQueryBuilder();
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
                error_log("Errore durante il recupero degli oggetti: " . $e->getMessage());
                return [];
            }
    }

    /**
     * Metodo per recuperare una lista di oggetti ordinati per un campo
     * @param string $table nome dell'entity
     * @param string $field nome del campo
     * @param string $ordinationType ordinamento (ASC o DESC)
     * @param int $quantity numero massimo di elementi da recuperare
     * @return array di oggetti
     * @throws Exception
     * 
    */
    public function getObjListOrdered($table, $field, $ordinationType, $quantity): array
    {
        try{
            $qb = $this->entityManager->createQueryBuilder();
            
            $qb->select('e')
               ->from($table, 'e')
               ->orderBy('e.' . $field, $ordinationType)
               ->setMaxResults($quantity);
            return $qb->getQuery()->getResult();
        }
        catch(Exception $e){
            error_log("Errore durante il recupero degli oggetti: " . $e->getMessage());
            return [];
        }
    }

    /**
    * Metodo per verificare l'esistenza di un oggetto nel db
    * @param string $table nome dell'entity
    * @param string $field nome del campo
    * @param mixed $value valore della colonna identificativa
    * @return bool true se esiste, false altrimenti
    * @throws Exception
    */
    public function verificaEsistenza( $table, $field, $value,): bool 
    {
       try {
        $qb = $this->entityManager->createQueryBuilder();
        //recupero il nome della colonna identificativa mappata nell'entity con le annotation doctrine
        $nomeColonnaId = $this->entityManager->getClassMetadata($table)->getIdentifierFieldNames()[0];
        // contiamo le righe restituite
        $qb->select('COUNT(e.' . $nomeColonnaId. ')')
           ->from($table, 'e')
           ->where('e.' . $field . ' = :value') 
           ->setParameter('value', $value);

        // getSingleScalarResult() serve per prendere un singolo valore numerico (es. 0 o 1)
        $conteggio = $qb->getQuery()->getSingleScalarResult();
        
        // Se il conteggio è maggiore di zero, l'elemento esiste (true)
        return $conteggio > 0;

        } catch (Exception $e) {
            error_log("Errore durante il controllo di esistenza dell'oggeto: " . $e->getMessage()); 
            echo "errore---------->" . $e->getMessage();
            return false;
        }

    }

    /*Metodo non so se utile, potrebbe servire per prevedere le ricerche nella barra di ricerca, ma c'è bisogno di javascript con ajax o fetch 
        public function verificaEsistenza($id, $table, $value, $field): bool 
    {
        try {
            $qb = $this->entityManager->createQueryBuilder();
            
            // Chiediamo a Doctrine di CONTARE le righe, non di scaricarle!
            $qb->select('COUNT(u.id' . $id . ')')
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
    */

    /**
     * Metodo per cercare un oggetto in un'entità rispetto ad un campo attributo contenente una parte di una stringa cercata
     * @param string $entityClass nome dell'entità da cercare
     * @param string $str stringa da cercare
     * @param string $field nome del campo da cercare
     * @param int $limit numero massimo di prodotti da restituire
     * @param int $offset numero di prodotti da saltare dall'inizio della lista
     * @return array di oggetti
     * @throws Exception
     */
    public function getRicerca($entityClass, $str, $field, $limit, $offset): array{
        try{
            $qb=$this->entityManager->createQueryBuilder();

            $qb->select('e');
            $qb->from($entityClass, 'e');
            $qb->where('e.' . $field . 'LIKE :ricerca');
            $qb->setParameter('ricerca', '%' . $str .  '%');

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
           
        } catch (Exception $e){
            error_log("Errore durante la ricerca: " . $e->getMessage());
            return ['risultati' => [], 'totale' => 0];
        }
    }


    /**
     * Metodo universale per eliminare un oggetto dal database
     * @param object $obj L'oggetto da eliminare
     * @return bool true se l'operazione ha successo, false altrimenti
     * @throws Exception
     */
    public function deleteObj(object $obj): bool
    {
        try {
            // Mettiamo l'etichetta "da cancellare" sull'oggetto
            $this->entityManager->remove($obj); 
            
            // Doctrine esegue la DELETE dentro una sua transazione sicura
            $this->entityManager->flush();
            
            return true;

        } catch (\Exception $e) {
            // Niente echo! Salviamo l'errore nel log di sistema
            error_log("Errore durante l'eliminazione: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Metodo per recuperare tutti gli oggetti di una classe
     * @param string $entityClass nome della classe
     * @return array di oggetti
     * @throws Exception
     */
    public function getAll(string $entityClass): array
    {
        try {
            $qb = $this->entityManager->createQueryBuilder();
            
            // Struttura fluida, sicura e pulitissima
            $qb->select('e')
               ->from($entityClass, 'e');
               
            // Restituisce direttamente l'array (pieno o vuoto)
            return $qb->getQuery()->getResult();
            
        } catch (\Exception $e) {
            // Log nascosto, niente information disclosure!
            error_log("Errore nel recupero dei dati per la classe $entityClass: " . $e->getMessage());
            return [];
        }
    }
}
