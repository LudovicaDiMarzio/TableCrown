<?php
/* Smarty version 5.8.0, created on 2026-07-17 17:08:00
  from 'file:catalogo/portadadi.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a5a4550d8b966_03383622',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7ce7b42214e29d89348e5a2868b9617553b99e40' => 
    array (
      0 => 'catalogo/portadadi.tpl',
      1 => 1784295776,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a5a4550d8b966_03383622 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates\\catalogo';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_12943741176a5a4550d28238_53110255', "extra_css");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_9138749146a5a4550d2dee0_11785121', "content");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_14128195096a5a4550d8a922_64684285', "extra_js");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "extra_css"} */
class Block_12943741176a5a4550d28238_53110255 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates\\catalogo';
?>

    <link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/css/catalogo.css">
<?php
}
}
/* {/block "extra_css"} */
/* {block "content"} */
class Block_9138749146a5a4550d2dee0_11785121 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates\\catalogo';
?>


<div class="catalogo-container">

        <section class="catalogo-header">
        <div class="container">

            <div class="catalogo-search-wrapper">
                <form class="catalogo-search-form" action="<?php echo $_smarty_tpl->getValue('base_url');?>
/catalogo/portadadi" method="get" id="search-form">
                    <input class="input catalogo-search-input"
                           type="search"
                           name="q"
                           placeholder="Cerca nel catalogo..."
                           value="<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('filtri')['q'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
"
                           aria-label="Cerca portadadi">
                    <button class="button catalogo-search-btn" type="submit" aria-label="Cerca">
                        <i class="ti ti-search"></i>
                    </button>
                </form>
            </div>

            <div class="catalogo-results-header">
                <div class="results-info">
                    <h2 class="results-title">
                        <?php if ((true && (true && null !== ($_smarty_tpl->getValue('filtri')['q'] ?? null))) && $_smarty_tpl->getValue('filtri')['q']) {?>
                            Risultati per "<strong><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('filtri')['q'], ENT_QUOTES, 'UTF-8', true);?>
</strong>"
                        <?php } else { ?>
                            Catalogo Completo
                        <?php }?>
                    </h2>
                    <p class="results-count">
                        <?php $_smarty_tpl->assign('total', (($tmp = $_smarty_tpl->getValue('total_results') ?? null)===null||$tmp==='' ? 0 ?? null : $tmp), false, NULL);?>
                        <?php if ($_smarty_tpl->getValue('total') == 1) {?>
                            1 risultato
                        <?php } else { ?>
                            <?php echo $_smarty_tpl->getValue('total');?>
 risultati
                        <?php }?>
                    </p>
                </div>

                <div class="sort-wrapper">
                    <label for="sort-select" class="sort-label">Ordina per:</label>
                    <select id="sort-select" class="select catalogo-sort-select" name="ordinamento" form="filters-form">
                        <option value="prezzo-asc"  <?php if ((true && (true && null !== ($_smarty_tpl->getValue('filtri')['ordinamento'] ?? null))) && $_smarty_tpl->getValue('filtri')['ordinamento'] == 'prezzo-asc') {?>  selected<?php }?>>Prezzo: crescente</option>
                        <option value="prezzo-desc" <?php if ((true && (true && null !== ($_smarty_tpl->getValue('filtri')['ordinamento'] ?? null))) && $_smarty_tpl->getValue('filtri')['ordinamento'] == 'prezzo-desc') {?> selected<?php }?>>Prezzo: decrescente</option>
                        <option value="popolarita"  <?php if ((true && (true && null !== ($_smarty_tpl->getValue('filtri')['ordinamento'] ?? null))) && $_smarty_tpl->getValue('filtri')['ordinamento'] == 'popolarita') {?>  selected<?php }?>>Più venduti</option>
                        <option value="rating"      <?php if ((true && (true && null !== ($_smarty_tpl->getValue('filtri')['ordinamento'] ?? null))) && $_smarty_tpl->getValue('filtri')['ordinamento'] == 'rating') {?>      selected<?php }?>>Valutazione</option>
                    </select>
                </div>
            </div>

        </div>
    </section>

        <div class="container">
        <div class="catalogo-layout">

                        <aside class="catalogo-sidebar" id="catalogo-filters">

                <div class="filter-header">
                    <h3 class="filter-title">Filtri</h3>
                    <div class="filter-header-actions">
                        <button class="filter-close-btn" id="filter-close-btn" aria-label="Chiudi filtri">
                            <i class="ti ti-x"></i>
                        </button>
                    </div>
                </div>

                <form class="filters-form" id="filters-form" method="get" action="<?php echo $_smarty_tpl->getValue('base_url');?>
