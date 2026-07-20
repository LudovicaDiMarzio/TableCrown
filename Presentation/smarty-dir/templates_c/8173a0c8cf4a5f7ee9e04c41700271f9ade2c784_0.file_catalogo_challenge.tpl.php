<?php
/* Smarty version 5.8.0, created on 2026-07-20 20:55:49
  from 'file:catalogo_challenge.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a5e6f35312153_07745590',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8173a0c8cf4a5f7ee9e04c41700271f9ade2c784' => 
    array (
      0 => 'catalogo_challenge.tpl',
      1 => 1784573744,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a5e6f35312153_07745590 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_9988554896a5e6f352ec3f1_33075031', "content");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "content"} */
class Block_9988554896a5e6f352ec3f1_33075031 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/css/catalogo_challenge.css">

<div class="eventi-lista-container">
    <div class="container">

        
        

        <div class="eventi-lista-layout">

            <aside class="eventi-sidebar">
                <h2 class="eventi-filtri-title">Filtri</h2>

                <form id="form-filtri-eventi" class="eventi-filtri-form" method="get" action="<?php echo $_smarty_tpl->getValue('base_url');?>
/eventi/challenge">


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
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('evento')->value) {
$foreach0DoElse = false;
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

                            <?php if ($_smarty_tpl->getValue('passato')) {?><span class="evento-passato-label">(passata)</span><?php }?>
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
                            <span class="evento-tipo-badge">
                                <?php if ($_smarty_tpl->getValue('evento')['premio']) {?>Premio: <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['premio'], ENT_QUOTES, 'UTF-8', true);
}?>
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

                        <?php if ($_smarty_tpl->getValue('evento')['tornei'] && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('evento')['tornei']) > 0) {?>
                        <div class="evento-tornei-associati">
                            <span class="evento-tornei-label">Tornei che partecipano:</span>
                            <ul class="evento-tornei-lista">
                                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('evento')['tornei'], 'torneo');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('torneo')->value) {
$foreach1DoElse = false;
?>
                                <li><a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/eventi/dettaglio?id=<?php echo $_smarty_tpl->getValue('torneo')['idEvento'];?>
"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('torneo')['nomeEvento'], ENT_QUOTES, 'UTF-8', true);?>
</a></li>
                                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                            </ul>
                        </div>
                        <?php }?>

                        <div class="evento-list-actions">
                            <?php if ($_smarty_tpl->getValue('passato')) {?>
                                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/eventi/risultati?id=<?php echo $_smarty_tpl->getValue('evento')['idEvento'];?>
" class="btn-evento-secondary">
                                    Visualizza risultati
                                </a>
                            <?php } else { ?>
                                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/eventi/dettaglio?id=<?php echo $_smarty_tpl->getValue('evento')['idEvento'];?>
" class="btn-evento-primary">
                                    Scopri di più
                                </a>
                            <?php }?>
                        </div>

                    </article>
                    <?php
}
if ($foreach0DoElse) {
?>
                    <p class="eventi-lista-empty">Nessuna challenge trovata.</p>
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
