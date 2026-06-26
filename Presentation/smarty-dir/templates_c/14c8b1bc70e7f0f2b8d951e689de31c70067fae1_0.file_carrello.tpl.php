<?php
/* Smarty version 5.8.0, created on 2026-06-26 16:01:31
  from 'file:carrello.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a3e863bacd772_44262740',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '14c8b1bc70e7f0f2b8d951e689de31c70067fae1' => 
    array (
      0 => 'carrello.tpl',
      1 => 1782482448,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a3e863bacd772_44262740 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\damic\\Desktop\\uni\\APPUNTI\\anno3\\secondo_semenstre\\Pweb\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_11164120346a3e863ba98941_13325647', "extra_css");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_9412604086a3e863ba9c9c5_66432531', "content");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_16500804936a3e863baccba7_88245276', "extra_js");
?>

<?php $_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "extra_css"} */
class Block_11164120346a3e863ba98941_13325647 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\damic\\Desktop\\uni\\APPUNTI\\anno3\\secondo_semenstre\\Pweb\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

    <link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/css/carrello.css">
<?php
}
}
/* {/block "extra_css"} */
/* {block "content"} */
class Block_9412604086a3e863ba9c9c5_66432531 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\damic\\Desktop\\uni\\APPUNTI\\anno3\\secondo_semenstre\\Pweb\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<div class="carrello-container">
    <div class="container">

        <h1 class="carrello-titolo">
            <i class="ti ti-shopping-cart"></i> Carrello
        </h1>

        <?php if ((true && ($_smarty_tpl->hasVariable('carrello_items') && null !== ($_smarty_tpl->getValue('carrello_items') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('carrello_items')) > 0) {?>

            <div class="carrello-layout">

                                <div class="carrello-main">

                    <div class="carrello-items" id="carrello-items">
                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('carrello_items'), 'item');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('item')->value) {
$foreach0DoElse = false;
?>
                            <?php $_smarty_tpl->assign('p', $_smarty_tpl->getValue('item')['prodotto'], false, NULL);?>

                            <div class="carrello-item"
                                 data-item-id="<?php echo $_smarty_tpl->getValue('item')['id_item'];?>
"
                                 data-prezzo-unitario="<?php echo $_smarty_tpl->getValue('item')['prezzo_unitario'];?>
"
                                 data-update-url="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('item')['update_url'], ENT_QUOTES, 'UTF-8', true);?>
">

                                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/prodotto/<?php echo $_smarty_tpl->getValue('p')['id'];?>
" class="carrello-item-img-link">
                                    <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/prodotti/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('p')['immagine'], ENT_QUOTES, 'UTF-8', true);?>
"
                                         onerror="this.onerror=null; this.src='<?php echo $_smarty_tpl->getValue('base_url');?>
/img/default.png'"
                                         alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('p')['nome'], ENT_QUOTES, 'UTF-8', true);?>
"
                                         class="carrello-item-img">
                                </a>

                                <div class="carrello-item-info">
                                    <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/prodotto/<?php echo $_smarty_tpl->getValue('p')['id'];?>
" class="carrello-item-nome">
                                        <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('p')['nome'], ENT_QUOTES, 'UTF-8', true);?>

                                    </a>

                                    <div class="carrello-item-prezzo-wrapper">
                                        <?php if ($_smarty_tpl->getValue('item')['sconto']) {?>
                                            <span class="carrello-item-prezzo">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('item')['prezzo_unitario'],2);?>
</span>
                                            <span class="carrello-item-prezzo-old">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('item')['prezzo_originale'],2);?>
</span>
                                        <?php } elseif ((true && (true && null !== ($_smarty_tpl->getValue('item')['prezzo_unitario'] ?? null)))) {?>
                                            <span class="carrello-item-prezzo">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('item')['prezzo_unitario'],2);?>
