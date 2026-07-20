{*
  TableCrown\Presentation\Views\Gestore - Dettaglio Challenge
  Estende layout_gestore.tpl.

  Variabili di pagina (da costruisciDatiVistaEvento(), modalita: 'gestore'):
    idEvento, nomeEvento, imgEvento, dataInizio, maxPartecipanti, statoEvento,
    numeroPartecipanti, richiedeQuota, postiDisponibili,
    tipo ('challenge'), quotaIscrizione,
    premio => card prodotto completa (prodottoToArray),
    tornei => array di torneoToArray() COMPLETI (non più link minimi come nel catalogo),
    punteggi => ['primo','secondo','terzo'] punti assegnati per piazzamento nei singoli tornei,
    descrizioneEvento, postiRimanenti, hasPostiDisponibili,
    vista = 'gestore_dettaglio_challenge'

  Se statoEvento === 'terminato', in più:
    classificaGenerata (bool)
    se true  => classificaFinale => lista ordinata completa ['posizione','punteggioTotale','utente']
    se false => torneiSenzaEsito => lista tornei senza podio ['id','nome']

  TODO T1 (segnalato a Control):
  - Ogni torneo dentro $tornei è prodotto da torneoToArray(), NON da
    costruisciDatiVistaEvento(): quindi NON ha ancora un campo 'podio' proprio
    (nè 'iscritti'). Per riusare qui lo stesso meccanismo del dettaglio torneo
    (sezione 3 del documento) serve che Control aggiunga anche a ogni torneo
    dentro $tornei i campi 'podio' e 'iscritti', altrimenti la UI qui sotto
    mostrerà sempre "Aggiungi esito" con selettori vuoti anche per tornei che
    un podio ce l'hanno già.
  - torneiSenzaEsito(): il metodo nel BaseController ha un bug, sovrascrive
    $mancanti invece di accumulare (manca [] su $mancanti[] = ...): oggi
    restituisce al massimo un solo torneo anche se ne mancano di più.
  - generaClassificaChallengeGestore() legge da POST 'id_challenge', non
    'id_evento' come indicato nel documento: il form sotto usa 'id_challenge'
    per essere coerente col controller reale, va however riallineato il documento.
  - Ogni torneo in $tornei ha anche il campo 'challenge' (torneoToArray lo
    include sempre) che punta a questa stessa challenge: qui lo ignoriamo
    volutamente in UI, come già indicato nella lista challenge.

  NOTA UI: "Modifica dati evento" ora è un popup nativo (<dialog>), non più
  un pannello a toggle CSS. Serve aggiungere in eventi_gestore_dettaglio.css:
  .gdet-modal, .gdet-modal::backdrop, .gdet-modal__content, .gdet-modal__close,
  .gdet-modal__actions.
*}
{extends file="layout_gestore.tpl"}

{block name="page_css"}
    <link rel="stylesheet" href="{$base_url}/css/eventi_gestore_dettaglio.css">
{/block}

{block name="content"}

{assign var="stato" value=$statoEvento|lower}

