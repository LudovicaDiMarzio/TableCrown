<?php
// Presentation/Views/ViewEventiSerate.php
namespace TableCrown\Presentation\Views;

use SmartyConfiguration;

class ViewEventiSerate extends BaseViewEventi {
    private const TEMPLATE = 'catalogo_serate.tpl';

    public function render(array $dati): void {
        $smarty = SmartyConfiguration::getSmarty();
        $this->assegnaDati($smarty, $dati);
        $smarty->display(self::TEMPLATE);
    }

    public function mostraDettagliEvento(array $dati, bool $isTerminato = false): void {
        $smarty = SmartyConfiguration::getSmarty();

        // Formattazione data per template attivo
        $dataRaw = $dati['dataInizio'] ?? $dati['data'] ?? '';
        $dataFormattata = $dataRaw;
        if ($dataRaw instanceof \DateTime) {
            $dataFormattata = $dataRaw->format('d/m/Y');
        } elseif (is_string($dataRaw) && preg_match('/^\d{4}-\d{2}-\d{2}/', $dataRaw)) {
            $dataFormattata = date('d/m/Y', strtotime($dataRaw));
        }

        if (!isset($dati['serata'])) {
            $dati['serata'] = [
                'id'           => $dati['idEvento'] ?? $dati['id'] ?? null,
                'nome'         => $dati['nomeEvento'] ?? $dati['nome'] ?? '',
                'immagine'     => $dati['imgEvento'] ?? $dati['immagine'] ?? '',
                'data'         => $dataFormattata,
                'postiLiberi'  => $dati['postiDisponibili'] ?? $dati['postiLiberi'] ?? 0,
                'postiTotali'  => $dati['maxPartecipanti'] ?? $dati['postiTotali'] ?? 0,
                'nomeAttivita' => $dati['tipoSerata'] ?? $dati['nomeAttivita'] ?? '',
                'descrizione'  => $dati['descrizioneEvento'] ?? $dati['descrizione'] ?? '',
                'recensioni'   => $dati['recensioni'] ?? [],
            ];
        }

        $this->assegnaDati($smarty, $dati);

        if ($isTerminato) {
            $smarty->display('dettaglio_serata_terminato.tpl');
        } else {
            $smarty->display('dettagliSerata.tpl');
        }
    }
}