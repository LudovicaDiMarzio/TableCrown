<?php
// Presentation/Views/ViewDettaglioEvento.php

namespace TableCrown\Presentation\Views;

/**
 * Class ViewDettaglioEvento
 * Gestisce il dispatch della vista di dettaglio di un evento (Serata, Torneo, Challenge)
 * in base al suo stato (attivo o terminato) e alla sua tipologia.
 */
class ViewDettaglioEvento {

    /**
     * Mappa i tipi di evento alle relative classi View concrete.
     */
    private const MAPPA_VISTE = [
        'serata'    => ViewEventiSerate::class,
        'challenge' => ViewEventiChallenge::class,
        'torneo'    => ViewEventiTornei::class,
    ];

    /**
     * Mostra la pagina di dettaglio dell'evento.
     *
     * @param array $dati Dati dell'evento e di contesto da passare a Smarty.
     * @throws \InvalidArgumentException Se il tipo di evento non è riconosciuto.
     */
    public static function mostraDettaglioEvento(array $dati): void {
        // 1. Rileviamo lo stato dell'evento per capire se è concluso/terminato
        $stato = $dati['statoEvento'] ?? $dati['stato'] ?? '';
        if (is_object($stato) && method_exists($stato, 'value')) {
            $stato = $stato->value;
        }
        $isTerminato = (strtolower((string)$stato) === 'terminato');

        // 2. Rileviamo il tipo di evento (serata, challenge, torneo)
        $tipo = $dati['tipo'] ?? $dati['tipoEvento'] ?? '';
        if (is_object($tipo) && method_exists($tipo, 'value')) {
            $tipo = $tipo->value;
        }
        $tipo = strtolower((string)$tipo);

        // Normalizzazione del tipo nel caso sia al plurale o abbia formati diversi
        if ($tipo === 'serate') {
            $tipo = 'serata';
        } elseif ($tipo === 'tornei') {
            $tipo = 'torneo';
        } elseif ($tipo === 'challenges') {
            $tipo = 'challenge';
        }

        if (empty($tipo) || !isset(self::MAPPA_VISTE[$tipo])) {
            throw new \InvalidArgumentException(
                "ViewDettaglioEvento::mostraDettaglioEvento() - tipo evento '{$tipo}' non valido o non riconosciuto."
            );
        }

        // 3. Istanziamo la vista specifica e deleghiamo la visualizzazione
        $classeVista = self::MAPPA_VISTE[$tipo];
        $vistaConcreta = new $classeVista();
        
        $vistaConcreta->mostraDettagliEvento($dati, $isTerminato);
    }
}
