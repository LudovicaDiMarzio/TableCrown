<?php
require_once __DIR__ . '/vendor/autoload.php'; 

use Smarty\Smarty;
$smarty = new Smarty();

// 1. Cerchiamo automaticamente dove si trova la cartella dei template
$possibiliPercorsi = [
    __DIR__ . '/smarty-dir/',
    __DIR__ . '/Presentation/smarty-dir/',
    __DIR__ . '/Presentation/Views/smarty-dir/',
    __DIR__ . '/presentation/smarty-dir/'
];

$smartyDirHandler = null;

foreach ($possibiliPercorsi as $percorso) {
    if (is_dir($percorso . 'templates/')) {
        $smartyDirHandler = $percorso;
        break;
    }
}

// Se non lo trova neanche così, facciamo un controllo disperato ma efficacissimo
if (!$smartyDirHandler) {
    echo "<strong style='color:red;'>Impossibile trovare la cartella dei template!</strong><br>";
    echo "Assicurati che la cartella <code>templates</code> (con all'interno <code>common/layout.tpl</code>) sia dentro <code>smarty-dir</code>.";
    exit;
}

// 2. Configurazione dinamica dei percorsi trovati
$smarty->setTemplateDir($smartyDirHandler . 'templates/');
$smarty->setCompileDir($smartyDirHandler . 'templates_c/');
$smarty->setCacheDir($smartyDirHandler . 'cache/');
$smarty->setConfigDir($smartyDirHandler . 'configs/');

$smarty->assign('page_title', 'Anteprima Layout');
$smarty->assign('base_url', '/public');

// 3. Tentativo di rendering
try {
    $smarty->display('common/layout.tpl');
} catch (Exception $e) {
    echo "<strong style='color:orange;'>Smarty è stato configurato qui:</strong> <code>" . htmlspecialchars($smartyDirHandler) . "</code><br>";
    echo "Ma ha riscontrato questo errore: <br><i>" . $e->getMessage() . "</i><br><br>";
    echo "<strong>Verifica interna:</strong> Controlla che dentro <code>" . htmlspecialchars($smartyDirHandler) . "templates/</code> ci sia effettivamente una cartella chiamata <code>common</code> con dentro il file <code>layout.tpl</code> (attento ai caratteri minuscoli/maiuscoli del nome del file!).";
}