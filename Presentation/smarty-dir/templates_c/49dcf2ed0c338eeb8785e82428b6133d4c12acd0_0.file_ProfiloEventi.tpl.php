<?php
/* Smarty version 5.8.0, created on 2026-07-12 19:45:19
  from 'file:ProfiloEventi.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a53d2af1a0d95_62798679',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '49dcf2ed0c338eeb8785e82428b6133d4c12acd0' => 
    array (
      0 => 'ProfiloEventi.tpl',
      1 => 1783878281,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a53d2af1a0d95_62798679 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_1152465626a53d2af170de5_41643243', "extra_css");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_174398046a53d2af174d23_84958638', "content");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_9510758226a53d2af1a0581_10512723', "extra_js");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "extra_css"} */
class Block_1152465626a53d2af170de5_41643243 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

    <link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/css/ProfiloEventi.css">
<?php
}
}
/* {/block "extra_css"} */
/* {block "content"} */
class Block_174398046a53d2af174d23_84958638 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<div class="mieeventi-container">
    <div class="container">

                <div class="mieeventi-topbar">
            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/account" class="mieeventi-back-link">
                <i class="ti ti-arrow-left"></i> Torna all'Area Personale
            </a>
        </div>

                <div class="mieeventi-header">
            <div class="mieeventi-header-text">
                <span class="mieeventi-eyebrow">Area Personale</span>
                <h1 class="mieeventi-titolo">
                    <i class="ti ti-calendar-event"></i> I Miei Eventi
                </h1>
            </div>

            <?php if ((true && ($_smarty_tpl->hasVariable('eventi') && null !== ($_smarty_tpl->getValue('eventi') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('eventi')) > 0) {?>
                <div class="mieeventi-count-badge">
                    <span class="mieeventi-count-num"><?php echo $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('eventi'));?>
</span>
                    <span class="mieeventi-count-label"><?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('eventi')) == 1) {?>evento<?php } else { ?>eventi<?php }?></span>
                </div>
            <?php }?>
        </div>

                <div class="mieeventi-tabs">
            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/account/eventi?ordinamento=futuri"
               class="mieeventi-tab <?php if (!(true && ($_smarty_tpl->hasVariable('ordinamento_eventi') && null !== ($_smarty_tpl->getValue('ordinamento_eventi') ?? null))) || $_smarty_tpl->getValue('ordinamento_eventi') == 'futuri') {?>mieeventi-tab-active<?php }?>">
                <i class="ti ti-calendar-due"></i> Futuri
            </a>
            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/account/eventi?ordinamento=passati_anno_corrente"
               class="mieeventi-tab <?php if ((true && ($_smarty_tpl->hasVariable('ordinamento_eventi') && null !== ($_smarty_tpl->getValue('ordinamento_eventi') ?? null))) && $_smarty_tpl->getValue('ordinamento_eventi') == 'passati_anno_corrente') {?>mieeventi-tab-active<?php }?>">
                <i class="ti ti-calendar-check"></i> Passati quest'anno
            </a>
            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/account/eventi?ordinamento=ultimi_5_anni"
               class="mieeventi-tab <?php if ((true && ($_smarty_tpl->hasVariable('ordinamento_eventi') && null !== ($_smarty_tpl->getValue('ordinamento_eventi') ?? null))) && $_smarty_tpl->getValue('ordinamento_eventi') == 'ultimi_5_anni') {?>mieeventi-tab-active<?php }?>">
                <i class="ti ti-history"></i> Ultimi 5 anni
            </a>
        </div>

                <?php if ((true && ($_smarty_tpl->hasVariable('eventi') && null !== ($_smarty_tpl->getValue('eventi') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('eventi')) > 0) {?>
            <div class="mieeventi-list" id="mieeventi-list">
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('eventi'), 'evento');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('evento')->value) {
$foreach0DoElse = false;
?>
                    <div class="mieeventi-card" id="mieeventi-card-<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['idEvento'], ENT_QUOTES, 'UTF-8', true);?>
">

                        <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['tipoEvento'], ENT_QUOTES, 'UTF-8', true);?>
/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['idEvento'], ENT_QUOTES, 'UTF-8', true);?>
" class="mieeventi-card-media">
                            <div class="mieeventi-card-img-placeholder">
                                <i class="ti ti-photo"></i>
                            </div>
                            <?php if ((true && (true && null !== ($_smarty_tpl->getValue('evento')['imgEvento'] ?? null))) && $_smarty_tpl->getValue('evento')['imgEvento']) {?>
                                <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/eventi/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['imgEvento'], ENT_QUOTES, 'UTF-8', true);?>
