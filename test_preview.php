<?php
require_once __DIR__ . '/vendor/autoload.php'; 

use Smarty\Smarty;
$smarty = new Smarty();

// Usiamo realpath per azzerare i problemi di slash, maiuscole e minuscole di Windows
$basePath = realpath(__DIR__);

// Proviamo a cercare la cartella provando sia la P maiuscola che minuscola automaticamente
$subFolder = '/Presentation/view_smarty_dir';
if (!is_dir($basePath . $subFolder)) {
    $subFolder = '/presentation/view_smarty_dir'; // ripiego su minuscolo
}

$templatedir = realpath($basePath . $subFolder . '/templates');
$compiledir  = realpath($basePath . $subFolder . '/templates_c');
$cachedir    = realpath($basePath . $subFolder . '/cache');
$configdir   = realpath($basePath . $subFolder . '/configs');

// DEBUG DEFINITIVO
if (!$templatedir || !is_dir($templatedir)) {
    echo "<strong style='color:red;'>DIAGNOSTICA PERCORSI fallita!</strong><br><br>";
    echo "La root del progetto è rilevata come: <code>" . htmlspecialchars($basePath) . "</code><br>";
    echo "Sto cercando di entrare in una cartella chiamata <code>presentation</code> o <code>Presentation</code> che contenga al suo interno <code>view_smarty_dir</code>.<br><br>";
    echo "<strong>Cosa fare ora:</strong> Apri la cartella <code>TableCrown</code> su Windows e controlla se i nomi di queste cartelle sono scritti esattamente così, o se per caso hai inserito <code>view_smarty_dir</code> dentro qualcos'altro (es. dentro <code>src</code> o direttamente nella root).";
    exit;
}

// Se i percorsi sono validi, li passiamo a Smarty
$smarty->setTemplateDir($templatedir);
$smarty->setCompileDir($compiledir);
$smarty->setCacheDir($cachedir);
$smarty->setConfigDir($configdir);

$smarty->assign('page_title', 'Anteprima Layout');

// Mostra il template
$smarty->display('common/layout.tpl');