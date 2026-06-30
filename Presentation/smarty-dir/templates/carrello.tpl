{extends file="common/layout.tpl"}

{block name="extra_css"}
    <link rel="stylesheet" href="{$base_url}/css/carrello.css">
{/block}

{block name="content"}
<div class="carrello-container">
    <div class="container">

        <h1 class="carrello-titolo">
            <i class="ti ti-shopping-cart"></i> Carrello
        </h1>

        {if isset($carrello_items) && $carrello_items|@count > 0}

            <div class="carrello-layout">

                {* ── COLONNA PRINCIPALE: ARTICOLI + CORRELATI ── *}
                <div class="carrello-main">

                    <div class="carrello-items" id="carrello-items">
                        {foreach $carrello_items as $item}
                            {assign var="p" value=$item.prodotto}

                            <div class="carrello-item"
                                 data-item-id="{$item.id_item}"
                                 data-prezzo-unitario="{$item.prezzo_unitario}"
                                 data-update-url="{$item.update_url|escape}">

                                <a href="{$base_url}/prodotto/{$p.id}" class="carrello-item-img-link">
                                    <img src="{$base_url}/img/prodotti/{$p.immagine|escape}"
                                         onerror="this.onerror=null; this.src='{$base_url}/img/default.png'"
                                         alt="{$p.nome|escape}"
                                         class="carrello-item-img">
                                </a>

                                <div class="carrello-item-info">
                                    <a href="{$base_url}/prodotto/{$p.id}" class="carrello-item-nome">
                                        {$p.nome|escape}
                                    </a>

                                    <div class="carrello-item-prezzo-wrapper">
                                        {if $item.sconto}
                                            <span class="carrello-item-prezzo">€{$item.prezzo_unitario|number_format:2}</span>
                                            <span class="carrello-item-prezzo-old">€{$item.prezzo_originale|number_format:2}</span>
                                        {elseif isset($item.prezzo_unitario)}
                                            <span class="carrello-item-prezzo">€{$item.prezzo_unitario|number_format:2}</span>
                                        {else}
                                            <span class="carrello-item-prezzo-nd">Prezzo N/D</span>
                                        {/if}
                                    </div>
                                </div>

                                <div class="carrello-item-controls">

                                    <div class="carrello-item-qty">
                                        <button class="button quantita-btn carrello-qty-minus" type="button" aria-label="Diminuisci quantità">
                                            <i class="ti ti-minus"></i>
                                        </button>
                                        <input type="number"
                                               class="input quantita-input carrello-qty-input"
                                               value="{$item.quantita}"
                                               min="1"
                                               max="99"
                                               aria-label="Quantità">
                                        <button class="button quantita-btn carrello-qty-plus" type="button" aria-label="Aumenta quantità">
                                            <i class="ti ti-plus"></i>
                                        </button>
                                    </div>

                                    <div class="carrello-item-subtotale">
                                        <span class="carrello-item-subtotale-label">Subtotale</span>
                                        <span class="carrello-item-subtotale-value">€{$item.subtotale|number_format:2}</span>
                                    </div>

                                    <button class="carrello-item-rimuovi"
                                            type="button"
                                            data-url="{$base_url}/carrello/rimuovi/{$item.id_item}"
                                            aria-label="Rimuovi {$p.nome|escape} dal carrello">
                                        <i class="ti ti-trash"></i> Rimuovi
                                    </button>

                                </div>

                            </div>
                        {/foreach}
                    </div>

                    {* ── SEZIONE: POTREBBE INTERESSARTI ── *}
                    {if isset($correlati) && $correlati|@count > 0}
                        <section class="carrello-correlati">
                            <h2 class="carrello-section-title">Potrebbe interessarti</h2>

                            <div class="correlati-wrapper">
                                <div class="correlati-grid" id="correlati-grid">
                                    {foreach $correlati as $correlato}
                                        <div class="correlato-card">
                                            <a href="{$base_url}/prodotto/{$correlato.id}" class="correlato-card-link">
                                                <div class="correlato-image-wrapper">
                                                    <img src="{$base_url}/img/prodotti/{$correlato.immagine|escape}"
                                                         onerror="this.onerror=null; this.src='{$base_url}/img/default.png'"
                                                         alt="{$correlato.nome|escape}"
                                                         class="correlato-image">
                                                </div>
                                                <div class="correlato-info">
                                                    <h3 class="correlato-nome">{$correlato.nome|escape}</h3>
                                                    <div class="correlato-rating">
                                                        {assign var="cMedia" value=$correlato.valutazione_media}
                                                        {foreach [1,2,3,4,5] as $s}
                                                            {if $s <= $cMedia}
                                                                <i class="ti ti-star-filled"></i>
                                                            {elseif ($s - $cMedia) < 1}
                                                                <i class="ti ti-star-half-filled"></i>
                                                            {else}
                                                                <i class="ti ti-star"></i>
                                                            {/if}
                                                        {/foreach}
                                                    </div>
                                                    <div class="correlato-prezzo">
                                                        {if $correlato.sconto}
                                                            <span class="correlato-prezzo-scontato">€{$correlato.prezzo_scontato|number_format:2}</span>
                                                            <span class="correlato-prezzo-old">€{$correlato.prezzo|number_format:2}</span>
                                                        {elseif isset($correlato.prezzo)}
                                                            <span>€{$correlato.prezzo|number_format:2}</span>
                                                        {else}
                                                            <span class="prezzo-nd">N/D</span>
                                                        {/if}
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="{$base_url}/carrello/aggiungi/{$correlato.id}"
                                               class="button btn-correlato-cart"
                                               aria-label="Aggiungi {$correlato.nome|escape} al carrello">
                                                <i class="ti ti-shopping-cart"></i> Carrello
                                            </a>
                                        </div>
                                    {/foreach}
                                </div>

                                <button class="correlati-nav correlati-next" id="correlati-next" type="button" aria-label="Vedi altri prodotti correlati">
                                    <i class="ti ti-chevron-right"></i>
                                </button>
                            </div>
                        </section>
                    {/if}

                </div>

                {* ── COLONNA DESTRA: RIEPILOGO ORDINE ── *}
                <aside class="carrello-summary"
                       id="carrello-summary"
                       data-sconto="{$carrello_summary.sconto}"
                       data-spedizione="{$carrello_summary.spedizione|default:''}">

                    <h2 class="carrello-summary-title">Totale Carrello</h2>

                    <dl class="carrello-summary-list">
                        <div class="carrello-summary-row">
                            <dt>N° articoli</dt>
                            <dd id="summary-n-articoli" aria-live="polite">{$carrello_summary.n_articoli}</dd>
                        </div>

                        {if $carrello_summary.sconto > 0}
                            <div class="carrello-summary-row carrello-summary-sconto">
                                <dt>Sconto</dt>
                                <dd>-€{$carrello_summary.sconto|number_format:2}</dd>
                            </div>
                        {/if}

                        <div class="carrello-summary-row">
                            <dt>Spedizione</dt>
                            <dd>
                                {if $carrello_summary.spedizione === null}
                                    Da calcolare
                                {elseif $carrello_summary.spedizione == 0}
                                    Gratuita
                                {else}
                                    €{$carrello_summary.spedizione|number_format:2}
                                {/if}
                            </dd>
                        </div>
                    </dl>

                    <div class="carrello-summary-totale">
                        <span class="carrello-summary-totale-label">Totale</span>
                        <span class="carrello-summary-totale-value" id="summary-totale" aria-live="polite">
                            €{$carrello_summary.totale|number_format:2}
                        </span>
                    </div>

                    <a href="{$base_url}/checkout" class="button btn-completa-ordine">
                        <i class="ti ti-shopping-cart"></i> Completa Ordine
                    </a>

                </aside>

            </div>

        {else}

            {* ── CARRELLO VUOTO ── *}
            <div class="carrello-vuoto">
                <i class="ti ti-shopping-cart-off"></i>
                <p>Il tuo carrello è vuoto.</p>
                <a href="{$base_url}/catalogo" class="btn-primary">Vai al Catalogo</a>
            </div>

        {/if}

    </div>
