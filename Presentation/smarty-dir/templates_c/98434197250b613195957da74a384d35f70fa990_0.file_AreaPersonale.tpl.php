<?php
/* Smarty version 5.8.0, created on 2026-07-21 00:59:36
  from 'file:AreaPersonale.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a5ea858550625_13350816',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '98434197250b613195957da74a384d35f70fa990' => 
    array (
      0 => 'AreaPersonale.tpl',
      1 => 1784588372,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a5ea858550625_13350816 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_3723896306a5ea858538235_57466162', "extra_css");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_6132468716a5ea85853bf52_51068229', "content");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_20062150226a5ea85854fbf5_56184882', "extra_js");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "extra_css"} */
class Block_3723896306a5ea858538235_57466162 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

    <link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/css/AreaPersonale.css">
<?php
}
}
/* {/block "extra_css"} */
/* {block "content"} */
class Block_6132468716a5ea85853bf52_51068229 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<div class="account-container">
    <div class="container">

        <div class="account-layout">

                        <div class="account-main">

                                <div class="account-header">

                    <div class="account-avatar">
                        <?php if ((true && (true && null !== ($_smarty_tpl->getValue('utente')['avatar'] ?? null))) && $_smarty_tpl->getValue('utente')['avatar']) {?>
                            <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/avatar/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('utente')['avatar'], ENT_QUOTES, 'UTF-8', true);?>
"
                                 onerror="this.onerror=null; this.src='<?php echo $_smarty_tpl->getValue('base_url');?>
/img/avatar-default.png'"
                                 alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('utente')['name'], ENT_QUOTES, 'UTF-8', true);?>
"
                                 class="account-avatar-img">
                        <?php } else { ?>
                            <i class="ti ti-user"></i>
                        <?php }?>
                    </div>

                    <div class="account-welcome">
                        <span class="account-eyebrow">Area Personale</span>
                        <h1 class="account-titolo">Ciao, <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('utente')['name'], ENT_QUOTES, 'UTF-8', true);?>
!</h1>

                        <div class="account-header-links">
                            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/logout" class="account-link-secondary">
                                <i class="ti ti-logout"></i> Logout
                            </a>
                        </div>
                    </div>

                </div>

                                <div class="account-grid">
                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('account_menu'), 'voce');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('voce')->value) {
$foreach0DoElse = false;
?>
                                                <?php if ($_smarty_tpl->getValue('voce')['label'] != 'I Miei Dadi') {?>
                            <a href="<?php echo $_smarty_tpl->getValue('base_url');
echo htmlspecialchars((string)$_smarty_tpl->getValue('voce')['url'], ENT_QUOTES, 'UTF-8', true);?>
" class="account-card">
                                <span class="account-card-icon">
                                    <i class="ti ti-chevron-right"></i>
                                </span>
                                <span class="account-card-label"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('voce')['label'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                                <span class="account-card-arrow">
                                    <i class="ti ti-arrow-right"></i>
                                </span>
                            </a>
                        <?php }?>
                    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>

                                        <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/profilo/pagamenti" class="account-card">
                        <span class="account-card-icon">
                            <i class="ti ti-credit-card"></i>
                        </span>
                        <span class="account-card-label">Metodi di Pagamento</span>
                        <span class="account-card-arrow">
                            <i class="ti ti-arrow-right"></i>
                        </span>
                    </a>
                </div>

            </div>

                        <aside class="account-summary" id="account-summary">

                <div class="account-summary-block">
                    <h2 class="account-summary-title">
                        <i class="ti ti-trophy"></i> Tornei Vinti
                    </h2>
                    <div class="account-summary-tornei-value">
                        <span class="account-tornei-attuali"><?php echo $_smarty_tpl->getValue('tornei_vinti');?>
</span><span class="account-tornei-sep">/</span><span class="account-tornei-totali"><?php echo $_smarty_tpl->getValue('tornei_obiettivo');?>
</span>
                    </div>

                    <div class="account-progress-track">
                        <div class="account-progress-fill"
                             style="width: <?php if ($_smarty_tpl->getValue('tornei_obiettivo') > 0) {
echo ($_smarty_tpl->getValue('tornei_vinti')/$_smarty_tpl->getValue('tornei_obiettivo'))*100;
} else { ?>0<?php }?>%;"></div>
                    </div>
                </div>

                <div class="account-livello-wrapper">
                    <div class="account-livello-row">
                        <span class="account-livello-label">
                            <i class="ti ti-star"></i> Livello Giocatore
                        </span>
                        <button type="button"
                                class="account-livello-info"
                                id="account-livello-info-btn"
                                aria-label="Informazioni livello giocatore"
                                aria-expanded="false">
                            <i class="ti ti-info-circle"></i>
                        </button>
                    </div>

                    <div class="account-livello-tooltip" id="account-livello-tooltip" role="tooltip">
                        Vinci altri tornei per diventare il livello successivo!
                    </div>
                </div>

            </aside>

        </div>

    </div>
</div>
<?php
}
}
/* {/block "content"} */
/* {block "extra_js"} */
class Block_20062150226a5ea85854fbf5_56184882 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<?php echo '<script'; ?>
>

(function() {

    // ── TOOLTIP LIVELLO GIOCATORE (click su mobile, hover gestito da CSS su desktop) ──
    var btn     = document.getElementById('account-livello-info-btn');
    var tooltip = document.getElementById('account-livello-tooltip');

    if (btn && tooltip) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            var aperto = tooltip.classList.toggle('is-visibile');
            btn.setAttribute('aria-expanded', aperto ? 'true' : 'false');
        });

        document.addEventListener('click', function(e) {
            if (!tooltip.contains(e.target) && e.target !== btn && !btn.contains(e.target)) {
                tooltip.classList.remove('is-visibile');
                btn.setAttribute('aria-expanded', 'false');
            }
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