<div class="gdet-container">

    <a href="{$base_url}/gestore/eventi/challenge" class="gdet-back">
        <i class="ti ti-arrow-left"></i> Torna alle challenge
    </a>

    {* ── HEADER ── *}
    <div class="gdet-header">
        <div class="gdet-header__img-wrapper">
            <img src="{$imgEvento}" alt="{$nomeEvento|escape}" class="gdet-header__img">
            <span class="gdet-status gdet-status--{$stato}">{$statoEvento}</span>
        </div>

        <div class="gdet-header__info">
            <span class="gdet-type">Challenge &middot; {$tornei|@count} tornei</span>
            <h1 class="gdet-title">{$nomeEvento|escape}</h1>

            <div class="gdet-meta">
                <span class="gdet-meta-row">
                    <i class="ti ti-calendar"></i> {$dataInizio|date_format:"%d %B %Y, %H:%M"}
                </span>
                <span class="gdet-meta-row{if $postiRimanenti <= 0} gdet-meta-row--full{/if}">
                    <i class="ti ti-users"></i>
                    {$numeroPartecipanti} / {$maxPartecipanti} iscritti
                    {if $postiRimanenti <= 0}&mdash; Al completo{else}&mdash; {$postiRimanenti} posti liberi{/if}
                </span>
                <span class="gdet-meta-row">
                    <i class="ti ti-ticket"></i>
                    {if $richiedeQuota}&euro;{$quotaIscrizione|number_format:2} iscrizione{else}Iscrizione gratuita{/if}
                </span>
            </div>
        </div>
    </div>

    {* ── DESCRIZIONE + PREMIO + PUNTEGGI ── *}
    <section class="gdet-section">
        <h2 class="gdet-section__title"><i class="ti ti-file-description"></i> Descrizione</h2>
        <p class="gdet-section__text">{$descrizioneEvento|escape|nl2br}</p>
    </section>

    <section class="gdet-section">
        <h2 class="gdet-section__title"><i class="ti ti-gift"></i> Premio in palio</h2>
        <div class="gdet-premio-card">
            <img src="{$premio.immagine}" alt="{$premio.nome|escape}" class="gdet-premio-card__img">
            <div class="gdet-premio-card__info">
                <span class="gdet-premio-card__name">{$premio.nome|escape}</span>
                {if $premio.sconto}
                    <span class="gdet-premio-card__price gdet-premio-card__price--old">&euro;{$premio.prezzo|number_format:2}</span>
                    <span class="gdet-premio-card__price">&euro;{$premio.prezzo_scontato|number_format:2}</span>
                {else}
                    <span class="gdet-premio-card__price">&euro;{$premio.prezzo|number_format:2}</span>
                {/if}
            </div>
        </div>
    </section>

    <section class="gdet-section">
        <h2 class="gdet-section__title"><i class="ti ti-star"></i> Punteggi challenge</h2>
        <p class="gdet-section__text">Punti assegnati in base al piazzamento ottenuto in ciascun torneo incluso:</p>
        <div class="gdet-punteggi">
            <span class="gdet-punteggi__item"><i class="ti ti-medal"></i> 1&deg; posto: {$punteggi.primo} punti</span>
            <span class="gdet-punteggi__item"><i class="ti ti-medal-2"></i> 2&deg; posto: {$punteggi.secondo} punti</span>
            <span class="gdet-punteggi__item"><i class="ti ti-medal-2"></i> 3&deg; posto: {$punteggi.terzo} punti</span>
        </div>
    </section>

    {* ── AZIONI GESTORE (stato) ── *}
    <section class="gdet-section gdet-actions">
        <h2 class="gdet-section__title"><i class="ti ti-settings"></i> Gestione evento</h2>

        <div class="gdet-actions__grid">

            {if $stato == 'programmato'}
                {assign var="oraCorrente" value=$smarty.now|date_format:"%Y-%m-%d %H:%M:%S"}
                {assign var="giaIniziata" value=$dataInizio <= $oraCorrente}
                {if $giaIniziata}
                    <form method="post" action="{$base_url}/gestore/eventi/attiva" class="gdet-action-form">
                        <input type="hidden" name="id_evento" value="{$idEvento}">
                        <button type="submit" class="gdet-btn gdet-btn--success">
                            <i class="ti ti-player-play"></i> Attiva evento
                        </button>
                    </form>
                {else}
                    <span class="gdet-btn gdet-btn--disabled" title="Disponibile solo dopo la data di inizio ({$dataInizio|date_format:"%d %B %Y, %H:%M"})">
                        <i class="ti ti-player-play"></i> Attiva evento
                    </span>
                {/if}

                <form method="post" action="{$base_url}/gestore/eventi/annulla" class="gdet-action-form" onsubmit="return confirm('Annullare questa challenge?');">
                    <input type="hidden" name="id_evento" value="{$idEvento}">
                    <button type="submit" class="gdet-btn gdet-btn--warning">
                        <i class="ti ti-ban"></i> Annulla evento
                    </button>
                </form>
            {/if}

            {if $stato == 'in_corso'}
                <form method="post" action="{$base_url}/gestore/eventi/concludi" class="gdet-action-form" onsubmit="return confirm('Concludere questa challenge?');">
                    <input type="hidden" name="id_evento" value="{$idEvento}">
                    <button type="submit" class="gdet-btn gdet-btn--success">
                        <i class="ti ti-flag-check"></i> Concludi evento
                    </button>
                </form>
            {/if}

            <button type="button" class="gdet-btn gdet-btn--info" onclick="document.getElementById('modal-modifica').showModal()">
                <i class="ti ti-edit"></i> Modifica dati
            </button>

            {if $stato == 'annullato'}
                <input type="checkbox" id="toggle-riprogramma" class="gdet-toggle-checkbox">
                <label for="toggle-riprogramma" class="gdet-btn gdet-btn--primary">
                    <i class="ti ti-calendar-repeat"></i> Riprogramma
                </label>
            {/if}
        </div>

        {* ── POPUP: Modifica dati evento (conforme a CGestore::modificaEventoGestore) ── *}
        <dialog class="gdet-modal" id="modal-modifica">
            <div class="gdet-modal__content">
                <button type="button" class="gdet-modal__close" onclick="document.getElementById('modal-modifica').close()" aria-label="Chiudi">
                    <i class="ti ti-x"></i>
                </button>

                <h3 class="gdet-panel__title">Modifica dati evento</h3>
                <p class="gdet-panel__hint">Non è possibile modificare data o stato da qui: usa i pulsanti dedicati sopra.</p>

                <form method="post" action="{$base_url}/gestore/eventi/modifica" enctype="multipart/form-data" class="gdet-form">
                    <input type="hidden" name="id_evento" value="{$idEvento}">

                    <label class="gdet-form__label" for="nomeEvento">Nome evento</label>
                    <input type="text" id="nomeEvento" name="nomeEvento" class="gdet-form__input" value="{$nomeEvento|escape}" maxlength="255" required>

                    <label class="gdet-form__label" for="descrizioneEvento">Descrizione</label>
                    <textarea id="descrizioneEvento" name="descrizioneEvento" class="gdet-form__textarea" rows="4" required>{$descrizioneEvento|escape}</textarea>

                    <label class="gdet-form__label" for="maxPartecipanti">Numero massimo partecipanti</label>
                    <input type="number" id="maxPartecipanti" name="maxPartecipanti" class="gdet-form__input" value="{$maxPartecipanti}" min="{$numeroPartecipanti}" required>

                    <label class="gdet-form__label" for="imgEvento">Immagine (lascia vuoto per non modificarla)</label>
                    <img src="{$imgEvento}" alt="Immagine attuale" class="gdet-form__img-preview">
                    <input type="file" id="imgEvento" name="imgEvento" class="gdet-form__input" accept="image/*">

                    <div class="gdet-modal__actions">
                        <button type="button" class="gdet-btn gdet-btn--muted" onclick="document.getElementById('modal-modifica').close()">
                            Annulla
                        </button>
                        <button type="submit" class="gdet-btn gdet-btn--success">
                            <i class="ti ti-device-floppy"></i> Salva modifiche
                        </button>
                    </div>
                </form>
            </div>
        </dialog>

        {if $stato == 'annullato'}
            <div class="gdet-panel" id="panel-riprogramma">
                <h3 class="gdet-panel__title">Riprogramma evento</h3>
                <p class="gdet-panel__hint">Imposta una nuova data futura: l'evento tornerà in stato "Programmato".</p>
                <form method="post" action="{$base_url}/gestore/eventi/riprogramma" class="gdet-form" id="form-riprogramma-{$idEvento}">
                    <input type="hidden" name="id_evento" value="{$idEvento}">
                    <label class="gdet-form__label" for="nuovaDataInizio">Nuova data e ora</label>
                    <input type="datetime-local" id="nuovaDataInizio" name="nuovaDataInizio" class="gdet-form__input" required>
                    <button type="submit" class="gdet-btn gdet-btn--primary">
                        <i class="ti ti-calendar-repeat"></i> Conferma riprogrammazione
                    </button>
                </form>
            </div>
        {/if}
    </section>

    {* ── SEZIONE 4: TORNEI + CLASSIFICA FINALE ── *}
    {if $stato == 'terminato'}
        <section class="gdet-section" id="tornei">
            <h2 class="gdet-section__title"><i class="ti ti-trophy"></i> Tornei ed esiti</h2>

            {if !$classificaGenerata}

                {if isset($torneiSenzaEsito) && $torneiSenzaEsito|@count > 0}
                    <p class="gdet-warning">
                        <i class="ti ti-alert-triangle"></i>
                        Mancano ancora gli esiti di:
                        {foreach $torneiSenzaEsito as $t name=tsi}{$t.nome|escape}{if !$smarty.foreach.tsi.last}, {/if}{/foreach}
                    </p>
                {/if}

                {* ── Elenco tornei della challenge, ciascuno con lo stesso meccanismo del dettaglio torneo singolo ── *}
                <div class="gdet-tornei-list">
                    {foreach $tornei as $torneo}
                        {assign var="statoTorneo" value=$torneo.statoEvento|lower}
                        {assign var="podioTorneoEsiste" value=isset($torneo.podio) && $torneo.podio|@count > 0}

                        <div class="gdet-torneo-card">
                            <div class="gdet-torneo-card__header">
                                <img src="{$torneo.imgEvento}" alt="{$torneo.nomeEvento|escape}" class="gdet-torneo-card__img">
                                <div>
                                    <span class="gdet-status gdet-status--{$statoTorneo}">{$torneo.statoEvento}</span>
                                    <h3 class="gdet-torneo-card__name">{$torneo.nomeEvento|escape}</h3>
                                    <span class="gdet-torneo-card__gioco">{$torneo.gioco|escape}</span>
                                </div>
                                <a href="{$base_url}/gestore/eventi/dettaglio/{$torneo.idEvento}" class="gdet-link">
                                    <i class="ti ti-eye"></i> Vedi torneo
                                </a>
                            </div>

                            {if $statoTorneo == 'terminato'}
                                {if $podioTorneoEsiste}
                                    <ul class="gdet-podio gdet-podio--compact">
                                        {foreach $torneo.podio as $piazzamento}
                                            <li class="gdet-podio__item gdet-podio__item--{$piazzamento.posizione}">
                                                <span class="gdet-podio__medal">{$piazzamento.posizione}&deg;</span>
                                                <span class="gdet-podio__name">{$piazzamento.utente.nome|escape}</span>
                                            </li>
                                        {/foreach}
                                    </ul>
                                {/if}

                                <input type="checkbox" id="toggle-esito-{$torneo.idEvento}" class="gdet-toggle-checkbox">
                                <label for="toggle-esito-{$torneo.idEvento}" class="gdet-btn gdet-btn--primary gdet-btn--small">
                                    <i class="ti ti-medal"></i> {if $podioTorneoEsiste}Modifica esito{else}Aggiungi esito{/if}
                                </label>

                                <div class="gdet-panel" id="panel-esito-{$torneo.idEvento}">
                                    {if !isset($torneo.iscritti) || $torneo.iscritti|@count == 0}
                                        <p class="gdet-warning">
                                            <i class="ti ti-alert-triangle"></i>
                                            Elenco iscritti non disponibile per questo torneo: verificare con Control.
                                        </p>
                                    {/if}
                                   <form method="post" action="{$base_url}/gestore/eventi/tornei/esito" class="gdet-form" id="form-esito-{$torneo.idEvento}">
                                        <input type="hidden" name="id_evento" value="{$torneo.idEvento}">

                                        <label class="gdet-form__label">1&deg; classificato *</label>
                                        <select name="id_primo" class="gdet-form__input gdet-podio-select" data-group="{$torneo.idEvento}" required>
                                            <option value="">Seleziona...</option>
                                            {foreach $torneo.iscritti|default:[] as $iscritto}
                                                <option value="{$iscritto.id}">{$iscritto.nome|escape}</option>
                                            {/foreach}
                                        </select>

                                        <label class="gdet-form__label">2&deg; classificato</label>
                                        <select name="id_secondo" class="gdet-form__input gdet-podio-select" data-group="{$torneo.idEvento}">
                                            <option value="">Nessuno</option>
                                            {foreach $torneo.iscritti|default:[] as $iscritto}
                                                <option value="{$iscritto.id}">{$iscritto.nome|escape}</option>
                                            {/foreach}
                                        </select>

                                        <label class="gdet-form__label">3&deg; classificato</label>
                                        <select name="id_terzo" class="gdet-form__input gdet-podio-select" data-group="{$torneo.idEvento}">
                                            <option value="">Nessuno</option>
                                            {foreach $torneo.iscritti|default:[] as $iscritto}
                                                <option value="{$iscritto.id}">{$iscritto.nome|escape}</option>
                                            {/foreach}
                                        </select>

                                        <button type="submit" class="gdet-btn gdet-btn--success gdet-btn--small">
                                            <i class="ti ti-device-floppy"></i> Salva esito
                                        </button>
                                    </form>
                                </div>
                            {else}
                                <p class="gdet-info-text">
                                    <i class="ti ti-info-circle"></i> Questo torneo non è ancora concluso.
                                </p>
                            {/if}
                        </div>
                    {/foreach}
                </div>

                {* ── Genera classifica finale ── *}
                {assign var="tuttiOk" value=!isset($torneiSenzaEsito) || $torneiSenzaEsito|@count == 0}
                <form method="post"
                      action="{$base_url}/gestore/eventi/challenge/genera-classifica"
                      class="gdet-action-form"
                      {if $tuttiOk}onsubmit="return confirm('Sei sicuro? Una volta generata la classifica sarà visibile a tutti gli utenti.');"{/if}>
                    <input type="hidden" name="id_challenge" value="{$idEvento}">
                    <button type="submit" class="gdet-btn gdet-btn--primary" {if !$tuttiOk}disabled{/if}>
                        <i class="ti ti-list-numbers"></i> Genera classifica finale
                    </button>
                </form>

            {else}
                {* ── Case B: classifica già generata, sola lettura ── *}
                <table class="gdet-classifica">
                    <thead>
                        <tr>
                            <th>Posizione</th>
                            <th>Utente</th>
                            <th>Punteggio totale</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach $classificaFinale as $riga}
                            <tr class="{if $riga.posizione <= 3}gdet-classifica__row--podio{/if}">
                                <td>
                                    {if $riga.posizione == 1}<i class="ti ti-medal"></i>{elseif $riga.posizione <= 3}<i class="ti ti-medal-2"></i>{/if}
                                    {$riga.posizione}&deg;
                                </td>
                                <td>{$riga.utente.nome|escape}</td>
                                <td>{$riga.punteggioTotale} punti</td>
                            </tr>
                        {/foreach}
                    </tbody>
                </table>
                <p class="gdet-info-text">
                    <i class="ti ti-lock"></i> Classifica definitiva: non è prevista nessuna modifica da interfaccia.
                </p>
            {/if}
        </section>
    {/if}

