<?php
/* Smarty version 5.8.0, created on 2026-07-22 00:51:40
  from 'file:gestore_dettaglio_serata.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a5ff7fc831375_01562727',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '430fe291378bae123d78377cd9e76ba5f9da0efd' => 
    array (
      0 => 'gestore_dettaglio_serata.tpl',
      1 => 1784674292,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a5ff7fc831375_01562727 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_4445149746a5ff7fc8042a7_15491882', "page_css");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_431230116a5ff7fc809af2_65093422', "content");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "layout_gestore.tpl", $_smarty_current_dir);
}
/* {block "page_css"} */
class Block_4445149746a5ff7fc8042a7_15491882 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

    <link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/css/eventi_gestore_dettaglio.css">
<?php
}
}
/* {/block "page_css"} */
/* {block "content"} */
class Block_431230116a5ff7fc809af2_65093422 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>


<?php $_smarty_tpl->assign('stato', mb_strtolower((string) $_smarty_tpl->getValue('statoEvento'), 'UTF-8'), false, NULL);?>

<div class="gdet-container">

    <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/eventi/serate" class="gdet-back">
        <i class="ti ti-arrow-left"></i> Torna alle serate
    </a>

        <div class="gdet-header">
        <div class="gdet-header__img-wrapper">
            <img src="<?php echo $_smarty_tpl->getValue('imgEvento');?>
" alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('nomeEvento'), ENT_QUOTES, 'UTF-8', true);?>
" class="gdet-header__img">
            <span class="gdet-status gdet-status--<?php echo $_smarty_tpl->getValue('stato');?>
"><?php echo $_smarty_tpl->getValue('statoEvento');?>
</span>
        </div>

        <div class="gdet-header__info">
            <span class="gdet-type"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('tipoSerata'), ENT_QUOTES, 'UTF-8', true);?>
</span>
            <h1 class="gdet-title"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('nomeEvento'), ENT_QUOTES, 'UTF-8', true);?>
</h1>

            <div class="gdet-meta">
                <span class="gdet-meta-row">
                    <i class="ti ti-calendar"></i> <?php echo $_smarty_tpl->getSmarty()->getModifierCallback('date_format')($_smarty_tpl->getValue('dataInizio'),"%d %B %Y, %H:%M");?>

                </span>
                <span class="gdet-meta-row<?php if ($_smarty_tpl->getValue('postiRimanenti') <= 0) {?> gdet-meta-row--full<?php }?>">
                    <i class="ti ti-users"></i>
                    <?php echo $_smarty_tpl->getValue('numeroPartecipanti');?>
 / <?php echo $_smarty_tpl->getValue('maxPartecipanti');?>
 iscritti
                    <?php if ($_smarty_tpl->getValue('postiRimanenti') <= 0) {?>&mdash; Al completo<?php } else { ?>&mdash; <?php echo $_smarty_tpl->getValue('postiRimanenti');?>
 posti liberi<?php }?>
                </span>
                <span class="gdet-meta-row">
                    <i class="ti ti-ticket"></i>
                    <?php if ($_smarty_tpl->getValue('richiedeQuota')) {?>Evento a pagamento<?php } else { ?>Evento gratuito<?php }?>
                </span>
            </div>
        </div>
    </div>

        <section class="gdet-section">
        <h2 class="gdet-section__title"><i class="ti ti-file-description"></i> Descrizione</h2>
        <p class="gdet-section__text"><?php echo nl2br((string) htmlspecialchars((string)$_smarty_tpl->getValue('descrizioneEvento'), ENT_QUOTES, 'UTF-8', true), (bool) 1);?>
