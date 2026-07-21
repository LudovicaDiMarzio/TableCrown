<?php
/* Smarty version 5.8.0, created on 2026-07-21 20:48:12
  from 'file:gestore_eventi_tornei.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a5fbeecd461f9_72651806',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '88ad0626cedce293b891dfbafc2e6a5af254e211' => 
    array (
      0 => 'gestore_eventi_tornei.tpl',
      1 => 1784555503,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a5fbeecd461f9_72651806 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_6536547026a5fbeecd305c6_22869873', "page_css");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_2915016756a5fbeecd328b3_11803535', "content");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "layout_gestore.tpl", $_smarty_current_dir);
}
/* {block "page_css"} */
class Block_6536547026a5fbeecd305c6_22869873 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

    <link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/css/eventi_gestore.css">
<?php
}
}
/* {/block "page_css"} */
/* {block "content"} */
class Block_2915016756a5fbeecd328b3_11803535 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>


<div class="gcat-container">

        <div class="gcat-header">
        <div class="gcat-header__titles">
            <h1 class="gcat-header__title">Tornei</h1>
            <p class="gcat-header__count">
                <?php $_smarty_tpl->assign('tot', $_smarty_tpl->getSmarty()->getModifierCallback('count')((($tmp = $_smarty_tpl->getValue('eventi') ?? null)===null||$tmp==='' ? array() ?? null : $tmp)), false, NULL);?>
                <?php if ($_smarty_tpl->getValue('tot') == 1) {?>1 torneo<?php } else {
echo $_smarty_tpl->getValue('tot');?>
 tornei<?php }?>
            </p>
        </div>

        <div class="gcat-header__actions">
            <form class="gcat-search-form" action="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/eventi/ricerca" method="get">
                <input class="gcat-search-input" type="search" name="q" placeholder="Cerca tra tutti gli eventi..." aria-label="Cerca eventi">
                <button class="gcat-search-btn" type="submit" aria-label="Cerca">
                    <i class="ti ti-search"></i>
                </button>
            </form>

                        <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/eventi/tornei/nuovo" class="gcat-btn-create">
                <i class="ti ti-plus"></i> Nuovo Torneo
            </a>
        </div>
    </div>

    <div class="gcat-layout">

                <aside class="gcat-sidebar">
            <h3 class="gcat-filter-title"><i class="ti ti-filter"></i> Filtri</h3>

            <form method="get" action="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/eventi/tornei">
                <div class="gcat-filter-group">
                    <label class="gcat-filter-label" for="filtro-data">Data evento</label>
                    <input type="date"
                           class="gcat-filter-date"
                           id="filtro-data"
                           name="filtro_data"
                           value="<?php if ((true && ($_smarty_tpl->hasVariable('filtri') && null !== ($_smarty_tpl->getValue('filtri') ?? null))) && (true && (true && null !== ($_smarty_tpl->getValue('filtri')['data'] ?? null)))) {
