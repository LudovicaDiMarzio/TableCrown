<?php
/* Smarty version 5.8.0, created on 2026-06-17 17:48:24
  from 'file:carrello.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a32c1c8b20054_12026072',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '14c8b1bc70e7f0f2b8d951e689de31c70067fae1' => 
    array (
      0 => 'carrello.tpl',
      1 => 1781711290,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a32c1c8b20054_12026072 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\damic\\Desktop\\uni\\APPUNTI\\anno3\\secondo_semenstre\\Pweb\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_15559615216a32c1c8af2389_75874151', "extra_css");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_5902849646a32c1c8af4853_81288811', "content");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_6303639226a32c1c8b1d8e3_51731765', "extra_js");
?>

<?php $_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "extra_css"} */
class Block_15559615216a32c1c8af2389_75874151 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\damic\\Desktop\\uni\\APPUNTI\\anno3\\secondo_semenstre\\Pweb\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

    <link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/public/css/carrello.css">
<?php
}
}
/* {/block "extra_css"} */
/* {block "content"} */
class Block_5902849646a32c1c8af4853_81288811 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\damic\\Desktop\\uni\\APPUNTI\\anno3\\secondo_semenstre\\Pweb\\TableCrown\\Presentation\\smarty-dir\\templates';
?>



<div class="carrello-container">
    <div class="container">

                <nav class="carrello-breadcrumb" aria-label="Breadcrumb">
            <ul class="breadcrumb-list">
                <li><a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/">Home</a></li>
                <li><a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/catalogo">Catalogo</a></li>
                <li class="is-active"><span>Carrello</span></li>
            </ul>
        </nav>

        <h1 class="carrello-titolo">
            <i class="ti ti-shopping-cart"></i> Carrello
        </h1>

        <?php if ((true && ($_smarty_tpl->hasVariable('carrello') && null !== ($_smarty_tpl->getValue('carrello') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('carrello')->getItems()) > 0) {?>

            <div class="carrello-layout">

                                <div class="carrello-main">

                    <div class="carrello-items" id="carrello-items">
                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('carrello')->getItems(), 'item');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('item')->value) {
$foreach0DoElse = false;
?>
                            <?php $_smarty_tpl->assign('p', $_smarty_tpl->getValue('item')->getProdotto(), false, NULL);?>
                            <?php $_smarty_tpl->assign('qty', $_smarty_tpl->getValue('item')->getQuantita(), false, NULL);?>

                            <div class="carrello-item"
                                 data-item-id="<?php echo $_smarty_tpl->getValue('item')->getIdItem();?>
"
                                 data-prezzo-unitario="<?php echo $_smarty_tpl->getValue('item')->getSubtotale()/$_smarty_tpl->getValue('qty');?>
"
                                 data-update-url="<?php echo $_smarty_tpl->getValue('base_url');?>
/carrello/aggiorna/<?php echo $_smarty_tpl->getValue('item')->getIdItem();?>
">

                                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/prodotto/<?php echo $_smarty_tpl->getValue('p')->getIdProdotto();?>
" class="carrello-item-img-link">
                                    <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/prodotti/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('p')->getImgProdotto(), ENT_QUOTES, 'UTF-8', true);?>
"
                                         alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('p')->getNomeProdotto(), ENT_QUOTES, 'UTF-8', true);?>
"
                                         class="carrello-item-img">
                                </a>

                                <div class="carrello-item-info">
                                    <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/prodotto/<?php echo $_smarty_tpl->getValue('p')->getIdProdotto();?>
" class="carrello-item-nome">
                                        <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('p')->getNomeProdotto(), ENT_QUOTES, 'UTF-8', true);?>

                                    </a>

                                    <?php $_smarty_tpl->assign('prezzo', $_smarty_tpl->getValue('p')->getPrezzo(), false, NULL);?>
                                    <div class="carrello-item-prezzo-wrapper">
                                        <?php if ((true && ($_smarty_tpl->hasVariable('prezzo') && null !== ($_smarty_tpl->getValue('prezzo') ?? null)))) {?>
                                            <?php if ($_smarty_tpl->getValue('prezzo')->hasSconto()) {?>
                                                <span class="carrello-item-prezzo">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prezzo')->calcolaPrezzoScontato(),2);?>
</span>
                                                <span class="carrello-item-prezzo-old">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prezzo')->getValore(),2);?>
</span>
                                            <?php } else { ?>
                                                <span class="carrello-item-prezzo">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prezzo')->getValore(),2);?>
</span>
                                            <?php }?>
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
                                               value="<?php echo $_smarty_tpl->getValue('qty');?>
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
                                        <span class="carrello-item-subtotale-value">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('item')->getSubtotale(),2);?>
