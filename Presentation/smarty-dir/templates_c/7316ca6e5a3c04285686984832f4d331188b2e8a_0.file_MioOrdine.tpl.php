<?php
/* Smarty version 5.8.0, created on 2026-07-12 17:57:55
  from 'file:MioOrdine.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a53b983b204c6_48039030',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7316ca6e5a3c04285686984832f4d331188b2e8a' => 
    array (
      0 => 'MioOrdine.tpl',
      1 => 1783871760,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a53b983b204c6_48039030 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_215344246a53b983b040d0_03520656', "extra_css");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_18888870656a53b983b06f96_87970999', "content");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_8666031506a53b983b1fcb8_47949268', "extra_js");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "extra_css"} */
class Block_215344246a53b983b040d0_03520656 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

    <link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/css/MioOrdine.css">
<?php
}
}
/* {/block "extra_css"} */
/* {block "content"} */
class Block_18888870656a53b983b06f96_87970999 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<div class="mieordini-container">
    <div class="container">

                <div class="mieordini-topbar">
            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/account" class="mieordini-back-link">
                <i class="ti ti-arrow-left"></i> Torna all'Area Personale
            </a>
        </div>

                <div class="mieordini-header">
            <div class="mieordini-header-text">
                <span class="mieordini-eyebrow">Area Personale</span>
                <h1 class="mieordini-titolo">
                    <i class="ti ti-package"></i> I Miei Ordini
                </h1>
            </div>

            <?php if ((true && ($_smarty_tpl->hasVariable('ordini') && null !== ($_smarty_tpl->getValue('ordini') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('ordini')) > 0) {?>
                <div class="mieordini-count-badge">
                    <span class="mieordini-count-num"><?php echo $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('ordini'));?>
</span>
                    <span class="mieordini-count-label"><?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('ordini')) == 1) {?>ordine<?php } else { ?>ordini<?php }?></span>
                </div>
            <?php }?>
        </div>

                <?php if ((true && ($_smarty_tpl->hasVariable('ordini') && null !== ($_smarty_tpl->getValue('ordini') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('ordini')) > 0) {?>
            <div class="mieordini-list" id="mieordini-list">
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('ordini'), 'ordine');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('ordine')->value) {
$foreach0DoElse = false;
?>
                    <div class="mieordini-card" id="mieordini-card-<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('ordine')['id'], ENT_QUOTES, 'UTF-8', true);?>
">

                                                <button type="button" class="mieordini-card-header" data-target="mieordini-body-<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('ordine')['id'], ENT_QUOTES, 'UTF-8', true);?>
" aria-expanded="false">
                            <div class="mieordini-card-header-left">
                                <span class="mieordini-ordine-id">Ordine #<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('ordine')['id'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                                <span class="mieordini-ordine-data"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('ordine')['data'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                            </div>

                            <div class="mieordini-card-header-right">
                                <span class="mieordini-stato-badge mieordini-stato-<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('ordine')['stato'], ENT_QUOTES, 'UTF-8', true);?>
">
                                    <?php if ($_smarty_tpl->getValue('ordine')['stato'] == 'in_lavorazione') {?><i class="ti ti-clock"></i> In lavorazione
                                    <?php } elseif ($_smarty_tpl->getValue('ordine')['stato'] == 'spedito') {?><i class="ti ti-truck-delivery"></i> Spedito
                                    <?php } elseif ($_smarty_tpl->getValue('ordine')['stato'] == 'consegnato') {?><i class="ti ti-circle-check"></i> Consegnato
                                    <?php } elseif ($_smarty_tpl->getValue('ordine')['stato'] == 'annullato') {?><i class="ti ti-circle-x"></i> Annullato
                                    <?php } else {
echo htmlspecialchars((string)$_smarty_tpl->getValue('ordine')['stato'], ENT_QUOTES, 'UTF-8', true);?>

                                    <?php }?>
                                </span>

                                <span class="mieordini-ordine-totale">€ <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('ordine')['totale'], ENT_QUOTES, 'UTF-8', true);?>
</span>

                                <i class="ti ti-chevron-down mieordini-chevron"></i>
                            </div>
                        </button>

                                                <div class="mieordini-card-body" id="mieordini-body-<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('ordine')['id'], ENT_QUOTES, 'UTF-8', true);?>
" hidden>

                                                        <div class="mieordini-items">
                                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('ordine')['items'], 'item');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('item')->value) {
$foreach1DoElse = false;
?>
                                    <div class="mieordini-item">
                                        <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/prodotto/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('item')['prodotto']['id'], ENT_QUOTES, 'UTF-8', true);?>
