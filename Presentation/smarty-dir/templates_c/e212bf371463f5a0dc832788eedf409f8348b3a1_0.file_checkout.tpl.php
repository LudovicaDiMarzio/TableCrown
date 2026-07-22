<?php
/* Smarty version 5.8.0, created on 2026-07-22 11:16:10
  from 'file:checkout.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a608a5a5f49c0_48061808',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e212bf371463f5a0dc832788eedf409f8348b3a1' => 
    array (
      0 => 'checkout.tpl',
      1 => 1784632655,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a608a5a5f49c0_48061808 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_16805950486a608a5a596f16_05535249', "extra_css");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_18389262526a608a5a59bb39_39385030', "content");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_11137985296a608a5a5f4353_34475860', "extra_js");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "extra_css"} */
class Block_16805950486a608a5a596f16_05535249 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

    <link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/css/checkout.css">
<?php
}
}
/* {/block "extra_css"} */
/* {block "content"} */
class Block_18389262526a608a5a59bb39_39385030 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>


<div class="checkout-container">
        <?php if ((true && ($_smarty_tpl->hasVariable('flash_type') && null !== ($_smarty_tpl->getValue('flash_type') ?? null))) && $_smarty_tpl->getValue('flash_type') == 'success') {?>
        <div class="checkout-esito-overlay" id="esito-successo" aria-hidden="false">
            <div class="checkout-esito-modal checkout-esito-successo">
                <i class="ti ti-circle-check checkout-esito-icon"></i>
                <h3 class="checkout-esito-titolo">Acquisto completato!</h3>
                <p class="checkout-esito-testo"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('flash_message'), ENT_QUOTES, 'UTF-8', true);?>
</p>
                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/profilo/ordini" class="button btn-checkout-conferma">
                    <i class="ti ti-list-check"></i> Vai ai tuoi ordini
                </a>
            </div>
        
        </div>
    <?php }?>

    <?php if ((true && ($_smarty_tpl->hasVariable('flash_type') && null !== ($_smarty_tpl->getValue('flash_type') ?? null))) && $_smarty_tpl->getValue('flash_type') == 'danger') {?>
        <div class="checkout-esito-overlay checkout-esito-overlay-errore" id="esito-errore" aria-hidden="false">
            <div class="checkout-esito-modal checkout-esito-errore">
                <button type="button" class="checkout-esito-close" id="close-esito-errore" aria-label="Chiudi">&times;</button>
                <i class="ti ti-alert-triangle checkout-esito-icon"></i>
                <h3 class="checkout-esito-titolo">Acquisto non riuscito</h3>
                <p class="checkout-esito-testo"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('flash_message'), ENT_QUOTES, 'UTF-8', true);?>
</p>
                <p class="checkout-esito-sub">Controlla i dati inseriti e riprova.</p>
             <button type="button" class="button btn-checkout-conferma" id="btn-riprova-errore">
                 <i class="ti ti-refresh"></i> Riprova
                </button>
            </div>
        </div>
    <?php }?>
    <div class="container">

        <h1 class="checkout-title">Checkout</h1>

        <form action="<?php echo (($tmp = $_smarty_tpl->getValue('azione_checkout') ?? null)===null||$tmp==='' ? ((string)$_smarty_tpl->getValue('base_url'))."/checkout/acquista" ?? null : $tmp);?>
" method="post" class="checkout-form" id="checkout-form">

            <?php if ($_smarty_tpl->getValue('tipo_checkout') == 'evento') {?>
                <input type="hidden" name="id_evento" value="<?php echo $_smarty_tpl->getValue('evento')['idEvento'];?>
">
            <?php }?>

            <div class="checkout-grid">

                                <div class="checkout-main">

                                        <section class="checkout-section">
                        <h2 class="checkout-section-title">
                            <?php if ($_smarty_tpl->getValue('tipo_checkout') == 'evento') {?>Riepilogo Iscrizione<?php } else { ?>Riepilogo Ordine<?php }?>
                        </h2>

                        <?php if ($_smarty_tpl->getValue('tipo_checkout') == 'evento' && (true && ($_smarty_tpl->hasVariable('evento') && null !== ($_smarty_tpl->getValue('evento') ?? null)))) {?>
                            <div class="checkout-evento-card">
                                <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/eventi/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['imgEvento'], ENT_QUOTES, 'UTF-8', true);?>
"
                                     alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['nomeEvento'], ENT_QUOTES, 'UTF-8', true);?>
