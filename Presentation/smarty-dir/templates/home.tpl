{extends file="common/layout.tpl"}

{block name="content"}
<div class="container px-4">

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
        
        <div class="columns is-multiline is-mobile is-tablet is-desktop">
            {if isset($offerte) && $offerte|@count > 0}
                {foreach $offerte as $prodotto}
                    <div class="column is-3-desktop is-6-tablet is-12-mobile">
                        <div class="card home-card-fixed">
                            <div class="card-image">
                                <figure class="image-container-fixed">
                                    <img src="{$base_url}/img/prodotti/{$prodotto->getImmagine()}" alt="{$prodotto->getNome()|escape}" />
                                </figure>
                            </div>
                            <div class="card-content">
                                <div class="media">
                                    <div class="media-left">
                                        <img src="{$base_url}/img/categorie/{$prodotto->getCategoriaIcona()}" class="editor-avatar" alt="Categoria" />
                                    </div>
                                    <div class="media-content">
                                        <p class="title">{$prodotto->getNome()|escape}</p>
                                        <p class="subtitle">{$prodotto->getEditore()|escape}</p>
                                    </div>
                                </div>
                                
                                <p class="game-description">
                                    {$prodotto->getDescrizioneBreve()|escape}
                                </p>
                                
                                <div class="price-container">
                                    <span class="price">€{$prodotto->getPrezzoScontato()}</span>
                                    <span class="price-old">€{$prodotto->getPrezzoListino()}</span>
                                </div>
                                
                                <div class="footer-card-custom">
                                    <time datetime="{$prodotto->getDataScadenza()}">
                                        <i class="ti ti-clock"></i> Scade il: {$prodotto->getDataScadenzaFormat()|escape}
                                    </time>
                                </div>
                            </div>
                        </div>
                    </div>
                {/foreach}
            {else}
                {assign var="demo_items" value=[1, 2, 3, 4]}
                {foreach $demo_items as $i}
                    <div class="column is-3-desktop is-6-tablet is-12-mobile">
                        <div class="card home-card-fixed">
                            <div class="card-image">
                                <figure class="image-container-fixed">
                                    <img src="https://bulma.io/assets/images/placeholders/1280x960.png" alt="Placeholder image" />
                                </figure>
                            </div>
                            <div class="card-content">
                                <div class="media">
                                    <div class="media-left">
                                        <img src="https://bulma.io/assets/images/placeholders/96x96.png" class="editor-avatar" alt="Placeholder image" />
                                    </div>
                                    <div class="media-content">
                                        <p class="title">Gioco in Offerta {$i}</p>
                                        <p class="subtitle">Editore Demo</p>
                                    </div>
                                </div>
                                
                                <p class="game-description">
                                    Offerta incredibile a tempo limitato. Aggiungi subito al carrello TableCrown.
                                </p>
                                
                                <div class="price-container">
                                    <span class="price">€29.90</span>
                                    <span class="price-old">€49.90</span>
                                </div>
                                
                                <div class="footer-card-custom">
                                    <time datetime="2026-06-15"><i class="ti ti-clock"></i> 11:59 PM - 15 Giu 2026</time>
                                </div>
                            </div>
                        </div>
                    </div>
                {/foreach}
            {/if}
        </div>
    </section>

    {* ──────────────────────────────────────────── *}
    {* 3. ZONA: NUOVI ARRIVI                        *}
    {* ──────────────────────────────────────────── *}
    <section class="home-section">
        <h2 class="title section-title is-4 text-uppercase">✨ Nuovi Arrivi</h2>
        
        <div class="columns is-multiline is-mobile is-tablet is-desktop">
            {if isset($nuovi_arrivi) && $nuovi_arrivi|@count > 0}
                {foreach $nuovi_arrivi as $prodotto}
                    <div class="column is-3-desktop is-6-tablet is-12-mobile">
                        <div class="card home-card-fixed">
                            <div class="card-image">
                                <figure class="image-container-fixed">
                                    <img src="{$base_url}/img/prodotti/{$prodotto->getImmagine()}" alt="{$prodotto->getNome()|escape}" />
                                </figure>
                            </div>
                            <div class="card-content">
                                <div class="media">
                                    <div class="media-left">
                                        <img src="{$base_url}/img/categorie/{$prodotto->getCategoriaIcona()}" class="editor-avatar" alt="Categoria" />
                                    </div>
                                    <div class="media-content">
                                        <p class="title">{$prodotto->getNome()|escape}</p>
                                        <p class="subtitle">{$prodotto->getEditore()|escape}</p>
                                    </div>
                                </div>
                                
                                <p class="game-description">
                                    {$prodotto->getDescrizioneBreve()|escape}
                                </p>
                                
                                <div class="price-container">
                                    <span class="price">€{$prodotto->getPrezzo()}</span>
                                </div>
                                
                                <div class="footer-card-custom">
                                    <time datetime="{$prodotto->getDataInserimento()}">
                                        <i class="ti ti-calendar"></i> Disponibile da oggi
                                    </time>
                                </div>
                            </div>
                        </div>
                    </div>
                {/foreach}
            {else}
                {assign var="demo_arrivals" value=[1, 2, 3, 4]}
                {foreach $demo_arrivals as $j}
                    <div class="column is-3-desktop is-6-tablet is-12-mobile">
                        <div class="card home-card-fixed">
                            <div class="card-image">
                                <figure class="image-container-fixed">
                                    <img src="https://bulma.io/assets/images/placeholders/1280x960.png" alt="Placeholder image" />
                                </figure>
                            </div>
                            <div class="card-content">
                                <div class="media">
                                    <div class="media-left">
                                        <img src="https://bulma.io/assets/images/placeholders/96x96.png" class="editor-avatar" alt="Placeholder image" />
                                    </div>
                                    <div class="media-content">
                                        <p class="title">Nuovo Arrivo {$j}</p>
                                        <p class="subtitle">Editore Demo</p>
                                    </div>
                                </div>
                                
                                <p class="game-description">
                                    Appena arrivato in magazzino. Scopri le meccaniche e i components di alta qualità.
                                </p>
                                
                                <div class="price-container">
                                    <span class="price">€39.90</span>
                                </div>
                                
                                <div class="footer-card-custom">
                                    <time datetime="2026-06-12"><i class="ti ti-calendar"></i> Caricato il: 12 Giu 2026</time>
                                </div>
                            </div>
                        </div>
                    </div>
                {/foreach}
            {/if}
        </div>
    </section>

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
{/block}