/catalogo/portadadi">

                    <?php if ((true && (true && null !== ($_smarty_tpl->getValue('filtri')['q'] ?? null))) && $_smarty_tpl->getValue('filtri')['q']) {?>
                        <input type="hidden" name="q" value="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('filtri')['q'], ENT_QUOTES, 'UTF-8', true);?>
">
                    <?php }?>

                                        <div class="filter-group">
                        <h4 class="filter-group-title">
                            <i class="ti ti-currency-euro"></i> Prezzo
                        </h4>
                        <div class="price-range-wrapper">

                            <div class="price-values-display">
                                <span id="price-value-min">€<?php echo (($tmp = (($tmp = $_smarty_tpl->getValue('filtri')['price_min'] ?? null)===null||$tmp==='' ? $_smarty_tpl->getValue('price_range_min') ?? null : $tmp) ?? null)===null||$tmp==='' ? 0 ?? null : $tmp);?>
</span>
                                <span class="price-values-separator">—</span>
                                <span id="price-value-max">€<?php echo (($tmp = (($tmp = $_smarty_tpl->getValue('filtri')['price_max'] ?? null)===null||$tmp==='' ? $_smarty_tpl->getValue('price_range_max') ?? null : $tmp) ?? null)===null||$tmp==='' ? 200 ?? null : $tmp);?>
</span>
                            </div>

                            <div class="price-slider-container">
                                <div class="price-slider-track"></div>
                                <div class="price-slider-range" id="price-slider-range"></div>
                                <input type="range"
                                       class="price-range-input price-range-min"
                                       name="price_min"
                                       id="price-range-min"
                                       min="<?php echo (($tmp = $_smarty_tpl->getValue('price_range_min') ?? null)===null||$tmp==='' ? 0 ?? null : $tmp);?>
"
                                       max="<?php echo (($tmp = $_smarty_tpl->getValue('price_range_max') ?? null)===null||$tmp==='' ? 200 ?? null : $tmp);?>
"
                                       step="1"
                                       value="<?php echo (($tmp = (($tmp = $_smarty_tpl->getValue('filtri')['price_min'] ?? null)===null||$tmp==='' ? $_smarty_tpl->getValue('price_range_min') ?? null : $tmp) ?? null)===null||$tmp==='' ? 0 ?? null : $tmp);?>
"
                                       aria-label="Prezzo minimo">
                                <input type="range"
                                       class="price-range-input price-range-max"
                                       name="price_max"
                                       id="price-range-max"
                                       min="<?php echo (($tmp = $_smarty_tpl->getValue('price_range_min') ?? null)===null||$tmp==='' ? 0 ?? null : $tmp);?>
"
                                       max="<?php echo (($tmp = $_smarty_tpl->getValue('price_range_max') ?? null)===null||$tmp==='' ? 200 ?? null : $tmp);?>
"
                                       step="1"
                                       value="<?php echo (($tmp = (($tmp = $_smarty_tpl->getValue('filtri')['price_max'] ?? null)===null||$tmp==='' ? $_smarty_tpl->getValue('price_range_max') ?? null : $tmp) ?? null)===null||$tmp==='' ? 200 ?? null : $tmp);?>
