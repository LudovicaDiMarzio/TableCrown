PHP
<?php
require_once __DIR__ . '/vendor/autoload.php'; 

use Smarty\Smarty;
$smarty = new Smarty();

// 1. Ricerca automatica della cartella dei template
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

if (!$smartyDirHandler) {
    echo "<strong style='color:red;'>Impossibile trovare la cartella dei template!</strong><br>";
    echo "Assicurati che la cartella <code>templates</code> sia dentro <code>smarty-dir</code>.";
    exit;
}

// 2. Configurazione dei percorsi di Smarty
$smarty->setTemplateDir($smartyDirHandler . 'templates/');
$smarty->setCompileDir($smartyDirHandler . 'templates_c/');
$smarty->setCacheDir($smartyDirHandler . 'cache/');
$smarty->setConfigDir($smartyDirHandler . 'configs/');

// Definiamo i dati di base per l'header e i link
$smarty->assign('page_title', 'TableCrown — Home');
$smarty->assign('base_url', '/public'); // Modifica se la cartella public ha un percorso diverso

// NOTA: Se hai lasciato i vettori vuoti o non settati, home.tpl mostrerà automaticamente 
// i 4 prodotti demo statici grazie al blocco {else} che abbiamo strutturato insieme.
$smarty->assign('offerte', []); 
$smarty->assign('nuovi_arrivi', []); 

// 3. Tentativo di rendering della HOME
try {
    // MODIFICATO: Puntiamo alla home.tpl. 
    // Se hai salvato home.tpl nella radice di 'templates/', usa semplicemente 'home.tpl'.
    // Se l'hai messa in una sottocartella (es. 'pages/home.tpl'), modifica il percorso di conseguenza.
    $smarty->display('home.tpl'); 
    
} catch (Exception $e) {
    echo "<strong style='color:orange;'>Errore nel caricamento della Home:</strong><br>";
    echo "<i>" . $e->getMessage() . "</i><br><br>";
    echo "<strong>Verifica:</strong> Assicurati di aver salvato il file <code>home.tpl</code> dentro la cartella: <code>" . htmlspecialchars($smartyDirHandler) . "templates/</code>";
}