echo $_smarty_tpl->getValue('filtri')['data'];
}?>"
                           onchange="this.form.submit()">
                </div>

                <div class="gcat-filter-actions">
                    <a class="gcat-filter-reset" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/eventi/tornei">
                        <i class="ti ti-refresh"></i> Rimuovi filtro
                    </a>
                </div>
            </form>
        </aside>

                <main class="gcat-grid">
            <?php if ((true && ($_smarty_tpl->hasVariable('eventi') && null !== ($_smarty_tpl->getValue('eventi') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('eventi')) > 0) {?>
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('eventi'), 'evento');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('evento')->value) {
$foreach0DoElse = false;
?>
                    <?php $_smarty_tpl->assign('stato', mb_strtolower((string) $_smarty_tpl->getValue('evento')['statoEvento'], 'UTF-8'), false, NULL);?>
                    <article class="gcat-card<?php if ($_smarty_tpl->getValue('stato') == 'terminato') {?> gcat-card--concluded<?php }?>">

                        <div class="gcat-card__img-wrapper">
                            <img src="<?php echo $_smarty_tpl->getValue('evento')['imgEvento'];?>
" alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['nomeEvento'], ENT_QUOTES, 'UTF-8', true);?>
" class="gcat-card__img">
                            <span class="gcat-card__status gcat-card__status--<?php echo $_smarty_tpl->getValue('stato');?>
"><?php echo $_smarty_tpl->getValue('evento')['statoEvento'];?>
</span>
                            <?php if ($_smarty_tpl->getValue('evento')['richiedeQuota']) {?>
                                <span class="gcat-card__quota">&euro;<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('evento')['quotaIscrizione'],2);?>
</span>
                            <?php }?>
                        </div>

                        <div class="gcat-card__body">
                            <span class="gcat-card__type">Torneo &middot; <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['gioco'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                            <h3 class="gcat-card__name"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['nomeEvento'], ENT_QUOTES, 'UTF-8', true);?>
</h3>

                            <div class="gcat-card__meta">
                                <span class="gcat-card__meta-row">
                                    <i class="ti ti-calendar"></i> <?php echo $_smarty_tpl->getSmarty()->getModifierCallback('date_format')($_smarty_tpl->getValue('evento')['dataInizio'],"%d %B %Y, %H:%M");?>

                                </span>
                                <span class="gcat-card__meta-row<?php if ($_smarty_tpl->getValue('evento')['postiDisponibili'] <= 0) {?> gcat-card__seats-full<?php }?>">
                                    <i class="ti ti-users"></i>
                                    <?php echo $_smarty_tpl->getValue('evento')['numeroPartecipanti'];?>
 / <?php echo $_smarty_tpl->getValue('evento')['maxPartecipanti'];?>
 iscritti
                                    <?php if ($_smarty_tpl->getValue('evento')['postiDisponibili'] <= 0) {?>&mdash; Al completo<?php }?>
                                </span>
                                <span class="gcat-card__meta-row">
                                    <i class="ti ti-gift"></i> Premio: <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['premio'], ENT_QUOTES, 'UTF-8', true);?>

                                </span>
                                <?php if ($_smarty_tpl->getValue('evento')['challenge']) {?>
                                    <span class="gcat-card__meta-row">
                                        <i class="ti ti-swords"></i>
                                        Parte della challenge
                                        <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/eventi/dettaglio/<?php echo $_smarty_tpl->getValue('evento')['challenge']['idEvento'];?>
" class="gcat-card__sub-event-tag"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['challenge']['nomeEvento'], ENT_QUOTES, 'UTF-8', true);?>
</a>
                                    </span>
                                <?php }?>
                            </div>
                        </div>

                                                <div class="gcat-card__footer">
                            <?php if ($_smarty_tpl->getValue('evento')['richiedeQuota']) {?>
                                <span class="gcat-card__price">&euro;<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('evento')['quotaIscrizione'],2);?>
</span>
                            <?php } else { ?>
                                <span class="gcat-card__price-free">Gratuito</span>
                            <?php }?>
                            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/eventi/dettaglio/<?php echo $_smarty_tpl->getValue('evento')['idEvento'];?>
" class="gcat-btn-manage">
                                <i class="ti ti-eye"></i> Vedi dettaglio
                            </a>
                        </div>
                    </article>
                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
            <?php } else { ?>
                <div class="gcat-empty">
                    <span class="gcat-empty__icon"><i class="ti ti-trophy-off"></i></span>
                    <h3 class="gcat-empty__title">Nessun torneo trovato</h3>
                    <p class="gcat-empty__text">
                        <?php if ((true && ($_smarty_tpl->hasVariable('filtri') && null !== ($_smarty_tpl->getValue('filtri') ?? null))) && (true && (true && null !== ($_smarty_tpl->getValue('filtri')['data'] ?? null))) && $_smarty_tpl->getValue('filtri')['data']) {?>
                            Non ci sono tornei programmati per la data selezionata.
                        <?php } else { ?>
                            Non è stato ancora pubblicato nessun torneo.
                        <?php }?>
                    </p>
                    <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/eventi/tornei/nuovo" class="gcat-btn-create">
                        <i class="ti ti-plus"></i> Crea il primo torneo
                    </a>
                </div>
            <?php }?>
        </main>

    </div>

</div>

<?php
}
}
/* {/block "content"} */
}
