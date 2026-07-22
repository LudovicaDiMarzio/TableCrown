{extends file="common/layout.tpl"}

{block name="extra_css"}
    <link rel="stylesheet" href="{$base_url}/css/ProfiloEventi.css">
{/block}

{block name="content"}
<div class="mieeventi-container">
    <div class="container">

        {* ── TOPBAR ── *}
        <div class="mieeventi-topbar">
            <a href="{$base_url}/profilo" class="mieeventi-back-link">
                <i class="ti ti-arrow-left"></i> Torna all'Area Personale
            </a>
        </div>

        {* ── HEADER ── *}
        <div class="mieeventi-header">
            <div class="mieeventi-header-text">
                <span class="mieeventi-eyebrow">Area Personale</span>
                <h1 class="mieeventi-titolo">
                    <i class="ti ti-calendar-event"></i> I Miei Eventi
                </h1>
            </div>

            {if isset($eventi) && $eventi|@count > 0}
                <div class="mieeventi-count-badge">
                    <span class="mieeventi-count-num">{$eventi|@count}</span>
                    <span class="mieeventi-count-label">{if $eventi|@count == 1}evento{else}eventi{/if}</span>
                </div>
            {/if}
        </div>

        {* ── TAB ORDINAMENTO ── *}
        <div class="mieeventi-tabs">
            <a href="{$base_url}/profilo/eventi?ordinamento=futuri"
               class="mieeventi-tab {if !isset($ordinamento) || $ordinamento == 'futuri'}mieeventi-tab-active{/if}">
                <i class="ti ti-calendar-due"></i> Futuri
            </a>
            <a href="{$base_url}/profilo/eventi?ordinamento=passati_anno_corrente"
               class="mieeventi-tab {if isset($ordinamento) && $ordinamento == 'passati_anno_corrente'}mieeventi-tab-active{/if}">
                <i class="ti ti-calendar-check"></i> Passati quest'anno
            </a>
            <a href="{$base_url}/profilo/eventi?ordinamento=ultimi_5_anni"
               class="mieeventi-tab {if isset($ordinamento) && $ordinamento == 'ultimi_5_anni'}mieeventi-tab-active{/if}">
                <i class="ti ti-history"></i> Ultimi 5 anni
            </a>
        </div>

        {* ── LISTA EVENTI ── *}
        {if isset($eventi) && $eventi|@count > 0}
            <div class="mieeventi-list" id="mieeventi-list">
                {foreach $eventi as $evento}
                    <div class="mieeventi-card" id="mieeventi-card-{$evento.idEvento|escape}">

                        <a href="{$base_url}/eventi/dettaglio?id={$evento.idEvento|escape}" class="mieeventi-card-media">
                            <div class="mieeventi-card-img-placeholder">
                                <i class="ti ti-photo"></i>
                            </div>
                            {if isset($evento.imgEvento) && $evento.imgEvento}
                                <img src="{$base_url}/img/eventi/{$evento.imgEvento|escape}"
                                     onerror="this.onerror=null; this.style.display='none';"
                                     alt="{$evento.nomeEvento|escape}"
                                     class="mieeventi-card-img">
                            {/if}

                            {if isset($evento.tipoEvento)}
                                <span class="mieeventi-tipo-badge mieeventi-tipo-{$evento.tipoEvento|escape}">
                                    {if $evento.tipoEvento == 'serata'}<i class="ti ti-moon-stars"></i> Serata
                                    {elseif $evento.tipoEvento == 'torneo'}<i class="ti ti-trophy"></i> Torneo
                                    {elseif $evento.tipoEvento == 'challenge'}<i class="ti ti-swords"></i> Challenge
                                    {else}{$evento.tipoEvento|escape}
                                    {/if}
                                </span>
                            {/if}
                        </a>

                        <div class="mieeventi-card-body">

                            <div class="mieeventi-card-top">
                                <a href="{$base_url}/{$evento.tipoEvento|default:''|escape}/{$evento.idEvento|escape}" class="mieeventi-nome">
                                    {$evento.nomeEvento|escape}
                                </a>
                            </div>

                            {* ── LISTA INFO VERTICALE ── *}
                            <div class="mieeventi-info-list">

                                {* -- stato -- *}
                                <div class="mieeventi-info-row {if $evento.statoEvento == 'in programma'}mieeventi-stato-riga-in-programma{else}mieeventi-stato-riga-concluso{/if}">
                                    <i class="ti ti-flag"></i>
                                    <span class="mieeventi-info-label">Stato:</span>
                                    <span class="mieeventi-info-value">{$evento.statoEvento|escape}</span>
                                </div>

                                {* -- campi comuni -- *}
                                <div class="mieeventi-info-row">
                                    <i class="ti ti-calendar"></i>
                                    <span class="mieeventi-info-label">Data:</span>
                                    <span class="mieeventi-info-value">{$evento.dataInizio|escape}</span>
                                </div>

                                <div class="mieeventi-info-row">
                                    <i class="ti ti-users"></i>
                                    <span class="mieeventi-info-label">Partecipanti:</span>
                                    <span class="mieeventi-info-value">{$evento.numeroPartecipanti|escape}/{$evento.maxPartecipanti|escape}</span>
                                </div>

                                {* -- corretto: la chiave passata da Control è 'dataiscrizione' minuscolo -- *}
                                {if isset($evento.dataiscrizione)}
                                    <div class="mieeventi-info-row">
                                        <i class="ti ti-user-check"></i>
                                        <span class="mieeventi-info-label">Iscritto il:</span>
                                        <span class="mieeventi-info-value">{$evento.dataiscrizione|escape}</span>
                                    </div>
                                {/if}

                                {* -- campi specifici per tipo (richiedono che Control usi mappaEvento(), vedi nota) -- *}
                                {if isset($evento.tipoEvento) && $evento.tipoEvento == 'serata'}
                                    {if isset($evento.tipoSerata)}
                                        <div class="mieeventi-info-row">
                                            <i class="ti ti-category"></i>
                                            <span class="mieeventi-info-label">Tipologia:</span>
                                            <span class="mieeventi-info-value">{$evento.tipoSerata|escape}</span>
                                        </div>
                                    {/if}

                                {elseif isset($evento.tipoEvento) && $evento.tipoEvento == 'torneo'}
                                    {if isset($evento.gioco)}
                                        <div class="mieeventi-info-row">
                                            <i class="ti ti-dice"></i>
                                            <span class="mieeventi-info-label">Gioco:</span>
                                            <span class="mieeventi-info-value">{$evento.gioco|escape}</span>
                                        </div>
                                    {/if}
                                    {if isset($evento.premio)}
                                        <div class="mieeventi-info-row">
                                            <i class="ti ti-award"></i>
                                            <span class="mieeventi-info-label">Premio:</span>
                                            <span class="mieeventi-info-value">{$evento.premio|escape}</span>
                                        </div>
                                    {/if}
                                    {if isset($evento.challenge)}
                                        <a href="{$base_url}/challenge/{$evento.challenge.idEvento|escape}" class="mieeventi-info-row mieeventi-info-row-link">
                                            <i class="ti ti-swords"></i>
                                            <span class="mieeventi-info-label">Fa parte di:</span>
                                            <span class="mieeventi-info-value">{$evento.challenge.nomeEvento|escape}</span>
                                        </a>
                                    {/if}

                                {elseif isset($evento.tipoEvento) && $evento.tipoEvento == 'challenge'}
                                    {if isset($evento.premio)}
                                        <div class="mieeventi-info-row">
                                            <i class="ti ti-award"></i>
                                            <span class="mieeventi-info-label">Premio:</span>
                                            <span class="mieeventi-info-value">{$evento.premio|escape}</span>
                                        </div>
                                    {/if}
                                    {if isset($evento.tornei) && $evento.tornei|@count > 0}
                                        <div class="mieeventi-info-row">
                                            <i class="ti ti-trophy"></i>
                                            <span class="mieeventi-info-label">Tornei inclusi:</span>
                                        </div>
                                        <div class="mieeventi-sotto-tornei">
                                            {foreach $evento.tornei as $torneo}
                                                <a href="{$base_url}/torneo/{$torneo.idEvento|escape}" class="mieeventi-sotto-torneo-link">
                                                    <i class="ti ti-corner-down-right"></i> {$torneo.nomeEvento|escape}
                                                </a>
                                            {/foreach}
                                        </div>
                                    {/if}
                                {/if}

                                {if isset($evento.quotaIscrizione)}
                                    <div class="mieeventi-info-row">
                                        <i class="ti ti-coin"></i>
                                        <span class="mieeventi-info-label">Quota:</span>
                                        <span class="mieeventi-info-value">€ {$evento.quotaIscrizione|escape}</span>
                                    </div>
                                {/if}

                                {if isset($evento.quotaPagata) && $evento.quotaPagata}
                                    <div class="mieeventi-info-row mieeventi-quota-pagata">
                                        <i class="ti ti-circle-check"></i>
                                        <span class="mieeventi-info-value">Quota pagata</span>
                                    </div>
                                {/if}

                                {* -- corretto: la chiave passata da Control è 'posizioneClassifica' -- *}
                                {if isset($evento.posizioneClassifica) && $evento.posizioneClassifica !== null}
                                    <div class="mieeventi-info-row mieeventi-classifica-row">
                                        <i class="ti ti-medal"></i>
                                        <span class="mieeventi-info-label">Classifica:</span>
                                        <span class="mieeventi-info-value">{$evento.posizioneClassifica|escape}&deg; posto</span>
                                    </div>
                                {/if}

                            </div>

                            {* ── AZIONI ── *}
                            <div class="mieeventi-actions">
                                {if isset($evento.tipoEvento) && $evento.tipoEvento == 'serata'}

                                    <a href="{$base_url}/{$evento.tipoEvento|escape}/{$evento.idEvento|escape}" class="mieeventi-btn-secondary">
                                        <i class="ti ti-info-circle"></i> Maggiori info
                                    </a>

                                    {if $evento.statoEvento == 'in programma'}
                                        <button type="button" class="mieeventi-btn-disdici" data-id="{$evento.idEvento|escape}">
                                            <i class="ti ti-x"></i> Disdici partecipazione
                                        </button>
                                    {/if}

                                {elseif isset($evento.tipoEvento)}
                                    {if $evento.statoEvento == 'in programma'}
                                        <a href="{$base_url}/{$evento.tipoEvento|escape}/{$evento.idEvento|escape}" class="mieeventi-btn-secondary">
                                            <i class="ti ti-info-circle"></i> Maggiori info
                                        </a>
                                    {else}
                                        <a href="{$base_url}/{$evento.tipoEvento|escape}/{$evento.idEvento|escape}#classifica" class="mieeventi-btn-secondary">
                                            <i class="ti ti-trophy"></i> Esito
                                        </a>
                                    {/if}
                                {/if}
                            </div>

                        </div>
                    </div>
                {/foreach}
            </div>
        {else}
            {* ── STATO VUOTO ── *}
            <div class="mieeventi-empty" id="mieeventi-empty">
                <div class="mieeventi-empty-icon">
                    <i class="ti ti-calendar-event"></i>
                </div>
                <h2 class="mieeventi-empty-titolo">Nessun evento in questa sezione</h2>
                <p class="mieeventi-empty-testo">Le serate, i tornei e le challenge a cui ti iscriverai compariranno qui.</p>
                <a href="{$base_url}/eventi" class="mieeventi-empty-btn">
                    <i class="ti ti-calendar-plus"></i> Scopri gli eventi
                </a>
            </div>
        {/if}

        {* ── POPUP CONFERMA DISDETTA ── *}
        <div class="mieeventi-popup-overlay" id="mieeventi-disdici-popup" hidden>
            <div class="mieeventi-popup-box">
                <i class="ti ti-alert-triangle mieeventi-popup-icon"></i>
                <p class="mieeventi-popup-message">Sei sicuro di voler disdire la partecipazione a questo evento?</p>

                <div class="mieeventi-popup-actions">
                    <button type="button" class="mieeventi-btn-secondary" id="mieeventi-disdici-indietro">Indietro</button>
                    <button type="button" class="mieeventi-btn-primary" id="mieeventi-disdici-conferma">Conferma</button>
                </div>
            </div>
        </div>

        {* ── POPUP MESSAGGI (feedback errore) ── *}
        <div class="mieeventi-popup-overlay" id="mieeventi-popup" hidden>
            <div class="mieeventi-popup-box">
                <i class="ti ti-alert-triangle mieeventi-popup-icon"></i>
                <p class="mieeventi-popup-message" id="mieeventi-popup-message"></p>
                <button type="button" class="mieeventi-btn-primary" id="mieeventi-popup-close">Chiudi</button>
            </div>
        </div>

    </div>
