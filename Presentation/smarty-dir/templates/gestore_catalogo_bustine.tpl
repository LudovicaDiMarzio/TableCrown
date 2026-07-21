{*
  TableCrown\Presentation\Views\Gestore - Catalogo Bustine
  Estende layout_gestore.tpl.
  URL: GET /gestore/catalogo/bustine (CGestore::mostraCatalogoBustineGestore())

  Variabili di pagina attese:
    $prodotti => prodottiToArray() delle bustine
    $filtri => ['q'=>?, 'disponibilita'=>[], 'disponibilita_enum'=>[], 'ordinamento'=>?]
    $pagination => ['current_page'=>int, 'total_pages'=>int]
    $total_results => int
    $livelloDanno_enum => richiesto dal modale incluso sotto, ma la sezione "Danno" resta
      sempre nascosta qui (data-is-gioco="0"), quindi il valore può anche essere vuoto/omesso
*}
{extends file="layout_gestore.tpl"}

{block name="page_css"}
    <link rel="stylesheet" href="{$base_url}/css/eventi_gestore.css">
    <link rel="stylesheet" href="{$base_url}/css/gestore_prodotti.css">
    <link rel="stylesheet" href="{$base_url}/css/gestore_modifica_prodotto.css">
{/block}

{block name="content"}

<div class="gprod-container">

    <div class="gprod-header">
        <div class="gprod-header__titles">
            <h1 class="gprod-header__title">Bustine</h1>
            <p class="gprod-header__count">
                {assign var="tot" value=$total_results|default:0}
                {if $tot == 1}1 prodotto{else}{$tot} prodotti{/if}
            </p>
        </div>

        <div class="gprod-header__actions">
            <form class="gprod-search-form" action="{$base_url}/gestore/ricerca" method="get">
                <input class="gprod-search-input" type="search" name="q" placeholder="Cerca bustine..."
                       value="{if isset($filtri) && isset($filtri.q)}{$filtri.q|escape}{/if}" aria-label="Cerca prodotti">
                <button class="gprod-search-btn" type="submit" aria-label="Cerca">
                    <i class="ti ti-search"></i>
                </button>
            </form>

            <a href="{$base_url}/gestore/crea/bustine" class="gprod-btn-create">
                <i class="ti ti-plus"></i> Nuova Bustina
            </a>
        </div>
    </div>

    <div class="gprod-layout">

        <aside class="gprod-sidebar">
            <h3 class="gprod-filter-title"><i class="ti ti-filter"></i> Filtri</h3>

            <form method="get" action="{$base_url}/gestore/catalogo/bustine">

                <div class="gprod-filter-group">
                    <span class="gprod-filter-label">Disponibilità</span>
                    {assign var="dispSelezionati" value=$filtri.disponibilita|default:[]}
                    {foreach $filtri.disponibilita_enum|default:[] as $opt}
                        <label class="gprod-filter-checkbox">
                            <input type="checkbox" name="disponibilita[]" value="{$opt.value}"
                                   {if in_array($opt.value, $dispSelezionati)}checked{/if}
                                   onchange="this.form.submit()">
                            {$opt.label}
                        </label>
                    {/foreach}
                </div>

                <div class="gprod-filter-group">
                    <label class="gprod-filter-label" for="filtro-ordinamento">Ordina per</label>
                    <select class="gprod-filter-select" id="filtro-ordinamento" name="ordinamento" onchange="this.form.submit()">
                        <option value="">Predefinito</option>
                        <option value="prezzo-asc"  {if $filtri.ordinamento == 'prezzo-asc'}selected{/if}>Prezzo crescente</option>
                        <option value="prezzo-desc" {if $filtri.ordinamento == 'prezzo-desc'}selected{/if}>Prezzo decrescente</option>
                        <option value="popolarita"  {if $filtri.ordinamento == 'popolarita'}selected{/if}>Popolarità</option>
                        <option value="rating"      {if $filtri.ordinamento == 'rating'}selected{/if}>Valutazione</option>
                    </select>
                </div>

                <div class="gprod-filter-actions">
                    <a class="gprod-filter-reset" href="{$base_url}/gestore/catalogo/bustine">
                        <i class="ti ti-refresh"></i> Rimuovi filtri
                    </a>
                </div>
            </form>
        </aside>

        <main class="gprod-grid">
            {if isset($prodotti) && $prodotti|@count > 0}
                {foreach $prodotti as $prodotto}
                    <article class="gprod-card" data-id-prodotto="{$prodotto.id}">
                        <div class="gprod-card__img-wrapper">
                            <img src="{$prodotto.immagine}" alt="{$prodotto.nome|escape}" class="gprod-card__img">
                            <span class="gprod-card__status gprod-card__status--{$prodotto.disponibilita|lower|replace:' ':'_'}">{$prodotto.disponibilita}</span>
                            {if $prodotto.sconto}
                                <span class="gprod-card__discount">-{$prodotto.percentuale_sconto}%</span>
                            {/if}
                        </div>

                        <div class="gprod-card__body">
                            <span class="gprod-card__type">Bustine</span>
                            <h3 class="gprod-card__name">{$prodotto.nome|escape}</h3>

                            <div class="gprod-card__meta">
                                <span class="gprod-card__meta-row">
                                    <i class="ti ti-star-filled"></i> {$prodotto.valutazione_media|string_format:"%.1f"}
                                </span>
                                <span class="gprod-card__meta-row{if $prodotto.quantita <= 0} gprod-card__stock-empty{/if}">
                                    <i class="ti ti-package"></i> {$prodotto.quantita} in magazzino
                                </span>
                            </div>

                            <div class="gprod-card__prezzo">
                                {if $prodotto.sconto}
                                    <span class="gprod-card__prezzo-old">&euro;{$prodotto.prezzo|number_format:2}</span>
                                    <span class="gprod-card__prezzo-new">&euro;{$prodotto.prezzo_scontato|number_format:2}</span>
                                {else}
                                    <span class="gprod-card__prezzo-new">&euro;{$prodotto.prezzo|number_format:2}</span>
                                {/if}
                            </div>

                            <div class="gprod-card__stepper">
                                <button type="button" class="gprod-stepper__btn" data-delta="-1" onclick="aggiornaQuantita(this, -1)" aria-label="Diminuisci quantità">
                                    <i class="ti ti-minus"></i>
                                </button>
                                <span class="gprod-stepper__value">{$prodotto.quantita}</span>
                                <button type="button" class="gprod-stepper__btn" data-delta="1" onclick="aggiornaQuantita(this, 1)" aria-label="Aumenta quantità">
                                    <i class="ti ti-plus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="gprod-card__footer">
                            <button type="button" class="gprod-btn-edit gmp-btn-modifica"
                                data-id="{$prodotto.id}"
                                data-nome="{$prodotto.nome|escape}"
                                data-immagine="{$prodotto.immagine}"
                                data-prezzo="{$prodotto.prezzo}"
                                data-sconto="{if $prodotto.sconto}1{else}0{/if}"
                                data-percentuale-sconto="{$prodotto.percentuale_sconto|default:0}"
                                data-is-gioco="0">
                                <i class="ti ti-pencil"></i> Modifica
                            </button>
                            <button type="button" class="gprod-btn-delete" onclick="eliminaProdotto(this)">
                                <i class="ti ti-trash"></i>
                            </button>
                        </div>
                    </article>
                {/foreach}
            {else}
                <div class="gprod-empty">
                    <span class="gprod-empty__icon"><i class="ti ti-package-off"></i></span>
                    <h3 class="gprod-empty__title">Nessuna bustina trovata</h3>
                    <p class="gprod-empty__text">
                        {if isset($filtri) && ($filtri.q ?? false)}
                            Nessun risultato per la ricerca corrente.
                        {else}
                            Non è stata ancora pubblicata nessuna bustina.
                        {/if}
                    </p>
                    <a href="{$base_url}/gestore/crea/bustine" class="gprod-btn-create">
                        <i class="ti ti-plus"></i> Crea la prima bustina
                    </a>
                </div>
            {/if}
        </main>

    </div>

    {if isset($pagination) && $pagination.total_pages > 1}
        <nav class="gprod-pagination">
            {if $pagination.current_page > 1}
                <a href="?pagina={$pagination.current_page - 1}" class="gprod-pagination__link"><i class="ti ti-chevron-left"></i></a>
            {/if}
            <span class="gprod-pagination__current">Pagina {$pagination.current_page} di {$pagination.total_pages}</span>
            {if $pagination.current_page < $pagination.total_pages}
                <a href="?pagina={$pagination.current_page + 1}" class="gprod-pagination__link"><i class="ti ti-chevron-right"></i></a>
            {/if}
        </nav>
    {/if}

