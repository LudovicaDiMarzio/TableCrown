<?php
/* Smarty version 5.8.0, created on 2026-07-12 17:30:10
  from 'file:wishlist.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a53b302866607_11742709',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '87ceda1ff4f4774c8db61b1d0bee09494ba3857e' => 
    array (
      0 => 'wishlist.tpl',
      1 => 1783870169,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a53b302866607_11742709 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_8712694006a53b30276cb61_17162798', "extra_css");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_1908385296a53b30276f794_71765080', "content");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_828341056a53b302865b36_56154651', "extra_js");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "extra_css"} */
class Block_8712694006a53b30276cb61_17162798 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

    <link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/css/Wishlist.css">
<?php
}
}
/* {/block "extra_css"} */
/* {block "content"} */
class Block_1908385296a53b30276f794_71765080 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<div class="wishlist-container">
    <div class="container">

                <div class="wishlist-topbar">
            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/account" class="wishlist-back-link">
                <i class="ti ti-arrow-left"></i> Torna all'Area Personale
            </a>
        </div>

                <div class="wishlist-header">
            <div class="wishlist-header-text">
                <span class="wishlist-eyebrow">Area Personale</span>
                <h1 class="wishlist-titolo">
                    <i class="ti ti-heart-filled"></i> La Mia Wishlist
                </h1>
            </div>

            <?php if ((true && ($_smarty_tpl->hasVariable('wishlist') && null !== ($_smarty_tpl->getValue('wishlist') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('wishlist')) > 0) {?>
                <div class="wishlist-count-badge">
                    <span class="wishlist-count-num"><?php echo $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('wishlist'));?>
</span>
                    <span class="wishlist-count-label"><?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('wishlist')) == 1) {?>articolo<?php } else { ?>articoli<?php }?></span>
                </div>
            <?php }?>
        </div>

                <?php if ((true && ($_smarty_tpl->hasVariable('wishlist') && null !== ($_smarty_tpl->getValue('wishlist') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('wishlist')) > 0) {?>
            <div class="wishlist-grid" id="wishlist-grid">
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('wishlist'), 'prodotto');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('prodotto')->value) {
$foreach0DoElse = false;
?>
                    <div class="wishlist-card <?php if (!$_smarty_tpl->getValue('prodotto')['isAcquistabile']) {?>wishlist-card-esaurito<?php }?>"
                         data-id="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['id'], ENT_QUOTES, 'UTF-8', true);?>
"
                         id="wishlist-card-<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['id'], ENT_QUOTES, 'UTF-8', true);?>
">

                        <div class="wishlist-card-media">
                            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/prodotto/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['id'], ENT_QUOTES, 'UTF-8', true);?>
">
                                <?php if ((true && (true && null !== ($_smarty_tpl->getValue('prodotto')['immagine'] ?? null))) && $_smarty_tpl->getValue('prodotto')['immagine']) {?>
                                    <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/prodotti/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['immagine'], ENT_QUOTES, 'UTF-8', true);?>
"
                                         onerror="this.onerror=null; this.src='<?php echo $_smarty_tpl->getValue('base_url');?>
/img/prodotto-default.png'"
                                         alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['nome'], ENT_QUOTES, 'UTF-8', true);?>
"
                                         class="wishlist-card-img">
                                <?php } else { ?>
                                    <div class="wishlist-card-img-placeholder">
                                        <i class="ti ti-photo"></i>
                                    </div>
                                <?php }?>
                            </a>

                            <?php if ($_smarty_tpl->getValue('prodotto')['disponibilita'] == 'esaurito') {?>
                                <span class="wishlist-badge-esaurito">Esaurito</span>
                            <?php } elseif ($_smarty_tpl->getValue('prodotto')['disponibilita'] == 'annunciato') {?>
                                <span class="wishlist-badge-esaurito wishlist-badge-annunciato">In arrivo</span>
                            <?php }?>

                            <?php if ((true && (true && null !== ($_smarty_tpl->getValue('prodotto')['sconto'] ?? null))) && $_smarty_tpl->getValue('prodotto')['sconto'] && $_smarty_tpl->getValue('prodotto')['percentuale_sconto']) {?>
                                <span class="wishlist-badge-sconto">-<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['percentuale_sconto'], ENT_QUOTES, 'UTF-8', true);?>
