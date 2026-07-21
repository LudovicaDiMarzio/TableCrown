{extends file="common/layout.tpl"}

{block name="extra_css"}
    <link rel="stylesheet" href="{$base_url}/public/css/home.css">
{/block}

{block name="content"}
<div class="container px-4">


    {* ── SEARCH BAR ── *}
    <div class="home-search-bar">
        <form class="home-search-form" action="{$base_url}/catalogo/giochi-da-tavolo" method="get">
            <input class="input home-search-input"
                   type="search"
                   name="q"
                   placeholder="Cerca nel catalogo..."
                   value="{$search_query|default:''|escape}"
                   aria-label="Cerca nel catalogo">
            <button class="button home-search-btn" type="submit" aria-label="Cerca">
                <i class="ti ti-search"></i>
            </button>
        </form>
    </div>



    {* ──────────────────────────────────────────── *}
    {* 1. CAROSELLO IMMAGINI (HERO)                 *}
    {* ──────────────────────────────────────────── *}
    <div class="hero-carousel" id="home-carousel">
        <div class="carousel-inner" id="carousel-inner">
            <div class="carousel-item">
                <img src="{$base_url}/img/carousel/slide1.jpg" alt="Nuovi Giochi da Tavolo">
                <div class="carousel-caption">
                    <h2 class="title is-3 has-text-white">Esplora le ultime novità</h2>
                    <p class="subtitle is-5 has-text-warning">I migliori titoli del 2026 arrivano su TableCrown</p>
                </div>
            </div>

            <div class="carousel-item">
                <img src="{$base_url}/img/carousel/slide2.jpg" alt="Eventi e Tornei">
                <div class="carousel-caption">
                    <h2 class="title is-3 has-text-white">Tornei della Settimana</h2>
                    <p class="subtitle is-5 has-text-warning">Iscriviti agli eventi ufficiali in Abruzzo</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{$base_url}/img/carousel/slide3.jpg" alt="Offerte Speciali">
                <div class="carousel-caption">
                    <h2 class="title is-3 has-text-white">Sconti folli di Primavera</h2>
                    <p class="subtitle is-5 has-text-warning">Fino al 40% di sconto sui giochi di strategia</p>
                </div>
            </div>
        </div>
        <div class="carousel-nav">
            <button class="button is-rounded" id="prev-slide"><i class="ti ti-chevron-left"></i></button>
            <button class="button is-rounded" id="next-slide"><i class="ti ti-chevron-right"></i></button>
        </div>
    </div>

    {* ──────────────────────────────────────────── *}
    {* 2. ZONA: OFFERTE IN SCADENZA                  *}
    {* ──────────────────────────────────────────── *}
    <section class="home-section">
        <h2 class="title section-title is-4 text-uppercase">🔥 Offerte in Scadenza</h2>

        <div class="card-row-vector">
            {if isset($offerte) && $offerte|@count > 0}
                {foreach $offerte as $prodotto}
                    {assign var="haSconto" value=$prodotto.sconto|default:false}
                    {assign var="prezzoEffettivo" value=$haSconto && isset($prodotto.prezzo_scontato) ? $prodotto.prezzo_scontato : $prodotto.prezzo|default:null}

                    <div class="card-vector-item">
                        <a href="{$base_url}/prodotto?id={$prodotto.id}" class="card-link-wrapper">
                            <div class="card home-card-fixed">
                                <div class="card-image">
                                    <figure class="image-container-fixed">
                                        <img src="{$base_url}/img/prodotti/{$prodotto.immagine}" alt="{$prodotto.nome|escape}" />
                                    </figure>
                                </div>
                                <div class="card-content">
                                    <p class="card-title-custom">{$prodotto.nome|escape}</p>

                                    <div class="card-rating">
                                        {assign var="media" value=$prodotto.valutazione_media}
                                        {assign var="stelle" value=[1,2,3,4,5]}
                                        {foreach $stelle as $s}
                                            {if $s <= $media}
                                                <i class="ti ti-star-filled star-icon"></i>
                                            {elseif ($s - $media) < 1}
                                                <i class="ti ti-star-half-filled star-icon"></i>
                                            {else}
                                                <i class="ti ti-star star-icon"></i>
                                            {/if}
                                        {/foreach}
                                    </div>

                                    <div class="price-container">
                                        {if $haSconto && isset($prodotto.prezzo_scontato)}
                                            <span class="price">€{$prodotto.prezzo_scontato|number_format:2}</span>
                                            {if isset($prodotto.prezzo)}
                                                <span class="price-old">€{$prodotto.prezzo|number_format:2}</span>
                                            {/if}
                                        {elseif isset($prodotto.prezzo)}
                                            <span class="price">€{$prodotto.prezzo|number_format:2}</span>
                                        {else}
                                            <span class="price-unavailable">Prezzo non disponibile</span>
                                        {/if}
                                    </div>

                                    <button class="btn-cart"
                                            data-id="{$prodotto.id}"
                                            data-nome="{$prodotto.nome|escape}"
                                            data-img="{$base_url}/img/prodotti/{$prodotto.immagine}"
                                            data-prezzo="{$prezzoEffettivo}">
                                        <i class="ti ti-shopping-cart"></i> Acquista
                                    </button>
                                </div>
                            </div>
                        </a>
                    </div>
                {/foreach}

                <div class="card-vector-item card-vector-more">
                    <a href="{$base_url}/offerte" class="view-more-link" title="Vedi tutte le offerte">
                        <div class="circle-plus">
                            <span>+</span>
                        </div>
                        <span class="view-more-text">Vedi tutti</span>
                    </a>
                </div>

            {else}
                <p class="empty-section-message">Nessuna offerta disponibile al momento.</p>
            {/if}
        </div>
    </section>

    {* ──────────────────────────────────────────── *}
    {* 3. ZONA: NUOVI ARRIVI                        *}
    {* ──────────────────────────────────────────── *}
    <section class="home-section">
        <h2 class="title section-title is-4 text-uppercase">✨ Nuovi Arrivi</h2>

        <div class="card-row-vector">
            {if isset($nuovi_arrivi) && $nuovi_arrivi|@count > 0}
                {foreach $nuovi_arrivi as $prodotto}
                    {assign var="haSconto" value=$prodotto.sconto|default:false}
                    {assign var="prezzoEffettivo" value=$haSconto && isset($prodotto.prezzo_scontato) ? $prodotto.prezzo_scontato : $prodotto.prezzo|default:null}

                    <div class="card-vector-item">
                        <a href="{$base_url}/prodotto?id={$prodotto.id}" class="card-link-wrapper">
                            <div class="card home-card-fixed">
                                <div class="card-image">
                                    <figure class="image-container-fixed">
                                        <img src="{$base_url}/img/prodotti/{$prodotto.immagine}" alt="{$prodotto.nome|escape}" />
                                    </figure>
                                </div>
                                <div class="card-content">
                                    <p class="card-title-custom">{$prodotto.nome|escape}</p>

                                    <div class="card-rating">
                                        {assign var="media" value=$prodotto.valutazione_media}
                                        {assign var="stelle" value=[1,2,3,4,5]}
                                        {foreach $stelle as $s}
                                            {if $s <= $media}
                                                <i class="ti ti-star-filled star-icon"></i>
                                            {elseif ($s - $media) < 1}
                                                <i class="ti ti-star-half-filled star-icon"></i>
                                            {else}
                                                <i class="ti ti-star star-icon"></i>
                                            {/if}
                                        {/foreach}
                                    </div>

                                    <div class="price-container">
                                        {if $haSconto && isset($prodotto.prezzo_scontato)}
                                            <span class="price">€{$prodotto.prezzo_scontato|number_format:2}</span>
                                            {if isset($prodotto.prezzo)}
                                                <span class="price-old">€{$prodotto.prezzo|number_format:2}</span>
                                            {/if}
                                        {elseif isset($prodotto.prezzo)}
                                            <span class="price">€{$prodotto.prezzo|number_format:2}</span>
                                        {else}
                                            <span class="price-unavailable">Prezzo non disponibile</span>
                                        {/if}
                                    </div>

                                    <button class="btn-cart"
                                            data-id="{$prodotto.id}"
                                            data-nome="{$prodotto.nome|escape}"
                                            data-img="{$base_url}/img/prodotti/{$prodotto.immagine}"
                                            data-prezzo="{$prezzoEffettivo}">
                                        <i class="ti ti-shopping-cart"></i> Acquista
                                    </button>
                                </div>
                            </div>
                        </a>
                    </div>
                {/foreach}

                <div class="card-vector-item card-vector-more">
                    <a href="{$base_url}/catalogo?ordinamento=novita" class="more-link-wrapper" title="Vedi tutti i nuovi arrivi">
                        <div class="more-circle-btn">
                            <span class="more-plus-icon">+</span>
                        </div>
                        <span class="more-text">Vedi tutti</span>
                    </a>
                </div>

            {else}
                <p class="empty-section-message">Nessun nuovo arrivo disponibile al momento.</p>
            {/if}
        </div>
    </section>

