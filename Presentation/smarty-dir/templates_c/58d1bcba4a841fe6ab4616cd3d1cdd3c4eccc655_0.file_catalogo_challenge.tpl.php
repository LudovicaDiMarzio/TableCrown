<?php
/* Smarty version 5.8.0, created on 2026-06-19 16:51:44
  from 'file:catalogo_challenge.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a3557803f4858_25286704',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '58d1bcba4a841fe6ab4616cd3d1cdd3c4eccc655' => 
    array (
      0 => 'catalogo_challenge.tpl',
      1 => 1781880519,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a3557803f4858_25286704 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\damic\\Desktop\\uni\\APPUNTI\\anno3\\secondo_semenstre\\Pweb\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_9672502786a3557803c6145_30188615', "content");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "content"} */
class Block_9672502786a3557803c6145_30188615 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\damic\\Desktop\\uni\\APPUNTI\\anno3\\secondo_semenstre\\Pweb\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/css/catalogo_challenge.css">

<div class="eventi-lista-container">
    <div class="container">

        <nav class="eventi-breadcrumb">
            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/">Home</a>
            <i class="ti ti-chevron-right"></i>
            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/eventi">Eventi</a>
            <i class="ti ti-chevron-right"></i>
            <span>Challenge</span>
        </nav>

        <div class="eventi-lista-layout">

            <aside class="eventi-sidebar">
                <h2 class="eventi-filtri-title">Filtri</h2>

                <form id="form-filtri-eventi" class="eventi-filtri-form" method="get" action="<?php echo $_smarty_tpl->getValue('base_url');?>
/catalogo/challenge">

                    <div class="eventi-filter-group">
                        <h3 class="eventi-filter-group-title">Data</h3>
                        <input type="date" name="data" class="eventi-date-input" value="<?php echo (($tmp = $_smarty_tpl->getValue('filtri')['data'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
">
                        <button type="submit" class="button btn-apply-data">
                            <i class="ti ti-check"></i> Applica Data
                        </button>
                    </div>

                    <div class="eventi-filter-group eventi-filter-group-last">
                        <div class="eventi-radio-options">
                            <label class="eventi-radio-label">
                                <input type="radio" name="stato" value="passati"
                                       <?php if ($_smarty_tpl->getValue('filtri')['stato'] == 'passati') {?>checked<?php }?>>
                                <span class="eventi-radio-text">Challenge passate</span>
                            </label>
                            <label class="eventi-radio-label">
                                <input type="radio" name="stato" value="programma"
                                       <?php if ($_smarty_tpl->getValue('filtri')['stato'] == 'programma' || !$_smarty_tpl->getValue('filtri')['stato']) {?>checked<?php }?>>
                                <span class="eventi-radio-text">Challenge in programma</span>
                            </label>
                        </div>
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
                    <?php $_smarty_tpl->assign('stato', $_smarty_tpl->getValue('evento')->getStatoEvento()->name, false, NULL);?>
                    <?php $_smarty_tpl->assign('passato', ($_smarty_tpl->getValue('stato') == 'Terminato'), false, NULL);?>
                    <?php $_smarty_tpl->assign('postiDisponibili', $_smarty_tpl->getValue('evento')->getMaxPartecipanti()-$_smarty_tpl->getValue('evento')->getNumeroPartecipanti(), false, NULL);?>
                    <?php $_smarty_tpl->assign('quota', $_smarty_tpl->getValue('evento')->getQuotaIscrizione(), false, NULL);?>

                    <article class="evento-list-card<?php if ($_smarty_tpl->getValue('passato')) {?> evento-list-card-passato<?php }?>">

                        <h3 class="evento-list-nome">
                            <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')->getNomeEvento(), ENT_QUOTES, 'UTF-8', true);?>

                            <?php if ($_smarty_tpl->getValue('passato')) {?><span class="evento-passato-label">(passata)</span><?php }?>
                        </h3>

                        <div class="evento-list-image-wrapper">
                            <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/image/eventi/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')->getImgEvento(), ENT_QUOTES, 'UTF-8', true);?>