%</span>
                            <?php }?>

                            <button type="button"
                                    class="wishlist-remove-btn"
                                    data-id="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['id'], ENT_QUOTES, 'UTF-8', true);?>
"
                                    aria-label="Rimuovi dalla wishlist"
                                    title="Rimuovi dalla wishlist">
                                <i class="ti ti-heart-filled"></i>
                            </button>
                        </div>

                        <div class="wishlist-card-body">
                            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/prodotto/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['id'], ENT_QUOTES, 'UTF-8', true);?>
" class="wishlist-card-nome">
                                <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['nome'], ENT_QUOTES, 'UTF-8', true);?>

                            </a>

                            <?php if ((true && (true && null !== ($_smarty_tpl->getValue('prodotto')['valutazione_media'] ?? null)))) {?>
                                <div class="wishlist-card-stelle" aria-label="Valutazione <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['valutazione_media'], ENT_QUOTES, 'UTF-8', true);?>
 su 5">
                                    <?php
$_smarty_tpl->assign('i', null);$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int) ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? 5+1 - (1) : 1-(5)+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0) {
for ($_smarty_tpl->tpl_vars['i']->value = 1, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++) {
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration === 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration === $_smarty_tpl->tpl_vars['i']->total;?>
                                        <?php if ($_smarty_tpl->getValue('i') <= $_smarty_tpl->getValue('prodotto')['valutazione_media']) {?>
                                            <i class="ti ti-star-filled"></i>
                                        <?php } elseif ($_smarty_tpl->getValue('i')-0.5 <= $_smarty_tpl->getValue('prodotto')['valutazione_media']) {?>
                                            <i class="ti ti-star-half-filled"></i>
                                        <?php } else { ?>
                                            <i class="ti ti-star"></i>
                                        <?php }?>
                                    <?php }
}
?>
                                    <span class="wishlist-card-stelle-valore"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['valutazione_media'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                                </div>
                            <?php }?>

                            <div class="wishlist-card-prezzo-row">
                                <?php if ((true && (true && null !== ($_smarty_tpl->getValue('prodotto')['sconto'] ?? null))) && $_smarty_tpl->getValue('prodotto')['sconto'] && $_smarty_tpl->getValue('prodotto')['prezzo_scontato']) {?>
                                    <span class="wishlist-prezzo-scontato">€ <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['prezzo_scontato'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                                    <span class="wishlist-prezzo-originale">€ <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['prezzo'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                                <?php } else { ?>
                                    <span class="wishlist-prezzo">€ <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['prezzo'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                                <?php }?>
                            </div>

                            <button type="button"
                                    class="wishlist-btn-carrello"
                                    data-id="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['id'], ENT_QUOTES, 'UTF-8', true);?>
"
                                    <?php if (!$_smarty_tpl->getValue('prodotto')['isAcquistabile']) {?>disabled<?php }?>>
                                <i class="ti ti-shopping-cart-plus"></i>
                                <?php if (!$_smarty_tpl->getValue('prodotto')['isAcquistabile']) {?>Non disponibile<?php } else { ?>Aggiungi al carrello<?php }?>
                            </button>
                        </div>

                    </div>
                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
            </div>
        <?php } else { ?>
                        <div class="wishlist-empty" id="wishlist-empty">
                <div class="wishlist-empty-icon">
                    <i class="ti ti-heart"></i>
                </div>
                <h2 class="wishlist-empty-titolo">La tua wishlist è vuota</h2>
                <p class="wishlist-empty-testo">Salva i prodotti che ti piacciono per ritrovarli facilmente quando vuoi.</p>
                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/catalogo" class="wishlist-empty-btn">
                    <i class="ti ti-shopping-bag"></i> Scopri il catalogo
                </a>
            </div>
        <?php }?>

                <div class="wishlist-popup-overlay" id="wishlist-popup" hidden>
            <div class="wishlist-popup-box">
                <i class="ti ti-circle-check wishlist-popup-icon" id="wishlist-popup-icon"></i>
                <p class="wishlist-popup-message" id="wishlist-popup-message"></p>
                <button type="button" class="wishlist-btn-primary" id="wishlist-popup-close">Chiudi</button>
            </div>
        </div>

    </div>
</div>
<?php
}
}
/* {/block "content"} */
/* {block "extra_js"} */
class Block_828341056a53b302865b36_56154651 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<?php echo '<script'; ?>
>

