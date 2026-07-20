<?php
/* Smarty version 5.8.0, created on 2026-07-21 01:51:24
  from 'file:ProfiloPagamenti.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a5eb47c6b7f21_31573460',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c66dfbf4459f8da985e2ff347335c860a7cfd955' => 
    array (
      0 => 'ProfiloPagamenti.tpl',
      1 => 1784591482,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a5eb47c6b7f21_31573460 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_11595495166a5eb47c697cc2_35343122', "extra_css");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_7649199326a5eb47c69bee1_04800002', "content");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_4107358956a5eb47c6b6f76_04590861', "extra_js");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "extra_css"} */
class Block_11595495166a5eb47c697cc2_35343122 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

    <link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/css/ProfiloPagamenti.css">
<?php
}
}
/* {/block "extra_css"} */
/* {block "content"} */
class Block_7649199326a5eb47c69bee1_04800002 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<div class="pagamenti-container">
    <div class="container">

                <div class="pagamenti-topbar">
            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/profilo" class="pagamenti-back-link">
                <i class="ti ti-arrow-left"></i> Torna all'Area Personale
            </a>
        </div>

                <div class="pagamenti-header">
            <div class="pagamenti-header-text">
                <span class="pagamenti-eyebrow">Area Personale</span>
                <h1 class="pagamenti-titolo">
                    <i class="ti ti-credit-card"></i> I Miei Metodi di Pagamento
                </h1>
            </div>

            <div class="pagamenti-header-actions">
                <?php if ((true && ($_smarty_tpl->hasVariable('metodi') && null !== ($_smarty_tpl->getValue('metodi') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('metodi')) > 0) {?>
                    <div class="pagamenti-count-badge">
                        <span class="pagamenti-count-num"><?php echo $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('metodi'));?>
</span>
                        <span class="pagamenti-count-label"><?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('metodi')) == 1) {?>carta<?php } else { ?>carte<?php }?></span>
                    </div>
                <?php }?>

                <button type="button" class="pagamenti-add-btn" id="pagamenti-btn-aggiungi" title="Aggiungi nuova carta">
                    <i class="ti ti-plus"></i>
                </button>
            </div>
        </div>

                <?php if ((true && ($_smarty_tpl->hasVariable('metodi') && null !== ($_smarty_tpl->getValue('metodi') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('metodi')) > 0) {?>
            <div class="pagamenti-list" id="pagamenti-list">
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('metodi'), 'carta');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('carta')->value) {
$foreach0DoElse = false;
?>
                                        <div class="pagamenti-card <?php if ((true && (true && null !== ($_smarty_tpl->getValue('carta')['predefinito'] ?? null))) && $_smarty_tpl->getValue('carta')['predefinito']) {?>pagamenti-card-predefinito<?php }?>" id="pagamenti-card-<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('carta')['id'], ENT_QUOTES, 'UTF-8', true);?>
">

                        <div class="pagamenti-card-top">
                            <span class="pagamenti-card-icon"><i class="ti ti-credit-card"></i></span>
                            <?php if ((true && (true && null !== ($_smarty_tpl->getValue('carta')['predefinito'] ?? null))) && $_smarty_tpl->getValue('carta')['predefinito']) {?>
                                <span class="pagamenti-predefinito-badge">
                                    <i class="ti ti-star-filled"></i> Predefinito
                                </span>
                            <?php }?>
                        </div>

                        <div class="pagamenti-numero-mascherato">
                            •••• •••• •••• <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('carta')['ultimeQuattroCifre'], ENT_QUOTES, 'UTF-8', true);?>

                        </div>

                        <div class="pagamenti-info-list">
                            <div class="pagamenti-info-row">
                                <i class="ti ti-user"></i>
                                <span class="pagamenti-info-value"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('carta')['titolare'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                            </div>
                            <div class="pagamenti-info-row">
                                <i class="ti ti-calendar"></i>
                                <span class="pagamenti-info-value">Scadenza <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('carta')['scadenza'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                            </div>
                        </div>

                        <div class="pagamenti-actions">
                            
                                                        <form action="<?php echo $_smarty_tpl->getValue('base_url');?>
/profilo/pagamenti/elimina"
                                  method="post"
                                  class="form-elimina-carta"
                                  data-confirm="Sei sicuro di voler eliminare questo metodo di pagamento?">
                                <input type="hidden" name="id_carta" value="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('carta')['id'], ENT_QUOTES, 'UTF-8', true);?>
">
                                <button type="submit" class="pagamenti-btn-elimina">
                                    <i class="ti ti-trash"></i> Elimina
                                </button>
                            </form>
                        </div>

                    </div>
                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
            </div>
        <?php } else { ?>
                        <div class="pagamenti-empty" id="pagamenti-empty">
                <div class="pagamenti-empty-icon">
                    <i class="ti ti-credit-card-off"></i>
                </div>
                <h2 class="pagamenti-empty-titolo">Nessun metodo di pagamento salvato</h2>
                <p class="pagamenti-empty-testo">Aggiungi una carta per velocizzare i tuoi prossimi acquisti.</p>
                <button type="button" class="pagamenti-empty-btn" id="pagamenti-btn-aggiungi-empty">
                    <i class="ti ti-plus"></i> Aggiungi carta
                </button>
            </div>
        <?php }?>

                <div class="pagamenti-popup-overlay" id="pagamenti-form-popup" hidden>
            <div class="pagamenti-popup-box">
                <h2 class="pagamenti-form-titolo">Aggiungi carta</h2>

                <form id="pagamenti-form" action="<?php echo $_smarty_tpl->getValue('base_url');?>
/profilo/pagamenti/aggiungi" method="post">
                    <div class="pagamenti-form-grid">
                        <div class="pagamenti-form-field pagamenti-form-field-full">
                            <label class="pagamenti-form-label" for="pagamenti-form-numero">Numero carta</label>
                            <input type="text" class="pagamenti-form-input" id="pagamenti-form-numero" name="numero_carta" inputmode="numeric" autocomplete="cc-number" placeholder="0000 0000 0000 0000" maxlength="19" required>
                        </div>

                        <div class="pagamenti-form-field pagamenti-form-field-full">
                            <label class="pagamenti-form-label" for="pagamenti-form-titolare">Titolare della carta</label>
                            <input type="text" class="pagamenti-form-input" id="pagamenti-form-titolare" name="titolare_carta" autocomplete="cc-name" required>
                        </div>

                        <div class="pagamenti-form-field">
                            <label class="pagamenti-form-label" for="pagamenti-form-scadenza">Scadenza (MM/AA)</label>
                            <input type="text" class="pagamenti-form-input" id="pagamenti-form-scadenza" name="scadenza_carta" autocomplete="cc-exp" placeholder="MM/AA" maxlength="5" required>
                        </div>

                        <div class="pagamenti-form-field">
                            <label class="pagamenti-form-label" for="pagamenti-form-cvv">CVV</label>
                            <input type="text" class="pagamenti-form-input" id="pagamenti-form-cvv" name="cvv" inputmode="numeric" autocomplete="cc-csc" maxlength="4" required>
                        </div>
                    </div>

                    <div class="pagamenti-form-actions">
                        <button type="button" class="pagamenti-form-btn-secondary" id="pagamenti-form-annulla">Annulla</button>
                        <button type="submit" class="pagamenti-form-btn-primary" id="pagamenti-form-salva">Salva</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
<?php
}
}
/* {/block "content"} */
/* {block "extra_js"} */
class Block_4107358956a5eb47c6b6f76_04590861 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<?php echo '<script'; ?>
>