</div>

{* ════════════════════════════════════════════════════════════
   MODAL 1: PRODOTTO AGGIUNTO AL CARRELLO (utente loggato)
   ════════════════════════════════════════════════════════════ *}
<div class="minicart-modal" id="minicart-modal" aria-hidden="true">
    <div class="modal-background"></div>

    <div class="minicart-content">
        <button id="close-minicart" class="modal-close-btn" type="button" aria-label="Chiudi pop-up">&times;</button>

        <h3 class="minicart-success-title">Prodotto aggiunto al carrello!</h3>

        <div class="minicart-product">
            <img src="" alt="" class="minicart-img" id="minicart-img">
            <div class="minicart-info">
                <p class="minicart-nome" id="minicart-nome"></p>
                <p class="minicart-prezzo" id="minicart-prezzo"></p>
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

{* ════════════════════════════════════════════════════════════
   MODAL 2: ACCESSO RICHIESTO (utente NON loggato)
   ════════════════════════════════════════════════════════════ *}
<div class="login-modal" id="login-modal" aria-hidden="true">
    <div class="modal-background"></div>

    <div class="login-modal-content">
        <button id="close-login-modal" class="modal-close-btn" type="button" aria-label="Chiudi pop-up">&times;</button>

        <div class="login-modal-icon">
            <i class="ti ti-lock"></i>
        </div>

        <h3 class="login-modal-title">Accedi per continuare</h3>
        <p class="login-modal-text">
            Devi avere un account per aggiungere prodotti al carrello e procedere all'acquisto.
        </p>

        <div class="login-modal-actions">
            <a href="{$base_url}/accedi" class="button btn-login-modal-accedi">
                <i class="ti ti-login"></i> Accedi
            </a>
            <a href="{$base_url}/registrati" class="button btn-login-modal-registrati">
                Crea un account
            </a>
        </div>
    </div>
