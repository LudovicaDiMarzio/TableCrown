<?php
/* Smarty version 5.8.0, created on 2026-07-18 18:42:28
  from 'file:eventi.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a5bacf43f24d3_65695740',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a57521546b04613aa83ac77d48db77d02dc238a7' => 
    array (
      0 => 'eventi.tpl',
      1 => 1784392945,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a5bacf43f24d3_65695740 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_20450050556a5bacf43ed8b3_31282077', "content");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "content"} */
class Block_20450050556a5bacf43ed8b3_31282077 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/css/eventi.css">

<div class="eventi-container">
    <div class="container">

        <div class="eventi-grid">

            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/eventi/serate" class="evento-card-link">
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
/eventi/tornei" class="evento-card-link">
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
/eventi/challenge" class="evento-card-link">
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