" class="mieordini-item-media">
                                            <?php if ((true && (true && null !== ($_smarty_tpl->getValue('item')['prodotto']['immagine'] ?? null))) && $_smarty_tpl->getValue('item')['prodotto']['immagine']) {?>
                                                <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/prodotti/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('item')['prodotto']['immagine'], ENT_QUOTES, 'UTF-8', true);?>
"
                                                     onerror="this.onerror=null; this.src='<?php echo $_smarty_tpl->getValue('base_url');?>
/img/prodotto-default.png'"
                                                     alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('item')['prodotto']['nome'], ENT_QUOTES, 'UTF-8', true);?>
"
                                                     class="mieordini-item-img">
                                            <?php } else { ?>
                                                <div class="mieordini-item-img-placeholder">
                                                    <i class="ti ti-photo"></i>
                                                </div>
                                            <?php }?>
                                        </a>

                                        <div class="mieordini-item-info">
                                            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/prodotto/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('item')['prodotto']['id'], ENT_QUOTES, 'UTF-8', true);?>
" class="mieordini-item-nome">
                                                <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('item')['prodotto']['nome'], ENT_QUOTES, 'UTF-8', true);?>

                                            </a>
                                            <span class="mieordini-item-qty">Quantità: <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('item')['quantita'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                                        </div>

                                        <div class="mieordini-item-prezzi">
                                            <?php if ((true && (true && null !== ($_smarty_tpl->getValue('item')['scontoApplicato'] ?? null))) && $_smarty_tpl->getValue('item')['scontoApplicato'] > 0) {?>
                                                <span class="mieordini-item-prezzo-unitario-scontato">€ <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('item')['prezzoUnitario'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                                                <span class="mieordini-item-sconto-badge">-<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('item')['scontoApplicato'], ENT_QUOTES, 'UTF-8', true);?>
%</span>
                                            <?php } else { ?>
                                                <span class="mieordini-item-prezzo-unitario">€ <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('item')['prezzoUnitario'], ENT_QUOTES, 'UTF-8', true);?>
 cad.</span>
                                            <?php }?>
                                            <span class="mieordini-item-totale">€ <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('item')['totaleItem'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                                        </div>
                                    </div>
                                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                            </div>

                                                        <div class="mieordini-info-grid">
                                <div class="mieordini-info-block">
                                    <h3 class="mieordini-info-title"><i class="ti ti-map-pin"></i> Indirizzo di spedizione</h3>
                                    <p class="mieordini-info-text">
                                        <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('ordine')['indirizzoSpedizione']['via'], ENT_QUOTES, 'UTF-8', true);?>
<br>
                                        <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('ordine')['indirizzoSpedizione']['cap'], ENT_QUOTES, 'UTF-8', true);?>
 <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('ordine')['indirizzoSpedizione']['citta'], ENT_QUOTES, 'UTF-8', true);?>
 (<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('ordine')['indirizzoSpedizione']['provincia'], ENT_QUOTES, 'UTF-8', true);?>
)<br>
                                        <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('ordine')['indirizzoSpedizione']['nazione'], ENT_QUOTES, 'UTF-8', true);?>

                                    </p>
                                </div>

                                <div class="mieordini-info-block">
                                    <h3 class="mieordini-info-title"><i class="ti ti-credit-card"></i> Metodo di pagamento</h3>
                                    <p class="mieordini-info-text">
                                        Carta terminante con <strong><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('ordine')['ultimeQuattroCifreCarta'], ENT_QUOTES, 'UTF-8', true);?>
