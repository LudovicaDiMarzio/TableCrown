<?php
/* Smarty version 5.8.0, created on 2026-07-21 22:10:20
  from 'file:gestore_catalogo_gioco.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a5fd22c609311_08414664',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '45302ba12a0f1fe05cd3006cc1463809f2526fa9' => 
    array (
      0 => 'gestore_catalogo_gioco.tpl',
      1 => 1784664617,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:gestore_modifica_gioco.tpl' => 1,
  ),
))) {
function content_6a5fd22c609311_08414664 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_18340739326a5fd22c5cb245_19579000', "page_css");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_12155500846a5fd22c5cff58_63541672', "content");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "layout_gestore.tpl", $_smarty_current_dir);
}
/* {block "page_css"} */
class Block_18340739326a5fd22c5cb245_19579000 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

    <link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/css/eventi_gestore.css">
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/css/gestore_prodotti.css">
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/css/gestore_modifica_prodotto.css">
<?php
}
}
/* {/block "page_css"} */
/* {block "content"} */
class Block_12155500846a5fd22c5cff58_63541672 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>


<div class="gprod-container">

    <div class="gprod-header">
        <div class="gprod-header__titles">
            <h1 class="gprod-header__title">Giochi da Tavolo</h1>
            <p class="gprod-header__count">
                <?php $_smarty_tpl->assign('tot', (($tmp = $_smarty_tpl->getValue('total_results') ?? null)===null||$tmp==='' ? 0 ?? null : $tmp), false, NULL);?>
                <?php if ($_smarty_tpl->getValue('tot') == 1) {?>1 prodotto<?php } else {
echo $_smarty_tpl->getValue('tot');?>
 prodotti<?php }?>
            </p>
        </div>

        <div class="gprod-header__actions">
            <form class="gprod-search-form" action="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/ricerca" method="get">
                <input class="gprod-search-input" type="search" name="q" placeholder="Cerca giochi da tavolo..."
                       value="<?php if ((true && ($_smarty_tpl->hasVariable('filtri') && null !== ($_smarty_tpl->getValue('filtri') ?? null))) && (true && (true && null !== ($_smarty_tpl->getValue('filtri')['q'] ?? null)))) {
echo htmlspecialchars((string)$_smarty_tpl->getValue('filtri')['q'], ENT_QUOTES, 'UTF-8', true);
}?>" aria-label="Cerca prodotti">
                <button class="gprod-search-btn" type="submit" aria-label="Cerca">
                    <i class="ti ti-search"></i>
                </button>
            </form>

            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/crea/giochi-da-tavolo" class="gprod-btn-create">
    <i class="ti ti-plus"></i> Nuovo Gioco
