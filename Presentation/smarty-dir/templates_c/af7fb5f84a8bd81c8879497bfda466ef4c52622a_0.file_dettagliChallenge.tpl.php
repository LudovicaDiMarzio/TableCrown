<?php
/* Smarty version 5.8.0, created on 2026-07-13 17:29:08
  from 'file:dettagliChallenge.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a55044447d815_44345084',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'af7fb5f84a8bd81c8879497bfda466ef4c52622a' => 
    array (
      0 => 'dettagliChallenge.tpl',
      1 => 1783956544,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a55044447d815_44345084 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>



<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_7143112916a550444467364_57953242', "content");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "content"} */
class Block_7143112916a550444467364_57953242 extends \Smarty\Runtime\Block
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
                <img src="<?php echo $_smarty_tpl->getValue('challenge')['immagine'];?>
" alt="<?php echo $_smarty_tpl->getValue('challenge')['nome'];?>
" class="dettaglio-img">
            </div>

            <div class="dettaglio-info">
                <h1 class="dettaglio-nome" style="color: #2c3e7a;"><?php echo $_smarty_tpl->getValue('challenge')['nome'];?>
</h1>

                <ul class="dettaglio-meta">
                    <li><i class="ti ti-calendar-event"></i> <?php echo $_smarty_tpl->getValue('challenge')['data'];?>
</li>
                    <li><i class="ti ti-users"></i> <?php echo $_smarty_tpl->getValue('challenge')['postiLiberi'];?>
 / <?php echo $_smarty_tpl->getValue('challenge')['postiTotali'];?>
 posti liberi</li>
                    <li><i class="ti ti-chess-king"></i> <?php echo $_smarty_tpl->getValue('challenge')['nomeAttivita'];?>
</li>
                </ul>
            </div>

            <div class="dettaglio-prezzo-box">

                <?php if ($_smarty_tpl->getValue('challenge')['premio']) {?>
                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/prodotto/<?php echo $_smarty_tpl->getValue('challenge')['premio']['id'];?>
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
                    <span class="dettaglio-prezzo-tot-value" id="prezzo-tot-<?php echo $_smarty_tpl->getValue('challenge')['id'];?>
">€ <?php echo $_smarty_tpl->getValue('challenge')['prezzo'];?>
</span>
                </div>

                <button type="button" class="btn-iscriviti" data-id="<?php echo $_smarty_tpl->getValue('challenge')['id'];?>
">
                    Iscriviti
                </button>
            </div>

        </div>

        <!-- ── DESCRIZIONE ── -->
        <div class="dettaglio-descrizione">
            <h2 class="dettaglio-section-title">Descrizione</h2>
            <p class="dettaglio-descrizione-testo"><?php echo $_smarty_tpl->getValue('challenge')['descrizione'];?>
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
/torneo/<?php echo $_smarty_tpl->getValue('torneo')['id'];?>
" class="dettaglio-correlato-card">
                        <div class="dettaglio-correlato-img-wrapper">
                            <img src="<?php echo $_smarty_tpl->getValue('torneo')['immagine'];?>
" alt="<?php echo $_smarty_tpl->getValue('torneo')['nome'];?>
" class="dettaglio-correlato-img">
                        </div>
                        <p class="dettaglio-correlato-nome"><?php echo $_smarty_tpl->getValue('torneo')['nome'];?>
</p>
                        <p class="dettaglio-correlato-data"><?php echo $_smarty_tpl->getValue('torneo')['data'];?>
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
