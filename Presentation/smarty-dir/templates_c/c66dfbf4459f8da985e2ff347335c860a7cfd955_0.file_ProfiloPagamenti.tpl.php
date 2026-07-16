<?php
/* Smarty version 5.8.0, created on 2026-07-16 18:20:00
  from 'file:ProfiloPagamenti.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a5904b0cb3cd9_67122650',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c66dfbf4459f8da985e2ff347335c860a7cfd955' => 
    array (
      0 => 'ProfiloPagamenti.tpl',
      1 => 1784218798,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a5904b0cb3cd9_67122650 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_4574979146a5904b0c95c48_75862242', "extra_css");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_4166981256a5904b0c99b61_92281576', "content");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_2133423316a5904b0cb2900_81682645', "extra_js");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "extra_css"} */
class Block_4574979146a5904b0c95c48_75862242 extends \Smarty\Runtime\Block
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
class Block_4166981256a5904b0c99b61_92281576 extends \Smarty\Runtime\Block
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
                <?php if ((true && ($_smarty_tpl->hasVariable('carte') && null !== ($_smarty_tpl->getValue('carte') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('carte')) > 0) {?>
                    <div class="pagamenti-count-badge">
                        <span class="pagamenti-count-num"><?php echo $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('carte'));?>
</span>
                        <span class="pagamenti-count-label"><?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('carte')) == 1) {?>carta<?php } else { ?>carte<?php }?></span>
                    </div>
                <?php }?>

                <button type="button" class="pagamenti-add-btn" id="pagamenti-btn-aggiungi" title="Aggiungi nuova carta">
                    <i class="ti ti-plus"></i>
                </button>
            </div>
        </div>

                <?php if ((true && ($_smarty_tpl->hasVariable('carte') && null !== ($_smarty_tpl->getValue('carte') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('carte')) > 0) {?>
            <div class="pagamenti-list" id="pagamenti-list">
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('carte'), 'carta');
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
                            <?php if (!(true && (true && null !== ($_smarty_tpl->getValue('carta')['predefinito'] ?? null))) || !$_smarty_tpl->getValue('carta')['predefinito']) {?>
                                <button type="button" class="pagamenti-btn-predefinito" data-id="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('carta')['id'], ENT_QUOTES, 'UTF-8', true);?>
">
                                    <i class="ti ti-star"></i> Imposta come predefinito
                                </button>
                            <?php }?>

                            <button type="button" class="pagamenti-btn-elimina" data-id="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('carta')['id'], ENT_QUOTES, 'UTF-8', true);?>
">
                                <i class="ti ti-trash"></i> Elimina
                            </button>
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

                <form id="pagamenti-form">
                    <div class="pagamenti-form-grid">
                        <div class="pagamenti-form-field pagamenti-form-field-full">
                            <label class="pagamenti-form-label" for="pagamenti-form-numero">Numero carta</label>
                            <input type="text" class="pagamenti-form-input" id="pagamenti-form-numero" inputmode="numeric" autocomplete="cc-number" placeholder="0000 0000 0000 0000" maxlength="19" required>
                        </div>

                        <div class="pagamenti-form-field pagamenti-form-field-full">
                            <label class="pagamenti-form-label" for="pagamenti-form-titolare">Titolare della carta</label>
                            <input type="text" class="pagamenti-form-input" id="pagamenti-form-titolare" autocomplete="cc-name" required>
                        </div>

                        <div class="pagamenti-form-field">
                            <label class="pagamenti-form-label" for="pagamenti-form-scadenza">Scadenza (MM/AA)</label>
                            <input type="text" class="pagamenti-form-input" id="pagamenti-form-scadenza" autocomplete="cc-exp" placeholder="MM/AA" maxlength="5" required>
                        </div>

                        <div class="pagamenti-form-field">
                            <label class="pagamenti-form-label" for="pagamenti-form-cvv">CVV</label>
                            <input type="text" class="pagamenti-form-input" id="pagamenti-form-cvv" inputmode="numeric" autocomplete="cc-csc" maxlength="4" required>
                        </div>
                    </div>

                    <p class="pagamenti-form-error" id="pagamenti-form-error"></p>

                    <div class="pagamenti-form-actions">
                        <button type="button" class="pagamenti-form-btn-secondary" id="pagamenti-form-annulla">Annulla</button>
                        <button type="submit" class="pagamenti-form-btn-primary" id="pagamenti-form-salva">Salva</button>
                    </div>
                </form>
            </div>
        </div>

                <div class="pagamenti-popup-overlay" id="pagamenti-elimina-popup" hidden>
            <div class="pagamenti-popup-box pagamenti-popup-box-confirm">
                <i class="ti ti-alert-triangle pagamenti-popup-icon"></i>
                <p class="pagamenti-popup-message">Sei sicuro di voler eliminare questo metodo di pagamento?</p>

                <div class="pagamenti-popup-actions">
                    <button type="button" class="pagamenti-form-btn-secondary" id="pagamenti-elimina-indietro">Indietro</button>
                    <button type="button" class="pagamenti-form-btn-primary" id="pagamenti-elimina-conferma">Elimina</button>
                </div>
            </div>
        </div>

                <div class="pagamenti-popup-overlay" id="pagamenti-popup" hidden>
            <div class="pagamenti-popup-box pagamenti-popup-box-confirm">
                <i class="ti ti-alert-triangle pagamenti-popup-icon"></i>
                <p class="pagamenti-popup-message" id="pagamenti-popup-message"></p>
                <button type="button" class="pagamenti-form-btn-primary" id="pagamenti-popup-close">Chiudi</button>
            </div>
        </div>

    </div>
</div>
<?php
}
}
/* {/block "content"} */
/* {block "extra_js"} */
class Block_2133423316a5904b0cb2900_81682645 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<?php echo '<script'; ?>
>