</a>
        </div>
    </div>

    <div class="gprod-layout">

        <aside class="gprod-sidebar">
            <h3 class="gprod-filter-title"><i class="ti ti-filter"></i> Filtri</h3>

            <form method="get" action="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/catalogo/giochi-da-tavolo">

                <div class="gprod-filter-group">
                    <span class="gprod-filter-label">Disponibilità</span>
                                        <?php $_smarty_tpl->assign('dispSelezionati', (($tmp = $_smarty_tpl->getValue('filtri')['disponibilita'] ?? null)===null||$tmp==='' ? array() ?? null : $tmp), false, NULL);?>
                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, (($tmp = $_smarty_tpl->getValue('filtri')['disponibilita_enum'] ?? null)===null||$tmp==='' ? array() ?? null : $tmp), 'opt');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('opt')->value) {
$foreach0DoElse = false;
?>
                        <label class="gprod-filter-checkbox">
                            <input type="checkbox" name="disponibilita[]" value="<?php echo $_smarty_tpl->getValue('opt')['value'];?>
"
                                   <?php if ($_smarty_tpl->getSmarty()->getModifierCallback('in_array')($_smarty_tpl->getValue('opt')['value'],$_smarty_tpl->getValue('dispSelezionati'))) {?>checked<?php }?>
                                   onchange="this.form.submit()">
                            <?php echo $_smarty_tpl->getValue('opt')['label'];?>

                        </label>
                    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                </div>

                <div class="gprod-filter-group">
                    <label class="gprod-filter-label" for="filtro-ordinamento">Ordina per</label>
                    <select class="gprod-filter-select" id="filtro-ordinamento" name="ordinamento" onchange="this.form.submit()">
                        <option value="">Predefinito</option>
                        <option value="prezzo-asc"  <?php if ($_smarty_tpl->getValue('filtri')['ordinamento'] == 'prezzo-asc') {?>selected<?php }?>>Prezzo crescente</option>
                        <option value="prezzo-desc" <?php if ($_smarty_tpl->getValue('filtri')['ordinamento'] == 'prezzo-desc') {?>selected<?php }?>>Prezzo decrescente</option>
                        <option value="popolarita"  <?php if ($_smarty_tpl->getValue('filtri')['ordinamento'] == 'popolarita') {?>selected<?php }?>>Popolarità</option>
                        <option value="rating"      <?php if ($_smarty_tpl->getValue('filtri')['ordinamento'] == 'rating') {?>selected<?php }?>>Valutazione</option>
                    </select>
                </div>

                <div class="gprod-filter-actions">
                    <a class="gprod-filter-reset" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/catalogo/giochi-da-tavolo">
                        <i class="ti ti-refresh"></i> Rimuovi filtri
                    </a>
                </div>
            </form>
        </aside>

        <main class="gprod-grid">

            <?php if ((true && ($_smarty_tpl->hasVariable('prodotti') && null !== ($_smarty_tpl->getValue('prodotti') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('prodotti')) > 0) {?>
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('prodotti'), 'prodotto');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('prodotto')->value) {
$foreach1DoElse = false;
?>
                    <article class="gprod-card" data-id-prodotto="<?php echo $_smarty_tpl->getValue('prodotto')['id'];?>
">
                        <div class="gprod-card__img-wrapper">
                            <img src="<?php echo $_smarty_tpl->getValue('prodotto')['immagine'];?>
" alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['nome'], ENT_QUOTES, 'UTF-8', true);?>
" class="gprod-card__img">
                            <span class="gprod-card__status gprod-card__status--<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('replace')(mb_strtolower((string) $_smarty_tpl->getValue('prodotto')['disponibilita'], 'UTF-8'),' ','_');?>
"><?php echo $_smarty_tpl->getValue('prodotto')['disponibilita'];?>
</span>
                            <?php if ($_smarty_tpl->getValue('prodotto')['sconto']) {?>
                                <span class="gprod-card__discount">-<?php echo $_smarty_tpl->getValue('prodotto')['percentuale_sconto'];?>
%</span>
                            <?php }?>
                        </div>

                        <div class="gprod-card__body">
                            <span class="gprod-card__type">Gioco da Tavolo</span>
                            <h3 class="gprod-card__name"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['nome'], ENT_QUOTES, 'UTF-8', true);?>
</h3>

                            <div class="gprod-card__meta">
                                <span class="gprod-card__meta-row">
                                    <i class="ti ti-star-filled"></i> <?php echo sprintf("%.1f",$_smarty_tpl->getValue('prodotto')['valutazione_media']);?>

                                </span>
                                <span class="gprod-card__meta-row<?php if ($_smarty_tpl->getValue('prodotto')['quantita'] <= 0) {?> gprod-card__stock-empty<?php }?>">
                                    <i class="ti ti-package"></i> <?php echo $_smarty_tpl->getValue('prodotto')['quantita'];?>
 in magazzino
                                </span>
                            </div>

                            <div class="gprod-card__prezzo">
                                <?php if ($_smarty_tpl->getValue('prodotto')['sconto']) {?>
                                    <span class="gprod-card__prezzo-old">&euro;<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prodotto')['prezzo'],2);?>
</span>
                                    <span class="gprod-card__prezzo-new">&euro;<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prodotto')['prezzo_scontato'],2);?>
</span>
                                <?php } else { ?>
                                    <span class="gprod-card__prezzo-new">&euro;<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prodotto')['prezzo'],2);?>
</span>
                                <?php }?>
                            </div>

                            <div class="gprod-card__stepper">
                                <button type="button" class="gprod-stepper__btn" data-delta="-1" onclick="aggiornaQuantita(this, -1)" aria-label="Diminuisci quantità">
                                    <i class="ti ti-minus"></i>
                                </button>
                                <span class="gprod-stepper__value"><?php echo $_smarty_tpl->getValue('prodotto')['quantita'];?>
</span>
                                <button type="button" class="gprod-stepper__btn" data-delta="1" onclick="aggiornaQuantita(this, 1)" aria-label="Aumenta quantità">
                                    <i class="ti ti-plus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="gprod-card__footer">
                            <button type="button" class="gprod-btn-edit gmp-btn-modifica"
    data-id="<?php echo $_smarty_tpl->getValue('prodotto')['id'];?>
"
    data-nome="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['nome'], ENT_QUOTES, 'UTF-8', true);?>
"
    data-immagine="<?php echo $_smarty_tpl->getValue('prodotto')['immagine'];?>
"
    data-tipo="<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('prodotto')['tipo'] ?? null)===null||$tmp==='' ? 'Gioco da Tavolo' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
"
    data-prezzo="<?php echo $_smarty_tpl->getValue('prodotto')['prezzo'];?>
"
    data-sconto="<?php if ($_smarty_tpl->getValue('prodotto')['sconto']) {?>1<?php } else { ?>0<?php }?>"
    data-percentuale-sconto="<?php echo (($tmp = $_smarty_tpl->getValue('prodotto')['percentuale_sconto'] ?? null)===null||$tmp==='' ? 0 ?? null : $tmp);?>
"
    data-scadenza-sconto="<?php echo (($tmp = $_smarty_tpl->getValue('prodotto')['scadenza_sconto'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
"
    data-danneggiato="<?php if ($_smarty_tpl->getValue('prodotto')['danneggiato']) {?>1<?php } else { ?>0<?php }?>"
    data-livello-danno="<?php echo (($tmp = $_smarty_tpl->getValue('prodotto')['livello_danno_attuale'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
"
    data-descrizione-danno="<?php echo (($tmp = $_smarty_tpl->getValue('prodotto')['descrizione_danno_attuale'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
"
    data-is-gioco="1">
    <i class="ti ti-pencil"></i> Modifica
</button>
                            <button type="button" class="gprod-btn-delete" onclick="eliminaProdotto(this)">
                                <i class="ti ti-trash"></i>
                            </button>
                        </div>
                    </article>
                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
            <?php } else { ?>
                <div class="gprod-empty">
                    <span class="gprod-empty__icon"><i class="ti ti-package-off"></i></span>
                    <h3 class="gprod-empty__title">Nessun gioco trovato</h3>
                    <p class="gprod-empty__text">
                        <?php if ((true && ($_smarty_tpl->hasVariable('filtri') && null !== ($_smarty_tpl->getValue('filtri') ?? null))) && ($_smarty_tpl->getValue('filtri')['q'] ?? false)) {?>
                            Nessun risultato per la ricerca corrente.
                        <?php } else { ?>
                            Non è stato ancora pubblicato nessun gioco da tavolo.
                        <?php }?>
                    </p>
                    <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/catalogo/giochi-da-tavolo/nuovo" class="gprod-btn-create">
                        <i class="ti ti-plus"></i> Crea il primo gioco
                    </a>
                </div>
            <?php }?>
        </main>

    </div>

    <?php if ((true && ($_smarty_tpl->hasVariable('pagination') && null !== ($_smarty_tpl->getValue('pagination') ?? null))) && $_smarty_tpl->getValue('pagination')['total_pages'] > 1) {?>
        <nav class="gprod-pagination">
            <?php if ($_smarty_tpl->getValue('pagination')['current_page'] > 1) {?>
                <a href="?pagina=<?php echo $_smarty_tpl->getValue('pagination')['current_page']-1;?>
" class="gprod-pagination__link"><i class="ti ti-chevron-left"></i></a>
            <?php }?>
            <span class="gprod-pagination__current">Pagina <?php echo $_smarty_tpl->getValue('pagination')['current_page'];?>
 di <?php echo $_smarty_tpl->getValue('pagination')['total_pages'];?>
</span>
            <?php if ($_smarty_tpl->getValue('pagination')['current_page'] < $_smarty_tpl->getValue('pagination')['total_pages']) {?>
                <a href="?pagina=<?php echo $_smarty_tpl->getValue('pagination')['current_page']+1;?>
" class="gprod-pagination__link"><i class="ti ti-chevron-right"></i></a>
            <?php }?>
        </nav>
    <?php }?>

</div>

<?php echo '<script'; ?>
>
    function aggiornaQuantita(btn, delta) {
        var card = btn.closest('.gprod-card');
        var idProdotto = card.dataset.idProdotto;
        var valueEl = card.querySelector('.gprod-stepper__value');

        fetch('<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/prodotti/quantita', {
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

        fetch('<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/catalogo/prodotto/elimina', {
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
<?php echo '</script'; ?>
>

<?php $_smarty_tpl->renderSubTemplate("file:gestore_modifica_gioco.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<?php
}
}
/* {/block "content"} */
}