</p>
    </section>

        <section class="gdet-section gdet-actions">
        <h2 class="gdet-section__title"><i class="ti ti-settings"></i> Gestione evento</h2>

        <div class="gdet-actions__grid">

            <?php if ($_smarty_tpl->getValue('stato') == 'programmato') {?>
                <?php $_smarty_tpl->assign('oraCorrente', $_smarty_tpl->getSmarty()->getModifierCallback('date_format')(time(),"%Y-%m-%d %H:%M:%S"), false, NULL);?>
                <?php $_smarty_tpl->assign('giaIniziata', $_smarty_tpl->getValue('dataInizio') <= $_smarty_tpl->getValue('oraCorrente'), false, NULL);?>
                <?php if ($_smarty_tpl->getValue('giaIniziata')) {?>
                    <form method="post" action="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/eventi/attiva" class="gdet-action-form">
                        <input type="hidden" name="id_evento" value="<?php echo $_smarty_tpl->getValue('idEvento');?>
">
                        <button type="submit" class="gdet-btn gdet-btn--success">
                            <i class="ti ti-player-play"></i> Attiva evento
                        </button>
                    </form>
                <?php } else { ?>
                                        <span class="gdet-btn gdet-btn--disabled" title="Disponibile solo dopo la data di inizio (<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('date_format')($_smarty_tpl->getValue('dataInizio'),"%d %B %Y, %H:%M");?>
)">
                        <i class="ti ti-player-play"></i> Attiva evento
                    </span>
                <?php }?>

                <form method="post" action="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/eventi/annulla" class="gdet-action-form" onsubmit="return confirm('Annullare questa serata?');">
                    <input type="hidden" name="id_evento" value="<?php echo $_smarty_tpl->getValue('idEvento');?>
">
                    <button type="submit" class="gdet-btn gdet-btn--warning">
                        <i class="ti ti-ban"></i> Annulla evento
                    </button>
                </form>
            <?php }?>

            <?php if ($_smarty_tpl->getValue('stato') == 'in_corso') {?>
                <form method="post" action="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/eventi/concludi" class="gdet-action-form" onsubmit="return confirm('Concludere questa serata?');">
                    <input type="hidden" name="id_evento" value="<?php echo $_smarty_tpl->getValue('idEvento');?>
">
                    <button type="submit" class="gdet-btn gdet-btn--success">
                        <i class="ti ti-flag-check"></i> Concludi evento
                    </button>
                </form>
            <?php }?>

            <?php if ($_smarty_tpl->getValue('stato') == 'terminato') {?>
                <p class="gdet-info-text">
                    <i class="ti ti-info-circle"></i> Le serate concluse non richiedono nessuna pubblicazione di esiti.
                </p>
            <?php }?>

                        <button type="button" class="gdet-btn gdet-btn--info" onclick="document.getElementById('modal-modifica').showModal()">
                <i class="ti ti-edit"></i> Modifica dati
            </button>

            <?php if ($_smarty_tpl->getValue('stato') == 'annullato') {?>
    <button type="button" class="gdet-btn gdet-btn--primary" onclick="document.getElementById('modal-riprogramma').showModal()">
        <i class="ti ti-calendar-repeat"></i> Riprogramma
    </button>
<?php }?>
        </div>

                <dialog class="gdet-modal" id="modal-modifica">
            <div class="gdet-modal__content">
                <button type="button" class="gdet-modal__close" onclick="document.getElementById('modal-modifica').close()" aria-label="Chiudi">
                    <i class="ti ti-x"></i>
                </button>

                <h3 class="gdet-panel__title">Modifica dati evento</h3>
                <p class="gdet-panel__hint">Non è possibile modificare data o stato da qui: usa i pulsanti dedicati sopra.</p>

                <form method="post" action="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/eventi/modifica" enctype="multipart/form-data" class="gdet-form">
                    <input type="hidden" name="id_evento" value="<?php echo $_smarty_tpl->getValue('idEvento');?>
">

                    <label class="gdet-form__label" for="nomeEvento">Nome evento</label>
                    <input type="text" id="nomeEvento" name="nomeEvento" class="gdet-form__input" value="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('nomeEvento'), ENT_QUOTES, 'UTF-8', true);?>
" maxlength="255" required>

                    <label class="gdet-form__label" for="descrizioneEvento">Descrizione</label>
                    <textarea id="descrizioneEvento" name="descrizioneEvento" class="gdet-form__textarea" rows="4" required><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('descrizioneEvento'), ENT_QUOTES, 'UTF-8', true);?>
</textarea>

                    <label class="gdet-form__label" for="maxPartecipanti">Numero massimo partecipanti</label>
                    <input type="number" id="maxPartecipanti" name="maxPartecipanti" class="gdet-form__input" value="<?php echo $_smarty_tpl->getValue('maxPartecipanti');?>
