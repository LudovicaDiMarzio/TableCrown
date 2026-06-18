<?php
// Presentation/Views/ViewFactory.php

require_once __DIR__ . '/ViewProdotto.php';
require_once __DIR__ . '/ViewCarrello.php';
require_once __DIR__ . '/ViewCatalogo.php';
require_once __DIR__ . '/ViewHome.php';

class ViewFactory {
    private $smarty;

    public function __construct($smarty) {
        $this->smarty = $smarty;
    }

    public function render(string $viewName, array $dati = []) {
        $view = match($viewName) {
            'prodotto' => new ViewProdotto($this->smarty),
            'carrello' => new ViewCarrello($this->smarty),
            'catalogo' => new ViewCatalogo($this->smarty),
            'home'     => new ViewHome($this->smarty),
            default    => throw new \InvalidArgumentException("View '$viewName' non trovata.")
        };

        $view->render($dati);
    }
}