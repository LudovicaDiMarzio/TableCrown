<?php
/* Smarty version 5.8.0, created on 2026-07-14 21:01:21
  from 'file:registrati.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a568781b56351_94849784',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b61b2914a41bf0615ff857d110c4da93ad3a9250' => 
    array (
      0 => 'registrati.tpl',
      1 => 1783961458,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a568781b56351_94849784 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_12189043136a568781b4a4e7_52183710', "extra_css");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_1139637806a568781b4e0d1_22526810', "content");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "extra_css"} */
class Block_12189043136a568781b4a4e7_52183710 extends \Smarty\Runtime\Block
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
class Block_1139637806a568781b4e0d1_22526810 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>


<div class="auth-container">
    <div class="container">
        <div class="auth-card auth-card-wide">

            <div class="auth-card-header">
                <div class="auth-icon">
                    <i class="ti ti-user-plus"></i>
                </div>
                <h1 class="auth-title">Crea il tuo account</h1>
                <p class="auth-subtitle">Unisciti alla community TableCrown</p>
            </div>

            <form class="auth-form" action="<?php echo $_smarty_tpl->getValue('base_url');?>
/registrati" method="post" id="register-form">

                <div class="auth-field">
                    <label for="nickname" class="auth-label">Nickname</label>
                    <div class="auth-input-wrapper">
                        <i class="ti ti-user"></i>
                        <input class="input auth-input"
                               type="text"
                               name="nome"
                               id="nickname"
                               placeholder="MastroDadi92"
                               value="<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('nickname_value') ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
"
                               required
                               minlength="3"
                               maxlength="30"
                               autocomplete="username">
                    </div>
                </div>

                <div class="auth-fields-row">
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
                        <label for="eta" class="auth-label">Età</label>
                        <div class="auth-input-wrapper">
                            <i class="ti ti-baby-carriage"></i>
                            <input class="input auth-input"
                                   type="number"
                                   name="eta"
                                   id="eta"
                                   placeholder="18"
                                   value="<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('eta_value') ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
"
                                   required
                                   min="18"
                                   max="120"
                                   autocomplete="off">
                        </div>
                    </div>
                </div>

                <div class="auth-fields-row">
                    <div class="auth-field">
                        <label for="password" class="auth-label">Password</label>
                        <div class="auth-input-wrapper">
                            <i class="ti ti-lock"></i>
                            <input class="input auth-input"
                                   type="password"
                                   name="password"
                                   id="password"
                                   placeholder="Min. 8 caratteri"
                                   required
                                   minlength="8"
                                   autocomplete="new-password">
                        </div>
                    </div>

                    <div class="auth-field">
                        <label for="password_conferma" class="auth-label">Conferma Password</label>
                        <div class="auth-input-wrapper">
                            <i class="ti ti-lock-check"></i>
                            <input class="input auth-input"
                                   type="password"
                                   name="password_conferma"
                                   id="password_conferma"
                                   placeholder="Ripeti password"
                                   required
                                   minlength="8"
                                   autocomplete="new-password">
                        </div>
                    </div>
                </div>

                <label class="auth-checkbox-label auth-checkbox-terms">
                    <input type="checkbox" name="accetta_termini" value="1" required>
                    <span>Accetto i <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/termini" class="auth-link-inline" target="_blank">Termini di Servizio</a> e la <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/privacy" class="auth-link-inline" target="_blank">Privacy Policy</a></span>
                </label>

                <button class="button auth-submit-btn" type="submit">
                    <i class="ti ti-user-plus"></i> Crea account
                </button>

            </form>

            <div class="auth-divider">
                <span>oppure</span>
            </div>

            <p class="auth-footer-text">
                Hai già un account?
                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/accedi" class="auth-link">Accedi</a>
            </p>

        </div>
    </div>
</div>

<?php
}
}
/* {/block "content"} */
}
