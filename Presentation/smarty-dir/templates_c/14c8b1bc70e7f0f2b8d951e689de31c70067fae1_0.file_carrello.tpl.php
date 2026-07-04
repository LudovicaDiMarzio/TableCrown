<?php
/* Smarty version 5.8.0, created on 2026-07-03 17:32:22
  from 'file:carrello.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a47d6068014b0_63466408',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '14c8b1bc70e7f0f2b8d951e689de31c70067fae1' => 
    array (
      0 => 'carrello.tpl',
      1 => 1783092737,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a47d6068014b0_63466408 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\damic\\Desktop\\uni\\APPUNTI\\anno3\\secondo_semenstre\\Pweb\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_5890527536a47d6067d0c63_62471853', "extra_css");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_8764139076a47d6067d4a37_18311354', "content");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_13109679406a47d606800d27_29231013', "extra_js");
?>

<?php $_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "extra_css"} */
class Block_5890527536a47d6067d0c63_62471853 extends \Smarty\Runtime\Block
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
class Block_8764139076a47d6067d4a37_18311354 extends \Smarty\Runtime\Block
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
                                 data-item-id="<?php echo $_smarty_tpl->getValue('p')['id'];?>
"
                                 data-prezzo-unitario="<?php echo $_smarty_tpl->getValue('item')['prezzo_unitario'];?>
"
                                 data-risparmio-unitario="<?php if ($_smarty_tpl->getValue('item')['sconto']) {
echo $_smarty_tpl->getValue('item')['prezzo_originale']-$_smarty_tpl->getValue('item')['prezzo_unitario'];
} else { ?>0<?php }?>"
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
/carrello/rimuovi/<?php echo $_smarty_tpl->getValue('p')['id'];?>
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

                                        <template id="tpl-carrello-item">
                        <div class="carrello-item"
                             data-item-id=""
                             data-prezzo-unitario=""
                             data-risparmio-unitario="0"
                             data-update-url="">

                            <a href="" class="carrello-item-img-link">
                                <img src=""
                                     onerror="this.onerror=null; this.src='<?php echo $_smarty_tpl->getValue('base_url');?>
/img/default.png'"
                                     alt=""
                                     class="carrello-item-img">
                            </a>

                            <div class="carrello-item-info">
                                <a href="" class="carrello-item-nome"></a>

                                <div class="carrello-item-prezzo-wrapper">
                                    <span class="carrello-item-prezzo"></span>
                                    <span class="carrello-item-prezzo-old" style="display:none;"></span>
                                    <span class="carrello-item-prezzo-nd" style="display:none;">Prezzo N/D</span>
                                </div>
                            </div>

                            <div class="carrello-item-controls">

                                <div class="carrello-item-qty">
                                    <button class="button quantita-btn carrello-qty-minus" type="button" aria-label="Diminuisci quantità">
                                        <i class="ti ti-minus"></i>
                                    </button>
                                    <input type="number"
                                           class="input quantita-input carrello-qty-input"
                                           value="1"
                                           min="1"
                                           max="99"
                                           aria-label="Quantità">
                                    <button class="button quantita-btn carrello-qty-plus" type="button" aria-label="Aumenta quantità">
                                        <i class="ti ti-plus"></i>
                                    </button>
                                </div>

                                <div class="carrello-item-subtotale">
                                    <span class="carrello-item-subtotale-label">Subtotale</span>
                                    <span class="carrello-item-subtotale-value"></span>
                                </div>

                                <button class="carrello-item-rimuovi"
                                        type="button"
                                        data-url=""
                                        aria-label="Rimuovi dal carrello">
                                    <i class="ti ti-trash"></i> Rimuovi
                                </button>

                            </div>

                        </div>
                    </template>

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
                                            <button class="button btn-correlato-cart"
                                                    type="button"
                                                    data-url="<?php echo $_smarty_tpl->getValue('base_url');?>
/carrello/aggiungi/<?php echo $_smarty_tpl->getValue('correlato')['id'];?>
"
                                                    aria-label="Aggiungi <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('correlato')['nome'], ENT_QUOTES, 'UTF-8', true);?>
 al carrello">
                                                <i class="ti ti-shopping-cart"></i> Carrello
                                            </button>
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

                                <aside class="carrello-summary" id="carrello-summary">

                    <h2 class="carrello-summary-title">Totale Carrello</h2>

                    <dl class="carrello-summary-list">
                        <div class="carrello-summary-row">
                            <dt>N° articoli</dt>
                            <dd id="summary-n-articoli" aria-live="polite"><?php echo $_smarty_tpl->getValue('carrello_summary')['n_articoli'];?>