</span>
                                    </div>

                                    <button class="carrello-item-rimuovi"
                                            type="button"
                                            data-url="<?php echo $_smarty_tpl->getValue('base_url');?>
/carrello/rimuovi/<?php echo $_smarty_tpl->getValue('item')->getIdItem();?>
"
                                            aria-label="Rimuovi <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('p')->getNomeProdotto(), ENT_QUOTES, 'UTF-8', true);?>
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
/prodotto/<?php echo $_smarty_tpl->getValue('correlato')->getIdProdotto();?>
" class="correlato-card-link">
                                                <div class="correlato-image-wrapper">
                                                    <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/prodotti/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('correlato')->getImgProdotto(), ENT_QUOTES, 'UTF-8', true);?>
"
                                                         alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('correlato')->getNomeProdotto(), ENT_QUOTES, 'UTF-8', true);?>
"
                                                         class="correlato-image">
                                                </div>
                                                <div class="correlato-info">
                                                    <h3 class="correlato-nome"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('correlato')->getNomeProdotto(), ENT_QUOTES, 'UTF-8', true);?>
</h3>
                                                    <div class="correlato-rating">
                                                        <?php $_smarty_tpl->assign('cMedia', $_smarty_tpl->getValue('correlato')->getValutazioneMedia(), false, NULL);?>
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
                                                        <?php $_smarty_tpl->assign('cPrezzo', $_smarty_tpl->getValue('correlato')->getPrezzo(), false, NULL);?>
                                                        <?php if ((true && ($_smarty_tpl->hasVariable('cPrezzo') && null !== ($_smarty_tpl->getValue('cPrezzo') ?? null)))) {?>
                                                            <?php if ($_smarty_tpl->getValue('cPrezzo')->hasSconto()) {?>
                                                                <span class="correlato-prezzo-scontato">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('cPrezzo')->calcolaPrezzoScontato(),2);?>
</span>
                                                                <span class="correlato-prezzo-old">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('cPrezzo')->getValore(),2);?>
</span>
                                                            <?php } else { ?>
                                                                <span>€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('cPrezzo')->getValore(),2);?>
</span>
                                                            <?php }?>
                                                        <?php } else { ?>
                                                            <span class="prezzo-nd">N/D</span>
                                                        <?php }?>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/carrello/aggiungi/<?php echo $_smarty_tpl->getValue('correlato')->getIdProdotto();?>
"
                                               class="button btn-correlato-cart"
                                               aria-label="Aggiungi <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('correlato')->getNomeProdotto(), ENT_QUOTES, 'UTF-8', true);?>
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
                       data-sconto="<?php echo $_smarty_tpl->getValue('carrello')->getSconto();?>
"
                       data-spedizione="<?php if ($_smarty_tpl->getValue('carrello')->getSpedizione() !== null) {
echo $_smarty_tpl->getValue('carrello')->getSpedizione();
}?>">

                    <h2 class="carrello-summary-title">Totale Carrello</h2>

                    <dl class="carrello-summary-list">
                        <div class="carrello-summary-row">
                            <dt>N° articoli</dt>
                            <dd id="summary-n-articoli" aria-live="polite"><?php echo $_smarty_tpl->getValue('carrello')->getTotaleArticoli();?>
</dd>
                        </div>

                        <?php if ($_smarty_tpl->getValue('carrello')->getSconto() > 0) {?>
                            <div class="carrello-summary-row carrello-summary-sconto">
                                <dt>Sconto</dt>
                                <dd>-€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('carrello')->getSconto(),2);?>
