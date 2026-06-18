<?php
/* Smarty version 5.8.0, created on 2026-06-18 11:20:00
  from 'file:catalogo.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a33b84026c2a3_34467098',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4d90e5f688d80db201316a7cb04f34e17d9fd4ea' => 
    array (
      0 => 'catalogo.tpl',
      1 => 1781774394,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a33b84026c2a3_34467098 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\damic\\Desktop\\uni\\APPUNTI\\anno3\\secondo_semenstre\\Pweb\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_6578384026a33b84020ea42_52807544', "extra_css");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_9876048226a33b840213237_83901611', "content");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_9617009346a33b84026a539_06479529', "extra_js");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "extra_css"} */
class Block_6578384026a33b84020ea42_52807544 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\damic\\Desktop\\uni\\APPUNTI\\anno3\\secondo_semenstre\\Pweb\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

    <link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/css/catalogo.css">
<?php
}
}
/* {/block "extra_css"} */
/* {block "content"} */
class Block_9876048226a33b840213237_83901611 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\damic\\Desktop\\uni\\APPUNTI\\anno3\\secondo_semenstre\\Pweb\\TableCrown\\Presentation\\smarty-dir\\templates';
?>


<div class="catalogo-container">
    
        <section class="catalogo-header">
        <div class="container">
            
                        <div class="catalogo-search-wrapper">
                <form class="catalogo-search-form" action="<?php echo $_smarty_tpl->getValue('base_url');?>
/catalogo" method="get" id="search-form">
                    <input class="input catalogo-search-input"
                           type="search"
                           name="q"
                           placeholder="Cerca nel catalogo..."
                           value="<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('search_query') ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