"
                                     onerror="this.onerror=null; this.style.display='none';"
                                     alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['nomeEvento'], ENT_QUOTES, 'UTF-8', true);?>
"
                                     class="mieeventi-card-img">
                            <?php }?>

                            <span class="mieeventi-tipo-badge mieeventi-tipo-<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['tipoEvento'], ENT_QUOTES, 'UTF-8', true);?>
">
                                <?php if ($_smarty_tpl->getValue('evento')['tipoEvento'] == 'serata') {?><i class="ti ti-moon-stars"></i> Serata
                                <?php } elseif ($_smarty_tpl->getValue('evento')['tipoEvento'] == 'torneo') {?><i class="ti ti-trophy"></i> Torneo
                                <?php } elseif ($_smarty_tpl->getValue('evento')['tipoEvento'] == 'challenge') {?><i class="ti ti-swords"></i> Challenge
                                <?php } else {
echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['tipoEvento'], ENT_QUOTES, 'UTF-8', true);?>

                                <?php }?>
                            </span>
                        </a>

                        <div class="mieeventi-card-body">

                            <div class="mieeventi-card-top">
                                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['tipoEvento'], ENT_QUOTES, 'UTF-8', true);?>
/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['idEvento'], ENT_QUOTES, 'UTF-8', true);?>
" class="mieeventi-nome">
                                    <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['nomeEvento'], ENT_QUOTES, 'UTF-8', true);?>

                                </a>
                            </div>

                                                        <div class="mieeventi-info-list">

                                                                <div class="mieeventi-info-row <?php if ($_smarty_tpl->getValue('evento')['statoEvento'] == 'in programma') {?>mieeventi-stato-riga-in-programma<?php } else { ?>mieeventi-stato-riga-concluso<?php }?>">
                                    <i class="ti ti-flag"></i>
                                    <span class="mieeventi-info-label">Stato:</span>
                                    <span class="mieeventi-info-value"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['statoEvento'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                                </div>

                                                                <div class="mieeventi-info-row">
                                    <i class="ti ti-calendar"></i>
                                    <span class="mieeventi-info-label">Data:</span>
                                    <span class="mieeventi-info-value"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['dataInizio'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                                </div>

                                <div class="mieeventi-info-row">
                                    <i class="ti ti-users"></i>
                                    <span class="mieeventi-info-label">Partecipanti:</span>
                                    <span class="mieeventi-info-value"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['numeroPartecipanti'], ENT_QUOTES, 'UTF-8', true);?>
/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['maxPartecipanti'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                                </div>

                                <div class="mieeventi-info-row">
                                    <i class="ti ti-user-check"></i>
                                    <span class="mieeventi-info-label">Iscritto il:</span>
                                    <span class="mieeventi-info-value"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['dataIscrizione'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                                </div>

                                                                <?php if ($_smarty_tpl->getValue('evento')['tipoEvento'] == 'serata') {?>
                                    <div class="mieeventi-info-row">
                                        <i class="ti ti-category"></i>
                                        <span class="mieeventi-info-label">Tipologia:</span>
                                        <span class="mieeventi-info-value"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['tipoSerata'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                                    </div>

                                <?php } elseif ($_smarty_tpl->getValue('evento')['tipoEvento'] == 'torneo') {?>
                                    <div class="mieeventi-info-row">
                                        <i class="ti ti-dice"></i>
                                        <span class="mieeventi-info-label">Gioco:</span>
                                        <span class="mieeventi-info-value"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['gioco'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                                    </div>
                                    <div class="mieeventi-info-row">
                                        <i class="ti ti-award"></i>
                                        <span class="mieeventi-info-label">Premio:</span>
                                        <span class="mieeventi-info-value"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['premio'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                                    </div>
                                    <?php if ((true && (true && null !== ($_smarty_tpl->getValue('evento')['challenge'] ?? null)))) {?>
                                        <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/challenge/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['challenge']['idEvento'], ENT_QUOTES, 'UTF-8', true);?>
" class="mieeventi-info-row mieeventi-info-row-link">
                                            <i class="ti ti-swords"></i>
                                            <span class="mieeventi-info-label">Fa parte di:</span>
                                            <span class="mieeventi-info-value"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['challenge']['nomeEvento'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                                        </a>
                                    <?php }?>

                                <?php } elseif ($_smarty_tpl->getValue('evento')['tipoEvento'] == 'challenge') {?>
                                    <div class="mieeventi-info-row">
                                        <i class="ti ti-award"></i>
                                        <span class="mieeventi-info-label">Premio:</span>
                                        <span class="mieeventi-info-value"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['premio'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                                    </div>
                                    <?php if ((true && (true && null !== ($_smarty_tpl->getValue('evento')['tornei'] ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('evento')['tornei']) > 0) {?>
                                        <div class="mieeventi-info-row">
                                            <i class="ti ti-trophy"></i>
                                            <span class="mieeventi-info-label">Tornei inclusi:</span>
                                        </div>
                                        <div class="mieeventi-sotto-tornei">
                                            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('evento')['tornei'], 'torneo');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('torneo')->value) {
$foreach1DoElse = false;
?>
                                                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/torneo/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('torneo')['idEvento'], ENT_QUOTES, 'UTF-8', true);?>
" class="mieeventi-sotto-torneo-link">
                                                    <i class="ti ti-corner-down-right"></i> <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('torneo')['nomeEvento'], ENT_QUOTES, 'UTF-8', true);?>

                                                </a>
                                            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                                        </div>
                                    <?php }?>
                                <?php }?>

                                                                <?php if ((true && (true && null !== ($_smarty_tpl->getValue('evento')['quotaIscrizione'] ?? null)))) {?>
                                    <div class="mieeventi-info-row">
                                        <i class="ti ti-coin"></i>
                                        <span class="mieeventi-info-label">Quota:</span>
                                        <span class="mieeventi-info-value">€ <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['quotaIscrizione'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                                    </div>
                                <?php }?>

                                <?php if ($_smarty_tpl->getValue('evento')['quotaPagata']) {?>
                                    <div class="mieeventi-info-row mieeventi-quota-pagata">
                                        <i class="ti ti-circle-check"></i>
                                        <span class="mieeventi-info-value">Quota pagata</span>
                                    </div>
                                <?php }?>

                                <?php if ($_smarty_tpl->getValue('evento')['posizioneInClassifica'] !== null) {?>
                                    <div class="mieeventi-info-row mieeventi-classifica-row">
                                        <i class="ti ti-medal"></i>
                                        <span class="mieeventi-info-label">Classifica:</span>
                                        <span class="mieeventi-info-value"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['posizioneInClassifica'], ENT_QUOTES, 'UTF-8', true);?>
&deg; posto</span>
                                    </div>
                                <?php }?>

                            </div>

                                                        <div class="mieeventi-actions">
                                <?php if ($_smarty_tpl->getValue('evento')['tipoEvento'] == 'serata') {?>
                                    <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['tipoEvento'], ENT_QUOTES, 'UTF-8', true);?>
/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['idEvento'], ENT_QUOTES, 'UTF-8', true);?>
" class="mieeventi-btn-secondary">
                                        <i class="ti ti-info-circle"></i> Maggiori info
                                    </a>
                                <?php } else { ?>
                                    <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['tipoEvento'], ENT_QUOTES, 'UTF-8', true);?>
/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['idEvento'], ENT_QUOTES, 'UTF-8', true);?>
#classifica" class="mieeventi-btn-secondary">
                                        <i class="ti ti-trophy"></i> Esito
                                    </a>
                                <?php }?>

                                <?php if ($_smarty_tpl->getValue('evento')['statoEvento'] == 'in programma' && $_smarty_tpl->getValue('evento')['isDisdicibile']) {?>
                                    <button type="button" class="mieeventi-btn-disdici" data-id="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['idEvento'], ENT_QUOTES, 'UTF-8', true);?>
">
                                        <i class="ti ti-x"></i> Disdici partecipazione
                                    </button>
                                <?php }?>
                            </div>

                        </div>
                    </div>
                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
            </div>
        <?php } else { ?>
                        <div class="mieeventi-empty" id="mieeventi-empty">
                <div class="mieeventi-empty-icon">
                    <i class="ti ti-calendar-event"></i>
                </div>
                <h2 class="mieeventi-empty-titolo">Nessun evento in questa sezione</h2>
                <p class="mieeventi-empty-testo">Le serate, i tornei e le challenge a cui ti iscriverai compariranno qui.</p>
                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/eventi" class="mieeventi-empty-btn">
                    <i class="ti ti-calendar-plus"></i> Scopri gli eventi
                </a>
            </div>
        <?php }?>

                <div class="mieeventi-popup-overlay" id="mieeventi-disdici-popup" hidden>
            <div class="mieeventi-popup-box">
                <i class="ti ti-alert-triangle mieeventi-popup-icon"></i>
                <p class="mieeventi-popup-message">Sei sicuro di voler disdire la partecipazione a questo evento?</p>

                <div class="mieeventi-popup-actions">
                    <button type="button" class="mieeventi-btn-secondary" id="mieeventi-disdici-indietro">Indietro</button>
                    <button type="button" class="mieeventi-btn-primary" id="mieeventi-disdici-conferma">Conferma</button>
                </div>
            </div>
        </div>

                <div class="mieeventi-popup-overlay" id="mieeventi-popup" hidden>
            <div class="mieeventi-popup-box">
                <i class="ti ti-alert-triangle mieeventi-popup-icon"></i>
                <p class="mieeventi-popup-message" id="mieeventi-popup-message"></p>
                <button type="button" class="mieeventi-btn-primary" id="mieeventi-popup-close">Chiudi</button>
            </div>
        </div>

    </div>
</div>
<?php
}
}
/* {/block "content"} */
/* {block "extra_js"} */
class Block_9510758226a53d2af1a0581_10512723 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<?php echo '<script'; ?>
>

