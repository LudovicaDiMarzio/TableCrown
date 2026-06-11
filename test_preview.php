<?php
// Includi l'autoloader di Composer o Smarty direttamente
require_once 'C:/Users/damic/Desktop/uni/APPUNTI/anno3/secondo_semenstre/Pweb/TableCrown/vendor/autoload.php';

use Smarty\Smarty;

$smarty = new Smarty();

// Configura i percorsi delle cartelle che hai creato
$smarty->setTemplateDir(__DIR__ . 'C:/Users/damic/Desktop/uni/APPUNTI/anno3/secondo_semenstre/Pweb/TableCrown/Presentation/smarty-dir/templates/');
$smarty->setCompileDir(__DIR__ . 'C:/Users/damic/Desktop/uni/APPUNTI/anno3/secondo_semenstre/Pweb/TableCrown/Presentation/smarty-dir/templates_c/');
$smarty->setCacheDir(__DIR__ . 'C:/Users/damic/Desktop/uni/APPUNTI/anno3/secondo_semenstre/Pweb/TableCrown/Presentation/smarty-dir/cache/');
$smarty->setConfigDir(__DIR__ . 'C:/Users/damic/Desktop/uni/APPUNTI/anno3/secondo_semenstre/Pweb/TableCrown/Presentation/smarty-dir/configs/');

// 2. DEBUG TEMPORANEO: Controlliamo se Windows vede davvero questa cartella
if (!is_dir($templateDir)) {
    echo "<strong style='color:red;'>ERRORE DI PERCORSO!</strong><br>";
    echo "Smarty sta cercando i template qui: <br><code>" . htmlspecialchars($templateDir) . "</code><br>";
    echo "Ma questa cartella NON esiste. Controlla se hai scritto bene le maiuscole o se si chiama 'view_smarty_dir'.";
    exit;
}

// 3. Se la cartella esiste, la impostiamo in Smarty
$smarty->setTemplateDir($templateDir);
$smarty->setCompileDir($compileDir);
$smarty->setCacheDir($cacheDir);
$smarty->setConfigDir($configDir);

$smarty->assign('page_title', 'Anteprima Layout');

// 4. Mostra il template
$smarty->display('common/layout.tpl');