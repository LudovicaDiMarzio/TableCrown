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

    /**
     * Gestisce la visualizzazione dei dettagli di un singolo evento.
     * Rileva lo stato dell'evento per capire se è terminato e richiama la vista corretta.
     *
     * @param array $dati Dati dell'evento da passare alla vista.
     * @throws \InvalidArgumentException Se il tipo di evento non è riconosciuto.
     */
    public static function mostraDettaglioEvento(array $dati): void {
        // 1. Controlliamo se lo stato è "terminato"
        $stato = $dati['statoEvento'] ?? $dati['stato'] ?? '';
        if (is_object($stato) && method_exists($stato, 'value')) {
            $stato = $stato->value;
        }
        $isTerminato = (strtolower((string)$stato) === 'terminato');

        // 2. Determiniamo il tipo di evento per instanziare la vista giusta
        $tipo = $dati['tipo'] ?? $dati['tipoEvento'] ?? '';
        if (is_object($tipo) && method_exists($tipo, 'value')) {
            $tipo = $tipo->value;
        }
        $tipo = strtolower((string)$tipo);

        // Mappa delle tipologie di evento sulle chiavi di MAPPA_VISTE
        $tipoMappa = [
            'serata'     => 'eventi_serate',
            'serate'     => 'eventi_serate',
            'torneo'     => 'eventi_tornei',
            'tornei'     => 'eventi_tornei',
            'challenge'  => 'eventi_challenge',
            'challenges' => 'eventi_challenge',
        ];

        if (empty($tipo) || !isset($tipoMappa[$tipo])) {
            throw new \InvalidArgumentException(
                "ViewEventi::mostraDettaglioEvento() - tipo evento '{$tipo}' non valido o non riconosciuto."
            );
        }

        $vistaChiave = $tipoMappa[$tipo];
        $classeVista = self::MAPPA_VISTE[$vistaChiave];
        
        $view = new $classeVista();
        $view->mostraDettagliEvento($dati, $isTerminato);
    }
}