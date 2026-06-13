<?php
/* Smarty version 5.8.0, created on 2026-06-13 17:23:48
  from 'file:common/layout.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a2d760447cfc3_85671078',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f9277bd0b3187de50fdd053d3c3530717861ace7' => 
    array (
      0 => 'common/layout.tpl',
      1 => 1781253868,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a2d760447cfc3_85671078 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\damic\\Desktop\\uni\\APPUNTI\\anno3\\secondo_semenstre\\Pweb\\TableCrown\\Presentation\\smarty-dir\\templates\\common';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, false);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <title><?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_9802890196a2d760444ac79_20820778', "page_title");
?>
</title>

        <link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/plugins/bulma/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.19.0/dist/tabler-icons.min.css">
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/css/style.css">

    <?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_7255537346a2d760444bc91_33925177', "extra_css");
?>

</head>
<body>

                <nav class="navbar navigation" role="navigation" aria-label="navigazione principale">
        <div class="container is-fluid px-5"> 
            
            <div class="navbar-row-top-clean">
                
                <div class="navbar-brand-mobile-only">
                    <a role="button" class="navbar-burger" id="navbar-burger" aria-label="Apri menu" aria-expanded="false" data-target="navbar-menu-custom">
                        <span aria-hidden="true"></span>
                        <span aria-hidden="true"></span>
                        <span aria-hidden="true"></span>
                    </a>
                </div>

                <div id="navbar-menu-custom" class="navbar-menu-custom-links">
                    
                    <div class="navbar-center-links">
                        <a class="navbar-item<?php if ($_smarty_tpl->getValue('current_page') == 'catalogo') {?> is-active<?php }?>" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/catalogo">Catalogo</a>
                        <a class="navbar-item<?php if ($_smarty_tpl->getValue('current_page') == 'eventi') {?> is-active<?php }?>" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/eventi">Eventi</a>
                        <a class="navbar-item<?php if ($_smarty_tpl->getValue('current_page') == 'offerte') {?> is-active<?php }?>" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/offerte">Offerte</a>
                    </div>

                    <div class="navbar-end-actions">
                        
                                                <?php if ((true && ($_smarty_tpl->hasVariable('utente') && null !== ($_smarty_tpl->getValue('utente') ?? null)))) {?>
                            <div class="navbar-item has-dropdown is-hoverable">
                                <a class="navbar-link navbar-user-link">
                                    <i class="ti ti-user-circle navbar-icon"></i>
                                    <span class="navbar-username"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('utente')->getNickname(), ENT_QUOTES, 'UTF-8', true);?>
</span>
                                </a>
                                <div class="navbar-dropdown is-right">
                                    <a class="navbar-item" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/profilo"><i class="ti ti-user"></i> Il mio account</a>
                                    <a class="navbar-item" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/profilo/ordini"><i class="ti ti-package"></i> I miei ordini</a>
                                    <a class="navbar-item" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/profilo/eventi"><i class="ti ti-calendar"></i> I miei eventi</a>
                                    <hr class="navbar-divider">
                                    <a class="navbar-item navbar-logout" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/logout"><i class="ti ti-logout"></i> Logout</a>
                                </div>
                            </div>
                        <?php } else { ?>
                            <a class="header-top-link" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/accedi">Accedi</a>
                        <?php }?>

                                                <a class="header-top-link" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/wishlist" title="La mia wishlist">
                            <i class="ti ti-heart navbar-icon"></i>
                            <span class="header-top-label">Wishlist</span>
                        </a>

                                                <a class="header-top-link" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/carrello" title="Carrello">
                            <i class="ti ti-shopping-cart navbar-icon"></i>
                            <span class="header-top-label">Carrello</span>
                            <?php if ((true && ($_smarty_tpl->hasVariable('cart_count') && null !== ($_smarty_tpl->getValue('cart_count') ?? null))) && $_smarty_tpl->getValue('cart_count') > 0) {?>
                                <span class="cart-badge"><?php echo $_smarty_tpl->getValue('cart_count');?>
</span>
                            <?php }?>
                        </a>
                    </div>
                    
                </div>
            </div>

            <div class="navbar-row-bottom-search">
                
                <a class="navbar-logo" href="<?php echo $_smarty_tpl->getValue('base_url');?>
">
                    <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/logo.png" alt="TableCrown" class="navbar-logo-img">
                </a>

                <div class="navbar-search-fullwidth">
                    <form class="navbar-search-form" action="<?php echo $_smarty_tpl->getValue('base_url');?>
/catalogo" method="get">
                        <input class="input navbar-search-input"
                               type="search"
                               name="q"
                               placeholder="Cerca nel catalogo..."
                               value="<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('search_query') ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
"
                               aria-label="Cerca nel catalogo">
                        <button class="button navbar-search-btn" type="submit" aria-label="Cerca">
                            <i class="ti ti-search"></i>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </nav>

        <?php if ((true && ($_smarty_tpl->hasVariable('breadcrumbs') && null !== ($_smarty_tpl->getValue('breadcrumbs') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('breadcrumbs')) > 0) {?>
    <section class="section breadcrumb-section">
        <div class="container">
            <nav class="breadcrumb is-small" aria-label="breadcrumbs">
                <ul>
                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('breadcrumbs'), 'crumb', true);
$_smarty_tpl->getVariable('crumb')->iteration = 0;
$foreach4DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('crumb')->value) {
$foreach4DoElse = false;
$_smarty_tpl->getVariable('crumb')->iteration++;
$_smarty_tpl->getVariable('crumb')->last = $_smarty_tpl->getVariable('crumb')->iteration === $_smarty_tpl->getVariable('crumb')->total;
$foreach4Backup = clone $_smarty_tpl->getVariable('crumb');
?>
                        <?php if ($_smarty_tpl->getVariable('crumb')->last) {?>
                            <li class="is-active">
                                <a href="#" aria-current="page"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('crumb')['label'], ENT_QUOTES, 'UTF-8', true);?>
</a>
                            </li>
                        <?php } else { ?>
                            <li><a href="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('crumb')['url'], ENT_QUOTES, 'UTF-8', true);?>
"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('crumb')['label'], ENT_QUOTES, 'UTF-8', true);?>
</a></li>
                        <?php }?>
                    <?php
$_smarty_tpl->setVariable('crumb', $foreach4Backup);
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                </ul>
            </nav>
        </div>
    </section>
    <?php }?>

        <?php if ((true && ($_smarty_tpl->hasVariable('flash_message') && null !== ($_smarty_tpl->getValue('flash_message') ?? null)))) {?>
    <section class="section flash-section">
        <div class="container">
            <div class="notification is-<?php echo (($tmp = $_smarty_tpl->getValue('flash_type') ?? null)===null||$tmp==='' ? 'info' ?? null : $tmp);?>
 is-light auto-hide">
                <button class="delete" aria-label="Chiudi"></button>
                <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('flash_message'), ENT_QUOTES, 'UTF-8', true);?>

            </div>
        </div>
    </section>
    <?php }?>

        <main>
        <?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_6299445366a2d760447bdc6_82939900', "content");
?>

    </main>

        <footer class="site-footer">
        <div class="container">
            <div class="columns">
                
                <div class="column is-3">
                    <h2 class="footer-heading">TABLECROWN</h2>
                    <p class="footer-desc">Il tuo negozio di giochi da tavolo.</p>
                    <p class="footer-desc">Prodotti, eventi e community.</p>
                    <div class="social-icons">
                        <a href="#"><i class="ti ti-brand-instagram"></i></a>
                        <a href="#"><i class="ti ti-brand-facebook"></i></a>
                        <a href="#"><i class="ti ti-brand-twitch"></i></a>
                    </div>
                </div>

                <div class="column is-3">
                    <h3 class="footer-heading">INFO</h3>
                    <ul class="footer-list">
                        <li><a href="#">Chi siamo</a></li>
                        <li><a href="#">Contattaci</a></li>
                        <li><a href="#">Dove siamo</a></li>
                    </ul>
                </div>

                <div class="column is-3">
                    <h3 class="footer-heading">ACCOUNT</h3>
                    <ul class="footer-list">
                        <li><a href="#">Accedi</a></li>
                        <li><a href="#">Registrati</a></li>
                    </ul>
                </div>

                <div class="column is-3">
                    <h3 class="footer-heading">CONTATTI</h3>
                    <ul class="footer-list footer-contacts">
                        <li>
                            <i class="ti ti-phone footer-contact-icon"></i>
                            <span>+39 344 253621</span>
                        </li>
                        <li>
                            <i class="ti ti-map-pin footer-contact-icon"></i>
                            <span>Giulianova, Abruzzo</span>
                        </li>
                    </ul>
                    <a href="#" class="footer-review-link">✍ Lasciaci una recensione</a>
                </div>

            </div>

            <div class="footer-divider"></div>

            <div class="footer-bottom">
                <p>© 2026 TableCrown — Tutti i diritti riservati</p>
            </div>
        </div>
    </footer>

        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->getValue('base_url');?>
/plugins/jQuery/jquery.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->getValue('base_url');?>
/plugins/masonry/masonry.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->getValue('base_url');?>
/plugins/match-height/jquery.matchHeight-min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->getValue('base_url');?>
/js/script.js"><?php echo '</script'; ?>
>

    <?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_5976129426a2d760447c858_47894851', "extra_js");
?>


</body>
</html><?php }
/* {block "page_title"} */
class Block_9802890196a2d760444ac79_20820778 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\damic\\Desktop\\uni\\APPUNTI\\anno3\\secondo_semenstre\\Pweb\\TableCrown\\Presentation\\smarty-dir\\templates\\common';
?>
TableCrown<?php
}
}
/* {/block "page_title"} */
/* {block "extra_css"} */
class Block_7255537346a2d760444bc91_33925177 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\damic\\Desktop\\uni\\APPUNTI\\anno3\\secondo_semenstre\\Pweb\\TableCrown\\Presentation\\smarty-dir\\templates\\common';
}
}
/* {/block "extra_css"} */
/* {block "content"} */
class Block_6299445366a2d760447bdc6_82939900 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\damic\\Desktop\\uni\\APPUNTI\\anno3\\secondo_semenstre\\Pweb\\TableCrown\\Presentation\\smarty-dir\\templates\\common';
}
}
/* {/block "content"} */
/* {block "extra_js"} */
class Block_5976129426a2d760447c858_47894851 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\damic\\Desktop\\uni\\APPUNTI\\anno3\\secondo_semenstre\\Pweb\\TableCrown\\Presentation\\smarty-dir\\templates\\common';
}
}
/* {/block "extra_js"} */
}
