<?php
require_once __DIR__ . '/vendor/autoload.php'; 

use Smarty\Smarty;
$smarty = new Smarty();
// Sostituito 'Presentation' con 'presentation'
$templatedir = __DIR__ . '/presentation/view_smarty_dir/templates/';
$compiledir  = __DIR__ . '/presentation/view_smarty_dir/templates_c/';
$cachedir    = __DIR__ . '/presentation/view_smarty_dir/cache/';
$configdir   = __DIR__ . '/presentation/view_smarty_dir/configs/';
// DEBUG REALE: Adesso stamperà la cartella corretta senza Warning
if (!is_dir($templatedir)) {
    echo "<strong style='color:red;'>ERRORE DI PERCORSO!</strong><br>";
    echo "Smarty sta cercando la cartella qui: <br><code>" . htmlspecialchars($templatedir) . "</code><br><br>";
    echo "<strong>Cosa controllare adesso:</strong><br>";
    echo "1. Controlla se la cartella 'Presentation' ha la 'P' maiuscola o minuscola nel tuo computer.<br>";
    echo "2. Controlla se la cartella si chiama esattamente 'view_smarty_dir'.<br>";
    exit;
}

// Se la cartella esiste, impostiamo i percorsi in Smarty
$smarty->setTemplateDir($templatedir);
$smarty->setCompileDir($compiledir);
$smarty->setCacheDir($cachedir);
$smarty->setConfigDir($configdir);

$smarty->assign('page_title', 'Anteprima Layout');

// Mostra il template
$smarty->display('common/layout.tpl');