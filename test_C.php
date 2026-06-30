<?php
// test_C.php — eseguito da terminale con: php test_C.php

require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/Foundation/FEntityManager.php';
require_once __DIR__ . '/Foundation/FPersistentManager.php';

use TableCrown\Foundation\FPersistentManager;
use TableCrown\Entity\EProdotto;

echo "Avvio test PersistentManager...\n\n";

$pm = FPersistentManager::getPersistentManager();

echo "=== Test getAll su EProdotto ===\n";
$prodotti = $pm::PMgetAll(EProdotto::class);
echo "Trovati " . count($prodotti) . " prodotti.\n";
var_dump($prodotti);