</div>
{/block}

{block name="extra_js"}
<script>
{literal}
(function() {

    // ── TOAST NOTIFICHE ──
    function mostraToast(messaggio, tipo) {
        var toast = document.createElement('div');
        toast.textContent = messaggio;
        toast.style.cssText = [
            'position:fixed', 'bottom:1.5rem', 'right:1.5rem',
            'padding:.75rem 1.25rem', 'border-radius:6px',
            'color:#fff', 'font-size:.9rem', 'z-index:9999',
            'box-shadow:0 2px 8px rgba(0,0,0,.25)',
            'background:' + (tipo === 'errore' ? '#c0392b' : '#27ae60')
        ].join(';');
        document.body.appendChild(toast);
        setTimeout(function() { toast.remove(); }, 4000);
    }

    const summary = document.getElementById('carrello-summary');
    const sconto = summary ? (parseFloat(summary.dataset.sconto) || 0) : 0;
    const spedizioneRaw = summary ? summary.dataset.spedizione : '';
    const spedizione = spedizioneRaw !== '' ? (parseFloat(spedizioneRaw) || 0) : 0;

    // ── RICALCOLO RIEPILOGO ──
    function ricalcolaRiepilogo() {
        var righe = document.querySelectorAll('.carrello-item');
        var nArticoli = 0;
        var subtotale = 0;

        righe.forEach(function(riga) {
            var input = riga.querySelector('.carrello-qty-input');
            var qty = parseInt(input ? input.value : 1) || 1;
            var unit = parseFloat(riga.dataset.prezzoUnitario) || 0;
            nArticoli += qty;
            subtotale += qty * unit;
        });

        var totale = Math.max(subtotale - sconto + spedizione, 0);

        var nArticoliEl = document.getElementById('summary-n-articoli');
        var totaleEl    = document.getElementById('summary-totale');
        if (nArticoliEl) nArticoliEl.textContent = nArticoli;
        if (totaleEl)    totaleEl.textContent = '€' + totale.toFixed(2);
    }

    // ── STEPPER QUANTITÀ PER OGNI ARTICOLO ──
    document.querySelectorAll('.carrello-item').forEach(function(riga) {
        var input       = riga.querySelector('.carrello-qty-input');
        var btnMinus    = riga.querySelector('.carrello-qty-minus');
        var btnPlus     = riga.querySelector('.carrello-qty-plus');
        var subtotaleEl = riga.querySelector('.carrello-item-subtotale-value');
        var unit        = parseFloat(riga.dataset.prezzoUnitario) || 0;
        var updateUrl   = riga.dataset.updateUrl;

        // Inizializza dataset per tracking valore precedente
        if (input) input.dataset.valPrecedente = input.value;

        function aggiornaRigaUI() {
            var qty = parseInt(input.value) || 1;
            if (subtotaleEl) subtotaleEl.textContent = '€' + (unit * qty).toFixed(2);
            ricalcolaRiepilogo();
        }

        function inviaAggiornamento(valPrecedente) {
            if (!updateUrl) return;
            var qty = parseInt(input.value) || 1;
            var controller = new AbortController();
            var timeout = setTimeout(function() { controller.abort(); }, 5000);

            fetch(updateUrl + '?qty=' + qty, { signal: controller.signal })
                .then(function(response) {
                    clearTimeout(timeout);
                    if (!response.ok) throw new Error('server');
                })
                .catch(function(err) {
                    clearTimeout(timeout);
                    input.value = valPrecedente;
                    input.dataset.valPrecedente = valPrecedente;
                    aggiornaRigaUI();
                    var msg = err.name === 'AbortError'
                        ? 'Connessione lenta, quantità non salvata.'
                        : 'Errore nel salvataggio della quantità.';
                    mostraToast(msg, 'errore');
                });
        }

        if (btnMinus) {
            btnMinus.addEventListener('click', function(e) {
                e.preventDefault();
                var val = parseInt(input.value) || 1;
                if (val > 1) {
                    input.value = val - 1;
                    input.dataset.valPrecedente = val;
                    aggiornaRigaUI();
                    inviaAggiornamento(val);
                }
            });
        }

        if (btnPlus) {
            btnPlus.addEventListener('click', function(e) {
                e.preventDefault();
                var val = parseInt(input.value) || 1;
                input.value = val + 1;
                input.dataset.valPrecedente = val;
                aggiornaRigaUI();
                inviaAggiornamento(val);
            });
        }

        if (input) {
            input.addEventListener('input', function() {
                var valPrecedente = parseInt(input.dataset.valPrecedente) || 1;
                var val = parseInt(input.value);
                if (isNaN(val) || val < 1) input.value = 1;
                aggiornaRigaUI();
                inviaAggiornamento(valPrecedente);
                input.dataset.valPrecedente = input.value;
            });
        }
    });

    // ── RIMOZIONE ARTICOLO ──
    document.querySelectorAll('.carrello-item-rimuovi').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var riga      = this.closest('.carrello-item');
            var url       = this.dataset.url;
            var parent    = riga.parentNode;
            var nextSibling = riga.nextSibling;

            riga.remove();

            var righeRimaste = document.querySelectorAll('.carrello-item');
            if (righeRimaste.length > 0) {
                ricalcolaRiepilogo();
            }

            if (!url) return;

            var controller = new AbortController();
            var timeout = setTimeout(function() { controller.abort(); }, 5000);

            fetch(url, { signal: controller.signal })
                .then(function(response) {
                    clearTimeout(timeout);
                    if (!response.ok) throw new Error('server');
                    if (document.querySelectorAll('.carrello-item').length === 0) {
                        window.location.reload();
                    }
                })
                .catch(function(err) {
                    clearTimeout(timeout);
                    if (nextSibling) {
                        parent.insertBefore(riga, nextSibling);
                    } else {
                        parent.appendChild(riga);
                    }
                    ricalcolaRiepilogo();
                    var msg = err.name === 'AbortError'
                        ? 'Connessione lenta, articolo non rimosso.'
                        : 'Errore nella rimozione dell\'articolo.';
                    mostraToast(msg, 'errore');
                });
        });
    });

    // ── CAROSELLO "POTREBBE INTERESSARTI" ──
    var correlatiNext = document.getElementById('correlati-next');
    var correlatiGrid = document.getElementById('correlati-grid');

    if (correlatiNext && correlatiGrid) {
        correlatiNext.addEventListener('click', function() {
            var card = correlatiGrid.querySelector('.correlato-card');
            var scrollAmount = card ? card.offsetWidth + 20 : 280;
            var fineRaggiunta = correlatiGrid.scrollLeft + correlatiGrid.clientWidth >= correlatiGrid.scrollWidth - 5;

            if (fineRaggiunta) {
                correlatiGrid.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                correlatiGrid.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            }
        });
    }

})();
{/literal}
</script>
{/block}
