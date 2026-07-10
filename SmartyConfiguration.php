<?php
// Presentation/Views/SmartyConfiguration.php
namespace TableCrown\Presentation\Views;

use Smarty\Smarty;

require_once __DIR__ . '/../../config.php'; // config.php è procedurale, non autoloadabile

class SmartyConfiguration {
    private static ?Smarty $instance = null;

    public static function getSmarty(): Smarty {
        if (self::$instance === null) {
            self::$instance = new Smarty();
            self::$instance->setTemplateDir(PRESENTATION_PATH . '/templates/');
            self::$instance->setCompileDir(PRESENTATION_PATH . '/templates_c/');
        }
        return self::$instance;
    }
}