</div>

{* ════════════════════════════════════════════════════════════
   MODAL 3: PRODOTTO NON DISPONIBILE
   ════════════════════════════════════════════════════════════ *}
<div class="unavailable-modal" id="unavailable-modal" aria-hidden="true">
    <div class="modal-background"></div>

    <div class="unavailable-modal-content">
        <button id="close-unavailable-modal" class="modal-close-btn" type="button" aria-label="Chiudi pop-up">&times;</button>

        <div class="unavailable-modal-icon">
            <i class="ti ti-ban"></i>
        </div>

        <h3 class="unavailable-modal-title">Prodotto non disponibile</h3>
        <p class="unavailable-modal-text" id="unavailable-modal-text">
            Questo prodotto non è al momento acquistabile.
        </p>

        <div class="unavailable-modal-actions">
            <a href="{$base_url}" class="button btn-unavailable-modal">
                <i class="ti ti-arrow-left"></i> Torna al catalogo
            </a>
        </div>
    </div>
</div>

{/block}

{block name="extra_js"}
<script>
    $(document).ready(function() {
        let currentSlide = 0;
        const totalSlides = 3;
        const $inner = $('#carousel-inner');

        function moveSlide(index) {
            currentSlide = (index + totalSlides) % totalSlides;
            $inner.css('transform', 'translateX(-' + (currentSlide * 100 / totalSlides) + '%)');
        }

        $('#next-slide').click(function() { moveSlide(currentSlide + 1); });
        $('#prev-slide').click(function() { moveSlide(currentSlide - 1); });

        setInterval(function() {
            moveSlide(currentSlide + 1);
        }, 5000);
    });
</script>