</dd>
                            </div>
                        <?php }?>

                        <div class="carrello-summary-row">
                            <dt>Spedizione</dt>
                            <dd>
                                <?php if ($_smarty_tpl->getValue('carrello')->getSpedizione() === null) {?>
                                    Da calcolare
                                <?php } elseif ($_smarty_tpl->getValue('carrello')->getSpedizione() == 0) {?>
                                    Gratuita
                                <?php } else { ?>
                                    €<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('carrello')->getSpedizione(),2);?>

                                <?php }?>
                            </dd>
                        </div>
                    </dl>

                    <div class="carrello-summary-totale">
                        <span class="carrello-summary-totale-label">Totale</span>
                        <span class="carrello-summary-totale-value" id="summary-totale" aria-live="polite">
                            €<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('carrello')->getTotale(),2);?>

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
class Block_6303639226a32c1c8b1d8e3_51731765 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\damic\\Desktop\\uni\\APPUNTI\\anno3\\secondo_semenstre\\Pweb\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<?php echo '<script'; ?>
>
function initCarrelloPage() {

    const summary = document.getElementById('carrello-summary');
    const sconto = summary ? (parseFloat(summary.dataset.sconto) || 0) : 0;
    const spedizioneRaw = summary ? summary.dataset.spedizione : '';
    const spedizione = spedizioneRaw ? (parseFloat(spedizioneRaw) || 0) : 0;

    // ── RICALCOLO RIEPILOGO (lato client, per feedback immediato) ──
    function ricalcolaRiepilogo() {
        const righe = document.querySelectorAll('.carrello-item');
        let nArticoli = 0;
        let subtotale = 0;

        righe.forEach(riga => {
            const input = riga.querySelector('.carrello-qty-input');
            const qty = parseInt(input?.value) || 1;
            const unit = parseFloat(riga.dataset.prezzoUnitario) || 0;
            nArticoli += qty;
            subtotale += qty * unit;
        });

        const totale = Math.max(subtotale - sconto + spedizione, 0);

        const nArticoliEl = document.getElementById('summary-n-articoli');
        const totaleEl = document.getElementById('summary-totale');
        if (nArticoliEl) nArticoliEl.textContent = nArticoli;
        if (totaleEl) totaleEl.textContent = '€' + totale.toFixed(2);
    }

    // ── STEPPER QUANTITÀ PER OGNI ARTICOLO ──
    document.querySelectorAll('.carrello-item').forEach(riga => {
        const input       = riga.querySelector('.carrello-qty-input');
        const btnMinus     = riga.querySelector('.carrello-qty-minus');
        const btnPlus      = riga.querySelector('.carrello-qty-plus');
        const subtotaleEl = riga.querySelector('.carrello-item-subtotale-value');
        const unit         = parseFloat(riga.dataset.prezzoUnitario) || 0;
        const updateUrl    = riga.dataset.updateUrl;

        function aggiornaRigaUI() {
            const qty = parseInt(input.value) || 1;
            if (subtotaleEl) subtotaleEl.textContent = '€' + (unit * qty).toFixed(2);
            ricalcolaRiepilogo();
        }

        function inviaAggiornamento() {
            if (!updateUrl) return;
            const qty = parseInt(input.value) || 1;
            fetch(updateUrl + '?qty=' + qty).catch(err => {
                console.warn('Aggiornamento carrello:', err);
            });
        }

        if (btnMinus) {
            btnMinus.addEventListener('click', function (e) {
                e.preventDefault();
                const val = parseInt(input.value) || 1;
                if (val > 1) {
                    input.value = val - 1;
                    aggiornaRigaUI();
                    inviaAggiornamento();
                }
            });
        }

        if (btnPlus) {
            btnPlus.addEventListener('click', function (e) {
                e.preventDefault();
                const val = parseInt(input.value) || 1;
                input.value = val + 1;
                aggiornaRigaUI();
                inviaAggiornamento();
            });
        }

        if (input) {
            input.addEventListener('input', function () {
                const val = parseInt(input.value);
                if (isNaN(val) || val < 1) {
                    input.value = 1;
                }
                aggiornaRigaUI();
                inviaAggiornamento();
            });
        }
    });

    // ── RIMOZIONE ARTICOLO ──
    document.querySelectorAll('.carrello-item-rimuovi').forEach(btn => {
        btn.addEventListener('click', function () {
            const riga = this.closest('.carrello-item');
            const url = this.dataset.url;

            if (url) {
                fetch(url).catch(err => {
                    console.warn('Rimozione carrello:', err);
                });
            }

            if (riga) {
                riga.remove();
            }

            const righeRimaste = document.querySelectorAll('.carrello-item');
            if (righeRimaste.length === 0) {
                // Nessun articolo rimasto: ricarica per mostrare lo stato "carrello vuoto"
                window.location.reload();
            } else {
                ricalcolaRiepilogo();
            }
        });
    });

    // ── CAROSELLO "POTREBBE INTERESSARTI" ──
    const correlatiNext = document.getElementById('correlati-next');
    const correlatiGrid = document.getElementById('correlati-grid');

    if (correlatiNext && correlatiGrid) {
        correlatiNext.addEventListener('click', function () {
            const card = correlatiGrid.querySelector('.correlato-card');
            const scrollAmount = card ? card.offsetWidth + 20 : 280;

            const fineRaggiunta = correlatiGrid.scrollLeft + correlatiGrid.clientWidth >= correlatiGrid.scrollWidth - 5;

            if (fineRaggiunta) {
                correlatiGrid.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                correlatiGrid.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            }
        });
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCarrelloPage);
} else {
    initCarrelloPage();
}
<?php echo '</script'; ?>
>
<?php
}
}
/* {/block "extra_js"} */
}