" min="<?php echo $_smarty_tpl->getValue('numeroPartecipanti');?>
" required>

                    <label class="gdet-form__label" for="imgEvento">Immagine (lascia vuoto per non modificarla)</label>
                    <img src="<?php echo $_smarty_tpl->getValue('imgEvento');?>
" alt="Immagine attuale" class="gdet-form__img-preview">
                    <input type="file" id="imgEvento" name="imgEvento" class="gdet-form__input" accept="image/*">

                    <div class="gdet-modal__actions">
                        <button type="button" class="gdet-btn gdet-btn--muted" onclick="document.getElementById('modal-modifica').close()">
                            Annulla
                        </button>
                        <button type="submit" class="gdet-btn gdet-btn--success">
                            <i class="ti ti-device-floppy"></i> Salva modifiche
                        </button>
                    </div>
                </form>
            </div>
        </dialog>

        <?php if ($_smarty_tpl->getValue('stato') == 'annullato') {?>
    <dialog class="gdet-modal" id="modal-riprogramma">
        <div class="gdet-modal__content">
            <button type="button" class="gdet-modal__close" onclick="document.getElementById('modal-riprogramma').close()" aria-label="Chiudi">
                <i class="ti ti-x"></i>
            </button>

            <h3 class="gdet-panel__title">Riprogramma evento</h3>
            <p class="gdet-panel__hint">Imposta una nuova data futura: l'evento tornerà in stato "Programmato".</p>

            <form method="post" action="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/eventi/riprogramma" class="gdet-form" id="form-riprogramma-<?php echo $_smarty_tpl->getValue('idEvento');?>
">
                <input type="hidden" name="id_evento" value="<?php echo $_smarty_tpl->getValue('idEvento');?>
">
                <label class="gdet-form__label" for="nuovaDataInizio">Nuova data e ora</label>
                <label class="gdet-form__label" for="nuovaDataInizio_visibile">Nuova data e ora</label>
<input type="datetime-local" id="nuovaDataInizio_visibile" class="gdet-form__input" required>
<input type="hidden" id="nuovaDataInizio" name="nuovaDataInizio">

                <div class="gdet-modal__actions">
                    <button type="button" class="gdet-btn gdet-btn--muted" onclick="document.getElementById('modal-riprogramma').close()">
                        Annulla
                    </button>
                    <button type="submit" class="gdet-btn gdet-btn--primary">
                        <i class="ti ti-calendar-repeat"></i> Conferma riprogrammazione
                    </button>
                </div>
            </form>
        </div>
    </dialog>
<?php }?>
    </section>

</div>

<?php echo '<script'; ?>
>
    // Chiude il popup "Modifica dati" cliccando sul backdrop
    (function() {
    ['modal-modifica', 'modal-riprogramma'].forEach(function(id) {
        var dialog = document.getElementById(id);
        if (dialog) {
            dialog.addEventListener('click', function(e) {
                if (e.target === dialog) dialog.close();
            });
        }
    });
})();

    <?php if ($_smarty_tpl->getValue('stato') == 'annullato') {?>
(function() {
    var form = document.getElementById('form-riprogramma-<?php echo $_smarty_tpl->getValue('idEvento');?>
');
    if (!form) return;
    form.addEventListener('submit', function() {
        var visibile = form.querySelector('#nuovaDataInizio_visibile');
        var hidden = form.querySelector('#nuovaDataInizio');
        if (visibile && visibile.value) {
            var valore = visibile.value; // "YYYY-MM-DDTHH:MM"
            if (valore.length === 16) valore += ':00';
            hidden.value = valore.replace('T', ' ');
        }
    });
})();
<?php }
if ($_smarty_tpl->getValue('stato') == 'annullato') {?>
(function() {
    var form = document.getElementById('form-riprogramma-<?php echo $_smarty_tpl->getValue('idEvento');?>
');
    if (!form) return;
    form.addEventListener('submit', function() {
        var visibile = form.querySelector('#nuovaDataInizio_visibile');
        var hidden = form.querySelector('#nuovaDataInizio');
        if (visibile && visibile.value) {
            var valore = visibile.value; // "YYYY-MM-DDTHH:MM"
            if (valore.length === 16) valore += ':00';
            hidden.value = valore.replace('T', ' ');
        }
    });
})();
<?php }
echo '</script'; ?>
>

<?php
}
}
/* {/block "content"} */
}
