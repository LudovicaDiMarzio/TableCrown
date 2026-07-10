<?php
/* Smarty version 5.8.0, created on 2026-07-10 16:40:52
  from 'file:ModificaAccount.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a51047443abb8_10457727',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '03e2d17f09341c2d42ee277078b146f3539dcc41' => 
    array (
      0 => 'ModificaAccount.tpl',
      1 => 1783694447,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a51047443abb8_10457727 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_3516886886a5104744269b4_29130138', "extra_css");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_4275864986a51047442a988_23806926', "content");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_171573216a51047443a1c9_77600025', "extra_js");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "extra_css"} */
class Block_3516886886a5104744269b4_29130138 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

    <link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/css/ModificaAccount.css">
<?php
}
}
/* {/block "extra_css"} */
/* {block "content"} */
class Block_4275864986a51047442a988_23806926 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<div class="modifica-account-container">
    <div class="container">

                <div class="modifica-account-topbar">
            <div class="modifica-account-breadcrumb">
                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/account" class="modifica-account-breadcrumb-link">Il mio account</a>
                <span class="modifica-account-breadcrumb-sep">&gt;</span>
                <span class="modifica-account-breadcrumb-current">Modifica account</span>
            </div>

            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/account/elimina"
               class="modifica-account-elimina"
               onclick="return confirm('Sei sicuro di voler eliminare il tuo account? L\'operazione è irreversibile.');">
                Elimina account
            </a>
        </div>

        <form action="<?php echo $_smarty_tpl->getValue('base_url');?>
/account/modifica" method="post" class="modifica-account-form" enctype="multipart/form-data">

                        <div class="modifica-account-avatar-wrap">
                <div class="modifica-account-avatar">
                    <?php if ((true && (true && null !== ($_smarty_tpl->getValue('utente')['avatar'] ?? null))) && $_smarty_tpl->getValue('utente')['avatar']) {?>
                        <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/avatar/<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('utente')['avatar'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
"
                             onerror="this.onerror=null; this.src='<?php echo $_smarty_tpl->getValue('base_url');?>
/img/avatar-default.png'"
                             alt="<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('utente')['nome'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
"
                             class="modifica-account-avatar-img"
                             id="modifica-account-avatar-preview">
                    <?php } else { ?>
                        <span class="modifica-account-avatar-placeholder" id="modifica-account-avatar-preview">IMG</span>
                    <?php }?>
                </div>

                <label for="modifica-account-avatar-input" class="modifica-account-avatar-edit">
                    <i class="ti ti-pencil"></i> Edit
                </label>
                <input type="file"
                       id="modifica-account-avatar-input"
                       name="avatar"
                       accept="image/*"
                       class="modifica-account-avatar-input">
            </div>

                        <div class="modifica-account-fields">

                <div class="modifica-account-field">
                    <label for="nickname" class="modifica-account-label">Nickname</label>
                    <input type="text"
                           id="nickname"
                           name="nickname"
                           class="modifica-account-input"
                           value="<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('utente')['nome'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
">
                </div>

                <div class="modifica-account-field">
                    <label for="email" class="modifica-account-label">Email</label>
                    <input type="email"
                           id="email"
                           name="email"
                           class="modifica-account-input"
                           value="<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('utente')['email'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
">
                </div>

                <div class="modifica-account-field">
                    <label for="eta" class="modifica-account-label">Età</label>
                    <input type="number"
                           id="eta"
                           name="eta"
                           min="0"
                           class="modifica-account-input"
                           value="<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('utente')['eta'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
">
                </div>

                <div class="modifica-account-field modifica-account-field-checkbox">
                    <label class="modifica-account-checkbox-label">
                        <input type="checkbox"
                               name="mostra_foto"
                               value="1"
                               <?php if ((true && (true && null !== ($_smarty_tpl->getValue('utente')['mostra_foto'] ?? null))) && $_smarty_tpl->getValue('utente')['mostra_foto']) {?>checked<?php }?>>
                        Mostra la mia foto profilo pubblicamente
                    </label>
                </div>

            </div>

                        <div class="modifica-account-actions">
                <button type="button"
                        class="modifica-account-btn-secondary"
                        id="modifica-account-password-toggle"
                        aria-expanded="false"
                        aria-controls="modifica-account-password-card">
                    Modifica Password
                </button>

                <button type="submit" class="modifica-account-btn-primary">Salva</button>
            </div>

        </form>

                <div class="modifica-account-password-card" id="modifica-account-password-card" hidden>
            <form action="<?php echo $_smarty_tpl->getValue('base_url');?>
/account/password" method="post" class="modifica-account-password-form">

                <div class="modifica-account-field">
                    <label for="psw_vecchia" class="modifica-account-label">Psw Vecchia</label>
                    <input type="password" id="psw_vecchia" name="psw_vecchia" class="modifica-account-input">
                </div>

                <div class="modifica-account-field">
                    <label for="psw_nuova" class="modifica-account-label">Psw Nuova</label>
                    <input type="password" id="psw_nuova" name="psw_nuova" class="modifica-account-input">
                </div>

                <div class="modifica-account-field">
                    <label for="psw_conferma" class="modifica-account-label">Psw Conferma</label>
                    <input type="password" id="psw_conferma" name="psw_conferma" class="modifica-account-input">
                </div>

                <button type="submit" class="modifica-account-btn-primary modifica-account-btn-password-salva">Salva</button>

            </form>
        </div>

    </div>
</div>
<?php
}
}
/* {/block "content"} */
/* {block "extra_js"} */
class Block_171573216a51047443a1c9_77600025 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<?php echo '<script'; ?>
>

(function() {

    // ── TOGGLE CARD MODIFICA PASSWORD ──
    var toggleBtn = document.getElementById('modifica-account-password-toggle');
    var card      = document.getElementById('modifica-account-password-card');

    if (toggleBtn && card) {
        toggleBtn.addEventListener('click', function() {
            var aperto = card.hasAttribute('hidden');
            if (aperto) {
                card.removeAttribute('hidden');
            } else {
                card.setAttribute('hidden', '');
            }
            toggleBtn.setAttribute('aria-expanded', aperto ? 'true' : 'false');
        });
    }

    // ── PREVIEW AVATAR AL CAMBIO FILE ──
    var avatarInput  = document.getElementById('modifica-account-avatar-input');
    var avatarPreview = document.getElementById('modifica-account-avatar-preview');

    if (avatarInput && avatarPreview) {
        avatarInput.addEventListener('change', function(e) {
            var file = e.target.files[0];
            if (!file) return;

            var reader = new FileReader();
            reader.onload = function(ev) {
                if (avatarPreview.tagName === 'IMG') {
                    avatarPreview.src = ev.target.result;
                } else {
                    var img = document.createElement('img');
                    img.src = ev.target.result;
                    img.className = 'modifica-account-avatar-img';
                    img.id = 'modifica-account-avatar-preview';
                    avatarPreview.replaceWith(img);
                    avatarPreview = img;
                }
            };
            reader.readAsDataURL(file);
        });
    }

})();

<?php echo '</script'; ?>
>
<?php
}
}
/* {/block "extra_js"} */
}