"
                                 alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')->getNomeEvento(), ENT_QUOTES, 'UTF-8', true);?>
"
                                 class="evento-list-image">
                        </div>

                        <div class="evento-list-meta-row">
                            <span class="evento-tipo-badge">Challenge</span>
                            <span class="evento-prezzo">
                                <?php if ($_smarty_tpl->getValue('quota')->hasSconto()) {?>
                                    <span class="evento-prezzo-originale"><?php echo sprintf("%.2f",$_smarty_tpl->getValue('quota')->getValore());?>
 <?php echo $_smarty_tpl->getValue('quota')->getValuta()->name;?>
</span>
                                    <?php echo sprintf("%.2f",$_smarty_tpl->getValue('quota')->calcolaPrezzoScontato());?>
 <?php echo $_smarty_tpl->getValue('quota')->getValuta()->name;?>

                                <?php } else { ?>
                                    <?php echo sprintf("%.2f",$_smarty_tpl->getValue('quota')->getValore());?>
 <?php echo $_smarty_tpl->getValue('quota')->getValuta()->name;?>

                                <?php }?>
                            </span>
                        </div>

                        <div class="evento-list-info-row">
                            <span class="evento-data">
                                <i class="ti ti-calendar"></i> <?php echo $_smarty_tpl->getSmarty()->getModifierCallback('date_format')($_smarty_tpl->getValue('evento')->getDataInizio(),"%d/%m/%Y");?>

                            </span>
                            <span class="evento-ora">
                                <i class="ti ti-clock"></i> <?php echo $_smarty_tpl->getSmarty()->getModifierCallback('date_format')($_smarty_tpl->getValue('evento')->getDataInizio(),"%H:%M");?>

                            </span>
                        </div>

                        <div class="evento-posti">
                            Posti disponibili: <strong><?php echo $_smarty_tpl->getValue('postiDisponibili');?>
/<?php echo $_smarty_tpl->getValue('evento')->getMaxPartecipanti();?>
</strong>
                        </div>

                        <div class="evento-list-actions">
                            <?php if ($_smarty_tpl->getValue('passato')) {?>
                                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/eventi/risultati/<?php echo $_smarty_tpl->getValue('evento')->getIdEvento();?>
" class="btn-evento-secondary">
                                    Visualizza risultati
                                </a>
                            <?php } else { ?>
                                <div class="evento-stepper" data-max="<?php echo $_smarty_tpl->getValue('postiDisponibili');?>
">
                                    <button type="button" class="evento-stepper-btn" data-action="decrease">−</button>
                                    <input type="number" class="evento-stepper-input" value="1" min="1" max="<?php echo $_smarty_tpl->getValue('postiDisponibili');?>
">
                                    <button type="button" class="evento-stepper-btn" data-action="increase">+</button>
                                </div>
                                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/eventi/prenota/<?php echo $_smarty_tpl->getValue('evento')->getIdEvento();?>
" class="btn-evento-primary">
                                    Prenota
                                </a>
                            <?php }?>
                        </div>

                        <?php if (!$_smarty_tpl->getValue('passato')) {?>
                        <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/eventi/dettaglio/<?php echo $_smarty_tpl->getValue('evento')->getIdEvento();?>
" class="evento-scopri-link">
                            Scopri di più
                        </a>
                        <?php }?>

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

<?php echo '<script'; ?>
>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form-filtri-eventi');
    if (form) {
        form.querySelectorAll('input[type="radio"]').forEach(function (input) {
            input.addEventListener('change', function () {
                form.submit();
            });
        });
    }

    document.querySelectorAll('.evento-stepper').forEach(function (stepper) {
        const max = parseInt(stepper.dataset.max, 10) || 99;
        const input = stepper.querySelector('.evento-stepper-input');

        stepper.querySelectorAll('.evento-stepper-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                let value = parseInt(input.value, 10) || 1;
                if (btn.dataset.action === 'increase' && value < max) value++;
                if (btn.dataset.action === 'decrease' && value > 1) value--;
                input.value = value;
            });
        });
    });
});
<?php echo '</script'; ?>
>
<?php
}
}
/* {/block "content"} */
}
