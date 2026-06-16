{extends file="common/layout.tpl"}

{block name="extra_css"}
    <link rel="stylesheet" href="{$base_url}/css/catalogo.css">
{/block}

{block name="content"}

<div class="catalogo-container">
    
    {* ── SEARCH BAR E HEADER CATALOGO ── *}
    <section class="catalogo-header">
        <div class="container">
            
            {* Search Form *}
            <div class="catalogo-search-wrapper">
                <form class="catalogo-search-form" action="{$base_url}/catalogo" method="get" id="search-form">
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

            {* Risultati + Ordinamento *}
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
                    <select id="sort-select" class="select catalogo-sort-select" name="ordinamento" onchange="document.getElementById('search-form').submit();">
                        <option value="rilevanza" {if isset($ordinamento) && $ordinamento == 'rilevanza'} selected{/if}>Rilevanza</option>
                        <option value="prezzo-asc" {if isset($ordinamento) && $ordinamento == 'prezzo-asc'} selected{/if}>Prezzo: crescente</option>
                        <option value="prezzo-desc" {if isset($ordinamento) && $ordinamento == 'prezzo-desc'} selected{/if}>Prezzo: decrescente</option>
                        <option value="novita" {if isset($ordinamento) && $ordinamento == 'novita'} selected{/if}>Novità</option>
                        <option value="popolarita" {if isset($ordinamento) && $ordinamento == 'popolarita'} selected{/if}>Più venduti</option>
                        <option value="rating" {if isset($ordinamento) && $ordinamento == 'rating'} selected{/if}>Valutazione</option>
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
                    <button class="filter-close-btn" id="filter-close-btn" aria-label="Chiudi filtri">
                        <i class="ti ti-x"></i>
                    </button>
                </div>

                <form class="filters-form" id="filters-form" method="get" action="{$base_url}/catalogo">
                    
                    {* Mantieni la ricerca durante i filtri *}
                    {if isset($search_query) && $search_query}
                        <input type="hidden" name="q" value="{$search_query|escape}">
                    {/if}
                    {if isset($ordinamento) && $ordinamento}
                        <input type="hidden" name="ordinamento" value="{$ordinamento|escape}">
                    {/if}

                    {* ── FILTRO: PREZZO ── *}
                    <div class="filter-group">
                        <h4 class="filter-group-title">
                            <i class="ti ti-currency-euro"></i> Prezzo
                        </h4>
                        <div class="price-range-wrapper">
                            <div class="price-inputs">
                                <input type="number" 
                                       class="input price-input price-min" 
                                       name="price_min" 
                                       placeholder="Min"
                                       value="{$price_min|default:''|escape}"
                                       min="0"
                                       aria-label="Prezzo minimo">
                                <span class="price-separator">—</span>
                                <input type="number" 
                                       class="input price-input price-max" 
                                       name="price_max" 
                                       placeholder="Max"
                                       value="{$price_max|default:''|escape}"
                                       min="0"
                                       aria-label="Prezzo massimo">
                            </div>
                            <input type="range" 
                                   class="range price-slider" 
                                   name="price_slider" 
                                   min="0" 
                                   max="500" 
                                   value="{$price_max|default:'500'|escape}"
                                   aria-label="Seleziona fascia di prezzo">
                        </div>
                    </div>

                    {* ── FILTRO: DISPONIBILITA' ── *}
                    <div class="filter-group">
                        <h4 class="filter-group-title">
                            <i class="ti ti-package"></i> Disponibilità
                        </h4>
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="radio" 
                                       name="disponibilita[]" 
                                       value="annunciato"
                                       {if isset($disponibilita) && in_array('annunciato', $disponibilita)} checked{/if}>
                                <span class="checkbox-text">Annunciato</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="radio" 
                                       name="disponibilita[]" 
                                       value="disponibile"
                                       {if isset($disponibilita) && in_array('disponibile', $disponibilita)} checked{/if}>
                                <span class="checkbox-text">Disponibile Subito</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="radio" 
                                       name="disponibilita[]" 
                                       value="esaurito"
                                       {if isset($disponibilita) && in_array('esaurito', $disponibilita)} checked{/if}>
                                <span class="checkbox-text">Esaurito</span>
                            </label>
                        </div>
                    </div>

                    {* ── FILTRO: OFFERTE ── *}
                    <div class="filter-group">
                        <h4 class="filter-group-title">
                            <i class="ti ti-tag"></i> Offerte
                        </h4>
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="radio" 
                                       name="offerte[]" 
                                       value="sconti"
                                       {if isset($offerte) && in_array('sconti', $offerte)} checked{/if}>
                                <span class="checkbox-text">Sconti Attivi</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="radio" 
                                       name="offerte[]" 
                                       value="bundle"
                                       {if isset($offerte) && in_array('bundle', $offerte)} checked{/if}>
                                <span class="checkbox-text">Bundle</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="radio" 
                                       name="offerte[]" 
                                       value="danneggiati"
                                       {if isset($offerte) && in_array('danneggiati', $offerte)} checked{/if}>
                                <span class="checkbox-text">Danneggiati / Scatolato</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="radio" 
                                       name="offerte[]" 
                                       value="novita"
                                       {if isset($offerte) && in_array('novita', $offerte)} checked{/if}>
                                <span class="checkbox-text">Novità</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="radio" 
                                       name="offerte[]" 
                                       value="venduti"
                                       {if isset($offerte) && in_array('venduti', $offerte)} checked{/if}>
                                <span class="checkbox-text">I più venduti</span>
                            </label>
                        </div>
                    </div>

                    {* ── FILTRO: CATEGORIA ── *}
                    <div class="filter-group">
                        <h4 class="filter-group-title">
                            <i class="ti ti-list"></i> Categoria
                        </h4>
                        <div class="checkbox-group">
                            {if isset($categorie) && $categorie|@count > 0}
                                {foreach $categorie as $cat}
                                    <label class="checkbox-label">
                                        <input type="checkbox" 
                                               name="categoria[]" 
                                               value="{$cat->getId()|escape}"
                                               {if isset($categoria_selected) && in_array($cat->getId(), $categoria_selected)} checked{/if}>
                                        <span class="checkbox-text">{$cat->getNome()|escape}</span>
                                    </label>
                                {/foreach}
                            {else}
                                <p class="no-options">Nessuna categoria disponibile</p>
                            {/if}
                        </div>
                    </div>

                    {* ── FILTRO: ESPANSIONI ── *}
                    <div class="filter-group">
                        <h4 class="filter-group-title">
                            <i class="ti ti-puzzle-2"></i> Espansioni
                        </h4>
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="radio" 
                                       name="espansioni" 
                                       value="si"
                                       {if isset($espansioni) && $espansioni == 'si'} checked{/if}>
                                <span class="checkbox-text">Solo base game</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="radio" 
                                       name="espansioni" 
                                       value="no"
                                       {if isset($espansioni) && $espansioni == 'no'} checked{/if}>
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
                                   placeholder="Da"
                                   value="{$age_min|default:''|escape}"
                                   min="0"
                                   max="18"
                                   aria-label="Età minima">
                            <span class="age-separator">—</span>
                            <input type="number" 
                                   class="input age-input" 
                                   name="age_max" 
                                   placeholder="A"
                                   value="{$age_max|default:''|escape}"
                                   min="0"
                                   max="99"
                                   aria-label="Età massima">
                        </div>
                    </div>

                    {* ── FILTRO: DIFFICOLTA' ── *}
                    <div class="filter-group">
                        <h4 class="filter-group-title">
                            <i class="ti ti-flame"></i> Difficoltà
                        </h4>
                        <div class="difficulty-options">
                            {assign var="difficolta_levels" value=['Facile', 'Media', 'Difficile', 'Molto difficile']}
                            {foreach $difficolta_levels as $level}
                                <label class="radio-label">
                                    <input type="radio" 
                                           name="difficolta" 
                                           value="{$level|lower}"
                                           {if isset($difficolta) && $difficolta == $level|lower} checked{/if}>
                                    <span class="radio-text">{$level}</span>
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
                                   placeholder="Min"
                                   value="{$players_min|default:''|escape}"
                                   min="1"
                                   aria-label="Numero giocatori minimo">
                            <span class="players-separator">—</span>
                            <input type="number" 
                                   class="input players-input" 
                                   name="players_max" 
                                   placeholder="Max"
                                   value="{$players_max|default:''|escape}"
                                   min="1"
                                   aria-label="Numero giocatori massimo">
                        </div>
                    </div>

                    {* ── FILTRO: LINGUA ── *}
                    <div class="filter-group">
                        <h4 class="filter-group-title">
                            <i class="ti ti-language"></i> Lingua
                        </h4>
                        <div class="language-options">
                            {assign var="lingue" value=['Italiano', 'English', 'Multilingue', 'Solo Immagini']}
                            {foreach $lingue as $lang}
                                <label class="radio-label">
                                    <input type="radio" 
                                           name="lingua" 
                                           value="{$lang|lower}"
                                           {if isset($lingua) && $lingua == $lang|lower} checked{/if}>
                                    <span class="radio-text">{$lang}</span>
                                </label>
                            {/foreach}
                        </div>
                    </div>

                    {* ── BOTTONI AZIONI FILTRI ── *}
                    <div class="filter-actions">
                        <button type="submit" class="button btn-apply-filters">
                            <i class="ti ti-check"></i> Applica Filtri
                        </button>
                        <a href="{$base_url}/catalogo" class="button btn-reset-filters">
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

                {* Grid Prodotti *}
                {if isset($prodotti) && $prodotti|@count > 0}
                    <div class="products-grid">
                        {foreach $prodotti as $prodotto}
                            <div class="product-card">
                                <a href="{$base_url}/prodotto/{$prodotto->getId()}" class="product-card-link">
                                    
                                    <div class="product-image-wrapper">
                                        <img src="{$base_url}/img/prodotti/{$prodotto->getImmagine()}" 
                                             alt="{$prodotto->getNome()|escape}" 
                                             class="product-image">
                                        
                                        {* Badge Disponibilità *}
                                        {if $prodotto->getDisponibilita() == 'esaurito'}
                                            <span class="product-badge product-badge-esaurito">Esaurito</span>
                                        {elseif $prodotto->getDisponibilita() == 'annunciato'}
                                            <span class="product-badge product-badge-annunciato">Annunciato</span>
                                        {/if}

                                        {* Badge Offerta *}
                                        {assign var="prezzo" value=$prodotto->getPrezzo()}
                                        {if isset($prezzo) && $prezzo->hasSconto()}
                                            <span class="product-badge product-badge-discount">-{$prezzo->getPercentualeSconto()}%</span>
                                        {/if}
                                    </div>

                                    <div class="product-info">
                                        <h3 class="product-name">{$prodotto->getNome()|escape}</h3>
                                        
                                        {* Rating *}
                                        <div class="product-rating">
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
                                            <span class="rating-value">({$media|number_format:1})</span>
                                        </div>

                                        {* Prezzo *}
                                        <div class="product-price-wrapper">
                                            {if isset($prezzo)}
                                                {if $prezzo->hasSconto()}
                                                    <span class="product-price">€{$prezzo->calcolaPrezzoScontato()|number_format:2}</span>
                                                    <span class="product-price-old">€{$prezzo->getValore()|number_format:2}</span>
                                                {else}
                                                    <span class="product-price">€{$prezzo->getValore()|number_format:2}</span>
                                                {/if}
                                            {else}
                                                <span class="product-price-unavailable">Prezzo N/D</span>
                                            {/if}
                                        </div>
                                    </div>

                                </a>

                                {* Bottone Carrello *}
                                <button class="button btn-add-cart" aria-label="Aggiungi a carrello">
                                    <i class="ti ti-shopping-cart"></i> Aggiungi
                                </button>
                            </div>
                        {/foreach}
                    </div>

                    {* Paginazione (se necessaria) *}
                    {if isset($pagination) && $pagination.total_pages > 1}
                    <div class="pagination-wrapper">
                        <nav class="pagination" aria-label="Paginazione">
                            {if $pagination.current_page > 1}
                                <a class="pagination-previous" href="{$base_url}/catalogo?page={$pagination.current_page - 1}{if isset($search_query)}&q={$search_query|escape}{/if}">
                                    <i class="ti ti-chevron-left"></i> Precedente
                                </a>
                            {/if}
                            
                            <ul class="pagination-list">
                                {for $i=1 to $pagination.total_pages}
                                    <li>
                                        {if $i == $pagination.current_page}
                                            <span class="pagination-link is-current" aria-label="Pagina {$i}" aria-current="page">{$i}</span>
                                        {else}
                                            <a class="pagination-link" aria-label="Vai a pagina {$i}" href="{$base_url}/catalogo?page={$i}{if isset($search_query)}&q={$search_query|escape}{/if}">{$i}</a>
                                        {/if}
                                    </li>
                                {/for}
                            </ul>

                            {if $pagination.current_page < $pagination.total_pages}
                                <a class="pagination-next" href="{$base_url}/catalogo?page={$pagination.current_page + 1}{if isset($search_query)}&q={$search_query|escape}{/if}">
                                    Successiva <i class="ti ti-chevron-right"></i>
                                </a>
                            {/if}
                        </nav>
                    </div>
                    {/if}

                {else}
                    {* Stato vuoto *}
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="ti ti-box-off"></i>
                        </div>
                        <h3 class="empty-state-title">Nessun prodotto trovato</h3>
                        <p class="empty-state-message">
                            Prova a modificare i filtri o la ricerca per trovare altri giochi da tavolo.
                        </p>
                        <a href="{$base_url}/catalogo" class="button btn-reset">
                            <i class="ti ti-refresh"></i> Vedi Catalogo Completo
                        </a>
                    </div>
                {/if}

            </main>

        </div>
    </div>

</div>

{/block}

{block name="extra_js"}
<script>
$(document).ready(function() {

    // Radio button deselezionabili
    var lastChecked = {};

    $('input[type="radio"]').on('click', function() {
        var name = $(this).attr('name');
        var value = $(this).val();

        if (lastChecked[name] === value) {
            // Stesso radio cliccato due volte → deseleziona
            $(this).prop('checked', false);
            lastChecked[name] = null;
        } else {
            lastChecked[name] = value;
        }
    });

    // Inizializza con eventuali radio già selezionati al caricamento
    $('input[type="radio"]:checked').each(function() {
        lastChecked[$(this).attr('name')] = $(this).val();
    });

    // Toggle Filtri su Mobile
    $('#btn-toggle-filters').click(function() {
        $('#catalogo-filters').toggleClass('is-open');
        $(this).toggleClass('is-active');
    });

    // Chiudi Filtri (mobile)
    $('#filter-close-btn').click(function() {
        $('#catalogo-filters').removeClass('is-open');
        $('#btn-toggle-filters').removeClass('is-active');
    });

    // Aggiorna valore rating in tempo reale
    $('.rating-slider').on('input', function() {
        $('#rating-value').text($(this).val());
    });

    // Chiudi filtri quando clicchi fuori (mobile)
    $(document).click(function(e) {
        const sidebar = $('#catalogo-filters');
        const btn = $('#btn-toggle-filters');
        if (!sidebar.is(e.target) && sidebar.has(e.target).length === 0 && 
            !btn.is(e.target) && btn.has(e.target).length === 0) {
            sidebar.removeClass('is-open');
            btn.removeClass('is-active');
        }
    });

});
</script>
{/block}