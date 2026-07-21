<?php
/* Smarty version 5.8.0, created on 2026-07-22 00:26:30
  from 'file:gestore_dettaglio_challenge.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a5ff216340689_22642035',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5798dbe05dd1e4a69058a203b74bf305eec465c3' => 
    array (
      0 => 'gestore_dettaglio_challenge.tpl',
      1 => 1784555473,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a5ff216340689_22642035 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_16069795666a5ff2163137b7_52221088', "page_css");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_6883663716a5ff216315945_49866697', "content");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "layout_gestore.tpl", $_smarty_current_dir);
}
/* {block "page_css"} */
class Block_16069795666a5ff2163137b7_52221088 extends \Smarty\Runtime\Block
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
class Block_6883663716a5ff216315945_49866697 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>


<?php $_smarty_tpl->assign('stato', mb_strtolower((string) $_smarty_tpl->getValue('statoEvento'), 'UTF-8'), false, NULL);?>

<div class="gdet-container">

    <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/eventi/challenge" class="gdet-back">
        <i class="ti ti-arrow-left"></i> Torna alle challenge
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
            <span class="gdet-type">Challenge &middot; <?php echo $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('tornei'));?>
 tornei</span>
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

    <section class="gdet-section">
        <h2 class="gdet-section__title"><i class="ti ti-star"></i> Punteggi challenge</h2>
        <p class="gdet-section__text">Punti assegnati in base al piazzamento ottenuto in ciascun torneo incluso:</p>
        <div class="gdet-punteggi">
            <span class="gdet-punteggi__item"><i class="ti ti-medal"></i> 1&deg; posto: <?php echo $_smarty_tpl->getValue('punteggi')['primo'];?>
 punti</span>
            <span class="gdet-punteggi__item"><i class="ti ti-medal-2"></i> 2&deg; posto: <?php echo $_smarty_tpl->getValue('punteggi')['secondo'];?>
 punti</span>
            <span class="gdet-punteggi__item"><i class="ti ti-medal-2"></i> 3&deg; posto: <?php echo $_smarty_tpl->getValue('punteggi')['terzo'];?>
 punti</span>
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
/gestore/eventi/annulla" class="gdet-action-form" onsubmit="return confirm('Annullare questa challenge?');">
                    <input type="hidden" name="id_evento" value="<?php echo $_smarty_tpl->getValue('idEvento');?>
