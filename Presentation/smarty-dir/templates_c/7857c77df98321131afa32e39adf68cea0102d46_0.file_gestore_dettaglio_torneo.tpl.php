<?php
/* Smarty version 5.8.0, created on 2026-07-22 00:48:29
  from 'file:gestore_dettaglio_torneo.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a5ff73d319e16_34373182',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7857c77df98321131afa32e39adf68cea0102d46' => 
    array (
      0 => 'gestore_dettaglio_torneo.tpl',
      1 => 1784674104,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a5ff73d319e16_34373182 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_20508486436a5ff73d2d8c88_29203992', "page_css");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_15255367916a5ff73d2dc796_88706320', "content");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "layout_gestore.tpl", $_smarty_current_dir);
}
/* {block "page_css"} */
class Block_20508486436a5ff73d2d8c88_29203992 extends \Smarty\Runtime\Block
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
class Block_15255367916a5ff73d2dc796_88706320 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>


<?php $_smarty_tpl->assign('stato', mb_strtolower((string) $_smarty_tpl->getValue('statoEvento'), 'UTF-8'), false, NULL);
$_smarty_tpl->assign('podioEsiste', (true && ($_smarty_tpl->hasVariable('podio') && null !== ($_smarty_tpl->getValue('podio') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('podio')) > 0, false, NULL);?>

<div class="gdet-container">

    <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/eventi/tornei" class="gdet-back">
        <i class="ti ti-arrow-left"></i> Torna ai tornei
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
            <span class="gdet-type">Torneo &middot; <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('gioco'), ENT_QUOTES, 'UTF-8', true);?>
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
                    <?php if ($_smarty_tpl->getValue('richiedeQuota')) {?>&euro;<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('quotaIscrizione'),2);?>
 iscrizione<?php } else { ?>Iscrizione gratuita<?php }?>
                </span>
                <?php if ($_smarty_tpl->getValue('challenge')) {?>
                    <span class="gdet-meta-row">
                        <i class="ti ti-swords"></i> Parte della challenge
                        <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/eventi/dettaglio/<?php echo $_smarty_tpl->getValue('challenge')['idEvento'];?>
" class="gdet-link"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('challenge')['nomeEvento'], ENT_QUOTES, 'UTF-8', true);?>
</a>
                    </span>
                <?php }?>
            </div>
        </div>
    </div>

        <section class="gdet-section">
        <h2 class="gdet-section__title"><i class="ti ti-file-description"></i> Descrizione</h2>
        <p class="gdet-section__text"><?php echo nl2br((string) htmlspecialchars((string)$_smarty_tpl->getValue('descrizioneEvento'), ENT_QUOTES, 'UTF-8', true), (bool) 1);?>
</p>
    </section>

    <section class="gdet-section">
        <h2 class="gdet-section__title"><i class="ti ti-gift"></i> Premio in palio</h2>
        <div class="gdet-premio-card">
            <img src="<?php echo $_smarty_tpl->getValue('premio')['immagine'];?>
" alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('premio')['nome'], ENT_QUOTES, 'UTF-8', true);?>
" class="gdet-premio-card__img">
            <div class="gdet-premio-card__info">
                <span class="gdet-premio-card__name"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('premio')['nome'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                <?php if ($_smarty_tpl->getValue('premio')['sconto']) {?>
                    <span class="gdet-premio-card__price gdet-premio-card__price--old">&euro;<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('premio')['prezzo'],2);?>
</span>
                    <span class="gdet-premio-card__price">&euro;<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('premio')['prezzo_scontato'],2);?>
</span>
                <?php } else { ?>
                    <span class="gdet-premio-card__price">&euro;<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('premio')['prezzo'],2);?>
</span>
                <?php }?>
            </div>
        </div>
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
/gestore/eventi/annulla" class="gdet-action-form" onsubmit="return confirm('Annullare questo torneo?');">
                    <input type="hidden" name="id_evento" value="<?php echo $_smarty_tpl->getValue('idEvento');?>
