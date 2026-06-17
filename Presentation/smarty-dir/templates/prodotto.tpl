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
                <li class="is-active"><span>{$prodotto->getNomeProdotto()|escape}</span></li>
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
                        {assign var="immagini" value=$prodotto->getImmagini()}
                        {if isset($immagini) && $immagini|@count > 0}
                            {foreach $immagini as $key => $img}
                                <img src="{$base_url}/img/prodotti/{$img|escape}"
                                     alt="{$prodotto->getNomeProdotto()|escape} - immagine {$key+1}"
                                     class="gallery-main-img{if $key == 0} is-active{/if}"
                                     data-index="{$key}">
                            {/foreach}
                        {else}
                            <img src="{$base_url}/img/prodotti/{$prodotto->getImgProdotto()|escape}"
                                 alt="{$prodotto->getNomeProdotto()|escape}"
                                 class="gallery-main-img is-active"
                                 data-index="0">
                        {/if}
                    </div>

                    <button class="gallery-nav gallery-next" id="gallery-next" aria-label="Immagine successiva">
                        <i class="ti ti-chevron-right"></i>
                    </button>
                </div>

                {* Thumbnails *}
                {if isset($immagini) && $immagini|@count > 1}
                    <div class="gallery-thumbs" id="gallery-thumbs">
                        {foreach $immagini as $key => $img}
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
                {if $prodotto->getDisponibilitaProdotto() == 'esaurito'}
                    <span class="prodotto-badge prodotto-badge-esaurito">Esaurito</span>
                {elseif $prodotto->getDisponibilitaProdotto() == 'annunciato'}
                    <span class="prodotto-badge prodotto-badge-annunciato">Annunciato</span>
                {elseif $prodotto->getDisponibilitaProdotto() == 'Non disponibile'}
                    <span class="prodotto-badge prodotto-badge-non-disponibile">Non disponibile</span>
                {elseif $prodotto->getDisponibilitaProdotto() == 'In arrivo'}
                    <span class="prodotto-badge prodotto-badge-in-arrivo">In arrivo</span>
                {else}
                    <span class="prodotto-badge prodotto-badge-disponibile">Disponibile</span>
                {/if}

                <h1 class="prodotto-nome">{$prodotto->getNomeProdotto()|escape}</h1>

                {* Rating *}
                <div class="prodotto-rating">
                    {assign var="media" value=$prodotto->getValutazioneMedia()}
                    {assign var="stelle" value=[1,2,3,4,5]}
                    {foreach $stelle as $s}
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
                    {if $prodotto->getGiocatoriMin() && $prodotto->getGiocatoriMax()}
                        <span class="prodotto-meta-item">
                            <i class="ti ti-users"></i>
                            {$prodotto->getGiocatoriMin()}–{$prodotto->getGiocatoriMax()} giocatori
                        </span>
                    {/if}
                    {if $prodotto->getEtaMin()}
                        <span class="prodotto-meta-item">
                            <i class="ti ti-baby-carriage"></i>
                            {$prodotto->getEtaMin()}+ anni
                        </span>
                    {/if}
                    {if $prodotto->getDurata()}
                        <span class="prodotto-meta-item">
                            <i class="ti ti-clock"></i>
                            {$prodotto->getDurata()} min
                        </span>
                    {/if}
                    {if $prodotto->getDifficolta()}
                        <span class="prodotto-meta-item">
                            <i class="ti ti-flame"></i>
                            {$prodotto->getDifficolta()|escape}
                        </span>
                    {/if}
                    {if $prodotto->getLingua()}
                        <span class="prodotto-meta-item">
                            <i class="ti ti-language"></i>
                            {$prodotto->getLingua()|escape}
                        </span>
                    {/if}
                </div>

                {* Prezzo *}
                <div class="prodotto-prezzo-wrapper">
                    {assign var="prezzo" value=$prodotto->getPrezzo()}
                    {if isset($prezzo)}
                        {if $prezzo->hasSconto()}
                            <span class="prodotto-prezzo">€{$prezzo->calcolaPrezzoScontato()|number_format:2}</span>
                            <span class="prodotto-prezzo-old">€{$prezzo->getValore()|number_format:2}</span>
                            <span class="prodotto-badge-sconto">-{$prezzo->getSconto()}%</span>
                        {else}
                            <span class="prodotto-prezzo">€{$prezzo->getValore()|number_format:2}</span>
                        {/if}
                    {else}
                        <span class="prodotto-prezzo-nd">Prezzo N/D</span>
                    {/if}
                </div>

            </div>

            {* ── COLONNA DESTRA: BOX ACQUISTO ── *}
            <div class="prodotto-acquisto-box">

                {* Disponibilità visiva *}
                <div class="acquisto-disponibilita">
                    {if $prodotto->getDisponibilitaProdotto() == 'disponibile'}
                        <i class="ti ti-circle-check"></i>
                        <span>Disponibile</span>
                    {elseif $prodotto->getDisponibilitaProdotto() == 'esaurito'}
                        <i class="ti ti-circle-x"></i>
                        <span>Esaurito</span>
                    {elseif $prodotto->getDisponibilitaProdotto() == 'Non disponibile'}
                        <i class="ti ti-circle-x"></i>
                        <span>Non disponibile</span>
                    {elseif $prodotto->getDisponibilitaProdotto() == 'In arrivo'}
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
                        <button class="button quantita-btn" id="qty-minus" aria-label="Diminuisci quantità">
                            <i class="ti ti-minus"></i>
                        </button>
                        <input type="number"
                               id="qty-input"
                               class="input quantita-input"
                               value="1"
                               min="1"
                               max="99"
                               aria-label="Quantità">
                        <button class="button quantita-btn" id="qty-plus" aria-label="Aumenta quantità">
                            <i class="ti ti-plus"></i>
                        </button>
                    </div>
                </div>

                {* Prezzo totale *}
                <div class="acquisto-prezzo-tot">
                    {if isset($prezzo)}
                        {if $prezzo->hasSconto()}
                            <span class="prezzo-tot-label">Totale:</span>
                            <span class="prezzo-tot-value" id="prezzo-tot" data-unit="{$prezzo->calcolaPrezzoScontato()}">
                                €{$prezzo->calcolaPrezzoScontato()|number_format:2}
                            </span>
                        {else}
                            <span class="prezzo-tot-label">Totale:</span>
                            <span class="prezzo-tot-value" id="prezzo-tot" data-unit="{$prezzo->getValore()}">
                                €{$prezzo->getValore()|number_format:2}
                            </span>
                        {/if}
                    {/if}
                </div>

                {* Bottone Aggiungi al Carrello *}
                {if $prodotto->getDisponibilitaProdotto() != 'esaurito'}
                    <a href="{$base_url}/carrello/aggiungi/{$prodotto->getIdProdotto()}"
                       class="button btn-add-cart-prodotto"
                       id="btn-add-cart"
                       aria-label="Aggiungi al carrello">
                        <i class="ti ti-shopping-cart"></i> Aggiungi al Carrello
                    </a>
                {else}
                    <button class="button btn-add-cart-prodotto is-disabled" disabled>
                        <i class="ti ti-shopping-cart-off"></i> Non disponibile
                    </button>
                {/if}

                {* Wishlist *}
                <a href="{$base_url}/wishlist/aggiungi/{$prodotto->getIdProdotto()}"
                   class="btn-wishlist"
                   aria-label="Aggiungi alla wishlist">
                    <i class="ti ti-heart"></i> Wishlist
                </a>

            </div>

        </div>

        {* ── SEZIONE DESCRIZIONE + COMPONENTI ── *}
        <div class="prodotto-details">

            <div class="prodotto-descrizione">
                <h2 class="prodotto-section-title">Descrizione</h2>
                <div class="prodotto-descrizione-testo">
                    {$prodotto->getDescrizione()|default:'Descrizione non disponibile.'|nl2br}
                </div>
            </div>

            {if $prodotto->getComponenti()}
                <div class="prodotto-componenti">
                    <h2 class="prodotto-section-title">Componenti</h2>
                    <ul class="componenti-list">
                        {foreach $prodotto->getComponenti() as $comp}
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
                                <a href="{$base_url}/prodotto/{$correlato->getIdProdotto()}" class="correlato-card-link">
                                    <div class="correlato-image-wrapper">
                                        <img src="{$base_url}/img/prodotti/{$correlato->getImgProdotto()|escape}"
                                             alt="{$correlato->getNomeProdotto()|escape}"
                                             class="correlato-image">
                                    </div>
                                    <div class="correlato-info">
                                        <h3 class="correlato-nome">{$correlato->getNomeProdotto()|escape}</h3>
                                        <div class="correlato-rating">
                                            {assign var="cMedia" value=$correlato->getValutazioneMedia()}
                                            {assign var="stelle" value=[1,2,3,4,5]}
                                            {foreach $stelle as $s}
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

                    <button class="correlati-nav correlati-next" id="correlati-next" aria-label="Vedi altri prodotti correlati">
                        <i class="ti ti-chevron-right"></i>
                    </button>
                </div>

            </section>
        {/if}

        {* ── SEZIONE RECENSIONI ── *}
        <section class="prodotto-recensioni" id="recensioni">
            <h2 class="prodotto-section-title">Recensioni</h2>

            {* Form nuova recensione (solo utenti loggati) *}
            {if isset($utente_loggato) && $utente_loggato}
                <div class="recensione-form-wrapper">
                    <button class="button btn-scrivi-recensione" id="btn-scrivi-recensione">
                        <i class="ti ti-pencil"></i> Scrivi la tua recensione
                    </button>

                    <div class="recensione-form" id="recensione-form" style="display:none;">
                        <form action="{$base_url}/recensione/aggiungi/{$prodotto->getIdProdotto()}" method="post">

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
                    <a href="{$base_url}/login">Accedi</a> per lasciare una recensione.
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
                                    {$rec->getNicknameUtente()|escape}
                                </span>
                                <div class="recensione-stars">
                                    {assign var="voto" value=$rec->getVoto()}
                                    {foreach [1,2,3,4,5] as $s}
                                        {if $s <= $voto}
                                            <i class="ti ti-star-filled"></i>
                                        {else}
                                            <i class="ti ti-star"></i>
                                        {/if}
                                    {/foreach}
                                </div>
                            </div>
                            <p class="recensione-titolo">{$rec->getTitolo()|escape}</p>
                            <p class="recensione-testo">{$rec->getTesto()|escape|nl2br}</p>
                        </div>
                    {/foreach}
                </div>
            {else}
                <p class="recensioni-empty">Nessuna recensione ancora. Sii il primo!</p>
            {/if}

        </section>

    </div>
