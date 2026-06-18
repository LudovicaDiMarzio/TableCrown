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

        {if isset($carrello) && $carrello->getItems()|@count > 0}

            <div class="carrello-layout">

                {* ── COLONNA PRINCIPALE: ARTICOLI + CORRELATI ── *}
                <div class="carrello-main">

                    <div class="carrello-items" id="carrello-items">
                        {foreach $carrello->getItems() as $item}
                            {assign var="p" value=$item->getProdotto()}
                            {assign var="qty" value=$item->getQuantita()}
                            {assign var="prezzo" value=$p->getPrezzo()}

                            <div class="carrello-item"
                                 data-item-id="{$item->getIdItem()}"
                                 data-prezzo-unitario="{if isset($prezzo)}{if $prezzo->hasSconto()}{$prezzo->calcolaPrezzoScontato()}{else}{$prezzo->getValore()}{/if}{else}0{/if}"
                                 data-update-url="{$base_url}/carrello/aggiorna/{$item->getIdItem()}">

                                <a href="{$base_url}/prodotto/{$p->getIdProdotto()}" class="carrello-item-img-link">
                                    <img src="{$base_url}/public/img/prodotti/{$p->getImgProdotto()|escape}"
                                         onerror="this.onerror=null; this.src='{$base_url}/public/img/default.png'"
                                        alt="{$p->getNomeProdotto()|escape}"
                                         class="carrello-item-img">
                                </a>

                                <div class="carrello-item-info">
                                    <a href="{$base_url}/prodotto/{$p->getIdProdotto()}" class="carrello-item-nome">
                                        {$p->getNomeProdotto()|escape}
                                    </a>

                                    <div class="carrello-item-prezzo-wrapper">
                                        {if isset($prezzo)}
                                            {if $prezzo->hasSconto()}
                                                <span class="carrello-item-prezzo">€{$prezzo->calcolaPrezzoScontato()|number_format:2}</span>
                                                <span class="carrello-item-prezzo-old">€{$prezzo->getValore()|number_format:2}</span>
                                            {else}
                                                <span class="carrello-item-prezzo">€{$prezzo->getValore()|number_format:2}</span>
                                            {/if}
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
                                               value="{$qty}"
                                               min="1"
                                               max="99"
                                               aria-label="Quantità">
                                        <button class="button quantita-btn carrello-qty-plus" type="button" aria-label="Aumenta quantità">
                                            <i class="ti ti-plus"></i>
                                        </button>
                                    </div>

                                    <div class="carrello-item-subtotale">
                                        <span class="carrello-item-subtotale-label">Subtotale</span>
                                        <span class="carrello-item-subtotale-value">€{$item->getSubtotale()|number_format:2}</span>
                                    </div>

                                    <button class="carrello-item-rimuovi"
                                            type="button"
                                            data-url="{$base_url}/carrello/rimuovi/{$item->getIdItem()}"
                                            aria-label="Rimuovi {$p->getNomeProdotto()|escape} dal carrello">
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
                                            <a href="{$base_url}/prodotto/{$correlato->getIdProdotto()}" class="correlato-card-link">
                                                <div class="correlato-image-wrapper">
                                                    <img src="{$base_url}/public/img/prodotti/{$correlato->getImgProdotto()|escape}"
                                                        onerror="this.onerror=null; this.src='{$base_url}/public/img/default.png'"
                                                        alt="{$correlato->getNomeProdotto()|escape}"
                                                        class="correlato-image">
                                                </div>
                                                <div class="correlato-info">
                                                    <h3 class="correlato-nome">{$correlato->getNomeProdotto()|escape}</h3>
                                                    <div class="correlato-rating">
                                                        {assign var="cMedia" value=$correlato->getValutazioneMedia()}
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
                                                        {assign var="cPrezzo" value=$correlato->getPrezzo()}
                                                        {if isset($cPrezzo)}
                                                            {if $cPrezzo->hasSconto()}
                                                                <span class="correlato-prezzo-scontato">€{$cPrezzo->calcolaPrezzoScontato()|number_format:2}</span>
                                                                <span class="correlato-prezzo-old">€{$cPrezzo->getValore()|number_format:2}</span>
                                                            {else}
                                                                <span>€{$cPrezzo->getValore()|number_format:2}</span>
                                                            {/if}
                                                        {else}
                                                            <span class="prezzo-nd">N/D</span>
                                                        {/if}
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="{$base_url}/carrello/aggiungi/{$correlato->getIdProdotto()}"
                                               class="button btn-correlato-cart"
                                               aria-label="Aggiungi {$correlato->getNomeProdotto()|escape} al carrello">
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
                       data-sconto="{$carrello->getSconto()}"
                       data-spedizione="{if $carrello->getSpedizione() !== null}{$carrello->getSpedizione()}{/if}">

                    <h2 class="carrello-summary-title">Totale Carrello</h2>

                    <dl class="carrello-summary-list">
                        <div class="carrello-summary-row">
                            <dt>N° articoli</dt>
                            <dd id="summary-n-articoli" aria-live="polite">{$carrello->getTotaleArticoli()}</dd>
                        </div>

                        {if $carrello->getSconto() > 0}
                            <div class="carrello-summary-row carrello-summary-sconto">
                                <dt>Sconto</dt>
                                <dd>-€{$carrello->getSconto()|number_format:2}</dd>
                            </div>
                        {/if}

                        <div class="carrello-summary-row">
                            <dt>Spedizione</dt>
                            <dd>
                                {if $carrello->getSpedizione() === null}
                                    Da calcolare
                                {elseif $carrello->getSpedizione() == 0}
                                    Gratuita
                                {else}
                                    €{$carrello->getSpedizione()|number_format:2}
                                {/if}
                            </dd>
                        </div>
                    </dl>

                    <div class="carrello-summary-totale">
                        <span class="carrello-summary-totale-label">Totale</span>
                        <span class="carrello-summary-totale-value" id="summary-totale" aria-live="polite">
                            €{$carrello->getTotale()|number_format:2}
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
function initCarrelloPage() {

    const summary = document.getElementById('carrello-summary');
    const sconto = summary ? (parseFloat(summary.dataset.sconto) || 0) : 0;
    const spedizioneRaw = summary ? summary.dataset.spedizione : '';
    const spedizione = spedizioneRaw ? (parseFloat(spedizioneRaw) || 0) : 0;

    // ── RICALCOLO RIEPILOGO (lato client, per feedback immediato) ──
    function ricalcolaRiepilogo() {
        const righe = document.querySelectorAll('.carrello-item');
        let nArticoli = 0;
        let subtotale = 0;

        righe.forEach(riga => {
            const input = riga.querySelector('.carrello-qty-input');
            const qty = parseInt(input?.value) || 1;
            const unit = parseFloat(riga.dataset.prezzoUnitario) || 0;
            nArticoli += qty;
            subtotale += qty * unit;
        });

        const totale = Math.max(subtotale - sconto + spedizione, 0);

        const nArticoliEl = document.getElementById('summary-n-articoli');
        const totaleEl = document.getElementById('summary-totale');
        if (nArticoliEl) nArticoliEl.textContent = nArticoli;
        if (totaleEl) totaleEl.textContent = '€' + totale.toFixed(2);
    }

    // ── STEPPER QUANTITÀ PER OGNI ARTICOLO ──
    document.querySelectorAll('.carrello-item').forEach(riga => {
        const input       = riga.querySelector('.carrello-qty-input');
        const btnMinus    = riga.querySelector('.carrello-qty-minus');
        const btnPlus     = riga.querySelector('.carrello-qty-plus');
        const subtotaleEl = riga.querySelector('.carrello-item-subtotale-value');
        const unit        = parseFloat(riga.dataset.prezzoUnitario) || 0;
        const updateUrl   = riga.dataset.updateUrl;

        function aggiornaRigaUI() {
            const qty = parseInt(input.value) || 1;
            if (subtotaleEl) subtotaleEl.textContent = '€' + (unit * qty).toFixed(2);
            ricalcolaRiepilogo();
        }

        function inviaAggiornamento() {
            if (!updateUrl) return;
            const qty = parseInt(input.value) || 1;
            const controller = new AbortController();
            const timeout = setTimeout(() => controller.abort(), 5000);
            fetch(updateUrl + '?qty=' + qty, { signal: controller.signal })
                .then(() => clearTimeout(timeout))
                .catch(() => clearTimeout(timeout));
        }

        if (btnMinus) {
            btnMinus.addEventListener('click', function (e) {
                e.preventDefault();
                const val = parseInt(input.value) || 1;
                if (val > 1) {
                    input.value = val - 1;
                    aggiornaRigaUI();
                    inviaAggiornamento();
                }
            });
        }

        if (btnPlus) {
            btnPlus.addEventListener('click', function (e) {
                e.preventDefault();
                const val = parseInt(input.value) || 1;
                input.value = val + 1;
                aggiornaRigaUI();
                inviaAggiornamento();
            });
        }

        if (input) {
            input.addEventListener('input', function () {
                const val = parseInt(input.value);
                if (isNaN(val) || val < 1) {
                    input.value = 1;
                }
                aggiornaRigaUI();
                inviaAggiornamento();
            });
        }
    });

    // ── RIMOZIONE ARTICOLO ──
    document.querySelectorAll('.carrello-item-rimuovi').forEach(btn => {
        btn.addEventListener('click', function () {
            const riga = this.closest('.carrello-item');
            const url = this.dataset.url;

            if (url) {
                const controller = new AbortController();
                const timeout = setTimeout(() => controller.abort(), 5000);
                fetch(url, { signal: controller.signal })
                    .then(() => clearTimeout(timeout))
                    .catch(() => clearTimeout(timeout));
            }

            if (riga) {
                riga.remove();
            }

            const righeRimaste = document.querySelectorAll('.carrello-item');
            if (righeRimaste.length === 0) {
                window.location.reload();
            } else {
                ricalcolaRiepilogo();
            }
        });
    });

    // ── CAROSELLO "POTREBBE INTERESSARTI" ──
    const correlatiNext = document.getElementById('correlati-next');
    const correlatiGrid = document.getElementById('correlati-grid');

    if (correlatiNext && correlatiGrid) {
        correlatiNext.addEventListener('click', function () {
            const card = correlatiGrid.querySelector('.correlato-card');
            const scrollAmount = card ? card.offsetWidth + 20 : 280;

            const fineRaggiunta = correlatiGrid.scrollLeft + correlatiGrid.clientWidth >= correlatiGrid.scrollWidth - 5;

            if (fineRaggiunta) {
                correlatiGrid.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                correlatiGrid.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            }
        });
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCarrelloPage);
} else {
    initCarrelloPage();
}
</script>
{/block}
