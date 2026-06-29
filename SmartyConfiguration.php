<?php
// Presentation/Views/SmartyConfiguration.php

require_once __DIR__ . '/../../config.php';

class SmartyConfiguration {
    private static $instance = null;

    public static function getSmarty(): Smarty {
        if (self::$instance === null) {
            self::$instance = new Smarty();
            self::$instance->setTemplateDir(__DIR__ . '/../templates/');
            self::$instance->setCompileDir(__DIR__ . '/../templates_c/');
        }
        return self::$instance;
    }
}