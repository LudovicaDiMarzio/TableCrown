{extends file="common/layout.tpl"}

{block name="extra_css"}
    <link rel="stylesheet" href="{$base_url}/css/catalogo.css">
{/block}

{block name="content"}

<div class="catalogo-container">
    
    {* ── SEARCH BAR E HEADER CATALOGO ── *}
    <section class="catalogo-header">
        <div class="container">
            
            <div class="catalogo-search-wrapper">
                <form class="catalogo-search-form" action="{$base_url}/catalogo/giochi-da-tavolo" method="get" id="search-form">
                    <input class="input catalogo-search-input"
                           type="search"
                           name="q"
                           placeholder="Cerca nel catalogo..."
                           value="{$search_query|default:''|escape}"
                           aria-label="Cerca giochi da tavolo">
                    <button class="button catalogo-search-btn" type="submit" aria-label="Cerca">
                        <i class="ti ti-search"></i>
                    </button>
                </form>
            </div>

            <div class="catalogo-results-header">
                <div class="results-info">
                    <h2 class="results-title">
                        {if isset($search_query) && $search_query}
                            Risultati per "<strong>{$search_query|escape}</strong>"
                        {else}
                            Catalogo Completo
                        {/if}
                    </h2>
                    <p class="results-count">
                        {assign var="total" value=$total_results|default:0}
                        {if $total == 1}
                            1 risultato
                        {else}
                            {$total} risultati
                        {/if}
                    </p>
                </div>

                <div class="sort-wrapper">
                    <label for="sort-select" class="sort-label">Ordina per:</label>
                    {* form="filters-form" collega questa select al form della sidebar
                       anche se sta fisicamente altrove nel DOM *}
                    <select id="sort-select" class="select catalogo-sort-select" name="ordinamento" form="filters-form">
                        <option value="rilevanza"   {if isset($ordinamento) && $ordinamento == 'rilevanza'}   selected{/if}>Rilevanza</option>
                        <option value="prezzo-asc"  {if isset($ordinamento) && $ordinamento == 'prezzo-asc'}  selected{/if}>Prezzo: crescente</option>
                        <option value="prezzo-desc" {if isset($ordinamento) && $ordinamento == 'prezzo-desc'} selected{/if}>Prezzo: decrescente</option>
                        <option value="novita"      {if isset($ordinamento) && $ordinamento == 'novita'}      selected{/if}>Novità</option>
                        <option value="popolarita"  {if isset($ordinamento) && $ordinamento == 'popolarita'}  selected{/if}>Più venduti</option>
                        <option value="rating"      {if isset($ordinamento) && $ordinamento == 'rating'}      selected{/if}>Valutazione</option>
                    </select>
                </div>
            </div>

        </div>
    </section>

    {* ── LAYOUT PRINCIPALE: SIDEBAR + GRID ── *}
    <div class="container">
        <div class="catalogo-layout">

            {* ── SIDEBAR FILTRI ── *}
            <aside class="catalogo-sidebar" id="catalogo-filters">
                
                <div class="filter-header">
                    <h3 class="filter-title">Filtri</h3>
                    <div class="filter-header-actions">
                        <button class="filter-close-btn" id="filter-close-btn" aria-label="Chiudi filtri">
                            <i class="ti ti-x"></i>
                        </button>
                    </div>
                </div>

                <form class="filters-form" id="filters-form" method="get" action="{$base_url}/catalogo/giochi-da-tavolo">

                    {* Preserva la ricerca testuale quando si sottomettono i filtri *}
                    {if isset($search_query) && $search_query}
                        <input type="hidden" name="q" value="{$search_query|escape}">
                    {/if}

                    {* ── FILTRO: PREZZO ── *}
                    <div class="filter-group">
                        <h4 class="filter-group-title">
                            <i class="ti ti-currency-euro"></i> Prezzo
                        </h4>
                        <div class="price-range-wrapper">

                            <div class="price-values-display">
                                <span id="price-value-min">€{$price_min|default:$price_range_min|default:0}</span>
                                <span class="price-values-separator">—</span>
                                <span id="price-value-max">€{$price_max|default:$price_range_max|default:200}</span>
                            </div>

                            <div class="price-slider-container">
                                <div class="price-slider-track"></div>
                                <div class="price-slider-range" id="price-slider-range"></div>
                                <input type="range"
                                       class="price-range-input price-range-min"
                                       name="price_min"
                                       id="price-range-min"
                                       min="{$price_range_min|default:0}"
                                       max="{$price_range_max|default:200}"
                                       step="1"
                                       value="{$price_min|default:$price_range_min|default:0}"
                                       aria-label="Prezzo minimo">
                                <input type="range"
                                       class="price-range-input price-range-max"
                                       name="price_max"
                                       id="price-range-max"
                                       min="{$price_range_min|default:0}"
                                       max="{$price_range_max|default:200}"
                                       step="1"
                                       value="{$price_max|default:$price_range_max|default:200}"
                                       aria-label="Prezzo massimo">
                            </div>
                    
                        </div>
                    </div>

                    {* ── FILTRO: DISPONIBILITA' ── *}
                    <div class="filter-group">
                        <h4 class="filter-group-title">
                            <i class="ti ti-package"></i> Disponibilità
                        </h4>
                        <div class="checkbox-group" data-exclusive="disponibilita">
                            <label class="checkbox-label">
                                <input type="checkbox" 
                                       name="disponibilita[]" 
                                       value="disponibile"
                                       {if isset($disponibilita) && in_array('disponibile', $disponibilita)} checked{/if}>
                                <span class="checkbox-text">Disponibile Subito</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" 
                                       name="disponibilita[]" 
                                       value="in_arrivo"
                                       {if isset($disponibilita) && in_array('in_arrivo', $disponibilita)} checked{/if}>
                                <span class="checkbox-text">In Arrivo</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" 
                                       name="disponibilita[]" 
                                       value="esaurito"
                                       {if isset($disponibilita) && in_array('esaurito', $disponibilita)} checked{/if}>
                                <span class="checkbox-text">Esaurito</span>
                            </label>
                        </div>
                    </div>

                    {* ── FILTRO: IN EVIDENZA ── *}
                    <div class="filter-group">
                        <h4 class="filter-group-title">
                            <i class="ti ti-tag"></i> In Evidenza
                        </h4>
                        <div class="checkbox-group" data-exclusive="in_evidenza">
                            <label class="checkbox-label">
                                <input type="checkbox" 
                                       name="in_evidenza[]" 
                                       value="sconti"
                                       {if isset($in_evidenza_filtro) && in_array('sconti', $in_evidenza_filtro)} checked{/if}>
                                <span class="checkbox-text">Sconti Attivi</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" 
                                       name="in_evidenza[]" 
                                       value="novita"
                                       {if isset($in_evidenza_filtro) && in_array('novita', $in_evidenza_filtro)} checked{/if}>
                                <span class="checkbox-text">Novità</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" 
                                       name="in_evidenza[]" 
                                       value="venduti"
                                       {if isset($in_evidenza_filtro) && in_array('venduti', $in_evidenza_filtro)} checked{/if}>
                                <span class="checkbox-text">I più venduti</span>
                            </label>
                        </div>
                    </div>

                    {* ── FILTRO: CATEGORIA (enum Categoria) ──
                       NOTA: idealmente $categorie_enum va assegnato dal Controller
                       leggendo Categoria::cases(), non ridefinito qui nel tpl. ── *}
                    <div class="filter-group" id="categoria-filter-group">
                        <h4 class="filter-group-title">
                            <i class="ti ti-list"></i> Categoria
                        </h4>
                        <div class="checkbox-group" data-exclusive="categoria">
                            {foreach $categorie_enum as $cat}
                                <label class="checkbox-label">
                                    <input type="checkbox" 
                                           name="categoria[]" 
                                           value="{$cat.value|escape}"
                                           {if isset($categoria_selected) && in_array($cat.value, $categoria_selected)} checked{/if}>
                                    <span class="checkbox-text">{$cat.label|escape}</span>
                                </label>
                            {/foreach}
                        </div>
                    </div>

                    {* ── FILTRO: ESPANSIONI ── *}
                    <div class="filter-group">
                        <h4 class="filter-group-title">
                            <i class="ti ti-puzzle-2"></i> Espansioni
                        </h4>
                        <div class="checkbox-group" data-exclusive="espansioni">
                            <label class="checkbox-label">
                                <input type="checkbox" 
                                       name="solo_base_game" 
                                       value="1"
                                       {if $solo_base_game|default:false} checked{/if}>
                                <span class="checkbox-text">Solo base game</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" 
                                       name="solo_espansioni" 
                                       value="1"
                                       {if $solo_espansioni|default:false} checked{/if}>
                                <span class="checkbox-text">Solo espansioni</span>
                            </label>
                        </div>
                    </div>

                    {* ── FILTRO: VALUTAZIONE ── *}
                    <div class="filter-group">
                        <h4 class="filter-group-title">
                            <i class="ti ti-star"></i> Valutazione
                        </h4>
                        <div class="rating-range-wrapper">
                            <input type="range" 
                                   class="range rating-slider" 
                                   name="rating_min" 
                                   min="0" 
                                   max="5" 
                                   step="0.5"
                                   value="{$rating_min|default:'0'|escape}"
                                   aria-label="Valutazione minima">
                            <div class="rating-display">
                                <span id="rating-value">{$rating_min|default:'0'|escape}</span>
                                <span class="rating-max">/ 5</span>
                            </div>
                        </div>
                    </div>

                    {* ── FILTRO: ETA' ── *}
                    <div class="filter-group">
                        <h4 class="filter-group-title">
                            <i class="ti ti-baby-carriage"></i> Età
                        </h4>
                        <div class="age-inputs">
                            <input type="number" 
                                   class="input age-input" 
                                   name="age_min" 
                                   placeholder="Età minima"
                                   value="{$age_min|default:''|escape}"
                                   min="0"
                                   max="18"
                                   aria-label="Età minima">
                        </div>
                    </div>

                    {* ── FILTRO: DIFFICOLTA' ── *}
                    <div class="filter-group">
                        <h4 class="filter-group-title">
                            <i class="ti ti-flame"></i> Difficoltà
                        </h4>
                        <div class="checkbox-group" data-exclusive="difficolta">
                            {assign var="difficolta_levels" value=['Facile', 'Media', 'Difficile', 'Molto difficile']}
                            {foreach $difficolta_levels as $level}
                                <label class="checkbox-label">
                                    <input type="checkbox"
                                           name="difficolta[]"
                                           value="{$level|lower}"
                                           {if isset($difficolta) && in_array($level|lower, $difficolta)} checked{/if}>
                                    <span class="checkbox-text">{$level}</span>
                                </label>
                            {/foreach}
                        </div>
                    </div>

                    {* ── FILTRO: NUMERO GIOCATORI ── *}
                    <div class="filter-group">
                        <h4 class="filter-group-title">
                            <i class="ti ti-users"></i> Giocatori
                        </h4>
                        <div class="players-inputs">
                            <input type="number" 
                                   class="input players-input" 
                                   name="players_min" 
                                   placeholder="Numero minimo"
                                   value="{$players_min|default:''|escape}"
                                   min="1"
                                   aria-label="Numero giocatori minimo">
                        </div>
                    </div>

                    {* ── FILTRO: LINGUA (enum LinguaGioco) ── *}
                    <div class="filter-group">
                        <h4 class="filter-group-title">
                            <i class="ti ti-language"></i> Lingua
                        </h4>
                        <div class="checkbox-group" data-exclusive="lingua">
                            {foreach $lingue_enum as $lang}
                                <label class="checkbox-label">
                                    <input type="checkbox"
                                           name="lingua[]"
                                           value="{$lang.value|escape}"
                                           {if isset($lingua) && in_array($lang.value, $lingua)} checked{/if}>
                                    <span class="checkbox-text">{$lang.label|escape}</span>
                                </label>
                            {/foreach}
                        </div>
                    </div>

                    {* ── FILTRO: DANNO (enum LivelloDannoGiochi) ── *}
                    <div class="filter-group" id="danno-filter-group">
                        <h4 class="filter-group-title">
                            <i class="ti ti-alert-triangle"></i> Stato / Danno
                        </h4>
                        <div class="checkbox-group" data-exclusive="danno">
                            {foreach $danno_enum as $liv}
                                <label class="checkbox-label">
                                    <input type="checkbox"
                                           name="danno[]"
                                           value="{$liv.value|escape}"
                                           {if isset($danno) && in_array($liv.value, $danno)} checked{/if}>
                                    <span class="checkbox-text">{$liv.label|escape}</span>
                                </label>
                            {/foreach}
                        </div>
                    </div>

                    {* ── BOTTONE RESET FILTRI ── *}
                    <div class="filter-actions">
                        <a href="{$base_url}/catalogo/giochi-da-tavolo" class="button btn-reset-filters">
                            <i class="ti ti-refresh"></i> Ripristina
                        </a>
                    </div>

                </form>
                
            </aside>
                

            {* ── GRID PRINCIPALE PRODOTTI ── *}
            <main class="catalogo-main">

                {* Toggle Filtri Mobile *}
                <div class="catalogo-mobile-toggle">
                    <button class="button btn-toggle-filters" id="btn-toggle-filters">
                        <i class="ti ti-filter"></i> Mostra Filtri
                    </button>
                </div>

                {if isset($prodotti) && $prodotti|@count > 0}
                    <div class="products-grid">
                        {foreach $prodotti as $prodotto}
                            <div class="product-card">
                                <a href="{$base_url}/prodotto/{$prodotto.id}" class="product-card-link">
                                    
                                    <div class="product-image-wrapper">
                                        <img src="{$base_url}/img/prodotti/{$prodotto.immagine|escape}" 
                                             alt="{$prodotto.nome|escape}" 
                                             class="product-image">
                                        
                                        {if $prodotto.disponibilita == 'esaurito'}
                                            <span class="product-badge product-badge-esaurito">Esaurito</span>
                                        {elseif $prodotto.disponibilita == 'in_arrivo'}
                                            <span class="product-badge product-badge-in-arrivo">In Arrivo</span>
                                        {/if}

                                        {if $prodotto.sconto}
                                            <span class="product-badge product-badge-discount">-{$prodotto.percentuale_sconto}%</span>
                                        {/if}
                                    </div>

                                    <div class="product-info">
                                        <h3 class="product-name">{$prodotto.nome|escape}</h3>
                                        
                                        <div class="product-rating">
                                            {assign var="media" value=$prodotto.valutazione_media}
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
                                            <span class="rating-value">({$media|number_format:1})</span>
                                        </div>

                                        <div class="product-price-wrapper">
                                            {if isset($prodotto.prezzo)}
                                                {if $prodotto.sconto}
                                                    <span class="product-price">€{$prodotto.prezzo_scontato|number_format:2}</span>
                                                    <span class="product-price-old">€{$prodotto.prezzo|number_format:2}</span>
                                                {else}
                                                    <span class="product-price">€{$prodotto.prezzo|number_format:2}</span>
                                                {/if}
                                            {else}
                                                <span class="product-price-unavailable">Prezzo N/D</span>
                                            {/if}
                                        </div>
                                    </div>

                                </a>

                                <button class="button btn-add-cart"
                                        data-id="{$prodotto.id}"
                                        data-nome="{$prodotto.nome|escape}"
                                        data-img="{$base_url}/img/prodotti/{$prodotto.immagine}"
                                        data-prezzo="{$prodotto.prezzo}"
                                        aria-label="Aggiungi a carrello">
                                    <i class="ti ti-shopping-cart"></i> Aggiungi
                                </button>
                            </div>
                        {/foreach}
                    </div>

                    {if isset($pagination) && $pagination.total_pages > 1}
                    <div class="pagination-wrapper">
                        <nav class="pagination" aria-label="Paginazione">
                            {if $pagination.current_page > 1}
                                <a class="pagination-previous" href="{$base_url}/catalogo/giochi-da-tavolo?page={$pagination.current_page - 1}{if isset($search_query)}&q={$search_query|escape}{/if}">
                                    <i class="ti ti-chevron-left"></i> Precedente
                                </a>
                            {/if}
                            
                            <ul class="pagination-list">
                                {for $i=1 to $pagination.total_pages}
                                    <li>
                                        {if $i == $pagination.current_page}
                                            <span class="pagination-link is-current" aria-label="Pagina {$i}" aria-current="page">{$i}</span>
                                        {else}
                                            <a class="pagination-link" aria-label="Vai a pagina {$i}" href="{$base_url}/catalogo/giochi-da-tavolo?page={$i}{if isset($search_query)}&q={$search_query|escape}{/if}">{$i}</a>
                                        {/if}
                                    </li>
                                {/for}
                            </ul>

                            {if $pagination.current_page < $pagination.total_pages}
                                <a class="pagination-next" href="{$base_url}/catalogo/giochi-da-tavolo?page={$pagination.current_page + 1}{if isset($search_query)}&q={$search_query|escape}{/if}">
                                    Successiva <i class="ti ti-chevron-right"></i>
                                </a>
                            {/if}
                        </nav>
                    </div>
                    {/if}

                {else}
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="ti ti-box-off"></i>
                        </div>
                        <h3 class="empty-state-title">Nessun prodotto trovato</h3>
                        <p class="empty-state-message">
                            Prova a modificare i filtri o la ricerca per trovare altri giochi da tavolo.
                        </p>
                        <a href="{$base_url}/catalogo/giochi-da-tavolo" class="button btn-reset">
                            <i class="ti ti-refresh"></i> Vedi Catalogo Completo
                        </a>
                    </div>
                {/if}

            </main>

        </div>
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
                <a href="{$base_url}/catalogo/giochi-da-tavolo" class="button btn-minicart-continua">
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

</div>{* fine catalogo-container *}

{/block}

{block name="extra_js"}
<script>
{literal}
document.addEventListener('DOMContentLoaded', function() {

    var filtersForm = document.getElementById('filters-form');

    // ── CHECKBOX ESCLUSIVI ──
    var exclusiveGroups = document.querySelectorAll('[data-exclusive]');
    exclusiveGroups.forEach(function(group) {
        var checkboxes = group.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    checkboxes.forEach(function(cb) {
                        if (cb !== checkbox) cb.checked = false;
                    });
                }
            });
        });
    });

    // ── TOGGLE FILTRI MOBILE ──
    var toggleBtn = document.getElementById('btn-toggle-filters');
    var sidebar   = document.getElementById('catalogo-filters');
    var closeBtn  = document.getElementById('filter-close-btn');

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('is-open');
            toggleBtn.classList.toggle('is-active');
        });
    }
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            sidebar.classList.remove('is-open');
            if (toggleBtn) toggleBtn.classList.remove('is-active');
        });
    }
    document.addEventListener('click', function(e) {
        if (sidebar && toggleBtn) {
            if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                sidebar.classList.remove('is-open');
                toggleBtn.classList.remove('is-active');
            }
        }
    });

    // ── RATING SLIDER (display live) ──
    var ratingSlider = document.querySelector('.rating-slider');
    if (ratingSlider) {
        ratingSlider.addEventListener('input', function() {
            document.getElementById('rating-value').textContent = this.value;
        });
    }

    // ── DUAL PRICE SLIDER (display live) ──
    var priceMinSlider = document.getElementById('price-range-min');
    var priceMaxSlider = document.getElementById('price-range-max');
    var priceValueMin  = document.getElementById('price-value-min');
    var priceValueMax  = document.getElementById('price-value-max');
    var priceRangeFill = document.getElementById('price-slider-range');

    if (priceMinSlider && priceMaxSlider) {

        var sliderMin = parseFloat(priceMinSlider.min);
        var sliderMax = parseFloat(priceMinSlider.max);

        function updatePriceRangeFill() {
            var minVal = parseFloat(priceMinSlider.value);
            var maxVal = parseFloat(priceMaxSlider.value);
            var range  = sliderMax - sliderMin || 1;

            var leftPct  = ((minVal - sliderMin) / range) * 100;
            var rightPct = ((maxVal - sliderMin) / range) * 100;

            priceRangeFill.style.left  = leftPct + '%';
            priceRangeFill.style.right = (100 - rightPct) + '%';

            priceValueMin.textContent = '€' + minVal;
            priceValueMax.textContent = '€' + maxVal;
        }

        priceMinSlider.addEventListener('input', function() {
            var minVal = parseFloat(priceMinSlider.value);
            var maxVal = parseFloat(priceMaxSlider.value);
            if (minVal > maxVal) {
                priceMinSlider.value = maxVal;
            }
            updatePriceRangeFill();
        });

        priceMaxSlider.addEventListener('input', function() {
            var minVal = parseFloat(priceMinSlider.value);
            var maxVal = parseFloat(priceMaxSlider.value);
            if (maxVal < minVal) {
                priceMaxSlider.value = minVal;
            }
            updatePriceRangeFill();
        });

        updatePriceRangeFill();
    }

    // ══════════════════════════════════════════════════════════
    //  AUTO-SUBMIT DEI FILTRI (nessun bottone "Applica")
    // ══════════════════════════════════════════════════════════

    function debounce(fn, delay) {
        var timer = null;
        return function() {
            clearTimeout(timer);
            timer = setTimeout(fn, delay);
        };
    }

    function submitFilters() {
        filtersForm.submit();
    }

    var submitDebounced = debounce(submitFilters, 600);

    // Checkbox e select: submit immediato al cambio
    filtersForm.querySelectorAll('input[type="checkbox"]').forEach(function(el) {
        el.addEventListener('change', submitFilters);
    });

    // Range (prezzo, rating): submit solo al rilascio dello slider (evento "change"),
    // non durante il trascinamento (evento "input")
    filtersForm.querySelectorAll('input[type="range"]').forEach(function(el) {
        el.addEventListener('change', submitFilters);
    });

    // Campi numerici (età, giocatori): submit con debounce mentre si digita,
    // così non si ricarica la pagina ad ogni singolo carattere
    filtersForm.querySelectorAll('input[type="number"]').forEach(function(el) {
        el.addEventListener('input', submitDebounced);
    });

    // Select ordinamento: sta fuori dal DOM del form ma è collegata
    // tramite l'attributo form="filters-form" → submit immediato al cambio
    var sortSelect = document.getElementById('sort-select');
    if (sortSelect) {
        sortSelect.addEventListener('change', submitFilters);
    }

    // ── MODAL: MINICART ──
    var minicartModal  = document.getElementById('minicart-modal');
    var minicartImg    = document.getElementById('minicart-img');
    var minicartNome   = document.getElementById('minicart-nome');
    var minicartPrezzo = document.getElementById('minicart-prezzo');

    function apriMinicart(dati) {
        if (!minicartModal) return;
        minicartImg.src            = dati.img;
        minicartImg.alt            = dati.nome;
        minicartNome.textContent   = dati.nome;
        minicartPrezzo.textContent = '€' + parseFloat(dati.prezzo || 0).toFixed(2);
        minicartModal.classList.add('is-active');
        minicartModal.setAttribute('aria-hidden', 'false');
        var cm = document.getElementById('close-minicart');
        if (cm) cm.focus();
    }

    function chiudiMinicart() {
        if (!minicartModal) return;
        minicartModal.classList.remove('is-active');
        minicartModal.setAttribute('aria-hidden', 'true');
    }

    var closeMinicart = document.getElementById('close-minicart');
    if (closeMinicart) {
        closeMinicart.addEventListener('click', function(e) {
            e.preventDefault();
            chiudiMinicart();
        });
    }
    var minicartBg = minicartModal ? minicartModal.querySelector('.modal-background') : null;
    if (minicartBg) minicartBg.addEventListener('click', chiudiMinicart);
    if (minicartModal) {
        minicartModal.querySelectorAll('.minicart-actions a').forEach(function(btn) {
            btn.addEventListener('click', function(e) { e.stopPropagation(); });
        });
    }

    // ── MODAL: LOGIN ──
    var loginModal = document.getElementById('login-modal');

    function apriLoginModal() {
        if (!loginModal) return;
        loginModal.classList.add('is-active');
        loginModal.setAttribute('aria-hidden', 'false');
        var cl = document.getElementById('close-login-modal');
        if (cl) cl.focus();
    }

    function chiudiLoginModal() {
        if (!loginModal) return;
        loginModal.classList.remove('is-active');
        loginModal.setAttribute('aria-hidden', 'true');
    }

    var closeLogin = document.getElementById('close-login-modal');
    if (closeLogin) {
        closeLogin.addEventListener('click', function(e) {
            e.preventDefault();
            chiudiLoginModal();
        });
    }
    var loginBg = loginModal ? loginModal.querySelector('.modal-background') : null;
    if (loginBg) loginBg.addEventListener('click', chiudiLoginModal);
    if (loginModal) {
        loginModal.querySelectorAll('.login-modal-actions a').forEach(function(btn) {
            btn.addEventListener('click', function(e) { e.stopPropagation(); });
        });
    }

    // ── AJAX CARRELLO ──
    function aggiungiAlCarrello(idProdotto, quantita, dati) {
        fetch('/carrello/aggiungi', {
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
                try {
                    var data = JSON.parse(text);
                    return { status: status, body: data };
                } catch(e) {
                    return { status: 401, body: { error: 'auth_required' } };
                }
            });
        })
        .then(function(result) {
            if (result.status === 401 || result.body.error === 'auth_required') {
                apriLoginModal();
                return;
            }
            if (result.body.success) {
                apriMinicart(dati);
                var cartBadge = document.getElementById('cart-count');
                if (cartBadge && result.body.cart_count !== undefined) {
                    cartBadge.textContent = result.body.cart_count;
                    cartBadge.style.display = result.body.cart_count > 0 ? 'inline' : 'none';
                }
            } else {
                console.error('Errore carrello:', result.body.messaggio || 'errore generico');
            }
        })
        .catch(function(err) {
            console.error('Fetch carrello fallita:', err);
        });
    }

    // ── CLICK BOTTONI AGGIUNGI ──
    document.querySelectorAll('.btn-add-cart').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var dati = {
                id:     this.dataset.id,
                nome:   this.dataset.nome,
                img:    this.dataset.img,
                prezzo: this.dataset.prezzo
            };
            aggiungiAlCarrello(dati.id, 1, dati);
        });
    });

});
{/literal}
</script>
{/block}
