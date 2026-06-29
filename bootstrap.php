<?php
//carica l'autoloader di composer per trovare le librerie e le classi entity
require_once __DIR__ . '/vendor/autoload.php'; //__DIR__ restituisce il percorso assoluto del file che stiamo leggendo (/vendor/autoload.php)

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\DriverManager;

function getEntityManagerBoot(): EntityManager
{
    /* il pattern singleton lo applico direttamente nell'FEntityManager
    //applico il pattern singleton per evitare di creare più di un'istanza di entitymanager*/
    static $entityManager = null;

    if ($entityManager !== null) {
        return $entityManager;
    }
    

    //metodo di doctrine della classe ORMSetup per creare la configurazione del db basandosi sugli attributi doctrine che abbiamo messo nelle entity (traduttore delle classi da php a doctrine)
    $config = ORMSetup::createAttributeMetadataConfiguration(
        paths: [__DIR__ . '/Entity'],  //comunico a doctrine dove sono le classi mappate
        isDevMode: true //siamo ancora in modalità sviluppo, quindi ogni volta che facciamo partire una pagina, doctrine si rilegge le entity da zero
    );

    //configurazione dati di accesso per la connessione al db
    $conn = [
        'driver'   => 'pdo_mysql', //tipologia di db utilizzato (MySQL)
        'host'     => 'localhost',
        'dbname'   => 'tablecrown',  // nome db
        'user'     => 'root',
        'password' => '',            // vuota in XAMPP di default
        'charset'  => 'utf8'
    ];

    //metodo doctrine per creare la connessione al db dati i parametri di configurazione precedenti
    $connection = DriverManager::getConnection($conn, $config);

    //creo l'entity manager che comunicherà con il db attraverso la connessione creata, sfruttando anche la configurazione doctrine che abbiamo scritto nelle entity 
    //EntityManagaer è una classe Doctrine 
    $entityManager = new EntityManager($connection, $config);

    return $entityManager;
}