">
                    <button type="submit" class="gdet-btn gdet-btn--warning">
                        <i class="ti ti-ban"></i> Annulla evento
                    </button>
                </form>
            <?php }?>

            <?php if ($_smarty_tpl->getValue('stato') == 'in_corso') {?>
                <form method="post" action="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/eventi/concludi" class="gdet-action-form" onsubmit="return confirm('Concludere questo torneo?');">
                    <input type="hidden" name="id_evento" value="<?php echo $_smarty_tpl->getValue('idEvento');?>
">
                    <button type="submit" class="gdet-btn gdet-btn--success">
                        <i class="ti ti-flag-check"></i> Concludi evento
                    </button>
                </form>
            <?php }?>

            <button type="button" class="gdet-btn gdet-btn--info" onclick="document.getElementById('modal-modifica').showModal()">
                <i class="ti ti-edit"></i> Modifica dati
            </button>

            <?php if ($_smarty_tpl->getValue('stato') == 'annullato') {?>
    <button type="button" class="gdet-btn gdet-btn--primary" onclick="document.getElementById('modal-riprogramma').showModal()">
        <i class="ti ti-calendar-repeat"></i> Riprogramma
    </button>
<?php }?>

            <?php if ($_smarty_tpl->getValue('stato') == 'terminato') {?>
                <button type="button" class="gdet-btn gdet-btn--primary" onclick="document.getElementById('modal-esito').showModal()">
                    <i class="ti ti-medal"></i> <?php if ($_smarty_tpl->getValue('podioEsiste')) {?>Modifica esito<?php } else { ?>Aggiungi esito<?php }?>
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

        <?php if ($_smarty_tpl->getValue('stato') == 'terminato') {?>
                        <?php if ($_smarty_tpl->getValue('podioEsiste')) {?>
                <div class="gdet-podio">
                    <h3 class="gdet-panel__title">Podio pubblicato</h3>
                    <ul class="gdet-podio__list">
                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('podio'), 'piazzamento');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('piazzamento')->value) {
$foreach0DoElse = false;
?>
                            <li class="gdet-podio__item gdet-podio__item--<?php echo $_smarty_tpl->getValue('piazzamento')['posizione'];?>
">
                                <span class="gdet-podio__medal">
                                    <?php if ($_smarty_tpl->getValue('piazzamento')['posizione'] == 1) {?><i class="ti ti-medal"></i> 1&deg;
                                    <?php } elseif ($_smarty_tpl->getValue('piazzamento')['posizione'] == 2) {?><i class="ti ti-medal-2"></i> 2&deg;
                                    <?php } else { ?><i class="ti ti-medal-2"></i> 3&deg;<?php }?>
                                </span>
                                <span class="gdet-podio__name"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('piazzamento')['utente']['nome'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                            </li>
                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                    </ul>
                </div>
            <?php }?>

                        <dialog class="gdet-modal" id="modal-esito">
                <div class="gdet-modal__content">
                    <button type="button" class="gdet-modal__close" onclick="document.getElementById('modal-esito').close()" aria-label="Chiudi">
                        <i class="ti ti-x"></i>
                    </button>

                    <h3 class="gdet-panel__title"><?php if ($_smarty_tpl->getValue('podioEsiste')) {?>Modifica esito<?php } else { ?>Aggiungi esito<?php }?></h3>
                    <?php if (!(true && ($_smarty_tpl->hasVariable('iscritti') && null !== ($_smarty_tpl->getValue('iscritti') ?? null))) || $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('iscritti')) == 0) {?>
                        <p class="gdet-warning">
                            <i class="ti ti-alert-triangle"></i>
                            Elenco iscritti non disponibile: verificare con Control che $iscritti sia esposto in questa vista.
                        </p>
                    <?php }?>
                    <form method="post" action="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/eventi/tornei/esito" class="gdet-form" id="form-esito-<?php echo $_smarty_tpl->getValue('idEvento');?>
">
                        <input type="hidden" name="id_evento" value="<?php echo $_smarty_tpl->getValue('idEvento');?>
">

                        <?php $_smarty_tpl->assign('idPrimo', null, false, NULL);?>
                        <?php $_smarty_tpl->assign('idSecondo', null, false, NULL);?>
                        <?php $_smarty_tpl->assign('idTerzo', null, false, NULL);?>
                        <?php if ($_smarty_tpl->getValue('podioEsiste')) {?>
                            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('podio'), 'p');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('p')->value) {
$foreach1DoElse = false;
?>
                                <?php if ($_smarty_tpl->getValue('p')['posizione'] == 1) {
$_smarty_tpl->assign('idPrimo', $_smarty_tpl->getValue('p')['utente']['id'], false, NULL);
}?>
                                <?php if ($_smarty_tpl->getValue('p')['posizione'] == 2) {
$_smarty_tpl->assign('idSecondo', $_smarty_tpl->getValue('p')['utente']['id'], false, NULL);
}?>
                                <?php if ($_smarty_tpl->getValue('p')['posizione'] == 3) {
$_smarty_tpl->assign('idTerzo', $_smarty_tpl->getValue('p')['utente']['id'], false, NULL);
}?>
                            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                        <?php }?>

                        <label class="gdet-form__label" for="id_primo">1&deg; classificato *</label>
                        <select id="id_primo" name="id_primo" class="gdet-form__input gdet-podio-select" required>
                            <option value="">Seleziona...</option>
                            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, (($tmp = $_smarty_tpl->getValue('iscritti') ?? null)===null||$tmp==='' ? array() ?? null : $tmp), 'iscritto');
