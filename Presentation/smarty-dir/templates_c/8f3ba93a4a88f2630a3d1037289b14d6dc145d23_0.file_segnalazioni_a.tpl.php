<?php
/* Smarty version 5.8.0, created on 2026-07-22 11:05:22
  from 'file:segnalazioni_a.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a6087d219e7e4_29918507',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8f3ba93a4a88f2630a3d1037289b14d6dc145d23' => 
    array (
      0 => 'segnalazioni_a.tpl',
      1 => 1784711109,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a6087d219e7e4_29918507 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_6458470896a6087d2186488_43530170', "page_css");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_6136282156a6087d2189e20_02712753', "content");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "layout_admin.tpl", $_smarty_current_dir);
}
/* {block "page_css"} */
class Block_6458470896a6087d2186488_43530170 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

    <link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/css/segnalazioni_a.css">
<?php
}
}
/* {/block "page_css"} */
/* {block "content"} */
class Block_6136282156a6087d2189e20_02712753 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

    <div class="segn">
        <div class="segn__heading">
            <div>
                <h1>Recensioni segnalate</h1>
                <p>Modera le recensioni segnalate dagli utenti</p>
            </div>

            <form class="segn__filtro" method="get" action="/admin/recensioni">
                <label for="ordinamento" class="segn__filtro-label">Ordina per</label>
                <select name="ordinamento" id="ordinamento" class="segn__filtro-select" onchange="this.form.submit()">
                    <option value="recenti" <?php if ($_smarty_tpl->getValue('ordinamento') === 'recenti') {?>selected<?php }?>>Più recenti</option>
                    <option value="gravita" <?php if ($_smarty_tpl->getValue('ordinamento') === 'gravita') {?>selected<?php }?>>Gravità</option>
                </select>
            </form>
        </div>

        <div class="recensioni-list">
            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('recensioni'), 'r');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('r')->value) {
$foreach0DoElse = false;
?>
                <article class="recensione-card">
                    <div class="recensione-card__header">
                        <div class="recensione-card__info">
                            <span class="recensione-card__prodotto"><?php echo $_smarty_tpl->getValue('r')['prodotto']['nome'];?>
</span>
                            <span class="recensione-card__meta">
                                Autore: <?php echo $_smarty_tpl->getValue('r')['autore']['nome'];?>
 &middot; <?php echo $_smarty_tpl->getSmarty()->getModifierCallback('date_format')($_smarty_tpl->getValue('r')['data'],"%d/%m/%Y %H:%M");?>

                            </span>
                        </div>
                        <div class="recensione-card__badges">
                            <span class="count-badge"><?php echo $_smarty_tpl->getValue('r')['numeroSegnalazioni'];?>
 segnalazioni</span>
                            <span class="badge badge--<?php echo $_smarty_tpl->getValue('r')['gravita'];?>
">
                                <?php if ($_smarty_tpl->getValue('r')['gravita'] === 'alta') {?>Alta
                                <?php } elseif ($_smarty_tpl->getValue('r')['gravita'] === 'media') {?>Media
                                <?php } else { ?>Bassa
                                <?php }?>
                            </span>
                        </div>
                    </div>

                    <p class="recensione-card__testo"><?php echo $_smarty_tpl->getValue('r')['testo'];?>
</p>

                    <div class="recensione-card__footer">
                        <a href="/admin/utente/profilo?id=<?php echo $_smarty_tpl->getValue('r')['autore']['id'];?>
" class="btn btn--outline">Controlla profilo</a>

                        <form method="post" action="/admin/recensioni/rigetta" class="recensione-card__form-elimina"
                              data-confirm-message="Rigettare questa segnalazione? La recensione resterà pubblicata.">
                            <input type="hidden" name="id_segnalazione" value="<?php echo $_smarty_tpl->getValue('r')['idSegnalazioneDaRisolvere'];?>
">
                            <button type="submit" class="btn btn--neutral">Rigetta segnalazione</button>
                        </form>

                        <form method="post" action="/admin/recensioni/elimina" class="recensione-card__form-elimina"
                              data-confirm-message="Eliminare definitivamente questa recensione?">
                            <input type="hidden" name="id_recensione" value="<?php echo $_smarty_tpl->getValue('r')['id'];?>
">
                            <input type="hidden" name="id_segnalazione" value="<?php echo $_smarty_tpl->getValue('r')['idSegnalazioneDaRisolvere'];?>
">
                            <button type="submit" class="btn btn--danger">Elimina</button>
                        </form>
                    </div>
                </article>
            <?php
}
if ($foreach0DoElse) {
?>
                <div class="list-empty">Nessuna recensione segnalata al momento.</div>
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
