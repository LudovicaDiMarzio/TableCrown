<?php
/* Smarty version 5.8.0, created on 2026-07-17 17:32:07
  from 'file:home_a.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a5a4af7ef67e2_79098058',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ecacc12dd6fedddb1d7b8843118f1bceb9b8c0f8' => 
    array (
      0 => 'home_a.tpl',
      1 => 1784302324,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a5a4af7ef67e2_79098058 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_8217617116a5a4af7ede873_05845307', "page_css");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_6037385406a5a4af7ee23c2_64465096', "content");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "layout_admin.tpl", $_smarty_current_dir);
}
/* {block "page_css"} */
class Block_8217617116a5a4af7ede873_05845307 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

    <link rel="stylesheet" href="/css/home_a.css">
<?php
}
}
/* {/block "page_css"} */
/* {block "content"} */
class Block_6037385406a5a4af7ee23c2_64465096 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

    <div class="dash">
        <div class="dash__heading">
            <h1>Dashboard Amministratore</h1>
            <p>Controllo e moderazione della piattaforma</p>
        </div>

        <section class="dash__stats">
            <article class="stat-card stat-card--danger">
                <span class="stat-card__icon stat-card__icon--danger ti ti-flag-3"></span>
                <div class="stat-card__body">
                    <span class="stat-card__label">Segnalazioni in attesa</span>
                    <span class="stat-card__value"><?php echo $_smarty_tpl->getValue('segnalazioniInSospeso');?>
</span>
                </div>
            </article>

            <article class="stat-card stat-card--primary">
                <span class="stat-card__icon stat-card__icon--primary ti ti-users"></span>
                <div class="stat-card__body">
                    <span class="stat-card__label">Utenti totali</span>
                    <span class="stat-card__value"><?php echo $_smarty_tpl->getValue('utentiTotali');?>
</span>

                </div>
            </article>

            <article class="stat-card stat-card--warning">
                <span class="stat-card__icon stat-card__icon--warning ti ti-user-off"></span>
                <div class="stat-card__body">
                    <span class="stat-card__label">Utenti sospesi</span>
                    <span class="stat-card__value"><?php echo $_smarty_tpl->getValue('utentiSospesiTotali');?>
</span>

                </div>
            </article>
        </section>

        <section class="dash__grid dash__grid--single">
            <div class="panel panel--segnalazioni">
                <div class="panel__header">
                    <h2>
                        Segnalazioni in attesa
                        <?php if ($_smarty_tpl->getValue('segnalazioniInSospeso') > 0) {?>
                            <span class="panel__badge"><?php echo $_smarty_tpl->getValue('segnalazioniInSospeso');?>
</span>
                        <?php }?>
                    </h2>
                    <a href="/admin/recensioni" class="panel__link">Vedi tutte</a>
                </div>

                <ul class="segnalazioni-list">
                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('segnalazioniUrgenti'), 's');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('s')->value) {
$foreach0DoElse = false;
?>
                        <li class="segnalazione-item">
                            <span class="segnalazione-item__icon ti ti-flag-3"></span>
                            <div class="segnalazione-item__body">
                                <span class="segnalazione-item__tipo"><?php echo $_smarty_tpl->getValue('s')['motivazione']['nome'];?>
</span>
                                <span class="segnalazione-item__meta">
                                    Segnalata da: <?php echo $_smarty_tpl->getValue('s')['utenteSegnalante']['nome'];?>
 &middot;
                                    Recensione di <?php echo $_smarty_tpl->getValue('s')['autoreRecensione']['nome'];?>
 su "<?php echo $_smarty_tpl->getValue('s')['prodotto']['nome'];?>
"
                                </span>
                                <span class="segnalazione-item__tempo"><?php echo $_smarty_tpl->getSmarty()->getModifierCallback('date_format')($_smarty_tpl->getValue('s')['data'],"%d/%m/%Y %H:%M");?>
</span>
                            </div>
                            <span class="badge badge--<?php echo $_smarty_tpl->getValue('s')['motivazione']['gravita'];?>
">
                                <?php if ($_smarty_tpl->getValue('s')['motivazione']['gravita'] === 'alta') {?>Alta
                                <?php } elseif ($_smarty_tpl->getValue('s')['motivazione']['gravita'] === 'media') {?>Media
                                <?php } else { ?>Bassa
                                <?php }?>
                            </span>
                            <a href="/admin/utente/profilo?id=<?php echo $_smarty_tpl->getValue('s')['autoreRecensione']['id'];?>
" class="btn btn--outline">Visualizza</a>
                        </li>
                    <?php
}
if ($foreach0DoElse) {
?>
                        <li class="list-empty">Nessuna segnalazione in attesa.</li>
                    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                </ul>
            </div>
        </section>
    </div>
<?php
}
}
/* {/block "content"} */
}
