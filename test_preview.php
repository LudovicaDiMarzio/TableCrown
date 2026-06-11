<?php
// Includi l'autoloader di Composer o Smarty direttamente
require_once __DIR__ . '/../vendor/autoload.php'; // Aggiusta il path in base a dove si trova

$smarty = new Smarty();

// Configura i percorsi delle cartelle che hai creato
$smarty->setTemplateDir(__DIR__ . '/presentation/view_smarty_dir/templates/');
$smarty->setCompileDir(__DIR__ . '/presentation/view_smarty_dir/templates_c/');
$smarty->setCacheDir(__DIR__ . '/presentation/view_smarty_dir/cache/');
$smarty->setConfigDir(__DIR__ . '/presentation/view_smarty_dir/configs/');

// Se nel layout usi delle variabili (es. il titolo della pagina), puoi simularle qui
$smarty->assign('page_title', 'Anteprima Layout');

// Mostra il layout (o il template specifico che include il layout)
$smarty->display('common/layout.tpl');