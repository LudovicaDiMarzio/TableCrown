<?php
/* Smarty version 5.8.0, created on 2026-07-14 20:50:56
  from 'file:accedi.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a5685108e5160_40479125',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f8286b0a31f65e9baaa40d97a85fc44b3038f3b2' => 
    array (
      0 => 'accedi.tpl',
      1 => 1783961458,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a5685108e5160_40479125 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_10706034726a5685108d4bc8_39894881', "extra_css");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_13927198076a5685108d93f8_05751064', "content");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_14918481736a5685108e42c2_76926463', "extra_js");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "extra_css"} */
class Block_10706034726a5685108d4bc8_39894881 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

    <link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/css/auth.css">
<?php
}
}
/* {/block "extra_css"} */
/* {block "content"} */
class Block_13927198076a5685108d93f8_05751064 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>


<div class="auth-container">
    <div class="container">
        <div class="auth-card">

            <div class="auth-card-header">
                <div class="auth-icon">
                    <i class="ti ti-login"></i>
                </div>
                <h1 class="auth-title">Bentornato</h1>
                <p class="auth-subtitle">Accedi al tuo account TableCrown</p>
            </div>

            <form class="auth-form" action="<?php echo $_smarty_tpl->getValue('base_url');?>
/accedi" method="post" id="login-form">

                <?php if ((true && ($_smarty_tpl->hasVariable('redirect_to') && null !== ($_smarty_tpl->getValue('redirect_to') ?? null)))) {?>
                    <input type="hidden" name="redirect_to" value="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('redirect_to'), ENT_QUOTES, 'UTF-8', true);?>
">
                <?php }?>

                <div class="auth-field">
                    <label for="email" class="auth-label">Email</label>
                    <div class="auth-input-wrapper">
                        <i class="ti ti-mail"></i>
                        <input class="input auth-input"
                               type="email"
                               name="email"
                               id="email"
                               placeholder="nome@esempio.it"
                               value="<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('email_value') ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
"
                               required
                               autocomplete="email">
                    </div>
                </div>

                <div class="auth-field">
                    <label for="password" class="auth-label">Password</label>
                    <div class="auth-input-wrapper">
                        <i class="ti ti-lock"></i>
                        <input class="input auth-input"
                               type="password"
                               name="password"
                               id="password"
                               placeholder="••••••••"
                               required
                               autocomplete="current-password">
                        <button type="button" class="auth-toggle-password" id="toggle-password" aria-label="Mostra password">
                            <i class="ti ti-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="auth-row-between">
                    <label class="auth-checkbox-label">
                        <input type="checkbox" name="ricordami" value="1"
                               <?php if ((true && ($_smarty_tpl->hasVariable('ricordami') && null !== ($_smarty_tpl->getValue('ricordami') ?? null))) && $_smarty_tpl->getValue('ricordami')) {?> checked<?php }?>>
                        <span>Ricordami</span>
                    </label>
                    <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/password-dimenticata" class="auth-link-inline">Password dimenticata?</a>
                </div>

                <button class="button auth-submit-btn" type="submit">
                    <i class="ti ti-login"></i> Accedi
                </button>

            </form>

            <div class="auth-divider">
                <span>oppure</span>
            </div>

            <p class="auth-footer-text">
                Non hai un account?
                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/registrati" class="auth-link">Registrati ora</a>
            </p>

        </div>
    </div>
</div>

<?php
}
}
/* {/block "content"} */
/* {block "extra_js"} */
class Block_14918481736a5685108e42c2_76926463 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<?php echo '<script'; ?>
>

document.addEventListener('DOMContentLoaded', function() {
    var toggleBtn = document.getElementById('toggle-password');
    var passwordInput = document.getElementById('password');

    if (toggleBtn && passwordInput) {
        toggleBtn.addEventListener('click', function() {
            var isHidden = passwordInput.type === 'password';
            passwordInput.type = isHidden ? 'text' : 'password';
            toggleBtn.querySelector('i').className = isHidden ? 'ti ti-eye-off' : 'ti ti-eye';
        });
    }
});

<?php echo '</script'; ?>
>
<?php
}
}
/* {/block "extra_js"} */
}