">
                    <button type="submit" class="gdet-btn gdet-btn--warning">
                        <i class="ti ti-ban"></i> Annulla evento
                    </button>
                </form>
            <?php }?>

            <?php if ($_smarty_tpl->getValue('stato') == 'in_corso') {?>
                <form method="post" action="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/eventi/concludi" class="gdet-action-form" onsubmit="return confirm('Concludere questa challenge?');">
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
                <input type="checkbox" id="toggle-riprogramma" class="gdet-toggle-checkbox">
                <label for="toggle-riprogramma" class="gdet-btn gdet-btn--primary">
                    <i class="ti ti-calendar-repeat"></i> Riprogramma
                </label>
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
            <div class="gdet-panel" id="panel-riprogramma">
                <h3 class="gdet-panel__title">Riprogramma evento</h3>
                <p class="gdet-panel__hint">Imposta una nuova data futura: l'evento tornerà in stato "Programmato".</p>
                <form method="post" action="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/eventi/riprogramma" class="gdet-form" id="form-riprogramma-<?php echo $_smarty_tpl->getValue('idEvento');?>
">
                    <input type="hidden" name="id_evento" value="<?php echo $_smarty_tpl->getValue('idEvento');?>
">
                    <label class="gdet-form__label" for="nuovaDataInizio">Nuova data e ora</label>
                    <input type="datetime-local" id="nuovaDataInizio" name="nuovaDataInizio" class="gdet-form__input" required>
                    <button type="submit" class="gdet-btn gdet-btn--primary">
                        <i class="ti ti-calendar-repeat"></i> Conferma riprogrammazione
                    </button>
                </form>
            </div>
        <?php }?>
    </section>

        <?php if ($_smarty_tpl->getValue('stato') == 'terminato') {?>
        <section class="gdet-section" id="tornei">
            <h2 class="gdet-section__title"><i class="ti ti-trophy"></i> Tornei ed esiti</h2>

            <?php if (!$_smarty_tpl->getValue('classificaGenerata')) {?>

                <?php if ((true && ($_smarty_tpl->hasVariable('torneiSenzaEsito') && null !== ($_smarty_tpl->getValue('torneiSenzaEsito') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('torneiSenzaEsito')) > 0) {?>
                    <p class="gdet-warning">
                        <i class="ti ti-alert-triangle"></i>
                        Mancano ancora gli esiti di:
                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('torneiSenzaEsito'), 't', false, NULL, 'tsi', array (
  'last' => true,
  'iteration' => true,
  'total' => true,
));
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('t')->value) {
$foreach0DoElse = false;
$_smarty_tpl->tpl_vars['__smarty_foreach_tsi']->value['iteration']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_tsi']->value['last'] = $_smarty_tpl->tpl_vars['__smarty_foreach_tsi']->value['iteration'] === $_smarty_tpl->tpl_vars['__smarty_foreach_tsi']->value['total'];
echo htmlspecialchars((string)$_smarty_tpl->getValue('t')['nome'], ENT_QUOTES, 'UTF-8', true);
if (!($_smarty_tpl->getValue('__smarty_foreach_tsi')['last'] ?? null)) {?>, <?php }
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                    </p>
                <?php }?>

                                <div class="gdet-tornei-list">
                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('tornei'), 'torneo');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('torneo')->value) {
$foreach1DoElse = false;
?>
                        <?php $_smarty_tpl->assign('statoTorneo', mb_strtolower((string) $_smarty_tpl->getValue('torneo')['statoEvento'], 'UTF-8'), false, NULL);?>
                        <?php $_smarty_tpl->assign('podioTorneoEsiste', (true && (true && null !== ($_smarty_tpl->getValue('torneo')['podio'] ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('torneo')['podio']) > 0, false, NULL);?>

                        <div class="gdet-torneo-card">
                            <div class="gdet-torneo-card__header">
                                <img src="<?php echo $_smarty_tpl->getValue('torneo')['imgEvento'];?>
" alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('torneo')['nomeEvento'], ENT_QUOTES, 'UTF-8', true);?>
" class="gdet-torneo-card__img">
                                <div>
                                    <span class="gdet-status gdet-status--<?php echo $_smarty_tpl->getValue('statoTorneo');?>
"><?php echo $_smarty_tpl->getValue('torneo')['statoEvento'];?>
</span>
                                    <h3 class="gdet-torneo-card__name"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('torneo')['nomeEvento'], ENT_QUOTES, 'UTF-8', true);?>
</h3>
                                    <span class="gdet-torneo-card__gioco"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('torneo')['gioco'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                                </div>
                                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/eventi/dettaglio/<?php echo $_smarty_tpl->getValue('torneo')['idEvento'];?>
" class="gdet-link">
                                    <i class="ti ti-eye"></i> Vedi torneo
                                </a>
                            </div>

                            <?php if ($_smarty_tpl->getValue('statoTorneo') == 'terminato') {?>
                                <?php if ($_smarty_tpl->getValue('podioTorneoEsiste')) {?>
                                    <ul class="gdet-podio gdet-podio--compact">
                                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('torneo')['podio'], 'piazzamento');
$foreach2DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('piazzamento')->value) {
$foreach2DoElse = false;
?>
                                            <li class="gdet-podio__item gdet-podio__item--<?php echo $_smarty_tpl->getValue('piazzamento')['posizione'];?>
">
                                                <span class="gdet-podio__medal"><?php echo $_smarty_tpl->getValue('piazzamento')['posizione'];?>
&deg;</span>
                                                <span class="gdet-podio__name"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('piazzamento')['utente']['nome'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                                            </li>
                                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                                    </ul>
                                <?php }?>

                                <input type="checkbox" id="toggle-esito-<?php echo $_smarty_tpl->getValue('torneo')['idEvento'];?>
" class="gdet-toggle-checkbox">
                                <label for="toggle-esito-<?php echo $_smarty_tpl->getValue('torneo')['idEvento'];?>
" class="gdet-btn gdet-btn--primary gdet-btn--small">
                                    <i class="ti ti-medal"></i> <?php if ($_smarty_tpl->getValue('podioTorneoEsiste')) {?>Modifica esito<?php } else { ?>Aggiungi esito<?php }?>
                                </label>

                                <div class="gdet-panel" id="panel-esito-<?php echo $_smarty_tpl->getValue('torneo')['idEvento'];?>
">
                                    <?php if (!(true && (true && null !== ($_smarty_tpl->getValue('torneo')['iscritti'] ?? null))) || $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('torneo')['iscritti']) == 0) {?>
                                        <p class="gdet-warning">
                                            <i class="ti ti-alert-triangle"></i>
                                            Elenco iscritti non disponibile per questo torneo: verificare con Control.
                                        </p>
                                    <?php }?>
                                   <form method="post" action="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/eventi/tornei/esito" class="gdet-form" id="form-esito-<?php echo $_smarty_tpl->getValue('torneo')['idEvento'];?>
">
                                        <input type="hidden" name="id_evento" value="<?php echo $_smarty_tpl->getValue('torneo')['idEvento'];?>
">

                                        <label class="gdet-form__label">1&deg; classificato *</label>
                                        <select name="id_primo" class="gdet-form__input gdet-podio-select" data-group="<?php echo $_smarty_tpl->getValue('torneo')['idEvento'];?>
" required>
                                            <option value="">Seleziona...</option>
                                            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, (($tmp = $_smarty_tpl->getValue('torneo')['iscritti'] ?? null)===null||$tmp==='' ? array() ?? null : $tmp), 'iscritto');
$foreach3DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('iscritto')->value) {
$foreach3DoElse = false;
?>
                                                <option value="<?php echo $_smarty_tpl->getValue('iscritto')['id'];?>
"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('iscritto')['nome'], ENT_QUOTES, 'UTF-8', true);?>
</option>
                                            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                                        </select>

                                        <label class="gdet-form__label">2&deg; classificato</label>
                                        <select name="id_secondo" class="gdet-form__input gdet-podio-select" data-group="<?php echo $_smarty_tpl->getValue('torneo')['idEvento'];?>
">
                                            <option value="">Nessuno</option>
                                            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, (($tmp = $_smarty_tpl->getValue('torneo')['iscritti'] ?? null)===null||$tmp==='' ? array() ?? null : $tmp), 'iscritto');
$foreach4DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('iscritto')->value) {
$foreach4DoElse = false;
?>
                                                <option value="<?php echo $_smarty_tpl->getValue('iscritto')['id'];?>
"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('iscritto')['nome'], ENT_QUOTES, 'UTF-8', true);?>
</option>
                                            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                                        </select>

                                        <label class="gdet-form__label">3&deg; classificato</label>
                                        <select name="id_terzo" class="gdet-form__input gdet-podio-select" data-group="<?php echo $_smarty_tpl->getValue('torneo')['idEvento'];?>
">
                                            <option value="">Nessuno</option>
                                            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, (($tmp = $_smarty_tpl->getValue('torneo')['iscritti'] ?? null)===null||$tmp==='' ? array() ?? null : $tmp), 'iscritto');
$foreach5DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('iscritto')->value) {
$foreach5DoElse = false;
?>
                                                <option value="<?php echo $_smarty_tpl->getValue('iscritto')['id'];?>
"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('iscritto')['nome'], ENT_QUOTES, 'UTF-8', true);?>
</option>
                                            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                                        </select>

                                        <button type="submit" class="gdet-btn gdet-btn--success gdet-btn--small">
                                            <i class="ti ti-device-floppy"></i> Salva esito
                                        </button>
                                    </form>
                                </div>
                            <?php } else { ?>
                                <p class="gdet-info-text">
                                    <i class="ti ti-info-circle"></i> Questo torneo non è ancora concluso.
                                </p>
                            <?php }?>
                        </div>
                    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                </div>

                                <?php $_smarty_tpl->assign('tuttiOk', !(true && ($_smarty_tpl->hasVariable('torneiSenzaEsito') && null !== ($_smarty_tpl->getValue('torneiSenzaEsito') ?? null))) || $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('torneiSenzaEsito')) == 0, false, NULL);?>
                <form method="post"
                      action="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/eventi/challenge/genera-classifica"
                      class="gdet-action-form"
                      <?php if ($_smarty_tpl->getValue('tuttiOk')) {?>onsubmit="return confirm('Sei sicuro? Una volta generata la classifica sarà visibile a tutti gli utenti.');"<?php }?>>
                    <input type="hidden" name="id_challenge" value="<?php echo $_smarty_tpl->getValue('idEvento');?>