</div>

<script>
    // Blocco doppie selezioni nei form podio, raggruppati per torneo (data-group).
    (function() {
        var gruppi = {};
        document.querySelectorAll('.gdet-podio-select').forEach(function(s) {
            var g = s.dataset.group || 'default';
            (gruppi[g] = gruppi[g] || []).push(s);
        });
        Object.values(gruppi).forEach(function(selects) {
            function aggiorna() {
                var scelti = selects.map(function(s) { return s.value; }).filter(function(v) { return v !== ''; });
                selects.forEach(function(select) {
                    Array.prototype.forEach.call(select.options, function(opt) {
                        if (opt.value === '') return;
                        opt.disabled = scelti.indexOf(opt.value) !== -1 && opt.value !== select.value;
                    });
                });
            }
            selects.forEach(function(s) { s.addEventListener('change', aggiorna); });
            aggiorna();
        });
    })();

    // Chiude il popup "Modifica dati" cliccando sul backdrop
    (function() {
        var dialog = document.getElementById('modal-modifica');
        if (dialog) {
            dialog.addEventListener('click', function(e) {
                if (e.target === dialog) dialog.close();
            });
        }
    })();

    {if $stato == 'annullato'}
    (function() {
        var form = document.getElementById('form-riprogramma-{$idEvento}');
        if (!form) return;
        form.addEventListener('submit', function() {
            var input = form.querySelector('[name="nuovaDataInizio"]');
            if (input && input.value) {
                input.value = input.value.replace('T', ' ') + ':00';
            }
        });
    })();
    {/if}
</script>

{/block}