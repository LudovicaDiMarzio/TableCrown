<?php
//crea le tabelle nel db seguendo le annotation doctrine
require_once 'bootstrap.php';

use Doctrine\ORM\Tools\SchemaTool;
use TableCrown\Entity\EPersona;
use TableCrown\Entity\EUtente;
use TableCrown\Entity\EAmministratore;
use TableCrown\Entity\ESegnalazione;
use TableCrown\Entity\EMotivazione;
use TableCrown\Entity\EProvvedimento;
use TableCrown\Entity\EBustine;
//il carrello sarà gestito in sessione
//use TableCrown\Entity\ECarrello;
//use TableCrown\Entity\ECarrelloItem;
use TableCrown\Entity\ECartaDiCredito;
use TableCrown\Entity\EChallenge;
use TableCrown\Entity\EDanno;
use TableCrown\Entity\EEvento;
use TableCrown\Entity\EGestore;
use TableCrown\Entity\EGiocoDaTavolo;
use TableCrown\Entity\EIndirizzo;
use TableCrown\Entity\EOrdine;
use TableCrown\Entity\EOrdineItem;
use TableCrown\Entity\EPartecipazione;
use TableCrown\Entity\EPortaDadi;
use TableCrown\Entity\EPrezzo;
use TableCrown\Entity\EProdotto;
use TableCrown\Entity\ERecensione;
use TableCrown\Entity\ETorneo;
use TableCrown\Entity\ESerata;
use TableCrown\Entity\EWishlist;

//creo l'entity manager sfruttando il codice di bootstrap.php
$entityManager = getEntityManagerBoot();

// Gestisce gli enum come stringhe
$platform = $entityManager->getConnection()->getDatabasePlatform();
if (!$platform->hasDoctrineTypeMappingFor('enum')) {
    $platform->registerDoctrineTypeMapping('enum', 'string');
}

//per aggirare i sistemi di sicurezza dei db, altrimenti non potrei ricostruire il db da capo ogni volta
$entityManager->getConnection()->executeStatement('SET FOREIGN_KEY_CHECKS = 0');

$schemaTool = new SchemaTool($entityManager);

//elenco di tutte le classi che volgio trasformare in tabelle
$classes = [
    $entityManager->getClassMetadata(EUtente::class),
    $entityManager->getClassMetadata(EAmministratore::class),
    $entityManager->getClassMetadata(ESegnalazione::class),
    $entityManager->getClassMetadata(EMotivazione::class),
    $entityManager->getClassMetadata(EProvvedimento::class),
    $entityManager->getClassMetadata(EBustine::class),
    //$entityManager->getClassMetadata(ECarrello::class),
    //$entityManager->getClassMetadata(ECarrelloItem::class),
    $entityManager->getClassMetadata(ECartaDiCredito::class),
    $entityManager->getClassMetadata(EChallenge::class),
    $entityManager->getClassMetadata(EDanno::class),
    $entityManager->getClassMetadata(EEvento::class),
    $entityManager->getClassMetadata(EGestore::class),
    $entityManager->getClassMetadata(EGiocoDaTavolo::class),
    $entityManager->getClassMetadata(EIndirizzo::class),
    $entityManager->getClassMetadata(EOrdine::class),
    $entityManager->getClassMetadata(EOrdineItem::class),
    $entityManager->getClassMetadata(EPartecipazione::class),
    $entityManager->getClassMetadata(EPersona::class),
    $entityManager->getClassMetadata(EPortaDadi::class),
    $entityManager->getClassMetadata(EPrezzo::class),
    $entityManager->getClassMetadata(EProdotto::class),
    $entityManager->getClassMetadata(ERecensione::class),
    $entityManager->getClassMetadata(ESerata::class),
    $entityManager->getClassMetadata(ETorneo::class),
    $entityManager->getClassMetadata(EWishlist::class)
];

$schemaTool->dropDatabase();   // cancella le vecchie tabelle, se esistenti
$schemaTool->createSchema($classes);  // crea le tabelle del db

//creazione del db
$entityManager->getConnection()->executeStatement('SET FOREIGN_KEY_CHECKS = 1');

echo "Database creato con successo!\n";