(function() {

    var popup        = document.getElementById('mieeventi-popup');
    var popupMessage = document.getElementById('mieeventi-popup-message');
    var popupClose    = document.getElementById('mieeventi-popup-close');

    var disdiciPopup     = document.getElementById('mieeventi-disdici-popup');
    var disdiciIndietro  = document.getElementById('mieeventi-disdici-indietro');
    var disdiciConferma  = document.getElementById('mieeventi-disdici-conferma');
    var idDaDisdire       = null;

    function mostraPopup(messaggio) {
        popupMessage.textContent = messaggio;
        popup.removeAttribute('hidden');
    }

    if (popupClose) {
        popupClose.addEventListener('click', function() {
            popup.setAttribute('hidden', '');
        });
    }

    // ── APERTURA POPUP CONFERMA DISDETTA ──
    var list = document.getElementById('mieeventi-list');
    if (list) {
        list.addEventListener('click', function(e) {
            var disdiciBtn = e.target.closest('.mieeventi-btn-disdici');
            if (disdiciBtn) {
                idDaDisdire = disdiciBtn.getAttribute('data-id');
                disdiciPopup.removeAttribute('hidden');
            }
        });
    }

    if (disdiciIndietro) {
        disdiciIndietro.addEventListener('click', function() {
            idDaDisdire = null;
            disdiciPopup.setAttribute('hidden', '');
        });
    }

    // ── CONFERMA DISDETTA (AJAX) ──
    if (disdiciConferma) {
        disdiciConferma.addEventListener('click', function() {
            if (!idDaDisdire) return;

            var id = idDaDisdire;

            fetch('<?php echo $_smarty_tpl->getValue('base_url');?>
/account/eventi/disdici', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                credentials: 'same-origin',
                body: JSON.stringify({ id: id })
            })
            .then(function(response) { return response.json(); })
            .then(function(data) {
                disdiciPopup.setAttribute('hidden', '');
                idDaDisdire = null;

                if (data.status === 'ok') {
                    window.location.reload();
                } else if (data.reason === 'non_disdicibile') {
                    mostraPopup('Non è più possibile disdire questa partecipazione.');
                } else {
                    mostraPopup('Non è stato possibile disdire la partecipazione, riprova più tardi.');
                }
            })
            .catch(function() {
                disdiciPopup.setAttribute('hidden', '');
                idDaDisdire = null;
                mostraPopup('Si è verificato un errore di connessione, riprova più tardi.');
            });
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
