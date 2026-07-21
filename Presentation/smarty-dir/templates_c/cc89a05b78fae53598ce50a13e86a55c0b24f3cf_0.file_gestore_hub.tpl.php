<?php
/* Smarty version 5.8.0, created on 2026-07-21 17:09:19
  from 'file:gestore_hub.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a5f8b9f6fc948_80769556',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cc89a05b78fae53598ce50a13e86a55c0b24f3cf' => 
    array (
      0 => 'gestore_hub.tpl',
      1 => 1784555516,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a5f8b9f6fc948_80769556 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_16705763886a5f8b9f6e9fa6_51486117', "page_css");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_9570916376a5f8b9f6ec153_61130763', "content");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "layout_gestore.tpl", $_smarty_current_dir);
}
/* {block "page_css"} */
class Block_16705763886a5f8b9f6e9fa6_51486117 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

    <link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/css/hub_gestore.css">
<?php
}
}
/* {/block "page_css"} */
/* {block "content"} */
class Block_9570916376a5f8b9f6ec153_61130763 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

    <div class="hub-header">
        <h1 class="hub-header__title">Dashboard Gestore</h1>
        <p class="hub-header__subtitle">Panoramica delle attività del negozio</p>
    </div>

        <div class="hub-stats">
        <div class="hub-stat-card">
            <span class="hub-stat-card__icon hub-stat-card__icon--orders"><span class="ti ti-shopping-cart"></span></span>
            <div class="hub-stat-card__body">
                <span class="hub-stat-card__label">Ordini totali</span>
                <span class="hub-stat-card__value"><?php echo $_smarty_tpl->getValue('ordiniTotali');?>
</span>
            </div>
        </div>

        <div class="hub-stat-card">
            <span class="hub-stat-card__icon hub-stat-card__icon--sales"><span class="ti ti-currency-euro"></span></span>
            <div class="hub-stat-card__body">
                <span class="hub-stat-card__label">Vendite totali</span>
                <span class="hub-stat-card__value">&euro; <?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('venditeTotali'),2,",",".");?>
</span>
            </div>
        </div>
    </div>

    <div class="hub-grid">

                <section class="hub-panel hub-panel--events">
            <div class="hub-panel__header">
                <h2 class="hub-panel__title">Prossimi Eventi</h2>
                <span class="hub-panel__count"><?php echo $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('prossimiEventi'));?>
</span>
            </div>

            <?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('prossimiEventi')) === 0) {?>
                <p class="hub-empty">Nessun evento in programma al momento.</p>
            <?php } else { ?>
                <div class="hub-event-list">
                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('prossimiEventi'), 'evento');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('evento')->value) {
$foreach0DoElse = false;
?>
                                                <?php if ($_smarty_tpl->getValue('evento')['tipo'] === 'serata') {?>
                            <?php $_smarty_tpl->assign('urlTipoEvento', "serate", false, NULL);?>
                            <?php $_smarty_tpl->assign('labelTipoEvento', "Serata", false, NULL);?>
                        <?php } elseif ($_smarty_tpl->getValue('evento')['tipo'] === 'torneo') {?>
                            <?php $_smarty_tpl->assign('urlTipoEvento', "tornei", false, NULL);?>
                            <?php $_smarty_tpl->assign('labelTipoEvento', "Torneo", false, NULL);?>
                        <?php } else { ?>
                            <?php $_smarty_tpl->assign('urlTipoEvento', "challenge", false, NULL);?>
                            <?php $_smarty_tpl->assign('labelTipoEvento', "Challenge", false, NULL);?>
                        <?php }?>

                        <article class="hub-event-card">
                            <img src="<?php echo $_smarty_tpl->getValue('evento')['imgEvento'];?>
" alt="<?php echo $_smarty_tpl->getValue('evento')['nomeEvento'];?>
" class="hub-event-card__img">
                            <div class="hub-event-card__body">
                                <span class="hub-event-card__type"><?php echo $_smarty_tpl->getValue('labelTipoEvento');?>
</span>
                                <h3 class="hub-event-card__name"><?php echo $_smarty_tpl->getValue('evento')['nomeEvento'];?>
</h3>
                                <span class="hub-event-card__date">
                                    <span class="ti ti-calendar"></span>
                                    <?php echo $_smarty_tpl->getSmarty()->getModifierCallback('date_format')($_smarty_tpl->getValue('evento')['dataInizio'],"%d %B %Y");?>

                                </span>
                                <span class="hub-event-card__seats">
                                    <span class="ti ti-users"></span>
                                    <?php echo $_smarty_tpl->getValue('evento')['numeroPartecipanti'];?>
 / <?php echo $_smarty_tpl->getValue('evento')['maxPartecipanti'];?>
 iscritti
                                </span>
                            </div>
                            <div class="hub-event-card__actions">
                                <span class="hub-status-badge hub-status-badge--<?php echo mb_strtolower((string) $_smarty_tpl->getValue('evento')['statoEvento'], 'UTF-8');?>
"><?php echo $_smarty_tpl->getValue('evento')['statoEvento'];?>
</span>
                                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/eventi/<?php echo $_smarty_tpl->getValue('urlTipoEvento');?>
" class="hub-btn hub-btn--ghost">Gestisci</a>
                            </div>
                        </article>
                    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                </div>
            <?php }?>

            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/eventi/serate" class="hub-panel__more">Vedi tutti gli eventi &rarr;</a>
        </section>

                <section class="hub-panel hub-panel--actions">
            <div class="hub-panel__header">
                <h2 class="hub-panel__title">Azioni rapide</h2>
            </div>

            <div class="hub-quick-actions">
                                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/catalogo/giochi-da-tavolo/nuovo" class="hub-quick-action">
                    <span class="ti ti-plus"></span> Aggiungi prodotto
                </a>
                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/eventi/serate/nuovo" class="hub-quick-action hub-quick-action--gold">
                    <span class="ti ti-moon-stars"></span> Crea Serata
                </a>
                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/eventi/tornei/nuovo" class="hub-quick-action hub-quick-action--gold">
                    <span class="ti ti-trophy"></span> Crea Torneo
                </a>
                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/eventi/challenge/nuovo" class="hub-quick-action hub-quick-action--gold">
                    <span class="ti ti-swords"></span> Crea Challenge
                </a>
            </div>
        </section>

    </div>
<?php
}
}
/* {/block "content"} */
}
