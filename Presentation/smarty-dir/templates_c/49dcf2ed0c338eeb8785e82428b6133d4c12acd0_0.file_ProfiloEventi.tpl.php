<?php
/* Smarty version 5.8.0, created on 2026-07-21 00:56:36
  from 'file:ProfiloEventi.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a5ea7a406b817_07170768',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '49dcf2ed0c338eeb8785e82428b6133d4c12acd0' => 
    array (
      0 => 'ProfiloEventi.tpl',
      1 => 1784454028,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a5ea7a406b817_07170768 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_961257466a5ea7a40265a1_42469750', "extra_css");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_19822508886a5ea7a402ab46_87367120', "content");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_13496074816a5ea7a406aa38_14900781', "extra_js");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "extra_css"} */
class Block_961257466a5ea7a40265a1_42469750 extends \Smarty\Runtime\Block
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
class Block_19822508886a5ea7a402ab46_87367120 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<div class="mieeventi-container">
    <div class="container">

                <div class="mieeventi-topbar">
            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/profilo" class="mieeventi-back-link">
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
/profilo/eventi?ordinamento=futuri"
               class="mieeventi-tab <?php if (!(true && ($_smarty_tpl->hasVariable('ordinamento') && null !== ($_smarty_tpl->getValue('ordinamento') ?? null))) || $_smarty_tpl->getValue('ordinamento') == 'futuri') {?>mieeventi-tab-active<?php }?>">
                <i class="ti ti-calendar-due"></i> Futuri
            </a>
            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/profilo/eventi?ordinamento=passati_anno_corrente"
               class="mieeventi-tab <?php if ((true && ($_smarty_tpl->hasVariable('ordinamento') && null !== ($_smarty_tpl->getValue('ordinamento') ?? null))) && $_smarty_tpl->getValue('ordinamento') == 'passati_anno_corrente') {?>mieeventi-tab-active<?php }?>">
                <i class="ti ti-calendar-check"></i> Passati quest'anno
            </a>
            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/profilo/eventi?ordinamento=ultimi_5_anni"
               class="mieeventi-tab <?php if ((true && ($_smarty_tpl->hasVariable('ordinamento') && null !== ($_smarty_tpl->getValue('ordinamento') ?? null))) && $_smarty_tpl->getValue('ordinamento') == 'ultimi_5_anni') {?>mieeventi-tab-active<?php }?>">
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
/<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('evento')['tipoEvento'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
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

                            <?php if ((true && (true && null !== ($_smarty_tpl->getValue('evento')['tipoEvento'] ?? null)))) {?>
                                <span class="mieeventi-tipo-badge mieeventi-tipo-<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['tipoEvento'], ENT_QUOTES, 'UTF-8', true);?>
">
                                    <?php if ($_smarty_tpl->getValue('evento')['tipoEvento'] == 'serata') {?><i class="ti ti-moon-stars"></i> Serata
                                    <?php } elseif ($_smarty_tpl->getValue('evento')['tipoEvento'] == 'torneo') {?><i class="ti ti-trophy"></i> Torneo
                                    <?php } elseif ($_smarty_tpl->getValue('evento')['tipoEvento'] == 'challenge') {?><i class="ti ti-swords"></i> Challenge
                                    <?php } else {
echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['tipoEvento'], ENT_QUOTES, 'UTF-8', true);?>

                                    <?php }?>
                                </span>
                            <?php }?>
                        </a>

                        <div class="mieeventi-card-body">

                            <div class="mieeventi-card-top">
                                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('evento')['tipoEvento'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
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

                                                                <?php if ((true && (true && null !== ($_smarty_tpl->getValue('evento')['dataiscrizione'] ?? null)))) {?>
                                    <div class="mieeventi-info-row">
                                        <i class="ti ti-user-check"></i>
                                        <span class="mieeventi-info-label">Iscritto il:</span>
                                        <span class="mieeventi-info-value"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['dataiscrizione'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                                    </div>
                                <?php }?>

                                                                <?php if ((true && (true && null !== ($_smarty_tpl->getValue('evento')['tipoEvento'] ?? null))) && $_smarty_tpl->getValue('evento')['tipoEvento'] == 'serata') {?>
                                    <?php if ((true && (true && null !== ($_smarty_tpl->getValue('evento')['tipoSerata'] ?? null)))) {?>
                                        <div class="mieeventi-info-row">
                                            <i class="ti ti-category"></i>
                                            <span class="mieeventi-info-label">Tipologia:</span>
                                            <span class="mieeventi-info-value"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['tipoSerata'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                                        </div>
                                    <?php }?>

                                <?php } elseif ((true && (true && null !== ($_smarty_tpl->getValue('evento')['tipoEvento'] ?? null))) && $_smarty_tpl->getValue('evento')['tipoEvento'] == 'torneo') {?>
                                    <?php if ((true && (true && null !== ($_smarty_tpl->getValue('evento')['gioco'] ?? null)))) {?>
                                        <div class="mieeventi-info-row">
                                            <i class="ti ti-dice"></i>
                                            <span class="mieeventi-info-label">Gioco:</span>
                                            <span class="mieeventi-info-value"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['gioco'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                                        </div>
                                    <?php }?>
                                    <?php if ((true && (true && null !== ($_smarty_tpl->getValue('evento')['premio'] ?? null)))) {?>
                                        <div class="mieeventi-info-row">
                                            <i class="ti ti-award"></i>
                                            <span class="mieeventi-info-label">Premio:</span>
                                            <span class="mieeventi-info-value"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['premio'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                                        </div>
                                    <?php }?>
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

                                <?php } elseif ((true && (true && null !== ($_smarty_tpl->getValue('evento')['tipoEvento'] ?? null))) && $_smarty_tpl->getValue('evento')['tipoEvento'] == 'challenge') {?>
                                    <?php if ((true && (true && null !== ($_smarty_tpl->getValue('evento')['premio'] ?? null)))) {?>
                                        <div class="mieeventi-info-row">
                                            <i class="ti ti-award"></i>
                                            <span class="mieeventi-info-label">Premio:</span>
                                            <span class="mieeventi-info-value"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['premio'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                                        </div>
                                    <?php }?>
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

                                <?php if ((true && (true && null !== ($_smarty_tpl->getValue('evento')['quotaPagata'] ?? null))) && $_smarty_tpl->getValue('evento')['quotaPagata']) {?>
                                    <div class="mieeventi-info-row mieeventi-quota-pagata">
                                        <i class="ti ti-circle-check"></i>
                                        <span class="mieeventi-info-value">Quota pagata</span>
                                    </div>
                                <?php }?>

                                                                <?php if ((true && (true && null !== ($_smarty_tpl->getValue('evento')['posizioneClassifica'] ?? null))) && $_smarty_tpl->getValue('evento')['posizioneClassifica'] !== null) {?>
                                    <div class="mieeventi-info-row mieeventi-classifica-row">
                                        <i class="ti ti-medal"></i>
                                        <span class="mieeventi-info-label">Classifica:</span>
                                        <span class="mieeventi-info-value"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['posizioneClassifica'], ENT_QUOTES, 'UTF-8', true);?>
&deg; posto</span>
                                    </div>
                                <?php }?>

                            </div>

                                                        <div class="mieeventi-actions">
                                <?php if ((true && (true && null !== ($_smarty_tpl->getValue('evento')['tipoEvento'] ?? null))) && $_smarty_tpl->getValue('evento')['tipoEvento'] == 'serata') {?>

                                    <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['tipoEvento'], ENT_QUOTES, 'UTF-8', true);?>
/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['idEvento'], ENT_QUOTES, 'UTF-8', true);?>
" class="mieeventi-btn-secondary">
                                        <i class="ti ti-info-circle"></i> Maggiori info
                                    </a>

                                    <?php if ($_smarty_tpl->getValue('evento')['statoEvento'] == 'in programma') {?>
                                        <button type="button" class="mieeventi-btn-disdici" data-id="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['idEvento'], ENT_QUOTES, 'UTF-8', true);?>
">
                                            <i class="ti ti-x"></i> Disdici partecipazione
                                        </button>
                                    <?php }?>

                                <?php } elseif ((true && (true && null !== ($_smarty_tpl->getValue('evento')['tipoEvento'] ?? null)))) {?>
                                    <?php if ($_smarty_tpl->getValue('evento')['statoEvento'] == 'in programma') {?>
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
class Block_13496074816a5ea7a406aa38_14900781 extends \Smarty\Runtime\Block
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

    if (disdiciConferma) {
        disdiciConferma.addEventListener('click', function() {
            if (!idDaDisdire) return;

            var id = idDaDisdire;

            fetch('<?php echo $_smarty_tpl->getValue('base_url');?>
/profilo/eventi/disdici', {
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
