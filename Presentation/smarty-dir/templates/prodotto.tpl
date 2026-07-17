{extends file="common/layout.tpl"}

{block name="extra_css"}
    <link rel="stylesheet" href="{$base_url}/css/prodotto.css">
{/block}

{block name="content"}

<div class="prodotto-container">
    <div class="container">

    

        {* ── SEZIONE PRINCIPALE: GALLERY + INFO + ACQUISTO ── *}
        <div class="prodotto-top">

            {* ── COLONNA SINISTRA: GALLERIA IMMAGINI ── *}
            <div class="prodotto-gallery">
                <div class="gallery-main-wrapper">
                    <div class="gallery-main" id="gallery-main">
                        <img src="{$base_url}/img/prodotti/{$immagine|escape}"
                             alt="{$nome|escape}"
                             class="gallery-main-img is-active"
                             data-index="0">
                    </div>
                </div>
            </div>

            {* ── COLONNA CENTRO: INFO PRODOTTO ── *}
            <div class="prodotto-info">

                {* Badge disponibilità *}
                {if $disponibilita == 'esaurito'}
                    <span class="prodotto-badge prodotto-badge-esaurito">Esaurito</span>
                {elseif $disponibilita == 'annunciato'}
                    <span class="prodotto-badge prodotto-badge-annunciato">Annunciato</span>
                {elseif $disponibilita == 'non disponibile'}
                    <span class="prodotto-badge prodotto-badge-non-disponibile">Non disponibile</span>
                {elseif $disponibilita == 'in arrivo'}
                    <span class="prodotto-badge prodotto-badge-in-arrivo">In arrivo</span>
                {else}
                    <span class="prodotto-badge prodotto-badge-disponibile">Disponibile</span>
                {/if}

                <h1 class="prodotto-nome">{$nome|escape}</h1>

                {* Rating *}
                <div class="prodotto-rating">
                    {foreach [1,2,3,4,5] as $s}
                        {if $s <= $valutazione_media}
                            <i class="ti ti-star-filled"></i>
                        {elseif ($s - $valutazione_media) < 1}
                            <i class="ti ti-star-half-filled"></i>
                        {else}
                            <i class="ti ti-star"></i>
                        {/if}
                    {/foreach}
                    <span class="prodotto-rating-value">({$valutazione_media|number_format:1})</span>
                    <a href="#recensioni" class="prodotto-rating-link">Leggi Recensioni</a>
                </div>

                {* Meta info prodotto *}
                <div class="prodotto-meta">
                    {if isset($numeroGiocatoriMin) && isset($numeroGiocatoriMax)}
                        <span class="prodotto-meta-item">
                            <i class="ti ti-users"></i>
                            {$numeroGiocatoriMin}–{$numeroGiocatoriMax} giocatori
                        </span>
                    {/if}
                    {if isset($etaMinima)}
                        <span class="prodotto-meta-item">
                            <i class="ti ti-baby-carriage"></i>
                            {$etaMinima}+ anni
                        </span>
                    {/if}
                    {if isset($durataMedia)}
                        <span class="prodotto-meta-item">
                            <i class="ti ti-clock"></i>
                            {$durataMedia} min
                        </span>
                    {/if}
                    {if isset($difficolta)}
                        <span class="prodotto-meta-item">
                            <i class="ti ti-flame"></i>
                            {$difficolta|escape}
                        </span>
                    {/if}
                    {if isset($lingua)}
                        <span class="prodotto-meta-item">
                            <i class="ti ti-language"></i>
                            {$lingua|escape}
                        </span>
                    {/if}
                </div>

                {* Prezzo *}
                <div class="prodotto-prezzo-wrapper">
                    {if $sconto}
                        <span class="prodotto-prezzo">€{$prezzo_scontato|number_format:2}</span>
                        <span class="prodotto-prezzo-old">€{$prezzo|number_format:2}</span>
                        <span class="prodotto-sconto-badge">-{$percentuale_sconto|string_format:"%.0f"}%</span>
                    {elseif isset($prezzo)}
                        <span class="prodotto-prezzo">€{$prezzo|number_format:2}</span>
                    {else}
                        <span class="prodotto-prezzo-nd">Prezzo N/D</span>
                    {/if}
                </div>

            </div>

            {* ── COLONNA DESTRA: BOX ACQUISTO ── *}
            <div class="prodotto-acquisto-box">

                {* Disponibilità visiva *}
                <div class="acquisto-disponibilita">
                    {if $disponibilita == 'disponibile'}
                        <i class="ti ti-circle-check"></i>
                        <span>Disponibile</span>
                    {elseif $disponibilita == 'esaurito'}
                        <i class="ti ti-circle-x"></i>
                        <span>Esaurito</span>
                    {elseif $disponibilita == 'non disponibile'}
                        <i class="ti ti-circle-x"></i>
                        <span>Non disponibile</span>
                    {elseif $disponibilita == 'in arrivo'}
                        <i class="ti ti-clock"></i>
                        <span>In arrivo</span>
                    {else}
                        <i class="ti ti-clock"></i>
                        <span>Annunciato</span>
                    {/if}
                </div>

                {* Selettore quantità *}
                <div class="acquisto-quantita">
                    <label class="acquisto-quantita-label" for="qty-input">Quantità:</label>
                    <div class="quantita-stepper">
                        <button class="button quantita-btn" id="qty-minus" type="button" aria-label="Diminuisci quantità">
                            <i class="ti ti-minus"></i>
                        </button>
                        <input type="number"
                               id="qty-input"
                               class="input quantita-input"
                               value="1"
                               min="1"
                               max="99"
                               aria-label="Quantità">
                        <button class="button quantita-btn" id="qty-plus" type="button" aria-label="Aumenta quantità">
                            <i class="ti ti-plus"></i>
                        </button>
                    </div>
                </div>

                {* Prezzo totale *}
                {if isset($prezzo)}
                    <div class="acquisto-prezzo-tot">
                        <span class="prezzo-tot-label">Totale:</span>
                        <span class="prezzo-tot-value" id="prezzo-tot" data-unit="{if $sconto}{$prezzo_scontato}{else}{$prezzo}{/if}">
                            €{if $sconto}{$prezzo_scontato|number_format:2}{else}{$prezzo|number_format:2}{/if}
                        </span>
                    </div>
                {/if}

                {* Bottone Aggiungi al Carrello *}
                {if $disponibilita == 'disponibile'}
                    <a href="{$base_url}/carrello/aggiungi/{$id}"
                       class="button btn-add-cart-prodotto"
                       id="btn-add-cart"
                       data-id="{$id}"
                       aria-label="Aggiungi al carrello">
                        <i class="ti ti-shopping-cart"></i> Aggiungi al Carrello
                    </a>
                {else}
                    <button class="button btn-add-cart-prodotto is-disabled" disabled type="button">
                        <i class="ti ti-shopping-cart-off"></i> Non disponibile
                    </button>
                {/if}

                {* Wishlist *}
                <button class="btn-wishlist{if isset($isInWishlist) && $isInWishlist} is-active{/if}" id="btn-wishlist" type="button"
                        data-id="{$id}"
                        aria-label="Aggiungi alla wishlist">
                    <i class="ti {if isset($isInWishlist) && $isInWishlist}ti-heart-filled{else}ti-heart{/if}" id="wishlist-icon"></i> Wishlist
                </button>

            </div>

        </div>

        {* ── SEZIONE DESCRIZIONE + COMPONENTI ── *}
        <div class="prodotto-details">

            <div class="prodotto-descrizione">
                <h2 class="prodotto-section-title">Descrizione</h2>
                <div class="prodotto-descrizione-testo">
                    {$descrizioneProdotto|default:'Descrizione non disponibile.'|nl2br}
                </div>
            </div>

            {if isset($componenti) && $componenti|@count > 0}
                <div class="prodotto-componenti">
                    <h2 class="prodotto-section-title">Componenti</h2>
                    <ul class="componenti-list">
                        {foreach $componenti as $comp}
                            <li class="componenti-item">
                                <i class="ti ti-point"></i>
                                {$comp|escape}
                            </li>
                        {/foreach}
                    </ul>
                </div>
            {/if}

        </div>

        {* ── SEZIONE: FORSE TI PUO' INTERESSARE ── *}
        {if isset($correlati) && $correlati|@count > 0}
            <section class="prodotto-correlati">
                <h2 class="prodotto-section-title">Forse ti può interessare...</h2>

                <div class="correlati-wrapper">
                    <div class="correlati-grid" id="correlati-grid">
                        {foreach $correlati as $correlato}
                            <div class="correlato-card">
                                <a href="{$base_url}/prodotto/{$correlato.id}" class="correlato-card-link">
                                    <div class="correlato-image-wrapper">
                                        <img src="{$base_url}/img/prodotti/{$correlato.immagine|escape}"
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
                                            {if isset($correlato.prezzo)}
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

        {* ── SEZIONE RECENSIONI ── *}
        <section class="prodotto-recensioni" id="recensioni">
            <h2 class="prodotto-section-title">Recensioni</h2>

            {if isset($utente) && $utente}
                {if isset($userHasPurchased) && $userHasPurchased}
                    <div class="recensione-form-wrapper">
                        <button class="button btn-scrivi-recensione" id="btn-scrivi-recensione" type="button">
                            <i class="ti ti-pencil"></i> Scrivi la tua recensione
                        </button>

                        <div class="recensione-form" id="recensione-form" style="display:none;">
                            {* Rotta corretta secondo il FrontController: /recensioni/aggiungi (plurale) *}
                            <form action="{$base_url}/recensioni/aggiungi" method="post">
                                <input type="hidden" name="id_prodotto" value="{$id}">

                                <div class="form-group">
                                    <label class="form-label">Valutazione</label>
                                    <div class="star-picker" id="star-picker" role="group" aria-label="Scegli valutazione">
                                        {foreach [1,2,3,4,5] as $s}
                                            <i class="ti ti-star star-pick{if $s == 1} is-selected{/if}" data-value="{$s}" aria-label="{$s} stelle"></i>
                                        {/foreach}
                                    </div>
                                    <button type="button" class="button-link btn-reset-voto" id="btn-reset-voto">
                                        Voto minimo (1 stella)
                                    </button>
                                    <input type="hidden" name="valutazione" id="rec-voto" value="1">
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="rec-testo">Testo</label>
                                    <textarea id="rec-testo"
                                              name="testo"
                                              class="textarea"
                                              placeholder="Scrivi la tua opinione..."
                                              rows="4"
                                              required></textarea>
                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="button btn-invia-recensione">
                                        <i class="ti ti-send"></i> Invia
                                    </button>
                                    <button type="button" class="button btn-annulla-recensione" id="btn-annulla-recensione">
                                        Annulla
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                {else}
                    <p class="recensione-login-hint">
                        <i class="ti ti-alert-circle"></i> Puoi lasciare una recensione solo dopo aver acquistato questo prodotto.
                    </p>
                {/if}
            {else}
                <p class="recensione-login-hint">
                    <a href="{$base_url}/accedi">Accedi</a> per lasciare una recensione.
                </p>
            {/if}

            {* Lista recensioni *}
            {if isset($recensioni) && $recensioni|@count > 0}
                <div class="recensioni-list">
                    {foreach $recensioni as $rec}
                        <div class="recensione-card">
                            <div class="recensione-header">
                                <span class="recensione-nickname">
                                    <i class="ti ti-user"></i>
                                    {$rec.utente|escape}
                                </span>
                                <div class="recensione-stars">
                                    {assign var="voto" value=$rec.valutazione}
                                    {foreach [1,2,3,4,5] as $s}
                                        {if $s <= $voto}
                                            <i class="ti ti-star-filled"></i>
                                        {else}
                                            <i class="ti ti-star"></i>
                                        {/if}
                                    {/foreach}
                                </div>
                            </div>
                            <p class="recensione-testo">{$rec.testo|escape|nl2br}</p>

                            {if isset($utente) && $utente}
                                <div class="recensione-azioni">
                                    {if $rec.utente == $utente.name}
                                        {* Confronto per nickname: recensioneToArray() non espone l'id autore.
                                           Da irrobustire con t1 se i nickname non sono garantiti univoci. *}
                                        <form action="{$base_url}/recensioni/elimina"
                                              method="post"
                                              class="form-elimina-recensione"
                                              data-confirm="Eliminare questa recensione?">
                                            <input type="hidden" name="id_recensione" value="{$rec.id}">
                                            <button type="submit" class="button-link btn-elimina-recensione">
                                                <i class="ti ti-trash"></i> Elimina
                                            </button>
                                        </form>
                                    {elseif isset($motivazioni) && $motivazioni|@count > 0}
                                        <button type="button"
                                                class="button-link btn-segnala-recensione"
                                                data-target="segnala-form-{$rec.id}">
                                            <i class="ti ti-flag"></i> Segnala
                                        </button>

                                        <div class="segnala-form" id="segnala-form-{$rec.id}" style="display:none;">
                                            <form action="{$base_url}/recensioni/segnala" method="post">
                                                <input type="hidden" name="id_recensione" value="{$rec.id}">
                                                <div class="form-group">
                                                    <label class="form-label" for="motivazione-{$rec.id}">Motivo della segnalazione</label>
                                                    <select id="motivazione-{$rec.id}" name="id_motivazione" class="input" required>
                                                        <option value="" disabled selected>Seleziona un motivo</option>
                                                        {foreach $motivazioni as $motivo}
                                                            <option value="{$motivo.id}">{$motivo.label|escape}</option>
                                                        {/foreach}
                                                    </select>
                                                </div>
                                                <div class="form-actions">
                                                    <button type="submit" class="button btn-invia-segnalazione">
                                                        <i class="ti ti-send"></i> Invia segnalazione
                                                    </button>
                                                    <button type="button"
                                                            class="button btn-annulla-segnalazione"
                                                            data-target="segnala-form-{$rec.id}">
                                                        Annulla
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    {/if}
                                </div>
                            {/if}
                        </div>
                    {/foreach}
                </div>
            {else}
                <p class="recensioni-empty">Nessuna recensione ancora. Sii il primo!</p>
            {/if}

        </section>

    </div>
</div>

{* ── MODAL MINI-CART ── *}
<div class="minicart-modal" id="minicart-modal" aria-hidden="true">
    <div class="modal-background"></div>

    <div class="minicart-content">
        <button id="close-minicart" class="modal-close-btn" type="button" aria-label="Chiudi pop-up">&times;</button>

        <h3 class="minicart-success-title">Prodotto aggiunto al carrello!</h3>

        <div class="minicart-product">
            <img src="{$base_url}/img/prodotti/{$immagine|escape}"
                 alt="{$nome|escape}"
                 class="minicart-img">
            <div class="minicart-info">
                <p class="minicart-nome">{$nome|escape}</p>
                <p class="minicart-prezzo">
                    {if $sconto}
                        €{$prezzo_scontato|number_format:2}
                    {elseif isset($prezzo)}
                        €{$prezzo|number_format:2}
                    {/if}
                </p>
            </div>
        </div>

        <div class="minicart-actions">
            <a href="{$base_url}/catalogo" class="button btn-minicart-continua">
                <i class="ti ti-arrow-left"></i> Continua Shopping
            </a>
            <a href="{$base_url}/carrello" class="button btn-minicart-ordine">
                <i class="ti ti-shopping-cart"></i> Completa Ordine
            </a>
        </div>
    </div>
</div>

{/block}

{block name="extra_js"}
{* Variabili ed endpoint globali: iniettati fuori da {literal} perché Smarty
   non valuta variabili al suo interno. *}
<script>
var utenteLoggato = {if isset($utente)}true{else}false{/if};
var wishlistInizialmenteAttiva = {if isset($isInWishlist) && $isInWishlist}true{else}false{/if};
var CARRELLO_AGGIUNGI_URL = "{$base_url}/carrello/aggiungi";
var WISHLIST_AGGIUNGI_URL = "{$base_url}/wishlist/aggiungi";
var WISHLIST_RIMUOVI_URL = "{$base_url}/wishlist/rimuovi";
</script>
<script>
{literal}
(function() {

    function richiedeLogin() {
        var modal = document.getElementById('login-modal-nav');
        if (modal) {
            modal.classList.add('is-active');
            modal.setAttribute('aria-hidden', 'false');
            var btn = document.getElementById('close-login-modal-nav');
            if (btn) btn.focus();
        }
    }

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

    // ── STEPPER QUANTITÀ + PREZZO TOTALE ──
    var qtyInput  = document.getElementById('qty-input');
    var prezzoTot = document.getElementById('prezzo-tot');

    function aggiornaPrezzo() {
        if (!prezzoTot || !qtyInput) return;
        var unit = parseFloat(prezzoTot.dataset.unit) || 0;
        var qty  = parseInt(qtyInput.value) || 1;
        prezzoTot.textContent = '€' + (unit * qty).toFixed(2);
    }

    var btnMinus = document.getElementById('qty-minus');
    if (btnMinus) {
        btnMinus.addEventListener('click', function(e) {
            e.preventDefault();
            if (!qtyInput) return;
            var val = parseInt(qtyInput.value) || 1;
            if (val > 1) { qtyInput.value = val - 1; aggiornaPrezzo(); }
        });
    }

    var btnPlus = document.getElementById('qty-plus');
    if (btnPlus) {
        btnPlus.addEventListener('click', function(e) {
            e.preventDefault();
            if (!qtyInput) return;
            qtyInput.value = (parseInt(qtyInput.value) || 1) + 1;
            aggiornaPrezzo();
        });
    }

    if (qtyInput) qtyInput.addEventListener('input', aggiornaPrezzo);

    // ── MODAL MINICART ──
    var modal   = document.getElementById('minicart-modal');
    var btnCart = document.getElementById('btn-add-cart');
    var idProdotto = btnCart ? btnCart.dataset.id : null;

    function apriMinicart() {
        if (!modal) return;
        modal.classList.add('is-active');
        modal.setAttribute('aria-hidden', 'false');
        var closeBtn = document.getElementById('close-minicart');
        if (closeBtn) closeBtn.focus();
    }

    function chiudiMinicart() {
        if (!modal) return;
        modal.classList.remove('is-active');
        modal.setAttribute('aria-hidden', 'true');
        if (btnCart) btnCart.focus();
    }

    function aggiungiAlCarrello(idProdotto, quantita, callback) {
        var controller = new AbortController();
        var timeout = setTimeout(function() { controller.abort(); }, 5000);

        fetch(CARRELLO_AGGIUNGI_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: 'id_prodotto=' + encodeURIComponent(idProdotto) + '&quantita=' + encodeURIComponent(quantita),
            signal: controller.signal
        })
        .then(function(res) {
            clearTimeout(timeout);
            if (res.status === 401) {
                richiedeLogin();
                throw new Error('auth');
            }
            if (!res.ok) throw new Error('server');
            return res.json();
        })
        .then(function(data) {
            if (data.success === false) {
                mostraToast(data.message || 'Errore nell\'aggiunta del prodotto.', 'errore');
                return;
            }
            apriMinicart();
            var cartBadge = document.getElementById('cart-count');
            if (cartBadge && data.cart_count !== undefined) {
                cartBadge.textContent = data.cart_count;
                cartBadge.style.display = data.cart_count > 0 ? 'inline' : 'none';
            }
            if (callback) callback(data);
        })
        .catch(function(err) {
            clearTimeout(timeout);
            if (err.message === 'auth') return; // già gestito sopra
            var msg = err.name === 'AbortError'
                ? 'Connessione lenta, prodotto non aggiunto.'
                : 'Errore nell\'aggiunta del prodotto.';
            mostraToast(msg, 'errore');
        });
    }

    if (btnCart) {
        btnCart.addEventListener('click', function(e) {
            e.preventDefault();
            if (!utenteLoggato) {
                richiedeLogin();
                return;
            }
            var qty = parseInt(qtyInput ? qtyInput.value : 1) || 1;
            aggiungiAlCarrello(idProdotto, qty);
        });
    }

    document.querySelectorAll('.btn-correlato-cart').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            if (!utenteLoggato) {
                richiedeLogin();
                return;
            }
            var hrefParts = this.getAttribute('href').split('/');
            var idCorrelato = hrefParts[hrefParts.length - 1];
            aggiungiAlCarrello(idCorrelato, 1);
        });
    });

    var closeMinicart = document.getElementById('close-minicart');
    if (closeMinicart) closeMinicart.addEventListener('click', function(e) { e.preventDefault(); chiudiMinicart(); });

    var modalBg = modal ? modal.querySelector('.modal-background') : null;
    if (modalBg) modalBg.addEventListener('click', chiudiMinicart);

    document.querySelectorAll('.minicart-actions a').forEach(function(btn) {
        btn.addEventListener('click', function(e) { e.stopPropagation(); });
    });

    // ── CAROSELLO CORRELATI ──
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

    // ── TOGGLE FORM RECENSIONE ──
    var btnRecensione  = document.getElementById('btn-scrivi-recensione');
    var formRecensione = document.getElementById('recensione-form');

    if (btnRecensione && formRecensione) {
        btnRecensione.addEventListener('click', function(e) {
            e.preventDefault();
            formRecensione.style.display = formRecensione.style.display === 'block' ? 'none' : 'block';
        });
    }

    var btnAnnulla = document.getElementById('btn-annulla-recensione');
    if (btnAnnulla) {
        btnAnnulla.addEventListener('click', function(e) {
            e.preventDefault();
            if (formRecensione) formRecensione.style.display = 'none';
        });
    }

    // ── STAR PICKER RECENSIONE ──
    var stars     = document.querySelectorAll('.star-pick');
    var votoInput = document.getElementById('rec-voto');

    function aggiornaStelle(valore) {
        stars.forEach(function(s, i) {
            s.classList.toggle('ti-star-filled', i < valore);
            s.classList.toggle('ti-star',        i >= valore);
        });
    }

    stars.forEach(function(star) {
        star.addEventListener('mouseover', function() { aggiornaStelle(parseInt(this.dataset.value)); });
        star.addEventListener('click', function(e) {
            e.preventDefault();
            var val = parseInt(this.dataset.value);
            if (votoInput) votoInput.value = val;
            aggiornaStelle(val);
        });
    });

    var starPicker = document.getElementById('star-picker');
    if (starPicker) {
        starPicker.addEventListener('mouseleave', function() {
            aggiornaStelle(parseInt(votoInput ? votoInput.value : 1) || 1);
        });
    }

    var btnResetVoto = document.getElementById('btn-reset-voto');
    if (btnResetVoto) {
        btnResetVoto.addEventListener('click', function(e) {
            e.preventDefault();
            if (votoInput) votoInput.value = 1;
            aggiornaStelle(1);
        });
    }

    // ── TOGGLE FORM SEGNALAZIONE (delegato, ce n'è uno per recensione) ──
    document.querySelectorAll('.btn-segnala-recensione, .btn-annulla-segnalazione').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            var target = document.getElementById(this.dataset.target);
            if (!target) return;
            target.style.display = target.style.display === 'block' ? 'none' : 'block';
        });
    });

    // ── CONFERMA ELIMINAZIONE RECENSIONE ──
    document.querySelectorAll('.form-elimina-recensione').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            var msg = this.dataset.confirm || 'Confermi l\'eliminazione?';
            if (!window.confirm(msg)) {
                e.preventDefault();
            }
        });
    });

    // ── WISHLIST ──
    var btnWishlist  = document.getElementById('btn-wishlist');
    var wishlistIcon = document.getElementById('wishlist-icon');
    var idProdottoWishlist = btnWishlist ? btnWishlist.dataset.id : null;
    var inWishlist = wishlistInizialmenteAttiva;

    function impostaIconaWishlist(stato) {
        wishlistIcon.classList.toggle('ti-heart',        !stato);
        wishlistIcon.classList.toggle('ti-heart-filled',  stato);
        btnWishlist.classList.toggle('is-active',          stato);
    }

    if (btnWishlist) {
        btnWishlist.addEventListener('click', function() {
            if (!utenteLoggato) {
                richiedeLogin();
                return;
            }

            var statoPrecedente = inWishlist;
            var url = inWishlist ? WISHLIST_RIMUOVI_URL : WISHLIST_AGGIUNGI_URL;

            inWishlist = !inWishlist;
            impostaIconaWishlist(inWishlist);

            var controller = new AbortController();
            var timeout = setTimeout(function() { controller.abort(); }, 5000);

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'id_prodotto=' + encodeURIComponent(idProdottoWishlist),
                signal: controller.signal
            })
            .then(function(res) {
                clearTimeout(timeout);
                if (res.status === 401) {
                    richiedeLogin();
                    throw new Error('auth');
                }
                if (!res.ok) throw new Error('server');
                return res.json();
            })
            .then(function(data) {
                if (!data.success) {
                    inWishlist = statoPrecedente;
                    impostaIconaWishlist(inWishlist);
                    mostraToast(data.message || 'Errore nella wishlist.', 'errore');
                }
            })
            .catch(function(err) {
                clearTimeout(timeout);
                inWishlist = statoPrecedente;
                impostaIconaWishlist(inWishlist);
                if (err.message === 'auth') return; // già gestito sopra
                var msg = err.name === 'AbortError'
                    ? 'Connessione lenta, wishlist non aggiornata.'
                    : 'Errore nella wishlist.';
                mostraToast(msg, 'errore');
            });
        });
    }

})();
{/literal}

</script>

{/block}