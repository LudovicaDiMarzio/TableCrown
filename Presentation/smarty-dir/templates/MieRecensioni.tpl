{extends file="common/layout.tpl"}

{block name="extra_css"}
    <link rel="stylesheet" href="{$base_url}/css/MieRecensioni.css">
{/block}

{block name="content"}
<div class="mierecensioni-container">
    <div class="container">

        {* ── TOPBAR: TORNA ALL'AREA PERSONALE ── *}
        <div class="mierecensioni-topbar">
            <a href="{$base_url}/account" class="mierecensioni-back-link">
                <i class="ti ti-arrow-left"></i> Torna all'Area Personale
            </a>
        </div>

        {* ── HEADER ── *}
        <div class="mierecensioni-header">
            <div class="mierecensioni-header-text">
                <span class="mierecensioni-eyebrow">Area Personale</span>
                <h1 class="mierecensioni-titolo">
                    <i class="ti ti-star-filled"></i> Le Mie Recensioni
                </h1>
            </div>

            {if isset($recensioni) && $recensioni|@count > 0}
                <div class="mierecensioni-count-badge">
                    <span class="mierecensioni-count-num">{$recensioni|@count}</span>
                    <span class="mierecensioni-count-label">{if $recensioni|@count == 1}recensione{else}recensioni{/if}</span>
                </div>
            {/if}
        </div>

        {* ── LISTA RECENSIONI ── *}
        {if isset($recensioni) && $recensioni|@count > 0}
            <div class="mierecensioni-list" id="mierecensioni-list">
                {foreach $recensioni as $recensione}
                    <div class="mierecensioni-card {if isset($recensione.isSegnalata) && $recensione.isSegnalata}mierecensioni-card-segnalata{/if}" id="mierecensioni-card-{$recensione.id|escape}">

                        <a href="{$base_url}/prodotto/{$recensione.prodotto.id|escape}" class="mierecensioni-card-media">
                            {if isset($recensione.prodotto.immagine) && $recensione.prodotto.immagine}
                                <img src="{$base_url}/img/prodotti/{$recensione.prodotto.immagine|escape}"
                                     onerror="this.onerror=null; this.src='{$base_url}/img/prodotto-default.png'"
                                     alt="{$recensione.prodotto.nome|escape}"
                                     class="mierecensioni-card-img">
                            {else}
                                <div class="mierecensioni-card-img-placeholder">
                                    <i class="ti ti-photo"></i>
                                </div>
                            {/if}
                        </a>

                        <div class="mierecensioni-card-body">
                            <div class="mierecensioni-card-top">
                                <a href="{$base_url}/prodotto/{$recensione.prodotto.id|escape}" class="mierecensioni-card-nome">
                                    {$recensione.prodotto.nome|escape}
                                </a>

                                <div class="mierecensioni-card-meta">
                                    <span class="mierecensioni-card-stelle" aria-label="Valutazione {$recensione.valutazione|escape} su 5">
                                        {for $i=1 to 5}
                                            {if $i <= $recensione.valutazione}
                                                <i class="ti ti-star-filled"></i>
                                            {else}
                                                <i class="ti ti-star"></i>
                                            {/if}
                                        {/for}
                                    </span>
                                    <span class="mierecensioni-card-sep">&middot;</span>
                                    <span class="mierecensioni-card-data">{$recensione.data|escape}</span>

                                    {if isset($recensione.isSegnalata) && $recensione.isSegnalata}
                                        <span class="mierecensioni-badge-segnalata">
                                            <i class="ti ti-flag-filled"></i> Segnalata
                                        </span>
                                    {/if}
                                </div>
                            </div>

                            <p class="mierecensioni-card-testo">{$recensione.testo|escape|nl2br}</p>
                        </div>

                        <button type="button"
                                class="mierecensioni-btn-elimina"
                                data-id="{$recensione.id|escape}">
                            <i class="ti ti-trash"></i> Elimina
                        </button>

                    </div>
                {/foreach}
            </div>
        {else}
            {* ── STATO VUOTO ── *}
            <div class="mierecensioni-empty" id="mierecensioni-empty">
                <div class="mierecensioni-empty-icon">
                    <i class="ti ti-star"></i>
                </div>
                <h2 class="mierecensioni-empty-titolo">Non hai ancora scritto recensioni</h2>
                <p class="mierecensioni-empty-testo">Le recensioni che lasci sui prodotti acquistati compariranno qui.</p>
                <a href="{$base_url}/account/ordini" class="mierecensioni-empty-btn">
                    <i class="ti ti-package"></i> Vai ai tuoi ordini
                </a>
            </div>
        {/if}

        {* ── POPUP CONFERMA ELIMINAZIONE ── *}
        <div class="mierecensioni-popup-overlay" id="mierecensioni-elimina-popup" hidden>
            <div class="mierecensioni-popup-box">
                <i class="ti ti-alert-triangle mierecensioni-popup-icon"></i>
                <p class="mierecensioni-popup-message">Sei sicuro di voler eliminare questa recensione?</p>

                <div class="mierecensioni-popup-actions">
                    <button type="button" class="mierecensioni-btn-secondary" id="mierecensioni-elimina-annulla">Annulla</button>
                    <button type="button" class="mierecensioni-btn-primary" id="mierecensioni-elimina-conferma">Conferma</button>
                </div>
            </div>
        </div>

        {* ── POPUP MESSAGGI (feedback errore) ── *}
        <div class="mierecensioni-popup-overlay" id="mierecensioni-popup" hidden>
            <div class="mierecensioni-popup-box">
                <i class="ti ti-alert-triangle mierecensioni-popup-icon"></i>
                <p class="mierecensioni-popup-message" id="mierecensioni-popup-message"></p>
                <button type="button" class="mierecensioni-btn-primary" id="mierecensioni-popup-close">Chiudi</button>
            </div>
        </div>

    </div>
</div>
{/block}

{block name="extra_js"}
<script>
{literal}
(function() {

    var list  = document.getElementById('mierecensioni-list');
    var empty = document.getElementById('mierecensioni-empty');

    var popup        = document.getElementById('mierecensioni-popup');
    var popupMessage = document.getElementById('mierecensioni-popup-message');
    var popupClose    = document.getElementById('mierecensioni-popup-close');

    var eliminaPopup       = document.getElementById('mierecensioni-elimina-popup');
    var eliminaAnnullaBtn  = document.getElementById('mierecensioni-elimina-annulla');
    var eliminaConfermaBtn = document.getElementById('mierecensioni-elimina-conferma');
    var idDaEliminare       = null;

    function mostraPopup(messaggio) {
        popupMessage.textContent = messaggio;
        popup.removeAttribute('hidden');
    }

    if (popupClose) {
        popupClose.addEventListener('click', function() {
            popup.setAttribute('hidden', '');
        });
    }

    function mostraStatoVuotoSeNecessario() {
        if (list && list.children.length === 0) {
            list.setAttribute('hidden', '');
            if (empty) {
                empty.removeAttribute('hidden');
            } else {
                window.location.reload();
            }
        }
    }

    // ── APERTURA POPUP CONFERMA ──
    if (list) {
        list.addEventListener('click', function(e) {
            var btn = e.target.closest('.mierecensioni-btn-elimina');
            if (!btn) return;

            idDaEliminare = btn.getAttribute('data-id');
            eliminaPopup.removeAttribute('hidden');
        });
    }

    if (eliminaAnnullaBtn) {
        eliminaAnnullaBtn.addEventListener('click', function() {
            idDaEliminare = null;
            eliminaPopup.setAttribute('hidden', '');
        });
    }

    // ── CONFERMA ELIMINAZIONE (AJAX) ──
    if (eliminaConfermaBtn) {
        eliminaConfermaBtn.addEventListener('click', function() {
            if (!idDaEliminare) return;

            var id = idDaEliminare;
            var card = document.getElementById('mierecensioni-card-' + id);

            fetch('{/literal}{$base_url}{literal}/account/recensioni/elimina', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                credentials: 'same-origin',
                body: JSON.stringify({ id: id })
            })
            .then(function(response) { return response.json(); })
            .then(function(data) {
                eliminaPopup.setAttribute('hidden', '');
                idDaEliminare = null;

                if (data.status === 'ok') {
                    if (card) {
                        card.classList.add('mierecensioni-card-uscita');
                        card.addEventListener('transitionend', function() {
                            card.remove();
                            mostraStatoVuotoSeNecessario();
                        }, { once: true });
                    }
                } else {
                    mostraPopup('Non è stato possibile eliminare la recensione, riprova più tardi.');
                }
            })
            .catch(function() {
                eliminaPopup.setAttribute('hidden', '');
                idDaEliminare = null;
                mostraPopup('Si è verificato un errore di connessione, riprova più tardi.');
            });
        });
    }

})();
{/literal}
</script>
{/block}