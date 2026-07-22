{extends file="common/layout.tpl"}

{block name="extra_css"}
    <link rel="stylesheet" href="{$base_url}/css/checkout.css">
{/block}

{block name="content"}

<div class="checkout-container">
    {* ── MODAL ESITO ACQUISTO ── *}
    {if isset($flash_type) && $flash_type == 'success'}
        <div class="checkout-esito-overlay" id="esito-successo" aria-hidden="false">
            <div class="checkout-esito-modal checkout-esito-successo">
                <i class="ti ti-circle-check checkout-esito-icon"></i>
                <h3 class="checkout-esito-titolo">Acquisto completato!</h3>
                <p class="checkout-esito-testo">{$flash_message|escape}</p>
                <a href="{$base_url}/profilo/ordini" class="button btn-checkout-conferma">
                    <i class="ti ti-list-check"></i> Vai ai tuoi ordini
                </a>
            </div>
        
        </div>
    {/if}

    {if isset($flash_type) && $flash_type == 'danger'}
        <div class="checkout-esito-overlay checkout-esito-overlay-errore" id="esito-errore" aria-hidden="false">
            <div class="checkout-esito-modal checkout-esito-errore">
                <button type="button" class="checkout-esito-close" id="close-esito-errore" aria-label="Chiudi">&times;</button>
                <i class="ti ti-alert-triangle checkout-esito-icon"></i>
                <h3 class="checkout-esito-titolo">Acquisto non riuscito</h3>
                <p class="checkout-esito-testo">{$flash_message|escape}</p>
                <p class="checkout-esito-sub">Controlla i dati inseriti e riprova.</p>
             <button type="button" class="button btn-checkout-conferma" id="btn-riprova-errore">
                 <i class="ti ti-refresh"></i> Riprova
                </button>
            </div>
        </div>
    {/if}
    <div class="container">

        <h1 class="checkout-title">Checkout</h1>

        <form action="{$azione_checkout|default:"$base_url/checkout/acquista"}" method="post" class="checkout-form" id="checkout-form">

            {if $tipo_checkout == 'evento'}
                <input type="hidden" name="id_evento" value="{$evento.idEvento}">
            {/if}

            <div class="checkout-grid">

                {* ── COLONNA PRINCIPALE ── *}
                <div class="checkout-main">

                    {* ── RIEPILOGO ── *}
                    <section class="checkout-section">
                        <h2 class="checkout-section-title">
                            {if $tipo_checkout == 'evento'}Riepilogo Iscrizione{else}Riepilogo Ordine{/if}
                        </h2>

                        {if $tipo_checkout == 'evento' && isset($evento)}
                            <div class="checkout-evento-card">
                                <img src="{$base_url}/img/eventi/{$evento.imgEvento|escape}"
                                     alt="{$evento.nomeEvento|escape}"
                                     class="checkout-evento-img">
                                <div class="checkout-evento-info">
                                    <h3 class="checkout-evento-nome">{$evento.nomeEvento|escape}</h3>
                                    {if isset($evento.dataInizio)}
                                        <p class="checkout-evento-meta"><i class="ti ti-calendar"></i> {$evento.dataInizio|date_format:"%d/%m/%Y %H:%M"}</p>
                                    {/if}
                                    {if isset($evento.gioco)}
                                        <p class="checkout-evento-meta"><i class="ti ti-cards"></i> {$evento.gioco|escape}</p>
                                    {/if}
                                </div>
                                {if isset($evento.quotaIscrizione)}
                                    <div class="checkout-evento-quota">€{$evento.quotaIscrizione|number_format:2}</div>
                                {/if}
                            </div>
                        {else}
                            <div class="checkout-prodotti-list">
                                {foreach $prodotti_carrello as $item}
                                    <div class="checkout-prodotto-row">
                                        <img src="{$base_url}/img/prodotti/{$item.prodotto.immagine|escape}"
                                             alt="{$item.prodotto.nome|escape}"
                                             class="checkout-prodotto-img">
                                        <div class="checkout-prodotto-info">
                                            <p class="checkout-prodotto-nome">{$item.prodotto.nome|escape}</p>
                                            <p class="checkout-prodotto-qta">Quantità: {$item.quantita}</p>
                                        </div>
                                        <div class="checkout-prodotto-prezzo">
                                            €{$item.subtotale|number_format:2}
                                        </div>
                                    </div>
                                {foreachelse}
                                    <p class="checkout-empty">Nessun prodotto nel carrello.</p>
                                {/foreach}
                            </div>
                        {/if}
                    </section>

                    {* ── INDIRIZZO (solo per prodotti) ── *}
                    {if $tipo_checkout != 'evento'}
                        <section class="checkout-section">
                            <h2 class="checkout-section-title">Indirizzo di Spedizione</h2>

                            {if isset($indirizzi) && $indirizzi|@count > 0}
                                <div class="checkout-radio-list" id="indirizzi-list">
                                    {foreach $indirizzi as $ind}
                                        <label class="checkout-radio-card{if $ind.predefinito} is-selected{/if}">
                                            <input type="radio" name="id_indirizzo" value="{$ind.id}" {if $ind.predefinito}checked{/if}>
                                            <div class="checkout-radio-content">
                                                <p class="checkout-radio-title">
                                                    {$ind.nome|escape}
                                                    {if $ind.predefinito}<span class="checkout-badge-predefinito">Predefinito</span>{/if}
                                                </p>
                                                <p class="checkout-radio-sub">
                                                    {$ind.via|escape}, {$ind.citta|escape} ({$ind.provincia|escape}) {$ind.cap|escape}, {$ind.nazione|escape}
                                                </p>
                                            </div>
                                        </label>
                                    {/foreach}
                                </div>
                            {else}
    <div class="checkout-empty-state">
        <i class="ti ti-map-pin-off checkout-empty-state-icon"></i>
        <p class="checkout-empty-state-text">Non hai indirizzi salvati.</p>
        <a href="{$base_url}/profilo/indirizzi" class="button btn-checkout-aggiungi-indirizzo">
            <i class="ti ti-plus"></i> Aggiungi un indirizzo
        </a>
    </div>
{/if}
                        </section>
                    {/if}

                    {* ── PAGAMENTO ── *}
