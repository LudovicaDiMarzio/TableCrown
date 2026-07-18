<?php
// Presentation/Views/ViewCatalogo.php
namespace TableCrown\Presentation\Views;

class ViewCatalogo {

    private const MAPPA_VISTE = [
        'catalogo_giochi'    => ViewGiochiDaTavolo::class,
        'catalogo_bustine'   => ViewBustine::class,
        'catalogo_portadadi' => ViewPortaDadi::class,
        'ricerca'            => ViewGiochiDaTavolo::class, // da confermare col team
        'offerte'            => ViewOfferte::class,        // NUOVA: prodotti misti in sconto
    ];

    public static function render(array $dati): void {
        $vista = $dati['vista'] ?? null;

        if ($vista === null || !isset(self::MAPPA_VISTE[$vista])) {
            throw new \InvalidArgumentException(
                "ViewCatalogo::render() - vista '{$vista}' non riconosciuta."
            );
        }

        $classeVista = self::MAPPA_VISTE[$vista];
        $view = new $classeVista();
        $view->render($dati);
    }
}