"
                           aria-label="Cerca giochi da tavolo">
                                        <?php if ((true && ($_smarty_tpl->hasVariable('ordinamento') && null !== ($_smarty_tpl->getValue('ordinamento') ?? null))) && $_smarty_tpl->getValue('ordinamento')) {?>
                        <input type="hidden" name="ordinamento" value="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('ordinamento'), ENT_QUOTES, 'UTF-8', true);?>
">
                    <?php }?>
                    <button class="button catalogo-search-btn" type="submit" aria-label="Cerca">
                        <i class="ti ti-search"></i>
                    </button>
                </form>
            </div>

                        <div class="catalogo-results-header">
                <div class="results-info">
                    <h2 class="results-title">
                        <?php if ((true && ($_smarty_tpl->hasVariable('search_query') && null !== ($_smarty_tpl->getValue('search_query') ?? null))) && $_smarty_tpl->getValue('search_query')) {?>
                            Risultati per "<strong><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('search_query'), ENT_QUOTES, 'UTF-8', true);?>
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
                                        <select id="sort-select" class="select catalogo-sort-select" onchange="syncSortAndSubmit(this.value);">
                        <option value="rilevanza" <?php if ((true && ($_smarty_tpl->hasVariable('ordinamento') && null !== ($_smarty_tpl->getValue('ordinamento') ?? null))) && $_smarty_tpl->getValue('ordinamento') == 'rilevanza') {?> selected<?php }?>>Rilevanza</option>
                        <option value="prezzo-asc" <?php if ((true && ($_smarty_tpl->hasVariable('ordinamento') && null !== ($_smarty_tpl->getValue('ordinamento') ?? null))) && $_smarty_tpl->getValue('ordinamento') == 'prezzo-asc') {?> selected<?php }?>>Prezzo: crescente</option>
                        <option value="prezzo-desc" <?php if ((true && ($_smarty_tpl->hasVariable('ordinamento') && null !== ($_smarty_tpl->getValue('ordinamento') ?? null))) && $_smarty_tpl->getValue('ordinamento') == 'prezzo-desc') {?> selected<?php }?>>Prezzo: decrescente</option>
                        <option value="novita" <?php if ((true && ($_smarty_tpl->hasVariable('ordinamento') && null !== ($_smarty_tpl->getValue('ordinamento') ?? null))) && $_smarty_tpl->getValue('ordinamento') == 'novita') {?> selected<?php }?>>Novità</option>
                        <option value="popolarita" <?php if ((true && ($_smarty_tpl->hasVariable('ordinamento') && null !== ($_smarty_tpl->getValue('ordinamento') ?? null))) && $_smarty_tpl->getValue('ordinamento') == 'popolarita') {?> selected<?php }?>>Più venduti</option>
                        <option value="rating" <?php if ((true && ($_smarty_tpl->hasVariable('ordinamento') && null !== ($_smarty_tpl->getValue('ordinamento') ?? null))) && $_smarty_tpl->getValue('ordinamento') == 'rating') {?> selected<?php }?>>Valutazione</option>
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
                    <button class="filter-close-btn" id="filter-close-btn" aria-label="Chiudi filtri">
                        <i class="ti ti-x"></i>
                    </button>
                </div>

                <form class="filters-form" id="filters-form" method="get" action="<?php echo $_smarty_tpl->getValue('base_url');?>
/catalogo">
                    
                                        <input type="hidden" name="q" value="<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('search_query') ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
">
                    <input type="hidden" name="ordinamento" id="hidden-ordinamento" value="<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('ordinamento') ?? null)===null||$tmp==='' ? 'rilevanza' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
">

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
                                       value="<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('price_min') ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
"
                                       min="0"
                                       aria-label="Prezzo minimo">
                                <span class="price-separator">—</span>
                                <input type="number" 
                                       class="input price-input price-max" 
                                       name="price_max" 
                                       placeholder="Max"
                                       value="<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('price_max') ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
"
                                       min="0"
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
                                <input type="checkbox" name="disponibilita" value="annunciato" <?php if ((true && ($_smarty_tpl->hasVariable('disponibilita') && null !== ($_smarty_tpl->getValue('disponibilita') ?? null))) && $_smarty_tpl->getValue('disponibilita') == 'annunciato') {?> checked<?php }?>>
                                <span class="checkbox-text">Annunciato</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="disponibilita" value="disponibile" <?php if ((true && ($_smarty_tpl->hasVariable('disponibilita') && null !== ($_smarty_tpl->getValue('disponibilita') ?? null))) && $_smarty_tpl->getValue('disponibilita') == 'disponibile') {?> checked<?php }?>>
                                <span class="checkbox-text">Disponibile Subito</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="disponibilita" value="esaurito" <?php if ((true && ($_smarty_tpl->hasVariable('disponibilita') && null !== ($_smarty_tpl->getValue('disponibilita') ?? null))) && $_smarty_tpl->getValue('disponibilita') == 'esaurito') {?> checked<?php }?>>
                                <span class="checkbox-text">Esaurito</span>
                            </label>
                        </div>
                    </div>

                                        <div class="filter-group">
                        <h4 class="filter-group-title">
                            <i class="ti ti-tag"></i> Offerte
                        </h4>
                        <div class="checkbox-group" data-exclusive="offerte">
                            <label class="checkbox-label">
                                <input type="checkbox" name="offerte" value="sconti" <?php if ((true && ($_smarty_tpl->hasVariable('offerte') && null !== ($_smarty_tpl->getValue('offerte') ?? null))) && $_smarty_tpl->getValue('offerte') == 'sconti') {?> checked<?php }?>>
                                <span class="checkbox-text">Sconti Attivi</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="offerte" value="bundle" <?php if ((true && ($_smarty_tpl->hasVariable('offerte') && null !== ($_smarty_tpl->getValue('offerte') ?? null))) && $_smarty_tpl->getValue('offerte') == 'bundle') {?> checked<?php }?>>
                                <span class="checkbox-text">Bundle</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="offerte" value="danneggiati" <?php if ((true && ($_smarty_tpl->hasVariable('offerte') && null !== ($_smarty_tpl->getValue('offerte') ?? null))) && $_smarty_tpl->getValue('offerte') == 'danneggiati') {?> checked<?php }?>>
                                <span class="checkbox-text">Danneggiati / Scatolato</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="offerte" value="novita" <?php if ((true && ($_smarty_tpl->hasVariable('offerte') && null !== ($_smarty_tpl->getValue('offerte') ?? null))) && $_smarty_tpl->getValue('offerte') == 'novita') {?> checked<?php }?>>
                                <span class="checkbox-text">Novità</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="offerte" value="venduti" <?php if ((true && ($_smarty_tpl->hasVariable('offerte') && null !== ($_smarty_tpl->getValue('offerte') ?? null))) && $_smarty_tpl->getValue('offerte') == 'venduti') {?> checked<?php }?>>
                                <span class="checkbox-text">I più venduti</span>
                            </label>
                        </div>
                    </div>

                                        <div class="filter-group">
                        <h4 class="filter-group-title">
                            <i class="ti ti-list"></i> Categoria
                        </h4>
                        <div class="checkbox-group" data-exclusive="categoria">
                            <?php if ((true && ($_smarty_tpl->hasVariable('categorie') && null !== ($_smarty_tpl->getValue('categorie') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('categorie')) > 0) {?>
                                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('categorie'), 'cat');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('cat')->value) {
$foreach0DoElse = false;
?>
                                    <label class="checkbox-label">
                                        <input type="checkbox" 
                                               name="categoria" 
                                               value="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('cat')->getIdProdotto(), ENT_QUOTES, 'UTF-8', true);?>
"
                                               <?php if ((true && ($_smarty_tpl->hasVariable('categoria_selected') && null !== ($_smarty_tpl->getValue('categoria_selected') ?? null))) && $_smarty_tpl->getValue('categoria_selected') == $_smarty_tpl->getValue('cat')->getIdProdotto()) {?> checked<?php }?>>
                                        <span class="checkbox-text"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('cat')->getNomeProdotto(), ENT_QUOTES, 'UTF-8', true);?>
</span>
                                    </label>
                                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                            <?php } else { ?>
                                <p class="no-options">Nessuna categoria disponibile</p>
                            <?php }?>
                        </div>
                    </div>

                                        <div class="filter-group">
                        <h4 class="filter-group-title">
                            <i class="ti ti-puzzle-2"></i> Espansioni
                        </h4>
                        <div class="checkbox-group" data-exclusive="espansioni">
                            <label class="checkbox-label">
                                <input type="checkbox" name="espansioni" value="si" <?php if ((true && ($_smarty_tpl->hasVariable('espansioni') && null !== ($_smarty_tpl->getValue('espansioni') ?? null))) && $_smarty_tpl->getValue('espansioni') == 'si') {?> checked<?php }?>>
                                <span class="checkbox-text">Solo base game</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="espansioni" value="no" <?php if ((true && ($_smarty_tpl->hasVariable('espansioni') && null !== ($_smarty_tpl->getValue('espansioni') ?? null))) && $_smarty_tpl->getValue('espansioni') == 'no') {?> checked<?php }?>>
                                <span class="checkbox-text">Solo espansioni</span>
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
                                   value="<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('rating_min') ?? null)===null||$tmp==='' ? '0' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
"
                                   aria-label="Valutazione minima">
                            <div class="rating-display">
                                <span id="rating-value"><?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('rating_min') ?? null)===null||$tmp==='' ? '0' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