(function() {

    // ── APERTURA/CHIUSURA POPUP "AGGIUNGI CARTA" ──
    // Solo mostra/nasconde l'overlay: il submit del form è nativo (nessun fetch/JSON).
    var formPopup   = document.getElementById('pagamenti-form-popup');
    var form        = document.getElementById('pagamenti-form');

    function resetForm() {
        if (form) form.reset();
    }

    function apriFormAggiungi() {
        resetForm();
        formPopup.removeAttribute('hidden');
    }

    var btnAggiungi      = document.getElementById('pagamenti-btn-aggiungi');
    var btnAggiungiEmpty = document.getElementById('pagamenti-btn-aggiungi-empty');
    var formAnnulla      = document.getElementById('pagamenti-form-annulla');

    if (btnAggiungi) {
        btnAggiungi.addEventListener('click', apriFormAggiungi);
    }
    if (btnAggiungiEmpty) {
        btnAggiungiEmpty.addEventListener('click', apriFormAggiungi);
    }
    if (formAnnulla) {
        formAnnulla.addEventListener('click', function() {
            formPopup.setAttribute('hidden', '');
        });
    }

    // ── CONFERMA ELIMINAZIONE CARTA ──
    // Stesso pattern già usato per l'eliminazione delle recensioni: window.confirm()
    // prima del submit nativo del form. Nessun fetch, nessun AJAX.
    document.querySelectorAll('.form-elimina-carta').forEach(function(f) {
        f.addEventListener('submit', function(e) {
            var msg = this.dataset.confirm || 'Confermi l\'eliminazione?';
            if (!window.confirm(msg)) {
                e.preventDefault();
            }
        });
    });

})();

<?php echo '</script'; ?>
>
<?php
}
}
/* {/block "extra_js"} */
}
