<?php
/* Smarty version 5.8.0, created on 2026-06-19 10:49:23
  from 'file:eventi.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a3502939026b7_30725120',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '82bb8d8b2cd3068441ef1aeddb9988914ccd5434' => 
    array (
      0 => 'eventi.tpl',
      1 => 1781858960,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a3502939026b7_30725120 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\damic\\Desktop\\uni\\APPUNTI\\anno3\\secondo_semenstre\\Pweb\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_16213973886a3502938fdcc9_75230335', "content");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "content"} */
class Block_16213973886a3502938fdcc9_75230335 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\damic\\Desktop\\uni\\APPUNTI\\anno3\\secondo_semenstre\\Pweb\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/css/eventi.css">

<div class="eventi-container">
    <div class="container">

        <nav class="eventi-breadcrumb">
            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/">Home</a>
            <i class="ti ti-chevron-right"></i>
            <span>Eventi</span>
        </nav>

        <div class="eventi-grid">

            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/catalogo?categoria=serate" class="evento-card-link">
                <article class="evento-card">
                    <h2 class="evento-title">Serate</h2>
                    <div class="evento-image-wrapper">
                        <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/image/eventi/serate.jpg" alt="Serate" class="evento-image">
                    </div>
                    <p class="evento-description">Serate a tema con giochi in compagnia, musica e tanto divertimento.</p>
                    <p class="evento-tagline">Vieni con noi, daaai!</p>
                </article>
            </a>

            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/catalogo?categoria=tornei" class="evento-card-link">
                <article class="evento-card">
                    <h2 class="evento-title">Tornei</h2>
                    <div class="evento-image-wrapper">
                        <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/image/eventi/tornei.jpg" alt="Tornei" class="evento-image">
                    </div>
                    <p class="evento-description">Sfide competitive tra giocatori, premi e tornei a eliminazione.</p>
                    <p class="evento-tagline">Si va a lettooo!!!</p>
                </article>
            </a>

            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/catalogo?categoria=challenge" class="evento-card-link">
                <article class="evento-card">
                    <h2 class="evento-title">Challenge</h2>
                    <div class="evento-image-wrapper">
                        <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/image/eventi/challenge.jpg" alt="Challenge" class="evento-image">
                    </div>
                    <p class="evento-description">Sblocca obiettivi, scala la classifica e conquista il podio.</p>
                    <p class="evento-tagline">Peffo'!!</p>
                </article>
            </a>

        </div>
    </div>
</div>
<?php
}
}
/* {/block "content"} */
}
