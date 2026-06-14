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
        
        <div class="card-row-vector">
            {if isset($offerte) && $offerte|@count > 0}
                {foreach $offerte as $prodotto}
                    <div class="card-vector-item">
                        <a href="{$base_url}/prodotto/{$prodotto->getId()}" class="card-link-wrapper">
                            <div class="card home-card-fixed">
                                <div class="card-image">
                                    <figure class="image-container-fixed">
                                        <img src="{$base_url}/img/prodotti/{$prodotto->getImmagine()}" alt="{$prodotto->getNome()|escape}" />
                                    </figure>
                                </div>
                                <div class="card-content">
                                    <p class="card-title-custom">{$prodotto->getNome()|escape}</p>

                                    <div class="card-rating">
                                        {assign var="media" value=$prodotto->getValutazioneMedia()}
                                        {for $s=1 to 5}
                                            {if $s <= $media}
                                                <i class="ti ti-star-filled star-icon"></i>
                                            {elseif $s - $media < 1}
                                                <i class="ti ti-star-half-filled star-icon"></i>
                                            {else}
                                                <i class="ti ti-star star-icon"></i>
                                            {/if}
                                        {/for}
                                    </div>

                                    <div class="price-container">
                                        <span class="price">€{$prodotto->getPrezzo()}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                {/foreach}
                
                {* Card Vedi Altro per dati reali *}
                <div class="card-vector-item card-vector-more">
                    <a href="#" class="view-more-link">
                        <div class="circle-plus">
                            <span>+</span>
                        </div>
                        <span class="view-more-text">Vedi tutti</span>
                    </a>
                </div>

                            </div>
                        </a>
                    </div>
                {/foreach}
                
                {* Card Vedi Altro per dati reali *}
                <div class="card-vector-item card-vector-more">
                    <a href="#" class="view-more-link">
                        <div class="circle-plus">
                            <span>+</span>
                        </div>
                        <span class="view-more-text">Vedi tutti</span>
                    </a>
                </div>

            {else}
                {assign var="demo_items" value=[1, 2, 3, 4, 5]}
                {foreach $demo_items as $i}
                    <div class="card-vector-item">
                        <a href="#" class="card-link-wrapper">
                            <div class="card home-card-fixed">
                                <div class="card-image">
                                    <figure class="image-container-fixed">
                                        <img src="https://bulma.io/assets/images/placeholders/1280x960.png" alt="Placeholder image" />
                                    </figure>
                                </div>
                                <div class="card-content">
                                    <p class="card-title-custom">{$prodotto->getNome()|escape}</p>

                                    <div class="card-rating">
                                        {assign var="media" value=$prodotto->getValutazioneMedia()}
                                        {for $s=1 to 5}
                                            {if $s <= $media}
                                                <i class="ti ti-star-filled star-icon"></i>
                                            {elseif $s - $media < 1}
                                                <i class="ti ti-star-half-filled star-icon"></i>
                                            {else}
                                                <i class="ti ti-star star-icon"></i>
                                            {/if}
                                        {/for}
                                    </div>

                                    <div class="price-container">
                                        <span class="price">€{$prodotto->getPrezzo()}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                
                {/foreach}

                {* Card Vedi Altro per dati Demo *}
                <div class="card-vector-item card-vector-more">
                    <a href="#" class="more-link-wrapper" title="Vedi tutte le offerte">
                        <div class="more-circle-btn">
                            <span class="more-plus-icon">+</span>
                        </div>
                        <span class="more-text">Vedi tutte</span>
                    </a>
                </div>
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
                    <div class="card-vector-item">
                        <a href="{$base_url}/prodotto/{$prodotto->getId()}" class="card-link-wrapper">
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
                                            <p class="card-title-custom">{$prodotto->getNome()|escape}</p>
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
                        </a>
                    </div>
                {/foreach}

                {* Card Vedi Altro per dati reali *}
                <div class="card-vector-item card-vector-more">
                    <a href="{$base_url}/catalogo?ordinamento=novita" class="more-link-wrapper" title="Vedi tutti i nuovi arrivi">
                        <div class="more-circle-btn">
                            <span class="more-plus-icon">+</span>
                        </div>
                        <span class="more-text">Vedi tutti</span>
                    </a>
                </div>

            {else}
                {assign var="demo_arrivals" value=[1, 2, 3, 4, 5]}
                {foreach $demo_arrivals as $j}
                    <div class="card-vector-item">
                        <a href="#" class="card-link-wrapper">
                            <div class="card home-card-fixed">
                                <div class="card-image">
                                    <figure class="image-container-fixed">
                                        <img src="https://bulma.io/assets/images/placeholders/1280x960.png" alt="Placeholder image" />
                                    </figure>
                                </div>
                                <div class="card-content">
                                    <div class="media">
                                        <div class="media-left">
                                            <img src="{$base_url}/img/categorie/{$prodotto->getCategoriaIcona()}" class="editor-avatar" alt="Categoria" />
                                        </div>
                                        <div class="media-content">
                                            <p class="card-title-custom">{$prodotto->getNome()|escape}</p>
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
                        </a>
                    </div>
                {/foreach}

                {* Card Vedi Altro per dati Demo *}
                <div class="card-vector-item card-vector-more">
                    <a href="#" class="more-link-wrapper" title="Vedi tutti i nuovi arrivi">
                        <div class="more-circle-btn">
                            <span class="more-plus-icon">+</span>
                        </div>
                        <span class="more-text">Vedi tutti</span>
                    </a>
                </div>
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
