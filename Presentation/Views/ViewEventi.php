<?php
// Presentation/Views/ViewEventi.php
namespace TableCrown\Presentation\Views;

class ViewEventi {

    private const MAPPA_VISTE = [
        'eventi_home'      => ViewEventiHome::class,
        'eventi_tornei'    => ViewEventiTornei::class,
        'eventi_challenge' => ViewEventiChallenge::class,
        'eventi_serate'    => ViewEventiSerate::class,
    ];

    public static function mostraEventi(array $dati): void {
        $vista = $dati['vista'] ?? null;

        if ($vista === null || !isset(self::MAPPA_VISTE[$vista])) {
            throw new \InvalidArgumentException(
                "ViewEventi::mostraEventi() - vista '{$vista}' non riconosciuta."
            );
        }

        $classeVista = self::MAPPA_VISTE[$vista];
        $view = new $classeVista();
        $view->render($dati); // qui resta render(): è la chiamata interna verso la vista concreta
    }
}