</div>

{* ── MODAL MINI-CART (appare dopo "Aggiungi al carrello") ── *}
<div class="minicart-modal" id="minicart-modal" aria-hidden="true">
    <div class="minicart-content">

        <div class="minicart-product">
            <img src="{$base_url}/img/prodotti/{$prodotto->getImgProdotto()|escape}"
                 alt="{$prodotto->getNomeProdotto()|escape}"
                 class="minicart-img">
            <div class="minicart-info">
                <p class="minicart-nome">{$prodotto->getNomeProdotto()|escape}</p>
                <p class="minicart-prezzo">
                    {if isset($prezzo)}
                        {if $prezzo->hasSconto()}
                            €{$prezzo->calcolaPrezzoScontato()|number_format:2}
                        {else}
                            €{$prezzo->getValore()|number_format:2}
                        {/if}
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
document.addEventListener('DOMContentLoaded', function () {

    // ── GALLERIA IMMAGINI ──
    const imgs = document.querySelectorAll('.gallery-main-img');
    const thumbs = document.querySelectorAll('.gallery-thumb');
    let currentImg = 0;

    function showImg(index) {
        imgs.forEach(i => i.classList.remove('is-active'));
        thumbs.forEach(t => t.classList.remove('is-active'));
        currentImg = (index + imgs.length) % imgs.length;
        if (imgs[currentImg]) imgs[currentImg].classList.add('is-active');
        if (thumbs[currentImg]) thumbs[currentImg].classList.add('is-active');
    }

    document.getElementById('gallery-prev')?.addEventListener('click', () => showImg(currentImg - 1));
    document.getElementById('gallery-next')?.addEventListener('click', () => showImg(currentImg + 1));

    thumbs.forEach(thumb => {
        thumb.addEventListener('click', function () {
            showImg(parseInt(this.dataset.index));
        });
    });

    // ── STEPPER QUANTITÀ + PREZZO TOTALE ──
    const qtyInput = document.getElementById('qty-input');
    const prezzoTot = document.getElementById('prezzo-tot');

    function aggiornaPrezzo() {
        if (!prezzoTot) return;
        const unit = parseFloat(prezzoTot.dataset.unit) || 0;
        const qty = parseInt(qtyInput.value) || 1;
        prezzoTot.textContent = '€' + (unit * qty).toFixed(2);
    }

    document.getElementById('qty-minus')?.addEventListener('click', function () {
        if (parseInt(qtyInput.value) > 1) {
            qtyInput.value = parseInt(qtyInput.value) - 1;
            aggiornaPrezzo();
        }
    });

    document.getElementById('qty-plus')?.addEventListener('click', function () {
        qtyInput.value = parseInt(qtyInput.value) + 1;
        aggiornaPrezzo();
    });

    qtyInput?.addEventListener('input', aggiornaPrezzo);

    // ── AGGIORNA HREF CARRELLO CON QUANTITÀ ──
    // ── AGGIORNA HREF CARRELLO CON QUANTITÀ (Gestione AJAX + Modal) ──
    const btnCart = document.getElementById('btn-add-cart');
    if (btnCart && qtyInput) {
        
        // Funzione per aggiornare l'attributo href (utile se l'utente fa tasto destro -> apri in nuova scheda)
        function aggiornaHref() {
            const currentQty = parseInt(qtyInput.value) || 1;
            // Estraiamo la base del link prima di eventuali vecchi parametri query
            const urlSenzaQuery = btnCart.getAttribute('href').split('?')[0];
            btnCart.setAttribute('href', urlSenzaQuery + '?qty=' + currentQty);
        }

        // Aggiorna l'href sia quando l'utente cambia input sia quando clicca sui pulsanti + e -
        qtyInput.addEventListener('input', aggiornaHref);
        document.getElementById('qty-minus')?.addEventListener('click', aggiornaHref);
        document.getElementById('qty-plus')?.addEventListener('click', aggiornaHref);

        // Intercettiamo il click per fare la richiesta AJAX
        btnCart.addEventListener('click', function (e) {
            e.preventDefault(); // Impedisce il reindirizzamento automatico del browser

            const targetUrl = this.getAttribute('href');
            const modal = document.getElementById('minicart-modal');

            // Inviamo la richiesta al server in background (AJAX)
            fetch(targetUrl, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest' // Comunica al backend che è una richiesta AJAX
                }
            })
            .then(response => {
                if (response.ok) {
                    // Se il server risponde correttamente, mostriamo il modal
                    if (modal) {
                        modal.classList.add('is-active');
                        modal.setAttribute('aria-hidden', 'false');
                    }
                } else {
                    console.error("Errore durante l'aggiunta al carrello.");
                    // Opzionale: fallback se la fetch fallisce, reindirizziamo normalmente
                    window.location.href = targetUrl;
                }
            })
            .catch(error => {
                console.error("Errore di rete:", error);
                window.location.href = targetUrl;
            });
        });
    }
    
    // ── TOGGLE FORM RECENSIONE ──
    document.getElementById('btn-scrivi-recensione')?.addEventListener('click', function () {
        const form = document.getElementById('recensione-form');
        if (form) form.style.display = form.style.display === 'none' ? 'block' : 'none';
    });

    document.getElementById('btn-annulla-recensione')?.addEventListener('click', function () {
        document.getElementById('recensione-form').style.display = 'none';
    });

    // ── STAR PICKER RECENSIONE ──
    const stars = document.querySelectorAll('.star-pick');
    const votoInput = document.getElementById('rec-voto');

    stars.forEach(star => {
        star.addEventListener('mouseover', function () {
            const val = parseInt(this.dataset.value);
            stars.forEach((s, i) => {
                s.classList.toggle('ti-star-filled', i < val);
                s.classList.toggle('ti-star', i >= val);
            });
        });

        star.addEventListener('click', function () {
            const val = parseInt(this.dataset.value);
            if (votoInput) votoInput.value = val;
        });
    });

    document.getElementById('star-picker')?.addEventListener('mouseleave', function () {
        const val = parseInt(votoInput?.value) || 0;
        stars.forEach((s, i) => {
            s.classList.toggle('ti-star-filled', i < val);
            s.classList.toggle('ti-star', i >= val);
        });
    });

});
</script>
{/block}
