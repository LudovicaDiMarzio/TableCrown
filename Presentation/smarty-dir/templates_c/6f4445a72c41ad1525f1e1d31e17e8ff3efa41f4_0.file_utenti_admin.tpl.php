<?php
/* Smarty version 5.8.0, created on 2026-07-22 10:54:32
  from 'file:utenti_admin.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a60854825df69_68404048',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6f4445a72c41ad1525f1e1d31e17e8ff3efa41f4' => 
    array (
      0 => 'utenti_admin.tpl',
      1 => 1784320803,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a60854825df69_68404048 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_8955639706a6085482546d4_40123632', "page_css");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_11003385866a608548256720_90042677', "content");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "layout_admin.tpl", $_smarty_current_dir);
}
/* {block "page_css"} */
class Block_8955639706a6085482546d4_40123632 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

    <link rel="stylesheet" href="/css/utenti_admin.css">
<?php
}
}
/* {/block "page_css"} */
/* {block "content"} */
class Block_11003385866a608548256720_90042677 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

    <div class="segn">
        <div class="segn__heading">
            <div>
                <h1>Utenti segnalati</h1>
                <p>Gestisci gli utenti con recensioni segnalate</p>
            </div>
        </div>

        <div class="recensioni-list">
            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('utenti'), 'u');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('u')->value) {
$foreach0DoElse = false;
?>
                <article class="recensione-card">
                    <div class="recensione-card__header">
                        <div class="recensione-card__info">
                            <span class="recensione-card__prodotto"><?php echo $_smarty_tpl->getValue('u')['nome'];?>
</span>
                            <span class="recensione-card__meta">
                                Stato: <?php echo $_smarty_tpl->getValue('u')['stato'];?>

                            </span>
                        </div>
                        <div class="recensione-card__badges">
                            <span class="count-badge"><?php echo $_smarty_tpl->getValue('u')['numeroSegnalazioni'];?>
 segnalazioni</span>
                        </div>
                    </div>

                    <div class="recensione-card__footer">
                        <a href="/admin/utente/profilo?id=<?php echo $_smarty_tpl->getValue('u')['id'];?>
" class="btn btn--outline">Dettagli utente</a>

                        <?php if ($_smarty_tpl->getValue('u')['stato'] === 'attivo') {?>
                            <form method="post" action="/admin/utente/sospendi" class="recensione-card__form-elimina"
                                  data-confirm-message="Sospendere questo utente per 3 mesi?">
                                <input type="hidden" name="id_persona" value="<?php echo $_smarty_tpl->getValue('u')['id'];?>
">
                                <button type="submit" class="btn btn--warning">Sospendi</button>
                            </form>
                        <?php }?>

                        <?php if ($_smarty_tpl->getValue('u')['stato'] !== 'bannato') {?>
                            <form method="post" action="/admin/utente/banna" class="recensione-card__form-elimina"
                                  data-confirm-message="Bannare permanentemente questo utente?">
                                <input type="hidden" name="id_persona" value="<?php echo $_smarty_tpl->getValue('u')['id'];?>
">
                                <button type="submit" class="btn btn--danger">Banna</button>
                            </form>
                        <?php }?>
                    </div>
                </article>
            <?php
}
if ($foreach0DoElse) {
?>
                <div class="list-empty">Nessun utente con recensioni segnalate al momento.</div>
            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
        </div>
    </div>
<?php
}
}
/* {/block "content"} */
}
