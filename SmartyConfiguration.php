<?php
// SmartyConfiguration.php (root)

use Smarty\Smarty;

require_once __DIR__ . '/config.php';

class SmartyConfiguration {
    private static ?Smarty $instance = null;

    public static function getSmarty(): Smarty {
        if (self::$instance === null) {
            self::$instance = new Smarty();
            self::$instance->setTemplateDir(SMARTY_DIR . '/templates/');
            self::$instance->setCompileDir(SMARTY_DIR . '/templates_c/');
        }
        return self::$instance;
    }
}