">
                    <button type="submit" class="gdet-btn gdet-btn--primary" <?php if (!$_smarty_tpl->getValue('tuttiOk')) {?>disabled<?php }?>>
                        <i class="ti ti-list-numbers"></i> Genera classifica finale
                    </button>
                </form>

            <?php } else { ?>
                                <table class="gdet-classifica">
                    <thead>
                        <tr>
                            <th>Posizione</th>
                            <th>Utente</th>
                            <th>Punteggio totale</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('classificaFinale'), 'riga');
$foreach6DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('riga')->value) {
$foreach6DoElse = false;
?>
                            <tr class="<?php if ($_smarty_tpl->getValue('riga')['posizione'] <= 3) {?>gdet-classifica__row--podio<?php }?>">
                                <td>
                                    <?php if ($_smarty_tpl->getValue('riga')['posizione'] == 1) {?><i class="ti ti-medal"></i><?php } elseif ($_smarty_tpl->getValue('riga')['posizione'] <= 3) {?><i class="ti ti-medal-2"></i><?php }?>
                                    <?php echo $_smarty_tpl->getValue('riga')['posizione'];?>
&deg;
                                </td>
                                <td><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('riga')['utente']['nome'], ENT_QUOTES, 'UTF-8', true);?>
</td>
                                <td><?php echo $_smarty_tpl->getValue('riga')['punteggioTotale'];?>
 punti</td>
                            </tr>
                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                    </tbody>
                </table>
                <p class="gdet-info-text">
                    <i class="ti ti-lock"></i> Classifica definitiva: non è prevista nessuna modifica da interfaccia.
                </p>
            <?php }?>
        </section>
    <?php }?>