"
                                     class="checkout-evento-img">
                                <div class="checkout-evento-info">
                                    <h3 class="checkout-evento-nome"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['nomeEvento'], ENT_QUOTES, 'UTF-8', true);?>
</h3>
                                    <?php if ((true && (true && null !== ($_smarty_tpl->getValue('evento')['dataInizio'] ?? null)))) {?>
                                        <p class="checkout-evento-meta"><i class="ti ti-calendar"></i> <?php echo $_smarty_tpl->getSmarty()->getModifierCallback('date_format')($_smarty_tpl->getValue('evento')['dataInizio'],"%d/%m/%Y %H:%M");?>
</p>
                                    <?php }?>
                                    <?php if ((true && (true && null !== ($_smarty_tpl->getValue('evento')['gioco'] ?? null)))) {?>
                                        <p class="checkout-evento-meta"><i class="ti ti-cards"></i> <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('evento')['gioco'], ENT_QUOTES, 'UTF-8', true);?>
</p>
                                    <?php }?>
                                </div>
                                <?php if ((true && (true && null !== ($_smarty_tpl->getValue('evento')['quotaIscrizione'] ?? null)))) {?>
                                    <div class="checkout-evento-quota">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('evento')['quotaIscrizione'],2);?>
</div>
                                <?php }?>
                            </div>
                        <?php } else { ?>
                            <div class="checkout-prodotti-list">
                                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('prodotti_carrello'), 'item');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('item')->value) {
$foreach0DoElse = false;
?>
                                    <div class="checkout-prodotto-row">
                                        <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/prodotti/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('item')['prodotto']['immagine'], ENT_QUOTES, 'UTF-8', true);?>
"
                                             alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('item')['prodotto']['nome'], ENT_QUOTES, 'UTF-8', true);?>
"
                                             class="checkout-prodotto-img">
                                        <div class="checkout-prodotto-info">
                                            <p class="checkout-prodotto-nome"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('item')['prodotto']['nome'], ENT_QUOTES, 'UTF-8', true);?>
</p>
                                            <p class="checkout-prodotto-qta">Quantità: <?php echo $_smarty_tpl->getValue('item')['quantita'];?>
</p>
                                        </div>
                                        <div class="checkout-prodotto-prezzo">
                                            €<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('item')['subtotale'],2);?>

                                        </div>
                                    </div>
                                <?php
}
if ($foreach0DoElse) {
?>
                                    <p class="checkout-empty">Nessun prodotto nel carrello.</p>
                                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                            </div>
                        <?php }?>
                    </section>

                                        <?php if ($_smarty_tpl->getValue('tipo_checkout') != 'evento') {?>
                        <section class="checkout-section">
                            <h2 class="checkout-section-title">Indirizzo di Spedizione</h2>

                            <?php if ((true && ($_smarty_tpl->hasVariable('indirizzi') && null !== ($_smarty_tpl->getValue('indirizzi') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('indirizzi')) > 0) {?>
                                <div class="checkout-radio-list" id="indirizzi-list">
                                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('indirizzi'), 'ind');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('ind')->value) {
$foreach1DoElse = false;
?>
                                        <label class="checkout-radio-card<?php if ($_smarty_tpl->getValue('ind')['predefinito']) {?> is-selected<?php }?>">
                                            <input type="radio" name="id_indirizzo" value="<?php echo $_smarty_tpl->getValue('ind')['id'];?>
" <?php if ($_smarty_tpl->getValue('ind')['predefinito']) {?>checked<?php }?>>
                                            <div class="checkout-radio-content">
                                                <p class="checkout-radio-title">
                                                    <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('ind')['nome'], ENT_QUOTES, 'UTF-8', true);?>

                                                    <?php if ($_smarty_tpl->getValue('ind')['predefinito']) {?><span class="checkout-badge-predefinito">Predefinito</span><?php }?>
                                                </p>
                                                <p class="checkout-radio-sub">
                                                    <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('ind')['via'], ENT_QUOTES, 'UTF-8', true);?>
, <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('ind')['citta'], ENT_QUOTES, 'UTF-8', true);?>
 (<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('ind')['provincia'], ENT_QUOTES, 'UTF-8', true);?>
) <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('ind')['cap'], ENT_QUOTES, 'UTF-8', true);?>
, <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('ind')['nazione'], ENT_QUOTES, 'UTF-8', true);?>

                                                </p>
                                            </div>
                                        </label>
                                    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                                </div>
                            <?php } else { ?>
                                <p class="checkout-empty">Non hai indirizzi salvati. <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/profilo/indirizzi">Aggiungine uno</a>.</p>
                            <?php }?>
                        </section>
                    <?php }?>

                    <section class="checkout-section">
    <h2 class="checkout-section-title">Metodo di Pagamento</h2>

    <?php if ((true && ($_smarty_tpl->hasVariable('carte') && null !== ($_smarty_tpl->getValue('carte') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('carte')) > 0) {?>
        <div class="checkout-tabs">
            <label class="checkout-tab is-active" id="tab-salvata">
                <input type="radio" name="scelta_carta" value="salvata" checked>
                <i class="ti ti-credit-card"></i> Carta Salvata
            </label>
            <label class="checkout-tab" id="tab-nuova">
                <input type="radio" name="scelta_carta" value="nuova">
                <i class="ti ti-plus"></i> Nuova Carta
            </label>
        </div>

        <div class="checkout-radio-list" id="carte-salvate-list">
            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('carte'), 'carta');
$foreach2DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('carta')->value) {
$foreach2DoElse = false;
?>
                <label class="checkout-radio-card">
                    <input type="radio" name="id_carta_salvata" value="<?php echo $_smarty_tpl->getValue('carta')['id'];?>
">
                    <div class="checkout-radio-content">
                        <p class="checkout-radio-title"><i class="ti ti-credit-card"></i> <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('carta')['titolare'], ENT_QUOTES, 'UTF-8', true);?>
</p>
                        <p class="checkout-radio-sub">**** **** **** <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('carta')['ultimeQuattroCifre'], ENT_QUOTES, 'UTF-8', true);?>
 — Scad. <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('carta')['scadenza'], ENT_QUOTES, 'UTF-8', true);?>