</span>
                                <span class="rating-max">/ 5</span>
                            </div>
                        </div>
                    </div>

                                        <div class="filter-group">
                        <h4 class="filter-group-title">
                            <i class="ti ti-baby-carriage"></i> Età
                        </h4>
                        <div class="age-inputs">
                            <input type="number" 
                                   class="input age-input" 
                                   name="age_min" 
                                   placeholder="Da"
                                   value="<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('age_min') ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
"
                                   min="0"
                                   max="18"
                                   aria-label="Età minima">
                            <span class="age-separator">—</span>
                            <input type="number" 
                                   class="input age-input" 
                                   name="age_max" 
                                   placeholder="A"
                                   value="<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('age_max') ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
"
                                   min="0"
                                   max="99"
                                   aria-label="Età massima">
                        </div>
                    </div>

                                        <div class="filter-group">
                        <h4 class="filter-group-title">
                            <i class="ti ti-flame"></i> Difficoltà
                        </h4>
                        <div class="checkbox-group" data-exclusive="difficolta">
                            <?php $_smarty_tpl->assign('difficolta_levels', array('Facile','Media','Difficile','Molto difficile'), false, NULL);?>
                            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('difficolta_levels'), 'level');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('level')->value) {
$foreach1DoElse = false;
?>
                                <label class="checkbox-label">
                                    <input type="checkbox"
                                           name="difficolta"
                                           value="<?php echo mb_strtolower((string) $_smarty_tpl->getValue('level'), 'UTF-8');?>
"
                                           <?php if ((true && ($_smarty_tpl->hasVariable('difficolta') && null !== ($_smarty_tpl->getValue('difficolta') ?? null))) && $_smarty_tpl->getValue('difficolta') == mb_strtolower((string) $_smarty_tpl->getValue('level'), 'UTF-8')) {?> checked<?php }?>>
                                    <span class="checkbox-text"><?php echo $_smarty_tpl->getValue('level');?>
</span>
                                </label>
                            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                        </div>
                    </div>

                                        <div class="filter-group">
                        <h4 class="filter-group-title">
                            <i class="ti ti-users"></i> Giocatori
                        </h4>
                        <div class="players-inputs">
                            <input type="number" 
                                   class="input players-input" 
                                   name="players_min" 
                                   placeholder="Min"
                                   value="<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('players_min') ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
"
                                   min="1"
                                   aria-label="Numero giocatori minimo">
                            <span class="players-separator">—</span>
                            <input type="number" 
                                   class="input players-input" 
                                   name="players_max" 
                                   placeholder="Max"
                                   value="<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('players_max') ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
"
                                   min="1"
                                   aria-label="Numero giocatori massimo">
                        </div>
                    </div>

                                        <div class="filter-group">
                        <h4 class="filter-group-title">
                            <i class="ti ti-language"></i> Lingua
                        </h4>
                        <div class="checkbox-group" data-exclusive="lingua">
                            <?php $_smarty_tpl->assign('lingue', array('Italiano','English','Multilingue','Solo Immagini'), false, NULL);?>
                            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('lingue'), 'lang');