</dd>
                        </div>

                        <div class="carrello-summary-row carrello-summary-risparmio"
                             id="summary-risparmio-row"
                             <?php if (!($_smarty_tpl->getValue('carrello_summary')['sconto'] > 0)) {?>style="display:none;"<?php }?>>
                            <dt>Risparmio</dt>
                            <dd id="summary-risparmio">-€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('carrello_summary')['sconto'],2);?>
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
class Block_13109679406a47d606800d27_29231013 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\damic\\Desktop\\uni\\APPUNTI\\anno3\\secondo_semenstre\\Pweb\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<?php echo '<script'; ?>
>

(function() {

    // ── TOAST NOTIFICHE ──
    function mostraToast(messaggio, tipo) {
        var toast = document.createElement('div');
        toast.textContent = messaggio;
        toast.style.cssText = [
            'position:fixed', 'bottom:1.5rem', 'right:1.5rem',
            'padding:.75rem 1.25rem', 'border-radius:6px',
            'color:#fff', 'font-size:.9rem', 'z-index:9999',
            'box-shadow:0 2px 8px rgba(0,0,0,.25)',
            'background:' + (tipo === 'errore' ? '#c0392b' : '#27ae60')
        ].join(';');
        document.body.appendChild(toast);
        setTimeout(function() { toast.remove(); }, 4000);
    }
    

    // ── RICALCOLO RIEPILOGO ──
    function ricalcolaRiepilogo() {
        var righe = document.querySelectorAll('.carrello-item');
        var nArticoli = 0;
        var subtotale = 0;
        var risparmioTotale = 0;

        righe.forEach(function(riga) {
            var input = riga.querySelector('.carrello-qty-input');
            var qty = parseInt(input ? input.value : 1) || 1;
            var unit = parseFloat(riga.dataset.prezzoUnitario) || 0;
            var risparmioUnit = parseFloat(riga.dataset.risparmioUnitario) || 0;
            nArticoli += qty;
            subtotale += qty * unit;
            risparmioTotale += qty * risparmioUnit;
        });

        // subtotale usa già il prezzo scontato per riga, quindi il totale
        // non deve sottrarre di nuovo il risparmio (altrimenti sconto doppio)
        var totale = Math.max(subtotale, 0);

        var nArticoliEl  = document.getElementById('summary-n-articoli');
        var totaleEl     = document.getElementById('summary-totale');
        var risparmioEl  = document.getElementById('summary-risparmio');
        var risparmioRow = document.getElementById('summary-risparmio-row');

        if (nArticoliEl)  nArticoliEl.textContent = nArticoli;
        if (totaleEl)     totaleEl.textContent = '€' + totale.toFixed(2);
        if (risparmioEl)  risparmioEl.textContent = '-€' + risparmioTotale.toFixed(2);
        if (risparmioRow) risparmioRow.style.display = risparmioTotale > 0 ? '' : 'none';
    }

    // ── BINDING RIGA CARRELLO (stepper qty + rimozione) ──
    // Estratto in funzione riutilizzabile: viene chiamato sia sulle righe
    // renderizzate da Smarty al caricamento, sia sulle righe create
    // dinamicamente via JS quando si aggiunge un correlato al carrello.
    function bindRigaCarrello(riga) {
        var input       = riga.querySelector('.carrello-qty-input');
        var btnMinus    = riga.querySelector('.carrello-qty-minus');
        var btnPlus     = riga.querySelector('.carrello-qty-plus');
        var subtotaleEl = riga.querySelector('.carrello-item-subtotale-value');
        var unit        = parseFloat(riga.dataset.prezzoUnitario) || 0;
        var updateUrl   = riga.dataset.updateUrl;

        
        if (input) input.dataset.valPrecedente = input.value;

        function aggiornaRigaUI() {
            var qty = parseInt(input.value) || 1;
            if (subtotaleEl) subtotaleEl.textContent = '€' + (unit * qty).toFixed(2);
            ricalcolaRiepilogo();
        }

        function inviaAggiornamento(valPrecedente) {
            if (!updateUrl) return;
            var qty = parseInt(input.value) || 1;
            var controller = new AbortController();
            var timeout = setTimeout(function() { controller.abort(); }, 5000);

            fetch(updateUrl + '?qty=' + qty, { signal: controller.signal })
                .then(function(response) {
                    clearTimeout(timeout);
                    if (!response.ok) throw new Error('server');
                })
                .catch(function(err) {
                    clearTimeout(timeout);
                    input.value = valPrecedente;
                    input.dataset.valPrecedente = valPrecedente;
                    aggiornaRigaUI();
                    var msg = err.name === 'AbortError'
                        ? 'Connessione lenta, quantità non salvata.'
                        : 'Errore nel salvataggio della quantità.';
                    mostraToast(msg, 'errore');
                });
        }

        if (btnMinus) {
            btnMinus.addEventListener('click', function(e) {
                e.preventDefault();
                var val = parseInt(input.value) || 1;
                if (val > 1) {
                    input.value = val - 1;
                    input.dataset.valPrecedente = val;
                    aggiornaRigaUI();
                    inviaAggiornamento(val);
                }
            });
        }

        if (btnPlus) {
            btnPlus.addEventListener('click', function(e) {
                e.preventDefault();
                var val = parseInt(input.value) || 1;
                input.value = val + 1;
                input.dataset.valPrecedente = val;
                aggiornaRigaUI();
                inviaAggiornamento(val);
            });
        }

        if (input) {
            input.addEventListener('input', function() {
                var valPrecedente = parseInt(input.dataset.valPrecedente) || 1;
                var val = parseInt(input.value);
                if (isNaN(val) || val < 1) input.value = 1;
                aggiornaRigaUI();
                inviaAggiornamento(valPrecedente);
                input.dataset.valPrecedente = input.value;
            });
        }

        var btnRimuovi = riga.querySelector('.carrello-item-rimuovi');
        if (btnRimuovi) {
            btnRimuovi.addEventListener('click', function() {
                var url         = this.dataset.url;
                var parent      = riga.parentNode;
                var nextSibling = riga.nextSibling;

                riga.remove();

                var righeRimaste = document.querySelectorAll('.carrello-item');
                if (righeRimaste.length > 0) {
                    ricalcolaRiepilogo();
                }

                if (!url) return;

                var controller = new AbortController();
                var timeout = setTimeout(function() { controller.abort(); }, 5000);

                fetch(url, {
                    method: 'POST',
                    signal: controller.signal
                })
                    .then(function(response) {
                        clearTimeout(timeout);
                        if (!response.ok) throw new Error('server');
                        if (document.querySelectorAll('.carrello-item').length === 0) {
                            window.location.reload();
                        }
                    })
                    .catch(function(err) {
                        clearTimeout(timeout);
                        if (nextSibling) {
                            parent.insertBefore(riga, nextSibling);
                        } else {
                            parent.appendChild(riga);
                        }
                        ricalcolaRiepilogo();
                        var msg = err.name === 'AbortError'
                            ? 'Connessione lenta, articolo non rimosso.'
                            : 'Errore nella rimozione dell\'articolo.';
                        mostraToast(msg, 'errore');
                    });
            });
        }
    }

    // Bind iniziale su tutte le righe già presenti nel DOM al caricamento
    document.querySelectorAll('.carrello-item').forEach(bindRigaCarrello);

    // ── CREAZIONE RIGA CARRELLO DA JSON (usata quando si aggiunge un correlato) ──
    function aggiungiRigaCarrello(data) {
        var tpl = document.getElementById('tpl-carrello-item');
        var contenitore = document.getElementById('carrello-items');
        if (!tpl || !contenitore) return;

        var nodo = tpl.content.cloneNode(true);
        var riga = nodo.querySelector('.carrello-item');

        riga.dataset.itemId = data.id;
        riga.dataset.prezzoUnitario = data.prezzo_unitario;
        riga.dataset.risparmioUnitario = data.sconto
            ? (data.prezzo_originale - data.prezzo_unitario)
            : 0;
        riga.dataset.updateUrl = data.update_url;

        var linkImg = riga.querySelector('.carrello-item-img-link');
        if (linkImg) linkImg.href = data.product_url;

        var img = riga.querySelector('.carrello-item-img');
        if (img) {
            img.src = data.immagine_url;
            img.alt = data.nome;
        }

        var nomeLink = riga.querySelector('.carrello-item-nome');
        if (nomeLink) {
            nomeLink.href = data.product_url;
            nomeLink.textContent = data.nome;
        }

        var prezzoEl    = riga.querySelector('.carrello-item-prezzo');
        var prezzoOldEl = riga.querySelector('.carrello-item-prezzo-old');
        var prezzoNdEl  = riga.querySelector('.carrello-item-prezzo-nd');

        if (data.sconto) {
            prezzoEl.textContent = '€' + Number(data.prezzo_unitario).toFixed(2);
            prezzoEl.style.display = '';
            prezzoOldEl.textContent = '€' + Number(data.prezzo_originale).toFixed(2);
            prezzoOldEl.style.display = '';
            prezzoNdEl.style.display = 'none';
        } else if (data.prezzo_unitario !== null && data.prezzo_unitario !== undefined) {
            prezzoEl.textContent = '€' + Number(data.prezzo_unitario).toFixed(2);
            prezzoEl.style.display = '';
            prezzoOldEl.style.display = 'none';
            prezzoNdEl.style.display = 'none';
        } else {
            prezzoEl.style.display = 'none';
            prezzoOldEl.style.display = 'none';
            prezzoNdEl.style.display = '';
        }

        var qtyInput = riga.querySelector('.carrello-qty-input');
        if (qtyInput) qtyInput.value = data.quantita || 1;

        var subtotaleEl = riga.querySelector('.carrello-item-subtotale-value');
        if (subtotaleEl) {
            var subtotaleCalcolato = (data.subtotale !== null && data.subtotale !== undefined)
                ? Number(data.subtotale)
                : Number(data.prezzo_unitario) * (data.quantita || 1);
            subtotaleEl.textContent = '€' + subtotaleCalcolato.toFixed(2);
        }

        var btnRimuovi = riga.querySelector('.carrello-item-rimuovi');
        if (btnRimuovi) {
            btnRimuovi.dataset.url = data.remove_url;
            btnRimuovi.setAttribute('aria-label', 'Rimuovi ' + data.nome + ' dal carrello');
        }

        contenitore.appendChild(riga);

        // Ribinda subito la nuova riga (stepper + rimozione)
        var nuovaRigaDom = contenitore.lastElementChild;
        bindRigaCarrello(nuovaRigaDom);
    }

    // ── AGGIUNGE UNA NUOVA RIGA O AGGIORNA LA QUANTITÀ SE IL PRODOTTO C'È GIÀ ──
    function aggiungiOAggiornaRigaCarrello(data) {
        var rigaEsistente = document.querySelector('.carrello-item[data-item-id="' + data.id + '"]');

        if (rigaEsistente) {
            var input = rigaEsistente.querySelector('.carrello-qty-input');
            if (input) {
                input.value = data.quantita;
                input.dataset.valPrecedente = data.quantita;
            }
            var subtotaleEl = rigaEsistente.querySelector('.carrello-item-subtotale-value');
            var unit = parseFloat(rigaEsistente.dataset.prezzoUnitario) || 0;
            if (subtotaleEl) {
                subtotaleEl.textContent = '€' + (unit * data.quantita).toFixed(2);
            }
        } else {
            aggiungiRigaCarrello(data);
        }

        ricalcolaRiepilogo();
    }

    // ── AGGIUNTA ARTICOLO (da correlati) ──
    document.querySelectorAll('.btn-correlato-cart').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var url = this.dataset.url;
            if (!url) return;

            var controller = new AbortController();
            var timeout = setTimeout(function() { controller.abort(); }, 5000);

            fetch(url, {
                method: 'POST',
                signal: controller.signal
            })
                .then(function(response) {
                    clearTimeout(timeout);
                    if (!response.ok) throw new Error('server');
                    return response.json();
                })
                .then(function(data) {
                    mostraToast('Prodotto aggiunto al carrello', 'successo');

                    // Se il carrello era vuoto in partenza, #carrello-items
                    // non esiste ancora nel DOM: in quel caso ricarichiamo
                    // la pagina per far comparire tutto il layout corretto
                    // (colonna riepilogo, sezione correlati ecc.)
                    if (!document.getElementById('carrello-items')) {
                        window.location.reload();
                        return;
                    }

                    aggiungiOAggiornaRigaCarrello(data);
                })
                .catch(function(err) {
                    clearTimeout(timeout);
                    var msg = err.name === 'AbortError'
                        ? 'Connessione lenta, prodotto non aggiunto.'
                        : 'Errore nell\'aggiunta del prodotto.';
                    mostraToast(msg, 'errore');
                });
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
