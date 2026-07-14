<?php
/* Smarty version 5.8.0, created on 2026-07-13 17:34:18
  from 'file:dettagliTorneo.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a55057a068fc2_34112955',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c3ee87419eeb33b27ae1cc6a05c253077a0f79af' => 
    array (
      0 => 'dettagliTorneo.tpl',
      1 => 1783956825,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a55057a068fc2_34112955 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>



<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_2752687226a55057a0563a7_38897168', "content");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "content"} */
class Block_2752687226a55057a0563a7_38897168 extends \Smarty\Runtime\Block
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
                <img src="<?php echo $_smarty_tpl->getValue('torneo')['immagine'];?>
" alt="<?php echo $_smarty_tpl->getValue('torneo')['nome'];?>
" class="dettaglio-img">
            </div>

            <div class="dettaglio-info">
                <h1 class="dettaglio-nome" style="color: #2c3e7a;"><?php echo $_smarty_tpl->getValue('torneo')['nome'];?>
</h1>

                <ul class="dettaglio-meta">
                    <li><i class="ti ti-calendar-event"></i> <?php echo $_smarty_tpl->getValue('torneo')['data'];?>
</li>
                    <li><i class="ti ti-users"></i> <?php echo $_smarty_tpl->getValue('torneo')['postiLiberi'];?>
 / <?php echo $_smarty_tpl->getValue('torneo')['postiTotali'];?>
 posti liberi</li>
                    <li><i class="ti ti-chess-king"></i> <?php echo $_smarty_tpl->getValue('torneo')['nomeAttivita'];?>
</li>
                </ul>
            </div>

            <div class="dettaglio-prezzo-box">

                <?php if ($_smarty_tpl->getValue('torneo')['premio']) {?>
                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/prodotto/<?php echo $_smarty_tpl->getValue('torneo')['premio']['id'];?>
" class="dettaglio-premio-card">
                    <div class="dettaglio-premio-img-wrapper">
                        <img src="<?php echo $_smarty_tpl->getValue('torneo')['premio']['immagine'];?>
" alt="<?php echo $_smarty_tpl->getValue('torneo')['premio']['nome'];?>
" class="dettaglio-premio-img">
                    </div>
                    <div class="dettaglio-premio-info">
                        <span class="dettaglio-premio-label">Premio in palio</span>
                        <span class="dettaglio-premio-nome"><?php echo $_smarty_tpl->getValue('torneo')['premio']['nome'];?>
</span>
                    </div>
                </a>
                <?php }?>

                <div class="dettaglio-prezzo-tot">
                    <span class="dettaglio-prezzo-tot-label">Totale</span>
                    <span class="dettaglio-prezzo-tot-value" id="prezzo-tot-<?php echo $_smarty_tpl->getValue('torneo')['id'];?>
">€ <?php echo $_smarty_tpl->getValue('torneo')['prezzo'];?>
</span>
                </div>

                <button type="button" class="btn-iscriviti" data-id="<?php echo $_smarty_tpl->getValue('torneo')['id'];?>
">
                    Iscriviti
                </button>
            </div>

        </div>

        <!-- ── DESCRIZIONE ── -->
        <div class="dettaglio-descrizione">
            <h2 class="dettaglio-section-title">Descrizione</h2>
            <p class="dettaglio-descrizione-testo"><?php echo $_smarty_tpl->getValue('torneo')['descrizione'];?>
</p>
        </div>

        <!-- ── CHALLENGE DI APPARTENENZA (se presente) ── -->
        <?php if ($_smarty_tpl->getValue('torneo')['challenge']) {?>
        <div class="dettaglio-correlati">
            <h2 class="dettaglio-section-title">Fa parte della Challenge</h2>
            <div class="dettaglio-correlati-grid">
                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/challenge/<?php echo $_smarty_tpl->getValue('torneo')['challenge']['id'];?>
" class="dettaglio-correlato-card">
                    <div class="dettaglio-correlato-img-wrapper">
                        <img src="<?php echo $_smarty_tpl->getValue('torneo')['challenge']['immagine'];?>
" alt="<?php echo $_smarty_tpl->getValue('torneo')['challenge']['nome'];?>
" class="dettaglio-correlato-img">
                    </div>
                    <p class="dettaglio-correlato-nome"><?php echo $_smarty_tpl->getValue('torneo')['challenge']['nome'];?>
</p>
                </a>
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