</div>

<script>
    function aggiornaQuantita(btn, delta) {
        var card = btn.closest('.gprod-card');
        var idProdotto = card.dataset.idProdotto;
        var valueEl = card.querySelector('.gprod-stepper__value');

        fetch('{$base_url}/gestore/prodotti/quantita', {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: new URLSearchParams({ id_prodotto: idProdotto, delta_quantita: delta })
        })
        .then(function (res) { return res.json(); })
        .then(function (data) {
            if (data.status === 'ok') {
                valueEl.textContent = data.quantita;
                var stockRow = card.querySelector('.gprod-card__meta-row:nth-child(2)');
                if (stockRow) {
                    stockRow.innerHTML = '<i class="ti ti-package"></i> ' + data.quantita + ' in magazzino';
                    stockRow.classList.toggle('gprod-card__stock-empty', data.quantita <= 0);
                }
            } else {
                alert(data.message || 'Errore durante l\'aggiornamento della quantità.');
            }
        })
        .catch(function () { alert('Errore di rete durante l\'aggiornamento della quantità.'); });
    }

    function eliminaProdotto(btn) {
        if (!confirm('Confermi la rimozione di questo prodotto dal catalogo?')) return;

        var card = btn.closest('.gprod-card');
        var idProdotto = card.dataset.idProdotto;

        fetch('{$base_url}/gestore/catalogo/prodotto/elimina', {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: new URLSearchParams({ id_prodotto: idProdotto })
        })
        .then(function (res) { return res.json(); })
        .then(function (data) {
            if (data.status === 'ok') {
                card.remove();
            } else {
                alert(data.message || 'Errore durante la rimozione del prodotto.');
            }
        })
        .catch(function () { alert('Errore di rete durante la rimozione del prodotto.'); });
    }
</script>

{include file="gestore_modifica_bustine.tpl"}

{/block}