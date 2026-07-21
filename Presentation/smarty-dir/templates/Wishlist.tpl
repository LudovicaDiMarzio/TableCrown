{extends file="common/layout.tpl"}

{block name="extra_css"}
    <link rel="stylesheet" href="{$base_url}/css/Wishlist.css">
{/block}

{block name="content"}
<div class="wishlist-container">
    <div class="container">

        {* ── TOPBAR: TORNA ALL'AREA PERSONALE ── *}
        <div class="wishlist-topbar">
            <a href="{$base_url}/profilo" class="wishlist-back-link">
                <i class="ti ti-arrow-left"></i> Torna all'Area Personale
            </a>
        </div>

        {* ── HEADER ── *}
        <div class="wishlist-header">
            <div class="wishlist-header-text">
                <span class="wishlist-eyebrow">Area Personale</span>
                <h1 class="wishlist-titolo">
                    <i class="ti ti-heart-filled"></i> La Mia Wishlist
                </h1>
            </div>

            {if isset($wishlist) && $wishlist|@count > 0}
                <div class="wishlist-count-badge">
                    <span class="wishlist-count-num">{$wishlist|@count}</span>
                    <span class="wishlist-count-label">{if $wishlist|@count == 1}articolo{else}articoli{/if}</span>
                </div>
            {/if}
        </div>

        {* ── GRIGLIA PRODOTTI ── *}
        {if isset($wishlist) && $wishlist|@count > 0}
            <div class="wishlist-grid" id="wishlist-grid">
                {foreach $wishlist as $prodotto}
                    <div class="wishlist-card {if !$prodotto.isAcquistabile}wishlist-card-esaurito{/if}"
                         data-id="{$prodotto.id|escape}"
                         id="wishlist-card-{$prodotto.id|escape}">

                        <div class="wishlist-card-media">
                            <a href="{$base_url}/prodotto/{$prodotto.id|escape}">
                                {if isset($prodotto.immagine) && $prodotto.immagine}
                                    <img src="{$base_url}/img/prodotti/{$prodotto.immagine|escape}"
                                         onerror="this.onerror=null; this.src='{$base_url}/img/prodotto-default.png'"
                                         alt="{$prodotto.nome|escape}"
                                         class="wishlist-card-img">
                                {else}
                                    <div class="wishlist-card-img-placeholder">
                                        <i class="ti ti-photo"></i>
                                    </div>
                                {/if}
                            </a>

                            {if $prodotto.disponibilita == 'esaurito'}
                                <span class="wishlist-badge-esaurito">Esaurito</span>
                            {elseif $prodotto.disponibilita == 'annunciato'}
                                <span class="wishlist-badge-esaurito wishlist-badge-annunciato">In arrivo</span>
                            {/if}

                            {if isset($prodotto.sconto) && $prodotto.sconto && $prodotto.percentuale_sconto}
                                <span class="wishlist-badge-sconto">-{$prodotto.percentuale_sconto|escape}%</span>
                            {/if}

                            <button type="button"
                                    class="wishlist-remove-btn"
                                    data-id="{$prodotto.id|escape}"
                                    aria-label="Rimuovi dalla wishlist"
                                    title="Rimuovi dalla wishlist">
                                <i class="ti ti-heart-filled"></i>
                            </button>
                        </div>

                        <div class="wishlist-card-body">
                            <a href="{$base_url}/prodotto/{$prodotto.id|escape}" class="wishlist-card-nome">
                                {$prodotto.nome|escape}
                            </a>

                            {if isset($prodotto.valutazione_media)}
                                <div class="wishlist-card-stelle" aria-label="Valutazione {$prodotto.valutazione_media|escape} su 5">
                                    {for $i=1 to 5}
                                        {if $i <= $prodotto.valutazione_media}
                                            <i class="ti ti-star-filled"></i>
                                        {elseif $i - 0.5 <= $prodotto.valutazione_media}
                                            <i class="ti ti-star-half-filled"></i>
                                        {else}
                                            <i class="ti ti-star"></i>
                                        {/if}
                                    {/for}
                                    <span class="wishlist-card-stelle-valore">{$prodotto.valutazione_media|escape}</span>
                                </div>
                            {/if}

                            <div class="wishlist-card-prezzo-row">
                                {if isset($prodotto.sconto) && $prodotto.sconto && $prodotto.prezzo_scontato}
                                    <span class="wishlist-prezzo-scontato">€ {$prodotto.prezzo_scontato|escape}</span>
                                    <span class="wishlist-prezzo-originale">€ {$prodotto.prezzo|escape}</span>
                                {else}
                                    <span class="wishlist-prezzo">€ {$prodotto.prezzo|escape}</span>
                                {/if}
                            </div>

                            <button type="button"
                                    class="wishlist-btn-carrello"
                                    data-id="{$prodotto.id|escape}"
                                    {if !$prodotto.isAcquistabile}disabled{/if}>
                                <i class="ti ti-shopping-cart-plus"></i>
                                {if !$prodotto.isAcquistabile}Non disponibile{else}Aggiungi al carrello{/if}
                            </button>
                        </div>

                    </div>
                {/foreach}
            </div>
        {else}
            {* ── STATO VUOTO ── *}
            <div class="wishlist-empty" id="wishlist-empty">
                <div class="wishlist-empty-icon">
                    <i class="ti ti-heart"></i>
                </div>
                <h2 class="wishlist-empty-titolo">La tua wishlist è vuota</h2>
                <p class="wishlist-empty-testo">Salva i prodotti che ti piacciono per ritrovarli facilmente quando vuoi.</p>
                <a href="{$base_url}/catalogo/giochi-da-tavolo" class="wishlist-empty-btn">
                    <i class="ti ti-shopping-bag"></i> Scopri il catalogo
                </a>
            </div>
        {/if}

        {* ── POPUP MESSAGGI (feedback azioni) ── *}
        <div class="wishlist-popup-overlay" id="wishlist-popup" hidden>
            <div class="wishlist-popup-box">
                <i class="ti ti-circle-check wishlist-popup-icon" id="wishlist-popup-icon"></i>
                <p class="wishlist-popup-message" id="wishlist-popup-message"></p>
                <button type="button" class="wishlist-btn-primary" id="wishlist-popup-close">Chiudi</button>
            </div>
        </div>

    </div>
</div>
{/block}

{block name="extra_js"}
<script>
{literal}
(function() {

    var grid  = document.getElementById('wishlist-grid');
    var empty = document.getElementById('wishlist-empty');

    var popup        = document.getElementById('wishlist-popup');
    var popupMessage = document.getElementById('wishlist-popup-message');
    var popupIcon     = document.getElementById('wishlist-popup-icon');
    var popupClose    = document.getElementById('wishlist-popup-close');

    function mostraPopup(messaggio, successo) {
        popupMessage.textContent = messaggio;
        popupIcon.className = 'ti wishlist-popup-icon ' + (successo ? 'ti-circle-check' : 'ti-alert-triangle');
        popupIcon.classList.toggle('wishlist-popup-icon-errore', !successo);
        popup.removeAttribute('hidden');
    }

    if (popupClose) {
        popupClose.addEventListener('click', function() {
            popup.setAttribute('hidden', '');
        });
    }

    function mostraStatoVuotoSeNecessario() {
        if (grid && grid.children.length === 0) {
            grid.setAttribute('hidden', '');
            if (empty) {
                empty.removeAttribute('hidden');
            } else {
                window.location.reload();
            }
        }
    }

    // ── RIMOZIONE DALLA WISHLIST ──
    if (grid) {
        grid.addEventListener('click', function(e) {
            var btn = e.target.closest('.wishlist-remove-btn');
            if (!btn) return;

            var id = btn.getAttribute('data-id');
            var card = document.getElementById('wishlist-card-' + id);

            fetch('{/literal}{$base_url}{literal}/wishlist/rimuovi', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
        'X-Requested-With': 'XMLHttpRequest'
    },
    credentials: 'same-origin',
    body: 'id_prodotto=' + encodeURIComponent(id)
})
            .then(function(response) { return response.json(); })
            .then(function(data) {
                if (data.status === 'ok') {
                    if (card) {
                        card.classList.add('wishlist-card-uscita');
                        card.addEventListener('transitionend', function() {
                            card.remove();
                            mostraStatoVuotoSeNecessario();
                        }, { once: true });
                    }
                } else {
                    mostraPopup('Non è stato possibile rimuovere il prodotto, riprova più tardi.', false);
                }
            })
            .catch(function() {
                mostraPopup('Si è verificato un errore di connessione, riprova più tardi.', false);
            });
        });

        // ── AGGIUNGI AL CARRELLO ──
        grid.addEventListener('click', function(e) {
            var btn = e.target.closest('.wishlist-btn-carrello');
            if (!btn || btn.disabled) return;

            var id = btn.getAttribute('data-id');

            fetch('{/literal}{$base_url}{literal}/wishlist/aggiungi-carrello', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                credentials: 'same-origin',
                body: JSON.stringify({ id: id })
            })
            .then(function(response) { return response.json(); })
            .then(function(data) {
                if (data.status === 'ok') {
                    mostraPopup('Prodotto aggiunto al carrello!', true);
                } else if (data.reason === 'esaurito') {
                    mostraPopup('Il prodotto non è più disponibile.', false);
                } else {
                    mostraPopup('Non è stato possibile aggiungere il prodotto, riprova più tardi.', false);
                }
            })
            .catch(function() {
                mostraPopup('Si è verificato un errore di connessione, riprova più tardi.', false);
            });
        });
    }

})();
{/literal}
</script>
{/block}