</span>
                                        <?php } else { ?>
                                            <span class="carrello-item-prezzo-nd">Prezzo N/D</span>
                                        <?php }?>
                                    </div>
                                </div>

                                <div class="carrello-item-controls">

                                    <div class="carrello-item-qty">
                                        <button class="button quantita-btn carrello-qty-minus" type="button" aria-label="Diminuisci quantità">
                                            <i class="ti ti-minus"></i>
                                        </button>
                                        <input type="number"
                                               class="input quantita-input carrello-qty-input"
                                               value="<?php echo $_smarty_tpl->getValue('item')['quantita'];?>
"
                                               min="1"
                                               max="99"
                                               aria-label="Quantità">
                                        <button class="button quantita-btn carrello-qty-plus" type="button" aria-label="Aumenta quantità">
                                            <i class="ti ti-plus"></i>
                                        </button>
                                    </div>

                                    <div class="carrello-item-subtotale">
                                        <span class="carrello-item-subtotale-label">Subtotale</span>
                                        <span class="carrello-item-subtotale-value">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('item')['subtotale'],2);?>
</span>
                                    </div>

                                    <button class="carrello-item-rimuovi"
                                            type="button"
                                            data-url="<?php echo $_smarty_tpl->getValue('base_url');?>
/carrello/rimuovi/<?php echo $_smarty_tpl->getValue('item')['id_item'];?>
"
                                            aria-label="Rimuovi <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('p')['nome'], ENT_QUOTES, 'UTF-8', true);?>
 dal carrello">
                                        <i class="ti ti-trash"></i> Rimuovi
                                    </button>

                                </div>

                            </div>
                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                    </div>

                                        <?php if ((true && ($_smarty_tpl->hasVariable('correlati') && null !== ($_smarty_tpl->getValue('correlati') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('correlati')) > 0) {?>
                        <section class="carrello-correlati">
                            <h2 class="carrello-section-title">Potrebbe interessarti</h2>

                            <div class="correlati-wrapper">
                                <div class="correlati-grid" id="correlati-grid">
                                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('correlati'), 'correlato');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('correlato')->value) {
$foreach1DoElse = false;
?>
                                        <div class="correlato-card">
                                            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/prodotto/<?php echo $_smarty_tpl->getValue('correlato')['id'];?>
" class="correlato-card-link">
                                                <div class="correlato-image-wrapper">
                                                    <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/prodotti/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('correlato')['immagine'], ENT_QUOTES, 'UTF-8', true);?>
"
                                                         onerror="this.onerror=null; this.src='<?php echo $_smarty_tpl->getValue('base_url');?>
/img/default.png'"
                                                         alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('correlato')['nome'], ENT_QUOTES, 'UTF-8', true);?>
"
                                                         class="correlato-image">
                                                </div>
                                                <div class="correlato-info">
                                                    <h3 class="correlato-nome"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('correlato')['nome'], ENT_QUOTES, 'UTF-8', true);?>
</h3>
                                                    <div class="correlato-rating">
                                                        <?php $_smarty_tpl->assign('cMedia', $_smarty_tpl->getValue('correlato')['valutazione_media'], false, NULL);?>
                                                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, array(1,2,3,4,5), 's');
$foreach2DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('s')->value) {
$foreach2DoElse = false;
?>
                                                            <?php if ($_smarty_tpl->getValue('s') <= $_smarty_tpl->getValue('cMedia')) {?>
                                                                <i class="ti ti-star-filled"></i>
                                                            <?php } elseif (($_smarty_tpl->getValue('s')-$_smarty_tpl->getValue('cMedia')) < 1) {?>
                                                                <i class="ti ti-star-half-filled"></i>
                                                            <?php } else { ?>
                                                                <i class="ti ti-star"></i>
                                                            <?php }?>
                                                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                                                    </div>
                                                    <div class="correlato-prezzo">
                                                        <?php if ($_smarty_tpl->getValue('correlato')['sconto']) {?>
                                                            <span class="correlato-prezzo-scontato">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('correlato')['prezzo_scontato'],2);?>
</span>
                                                            <span class="correlato-prezzo-old">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('correlato')['prezzo'],2);?>
</span>
                                                        <?php } elseif ((true && (true && null !== ($_smarty_tpl->getValue('correlato')['prezzo'] ?? null)))) {?>
                                                            <span>€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('correlato')['prezzo'],2);?>