(function() {

    var popup        = document.getElementById('pagamenti-popup');
    var popupMessage = document.getElementById('pagamenti-popup-message');
    var popupClose    = document.getElementById('pagamenti-popup-close');

    function mostraPopup(messaggio) {
        popupMessage.textContent = messaggio;
        popup.removeAttribute('hidden');
    }

    if (popupClose) {
        popupClose.addEventListener('click', function() {
            popup.setAttribute('hidden', '');
        });
    }

    var formPopup   = document.getElementById('pagamenti-form-popup');
    var form        = document.getElementById('pagamenti-form');
    var formError   = document.getElementById('pagamenti-form-error');
    var formAnnulla = document.getElementById('pagamenti-form-annulla');

    var campoNumero    = document.getElementById('pagamenti-form-numero');
    var campoTitolare  = document.getElementById('pagamenti-form-titolare');
    var campoScadenza  = document.getElementById('pagamenti-form-scadenza');
    var campoCvv       = document.getElementById('pagamenti-form-cvv');

    function resetForm() {
        campoNumero.value = '';
        campoTitolare.value = '';
        campoScadenza.value = '';
        campoCvv.value = '';
        formError.textContent = '';
    }

    function apriFormAggiungi() {
        resetForm();
        formPopup.removeAttribute('hidden');
    }

    var btnAggiungi      = document.getElementById('pagamenti-btn-aggiungi');
    var btnAggiungiEmpty = document.getElementById('pagamenti-btn-aggiungi-empty');

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

    var list = document.getElementById('pagamenti-list');

    // ── SALVATAGGIO FORM (AJAX): solo aggiunta ──
    // Chiavi payload allineate a CMetodiPagamento::aggiungiCarta() (UHTTPMethods::postString)
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            formError.textContent = '';

            var payload = {
                numero_carta: campoNumero.value.trim(),
                titolare_carta: campoTitolare.value.trim(),
                scadenza_carta: campoScadenza.value.trim(),
                cvv: campoCvv.value.trim()
            };

            if (!payload.numero_carta || !payload.titolare_carta || !payload.scadenza_carta || !payload.cvv) {
                formError.textContent = 'Compila tutti i campi obbligatori.';
                return;
            }

            fetch('<?php echo $_smarty_tpl->getValue('base_url');?>
/pagamenti/aggiungi', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                credentials: 'same-origin',
                body: JSON.stringify(payload)
            })
            .then(function(response) { return response.json(); })
            .then(function(data) {
                if (data.status === 'ok') {
                    window.location.reload();
                } else {
                    formError.textContent = data.message || 'Non è stato possibile salvare la carta, riprova.';
                }
            })
            .catch(function() {
                formError.textContent = 'Si è verificato un errore di connessione, riprova più tardi.';
            });
        });
    }

    // ── ELIMINAZIONE (CONFERMA + AJAX) ──
    var eliminaPopup    = document.getElementById('pagamenti-elimina-popup');
    var eliminaIndietro = document.getElementById('pagamenti-elimina-indietro');
    var eliminaConferma = document.getElementById('pagamenti-elimina-conferma');
    var idDaEliminare     = null;

    if (list) {
        list.addEventListener('click', function(e) {
            var eliminaBtn = e.target.closest('.pagamenti-btn-elimina');
            if (eliminaBtn) {
                idDaEliminare = eliminaBtn.getAttribute('data-id');
                eliminaPopup.removeAttribute('hidden');
            }
        });
    }

    if (eliminaIndietro) {
        eliminaIndietro.addEventListener('click', function() {
            idDaEliminare = null;
            eliminaPopup.setAttribute('hidden', '');
        });
    }

    if (eliminaConferma) {
        eliminaConferma.addEventListener('click', function() {
            if (!idDaEliminare) return;

            var id = idDaEliminare;

            // Chiave payload allineata a CMetodiPagamento::eliminaCarta() (UHTTPMethods::postInt('id_carta'))
            fetch('<?php echo $_smarty_tpl->getValue('base_url');?>
/pagamenti/elimina', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                credentials: 'same-origin',
                body: JSON.stringify({ id_carta: id })
            })
            .then(function(response) { return response.json(); })
            .then(function(data) {
                eliminaPopup.setAttribute('hidden', '');
                idDaEliminare = null;

                if (data.status === 'ok') {
                    window.location.reload();
                } else {
                    mostraPopup(data.message || 'Non è stato possibile eliminare la carta, riprova.');
                }
            })
            .catch(function() {
                eliminaPopup.setAttribute('hidden', '');
                idDaEliminare = null;
                mostraPopup('Si è verificato un errore di connessione, riprova più tardi.');
            });
        });
    }

    // ── IMPOSTA COME PREDEFINITO (AJAX) ──
    // ATTENZIONE: endpoint /pagamenti/predefinito non ancora implementato in CMetodiPagamento.
    // Da aggiungere lato Control (+ campo 'predefinito' in cartaToArray()) prima del merge.
    if (list) {
        list.addEventListener('click', function(e) {
            var predefinitoBtn = e.target.closest('.pagamenti-btn-predefinito');
            if (!predefinitoBtn) return;

            var id = predefinitoBtn.getAttribute('data-id');

            fetch('<?php echo $_smarty_tpl->getValue('base_url');?>
/pagamenti/predefinito', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                credentials: 'same-origin',
                body: JSON.stringify({ id_carta: id })
            })
            .then(function(response) { return response.json(); })
            .then(function(data) {
                if (data.status === 'ok') {
                    window.location.reload();
                } else {
                    mostraPopup(data.message || 'Non è stato possibile impostare la carta come predefinita.');
                }
            })
            .catch(function() {
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
