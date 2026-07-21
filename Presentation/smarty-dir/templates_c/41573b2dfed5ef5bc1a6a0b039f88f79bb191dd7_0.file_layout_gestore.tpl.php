<?php
/* Smarty version 5.8.0, created on 2026-07-21 17:09:19
  from 'file:layout_gestore.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a5f8b9f9681a0_04765543',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '41573b2dfed5ef5bc1a6a0b039f88f79bb191dd7' => 
    array (
      0 => 'layout_gestore.tpl',
      1 => 1784555538,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a5f8b9f9681a0_04765543 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, false);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if ($_smarty_tpl->getValue('pageTitle')) {
echo $_smarty_tpl->getValue('pageTitle');?>
 - <?php }?>TableCrown Gestore</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/css/layout_gestore.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_17118908266a5f8b9f956454_09910342', "page_css");
?>

</head>
<body class="gestore-body">
<div class="gestore-shell">

    <aside class="gestore-sidebar">
        <div class="gestore-sidebar__brand">
            <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/assets/img/logo.svg" alt="TableCrown" class="gestore-sidebar__logo">
            <div class="gestore-sidebar__brand-text">
                <span class="gestore-sidebar__name">TableCrown</span>
                <span class="gestore-sidebar__role">Gestore Negozio</span>
            </div>
        </div>

                <?php $_smarty_tpl->assign('prodottiAttivo', ($_smarty_tpl->getValue('current_page') === 'gestore_catalogo_giochi' || $_smarty_tpl->getValue('current_page') === 'gestore_catalogo_bustine' || $_smarty_tpl->getValue('current_page') === 'gestore_catalogo_portadadi'), false, NULL);?>

        <nav class="gestore-sidebar__nav">
            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/dashboard"
               class="gestore-nav__item<?php if ($_smarty_tpl->getValue('current_page') === 'gestore_dashboard') {?> is-active<?php }?>">
                <span class="ti ti-layout-dashboard"></span>
                Dashboard
            </a>

            <div class="gestore-nav__group<?php if ($_smarty_tpl->getValue('prodottiAttivo')) {?> is-open<?php }?>">
                <button type="button" class="gestore-nav__item gestore-nav__item--toggle<?php if ($_smarty_tpl->getValue('prodottiAttivo')) {?> is-active<?php }?>" data-nav-toggle="prodotti">
                    <span class="ti ti-package"></span>
                    Prodotti
                    <span class="ti ti-chevron-down gestore-nav__chevron"></span>
                </button>
                <div class="gestore-nav__submenu" id="navSubmenu-prodotti">
                    <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/catalogo/giochi-da-tavolo"
                       class="gestore-nav__subitem<?php if ($_smarty_tpl->getValue('current_page') === 'gestore_catalogo_giochi') {?> is-active<?php }?>">Giochi da Tavolo</a>
                    <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/catalogo/bustine"
                       class="gestore-nav__subitem<?php if ($_smarty_tpl->getValue('current_page') === 'gestore_catalogo_bustine') {?> is-active<?php }?>">Bustine</a>
                    <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/catalogo/porta-dadi"
                       class="gestore-nav__subitem<?php if ($_smarty_tpl->getValue('current_page') === 'gestore_catalogo_portadadi') {?> is-active<?php }?>">Porta Dadi</a>
                </div>
            </div>

            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/eventi/serate"
               class="gestore-nav__item<?php if ($_smarty_tpl->getValue('current_page') === 'gestore_eventi_serate') {?> is-active<?php }?>">
                <span class="ti ti-moon-stars"></span>
                Serate
            </a>
            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/eventi/tornei"
               class="gestore-nav__item<?php if ($_smarty_tpl->getValue('current_page') === 'gestore_eventi_tornei') {?> is-active<?php }?>">
                <span class="ti ti-trophy"></span>
                Tornei
            </a>
            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/eventi/challenge"
               class="gestore-nav__item<?php if ($_smarty_tpl->getValue('current_page') === 'gestore_eventi_challenge') {?> is-active<?php }?>">
                <span class="ti ti-swords"></span>
                Challenge
            </a>
        </nav>
    </aside>

    <div class="gestore-main">
        <header class="gestore-topbar">
                        <nav class="gestore-breadcrumbs" aria-label="breadcrumb">
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('breadcrumbs'), 'crumb', false, NULL, 'bc', array (
  'last' => true,
  'iteration' => true,
  'total' => true,
));
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('crumb')->value) {
$foreach1DoElse = false;
$_smarty_tpl->tpl_vars['__smarty_foreach_bc']->value['iteration']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_bc']->value['last'] = $_smarty_tpl->tpl_vars['__smarty_foreach_bc']->value['iteration'] === $_smarty_tpl->tpl_vars['__smarty_foreach_bc']->value['total'];
?>
                    <?php if (($_smarty_tpl->getValue('__smarty_foreach_bc')['last'] ?? null)) {?>
                        <span class="gestore-breadcrumbs__current"><?php echo $_smarty_tpl->getValue('crumb')['label'];?>
</span>
                    <?php } else { ?>
                        <a href="<?php echo $_smarty_tpl->getValue('crumb')['url'];?>
"><?php echo $_smarty_tpl->getValue('crumb')['label'];?>
</a>
                        <span class="gestore-breadcrumbs__sep">/</span>
                    <?php }?>
                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
            </nav>

            <div class="gestore-topbar__actions">
                <div class="gestore-topbar__profile" id="gestoreProfileToggle">
                    <?php if ($_smarty_tpl->getValue('utente')) {?>
                        <span class="gestore-topbar__avatar"><?php echo mb_strtoupper((string) $_smarty_tpl->getSmarty()->getModifierCallback('truncate')($_smarty_tpl->getValue('utente')['name'],1,'',true) ?? '', 'UTF-8');?>
</span>
                        <div class="gestore-topbar__identity">
                            <span class="gestore-topbar__name"><?php echo $_smarty_tpl->getValue('utente')['name'];?>
</span>
                            <span class="gestore-topbar__role">Gestore</span>
                        </div>
                    <?php } else { ?>
                        <span class="gestore-topbar__avatar">G</span>
                        <div class="gestore-topbar__identity">
                            <span class="gestore-topbar__name">Gestore</span>
                            <span class="gestore-topbar__role">Non autenticato</span>
                        </div>
                    <?php }?>
                    <span class="ti ti-chevron-down gestore-topbar__chevron"></span>

                    <div class="gestore-topbar__dropdown" id="gestoreProfileDropdown">
                        <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/logout" class="gestore-topbar__dropdown-item">
                            <span class="ti ti-logout"></span> Esci
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <main class="gestore-content">
            <?php if ($_smarty_tpl->getValue('flash_message')) {?>
                <div class="gestore-flash gestore-flash--<?php echo $_smarty_tpl->getValue('flash_type');?>
">
                    <span class="gestore-flash__text"><?php echo $_smarty_tpl->getValue('flash_message');?>
</span>
                </div>
            <?php }?>

            <?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_5544799596a5f8b9f965f18_04267613', "content");
?>

        </main>

        <footer class="gestore-footer">
            <span>&copy; <?php echo $_smarty_tpl->getSmarty()->getModifierCallback('date_format')(time(),"%Y");?>
 TableCrown</span>
        </footer>
    </div>

        <div class="gestore-modal-overlay" id="gestoreConfirmOverlay">
        <div class="gestore-modal">
            <div class="gestore-modal__icon"><span class="ti ti-alert-triangle"></span></div>
            <p class="gestore-modal__text" id="gestoreConfirmText"></p>
            <div class="gestore-modal__actions">
                <button type="button" class="gestore-modal__btn gestore-modal__btn--cancel" id="gestoreConfirmCancel">Annulla</button>
                <button type="button" class="gestore-modal__btn gestore-modal__btn--confirm" id="gestoreConfirmOk">Conferma</button>
            </div>
        </div>
    </div>

</div>

<?php echo '<script'; ?>
>
document.addEventListener('DOMContentLoaded', function () {
    // Dropdown profilo (solo logout, dato che non esiste modifica account per il gestore)
    const toggle = document.getElementById('gestoreProfileToggle');
    const dropdown = document.getElementById('gestoreProfileDropdown');
    if (toggle && dropdown) {
        toggle.addEventListener('click', function (e) {
            e.stopPropagation();
            dropdown.classList.toggle('is-open');
        });
        document.addEventListener('click', function () {
            dropdown.classList.remove('is-open');
        });
    }

    // Submenu "Prodotti" nella sidebar
    document.querySelectorAll('[data-nav-toggle]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            btn.closest('.gestore-nav__group').classList.toggle('is-open');
        });
    });

    // Modal di conferma condiviso, per i form con data-confirm-message
    const overlay = document.getElementById('gestoreConfirmOverlay');
    const text = document.getElementById('gestoreConfirmText');
    const btnOk = document.getElementById('gestoreConfirmOk');
    const btnCancel = document.getElementById('gestoreConfirmCancel');
    let pendingForm = null;

    document.querySelectorAll('form[data-confirm-message]').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            pendingForm = form;
            text.textContent = form.dataset.confirmMessage;
            overlay.classList.add('is-open');
        });
    });

    btnOk.addEventListener('click', function () {
        overlay.classList.remove('is-open');
        if (pendingForm) {
            pendingForm.submit();
            pendingForm = null;
        }
    });

    btnCancel.addEventListener('click', function () {
        overlay.classList.remove('is-open');
        pendingForm = null;
    });

    overlay.addEventListener('click', function (e) {
        if (e.target === overlay) {
            overlay.classList.remove('is-open');
            pendingForm = null;
        }
    });
});
<?php echo '</script'; ?>
>
</body>
</html><?php }
/* {block "page_css"} */
class Block_17118908266a5f8b9f956454_09910342 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
}
}
/* {/block "page_css"} */
/* {block "content"} */
class Block_5544799596a5f8b9f965f18_04267613 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
}
}
/* {/block "content"} */
}
