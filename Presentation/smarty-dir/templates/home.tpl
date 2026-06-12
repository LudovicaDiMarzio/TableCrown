{extends file="common/layout.tpl"}

{block name="content"}
<div class="container px-4">

    {* 1. CAROSELLO IMMAGINI *}
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

    {* 2. ZONA: OFFERTE IN SCADENZA *}
    <section class="home-section">
        <h2 class="title section-title is-4 text-uppercase">🔥 Offerte in Scadenza</h2>
        
        <div class="columns is-multiline is-desktop">
            {if isset($offerte) && $offerte|@count > 0}
                {foreach $offerte as $prodotto}
                    <div class="column is-3-desktop is-6-tablet is-12-mobile">
                        <div class="card home-card-fixed">
                            <div class="card-image">
                                <figure class="image is-4by3">
                                    <img src="{$base_url}/img/prodotti/{$prodotto->getImmagine()}" alt="{$prodotto->getNome()|escape}" />
                                </figure>
                            </div>
                            <div class="card-content">
                                <div class="media mb-3">
                                    <div class="media-left">
                                        <figure class="image is-48x48">
                                            <img src="{$base_url}/img/categorie/{$prodotto->getCategoriaIcona()}" alt="Categoria" />
                                        </figure>
                                    </div>
                                    <div class="media-content">
                                        <p class="title is-5 mb-1">{$prodotto->getNome()|escape}</p>
                                        <p class="subtitle is-6 has-text-muted">{$prodotto->getEditore()|escape}</p>
                                    </div>
                                </div>
                                <div class="content">
                                    {$prodotto->getDescrizioneBreve()|escape}
                                    <br />
                                    <div class="mt-3">
                                        <span class="has-text-danger font-weight-bold title is-5">€{$prodotto->getPrezzoScontato()}</span>
                                        <span class="has-text-muted text-decoration-line-through is-size-7 ml-2">€{$prodotto->getPrezzoListino()}</span>
                                    </div>
                                    <hr class="my-2">
                                    <time class="is-size-7 has-text-danger" datetime="{$prodotto->getDataScadenza()}">
                                        <i class="ti ti-clock"></i> Scade il: {$prodotto->getDataScadenzaFormat()|escape}
                                    </time>
                                </div>
                            </div>
                        </div>
                    </div>
                {/foreach}
            {else}
                {foreach range(1, 4) as $i}
                    <div class="column is-3-desktop is-6-tablet is-12-mobile">
                        <div class="card home-card-fixed">
                            <div class="card-image">
                                <figure class="image is-4by3">
                                    <img src="https://bulma.io/assets/images/placeholders/1280x960.png" alt="Placeholder image" />
                                </figure>
                            </div>
                            <div class="card-content">
                                <div class="media mb-3">
                                    <div class="media-left">
                                        <figure class="image is-48x48">
                                            <img src="https://bulma.io/assets/images/placeholders/96x96.png" alt="Placeholder image" />
                                        </figure>
                                    </div>
                                    <div class="media-content">
                                        <p class="title is-5 mb-1">Gioco in Offerta {$i}</p>
                                        <p class="subtitle is-6 has-text-muted">Editore Demo</p>
                                    </div>
                                </div>
                                <div class="content">
                                    Offerta incredibile a tempo limitato. Aggiungi subito al carrello TableCrown.
                                    <br />
                                    <div class="mt-3">
                                        <span class="has-text-danger is-size-5 font-weight-bold">€29.90</span>
                                        <span class="has-text-muted is-size-7 ml-2" style="text-decoration: line-through;">€49.90</span>
                                    </div>
                                    <hr class="my-2">
                                    <time class="is-size-7 has-text-danger" datetime="2026-06-15">11:59 PM - 15 Giu 2026</time>
                                </div>
                            </div>
                        </div>
                    </div>
                {/foreach}
            {/if}
        </div>
    </section>

    {* 3. ZONA: NUOVI ARRIVI *}
    <section class="home-section">
        <h2 class="title section-title is-4 text-uppercase">✨ Nuovi Arrivi</h2>
        
        <div class="columns is-multiline is-desktop">
            {if isset($nuovi_arrivi) && $nuovi_arrivi|@count > 0}
                {foreach $nuovi_arrivi as $prodotto}
                    <div class="column is-3-desktop is-6-tablet is-12-mobile">
                        <div class="card home-card-fixed">
                            <div class="card-image">
                                <figure class="image is-4by3">
                                    <img src="{$base_url}/img/prodotti/{$prodotto->getImmagine()}" alt="{$prodotto->getNome()|escape}" />
                                </figure>
                            </div>
                            <div class="card-content">
                                <div class="media mb-3">
                                    <div class="media-left">
                                        <figure class="image is-48x48">
                                            <img src="{$base_url}/img/categorie/{$prodotto->getCategoriaIcona()}" alt="Categoria" />
                                        </figure>
                                    </div>
                                    <div class="media-content">
                                        <p class="title is-5 mb-1">{$prodotto->getNome()|escape}</p>
                                        <p class="subtitle is-6 has-text-muted">{$prodotto->getEditore()|escape}</p>
                                    </div>
                                </div>
                                <div class="content">
                                    {$prodotto->getDescrizioneBreve()|escape}
                                    <br />
                                    <div class="mt-3">
                                        <span class="has-text-dark font-weight-bold title is-5">€{$prodotto->getPrezzo()}</span>
                                    </div>
                                    <hr class="my-2">
                                    <time class="is-size-7 has-text-muted" datetime="{$prodotto->getDataInserimento()}">
                                        <i class="ti ti-calendar"></i> Disponibile da oggi
                                    </time>
                                </div>
                            </div>
                        </div>
                    </div>
                {/foreach}
            {else}
                {foreach range(1, 4) as $i}
                    <div class="column is-3-desktop is-6-tablet is-12-mobile">
                        <div class="card home-card-fixed">
                            <div class="card-image">
                                <figure class="image is-4by3">
                                    <img src="https://bulma.io/assets/images/placeholders/1280x960.png" alt="Placeholder image" />
                                </figure>
                            </div>
                            <div class="card-content">
                                <div class="media mb-3">
                                    <div class="media-left">
                                        <figure class="image is-48x48">
                                            <img src="https://bulma.io/assets/images/placeholders/96x96.png" alt="Placeholder image" />
                                        </figure>
                                    </div>
                                    <div class="media-content">
                                        <p class="title is-5 mb-1">Nuovo Arrivo {$i}</p>
                                        <p class="subtitle is-6 has-text-muted">Editore Demo</p>
                                    </div>
                                </div>
                                <div class="content">
                                    Appena arrivato in magazzino. Scopri le meccaniche e i componenti di alta qualità.
                                    <br />
                                    <div class="mt-3">
                                        <span class="has-text-dark is-size-5 font-weight-bold">€39.90</span>
                                    </div>
                                    <hr class="my-2">
                                    <time class="is-size-7 has-text-muted" datetime="2026-06-12">Caricato il: 12 Giu 2026</time>
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