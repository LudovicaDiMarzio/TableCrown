{*
  TableCrown\Presentation\Views\Gestore - Dettaglio Serata
  Estende layout_gestore.tpl.

  Variabili di pagina (da BaseController::costruisciDatiVistaEvento(), modalita: 'gestore',
  chiamato da CGestore::mostraDettaglioEventoGestore()):
    idEvento, nomeEvento, imgEvento, dataInizio (Y-m-d H:i:s), maxPartecipanti,
    statoEvento, numeroPartecipanti, richiedeQuota, postiDisponibili,
    tipo ('serata'), tipoSerata,
    descrizioneEvento, postiRimanenti, hasPostiDisponibili, userIscritto (irrilevante qui),
    vista = 'gestore_dettaglio_serata'

  Pulsanti per stato (sezione 2 del documento Control):
    programmato -> Attiva* (solo se dataInizio già passata) + Annulla + Modifica dati
    in_corso    -> Concludi (+ Modifica dati)
    terminato   -> nessuna azione aggiuntiva per le Serate (solo vista informativa) + Modifica dati
    annullato   -> Riprogramma (+ Modifica dati)

  NB: "Modifica dati" è sempre visibile, in qualunque stato (specificato esplicitamente
  nel documento, anche se la tabella riassuntiva la elenca solo sotto "programmato").

  MODIFICA: "Modifica dati" ora è un popup nativo (<dialog>), coerente con
  dettaglio_torneo.tpl e dettaglio_challenge.tpl, al posto del vecchio pattern
  checkbox+label+.gdet-panel. Serve aggiungere in eventi_gestore_dettaglio.css
  (se non già presenti): .gdet-modal, .gdet-modal::backdrop, .gdet-modal__content,
  .gdet-modal__close, .gdet-modal__actions.

  TODO T1: verificare formato reale restituito da $evento.dataInizio (qui atteso
  'Y-m-d H:i:s', parsing lato Smarty fatto con |strtotime, coerente con l'uso
  di |date_format già presente nelle liste).
*}
{extends file="layout_gestore.tpl"}

{block name="page_css"}
    <link rel="stylesheet" href="{$base_url}/css/eventi_gestore_dettaglio.css">
{/block}

{block name="content"}

{assign var="stato" value=$statoEvento|lower}