</strong><br>
                                        Intestata a <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('ordine')['nomeTitolareCarta'], ENT_QUOTES, 'UTF-8', true);?>

                                    </p>
                                </div>
                            </div>

                                                        <?php if ((true && (true && null !== ($_smarty_tpl->getValue('ordine')['isAnnullabile'] ?? null))) && $_smarty_tpl->getValue('ordine')['isAnnullabile']) {?>
                                <div class="mieordini-actions">
                                    <button type="button" class="mieordini-btn-annulla" data-id="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('ordine')['id'], ENT_QUOTES, 'UTF-8', true);?>
">
                                        <i class="ti ti-x"></i> Annulla ordine
                                    </button>
                                </div>
                            <?php }?>

                        </div>

                    </div>
                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
            </div>
        <?php } else { ?>
                        <div class="mieordini-empty" id="mieordini-empty">
                <div class="mieordini-empty-icon">
                    <i class="ti ti-package"></i>
                </div>
                <h2 class="mieordini-empty-titolo">Non hai ancora effettuato ordini</h2>
                <p class="mieordini-empty-testo">Quando completerai un acquisto, lo troverai qui insieme allo stato della spedizione.</p>
                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/catalogo" class="mieordini-empty-btn">
                    <i class="ti ti-shopping-bag"></i> Scopri il catalogo
                </a>
            </div>
        <?php }?>

                <div class="mieordini-popup-overlay" id="mieordini-annulla-popup" hidden>
            <div class="mieordini-popup-box">
                <i class="ti ti-alert-triangle mieordini-popup-icon"></i>
                <p class="mieordini-popup-message">Sei sicuro di voler annullare questo ordine?</p>

                <div class="mieordini-popup-actions">
                    <button type="button" class="mieordini-btn-secondary" id="mieordini-annulla-indietro">Indietro</button>
                    <button type="button" class="mieordini-btn-primary" id="mieordini-annulla-conferma">Conferma</button>
                </div>
            </div>
        </div>

                <div class="mieordini-popup-overlay" id="mieordini-popup" hidden>
            <div class="mieordini-popup-box">
                <i class="ti ti-alert-triangle mieordini-popup-icon"></i>
                <p class="mieordini-popup-message" id="mieordini-popup-message"></p>
                <button type="button" class="mieordini-btn-primary" id="mieordini-popup-close">Chiudi</button>
            </div>
        </div>

    </div>
</div>
<?php
}
}
/* {/block "content"} */
/* {block "extra_js"} */
class Block_8666031506a53b983b1fcb8_47949268 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<?php echo '<script'; ?>
>

(function() {

    var list = document.getElementById('mieordini-list');

    var popup        = document.getElementById('mieordini-popup');
    var popupMessage = document.getElementById('mieordini-popup-message');
    var popupClose    = document.getElementById('mieordini-popup-close');

    var annullaPopup     = document.getElementById('mieordini-annulla-popup');
    var annullaIndietro  = document.getElementById('mieordini-annulla-indietro');
    var annullaConferma  = document.getElementById('mieordini-annulla-conferma');
    var idDaAnnullare      = null;

    function mostraPopup(messaggio) {
        popupMessage.textContent = messaggio;
        popup.removeAttribute('hidden');
    }

    if (popupClose) {
        popupClose.addEventListener('click', function() {
            popup.setAttribute('hidden', '');
        });
    }

    // ── APERTURA/CHIUSURA DETTAGLIO ORDINE ──
    if (list) {
        list.addEventListener('click', function(e) {
            var header = e.target.closest('.mieordini-card-header');
            if (header) {
                var targetId = header.getAttribute('data-target');
                var body = document.getElementById(targetId);
                if (!body) return;

                var aperto = body.hasAttribute('hidden');
                if (aperto) {
                    body.removeAttribute('hidden');
                } else {
                    body.setAttribute('hidden', '');
                }
                header.setAttribute('aria-expanded', aperto ? 'true' : 'false');
                return;
            }

            // ── APERTURA POPUP CONFERMA ANNULLAMENTO ──
            var annullaBtn = e.target.closest('.mieordini-btn-annulla');
            if (annullaBtn) {
                idDaAnnullare = annullaBtn.getAttribute('data-id');
                annullaPopup.removeAttribute('hidden');
            }
        });
    }

    if (annullaIndietro) {
        annullaIndietro.addEventListener('click', function() {
            idDaAnnullare = null;
            annullaPopup.setAttribute('hidden', '');
        });
    }

    // ── CONFERMA ANNULLAMENTO (AJAX) ──
    if (annullaConferma) {
        annullaConferma.addEventListener('click', function() {
            if (!idDaAnnullare) return;

            var id = idDaAnnullare;

            fetch('<?php echo $_smarty_tpl->getValue('base_url');?>
/account/ordini/annulla', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                credentials: 'same-origin',
                body: JSON.stringify({ id: id })
            })
            .then(function(response) { return response.json(); })
            .then(function(data) {
                annullaPopup.setAttribute('hidden', '');
                idDaAnnullare = null;

                if (data.status === 'ok') {
                    window.location.reload();
                } else if (data.reason === 'non_annullabile') {
                    mostraPopup('Questo ordine non può più essere annullato.');
                } else {
                    mostraPopup('Non è stato possibile annullare l\'ordine, riprova più tardi.');
                }
            })
            .catch(function() {
                annullaPopup.setAttribute('hidden', '');
                idDaAnnullare = null;
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