(function() {

    var grid  = document.getElementById('wishlist-grid');
    var empty = document.getElementById('wishlist-empty');

    var popup        = document.getElementById('wishlist-popup');
    var popupMessage = document.getElementById('wishlist-popup-message');
    var popupIcon     = document.getElementById('wishlist-popup-icon');
    var popupClose    = document.getElementById('wishlist-popup-close');

    function mostraPopup(messaggio, successo) {
        popupMessage.textContent = messaggio;
        popupIcon.className = 'ti wishlist-popup-icon ' + (successo ? 'ti-circle-check' : 'ti-alert-triangle');
        popupIcon.classList.toggle('wishlist-popup-icon-errore', !successo);
        popup.removeAttribute('hidden');
    }

    if (popupClose) {
        popupClose.addEventListener('click', function() {
            popup.setAttribute('hidden', '');
        });
    }

    function mostraStatoVuotoSeNecessario() {
        if (grid && grid.children.length === 0) {
            grid.setAttribute('hidden', '');
            if (empty) {
                empty.removeAttribute('hidden');
            } else {
                window.location.reload();
            }
        }
    }

    // ── RIMOZIONE DALLA WISHLIST ──
    if (grid) {
        grid.addEventListener('click', function(e) {
            var btn = e.target.closest('.wishlist-remove-btn');
            if (!btn) return;

            var id = btn.getAttribute('data-id');
            var card = document.getElementById('wishlist-card-' + id);

            fetch('<?php echo $_smarty_tpl->getValue('base_url');?>
/wishlist/rimuovi', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                credentials: 'same-origin',
                body: JSON.stringify({ id: id })
            })
            .then(function(response) { return response.json(); })
            .then(function(data) {
                if (data.status === 'ok') {
                    if (card) {
                        card.classList.add('wishlist-card-uscita');
                        card.addEventListener('transitionend', function() {
                            card.remove();
                            mostraStatoVuotoSeNecessario();
                        }, { once: true });
                    }
                } else {
                    mostraPopup('Non è stato possibile rimuovere il prodotto, riprova più tardi.', false);
                }
            })
            .catch(function() {
                mostraPopup('Si è verificato un errore di connessione, riprova più tardi.', false);
            });
        });

        // ── AGGIUNGI AL CARRELLO ──
        grid.addEventListener('click', function(e) {
            var btn = e.target.closest('.wishlist-btn-carrello');
            if (!btn || btn.disabled) return;

            var id = btn.getAttribute('data-id');

            fetch('<?php echo $_smarty_tpl->getValue('base_url');?>
/wishlist/aggiungi-carrello', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                credentials: 'same-origin',
                body: JSON.stringify({ id: id })
            })
            .then(function(response) { return response.json(); })
            .then(function(data) {
                if (data.status === 'ok') {
                    mostraPopup('Prodotto aggiunto al carrello!', true);
                } else if (data.reason === 'esaurito') {
                    mostraPopup('Il prodotto non è più disponibile.', false);
                } else {
                    mostraPopup('Non è stato possibile aggiungere il prodotto, riprova più tardi.', false);
                }
            })
            .catch(function() {
                mostraPopup('Si è verificato un errore di connessione, riprova più tardi.', false);
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
