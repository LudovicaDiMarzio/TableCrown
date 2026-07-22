{*
  TableCrown\Presentation\Views\Gestore - Dettaglio Torneo
  Estende layout_gestore.tpl.

  Variabili di pagina (da costruisciDatiVistaEvento(), modalita: 'gestore'):
    idEvento, nomeEvento, imgEvento, dataInizio, maxPartecipanti, statoEvento,
    numeroPartecipanti, richiedeQuota, postiDisponibili,
    tipo ('torneo'), quotaIscrizione, gioco (string), challenge (link minimo|null),
    premio => qui è la card prodotto COMPLETA (prodottoToArray), non il link minimo del catalogo,
    descrizioneEvento, postiRimanenti, hasPostiDisponibili,
    vista = 'gestore_dettaglio_torneo'

  Sezione 3 del documento Control (podio):
    $podio => array ordinato di ['posizione','utente'=>['id','nome']], solo se già inserito
    $iscritti => lista iscritti al torneo per i selettori del form (id, nome)

  TODO T1 (segnalato a Control): costruisciDatiVistaEvento() NON popola ancora
  $podio (manca la chiamata a estraiPodioTorneo(), helper già presente in
  BaseController ma inutilizzato) né $iscritti. Il tpl è scritto secondo la
  struttura dati promessa dal documento; finché Control non collega questi
  campi, la sezione podio resterà sempre "vuota / Aggiungi esito" e i selettori
  risulteranno vuoti con avviso a schermo.

  MODIFICA: sia "Modifica dati" sia "Aggiungi/Modifica esito" ora usano popup
  nativi (<dialog>), come già in dettaglio_challenge.tpl, invece del pattern
  checkbox+label+.gdet-panel. Il vecchio pattern non funzionava per l'esito
  perché il checkbox di toggle è annidato dentro .gdet-actions__grid e quindi
  non è più fratello diretto (selettore CSS ~) del pannello: il CSS a fratelli
  non lo raggiungeva mai. <dialog> con showModal()/close() è controllato via JS
  e non dipende da questa relazione di parentela nel markup.
  Serve aggiungere in eventi_gestore_dettaglio.css (se non già presenti da
  challenge): .gdet-modal, .gdet-modal::backdrop, .gdet-modal__content,
  .gdet-modal__close, .gdet-modal__actions.
*}
{extends file="layout_gestore.tpl"}

{block name="page_css"}
    <link rel="stylesheet" href="{$base_url}/css/eventi_gestore_dettaglio.css">
{/block}

{block name="content"}

{assign var="stato" value=$statoEvento|lower}
{assign var="podioEsiste" value=isset($podio) && $podio|@count > 0}

