<?php
require_once __DIR__ . '/vendor/autoload.php'; 

use Smarty\Smarty;
$smarty = new Smarty();

// Configurazione dei percorsi basata sulla tua vera struttura delle cartelle
$smarty->setTemplateDir(__DIR__ . '/smarty-dir/templates/');
$smarty->setCompileDir(__DIR__ . '/smarty-dir/templates_c/');
$smarty->setCacheDir(__DIR__ . '/smarty-dir/cache/');
$smarty->setConfigDir(__DIR__ . '/smarty-dir/configs/');

// Assegniamo una variabile per il titolo (se usata nel layout)
$smarty->assign('page_title', 'Anteprima Layout TableCrown');

// Mostra il layout
$smarty->display('common/layout.tpl');