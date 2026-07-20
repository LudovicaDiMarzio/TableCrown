<?php
// Presentation/Views/BaseViewEventi.php
namespace TableCrown\Presentation\Views;

use Smarty\Smarty;

abstract class BaseViewEventi implements ViewEventiInterface {

    protected function assegnaDati(Smarty $smarty, array $dati): void {
        foreach ($dati as $chiave => $valore) {
            if ($chiave === 'vista') {
                continue;
            }
            $smarty->assign($chiave, $valore);
        }
    }

    /**
     * Metodo di default per la visualizzazione del dettaglio dell'evento.
     * Le viste che non gestiscono i dettagli (es. ViewEventiHome) erediteranno questo comportamento di default.
     *
     * @param array $dati Dati dell'evento.
     * @param bool $isTerminato Flag che indica se l'evento è concluso.
     * @throws \BadMethodCallException Se la vista corrente non supporta i dettagli.
     */
    public function mostraDettagliEvento(array $dati, bool $isTerminato = false): void {
        throw new \BadMethodCallException(
            "La vista " . get_class($this) . " non supporta la visualizzazione del dettaglio dell'evento."
        );
    }
}