<div class="gdet-container">

    <a href="{$base_url}/gestore/eventi/serate" class="gdet-back">
        <i class="ti ti-arrow-left"></i> Torna alle serate
    </a>

    {* ── HEADER ── *}
    <div class="gdet-header">
        <div class="gdet-header__img-wrapper">
            <img src="{$imgEvento}" alt="{$nomeEvento|escape}" class="gdet-header__img">
            <span class="gdet-status gdet-status--{$stato}">{$statoEvento}</span>
        </div>

        <div class="gdet-header__info">
            <span class="gdet-type">{$tipoSerata|escape}</span>
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
                    {if $richiedeQuota}Evento a pagamento{else}Evento gratuito{/if}
                </span>
            </div>
        </div>
    </div>

    {* ── DESCRIZIONE ── *}
    <section class="gdet-section">
        <h2 class="gdet-section__title"><i class="ti ti-file-description"></i> Descrizione</h2>
        <p class="gdet-section__text">{$descrizioneEvento|escape|nl2br}</p>
    </section>

    {* ── AZIONI GESTORE ── *}
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
                    {* Il pulsante non compare finché dataInizio è nel futuro: il click fallirebbe lato Control *}
                    <span class="gdet-btn gdet-btn--disabled" title="Disponibile solo dopo la data di inizio ({$dataInizio|date_format:"%d %B %Y, %H:%M"})">
                        <i class="ti ti-player-play"></i> Attiva evento
                    </span>
                {/if}

                <form method="post" action="{$base_url}/gestore/eventi/annulla" class="gdet-action-form" onsubmit="return confirm('Annullare questa serata?');">
                    <input type="hidden" name="id_evento" value="{$idEvento}">
                    <button type="submit" class="gdet-btn gdet-btn--warning">
                        <i class="ti ti-ban"></i> Annulla evento
                    </button>
                </form>
            {/if}

            {if $stato == 'in_corso'}
                <form method="post" action="{$base_url}/gestore/eventi/concludi" class="gdet-action-form" onsubmit="return confirm('Concludere questa serata?');">
                    <input type="hidden" name="id_evento" value="{$idEvento}">
                    <button type="submit" class="gdet-btn gdet-btn--success">
                        <i class="ti ti-flag-check"></i> Concludi evento
                    </button>
                </form>
            {/if}

            {if $stato == 'terminato'}
                <p class="gdet-info-text">
                    <i class="ti ti-info-circle"></i> Le serate concluse non richiedono nessuna pubblicazione di esiti.
                </p>
            {/if}

            {* ── MODIFICA DATI: sempre disponibile, qualunque sia lo stato ── *}
            <button type="button" class="gdet-btn gdet-btn--info" onclick="document.getElementById('modal-modifica').showModal()">
                <i class="ti ti-edit"></i> Modifica dati
            </button>

            {if $stato == 'annullato'}
    <button type="button" class="gdet-btn gdet-btn--primary" onclick="document.getElementById('modal-riprogramma').showModal()">
        <i class="ti ti-calendar-repeat"></i> Riprogramma
    </button>
{/if}
        </div>

        {* ── POPUP: Modifica dati (nome, descrizione, max partecipanti, immagine) ── *}
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
    <dialog class="gdet-modal" id="modal-riprogramma">
        <div class="gdet-modal__content">
            <button type="button" class="gdet-modal__close" onclick="document.getElementById('modal-riprogramma').close()" aria-label="Chiudi">
                <i class="ti ti-x"></i>
            </button>

            <h3 class="gdet-panel__title">Riprogramma evento</h3>
            <p class="gdet-panel__hint">Imposta una nuova data futura: l'evento tornerà in stato "Programmato".</p>

            <form method="post" action="{$base_url}/gestore/eventi/riprogramma" class="gdet-form" id="form-riprogramma-{$idEvento}">
                <input type="hidden" name="id_evento" value="{$idEvento}">
                <label class="gdet-form__label" for="nuovaDataInizio">Nuova data e ora</label>
                <label class="gdet-form__label" for="nuovaDataInizio_visibile">Nuova data e ora</label>
<input type="datetime-local" id="nuovaDataInizio_visibile" class="gdet-form__input" required>
<input type="hidden" id="nuovaDataInizio" name="nuovaDataInizio">

                <div class="gdet-modal__actions">
                    <button type="button" class="gdet-btn gdet-btn--muted" onclick="document.getElementById('modal-riprogramma').close()">
                        Annulla
                    </button>
                    <button type="submit" class="gdet-btn gdet-btn--primary">
                        <i class="ti ti-calendar-repeat"></i> Conferma riprogrammazione
                    </button>
                </div>
            </form>
        </div>
    </dialog>
{/if}
    </section>

</div>

<script>
    // Chiude il popup "Modifica dati" cliccando sul backdrop
    (function() {
    ['modal-modifica', 'modal-riprogramma'].forEach(function(id) {
        var dialog = document.getElementById(id);
        if (dialog) {
            dialog.addEventListener('click', function(e) {
                if (e.target === dialog) dialog.close();
            });
        }
    });
})();

    {if $stato == 'annullato'}
(function() {
    var form = document.getElementById('form-riprogramma-{$idEvento}');
    if (!form) return;
    form.addEventListener('submit', function() {
        var visibile = form.querySelector('#nuovaDataInizio_visibile');
        var hidden = form.querySelector('#nuovaDataInizio');
        if (visibile && visibile.value) {
            var valore = visibile.value; // "YYYY-MM-DDTHH:MM"
            if (valore.length === 16) valore += ':00';
            hidden.value = valore.replace('T', ' ');
        }
    });
})();
{/if}{if $stato == 'annullato'}
(function() {
    var form = document.getElementById('form-riprogramma-{$idEvento}');
    if (!form) return;
    form.addEventListener('submit', function() {
        var visibile = form.querySelector('#nuovaDataInizio_visibile');
        var hidden = form.querySelector('#nuovaDataInizio');
        if (visibile && visibile.value) {
            var valore = visibile.value; // "YYYY-MM-DDTHH:MM"
            if (valore.length === 16) valore += ':00';
            hidden.value = valore.replace('T', ' ');
        }
    });
})();
{/if}
</script>

{/block}