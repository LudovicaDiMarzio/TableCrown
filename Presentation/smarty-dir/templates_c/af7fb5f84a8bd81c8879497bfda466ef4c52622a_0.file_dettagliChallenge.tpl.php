<?php
/* Smarty version 5.8.0, created on 2026-07-20 21:26:37
  from 'file:dettagliChallenge.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a5e766d6d20e0_75709653',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'af7fb5f84a8bd81c8879497bfda466ef4c52622a' => 
    array (
      0 => 'dettagliChallenge.tpl',
      1 => 1784575592,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a5e766d6d20e0_75709653 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>



<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_15712100616a5e766d6bc4b8_15779724', "content");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "content"} */
class Block_15712100616a5e766d6bc4b8_15779724 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/css/dettagli.css">

<div class="dettaglio-container">
    <div class="container">

        <!-- ── BLOCCO SUPERIORE (con box prezzo) ── -->
        <div class="dettaglio-top dettaglio-top--con-prezzo">

            <div class="dettaglio-gallery">
                <img src="<?php echo $_smarty_tpl->getValue('challenge')['imgEvento'];?>
" alt="<?php echo $_smarty_tpl->getValue('challenge')['nomeEvento'];?>
" class="dettaglio-img">
            </div>

            <div class="dettaglio-info">
                <h1 class="dettaglio-nome" style="color: #2c3e7a;"><?php echo $_smarty_tpl->getValue('challenge')['nomeEvento'];?>
</h1>

                <ul class="dettaglio-meta">
                    <li><i class="ti ti-calendar-event"></i> <?php echo $_smarty_tpl->getValue('challenge')['dataInizio'];?>
</li>
                    <li><i class="ti ti-users"></i> <?php echo $_smarty_tpl->getValue('challenge')['postiRimanenti'];?>
 / <?php echo $_smarty_tpl->getValue('challenge')['maxPartecipanti'];?>
 posti liberi</li>
                </ul>
            </div>

            <div class="dettaglio-prezzo-box">

                <?php if ($_smarty_tpl->getValue('challenge')['premio']) {?>
                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/prodotto?id=<?php echo $_smarty_tpl->getValue('challenge')['premio']['id'];?>
" class="dettaglio-premio-card">
                    <div class="dettaglio-premio-img-wrapper">
                        <img src="<?php echo $_smarty_tpl->getValue('challenge')['premio']['immagine'];?>
" alt="<?php echo $_smarty_tpl->getValue('challenge')['premio']['nome'];?>
" class="dettaglio-premio-img">
                    </div>
                    <div class="dettaglio-premio-info">
                        <span class="dettaglio-premio-label">Premio in palio</span>
                        <span class="dettaglio-premio-nome"><?php echo $_smarty_tpl->getValue('challenge')['premio']['nome'];?>
</span>
                    </div>
                </a>
                <?php }?>

                <div class="dettaglio-prezzo-tot">
                    <span class="dettaglio-prezzo-tot-label">Totale</span>
                    <span class="dettaglio-prezzo-tot-value" id="prezzo-tot-<?php echo $_smarty_tpl->getValue('challenge')['idEvento'];?>
">€ <?php echo $_smarty_tpl->getValue('challenge')['quotaIscrizione'];?>
</span>
                </div>

                <button type="button" class="btn-iscriviti" data-id="<?php echo $_smarty_tpl->getValue('challenge')['idEvento'];?>
">
                    Iscriviti
                </button>
            </div>

        </div>

        <!-- ── DESCRIZIONE ── -->
        <div class="dettaglio-descrizione">
            <h2 class="dettaglio-section-title">Descrizione</h2>
            <p class="dettaglio-descrizione-testo"><?php echo $_smarty_tpl->getValue('challenge')['descrizioneEvento'];?>
</p>
        </div>

        <!-- ── TORNEI INCLUSI (se presenti) ── -->
        <?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('challenge')['tornei']) > 0) {?>
        <div class="dettaglio-correlati">
            <h2 class="dettaglio-section-title">Tornei inclusi</h2>
            <div class="dettaglio-correlati-grid">
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('challenge')['tornei'], 'torneo');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('torneo')->value) {
$foreach0DoElse = false;
?>
                    <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/eventi/dettaglio?id=<?php echo $_smarty_tpl->getValue('torneo')['idEvento'];?>
" class="dettaglio-correlato-card">
                        <div class="dettaglio-correlato-img-wrapper">
                            <img src="<?php echo $_smarty_tpl->getValue('torneo')['imgEvento'];?>
" alt="<?php echo $_smarty_tpl->getValue('torneo')['nomeEvento'];?>
" class="dettaglio-correlato-img">
                        </div>
                        <p class="dettaglio-correlato-nome"><?php echo $_smarty_tpl->getValue('torneo')['nomeEvento'];?>
</p>
                        <p class="dettaglio-correlato-data"><?php echo $_smarty_tpl->getValue('torneo')['dataInizio'];?>
</p>
                    </a>
                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
            </div>
        </div>
        <?php }?>

    </div>
</div>
<?php
}
}
/* {/block "content"} */
}