$foreach2DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('iscritto')->value) {
$foreach2DoElse = false;
?>
                                <option value="<?php echo $_smarty_tpl->getValue('iscritto')['id'];?>
" <?php if ($_smarty_tpl->getValue('idPrimo') == $_smarty_tpl->getValue('iscritto')['id']) {?>selected<?php }?>><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('iscritto')['nome'], ENT_QUOTES, 'UTF-8', true);?>
</option>
                            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                        </select>

                        <label class="gdet-form__label" for="id_secondo">2&deg; classificato</label>
                        <select id="id_secondo" name="id_secondo" class="gdet-form__input gdet-podio-select">
                            <option value="">Nessuno</option>
                            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, (($tmp = $_smarty_tpl->getValue('iscritti') ?? null)===null||$tmp==='' ? array() ?? null : $tmp), 'iscritto');
$foreach3DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('iscritto')->value) {
$foreach3DoElse = false;
?>
                                <option value="<?php echo $_smarty_tpl->getValue('iscritto')['id'];?>
" <?php if ($_smarty_tpl->getValue('idSecondo') == $_smarty_tpl->getValue('iscritto')['id']) {?>selected<?php }?>><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('iscritto')['nome'], ENT_QUOTES, 'UTF-8', true);?>
</option>
                            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                        </select>

                        <label class="gdet-form__label" for="id_terzo">3&deg; classificato</label>
                        <select id="id_terzo" name="id_terzo" class="gdet-form__input gdet-podio-select">
                            <option value="">Nessuno</option>
                            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, (($tmp = $_smarty_tpl->getValue('iscritti') ?? null)===null||$tmp==='' ? array() ?? null : $tmp), 'iscritto');
$foreach4DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('iscritto')->value) {
$foreach4DoElse = false;
?>
                                <option value="<?php echo $_smarty_tpl->getValue('iscritto')['id'];?>
" <?php if ($_smarty_tpl->getValue('idTerzo') == $_smarty_tpl->getValue('iscritto')['id']) {?>selected<?php }?>><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('iscritto')['nome'], ENT_QUOTES, 'UTF-8', true);?>
</option>
                            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                        </select>

                        <div class="gdet-modal__actions">
                            <button type="button" class="gdet-btn gdet-btn--muted" onclick="document.getElementById('modal-esito').close()">
                                Annulla
                            </button>
                            <button type="submit" class="gdet-btn gdet-btn--success">
                                <i class="ti ti-device-floppy"></i> Salva esito
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
    // Impedisce lato client di scegliere due volte la stessa persona nei 3 selettori
    // del podio (Control valida comunque server-side, questo è solo un aiuto in UI).
    (function() {
        var selects = document.querySelectorAll('#form-esito-<?php echo $_smarty_tpl->getValue('idEvento');?>
 .gdet-podio-select');
        if (!selects.length) return;

        function aggiornaOpzioni() {
            var scelti = Array.prototype.map.call(selects, function(s) { return s.value; }).filter(function(v) { return v !== ''; });
            selects.forEach(function(select) {
                Array.prototype.forEach.call(select.options, function(opt) {
                    if (opt.value === '') return;
                    opt.disabled = scelti.indexOf(opt.value) !== -1 && opt.value !== select.value;
                });
            });
        }
        selects.forEach(function(s) { s.addEventListener('change', aggiornaOpzioni); });
        aggiornaOpzioni();
    })();

    // Chiude i popup cliccando sul backdrop
    (function() {
        ['modal-modifica', 'modal-esito', 'modal-riprogramma'].forEach(function(id) {
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
            var valore = visibile.value; // "YYYY-MM-DDTHH:MM" o "...:SS"
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