</div>
{/block}

{block name="extra_js"}
<script>
{literal}
(function() {

    var popup        = document.getElementById('mieeventi-popup');
    var popupMessage = document.getElementById('mieeventi-popup-message');
    var popupClose    = document.getElementById('mieeventi-popup-close');

    var disdiciPopup     = document.getElementById('mieeventi-disdici-popup');
    var disdiciIndietro  = document.getElementById('mieeventi-disdici-indietro');
    var disdiciConferma  = document.getElementById('mieeventi-disdici-conferma');
    var idDaDisdire       = null;

    function mostraPopup(messaggio) {
        popupMessage.textContent = messaggio;
        popup.removeAttribute('hidden');
    }

    if (popupClose) {
        popupClose.addEventListener('click', function() {
            popup.setAttribute('hidden', '');
        });
    }

    var list = document.getElementById('mieeventi-list');
    if (list) {
        list.addEventListener('click', function(e) {
            var disdiciBtn = e.target.closest('.mieeventi-btn-disdici');
            if (disdiciBtn) {
                idDaDisdire = disdiciBtn.getAttribute('data-id');
                disdiciPopup.removeAttribute('hidden');
            }
        });
    }

    if (disdiciIndietro) {
        disdiciIndietro.addEventListener('click', function() {
            idDaDisdire = null;
            disdiciPopup.setAttribute('hidden', '');
        });
    }

    if (disdiciConferma) {
        disdiciConferma.addEventListener('click', function() {
            if (!idDaDisdire) return;

            var id = idDaDisdire;

            fetch('{/literal}{$base_url}{literal}/profilo/eventi/disdici', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                credentials: 'same-origin',
                body: JSON.stringify({ id: id })
            })
            .then(function(response) { return response.json(); })
            .then(function(data) {
                disdiciPopup.setAttribute('hidden', '');
                idDaDisdire = null;

                if (data.status === 'ok') {
                    window.location.reload();
                } else if (data.reason === 'non_disdicibile') {
                    mostraPopup('Non è più possibile disdire questa partecipazione.');
                } else {
                    mostraPopup('Non è stato possibile disdire la partecipazione, riprova più tardi.');
                }
            })
            .catch(function() {
                disdiciPopup.setAttribute('hidden', '');
                idDaDisdire = null;
                mostraPopup('Si è verificato un errore di connessione, riprova più tardi.');
            });
        });
    }

})();
{/literal}
</script>
{/block}