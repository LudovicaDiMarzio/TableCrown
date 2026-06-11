<?php
// Includi l'autoloader di Composer o Smarty direttamente
require_once 'C:/Users/damic/Desktop/uni/APPUNTI/anno3/secondo_semenstre/Pweb/TableCrown/autoload.php';

$smarty = new Smarty();

// Configura i percorsi delle cartelle che hai creato
$smarty->setTemplateDir(__DIR__ . 'C:/Users/damic/Desktop/uni/APPUNTI/anno3/secondo_semenstre/Pweb/TableCrown/Presentation/smarty-dir/templates/');
$smarty->setCompileDir(__DIR__ . 'C:/Users/damic/Desktop/uni/APPUNTI/anno3/secondo_semenstre/Pweb/TableCrown/Presentation/smarty-dir/templates_c/');
$smarty->setCacheDir(__DIR__ . 'C:/Users/damic/Desktop/uni/APPUNTI/anno3/secondo_semenstre/Pweb/TableCrown/Presentation/smarty-dir/cache/');
$smarty->setConfigDir(__DIR__ . 'C:/Users/damic/Desktop/uni/APPUNTI/anno3/secondo_semenstre/Pweb/TableCrown/Presentation/smarty-dir/configs/');

// Se nel layout usi delle variabili (es. il titolo della pagina), puoi simularle qui
$smarty->assign('page_title', 'Anteprima Layout');

// Mostra il layout (o il template specifico che include il layout)
$smarty->display('common/layout.tpl');