</span>
                                                        <?php } else { ?>
                                                            <span class="prezzo-nd">N/D</span>
                                                        <?php }?>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/carrello/aggiungi/<?php echo $_smarty_tpl->getValue('correlato')['id'];?>
"
                                               class="button btn-correlato-cart"
                                               aria-label="Aggiungi <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('correlato')['nome'], ENT_QUOTES, 'UTF-8', true);?>
 al carrello">
                                                <i class="ti ti-shopping-cart"></i> Carrello
                                            </a>
                                        </div>
                                    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                                </div>

                                <button class="correlati-nav correlati-next" id="correlati-next" type="button" aria-label="Vedi altri prodotti correlati">
                                    <i class="ti ti-chevron-right"></i>
                                </button>
                            </div>
                        </section>
                    <?php }?>

                </div>

                                <aside class="carrello-summary"
                       id="carrello-summary"
                       data-sconto="<?php echo $_smarty_tpl->getValue('carrello_summary')['sconto'];?>
"
                       data-spedizione="<?php echo (($tmp = $_smarty_tpl->getValue('carrello_summary')['spedizione'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
">

                    <h2 class="carrello-summary-title">Totale Carrello</h2>

                    <dl class="carrello-summary-list">
                        <div class="carrello-summary-row">
                            <dt>N° articoli</dt>
                            <dd id="summary-n-articoli" aria-live="polite"><?php echo $_smarty_tpl->getValue('carrello_summary')['n_articoli'];?>
</dd>
                        </div>

                        <?php if ($_smarty_tpl->getValue('carrello_summary')['sconto'] > 0) {?>
                            <div class="carrello-summary-row carrello-summary-sconto">
                                <dt>Sconto</dt>
                                <dd>-€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('carrello_summary')['sconto'],2);?>
</dd>
                            </div>
                        <?php }?>

                        <div class="carrello-summary-row">
                            <dt>Spedizione</dt>
                            <dd>
                                <?php if ($_smarty_tpl->getValue('carrello_summary')['spedizione'] === null) {?>
                                    Da calcolare
                                <?php } elseif ($_smarty_tpl->getValue('carrello_summary')['spedizione'] == 0) {?>
                                    Gratuita
                                <?php } else { ?>
                                    €<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('carrello_summary')['spedizione'],2);?>

                                <?php }?>
                            </dd>
                        </div>
                    </dl>

                    <div class="carrello-summary-totale">
                        <span class="carrello-summary-totale-label">Totale</span>
                        <span class="carrello-summary-totale-value" id="summary-totale" aria-live="polite">
                            €<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('carrello_summary')['totale'],2);?>

                        </span>
                    </div>

                    <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/checkout" class="button btn-completa-ordine">
                        <i class="ti ti-shopping-cart"></i> Completa Ordine
                    </a>

                </aside>

            </div>

        <?php } else { ?>

                        <div class="carrello-vuoto">
                <i class="ti ti-shopping-cart-off"></i>
                <p>Il tuo carrello è vuoto.</p>
                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/catalogo" class="btn-primary">Vai al Catalogo</a>
            </div>

        <?php }?>

    </div>
</div>
<?php
}
}
/* {/block "content"} */
/* {block "extra_js"} */
class Block_16500804936a3e863baccba7_88245276 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\damic\\Desktop\\uni\\APPUNTI\\anno3\\secondo_semenstre\\Pweb\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<?php echo '<script'; ?>
>

