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
                                 data-item-id="{$p.id}"
                                 data-prezzo-unitario="{$p.prezzo_unitario}"
                                 data-risparmio-unitario="{if $p.sconto}{$p.prezzo_originale-$p.prezzo_unitario}{else}0{/if}"
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
                                        {if $p.sconto}
                                            <span class="carrello-item-prezzo">€{$p.prezzo_unitario|number_format:2}</span>
                                            <span class="carrello-item-prezzo-old">€{$p.prezzo_originale|number_format:2}</span>
                                        {elseif isset($p.prezzo_unitario)}
                                            <span class="carrello-item-prezzo">€{$p.prezzo_unitario|number_format:2}</span>
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
                                            data-url="{$base_url}/carrello/rimuovi/{$p.id}"
                                            aria-label="Rimuovi {$p.nome|escape} dal carrello">
                                        <i class="ti ti-trash"></i> Rimuovi
                                    </button>

                                </div>

                            </div>
                        {/foreach}
                    </div>

                    {* ── TEMPLATE NASCOSTO: usato da JS per generare nuove righe senza reload ── *}
                    <template id="tpl-carrello-item">
                        <div class="carrello-item"
                             data-item-id=""
                             data-prezzo-unitario=""
                             data-risparmio-unitario="0"
                             data-update-url="">

                            <a href="" class="carrello-item-img-link">
                                <img src=""
                                     onerror="this.onerror=null; this.src='{$base_url}/img/default.png'"
                                     alt=""
                                     class="carrello-item-img">
                            </a>

                            <div class="carrello-item-info">
                                <a href="" class="carrello-item-nome"></a>

                                <div class="carrello-item-prezzo-wrapper">
                                    <span class="carrello-item-prezzo"></span>
                                    <span class="carrello-item-prezzo-old" style="display:none;"></span>
                                    <span class="carrello-item-prezzo-nd" style="display:none;">Prezzo N/D</span>
                                </div>
                            </div>

                            <div class="carrello-item-controls">

                                <div class="carrello-item-qty">
                                    <button class="button quantita-btn carrello-qty-minus" type="button" aria-label="Diminuisci quantità">
                                        <i class="ti ti-minus"></i>
                                    </button>
                                    <input type="number"
                                           class="input quantita-input carrello-qty-input"
                                           value="1"
                                           min="1"
                                           max="99"
                                           aria-label="Quantità">
                                    <button class="button quantita-btn carrello-qty-plus" type="button" aria-label="Aumenta quantità">
                                        <i class="ti ti-plus"></i>
                                    </button>
                                </div>

                                <div class="carrello-item-subtotale">
                                    <span class="carrello-item-subtotale-label">Subtotale</span>
                                    <span class="carrello-item-subtotale-value"></span>
                                </div>

                                <button class="carrello-item-rimuovi"
                                        type="button"
                                        data-url=""
                                        aria-label="Rimuovi dal carrello">
                                    <i class="ti ti-trash"></i> Rimuovi
                                </button>

                            </div>

                        </div>
                    </template>

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
                                            <button class="button btn-correlato-cart"
                                                    type="button"
                                                    data-url="{$base_url}/carrello/aggiungi/{$correlato.id}"
                                                    aria-label="Aggiungi {$correlato.nome|escape} al carrello">
                                                <i class="ti ti-shopping-cart"></i> Carrello
                                            </button>
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
                <aside class="carrello-summary" id="carrello-summary">

                    <h2 class="carrello-summary-title">Totale Carrello</h2>

                    <dl class="carrello-summary-list">
                        <div class="carrello-summary-row">
                            <dt>N° articoli</dt>
                            <dd id="summary-n-articoli" aria-live="polite">{$carrello_summary.n_articoli}</dd>
                        </div>

                        <div class="carrello-summary-row carrello-summary-risparmio"
                             id="summary-risparmio-row"
                             {if !($carrello_summary.sconto > 0)}style="display:none;"{/if}>
                            <dt>Risparmio</dt>
                            <dd id="summary-risparmio">-€{$carrello_summary.sconto|number_format:2}</dd>
                        </div>

                        

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
    

    // ── RICALCOLO RIEPILOGO ──
    function ricalcolaRiepilogo() {
        var righe = document.querySelectorAll('.carrello-item');
        var nArticoli = 0;
        var subtotale = 0;
        var risparmioTotale = 0;

        righe.forEach(function(riga) {
            var input = riga.querySelector('.carrello-qty-input');
            var qty = parseInt(input ? input.value : 1) || 1;
            var unit = parseFloat(riga.dataset.prezzoUnitario) || 0;
            var risparmioUnit = parseFloat(riga.dataset.risparmioUnitario) || 0;
            nArticoli += qty;
            subtotale += qty * unit;
            risparmioTotale += qty * risparmioUnit;
        });

        // subtotale usa già il prezzo scontato per riga, quindi il totale
        // non deve sottrarre di nuovo il risparmio (altrimenti sconto doppio)
        var totale = Math.max(subtotale, 0);

        var nArticoliEl  = document.getElementById('summary-n-articoli');
        var totaleEl     = document.getElementById('summary-totale');
        var risparmioEl  = document.getElementById('summary-risparmio');
        var risparmioRow = document.getElementById('summary-risparmio-row');

        if (nArticoliEl)  nArticoliEl.textContent = nArticoli;
        if (totaleEl)     totaleEl.textContent = '€' + totale.toFixed(2);
        if (risparmioEl)  risparmioEl.textContent = '-€' + risparmioTotale.toFixed(2);
        if (risparmioRow) risparmioRow.style.display = risparmioTotale > 0 ? '' : 'none';
    }

    // ── BINDING RIGA CARRELLO (stepper qty + rimozione) ──
    // Estratto in funzione riutilizzabile: viene chiamato sia sulle righe
    // renderizzate da Smarty al caricamento, sia sulle righe create
    // dinamicamente via JS quando si aggiunge un correlato al carrello.
    function bindRigaCarrello(riga) {
        var input       = riga.querySelector('.carrello-qty-input');
        var btnMinus    = riga.querySelector('.carrello-qty-minus');
        var btnPlus     = riga.querySelector('.carrello-qty-plus');
        var subtotaleEl = riga.querySelector('.carrello-item-subtotale-value');
        var unit        = parseFloat(riga.dataset.prezzoUnitario) || 0;
        var updateUrl   = riga.dataset.updateUrl;

        
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

        var btnRimuovi = riga.querySelector('.carrello-item-rimuovi');
        if (btnRimuovi) {
            btnRimuovi.addEventListener('click', function() {
                var url         = this.dataset.url;
                var parent      = riga.parentNode;
                var nextSibling = riga.nextSibling;

                riga.remove();

                var righeRimaste = document.querySelectorAll('.carrello-item');
                if (righeRimaste.length > 0) {
                    ricalcolaRiepilogo();
                }

                if (!url) return;

                var controller = new AbortController();
                var timeout = setTimeout(function() { controller.abort(); }, 5000);

                fetch(url, {
                    method: 'POST',
                    signal: controller.signal
                })
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
        }
    }

    // Bind iniziale su tutte le righe già presenti nel DOM al caricamento
    document.querySelectorAll('.carrello-item').forEach(bindRigaCarrello);

    // ── CREAZIONE RIGA CARRELLO DA JSON (usata quando si aggiunge un correlato) ──
    function aggiungiRigaCarrello(data) {
        var tpl = document.getElementById('tpl-carrello-item');
        var contenitore = document.getElementById('carrello-items');
        if (!tpl || !contenitore) return;

        var nodo = tpl.content.cloneNode(true);
        var riga = nodo.querySelector('.carrello-item');

        riga.dataset.itemId = data.id;
        riga.dataset.prezzoUnitario = data.prezzo_unitario;
        riga.dataset.risparmioUnitario = data.sconto
            ? (data.prezzo_originale - data.prezzo_unitario)
            : 0;
        riga.dataset.updateUrl = data.update_url;

        var linkImg = riga.querySelector('.carrello-item-img-link');
        if (linkImg) linkImg.href = data.product_url;

        var img = riga.querySelector('.carrello-item-img');
        if (img) {
            img.src = data.immagine_url;
            img.alt = data.nome;
        }

        var nomeLink = riga.querySelector('.carrello-item-nome');
        if (nomeLink) {
            nomeLink.href = data.product_url;
            nomeLink.textContent = data.nome;
        }

        var prezzoEl    = riga.querySelector('.carrello-item-prezzo');
        var prezzoOldEl = riga.querySelector('.carrello-item-prezzo-old');
        var prezzoNdEl  = riga.querySelector('.carrello-item-prezzo-nd');

        if (data.sconto) {
            prezzoEl.textContent = '€' + Number(data.prezzo_unitario).toFixed(2);
            prezzoEl.style.display = '';
            prezzoOldEl.textContent = '€' + Number(data.prezzo_originale).toFixed(2);
            prezzoOldEl.style.display = '';
            prezzoNdEl.style.display = 'none';
        } else if (data.prezzo_unitario !== null && data.prezzo_unitario !== undefined) {
            prezzoEl.textContent = '€' + Number(data.prezzo_unitario).toFixed(2);
            prezzoEl.style.display = '';
            prezzoOldEl.style.display = 'none';
            prezzoNdEl.style.display = 'none';
        } else {
            prezzoEl.style.display = 'none';
            prezzoOldEl.style.display = 'none';
            prezzoNdEl.style.display = '';
        }

        var qtyInput = riga.querySelector('.carrello-qty-input');
        if (qtyInput) qtyInput.value = data.quantita || 1;

        var subtotaleEl = riga.querySelector('.carrello-item-subtotale-value');
        if (subtotaleEl) {
            var subtotaleCalcolato = (data.subtotale !== null && data.subtotale !== undefined)
                ? Number(data.subtotale)
                : Number(data.prezzo_unitario) * (data.quantita || 1);
            subtotaleEl.textContent = '€' + subtotaleCalcolato.toFixed(2);
        }

        var btnRimuovi = riga.querySelector('.carrello-item-rimuovi');
        if (btnRimuovi) {
            btnRimuovi.dataset.url = data.remove_url;
            btnRimuovi.setAttribute('aria-label', 'Rimuovi ' + data.nome + ' dal carrello');
        }

        contenitore.appendChild(riga);

        // Ribinda subito la nuova riga (stepper + rimozione)
        var nuovaRigaDom = contenitore.lastElementChild;
        bindRigaCarrello(nuovaRigaDom);
    }

    // ── AGGIUNGE UNA NUOVA RIGA O AGGIORNA LA QUANTITÀ SE IL PRODOTTO C'È GIÀ ──
    function aggiungiOAggiornaRigaCarrello(data) {
        var rigaEsistente = document.querySelector('.carrello-item[data-item-id="' + data.id + '"]');

        if (rigaEsistente) {
            var input = rigaEsistente.querySelector('.carrello-qty-input');
            if (input) {
                input.value = data.quantita;
                input.dataset.valPrecedente = data.quantita;
            }
            var subtotaleEl = rigaEsistente.querySelector('.carrello-item-subtotale-value');
            var unit = parseFloat(rigaEsistente.dataset.prezzoUnitario) || 0;
            if (subtotaleEl) {
                subtotaleEl.textContent = '€' + (unit * data.quantita).toFixed(2);
            }
        } else {
            aggiungiRigaCarrello(data);
        }

        ricalcolaRiepilogo();
    }

    // ── AGGIUNTA ARTICOLO (da correlati) ──
    document.querySelectorAll('.btn-correlato-cart').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var url = this.dataset.url;
            if (!url) return;

            var controller = new AbortController();
            var timeout = setTimeout(function() { controller.abort(); }, 5000);

            fetch(url, {
                method: 'POST',
                signal: controller.signal
            })
                .then(function(response) {
                    clearTimeout(timeout);
                    if (!response.ok) throw new Error('server');
                    return response.json();
                })
                .then(function(data) {
                    mostraToast('Prodotto aggiunto al carrello', 'successo');

                    // Se il carrello era vuoto in partenza, #carrello-items
                    // non esiste ancora nel DOM: in quel caso ricarichiamo
                    // la pagina per far comparire tutto il layout corretto
                    // (colonna riepilogo, sezione correlati ecc.)
                    if (!document.getElementById('carrello-items')) {
                        window.location.reload();
                        return;
                    }

                    aggiungiOAggiornaRigaCarrello(data);
                })
                .catch(function(err) {
                    clearTimeout(timeout);
                    var msg = err.name === 'AbortError'
                        ? 'Connessione lenta, prodotto non aggiunto.'
                        : 'Errore nell\'aggiunta del prodotto.';
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
