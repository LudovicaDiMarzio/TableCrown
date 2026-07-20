<?php
// Presentation/Views/ViewEventiInterface.php
namespace TableCrown\Presentation\Views;

interface ViewEventiInterface {
    public function render(array $dati): void;
    public function mostraDettagliEvento(array $dati, bool $isTerminato = false): void;
}