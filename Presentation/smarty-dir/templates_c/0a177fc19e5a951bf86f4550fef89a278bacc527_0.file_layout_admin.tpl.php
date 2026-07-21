<?php
/* Smarty version 5.8.0, created on 2026-07-21 17:18:53
  from 'file:layout_admin.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a5f8ddd24c503_94829912',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0a177fc19e5a951bf86f4550fef89a278bacc527' => 
    array (
      0 => 'layout_admin.tpl',
      1 => 1784647129,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a5f8ddd24c503_94829912 (\Smarty\Template $_smarty_tpl) {
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
 - <?php }?>TableCrown Admin</title>
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/css/layout_admin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_4188511276a5f8ddd243b80_56775881', "page_css");
?>

</head>
<body class="admin-body">
<div class="admin-shell">

    <aside class="admin-sidebar">
        <div class="admin-sidebar__brand">
            <img src="/assets/img/logo.svg" alt="TableCrown" class="admin-sidebar__logo">
            <div class="admin-sidebar__brand-text">
                <span class="admin-sidebar__name">TableCrown</span>
                <span class="admin-sidebar__role">Amministratore</span>
            </div>
        </div>

        <nav class="admin-sidebar__nav">
            <a href="/admin/dashboard" class="admin-nav__item">
                <span class="admin-nav__icon admin-nav__icon--dashboard"></span>
                Dashboard
            </a>
            <a href="/admin/utenti" class="admin-nav__item">
                <span class="admin-nav__icon admin-nav__icon--utenti"></span>
                Utenti
            </a>
            <a href="/admin/segnalazioni" class="admin-nav__item">
                <span class="admin-nav__icon admin-nav__icon--segnalazioni"></span>
                Segnalazioni
                <?php if ($_smarty_tpl->getValue('segnalazioniInAttesaCount') > 0) {?>
                    <span class="admin-nav__badge"><?php echo $_smarty_tpl->getValue('segnalazioniInAttesaCount');?>
</span>
                <?php }?>
            </a>
            <a href="/admin/impostazioni" class="admin-nav__item">
                <span class="admin-nav__icon admin-nav__icon--impostazioni"></span>
                Impostazioni
            </a>
        </nav>
    </aside>

    <div class="admin-main">
        <header class="admin-topbar">
            <div class="admin-topbar__spacer"></div>

            <div class="admin-topbar__actions">
                <div class="admin-topbar__profile" id="adminProfileToggle">
                    <span class="admin-topbar__avatar"></span>
                    <div class="admin-topbar__identity">
                        <span class="admin-topbar__admin-name"><?php echo $_smarty_tpl->getValue('utente')['name'];?>
</span>
                        <span class="admin-topbar__admin-role">Amministratore</span>
                    </div>
                    <span class="admin-topbar__chevron ti ti-chevron-down"></span>
                    <div class="admin-topbar__dropdown" id="adminProfileDropdown">

                        <a href="/logout" class="admin-topbar__dropdown-item">
                            <span class="ti ti-logout"></span> Esci
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <main class="admin-content">
            <?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_2415432576a5f8ddd24b023_69136831', "content");
?>

        </main>

        <footer class="admin-footer">
            <span>&copy; <?php echo $_smarty_tpl->getValue('annoCorrente');?>
 TableCrown</span>
        </footer>
    </div>

    <!-- Modal di conferma, condiviso da tutte le pagine admin -->
    <div class="admin-modal-overlay" id="adminConfirmOverlay">
        <div class="admin-modal">
            <div class="admin-modal__icon"><span class="ti ti-alert-triangle"></span></div>
            <p class="admin-modal__text" id="adminConfirmText"></p>
            <div class="admin-modal__actions">
                <button type="button" class="admin-modal__btn admin-modal__btn--cancel" id="adminConfirmCancel">Annulla</button>
                <button type="button" class="admin-modal__btn admin-modal__btn--confirm" id="adminConfirmOk">Conferma</button>
            </div>
        </div>
    </div>

</div>

<?php echo '<script'; ?>
>
document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('adminProfileToggle');
    const dropdown = document.getElementById('adminProfileDropdown');
    if (toggle && dropdown) {
        toggle.addEventListener('click', function (e) {
            e.stopPropagation();
            dropdown.classList.toggle('is-open');
        });
        document.addEventListener('click', function () {
            dropdown.classList.remove('is-open');
        });
    }

    // Modal di conferma per i form con data-confirm-message
    const overlay = document.getElementById('adminConfirmOverlay');
    const text = document.getElementById('adminConfirmText');
    const btnOk = document.getElementById('adminConfirmOk');
    const btnCancel = document.getElementById('adminConfirmCancel');
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
class Block_4188511276a5f8ddd243b80_56775881 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
}
}
/* {/block "page_css"} */
/* {block "content"} */
class Block_2415432576a5f8ddd24b023_69136831 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
}
}
/* {/block "content"} */
}
