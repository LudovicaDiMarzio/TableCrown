<?php
/* Smarty version 5.8.0, created on 2026-07-18 21:56:16
  from 'file:catalogo_tornei.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a5bda60d97d38_93434885',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a524171fbb5497b11b5331620d3555a287bc7536' => 
    array (
      0 => 'catalogo_tornei.tpl',
      1 => 1784404017,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a5bda60d97d38_93434885 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_7846866076a5bda60d6b976_45506614', "content");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "content"} */
class Block_7846866076a5bda60d6b976_45506614 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/css/catalogo_tornei.css">

<div class="eventi-lista-container">
    <div class="container">

        <?php if ((true && ($_smarty_tpl->hasVariable('breadcrumbs') && null !== ($_smarty_tpl->getValue('breadcrumbs') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('breadcrumbs')) > 0) {?>
        <nav class="eventi-breadcrumb">
            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('breadcrumbs'), 'crumb', true);
$_smarty_tpl->getVariable('crumb')->iteration = 0;
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('crumb')->value) {
$foreach0DoElse = false;
$_smarty_tpl->getVariable('crumb')->iteration++;
$_smarty_tpl->getVariable('crumb')->last = $_smarty_tpl->getVariable('crumb')->iteration === $_smarty_tpl->getVariable('crumb')->total;
$foreach0Backup = clone $_smarty_tpl->getVariable('crumb');
?>
                <?php if ($_smarty_tpl->getVariable('crumb')->last) {?>
                    <span><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('crumb')['label'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                <?php } else { ?>
                    <a href="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('crumb')['url'], ENT_QUOTES, 'UTF-8', true);?>
"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('crumb')['label'], ENT_QUOTES, 'UTF-8', true);?>
</a>
                    <i class="ti ti-chevron-right"></i>
                <?php }?>
            <?php
$_smarty_tpl->setVariable('crumb', $foreach0Backup);
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
        </nav>
        <?php }?>

        <div class="eventi-lista-layout">

            <aside class="eventi-sidebar">
                <h2 class="eventi-filtri-title">Filtri</h2>

                <form id="form-filtri-eventi" class="eventi-filtri-form" method="get" action="<?php echo $_smarty_tpl->getValue('base_url');?>
/eventi/tornei">

                    <div class="eventi-filter-group">
                        <h3 class="eventi-filter-group-title">Cerca</h3>
                        <input type="text"
                               name="query_string"
                               class="eventi-ricerca-input"
                               placeholder="Cerca per nome..."
                               value="<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('filtri')['query_string'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
">
                    </div>

                    <div class="eventi-filter-group eventi-filter-group-last">
                        <h3 class="eventi-filter-group-title">Data</h3>
                        <input type="date" name="data" class="eventi-date-input" value="<?php echo (($tmp = $_smarty_tpl->getValue('filtri')['data'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
">
                        <button type="submit" class="button btn-apply-data">
                            <i class="ti ti-check"></i> Applica filtri
                        </button>
                    </div>

                </form>
            </aside>

            <div class="eventi-lista-main">
                <div class="eventi-grid">
                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('eventi'), 'evento');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('evento')->value) {
$foreach1DoElse = false;
?>
                    <?php $_smarty_tpl->assign('stato', $_smarty_tpl->getValue('evento')['statoEvento'], false, NULL);?>
                    <?php $_smarty_tpl->assign('passato', ($_smarty_tpl->getValue('stato') == 'Terminato'), false, NULL);?>
                    <?php $_smarty_tpl->assign('postiDisponibili', $_smarty_tpl->getValue('evento')['maxPartecipanti']-$_smarty_tpl->getValue('evento')['numeroPartecipanti'], false, NULL);?>
                    <?php $_smarty_tpl->assign('esaurito', ($_smarty_tpl->getValue('postiDisponibili') <= 0), false, NULL);?>

                    <article class="evento-list-card<?php if ($_smarty_tpl->getValue('passato')) {?> evento-list-card-passato<?php }
if ($_smarty_tpl->getValue('esaurito')) {?> evento-list-card-esaurito<?php }?>">

                        <?php if ($_smarty_tpl->getValue('esaurito')) {?>
                        <span class="evento-badge-esaurito">Posti esauriti</span>
                        <?php }?>

                        <h3 class="evento-list-nome">
                            <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['nomeEvento'], ENT_QUOTES, 'UTF-8', true);?>

                            <?php if ($_smarty_tpl->getValue('passato')) {?><span class="evento-passato-label">(passato)</span><?php }?>
                        </h3>

                        <div class="evento-list-image-wrapper">
                            <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/image/eventi/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['imgEvento'], ENT_QUOTES, 'UTF-8', true);?>
"
                                 alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['nomeEvento'], ENT_QUOTES, 'UTF-8', true);?>
"
                                 class="evento-list-image">
                        </div>

                        <div class="evento-list-meta-row">
                            <span class="evento-tipo-badge"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['gioco'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                            <span class="evento-prezzo">
                                <?php echo sprintf("%.2f",$_smarty_tpl->getValue('evento')['quotaIscrizione']);?>
 €
                            </span>
                        </div>

                        <div class="evento-list-info-row">
                            <span class="evento-data">
                                <i class="ti ti-calendar"></i> <?php echo $_smarty_tpl->getSmarty()->getModifierCallback('date_format')($_smarty_tpl->getValue('evento')['dataInizio'],"%d/%m/%Y");?>

                            </span>
                            <span class="evento-ora">
                                <i class="ti ti-clock"></i> <?php echo $_smarty_tpl->getSmarty()->getModifierCallback('date_format')($_smarty_tpl->getValue('evento')['dataInizio'],"%H:%M");?>

                            </span>
                        </div>

                        <div class="evento-posti">
                            Posti disponibili: <strong><?php echo $_smarty_tpl->getValue('postiDisponibili');?>
/<?php echo $_smarty_tpl->getValue('evento')['maxPartecipanti'];?>
</strong>
                        </div>

                        <?php if ($_smarty_tpl->getValue('evento')['challenge']) {?>
                        <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/eventi/dettaglio/<?php echo $_smarty_tpl->getValue('evento')['challenge']['idEvento'];?>
" class="evento-challenge-link">
                            <i class="ti ti-trophy"></i> Fa parte della challenge: <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['challenge']['nomeEvento'], ENT_QUOTES, 'UTF-8', true);?>

                        </a>
                        <?php }?>

                        <div class="evento-list-actions">
                            <?php if ($_smarty_tpl->getValue('passato')) {?>
                                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/eventi/risultati/<?php echo $_smarty_tpl->getValue('evento')['idEvento'];?>
" class="btn-evento-secondary">
                                    Visualizza risultati
                                </a>
                            <?php } else { ?>
                                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/eventi/dettaglio/<?php echo $_smarty_tpl->getValue('evento')['idEvento'];?>
" class="btn-evento-primary">
                                    Scopri di più
                                </a>
                            <?php }?>
                        </div>

                    </article>
                    <?php
}
if ($foreach1DoElse) {
?>
                    <p class="eventi-lista-empty">Nessun torneo trovato.</p>
                    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                </div>
            </div>

        </div>
    </div>
</div>
<?php
}
}
/* {/block "content"} */
}
