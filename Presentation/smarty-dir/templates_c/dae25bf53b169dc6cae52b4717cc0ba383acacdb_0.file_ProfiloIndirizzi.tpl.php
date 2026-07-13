<?php
/* Smarty version 5.8.0, created on 2026-07-13 11:08:51
  from 'file:ProfiloIndirizzi.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a54ab23e0bfb3_49208253',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'dae25bf53b169dc6cae52b4717cc0ba383acacdb' => 
    array (
      0 => 'ProfiloIndirizzi.tpl',
      1 => 1783933652,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a54ab23e0bfb3_49208253 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_16581682546a54ab23b35de6_12321153', "extra_css");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_2871701896a54ab23bcb0d7_77628023', "content");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_7432238226a54ab23e0a437_67991474', "extra_js");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "extra_css"} */
class Block_16581682546a54ab23b35de6_12321153 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

    <link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/css/ProfiloIndirizzi.css">
<?php
}
}
/* {/block "extra_css"} */
/* {block "content"} */
class Block_2871701896a54ab23bcb0d7_77628023 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<div class="indirizzi-container">
    <div class="container">

                <div class="indirizzi-topbar">
            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/account" class="indirizzi-back-link">
                <i class="ti ti-arrow-left"></i> Torna all'Area Personale
            </a>
        </div>

                <div class="indirizzi-header">
            <div class="indirizzi-header-text">
                <span class="indirizzi-eyebrow">Area Personale</span>
                <h1 class="indirizzi-titolo">
                    <i class="ti ti-map-pin"></i> I Miei Indirizzi
                </h1>
            </div>

            <div class="indirizzi-header-actions">
                <?php if ((true && ($_smarty_tpl->hasVariable('indirizzi') && null !== ($_smarty_tpl->getValue('indirizzi') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('indirizzi')) > 0) {?>
                    <div class="indirizzi-count-badge">
                        <span class="indirizzi-count-num"><?php echo $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('indirizzi'));?>
</span>
                        <span class="indirizzi-count-label"><?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('indirizzi')) == 1) {?>indirizzo<?php } else { ?>indirizzi<?php }?></span>
                    </div>
                <?php }?>

                <button type="button" class="indirizzi-add-btn" id="indirizzi-btn-aggiungi" title="Aggiungi nuovo indirizzo">
                    <i class="ti ti-plus"></i>
                </button>
            </div>
        </div>

                <?php if ((true && ($_smarty_tpl->hasVariable('indirizzi') && null !== ($_smarty_tpl->getValue('indirizzi') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('indirizzi')) > 0) {?>
            <div class="indirizzi-list" id="indirizzi-list">
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('indirizzi'), 'indirizzo');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('indirizzo')->value) {
$foreach0DoElse = false;
?>
                    <div class="indirizzi-card <?php if ($_smarty_tpl->getValue('indirizzo')['predefinito']) {?>indirizzi-card-predefinito<?php }?>" id="indirizzi-card-<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('indirizzo')['id'], ENT_QUOTES, 'UTF-8', true);?>
">

                        <div class="indirizzi-card-top">
                            <span class="indirizzi-nome"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('indirizzo')['nome'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                            <?php if ($_smarty_tpl->getValue('indirizzo')['predefinito']) {?>
                                <span class="indirizzi-predefinito-badge">
                                    <i class="ti ti-star-filled"></i> Predefinito
                                </span>
                            <?php }?>
                        </div>

                        <div class="indirizzi-info-list">
                            <div class="indirizzi-info-row">
                                <i class="ti ti-road"></i>
                                <span class="indirizzi-info-value"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('indirizzo')['via'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                            </div>
                            <div class="indirizzi-info-row">
                                <i class="ti ti-building"></i>
                                <span class="indirizzi-info-value"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('indirizzo')['citta'], ENT_QUOTES, 'UTF-8', true);?>
 (<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('indirizzo')['provincia'], ENT_QUOTES, 'UTF-8', true);?>
), <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('indirizzo')['cap'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                            </div>
                            <div class="indirizzi-info-row">
                                <i class="ti ti-flag"></i>
                                <span class="indirizzi-info-value"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('indirizzo')['nazione'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                            </div>
                            <?php if ((true && (true && null !== ($_smarty_tpl->getValue('indirizzo')['nomeCitofono'] ?? null))) && $_smarty_tpl->getValue('indirizzo')['nomeCitofono']) {?>
                                <div class="indirizzi-info-row">
                                    <i class="ti ti-bell"></i>
                                    <span class="indirizzi-info-value"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('indirizzo')['nomeCitofono'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                                </div>
                            <?php }?>
                        </div>

                        <div class="indirizzi-actions">
                            <button type="button"
                                    class="indirizzi-btn-secondary indirizzi-btn-modifica"
                                    data-id="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('indirizzo')['id'], ENT_QUOTES, 'UTF-8', true);?>
"
                                    data-nome="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('indirizzo')['nome'], ENT_QUOTES, 'UTF-8', true);?>
"
                                    data-via="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('indirizzo')['via'], ENT_QUOTES, 'UTF-8', true);?>
"
                                    data-citta="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('indirizzo')['citta'], ENT_QUOTES, 'UTF-8', true);?>
"
                                    data-cap="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('indirizzo')['cap'], ENT_QUOTES, 'UTF-8', true);?>
"
                                    data-provincia="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('indirizzo')['provincia'], ENT_QUOTES, 'UTF-8', true);?>
"
                                    data-nazione="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('indirizzo')['nazione'], ENT_QUOTES, 'UTF-8', true);?>
"
                                    data-nomecitofono="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('indirizzo')['nomeCitofono'], ENT_QUOTES, 'UTF-8', true);?>
">
                                <i class="ti ti-edit"></i> Modifica
                            </button>

                            <?php if (!$_smarty_tpl->getValue('indirizzo')['predefinito']) {?>
                                <button type="button" class="indirizzi-btn-predefinito" data-id="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('indirizzo')['id'], ENT_QUOTES, 'UTF-8', true);?>
">
                                    <i class="ti ti-star"></i> Imposta come predefinito
                                </button>
                            <?php }?>

                            <button type="button" class="indirizzi-btn-elimina" data-id="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('indirizzo')['id'], ENT_QUOTES, 'UTF-8', true);?>
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
                        <div class="indirizzi-empty" id="indirizzi-empty">
                <div class="indirizzi-empty-icon">
                    <i class="ti ti-map-pin-off"></i>
                </div>
                <h2 class="indirizzi-empty-titolo">Nessun indirizzo salvato</h2>
                <p class="indirizzi-empty-testo">Aggiungi il tuo primo indirizzo per velocizzare i tuoi prossimi ordini.</p>
                <button type="button" class="indirizzi-empty-btn" id="indirizzi-btn-aggiungi-empty">
                    <i class="ti ti-plus"></i> Aggiungi indirizzo
                </button>
            </div>
        <?php }?>

                <div class="indirizzi-popup-overlay" id="indirizzi-form-popup" hidden>
            <div class="indirizzi-popup-box">
                <h2 class="indirizzi-form-titolo" id="indirizzi-form-titolo">Aggiungi indirizzo</h2>

                <form id="indirizzi-form">
                    <input type="hidden" id="indirizzi-form-id" value="">

                    <div class="indirizzi-form-grid">
                        <div class="indirizzi-form-field indirizzi-form-field-full">
                            <label class="indirizzi-form-label" for="indirizzi-form-nome">Nome indirizzo</label>
                            <input type="text" class="indirizzi-form-input" id="indirizzi-form-nome" placeholder="Es. Casa, Ufficio" required>
                        </div>

                        <div class="indirizzi-form-field indirizzi-form-field-full">
                            <label class="indirizzi-form-label" for="indirizzi-form-via">Via e numero civico</label>
                            <input type="text" class="indirizzi-form-input" id="indirizzi-form-via" required>
                        </div>

                        <div class="indirizzi-form-field">
                            <label class="indirizzi-form-label" for="indirizzi-form-citta">Città</label>
                            <input type="text" class="indirizzi-form-input" id="indirizzi-form-citta" required>
                        </div>

                        <div class="indirizzi-form-field">
                            <label class="indirizzi-form-label" for="indirizzi-form-provincia">Provincia</label>
                            <input type="text" class="indirizzi-form-input" id="indirizzi-form-provincia" maxlength="2" required>
                        </div>

                        <div class="indirizzi-form-field">
                            <label class="indirizzi-form-label" for="indirizzi-form-cap">CAP</label>
                            <input type="text" class="indirizzi-form-input" id="indirizzi-form-cap" required>
                        </div>

                        <div class="indirizzi-form-field">
                            <label class="indirizzi-form-label" for="indirizzi-form-nazione">Nazione</label>
                            <input type="text" class="indirizzi-form-input" id="indirizzi-form-nazione" required>
                        </div>

                        <div class="indirizzi-form-field indirizzi-form-field-full">
                            <label class="indirizzi-form-label" for="indirizzi-form-citofono">Nome sul citofono</label>
                            <input type="text" class="indirizzi-form-input" id="indirizzi-form-citofono">
                        </div>
                    </div>

                    <p class="indirizzi-form-error" id="indirizzi-form-error"></p>

                    <div class="indirizzi-form-actions">
                        <button type="button" class="indirizzi-form-btn-secondary" id="indirizzi-form-annulla">Annulla</button>
                        <button type="submit" class="indirizzi-form-btn-primary" id="indirizzi-form-salva">Salva</button>
                    </div>
                </form>
            </div>
        </div>

                <div class="indirizzi-popup-overlay" id="indirizzi-elimina-popup" hidden>
            <div class="indirizzi-popup-box indirizzi-popup-box-confirm">
                <i class="ti ti-alert-triangle indirizzi-popup-icon"></i>
                <p class="indirizzi-popup-message">Sei sicuro di voler eliminare questo indirizzo?</p>

                <div class="indirizzi-popup-actions">
                    <button type="button" class="indirizzi-form-btn-secondary" id="indirizzi-elimina-indietro">Indietro</button>
                    <button type="button" class="indirizzi-form-btn-primary" id="indirizzi-elimina-conferma">Elimina</button>
                </div>
            </div>
        </div>

                <div class="indirizzi-popup-overlay" id="indirizzi-popup" hidden>
            <div class="indirizzi-popup-box indirizzi-popup-box-confirm">
                <i class="ti ti-alert-triangle indirizzi-popup-icon"></i>
                <p class="indirizzi-popup-message" id="indirizzi-popup-message"></p>
                <button type="button" class="indirizzi-form-btn-primary" id="indirizzi-popup-close">Chiudi</button>
            </div>
        </div>

    </div>
</div>
<?php
}
}
/* {/block "content"} */
/* {block "extra_js"} */
class Block_7432238226a54ab23e0a437_67991474 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<?php echo '<script'; ?>
>

(function() {

    // ── ELEMENTI POPUP MESSAGGI ──
    var popup        = document.getElementById('indirizzi-popup');
    var popupMessage = document.getElementById('indirizzi-popup-message');
    var popupClose    = document.getElementById('indirizzi-popup-close');

    function mostraPopup(messaggio) {
        popupMessage.textContent = messaggio;
        popup.removeAttribute('hidden');
    }

    if (popupClose) {
        popupClose.addEventListener('click', function() {
            popup.setAttribute('hidden', '');
        });
    }

    // ── ELEMENTI FORM (AGGIUNGI / MODIFICA) ──
    var formPopup   = document.getElementById('indirizzi-form-popup');
    var formTitolo  = document.getElementById('indirizzi-form-titolo');
    var form        = document.getElementById('indirizzi-form');
    var formError   = document.getElementById('indirizzi-form-error');
    var formAnnulla = document.getElementById('indirizzi-form-annulla');

    var campoId         = document.getElementById('indirizzi-form-id');
    var campoNome       = document.getElementById('indirizzi-form-nome');
    var campoVia        = document.getElementById('indirizzi-form-via');
    var campoCitta      = document.getElementById('indirizzi-form-citta');
    var campoProvincia  = document.getElementById('indirizzi-form-provincia');
    var campoCap        = document.getElementById('indirizzi-form-cap');
    var campoNazione    = document.getElementById('indirizzi-form-nazione');
    var campoCitofono   = document.getElementById('indirizzi-form-citofono');

    function resetForm() {
        campoId.value = '';
        campoNome.value = '';
        campoVia.value = '';
        campoCitta.value = '';
        campoProvincia.value = '';
        campoCap.value = '';
        campoNazione.value = '';
        campoCitofono.value = '';
        formError.textContent = '';
    }

    function apriFormAggiungi() {
        resetForm();
        formTitolo.textContent = 'Aggiungi indirizzo';
        formPopup.removeAttribute('hidden');
    }

    function apriFormModifica(btn) {
        resetForm();
        formTitolo.textContent = 'Modifica indirizzo';
        campoId.value = btn.getAttribute('data-id');
        campoNome.value = btn.getAttribute('data-nome');
        campoVia.value = btn.getAttribute('data-via');
        campoCitta.value = btn.getAttribute('data-citta');
        campoProvincia.value = btn.getAttribute('data-provincia');
        campoCap.value = btn.getAttribute('data-cap');
        campoNazione.value = btn.getAttribute('data-nazione');
        campoCitofono.value = btn.getAttribute('data-nomecitofono');
        formPopup.removeAttribute('hidden');
    }

    var btnAggiungi      = document.getElementById('indirizzi-btn-aggiungi');
    var btnAggiungiEmpty = document.getElementById('indirizzi-btn-aggiungi-empty');

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

    var list = document.getElementById('indirizzi-list');
    if (list) {
        list.addEventListener('click', function(e) {
            var modificaBtn = e.target.closest('.indirizzi-btn-modifica');
            if (modificaBtn) {
                apriFormModifica(modificaBtn);
            }
        });
    }

    // ── SALVATAGGIO FORM (AJAX) ──
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            formError.textContent = '';

            var payload = {
                id: campoId.value || null,
                nome: campoNome.value.trim(),
                via: campoVia.value.trim(),
                citta: campoCitta.value.trim(),
                provincia: campoProvincia.value.trim(),
                cap: campoCap.value.trim(),
                nazione: campoNazione.value.trim(),
                nomeCitofono: campoCitofono.value.trim()
            };

            if (!payload.nome || !payload.via || !payload.citta || !payload.provincia || !payload.cap || !payload.nazione) {
                formError.textContent = 'Compila tutti i campi obbligatori.';
                return;
            }

            fetch('<?php echo $_smarty_tpl->getValue('base_url');?>
/account/indirizzi/salva', {
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
                    formError.textContent = data.messaggio || 'Non è stato possibile salvare l\'indirizzo, riprova.';
                }
            })
            .catch(function() {
                formError.textContent = 'Si è verificato un errore di connessione, riprova più tardi.';
            });
        });
    }

    // ── ELIMINAZIONE (CONFERMA + AJAX) ──
    var eliminaPopup    = document.getElementById('indirizzi-elimina-popup');
    var eliminaIndietro = document.getElementById('indirizzi-elimina-indietro');
    var eliminaConferma = document.getElementById('indirizzi-elimina-conferma');
    var idDaEliminare     = null;

    if (list) {
        list.addEventListener('click', function(e) {
            var eliminaBtn = e.target.closest('.indirizzi-btn-elimina');
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

            fetch('<?php echo $_smarty_tpl->getValue('base_url');?>
/account/indirizzi/elimina', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                credentials: 'same-origin',
                body: JSON.stringify({ id: id })
            })
            .then(function(response) { return response.json(); })
            .then(function(data) {
                eliminaPopup.setAttribute('hidden', '');
                idDaEliminare = null;

                if (data.status === 'ok') {
                    window.location.reload();
                } else {
                    mostraPopup(data.messaggio || 'Non è stato possibile eliminare l\'indirizzo, riprova.');
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
    if (list) {
        list.addEventListener('click', function(e) {
            var predefinitoBtn = e.target.closest('.indirizzi-btn-predefinito');
            if (!predefinitoBtn) return;

            var id = predefinitoBtn.getAttribute('data-id');

            fetch('<?php echo $_smarty_tpl->getValue('base_url');?>
/account/indirizzi/predefinito', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                credentials: 'same-origin',
                body: JSON.stringify({ id: id })
            })
            .then(function(response) { return response.json(); })
            .then(function(data) {
                if (data.status === 'ok') {
                    window.location.reload();
                } else {
                    mostraPopup(data.messaggio || 'Non è stato possibile impostare l\'indirizzo come predefinito.');
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
