<?php
/* Smarty version 5.8.0, created on 2026-07-21 00:14:08
  from 'file:MieRecensioni.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a5e9db04f8ac6_23578192',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c6fc8ff9800664d95d420af65159a9c89fd542da' => 
    array (
      0 => 'MieRecensioni.tpl',
      1 => 1784454026,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a5e9db04f8ac6_23578192 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_6453474096a5e9db03b4161_93244799', "extra_css");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_7369901536a5e9db03ba016_98161391', "content");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_16025173616a5e9db04f77c1_82900775', "extra_js");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "extra_css"} */
class Block_6453474096a5e9db03b4161_93244799 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

    <link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/css/MieRecensioni.css">
<?php
}
}
/* {/block "extra_css"} */
/* {block "content"} */
class Block_7369901536a5e9db03ba016_98161391 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<div class="mierecensioni-container">
    <div class="container">

                <div class="mierecensioni-topbar">
            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/profilo" class="mierecensioni-back-link">
                <i class="ti ti-arrow-left"></i> Torna all'Area Personale
            </a>
        </div>

                <div class="mierecensioni-header">
            <div class="mierecensioni-header-text">
                <span class="mierecensioni-eyebrow">Area Personale</span>
                <h1 class="mierecensioni-titolo">
                    <i class="ti ti-star-filled"></i> Le Mie Recensioni
                </h1>
            </div>

            <?php if ((true && ($_smarty_tpl->hasVariable('recensioni') && null !== ($_smarty_tpl->getValue('recensioni') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('recensioni')) > 0) {?>
                <div class="mierecensioni-count-badge">
                    <span class="mierecensioni-count-num"><?php echo $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('recensioni'));?>
</span>
                    <span class="mierecensioni-count-label"><?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('recensioni')) == 1) {?>recensione<?php } else { ?>recensioni<?php }?></span>
                </div>
            <?php }?>
        </div>

                <?php if ((true && ($_smarty_tpl->hasVariable('recensioni') && null !== ($_smarty_tpl->getValue('recensioni') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('recensioni')) > 0) {?>
            <div class="mierecensioni-list" id="mierecensioni-list">
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('recensioni'), 'recensione');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('recensione')->value) {
$foreach0DoElse = false;
?>
                    <div class="mierecensioni-card <?php if ((true && (true && null !== ($_smarty_tpl->getValue('recensione')['isSegnalata'] ?? null))) && $_smarty_tpl->getValue('recensione')['isSegnalata']) {?>mierecensioni-card-segnalata<?php }?>" id="mierecensioni-card-<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('recensione')['id'], ENT_QUOTES, 'UTF-8', true);?>
">

                        <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/prodotto/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('recensione')['prodotto']['id'], ENT_QUOTES, 'UTF-8', true);?>
" class="mierecensioni-card-media">
                            <?php if ((true && (true && null !== ($_smarty_tpl->getValue('recensione')['prodotto']['immagine'] ?? null))) && $_smarty_tpl->getValue('recensione')['prodotto']['immagine']) {?>
                                <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/prodotti/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('recensione')['prodotto']['immagine'], ENT_QUOTES, 'UTF-8', true);?>
"
                                     onerror="this.onerror=null; this.src='<?php echo $_smarty_tpl->getValue('base_url');?>
/img/prodotto-default.png'"
                                     alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('recensione')['prodotto']['nome'], ENT_QUOTES, 'UTF-8', true);?>
"
                                     class="mierecensioni-card-img">
                            <?php } else { ?>
                                <div class="mierecensioni-card-img-placeholder">
                                    <i class="ti ti-photo"></i>
                                </div>
                            <?php }?>
                        </a>

                        <div class="mierecensioni-card-body">
                            <div class="mierecensioni-card-top">
                                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/prodotto/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('recensione')['prodotto']['id'], ENT_QUOTES, 'UTF-8', true);?>
" class="mierecensioni-card-nome">
                                    <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('recensione')['prodotto']['nome'], ENT_QUOTES, 'UTF-8', true);?>

                                </a>

                                <div class="mierecensioni-card-meta">
                                    <span class="mierecensioni-card-stelle" aria-label="Valutazione <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('recensione')['valutazione'], ENT_QUOTES, 'UTF-8', true);?>
 su 5">
                                        <?php
$_smarty_tpl->assign('i', null);$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int) ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? 5+1 - (1) : 1-(5)+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0) {
for ($_smarty_tpl->tpl_vars['i']->value = 1, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++) {
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration === 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration === $_smarty_tpl->tpl_vars['i']->total;?>
                                            <?php if ($_smarty_tpl->getValue('i') <= $_smarty_tpl->getValue('recensione')['valutazione']) {?>
                                                <i class="ti ti-star-filled"></i>
                                            <?php } else { ?>
                                                <i class="ti ti-star"></i>
                                            <?php }?>
                                        <?php }
}
?>
                                    </span>
                                    <span class="mierecensioni-card-sep">&middot;</span>
                                    <span class="mierecensioni-card-data"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('recensione')['data'], ENT_QUOTES, 'UTF-8', true);?>
</span>

                                    <?php if ((true && (true && null !== ($_smarty_tpl->getValue('recensione')['isSegnalata'] ?? null))) && $_smarty_tpl->getValue('recensione')['isSegnalata']) {?>
                                        <span class="mierecensioni-badge-segnalata">
                                            <i class="ti ti-flag-filled"></i> Segnalata
                                        </span>
                                    <?php }?>
                                </div>
                            </div>

                            <p class="mierecensioni-card-testo"><?php echo nl2br((string) htmlspecialchars((string)$_smarty_tpl->getValue('recensione')['testo'], ENT_QUOTES, 'UTF-8', true), (bool) 1);?>