</div>

<?php echo '<script'; ?>
>
    // Blocco doppie selezioni nei form podio, raggruppati per torneo (data-group).
    (function() {
        var gruppi = {};
        document.querySelectorAll('.gdet-podio-select').forEach(function(s) {
            var g = s.dataset.group || 'default';
            (gruppi[g] = gruppi[g] || []).push(s);
        });
        Object.values(gruppi).forEach(function(selects) {
            function aggiorna() {
                var scelti = selects.map(function(s) { return s.value; }).filter(function(v) { return v !== ''; });
                selects.forEach(function(select) {
                    Array.prototype.forEach.call(select.options, function(opt) {
                        if (opt.value === '') return;
                        opt.disabled = scelti.indexOf(opt.value) !== -1 && opt.value !== select.value;
                    });
                });
            }
            selects.forEach(function(s) { s.addEventListener('change', aggiorna); });
            aggiorna();
        });
    })();

    // Chiude il popup "Modifica dati" cliccando sul backdrop
    (function() {
        var dialog = document.getElementById('modal-modifica');
        if (dialog) {
            dialog.addEventListener('click', function(e) {
                if (e.target === dialog) dialog.close();
            });
        }
    })();

    <?php if ($_smarty_tpl->getValue('stato') == 'annullato') {?>
    (function() {
        var form = document.getElementById('form-riprogramma-<?php echo $_smarty_tpl->getValue('idEvento');?>
');
        if (!form) return;
        form.addEventListener('submit', function() {
            var input = form.querySelector('[name="nuovaDataInizio"]');
            if (input && input.value) {
                input.value = input.value.replace('T', ' ') + ':00';
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
