{extends file="common/layout.tpl"}

{block name="extra_css"}
    <link rel="stylesheet" href="{$base_url}/css/prodotto.css">
{/block}

{block name="content"}

<div class="prodotto-container">
    <div class="container">

        {* ── BREADCRUMB ── *}
        <nav class="prodotto-breadcrumb" aria-label="Breadcrumb">
            <ul class="breadcrumb-list">
                <li><a href="{$base_url}/">Home</a></li>
                <li><a href="{$base_url}/catalogo">Catalogo</a></li>
                <li class="is-active"><span>{$prodotto.nome|escape}</span></li>
            </ul>
        </nav>

        {* ── SEZIONE PRINCIPALE: GALLERY + INFO + ACQUISTO ── *}
        <div class="prodotto-top">

            {* ── COLONNA SINISTRA: GALLERIA IMMAGINI ── *}
            <div class="prodotto-gallery">

                <div class="gallery-main-wrapper">
                    <button class="gallery-nav gallery-prev" id="gallery-prev" aria-label="Immagine precedente">
                        <i class="ti ti-chevron-left"></i>
                    </button>

                    <div class="gallery-main" id="gallery-main">
                        {if isset($prodotto.immagini) && $prodotto.immagini|@count > 0}
                            {foreach $prodotto.immagini as $key => $img}
                                <img src="{$base_url}/img/prodotti/{$img|escape}"
                                     alt="{$prodotto.nome|escape} - immagine {$key+1}"
                                     class="gallery-main-img{if $key == 0} is-active{/if}"
                                     data-index="{$key}">
                            {/foreach}
                        {else}
                            <img src="{$base_url}/img/prodotti/{$prodotto.immagine|escape}"
                                 alt="{$prodotto.nome|escape}"
                                 class="gallery-main-img is-active"
                                 data-index="0">
                        {/if}
                    </div>

                    <button class="gallery-nav gallery-next" id="gallery-next" aria-label="Immagine successiva">
                        <i class="ti ti-chevron-right"></i>
                    </button>
                </div>

                {* Thumbnails *}
                {if isset($prodotto.immagini) && $prodotto.immagini|@count > 1}
                    <div class="gallery-thumbs" id="gallery-thumbs">
                        {foreach $prodotto.immagini as $key => $img}
                            <img src="{$base_url}/img/prodotti/{$img|escape}"
                                 alt="Thumbnail {$key+1}"
                                 class="gallery-thumb{if $key == 0} is-active{/if}"
                                 data-index="{$key}">
                        {/foreach}
                    </div>
                {/if}

            </div>

            {* ── COLONNA CENTRO: INFO PRODOTTO ── *}
            <div class="prodotto-info">

                {* Badge disponibilità *}
                {if $prodotto.disponibilita == 'esaurito'}
                    <span class="prodotto-badge prodotto-badge-esaurito">Esaurito</span>
                {elseif $prodotto.disponibilita == 'annunciato'}
                    <span class="prodotto-badge prodotto-badge-annunciato">Annunciato</span>
                {elseif $prodotto.disponibilita == 'non disponibile'}
                    <span class="prodotto-badge prodotto-badge-non-disponibile">Non disponibile</span>
                {elseif $prodotto.disponibilita == 'in arrivo'}
                    <span class="prodotto-badge prodotto-badge-in-arrivo">In arrivo</span>
                {else}
                    <span class="prodotto-badge prodotto-badge-disponibile">Disponibile</span>
                {/if}

                <h1 class="prodotto-nome">{$prodotto.nome|escape}</h1>

                {* Rating *}
                <div class="prodotto-rating">
                    {assign var="media" value=$prodotto.valutazione_media}
                    {foreach [1,2,3,4,5] as $s}
                        {if $s <= $media}
                            <i class="ti ti-star-filled"></i>
                        {elseif ($s - $media) < 1}
                            <i class="ti ti-star-half-filled"></i>
                        {else}
                            <i class="ti ti-star"></i>
                        {/if}
                    {/foreach}
                    <span class="prodotto-rating-value">({$media|number_format:1})</span>
                    <a href="#recensioni" class="prodotto-rating-link">Leggi Recensioni</a>
                </div>

                {* Meta info prodotto *}
                <div class="prodotto-meta">
                    {if isset($prodotto.giocatori_min) && isset($prodotto.giocatori_max)}
                        <span class="prodotto-meta-item">
                            <i class="ti ti-users"></i>
                            {$prodotto.giocatori_min}–{$prodotto.giocatori_max} giocatori
                        </span>
                    {/if}
                    {if isset($prodotto.eta_min)}
                        <span class="prodotto-meta-item">
                            <i class="ti ti-baby-carriage"></i>
                            {$prodotto.eta_min}+ anni
                        </span>
                    {/if}
                    {if isset($prodotto.durata)}
                        <span class="prodotto-meta-item">
                            <i class="ti ti-clock"></i>
                            {$prodotto.durata} min
                        </span>
                    {/if}
                    {if isset($prodotto.difficolta)}
                        <span class="prodotto-meta-item">
                            <i class="ti ti-flame"></i>
                            {$prodotto.difficolta|escape}
                        </span>
                    {/if}
                    {if isset($prodotto.lingua)}
                        <span class="prodotto-meta-item">
                            <i class="ti ti-language"></i>
                            {$prodotto.lingua|escape}
                        </span>
                    {/if}
                </div>

                {* Prezzo *}
                <div class="prodotto-prezzo-wrapper">
                    {if $prodotto.sconto}
                        <span class="prodotto-prezzo">€{$prodotto.prezzo_scontato|number_format:2}</span>
                        <span class="prodotto-prezzo-old">€{$prodotto.prezzo|number_format:2}</span>
                        <span class="prodotto-badge-sconto">-{$prodotto.percentuale_sconto}%</span>
                    {elseif isset($prodotto.prezzo)}
                        <span class="prodotto-prezzo">€{$prodotto.prezzo|number_format:2}</span>
                    {else}
                        <span class="prodotto-prezzo-nd">Prezzo N/D</span>
                    {/if}
                </div>

            </div>

            {* ── COLONNA DESTRA: BOX ACQUISTO ── *}
            <div class="prodotto-acquisto-box">

                {* Disponibilità visiva *}
                <div class="acquisto-disponibilita">
                    {if $prodotto.disponibilita == 'disponibile'}
                        <i class="ti ti-circle-check"></i>
                        <span>Disponibile</span>
                    {elseif $prodotto.disponibilita == 'esaurito'}
                        <i class="ti ti-circle-x"></i>
                        <span>Esaurito</span>
                    {elseif $prodotto.disponibilita == 'non disponibile'}
                        <i class="ti ti-circle-x"></i>
                        <span>Non disponibile</span>
                    {elseif $prodotto.disponibilita == 'in arrivo'}
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
                <div class="acquisto-prezzo-tot">
                    {if $prodotto.sconto}
                        <span class="prezzo-tot-label">Totale:</span>
                        <span class="prezzo-tot-value" id="prezzo-tot" data-unit="{$prodotto.prezzo_scontato}">
                            €{$prodotto.prezzo_scontato|number_format:2}
                        </span>
                    {elseif isset($prodotto.prezzo)}
                        <span class="prezzo-tot-label">Totale:</span>
                        <span class="prezzo-tot-value" id="prezzo-tot" data-unit="{$prodotto.prezzo}">
                            €{$prodotto.prezzo|number_format:2}
                        </span>
                    {/if}
                </div>

                {* Bottone Aggiungi al Carrello *}
                {if $prodotto.disponibilita != 'esaurito'}
                    <a href="{$base_url}/carrello/aggiungi/{$prodotto.id}"
                       class="button btn-add-cart-prodotto"
                       id="btn-add-cart"
                       data-id="{$prodotto.id}"
                       aria-label="Aggiungi al carrello">
                        <i class="ti ti-shopping-cart"></i> Aggiungi al Carrello
                    </a>
                {else}
                    <button class="button btn-add-cart-prodotto is-disabled" disabled type="button">
                        <i class="ti ti-shopping-cart-off"></i> Non disponibile
                    </button>
                {/if}

                {* Wishlist *}
                <button class="btn-wishlist" id="btn-wishlist" type="button"
                        data-url="{$base_url}/wishlist/aggiungi/{$prodotto.id}"
                        aria-label="Aggiungi alla wishlist">
                    <i class="ti ti-heart" id="wishlist-icon"></i> Wishlist
                </button>

            </div>

        </div>

        {* ── SEZIONE DESCRIZIONE + COMPONENTI ── *}
        <div class="prodotto-details">

            <div class="prodotto-descrizione">
                <h2 class="prodotto-section-title">Descrizione</h2>
                <div class="prodotto-descrizione-testo">
                    {$prodotto.descrizione|default:'Descrizione non disponibile.'|nl2br}
                </div>
            </div>

            {if isset($prodotto.componenti) && $prodotto.componenti|@count > 0}
                <div class="prodotto-componenti">
                    <h2 class="prodotto-section-title">Componenti</h2>
                    <ul class="componenti-list">
                        {foreach $prodotto.componenti as $comp}
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
                            <form action="{$base_url}/recensione/aggiungi/{$prodotto.id}" method="post">

                                <div class="form-group">
                                    <label class="form-label" for="rec-titolo">Titolo</label>
                                    <input type="text"
                                           id="rec-titolo"
                                           name="titolo"
                                           class="input"
                                           placeholder="Titolo della recensione"
                                           required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Valutazione</label>
                                    <div class="star-picker" id="star-picker" role="group" aria-label="Scegli valutazione">
                                        {foreach [1,2,3,4,5] as $s}
                                            <i class="ti ti-star star-pick" data-value="{$s}" aria-label="{$s} stelle"></i>
                                        {/foreach}
                                    </div>
                                    <input type="hidden" name="voto" id="rec-voto" value="0">
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
                                    {$rec.nickname|escape}
                                </span>
                                <div class="recensione-stars">
                                    {assign var="voto" value=$rec.voto}
                                    {foreach [1,2,3,4,5] as $s}
                                        {if $s <= $voto}
                                            <i class="ti ti-star-filled"></i>
                                        {else}
                                            <i class="ti ti-star"></i>
                                        {/if}
                                    {/foreach}
                                </div>
                            </div>
                            <p class="recensione-titolo">{$rec.titolo|escape}</p>
                            <p class="recensione-testo">{$rec.testo|escape|nl2br}</p>
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
            <img src="{$base_url}/img/prodotti/{$prodotto.immagine|escape}"
                 alt="{$prodotto.nome|escape}"
                 class="minicart-img">
            <div class="minicart-info">
                <p class="minicart-nome">{$prodotto.nome|escape}</p>
                <p class="minicart-prezzo">
                    {if $prodotto.sconto}
                        €{$prodotto.prezzo_scontato|number_format:2}
                    {elseif isset($prodotto.prezzo)}
                        €{$prodotto.prezzo|number_format:2}
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
<script>
{literal}
(function() {

    // ── GALLERIA IMMAGINI ──
    var imgs   = document.querySelectorAll('.gallery-main-img');
    var thumbs = document.querySelectorAll('.gallery-thumb');
    var currentImg = 0;

    function showImg(index) {
        imgs.forEach(function(i) { i.classList.remove('is-active'); });
        thumbs.forEach(function(t) { t.classList.remove('is-active'); });
        currentImg = (index + imgs.length) % imgs.length;
        if (imgs[currentImg])   imgs[currentImg].classList.add('is-active');
        if (thumbs[currentImg]) thumbs[currentImg].classList.add('is-active');
    }

    var galleryPrev = document.getElementById('gallery-prev');
    var galleryNext = document.getElementById('gallery-next');
    if (galleryPrev) galleryPrev.addEventListener('click', function() { showImg(currentImg - 1); });
    if (galleryNext) galleryNext.addEventListener('click', function() { showImg(currentImg + 1); });

    thumbs.forEach(function(thumb) {
        thumb.addEventListener('click', function() {
            showImg(parseInt(this.dataset.index));
        });
    });

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

    // ── AJAX AGGIUNGI AL CARRELLO ──
    function aggiungiAlCarrello(idProdotto, quantita, callback) {
        fetch('/carrello/aggiungi', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: 'id_prodotto=' + idProdotto + '&quantita=' + quantita
        })
        .then(function(res) {
            if (!res.ok) throw new Error('Errore HTTP: ' + res.status);
            return res.json();
        })
        .then(function(data) {
            if (data.success) {
                apriMinicart();
                var cartBadge = document.getElementById('cart-count');
                if (cartBadge && data.cart_count !== undefined) {
                    cartBadge.textContent = data.cart_count;
                    cartBadge.style.display = data.cart_count > 0 ? 'inline' : 'none';
                }
                if (callback) callback(data);
            } else {
                console.error('Errore carrello:', data.messaggio);
            }
        })
        .catch(function(err) {
            console.error('Fetch carrello fallita:', err);
        });
    }

    if (btnCart) {
        btnCart.addEventListener('click', function(e) {
            e.preventDefault();
            var qty = parseInt(qtyInput ? qtyInput.value : 1) || 1;
            aggiungiAlCarrello(idProdotto, qty);
        });
    }

    document.querySelectorAll('.btn-correlato-cart').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
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
            aggiornaStelle(parseInt(votoInput ? votoInput.value : 0) || 0);
        });
    }

    // ── WISHLIST ──
    var btnWishlist  = document.getElementById('btn-wishlist');
    var wishlistIcon = document.getElementById('wishlist-icon');
    var inWishlist   = false;

    if (btnWishlist) {
        btnWishlist.addEventListener('click', function() {
            inWishlist = !inWishlist;
            wishlistIcon.classList.toggle('ti-heart',        !inWishlist);
            wishlistIcon.classList.toggle('ti-heart-filled',  inWishlist);
            btnWishlist.classList.toggle('is-active',          inWishlist);

            fetch('/wishlist/aggiungi', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'id_prodotto=' + idProdotto
            })
            .then(function(res) {
                if (!res.ok) throw new Error('Errore HTTP: ' + res.status);
                return res.json();
            })
            .then(function(data) {
                if (!data.success) {
                    inWishlist = !inWishlist;
                    wishlistIcon.classList.toggle('ti-heart',        !inWishlist);
                    wishlistIcon.classList.toggle('ti-heart-filled',  inWishlist);
                    btnWishlist.classList.toggle('is-active',          inWishlist);
                    console.error('Errore wishlist:', data.messaggio);
                }
            })
            .catch(function(err) { console.error('Fetch wishlist fallita:', err); });
        });
    }

})();
{/literal}

</script>

{/block}