<div class="gdet-container">

    <a href="{$base_url}/gestore/eventi/tornei" class="gdet-back">
        <i class="ti ti-arrow-left"></i> Torna ai tornei
    </a>

    {* ── HEADER ── *}
    <div class="gdet-header">
        <div class="gdet-header__img-wrapper">
            <img src="{$imgEvento}" alt="{$nomeEvento|escape}" class="gdet-header__img">
            <span class="gdet-status gdet-status--{$stato}">{$statoEvento}</span>
        </div>

        <div class="gdet-header__info">
            <span class="gdet-type">Torneo &middot; {$gioco|escape}</span>
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
                {if $challenge}
                    <span class="gdet-meta-row">
                        <i class="ti ti-swords"></i> Parte della challenge
                        <a href="{$base_url}/gestore/eventi/dettaglio/{$challenge.idEvento}" class="gdet-link">{$challenge.nomeEvento|escape}</a>
                    </span>
                {/if}
            </div>
        </div>
    </div>

    {* ── DESCRIZIONE + PREMIO ── *}
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

                <form method="post" action="{$base_url}/gestore/eventi/annulla" class="gdet-action-form" onsubmit="return confirm('Annullare questo torneo?');">
                    <input type="hidden" name="id_evento" value="{$idEvento}">
                    <button type="submit" class="gdet-btn gdet-btn--warning">
                        <i class="ti ti-ban"></i> Annulla evento
                    </button>
                </form>
            {/if}

            {if $stato == 'in_corso'}
                <form method="post" action="{$base_url}/gestore/eventi/concludi" class="gdet-action-form" onsubmit="return confirm('Concludere questo torneo?');">
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
    <button type="button" class="gdet-btn gdet-btn--primary" onclick="document.getElementById('modal-riprogramma').showModal()">
        <i class="ti ti-calendar-repeat"></i> Riprogramma
    </button>
{/if}

            {if $stato == 'terminato'}
                <button type="button" class="gdet-btn gdet-btn--primary" onclick="document.getElementById('modal-esito').showModal()">
                    <i class="ti ti-medal"></i> {if $podioEsiste}Modifica esito{else}Aggiungi esito{/if}
                </button>
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

        {if $stato == 'terminato'}
            {* ── ESITO GIA' INSERITO: podio in sola visualizzazione (fuori dal popup) ── *}
            {if $podioEsiste}
                <div class="gdet-podio">
                    <h3 class="gdet-panel__title">Podio pubblicato</h3>
                    <ul class="gdet-podio__list">
                        {foreach $podio as $piazzamento}
                            <li class="gdet-podio__item gdet-podio__item--{$piazzamento.posizione}">
                                <span class="gdet-podio__medal">
                                    {if $piazzamento.posizione == 1}<i class="ti ti-medal"></i> 1&deg;
                                    {elseif $piazzamento.posizione == 2}<i class="ti ti-medal-2"></i> 2&deg;
                                    {else}<i class="ti ti-medal-2"></i> 3&deg;{/if}
                                </span>
                                <span class="gdet-podio__name">{$piazzamento.utente.nome|escape}</span>
                            </li>
                        {/foreach}
                    </ul>
                </div>
            {/if}

            {* ── POPUP: form Aggiungi/Modifica esito (stessa route per entrambi i casi) ── *}
            <dialog class="gdet-modal" id="modal-esito">
                <div class="gdet-modal__content">
                    <button type="button" class="gdet-modal__close" onclick="document.getElementById('modal-esito').close()" aria-label="Chiudi">
                        <i class="ti ti-x"></i>
                    </button>

                    <h3 class="gdet-panel__title">{if $podioEsiste}Modifica esito{else}Aggiungi esito{/if}</h3>
                    {if !isset($iscritti) || $iscritti|@count == 0}
                        <p class="gdet-warning">
                            <i class="ti ti-alert-triangle"></i>
                            Elenco iscritti non disponibile: verificare con Control che $iscritti sia esposto in questa vista.
                        </p>
                    {/if}
                    <form method="post" action="{$base_url}/gestore/eventi/tornei/esito" class="gdet-form" id="form-esito-{$idEvento}">
                        <input type="hidden" name="id_evento" value="{$idEvento}">

                        {assign var="idPrimo" value=null}
                        {assign var="idSecondo" value=null}
                        {assign var="idTerzo" value=null}
                        {if $podioEsiste}
                            {foreach $podio as $p}
                                {if $p.posizione == 1}{assign var="idPrimo" value=$p.utente.id}{/if}
                                {if $p.posizione == 2}{assign var="idSecondo" value=$p.utente.id}{/if}
                                {if $p.posizione == 3}{assign var="idTerzo" value=$p.utente.id}{/if}
                            {/foreach}
                        {/if}

                        <label class="gdet-form__label" for="id_primo">1&deg; classificato *</label>
                        <select id="id_primo" name="id_primo" class="gdet-form__input gdet-podio-select" required>
                            <option value="">Seleziona...</option>
                            {foreach $iscritti|default:[] as $iscritto}
                                <option value="{$iscritto.id}" {if $idPrimo == $iscritto.id}selected{/if}>{$iscritto.nome|escape}</option>
                            {/foreach}
                        </select>

                        <label class="gdet-form__label" for="id_secondo">2&deg; classificato</label>
                        <select id="id_secondo" name="id_secondo" class="gdet-form__input gdet-podio-select">
                            <option value="">Nessuno</option>
                            {foreach $iscritti|default:[] as $iscritto}
                                <option value="{$iscritto.id}" {if $idSecondo == $iscritto.id}selected{/if}>{$iscritto.nome|escape}</option>
                            {/foreach}
                        </select>

                        <label class="gdet-form__label" for="id_terzo">3&deg; classificato</label>
                        <select id="id_terzo" name="id_terzo" class="gdet-form__input gdet-podio-select">
                            <option value="">Nessuno</option>
                            {foreach $iscritti|default:[] as $iscritto}
                                <option value="{$iscritto.id}" {if $idTerzo == $iscritto.id}selected{/if}>{$iscritto.nome|escape}</option>
                            {/foreach}
                        </select>

                        <div class="gdet-modal__actions">
                            <button type="button" class="gdet-btn gdet-btn--muted" onclick="document.getElementById('modal-esito').close()">
                                Annulla
                            </button>
                            <button type="submit" class="gdet-btn gdet-btn--success">
                                <i class="ti ti-device-floppy"></i> Salva esito
                            </button>
                        </div>
                    </form>
                </div>
            </dialog>
        {/if}
    </section>

</div>

<script>
    // Impedisce lato client di scegliere due volte la stessa persona nei 3 selettori
    // del podio (Control valida comunque server-side, questo è solo un aiuto in UI).
    (function() {
        var selects = document.querySelectorAll('#form-esito-{$idEvento} .gdet-podio-select');
        if (!selects.length) return;

        function aggiornaOpzioni() {
            var scelti = Array.prototype.map.call(selects, function(s) { return s.value; }).filter(function(v) { return v !== ''; });
            selects.forEach(function(select) {
                Array.prototype.forEach.call(select.options, function(opt) {
                    if (opt.value === '') return;
                    opt.disabled = scelti.indexOf(opt.value) !== -1 && opt.value !== select.value;
                });
            });
        }
        selects.forEach(function(s) { s.addEventListener('change', aggiornaOpzioni); });
        aggiornaOpzioni();
    })();

    // Chiude i popup cliccando sul backdrop
    (function() {
        ['modal-modifica', 'modal-esito', 'modal-riprogramma'].forEach(function(id) {
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
            var valore = visibile.value; // "YYYY-MM-DDTHH:MM" o "...:SS"
            if (valore.length === 16) valore += ':00';
            hidden.value = valore.replace('T', ' ');
        }
    });
})();
{/if}
</script>

{/block}