</p>
                    </div>
                </label>
            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
        </div>
    <?php } else { ?>
        <input type="hidden" name="scelta_carta" value="nuova">
    <?php }?>

    <input type="hidden" name="id_carta_salvata" id="id_carta_salvata_fallback" value="0" <?php if ((true && ($_smarty_tpl->hasVariable('carte') && null !== ($_smarty_tpl->getValue('carte') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('carte')) > 0) {?>disabled<?php }?>>

    <div class="checkout-nuova-carta" id="nuova-carta-form" <?php if ((true && ($_smarty_tpl->hasVariable('carte') && null !== ($_smarty_tpl->getValue('carte') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('carte')) > 0) {?>style="display:none;"<?php }?>>

                        <div class="checkout-nuova-carta" id="nuova-carta-form" <?php if ((true && ($_smarty_tpl->hasVariable('carte') && null !== ($_smarty_tpl->getValue('carte') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('carte')) > 0) {?>style="display:none;"<?php }?>>
                            <div class="form-group">
                                <label class="form-label" for="titolare_carta">Titolare</label>
                                <input type="text" id="titolare_carta" name="titolare_carta" class="input" placeholder="Nome sulla carta">
                            </div>
                            <div class="checkout-form-row">
                                <div class="form-group">
                                    <label class="form-label" for="numero_carta">Numero Carta</label>
                                    <input type="text" id="numero_carta" name="numero_carta" class="input" placeholder="0000 0000 0000 0000" maxlength="19">
                                </div>
                                <div class="form-group form-group-small">
                                    <label class="form-label" for="scadenza_carta">Scadenza</label>
                                    <input type="text" id="scadenza_carta" name="scadenza_carta" class="input" placeholder="MM/AA" maxlength="5">
                                </div>
                                <div class="form-group form-group-small">
                                    <label class="form-label" for="cvv">CVV</label>
                                    <input type="password" id="cvv" name="cvv" class="input" placeholder="123" maxlength="4">
                                </div>
                            </div>
                            <label class="checkout-checkbox">
                                <input type="checkbox" name="salva_carta_profilo" value="1">
                                Salva questa carta sul mio profilo
                            </label>
                        </div>
                    </section>

                </div>

                                <aside class="checkout-summary-box">
                    <h2 class="checkout-summary-title">Totale</h2>

                    <div class="checkout-summary-row">
                        <span><?php if ($_smarty_tpl->getValue('tipo_checkout') == 'evento') {?>Quota Iscrizione<?php } else { ?>Subtotale<?php }?></span>
                        <span>
                            €<?php if ($_smarty_tpl->getValue('tipo_checkout') == 'evento') {
echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('evento')['quotaIscrizione'],2);
} else {
echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('totale_carrello'),2);
}?>
                        </span>
                    </div>

                    <div class="checkout-summary-total">
                        <span>Totale</span>
                        <span>
                            €<?php if ($_smarty_tpl->getValue('tipo_checkout') == 'evento') {
echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('evento')['quotaIscrizione'],2);
} else {
echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('totale_carrello'),2);
}?>
                        </span>
                    </div>

                    <button type="submit" class="button btn-checkout-conferma">
                        <i class="ti ti-lock"></i> Conferma e Paga
                    </button>

                    <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/<?php if ($_smarty_tpl->getValue('tipo_checkout') == 'evento') {?>eventi<?php } else { ?>carrello<?php }?>" class="checkout-back-link">
                        <i class="ti ti-arrow-left"></i> <?php if ($_smarty_tpl->getValue('tipo_checkout') == 'evento') {?>Torna agli eventi<?php } else { ?>Torna al carrello<?php }?>
                    </a>
                </aside>

            </div>
        </form>

    </div>
</div>

<?php
}
}
/* {/block "content"} */
/* {block "extra_js"} */
class Block_11137985296a608a5a5f4353_34475860 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<?php echo '<script'; ?>
>

