<?php
//crea le tabelle nel db seguendo le annotation doctrine
require_once 'bootstrap.php';

use Doctrine\ORM\Tools\SchemaTool;
use TableCrown\Entity\EUtente;
use TableCrown\Entity\EAmministratore;
use TableCrown\Entity\ESegnalazione;
use TableCrown\Entity\EMotivazione;
use TableCrown\Entity\EProvvedimento;
// aggiungi tutte le altre entità

$entityManager = getEntityManager();

// Gestisce gli enum come stringhe
$platform = $entityManager->getConnection()->getDatabasePlatform();
if (!$platform->hasDoctrineTypeMappingFor('enum')) {
    $platform->registerDoctrineTypeMapping('enum', 'string');
}

$entityManager->getConnection()->executeStatement('SET FOREIGN_KEY_CHECKS = 0');

$schemaTool = new SchemaTool($entityManager);

$classes = [
    $entityManager->getClassMetadata(EUtente::class),
    $entityManager->getClassMetadata(EAmministratore::class),
    $entityManager->getClassMetadata(ESegnalazione::class),
    $entityManager->getClassMetadata(EMotivazione::class),
    $entityManager->getClassMetadata(EProvvedimento::class),
    // aggiungi tutte le altre entità
];

$schemaTool->dropDatabase();   // cancella il db esistente
$schemaTool->createSchema($classes);  // crea le tabelle

$entityManager->getConnection()->executeStatement('SET FOREIGN_KEY_CHECKS = 1');

echo "Database creato con successo!\n";