$foreach2DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('lang')->value) {
$foreach2DoElse = false;
?>
                                <label class="checkbox-label">
                                    <input type="checkbox"
                                           name="lingua"
                                           value="<?php echo mb_strtolower((string) $_smarty_tpl->getValue('lang'), 'UTF-8');?>
"
                                           <?php if ((true && ($_smarty_tpl->hasVariable('lingua') && null !== ($_smarty_tpl->getValue('lingua') ?? null))) && $_smarty_tpl->getValue('lingua') == mb_strtolower((string) $_smarty_tpl->getValue('lang'), 'UTF-8')) {?> checked<?php }?>>
                                    <span class="checkbox-text"><?php echo $_smarty_tpl->getValue('lang');?>
</span>
                                </label>
                            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                        </div>
                    </div>

                                        <div class="filter-actions">
                        <button type="submit" class="button btn-apply-filters">
                            <i class="ti ti-check"></i> Applica Filtri
                        </button>
                        <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/catalogo" class="button btn-reset-filters">
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
$foreach3DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('prodotto')->value) {
$foreach3DoElse = false;
?>
                            <div class="product-card">
                                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/prodotto/<?php echo $_smarty_tpl->getValue('prodotto')->getIdProdotto();?>
" class="product-card-link">
                                    
                                    <div class="product-image-wrapper">
                                        <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/prodotti/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')->getImgProdotto(), ENT_QUOTES, 'UTF-8', true);?>
" 
                                             alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')->getNomeProdotto(), ENT_QUOTES, 'UTF-8', true);?>
" 
                                             class="product-image">
                                        
                                                                                <?php if ($_smarty_tpl->getValue('prodotto')->getDisponibilitaProdotto() == 'esaurito') {?>
                                            <span class="product-badge product-badge-esaurito">Esaurito</span>
                                        <?php }?>
                                        <?php if ($_smarty_tpl->getValue('prodotto')->getDisponibilitaProdotto() == 'annunciato') {?>
                                            <span class="product-badge product-badge-annunciato">Annunciato</span>
                                        <?php }?>

                                                                                <?php $_smarty_tpl->assign('prezzo', $_smarty_tpl->getValue('prodotto')->getPrezzo(), false, NULL);?>
                                        <?php if ((true && ($_smarty_tpl->hasVariable('prezzo') && null !== ($_smarty_tpl->getValue('prezzo') ?? null))) && $_smarty_tpl->getValue('prezzo')->hasSconto()) {?>
                                            <span class="product-badge product-badge-discount">-<?php echo $_smarty_tpl->getValue('prezzo')->getSconto();?>
%</span>
                                        <?php }?>
                                    </div>

                                    <div class="product-info">
                                        <h3 class="product-name"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')->getNomeProdotto(), ENT_QUOTES, 'UTF-8', true);?>
</h3>
                                        
                                                                                <div class="product-rating">
                                            <?php $_smarty_tpl->assign('media', $_smarty_tpl->getValue('prodotto')->getValutazioneMedia(), false, NULL);?>
                                            <?php $_smarty_tpl->assign('stelle', array(1,2,3,4,5), false, NULL);?>
                                            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('stelle'), 's');