<section class="checkout-section">
    <h2 class="checkout-section-title">Metodo di Pagamento</h2>

    {if isset($carte) && $carte|@count > 0}
        <div class="checkout-tabs">
            <label class="checkout-tab is-active" id="tab-salvata">
                <input type="radio" name="scelta_carta" value="salvata" checked>
                <i class="ti ti-credit-card"></i> Carta Salvata
            </label>
            <label class="checkout-tab" id="tab-nuova">
                <input type="radio" name="scelta_carta" value="nuova">
                <i class="ti ti-plus"></i> Nuova Carta
            </label>
        </div>

        <div class="checkout-radio-list" id="carte-salvate-list">
            {foreach $carte as $carta}
                <label class="checkout-radio-card">
                    <input type="radio" name="id_carta_salvata" value="{$carta.id}">
                    <div class="checkout-radio-content">
                        <p class="checkout-radio-title"><i class="ti ti-credit-card"></i> {$carta.titolare|escape}</p>
                        <p class="checkout-radio-sub">**** **** **** {$carta.ultimeQuattroCifre|escape} — Scad. {$carta.scadenza|escape}</p>
                    </div>
                </label>
            {/foreach}
        </div>
    {else}
        <input type="hidden" name="scelta_carta" value="nuova">
    {/if}

    <input type="hidden" name="id_carta_salvata" id="id_carta_salvata_fallback" value="0" {if isset($carte) && $carte|@count > 0}disabled{/if}>

    <div class="checkout-nuova-carta" id="nuova-carta-form" {if isset($carte) && $carte|@count > 0}style="display:none;"{/if}>

                        <div class="checkout-nuova-carta" id="nuova-carta-form" {if isset($carte) && $carte|@count > 0}style="display:none;"{/if}>
                            <div class="form-group">
                                <label class="form-label" for="titolare_carta">Titolare</label>
                                <input type="text" id="titolare_carta" name="titolare_carta" class="input" placeholder="Nome sulla carta">
                            </div>
                            <div class="checkout-form-row">
                                <div class="form-group">
                                    <label class="form-label" for="numero_carta">Numero Carta</label>
                                    <input type="text" id="numero_carta" name="numero_carta" class="input" placeholder="0000 0000 0000 0000" maxlength="19">
                                </div>
                                <div class="form-group form-group-small">
                                    <label class="form-label" for="scadenza_carta">Scadenza</label>
                                    <input type="text" id="scadenza_carta" name="scadenza_carta" class="input" placeholder="MM/AA" maxlength="5">
                                </div>
                                <div class="form-group form-group-small">
                                    <label class="form-label" for="cvv">CVV</label>
                                    <input type="password" id="cvv" name="cvv" class="input" placeholder="123" maxlength="4">
                                </div>
                            </div>
                            <label class="checkout-checkbox">
                                <input type="checkbox" name="salva_carta_profilo" value="1">
                                Salva questa carta sul mio profilo
                            </label>
                        </div>
                    </section>

                </div>

                {* ── COLONNA LATERALE: RIEPILOGO TOTALE ── *}
                <aside class="checkout-summary-box">
                    <h2 class="checkout-summary-title">Totale</h2>

                    <div class="checkout-summary-row">
                        <span>{if $tipo_checkout == 'evento'}Quota Iscrizione{else}Subtotale{/if}</span>
                        <span>
                            €{if $tipo_checkout == 'evento'}{$evento.quotaIscrizione|number_format:2}{else}{$totale_carrello|number_format:2}{/if}
                        </span>
                    </div>

                    <div class="checkout-summary-total">
                        <span>Totale</span>
                        <span>
                            €{if $tipo_checkout == 'evento'}{$evento.quotaIscrizione|number_format:2}{else}{$totale_carrello|number_format:2}{/if}
                        </span>
                    </div>

                    <button type="submit" class="button btn-checkout-conferma">
                        <i class="ti ti-lock"></i> Conferma e Paga
                    </button>

                    <a href="{$base_url}/{if $tipo_checkout == 'evento'}eventi{else}carrello{/if}" class="checkout-back-link">
                        <i class="ti ti-arrow-left"></i> {if $tipo_checkout == 'evento'}Torna agli eventi{else}Torna al carrello{/if}
                    </a>
                </aside>

            </div>
        </form>

    </div>