<script>
    // Percorso base del sito, valutato qui da Smarty prima del JS puro sotto.
    const baseUrl = "{$base_url}";

    {literal}

    function initHomeCartLogic() {

    const minicartModal  = document.getElementById('minicart-modal');
    const minicartImg     = document.getElementById('minicart-img');
    const minicartNome    = document.getElementById('minicart-nome');
    const minicartPrezzo  = document.getElementById('minicart-prezzo');

    function apriMinicart(dati) {
        if (!minicartModal) return;
        minicartImg.src = dati.img;
        minicartImg.alt = dati.nome;
        minicartNome.textContent = dati.nome;
        minicartPrezzo.textContent = '€' + parseFloat(dati.prezzo || 0).toFixed(2);

        minicartModal.classList.add('is-active');
        minicartModal.setAttribute('aria-hidden', 'false');
        document.getElementById('close-minicart')?.focus();
    }

    function chiudiMinicart() {
        if (!minicartModal) return;
        minicartModal.classList.remove('is-active');
        minicartModal.setAttribute('aria-hidden', 'true');
    }

    document.getElementById('close-minicart')?.addEventListener('click', function (e) {
        e.preventDefault();
        chiudiMinicart();
    });

    minicartModal?.querySelector('.modal-background')?.addEventListener('click', chiudiMinicart);

    minicartModal?.querySelectorAll('.minicart-actions a').forEach(function (btn) {
        btn.addEventListener('click', function (e) { e.stopPropagation(); });
    });

    const loginModal = document.getElementById('login-modal');

    function apriLoginModal() {
        if (!loginModal) return;
        loginModal.classList.add('is-active');
        loginModal.setAttribute('aria-hidden', 'false');
        document.getElementById('close-login-modal')?.focus();
    }

    function chiudiLoginModal() {
        if (!loginModal) return;
        loginModal.classList.remove('is-active');
        loginModal.setAttribute('aria-hidden', 'true');
    }

    document.getElementById('close-login-modal')?.addEventListener('click', function (e) {
        e.preventDefault();
        chiudiLoginModal();
    });

    loginModal?.querySelector('.modal-background')?.addEventListener('click', chiudiLoginModal);

    loginModal?.querySelectorAll('.login-modal-actions a').forEach(function (btn) {
        btn.addEventListener('click', function (e) { e.stopPropagation(); });
    });

    const unavailableModal = document.getElementById('unavailable-modal');
    const unavailableModalText = document.getElementById('unavailable-modal-text');

    function apriUnavailableModal(messaggio) {
        if (!unavailableModal) return;
        if (messaggio) {
            unavailableModalText.textContent = messaggio;
        }
        unavailableModal.classList.add('is-active');
        unavailableModal.setAttribute('aria-hidden', 'false');
        document.getElementById('close-unavailable-modal')?.focus();
    }

    function chiudiUnavailableModal() {
        if (!unavailableModal) return;
        unavailableModal.classList.remove('is-active');
        unavailableModal.setAttribute('aria-hidden', 'true');
    }

    document.getElementById('close-unavailable-modal')?.addEventListener('click', function (e) {
        e.preventDefault();
        chiudiUnavailableModal();
    });

    unavailableModal?.querySelector('.modal-background')?.addEventListener('click', chiudiUnavailableModal);

    unavailableModal?.querySelectorAll('.unavailable-modal-actions a').forEach(function (btn) {
        btn.addEventListener('click', function (e) { e.stopPropagation(); });
    });

    function aggiungiAlCarrello(idProdotto, quantita, dati) {
        fetch(baseUrl + '/carrello/aggiungi', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: 'id_prodotto=' + idProdotto + '&quantita=' + quantita
        })
        .then(function(res) {
            var status = res.status;
            return res.text().then(function(text) {
                var data = parseJsonSicuro(text);
                if (data === null) {
                    console.error('Risposta non interpretabile come JSON:', text);
                    return { status: status, body: { error: 'parse_error' } };
                }
                return { status: status, body: data };
            });
        })
        .then(function(result) {
            if (result.body.error === 'parse_error') {
                console.error('Errore tecnico nella risposta del server.');
                return;
            }
            if (result.status === 401 || result.body.error === 'auth_required') {
                apriLoginModal();
                return;
            }
            if (result.body.success !== false) {
                apriMinicart(dati);
                var cartBadge = document.getElementById('cart-count');
                if (cartBadge && result.body.cart_count !== undefined) {
                    cartBadge.textContent = result.body.cart_count;
                    cartBadge.style.display = result.body.cart_count > 0 ? 'inline' : 'none';
                }
            } else {
                apriUnavailableModal(result.body.message);
            }
        })
        .catch(function(err) {
            console.error('Fetch carrello fallita:', err);
        });
    }

    function parseJsonSicuro(text) {
        try {
            return JSON.parse(text);
        } catch (e) {
            var inizio = text.indexOf('{');
            var fine = text.lastIndexOf('}');
            if (inizio === -1 || fine === -1 || fine < inizio) {
                return null;
            }
            try {
                return JSON.parse(text.substring(inizio, fine + 1));
            } catch (e2) {
                return null;
            }
        }
    }

    document.querySelectorAll('.btn-cart').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            const dati = {
                id: this.dataset.id,
                nome: this.dataset.nome,
                img: this.dataset.img,
                prezzo: this.dataset.prezzo
            };

            aggiungiAlCarrello(dati.id, 1, dati);
        });
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initHomeCartLogic);
} else {
    initHomeCartLogic();
}

{/literal}

</script>

{/block}