$foreach4DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('s')->value) {
$foreach4DoElse = false;
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
                                            <?php if ((true && ($_smarty_tpl->hasVariable('prezzo') && null !== ($_smarty_tpl->getValue('prezzo') ?? null)))) {?>
                                                <?php if ($_smarty_tpl->getValue('prezzo')->hasSconto()) {?>
                                                    <span class="product-price">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prezzo')->calcolaPrezzoScontato(),2);?>
</span>
                                                    <span class="product-price-old">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prezzo')->getValore(),2);?>
</span>
                                                <?php } else { ?>
                                                    <span class="product-price">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prezzo')->getValore(),2);?>
</span>
                                                <?php }?>
                                            <?php } else { ?>
                                                <span class="product-price-unavailable">Prezzo N/D</span>
                                            <?php }?>
                                        </div>
                                    </div>

                                </a>

                                                                 <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/carrello/aggiungi/<?php echo $_smarty_tpl->getValue('prodotto')->getIdProdotto();?>
" class="button btn-add-cart" aria-label="Aggiungi a carrello">
                                    <i class="ti ti-shopping-cart"></i> Aggiungi
                                </a>
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
/catalogo?page=<?php echo $_smarty_tpl->getValue('pagination')['current_page']-1;
if ((true && ($_smarty_tpl->hasVariable('search_query') && null !== ($_smarty_tpl->getValue('search_query') ?? null)))) {?>&q=<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('search_query'), ENT_QUOTES, 'UTF-8', true);
}
if ((true && ($_smarty_tpl->hasVariable('ordinamento') && null !== ($_smarty_tpl->getValue('ordinamento') ?? null)))) {?>&ordinamento=<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('ordinamento'), ENT_QUOTES, 'UTF-8', true);
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
/catalogo?page=<?php echo $_smarty_tpl->getValue('i');
if ((true && ($_smarty_tpl->hasVariable('search_query') && null !== ($_smarty_tpl->getValue('search_query') ?? null)))) {?>&q=<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('search_query'), ENT_QUOTES, 'UTF-8', true);
}
if ((true && ($_smarty_tpl->hasVariable('ordinamento') && null !== ($_smarty_tpl->getValue('ordinamento') ?? null)))) {?>&ordinamento=<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('ordinamento'), ENT_QUOTES, 'UTF-8', true);
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
/catalogo?page=<?php echo $_smarty_tpl->getValue('pagination')['current_page']+1;
if ((true && ($_smarty_tpl->hasVariable('search_query') && null !== ($_smarty_tpl->getValue('search_query') ?? null)))) {?>&q=<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('search_query'), ENT_QUOTES, 'UTF-8', true);
}
if ((true && ($_smarty_tpl->hasVariable('ordinamento') && null !== ($_smarty_tpl->getValue('ordinamento') ?? null)))) {?>&ordinamento=<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('ordinamento'), ENT_QUOTES, 'UTF-8', true);
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
                            Prova a modificare i filtri o la ricerca per trovare altri giochi da tavolo.
                        </p>
                        <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/catalogo" class="button btn-reset">
                            <i class="ti ti-refresh"></i> Vedi Catalogo Completo
                        </a>
                    </div>
                <?php }?>

            </main>

        </div>
    </div>

</div>

<?php
}
}
/* {/block "content"} */
/* {block "extra_js"} */
class Block_9617009346a33b84026a539_06479529 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\damic\\Desktop\\uni\\APPUNTI\\anno3\\secondo_semenstre\\Pweb\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<?php echo '<script'; ?>
>
// Funzione globale per gestire l'ordinamento mantenendo i filtri della sidebar
function syncSortAndSubmit(sortValue) {
    const hiddenSort = document.getElementById('hidden-ordinamento');
    const filterForm = document.getElementById('filters-form');
    if (hiddenSort && filterForm) {
        hiddenSort.value = sortValue;
        filterForm.submit();
    }
}

document.addEventListener('DOMContentLoaded', function() {

    // ✅ Checkbox esclusivi puliti
    const exclusiveGroups = document.querySelectorAll('[data-exclusive]');
    
    exclusiveGroups.forEach(group => {
        const checkboxes = group.querySelectorAll('input[type="checkbox"]');
        
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    checkboxes.forEach(cb => {
                        if (cb !== this) {
                            cb.checked = false;
                        }
                    });
                }
            });
        });
    });

    // Toggle Filtri su Mobile
    const toggleBtn = document.getElementById('btn-toggle-filters');
    const sidebar = document.getElementById('catalogo-filters');
    const closeBtn = document.getElementById('filter-close-btn');
    
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('is-open');
            this.classList.toggle('is-active');
        });
    }

    // Chiudi Filtri (mobile)
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            sidebar.classList.remove('is-open');
            toggleBtn.classList.remove('is-active');
        });
    }

    // Aggiorna valore rating in tempo reale
    const ratingSlider = document.querySelector('.rating-slider');
    if (ratingSlider) {
        ratingSlider.addEventListener('input', function() {
            document.getElementById('rating-value').textContent = this.value;
        });
    }

    // Chiudi filtri quando clicchi fuori (mobile)
    document.addEventListener('click', function(e) {
        if (sidebar && toggleBtn) {
            if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                sidebar.classList.remove('is-open');
                toggleBtn.classList.remove('is-active');
            }
        }
    });

});
<?php echo '</script'; ?>
>
<?php
}
}
/* {/block "extra_js"} */
}