"
                                       aria-label="Prezzo massimo">
                            </div>

                        </div>
                    </div>

                                        <div class="filter-group">
                        <h4 class="filter-group-title">
                            <i class="ti ti-package"></i> Disponibilità
                        </h4>
                        <div class="checkbox-group" data-exclusive="disponibilita">
                            <label class="checkbox-label">
                                <input type="checkbox"
                                       name="disponibilita[]"
                                       value="disponibile"
                                       <?php if ((true && (true && null !== ($_smarty_tpl->getValue('filtri')['disponibilita'] ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('in_array')('disponibile',$_smarty_tpl->getValue('filtri')['disponibilita'])) {?> checked<?php }?>>
                                <span class="checkbox-text">Disponibile Subito</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox"
                                       name="disponibilita[]"
                                       value="in_arrivo"
                                       <?php if ((true && (true && null !== ($_smarty_tpl->getValue('filtri')['disponibilita'] ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('in_array')('in_arrivo',$_smarty_tpl->getValue('filtri')['disponibilita'])) {?> checked<?php }?>>
                                <span class="checkbox-text">In Arrivo</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox"
                                       name="disponibilita[]"
                                       value="esaurito"
                                       <?php if ((true && (true && null !== ($_smarty_tpl->getValue('filtri')['disponibilita'] ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('in_array')('esaurito',$_smarty_tpl->getValue('filtri')['disponibilita'])) {?> checked<?php }?>>
                                <span class="checkbox-text">Esaurito</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox"
                                       name="disponibilita[]"
                                       value="non_disponibile"
                                       <?php if ((true && (true && null !== ($_smarty_tpl->getValue('filtri')['disponibilita'] ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('in_array')('non_disponibile',$_smarty_tpl->getValue('filtri')['disponibilita'])) {?> checked<?php }?>>
                                <span class="checkbox-text">Non Disponibile</span>
                            </label>
                        </div>
                    </div>

                                        <div class="filter-group">
                        <h4 class="filter-group-title">
                            <i class="ti ti-tag"></i> In Evidenza
                        </h4>
                        <div class="checkbox-group" data-exclusive="in_evidenza">
                            <label class="checkbox-label">
                                <input type="checkbox"
                                       name="in_evidenza[]"
                                       value="sconti"
                                       <?php if ((true && (true && null !== ($_smarty_tpl->getValue('filtri')['in_evidenza'] ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('in_array')('sconti',$_smarty_tpl->getValue('filtri')['in_evidenza'])) {?> checked<?php }?>>
                                <span class="checkbox-text">Sconti Attivi</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox"
                                       name="in_evidenza[]"
                                       value="novita"
                                       <?php if ((true && (true && null !== ($_smarty_tpl->getValue('filtri')['in_evidenza'] ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('in_array')('novita',$_smarty_tpl->getValue('filtri')['in_evidenza'])) {?> checked<?php }?>>
                                <span class="checkbox-text">Novità</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox"
                                       name="in_evidenza[]"
                                       value="venduti"
                                       <?php if ((true && (true && null !== ($_smarty_tpl->getValue('filtri')['in_evidenza'] ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('in_array')('venduti',$_smarty_tpl->getValue('filtri')['in_evidenza'])) {?> checked<?php }?>>
                                <span class="checkbox-text">I più venduti</span>
                            </label>
                        </div>
                    </div>

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
                                   value="<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('filtri')['rating_min'] ?? null)===null||$tmp==='' ? '0' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
"
                                   aria-label="Valutazione minima">
                            <div class="rating-display">
                                <span id="rating-value"><?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('filtri')['rating_min'] ?? null)===null||$tmp==='' ? '0' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
</span>
                                <span class="rating-max">/ 5</span>
                            </div>
                        </div>
                    </div>

                                        <div class="filter-actions">
                        <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/catalogo/portadadi" class="button btn-reset-filters">
                            <i class="ti ti-refresh"></i> Ripristina
                        </a>
                    </div>

                </form>

            </aside>


                        <main class="catalogo-main">

                <div class="catalogo-mobile-toggle">
                    <button class="button btn-toggle-filters" id="btn-toggle-filters">
                        <i class="ti ti-filter"></i> Mostra Filtri
                    </button>
                </div>

                <?php if ((true && ($_smarty_tpl->hasVariable('prodotti') && null !== ($_smarty_tpl->getValue('prodotti') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('prodotti')) > 0) {?>
                    <div class="products-grid">
                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('prodotti'), 'prodotto');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('prodotto')->value) {
$foreach0DoElse = false;
?>
                            <div class="product-card">
                                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/prodotto/<?php echo $_smarty_tpl->getValue('prodotto')['id'];?>
" class="product-card-link">

                                    <div class="product-image-wrapper">
                                        <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/prodotti/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['immagine'], ENT_QUOTES, 'UTF-8', true);?>
"
                                             alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['nome'], ENT_QUOTES, 'UTF-8', true);?>
"
                                             class="product-image">

                                        <?php if ($_smarty_tpl->getValue('prodotto')['disponibilita'] == 'esaurito') {?>
                                            <span class="product-badge product-badge-esaurito">Esaurito</span>
                                        <?php } elseif ($_smarty_tpl->getValue('prodotto')['disponibilita'] == 'in_arrivo') {?>
                                            <span class="product-badge product-badge-in-arrivo">In Arrivo</span>
                                        <?php } elseif ($_smarty_tpl->getValue('prodotto')['disponibilita'] == 'non_disponibile') {?>
                                            <span class="product-badge product-badge-non-disponibile">Non Disponibile</span>
                                        <?php }?>

                                        <?php if ($_smarty_tpl->getValue('prodotto')['sconto']) {?>
                                            <span class="product-badge product-badge-discount">-<?php echo $_smarty_tpl->getValue('prodotto')['percentuale_sconto'];?>
%</span>
                                        <?php }?>
                                    </div>

                                    <div class="product-info">
                                        <h3 class="product-name"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['nome'], ENT_QUOTES, 'UTF-8', true);?>
</h3>

                                        <div class="product-rating">
                                            <?php $_smarty_tpl->assign('media', $_smarty_tpl->getValue('prodotto')['valutazione_media'], false, NULL);?>
                                            <?php $_smarty_tpl->assign('stelle', array(1,2,3,4,5), false, NULL);?>
                                            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('stelle'), 's');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('s')->value) {
$foreach1DoElse = false;
?>
                                                <?php if ($_smarty_tpl->getValue('s') <= $_smarty_tpl->getValue('media')) {?>
                                                    <i class="ti ti-star-filled"></i>
                                                <?php } elseif (($_smarty_tpl->getValue('s')-$_smarty_tpl->getValue('media')) < 1) {?>
                                                    <i class="ti ti-star-half-filled"></i>
                                                <?php } else { ?>
                                                    <i class="ti ti-star"></i>
                                                <?php }?>
                                            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                                            <span class="rating-value">(<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('media'),1);?>
)</span>
                                        </div>

                                        <div class="product-price-wrapper">
                                            <?php if ((true && (true && null !== ($_smarty_tpl->getValue('prodotto')['prezzo_unitario'] ?? null)))) {?>
                                                <?php if ($_smarty_tpl->getValue('prodotto')['sconto']) {?>
                                                    <span class="product-price">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prodotto')['prezzo_unitario'],2);?>
</span>
                                                    <span class="product-price-old">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prodotto')['prezzo_originale'],2);?>
</span>
                                                <?php } else { ?>
                                                    <span class="product-price">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prodotto')['prezzo_unitario'],2);?>
</span>
                                                <?php }?>
                                            <?php } else { ?>
                                                <span class="product-price-unavailable">Prezzo N/D</span>
                                            <?php }?>
                                        </div>
                                    </div>

                                </a>

                                <?php if ($_smarty_tpl->getValue('prodotto')['isAcquistabile']) {?>
                                    <button class="button btn-add-cart"
                                            data-id="<?php echo $_smarty_tpl->getValue('prodotto')['id'];?>
"
                                            data-nome="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['nome'], ENT_QUOTES, 'UTF-8', true);?>
"
                                            data-img="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/prodotti/<?php echo $_smarty_tpl->getValue('prodotto')['immagine'];?>
"
                                            data-prezzo="<?php echo $_smarty_tpl->getValue('prodotto')['prezzo_unitario'];?>
"
                                            aria-label="Aggiungi a carrello">
                                        <i class="ti ti-shopping-cart"></i> Aggiungi
                                    </button>
                                <?php } else { ?>
                                    <button class="button btn-add-cart is-disabled" type="button" disabled aria-label="Prodotto non acquistabile">
                                        <i class="ti ti-ban"></i> Non disponibile
                                    </button>
                                <?php }?>
                            </div>
                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                    </div>

                    <?php if ((true && ($_smarty_tpl->hasVariable('pagination') && null !== ($_smarty_tpl->getValue('pagination') ?? null))) && $_smarty_tpl->getValue('pagination')['total_pages'] > 1) {?>
                    <div class="pagination-wrapper">
                        <nav class="pagination" aria-label="Paginazione">
                            <?php if ($_smarty_tpl->getValue('pagination')['current_page'] > 1) {?>
                                <a class="pagination-previous" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/catalogo/portadadi?page=<?php echo $_smarty_tpl->getValue('pagination')['current_page']-1;
if ((true && (true && null !== ($_smarty_tpl->getValue('filtri')['q'] ?? null)))) {?>&q=<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('filtri')['q'], ENT_QUOTES, 'UTF-8', true);
}?>">
                                    <i class="ti ti-chevron-left"></i> Precedente
                                </a>
                            <?php }?>

                            <ul class="pagination-list">
                                <?php
$_smarty_tpl->assign('i', null);$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int) ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? $_smarty_tpl->getValue('pagination')['total_pages']+1 - (1) : 1-($_smarty_tpl->getValue('pagination')['total_pages'])+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0) {
for ($_smarty_tpl->tpl_vars['i']->value = 1, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++) {
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration === 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration === $_smarty_tpl->tpl_vars['i']->total;?>
                                    <li>
                                        <?php if ($_smarty_tpl->getValue('i') == $_smarty_tpl->getValue('pagination')['current_page']) {?>
                                            <span class="pagination-link is-current" aria-label="Pagina <?php echo $_smarty_tpl->getValue('i');?>
" aria-current="page"><?php echo $_smarty_tpl->getValue('i');?>
</span>
                                        <?php } else { ?>
                                            <a class="pagination-link" aria-label="Vai a pagina <?php echo $_smarty_tpl->getValue('i');?>
" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/catalogo/portadadi?page=<?php echo $_smarty_tpl->getValue('i');
if ((true && (true && null !== ($_smarty_tpl->getValue('filtri')['q'] ?? null)))) {?>&q=<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('filtri')['q'], ENT_QUOTES, 'UTF-8', true);
}?>"><?php echo $_smarty_tpl->getValue('i');?>
</a>
                                        <?php }?>
                                    </li>
                                <?php }
}
?>
                            </ul>

                            <?php if ($_smarty_tpl->getValue('pagination')['current_page'] < $_smarty_tpl->getValue('pagination')['total_pages']) {?>
                                <a class="pagination-next" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/catalogo/portadadi?page=<?php echo $_smarty_tpl->getValue('pagination')['current_page']+1;
if ((true && (true && null !== ($_smarty_tpl->getValue('filtri')['q'] ?? null)))) {?>&q=<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('filtri')['q'], ENT_QUOTES, 'UTF-8', true);
}?>">
                                    Successiva <i class="ti ti-chevron-right"></i>
                                </a>
                            <?php }?>
                        </nav>
                    </div>
                    <?php }?>

                <?php } else { ?>
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="ti ti-box-off"></i>
                        </div>
                        <h3 class="empty-state-title">Nessun prodotto trovato</h3>
                        <p class="empty-state-message">
                            Prova a modificare i filtri o la ricerca per trovare altri portadadi.
                        </p>
                        <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/catalogo/portadadi" class="button btn-reset">
                            <i class="ti ti-refresh"></i> Vedi Catalogo Completo
                        </a>
                    </div>
                <?php }?>

            </main>

        </div>
    </div>

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
                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/catalogo/portadadi" class="button btn-minicart-continua">
                    <i class="ti ti-arrow-left"></i> Continua Shopping
                </a>
                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/carrello" class="button btn-minicart-ordine">
                    <i class="ti ti-shopping-cart"></i> Completa Ordine
                </a>
            </div>
        </div>
    </div>

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
                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/accedi" class="button btn-login-modal-accedi">
                    <i class="ti ti-login"></i> Accedi
                </a>
                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/registrati" class="button btn-login-modal-registrati">
                    Crea un account
                </a>
            </div>
        </div>
    </div>

</div>
<?php
}
}
/* {/block "content"} */
/* {block "extra_js"} */
class Block_14128195096a5a4550d8a922_64684285 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates\\catalogo';
?>

<?php echo '<script'; ?>
>

document.addEventListener('DOMContentLoaded', function() {

    var filtersForm = document.getElementById('filters-form');

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

    var ratingSlider = document.querySelector('.rating-slider');
    if (ratingSlider) {
        ratingSlider.addEventListener('input', function() {
            document.getElementById('rating-value').textContent = this.value;
        });
    }

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

    filtersForm.querySelectorAll('input[type="checkbox"]').forEach(function(el) {
        el.addEventListener('change', submitFilters);
    });

    filtersForm.querySelectorAll('input[type="range"]').forEach(function(el) {
        el.addEventListener('change', submitFilters);
    });

    var sortSelect = document.getElementById('sort-select');
    if (sortSelect) {
        sortSelect.addEventListener('change', submitFilters);
    }

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

    document.querySelectorAll('.btn-add-cart:not(.is-disabled)').forEach(function(btn) {
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

<?php echo '</script'; ?>
>
<?php
}
}
/* {/block "extra_js"} */
}