</div>

{/block}

{block name="extra_js"}
<script>
{literal}
(function() {

    var tabSalvata = document.getElementById('tab-salvata');
    var tabNuova = document.getElementById('tab-nuova');
    var carteList = document.getElementById('carte-salvate-list');
    var nuovaCartaForm = document.getElementById('nuova-carta-form');
    var fallbackCartaSalvata = document.getElementById('id_carta_salvata_fallback');

    function mostraSalvata() {
        if (tabSalvata) tabSalvata.classList.add('is-active');
        if (tabNuova) tabNuova.classList.remove('is-active');
        if (carteList) carteList.style.display = '';
        if (nuovaCartaForm) nuovaCartaForm.style.display = 'none';
        if (fallbackCartaSalvata) fallbackCartaSalvata.disabled = true;
    }

    function mostraNuova() {
        if (tabNuova) tabNuova.classList.add('is-active');
        if (tabSalvata) tabSalvata.classList.remove('is-active');
        if (carteList) carteList.style.display = 'none';
        if (nuovaCartaForm) nuovaCartaForm.style.display = 'block';
        if (fallbackCartaSalvata) fallbackCartaSalvata.disabled = false;
    }

    if (tabSalvata) tabSalvata.addEventListener('click', mostraSalvata);
    if (tabNuova) tabNuova.addEventListener('click', mostraNuova)

    // ── EVIDENZIAZIONE RADIO CARD SELEZIONATA (indirizzi e carte) ──
    document.querySelectorAll('.checkout-radio-list').forEach(function(lista) {
        var cards = lista.querySelectorAll('.checkout-radio-card');
        cards.forEach(function(card) {
            var input = card.querySelector('input[type="radio"]');
            if (!input) return;
            input.addEventListener('change', function() {
                cards.forEach(function(c) { c.classList.remove('is-selected'); });
                card.classList.add('is-selected');
            });
        });
    });

    // ── VALIDAZIONE MINIMA LATO CLIENT ──
    var form = document.getElementById('checkout-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            var sceltaCartaEl = form.querySelector('input[name="scelta_carta"]:checked')
                              || form.querySelector('input[name="scelta_carta"][type="hidden"]');
            if (sceltaCartaEl && sceltaCartaEl.value === 'nuova') {
                var numero = document.getElementById('numero_carta');
                var cvv = document.getElementById('cvv');
                var titolare = document.getElementById('titolare_carta');
                var scadenza = document.getElementById('scadenza_carta');
                if (!numero.value || !cvv.value || !titolare.value || !scadenza.value) {
                    e.preventDefault();
                    window.alert('Compila tutti i campi della carta di pagamento.');
                }
            }
        });
    }

    // ── MODAL ESITO ACQUISTO ──
    var esitoSuccesso = document.getElementById('esito-successo');
    if (esitoSuccesso) {
        document.body.style.overflow = 'hidden'; // resto della pagina bloccato: niente scroll, overlay copre tutti i click
    }
    
    var esitoErrore = document.getElementById('esito-errore');
    var closeErrore = document.getElementById('close-esito-errore');
    var btnRiprova = document.getElementById('btn-riprova-errore');

    function chiudiErrore() {
        if (esitoErrore) esitoErrore.remove();
        document.body.style.overflow = '';
    }

    if (closeErrore) closeErrore.addEventListener('click', chiudiErrore);
    if (btnRiprova) btnRiprova.addEventListener('click', chiudiErrore);
    if (esitoErrore) {
        esitoErrore.addEventListener('click', function(e) {
            if (e.target === esitoErrore) chiudiErrore(); // click fuori dal box chiude
        });
    }


})();
{/literal}
</script>
{/block}