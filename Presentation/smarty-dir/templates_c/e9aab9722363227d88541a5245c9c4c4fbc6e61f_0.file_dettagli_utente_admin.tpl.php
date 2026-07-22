<?php
/* Smarty version 5.8.0, created on 2026-07-22 15:26:41
  from 'file:dettagli_utente_admin.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a60c5110db0e0_61132943',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e9aab9722363227d88541a5245c9c4c4fbc6e61f' => 
    array (
      0 => 'dettagli_utente_admin.tpl',
      1 => 1784726761,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a60c5110db0e0_61132943 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_1400818756a60c5110beac0_14844731', "page_css");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_19058393026a60c5110c2354_94978773', "content");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "layout_admin.tpl", $_smarty_current_dir);
}
/* {block "page_css"} */
class Block_1400818756a60c5110beac0_14844731 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

    <link rel="stylesheet" href="css/dettagli_utente_admin.css">
<?php
}
}
/* {/block "page_css"} */
/* {block "content"} */
class Block_19058393026a60c5110c2354_94978773 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<div class="profile-page">

    <div class="profile-page__top">
        <a href="/admin/utenti" class="profile-page__back">&larr; Torna alla lista utenti</a>
    </div>

    <div class="profile-header">
        <div class="profile-header__identity">
            <div class="profile-avatar">
                <span><?php echo mb_strtoupper((string) $_smarty_tpl->getSmarty()->getModifierCallback('truncate')($_smarty_tpl->getValue('utenteProfilo')['nome'],1,'',true) ?? '', 'UTF-8');?>
</span>
            </div>
            <div class="profile-header__info">
                <h1><?php echo $_smarty_tpl->getValue('utenteProfilo')['nome'];?>
</h1>
                <div class="profile-header__meta">
                    <span class="profile-header__id">ID #<?php echo $_smarty_tpl->getValue('utenteProfilo')['id'];?>
</span>
                    <span class="badge badge--<?php echo $_smarty_tpl->getValue('utenteProfilo')['stato'];?>
"><?php echo $_smarty_tpl->getSmarty()->getModifierCallback('replace')($_smarty_tpl->getValue('utenteProfilo')['stato'],'_',' ');?>
</span>
                </div>
            </div>
        </div>

        <div class="profile-header__actions">
            <form action="/admin/utente/sospendi" method="post"
                  data-confirm-message="Sospendere <?php echo $_smarty_tpl->getValue('utenteProfilo')['nome'];?>
 per 3 mesi? Non potrà accedere al proprio account fino alla scadenza.">
                <input type="hidden" name="id_persona" value="<?php echo $_smarty_tpl->getValue('utenteProfilo')['id'];?>
">
                <button type="submit" class="btn btn--warning">Sospendi</button>
            </form>
            <form action="/admin/utente/banna" method="post"
                  data-confirm-message="Bannare <?php echo $_smarty_tpl->getValue('utenteProfilo')['nome'];?>
 in modo permanente? L'account non potrà più essere riattivato.">
                <input type="hidden" name="id_persona" value="<?php echo $_smarty_tpl->getValue('uteutenteProfilonte')['id'];?>
">
                <button type="submit" class="btn btn--danger">Banna</button>
            </form>
        </div>
    </div>

    <div class="panel">
        <div class="panel__header">
            <h2>Recensioni dell'utente</h2>
            <?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('recensioniSegnalate')) > 0) {?>
                <span class="panel__badge"><?php echo $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('recensioniSegnalate'));?>
</span>
            <?php }?>
        </div>

        <?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('recensioniSegnalate')) > 0) {?>
            <ul class="recensione-list">
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('recensioniSegnalate'), 'recensione');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('recensione')->value) {
$foreach0DoElse = false;
?>
                    <li class="recensione-card">
                        <div class="recensione-card__avatar" <?php if ($_smarty_tpl->getValue('recensione')['prodotto']['immagine']) {?>style="background-image:url('<?php echo $_smarty_tpl->getValue('recensione')['prodotto']['immagine'];?>
')"<?php }?>></div>

                        <div class="recensione-card__body">
                            <div class="recensione-card__head">
                                <span class="recensione-card__utente"><?php echo $_smarty_tpl->getValue('recensione')['utente'];?>
</span>
                                <span class="recensione-card__data"><?php echo $_smarty_tpl->getSmarty()->getModifierCallback('date_format')($_smarty_tpl->getValue('recensione')['data'],"%d/%m/%Y");?>
</span>
                            </div>
                            <p class="recensione-card__prodotto">su <a href="/prodotto?id=<?php echo $_smarty_tpl->getValue('recensione')['prodotto']['id'];?>
"><?php echo $_smarty_tpl->getValue('recensione')['prodotto']['nome'];?>
</a></p>
                            <p class="recensione-card__testo"><?php echo $_smarty_tpl->getValue('recensione')['testo'];?>
</p>
                        </div>

                        <form action="/admin/recensioni/elimina" method="post" class="recensione-card__form"
                              data-confirm-message="Rimuovere questa recensione dal sito?">
                            <input type="hidden" name="id_recensione" value="<?php echo $_smarty_tpl->getValue('recensione')['id'];?>
">
                            <button type="submit" class="btn btn--danger-outline btn--small">Rimuovi</button>
                        </form>
                    </li>
                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
            </ul>
        <?php } else { ?>
            <p class="list-empty">Questo utente non ha ancora scritto recensioni.</p>
        <?php }?>
    </div>

</div>
<?php
}
}
/* {/block "content"} */
}
