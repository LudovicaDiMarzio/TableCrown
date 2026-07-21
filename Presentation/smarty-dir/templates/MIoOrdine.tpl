{extends file="common/layout.tpl"}

{block name="extra_css"}
    <link rel="stylesheet" href="{$base_url}/css/MioOrdine.css">
{/block}

{block name="content"}
<div class="mieordini-container">
    <div class="container">

        {* ── TOPBAR ── *}
        <div class="mieordini-topbar">
            <a href="{$base_url}/profilo" class="mieordini-back-link">
                <i class="ti ti-arrow-left"></i> Torna all'Area Personale
            </a>
        </div>

        {* ── HEADER ── *}
        <div class="mieordini-header">
            <div class="mieordini-header-text">
                <span class="mieordini-eyebrow">Area Personale</span>
                <h1 class="mieordini-titolo">
                    <i class="ti ti-package"></i> I Miei Ordini
                </h1>
            </div>

            {if isset($ordini) && $ordini|@count > 0}
                <div class="mieordini-count-badge">
                    <span class="mieordini-count-num">{$ordini|@count}</span>
                    <span class="mieordini-count-label">{if $ordini|@count == 1}ordine{else}ordini{/if}</span>
                </div>
            {/if}
        </div>

        {* ── LISTA ORDINI ── *}
        {if isset($ordini) && $ordini|@count > 0}
            <div class="mieordini-list" id="mieordini-list">
                {foreach $ordini as $ordine}
                    <div class="mieordini-card" id="mieordini-card-{$ordine.id|escape}">

                        {* ── RIGA CLICCABILE: HEADER ORDINE ── *}
                        <button type="button" class="mieordini-card-header" data-target="mieordini-body-{$ordine.id|escape}" aria-expanded="false">
                            <div class="mieordini-card-header-left">
                                <span class="mieordini-ordine-id">Ordine #{$ordine.id|escape}</span>
                                <span class="mieordini-ordine-data">{$ordine.data|escape}</span>
                            </div>

                            <div class="mieordini-card-header-right">
                                <span class="mieordini-stato-badge mieordini-stato-{$ordine.stato|escape}">
                                    {if $ordine.stato == 'in_lavorazione'}<i class="ti ti-clock"></i> In lavorazione
                                    {elseif $ordine.stato == 'spedito'}<i class="ti ti-truck-delivery"></i> Spedito
                                    {elseif $ordine.stato == 'consegnato'}<i class="ti ti-circle-check"></i> Consegnato
                                    {elseif $ordine.stato == 'annullato'}<i class="ti ti-circle-x"></i> Annullato
                                    {else}{$ordine.stato|escape}
                                    {/if}
                                </span>

                                <span class="mieordini-ordine-totale">€ {$ordine.totale|escape}</span>

                                <i class="ti ti-chevron-down mieordini-chevron"></i>
                            </div>
                        </button>

                        {* ── DETTAGLIO ORDINE (collassabile) ── *}
                        <div class="mieordini-card-body" id="mieordini-body-{$ordine.id|escape}" hidden>

                            {* ── ARTICOLI ── *}
                            <div class="mieordini-items">
                                {foreach $ordine.items as $item}
                                    <div class="mieordini-item">
                                        <a href="{$base_url}/prodotto?id={$item.prodotto.id|escape}" class="mieordini-item-media">
                                            {if isset($item.prodotto.immagine) && $item.prodotto.immagine}
                                                <img src="{$base_url}/img/prodotti/{$item.prodotto.immagine|escape}"
                                                     onerror="this.onerror=null; this.src='{$base_url}/img/prodotto-default.png'"
                                                     alt="{$item.prodotto.nome|escape}"
                                                     class="mieordini-item-img">
                                            {else}
                                                <div class="mieordini-item-img-placeholder">
                                                    <i class="ti ti-photo"></i>
                                                </div>
                                            {/if}
                                        </a>

                                        <div class="mieordini-item-info">
                                            <a href="{$base_url}/prodotto?id={$item.prodotto.id|escape}" class="mieordini-item-nome">
                                                {$item.prodotto.nome|escape}
                                            </a>
                                            <span class="mieordini-item-qty">Quantità: {$item.quantita|escape}</span>
                                        </div>

                                        <div class="mieordini-item-prezzi">
                                            {if isset($item.scontoApplicato) && $item.scontoApplicato > 0}
                                                <span class="mieordini-item-prezzo-unitario-scontato">€ {$item.prezzoUnitario|escape}</span>
                                                <span class="mieordini-item-sconto-badge">-{$item.scontoApplicato|escape}%</span>
                                            {else}
                                                <span class="mieordini-item-prezzo-unitario">€ {$item.prezzoUnitario|escape} cad.</span>
                                            {/if}
                                            <span class="mieordini-item-totale">€ {$item.totaleItem|escape}</span>
                                        </div>
                                    </div>
                                {/foreach}
                            </div>

                            {* ── INDIRIZZO + PAGAMENTO ── *}
                            <div class="mieordini-info-grid">
                                <div class="mieordini-info-block">
                                    <h3 class="mieordini-info-title"><i class="ti ti-map-pin"></i> Indirizzo di spedizione</h3>
                                    <p class="mieordini-info-text">
                                        {$ordine.indirizzoSpedizione.via|escape}<br>
                                        {$ordine.indirizzoSpedizione.cap|escape} {$ordine.indirizzoSpedizione.citta|escape} ({$ordine.indirizzoSpedizione.provincia|escape})<br>
                                        {$ordine.indirizzoSpedizione.nazione|escape}
                                    </p>
                                </div>

                                <div class="mieordini-info-block">
                                    <h3 class="mieordini-info-title"><i class="ti ti-credit-card"></i> Metodo di pagamento</h3>
                                    <p class="mieordini-info-text">
                                        Carta terminante con <strong>{$ordine.ultimeQuattroCifreCarta|escape}</strong><br>
                                        Intestata a {$ordine.nomeTitolareCarta|escape}
                                    </p>
                                </div>
                            </div>

                        </div>

                    </div>
                {/foreach}
            </div>
        {else}
            {* ── STATO VUOTO ── *}
            <div class="mieordini-empty" id="mieordini-empty">
                <div class="mieordini-empty-icon">
                    <i class="ti ti-package"></i>
                </div>
                <h2 class="mieordini-empty-titolo">Non hai ancora effettuato ordini</h2>
                <p class="mieordini-empty-testo">Quando completerai un acquisto, lo troverai qui insieme allo stato della spedizione.</p>
                <a href="{$base_url}/catalogo/giochi-da-tavolo" class="mieordini-empty-btn">
                    <i class="ti ti-shopping-bag"></i> Scopri il catalogo
                </a>
            </div>
        {/if}

        {* ── POPUP MESSAGGI (feedback errore) ── *}
        <div class="mieordini-popup-overlay" id="mieordini-popup" hidden>
            <div class="mieordini-popup-box">
                <i class="ti ti-alert-triangle mieordini-popup-icon"></i>
                <p class="mieordini-popup-message" id="mieordini-popup-message"></p>
                <button type="button" class="mieordini-btn-primary" id="mieordini-popup-close">Chiudi</button>
            </div>
        </div>

    </div>
</div>
{/block}

{block name="extra_js"}
<script>
{literal}
(function() {

    var list = document.getElementById('mieordini-list');

    var popup        = document.getElementById('mieordini-popup');
    var popupMessage = document.getElementById('mieordini-popup-message');
    var popupClose    = document.getElementById('mieordini-popup-close');

    

    function mostraPopup(messaggio) {
        popupMessage.textContent = messaggio;
        popup.removeAttribute('hidden');
    }

    if (popupClose) {
        popupClose.addEventListener('click', function() {
            popup.setAttribute('hidden', '');
        });
    }

    // ── APERTURA/CHIUSURA DETTAGLIO ORDINE ──
    if (list) {
        list.addEventListener('click', function(e) {
            var header = e.target.closest('.mieordini-card-header');
            if (header) {
                var targetId = header.getAttribute('data-target');
                var body = document.getElementById(targetId);
                if (!body) return;

                var aperto = body.hasAttribute('hidden');
                if (aperto) {
                    body.removeAttribute('hidden');
                } else {
                    body.setAttribute('hidden', '');
                }
                header.setAttribute('aria-expanded', aperto ? 'true' : 'false');
                return;
            }

        });
    }

    
})();
{/literal}
</script>
{/block}