(function() {

    const summary = document.getElementById('carrello-summary');
    const sconto = summary ? (parseFloat(summary.dataset.sconto) || 0) : 0;
    const spedizioneRaw = summary ? summary.dataset.spedizione : '';
    const spedizione = spedizioneRaw !== '' ? (parseFloat(spedizioneRaw) || 0) : 0;

    // ── RICALCOLO RIEPILOGO (lato client, per feedback immediato) ──
    function ricalcolaRiepilogo() {
        var righe = document.querySelectorAll('.carrello-item');
        var nArticoli = 0;
        var subtotale = 0;

        righe.forEach(function(riga) {
            var input = riga.querySelector('.carrello-qty-input');
            var qty = parseInt(input ? input.value : 1) || 1;
            var unit = parseFloat(riga.dataset.prezzoUnitario) || 0;
            nArticoli += qty;
            subtotale += qty * unit;
        });

        var totale = Math.max(subtotale - sconto + spedizione, 0);

        var nArticoliEl = document.getElementById('summary-n-articoli');
        var totaleEl    = document.getElementById('summary-totale');
        if (nArticoliEl) nArticoliEl.textContent = nArticoli;
        if (totaleEl)    totaleEl.textContent = '€' + totale.toFixed(2);
    }

    // ── STEPPER QUANTITÀ PER OGNI ARTICOLO ──
    document.querySelectorAll('.carrello-item').forEach(function(riga) {
        var input       = riga.querySelector('.carrello-qty-input');
        var btnMinus    = riga.querySelector('.carrello-qty-minus');
        var btnPlus     = riga.querySelector('.carrello-qty-plus');
        var subtotaleEl = riga.querySelector('.carrello-item-subtotale-value');
        var unit        = parseFloat(riga.dataset.prezzoUnitario) || 0;
        var updateUrl   = riga.dataset.updateUrl;

        function aggiornaRigaUI() {
            var qty = parseInt(input.value) || 1;
            if (subtotaleEl) subtotaleEl.textContent = '€' + (unit * qty).toFixed(2);
            ricalcolaRiepilogo();
        }

        function inviaAggiornamento() {
            if (!updateUrl) return;
            var qty = parseInt(input.value) || 1;
            var controller = new AbortController();
            var timeout = setTimeout(function() { controller.abort(); }, 5000);
            fetch(updateUrl + '?qty=' + qty, { signal: controller.signal })
                .then(function() { clearTimeout(timeout); })
                .catch(function() { clearTimeout(timeout); });
        }

        if (btnMinus) {
            btnMinus.addEventListener('click', function(e) {
                e.preventDefault();
                var val = parseInt(input.value) || 1;
                if (val > 1) {
                    input.value = val - 1;
                    aggiornaRigaUI();
                    inviaAggiornamento();
                }
            });
        }

        if (btnPlus) {
            btnPlus.addEventListener('click', function(e) {
                e.preventDefault();
                input.value = (parseInt(input.value) || 1) + 1;
                aggiornaRigaUI();
                inviaAggiornamento();
            });
        }

        if (input) {
            input.addEventListener('input', function() {
                var val = parseInt(input.value);
                if (isNaN(val) || val < 1) input.value = 1;
                aggiornaRigaUI();
                inviaAggiornamento();
            });
        }
    });

    // ── RIMOZIONE ARTICOLO ──
    document.querySelectorAll('.carrello-item-rimuovi').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var riga = this.closest('.carrello-item');
            var url  = this.dataset.url;

            if (url) {
                var controller = new AbortController();
                var timeout = setTimeout(function() { controller.abort(); }, 5000);
                fetch(url, { signal: controller.signal })
                    .then(function() { clearTimeout(timeout); })
                    .catch(function() { clearTimeout(timeout); });
            }

            if (riga) riga.remove();

            var righeRimaste = document.querySelectorAll('.carrello-item');
            if (righeRimaste.length === 0) {
                window.location.reload();
            } else {
                ricalcolaRiepilogo();
            }
        });
    });

    // ── CAROSELLO "POTREBBE INTERESSARTI" ──
    var correlatiNext = document.getElementById('correlati-next');
    var correlatiGrid = document.getElementById('correlati-grid');

    if (correlatiNext && correlatiGrid) {
        correlatiNext.addEventListener('click', function() {
            var card = correlatiGrid.querySelector('.correlato-card');
            var scrollAmount = card ? card.offsetWidth + 20 : 280;
            var fineRaggiunta = correlatiGrid.scrollLeft + correlatiGrid.clientWidth >= correlatiGrid.scrollWidth - 5;

            if (fineRaggiunta) {
                correlatiGrid.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                correlatiGrid.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            }
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