</p>
                        </div>

                        <button type="button"
                                class="mierecensioni-btn-elimina"
                                data-id="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('recensione')['id'], ENT_QUOTES, 'UTF-8', true);?>
">
                            <i class="ti ti-trash"></i> Elimina
                        </button>

                    </div>
                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
            </div>
        <?php } else { ?>
                        <div class="mierecensioni-empty" id="mierecensioni-empty">
                <div class="mierecensioni-empty-icon">
                    <i class="ti ti-star"></i>
                </div>
                <h2 class="mierecensioni-empty-titolo">Non hai ancora scritto recensioni</h2>
                <p class="mierecensioni-empty-testo">Le recensioni che lasci sui prodotti acquistati compariranno qui.</p>
                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/profilo/ordini" class="mierecensioni-empty-btn">
                    <i class="ti ti-package"></i> Vai ai tuoi ordini
                </a>
            </div>
        <?php }?>

                <div class="mierecensioni-popup-overlay" id="mierecensioni-elimina-popup" hidden>
            <div class="mierecensioni-popup-box">
                <i class="ti ti-alert-triangle mierecensioni-popup-icon"></i>
                <p class="mierecensioni-popup-message">Sei sicuro di voler eliminare questa recensione?</p>

                <div class="mierecensioni-popup-actions">
                    <button type="button" class="mierecensioni-btn-secondary" id="mierecensioni-elimina-annulla">Annulla</button>
                    <button type="button" class="mierecensioni-btn-primary" id="mierecensioni-elimina-conferma">Conferma</button>
                </div>
            </div>
        </div>

                <div class="mierecensioni-popup-overlay" id="mierecensioni-popup" hidden>
            <div class="mierecensioni-popup-box">
                <i class="ti ti-alert-triangle mierecensioni-popup-icon"></i>
                <p class="mierecensioni-popup-message" id="mierecensioni-popup-message"></p>
                <button type="button" class="mierecensioni-btn-primary" id="mierecensioni-popup-close">Chiudi</button>
            </div>
        </div>

    </div>
</div>
<?php
}
}
/* {/block "content"} */
/* {block "extra_js"} */
class Block_16025173616a5e9db04f77c1_82900775 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<?php echo '<script'; ?>
>

(function() {

    var list  = document.getElementById('mierecensioni-list');
    var empty = document.getElementById('mierecensioni-empty');

    var popup        = document.getElementById('mierecensioni-popup');
    var popupMessage = document.getElementById('mierecensioni-popup-message');
    var popupClose    = document.getElementById('mierecensioni-popup-close');

    var eliminaPopup       = document.getElementById('mierecensioni-elimina-popup');
    var eliminaAnnullaBtn  = document.getElementById('mierecensioni-elimina-annulla');
    var eliminaConfermaBtn = document.getElementById('mierecensioni-elimina-conferma');
    var idDaEliminare       = null;

    function mostraPopup(messaggio) {
        popupMessage.textContent = messaggio;
        popup.removeAttribute('hidden');
    }

    if (popupClose) {
        popupClose.addEventListener('click', function() {
            popup.setAttribute('hidden', '');
        });
    }

    function mostraStatoVuotoSeNecessario() {
        if (list && list.children.length === 0) {
            list.setAttribute('hidden', '');
            if (empty) {
                empty.removeAttribute('hidden');
            } else {
                window.location.reload();
            }
        }
    }

    // ── APERTURA POPUP CONFERMA ──
    if (list) {
        list.addEventListener('click', function(e) {
            var btn = e.target.closest('.mierecensioni-btn-elimina');
            if (!btn) return;

            idDaEliminare = btn.getAttribute('data-id');
            eliminaPopup.removeAttribute('hidden');
        });
    }

    if (eliminaAnnullaBtn) {
        eliminaAnnullaBtn.addEventListener('click', function() {
            idDaEliminare = null;
            eliminaPopup.setAttribute('hidden', '');
        });
    }

    // ── CONFERMA ELIMINAZIONE (AJAX) ──
    if (eliminaConfermaBtn) {
        eliminaConfermaBtn.addEventListener('click', function() {
            if (!idDaEliminare) return;

            var id = idDaEliminare;
            var card = document.getElementById('mierecensioni-card-' + id);

            fetch('<?php echo $_smarty_tpl->getValue('base_url');?>
/recensioni/elimina', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                credentials: 'same-origin',
                body: JSON.stringify({ id_recensione: id })
            })
            .then(function(response) { return response.json(); })
            .then(function(data) {
                eliminaPopup.setAttribute('hidden', '');
                idDaEliminare = null;

                if (data.status === 'ok') {
                    if (card) {
                        card.classList.add('mierecensioni-card-uscita');
                        card.addEventListener('transitionend', function() {
                            card.remove();
                            mostraStatoVuotoSeNecessario();
                        }, { once: true });
                    }
                } else {
                    mostraPopup(data.message || 'Non è stato possibile eliminare la recensione, riprova più tardi.');
                }
            })
            .catch(function() {
                eliminaPopup.setAttribute('hidden', '');
                idDaEliminare = null;
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