(function() {

    var tabSalvata = document.getElementById('tab-salvata');
    var tabNuova = document.getElementById('tab-nuova');
    var carteList = document.getElementById('carte-salvate-list');
    var nuovaCartaForm = document.getElementById('nuova-carta-form');
    var fallbackCartaSalvata = document.getElementById('id_carta_salvata_fallback');

    function mostraSalvata() {
        if (tabSalvata) tabSalvata.classList.add('is-active');
        if (tabNuova) tabNuova.classList.remove('is-active');
        if (carteList) carteList.style.display = '';
        if (nuovaCartaForm) nuovaCartaForm.style.display = 'none';
        if (fallbackCartaSalvata) fallbackCartaSalvata.disabled = true;
    }

    function mostraNuova() {
        if (tabNuova) tabNuova.classList.add('is-active');
        if (tabSalvata) tabSalvata.classList.remove('is-active');
        if (carteList) carteList.style.display = 'none';
        if (nuovaCartaForm) nuovaCartaForm.style.display = 'block';
        if (fallbackCartaSalvata) fallbackCartaSalvata.disabled = false;
    }

    if (tabSalvata) tabSalvata.addEventListener('click', mostraSalvata);
    if (tabNuova) tabNuova.addEventListener('click', mostraNuova)

    // ── EVIDENZIAZIONE RADIO CARD SELEZIONATA (indirizzi e carte) ──
    document.querySelectorAll('.checkout-radio-list').forEach(function(lista) {
        var cards = lista.querySelectorAll('.checkout-radio-card');
        cards.forEach(function(card) {
            var input = card.querySelector('input[type="radio"]');
            if (!input) return;
            input.addEventListener('change', function() {
                cards.forEach(function(c) { c.classList.remove('is-selected'); });
                card.classList.add('is-selected');
            });
        });
    });

    // ── VALIDAZIONE MINIMA LATO CLIENT ──
    var form = document.getElementById('checkout-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            var sceltaCartaEl = form.querySelector('input[name="scelta_carta"]:checked')
                              || form.querySelector('input[name="scelta_carta"][type="hidden"]');
            if (sceltaCartaEl && sceltaCartaEl.value === 'nuova') {
                var numero = document.getElementById('numero_carta');
                var cvv = document.getElementById('cvv');
                var titolare = document.getElementById('titolare_carta');
                var scadenza = document.getElementById('scadenza_carta');
                if (!numero.value || !cvv.value || !titolare.value || !scadenza.value) {
                    e.preventDefault();
                    window.alert('Compila tutti i campi della carta di pagamento.');
                }
            }
        });
    }

    // ── MODAL ESITO ACQUISTO ──
    var esitoSuccesso = document.getElementById('esito-successo');
    if (esitoSuccesso) {
        document.body.style.overflow = 'hidden'; // resto della pagina bloccato: niente scroll, overlay copre tutti i click
    }
    
    var esitoErrore = document.getElementById('esito-errore');
    var closeErrore = document.getElementById('close-esito-errore');
    var btnRiprova = document.getElementById('btn-riprova-errore');

    function chiudiErrore() {
        if (esitoErrore) esitoErrore.remove();
        document.body.style.overflow = '';
    }

    if (closeErrore) closeErrore.addEventListener('click', chiudiErrore);
    if (btnRiprova) btnRiprova.addEventListener('click', chiudiErrore);
    if (esitoErrore) {
        esitoErrore.addEventListener('click', function(e) {
            if (e.target === esitoErrore) chiudiErrore(); // click fuori dal box chiude
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
