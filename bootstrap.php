<?php
//configura la connessione al db
require_once __DIR__ . '/vendor/autoload.php';

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\DriverManager;

function getEntityManager(): EntityManager
{
    $config = ORMSetup::createAttributeMetadataConfiguration(
        paths: [__DIR__ . '/Entity'],  // cartella entità
        isDevMode: true
    );

    $conn = [
        'driver'   => 'pdo_mysql',
        'host'     => 'localhost',
        'dbname'   => 'tablecrown',  // nome db
        'user'     => 'root',
        'password' => '',            // vuota in XAMPP di default
        'charset'  => 'utf8'
    ];

    $connection = DriverManager::getConnection($conn, $config);
    return  new EntityManager($connection, $config);
}