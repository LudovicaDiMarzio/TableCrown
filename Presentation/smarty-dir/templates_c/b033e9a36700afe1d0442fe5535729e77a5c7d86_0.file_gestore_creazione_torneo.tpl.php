<?php
/* Smarty version 5.8.0, created on 2026-07-21 20:57:29
  from 'file:gestore_creazione_torneo.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a5fc119042490_69924301',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b033e9a36700afe1d0442fe5535729e77a5c7d86' => 
    array (
      0 => 'gestore_creazione_torneo.tpl',
      1 => 1784555442,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a5fc119042490_69924301 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_13464021026a5fc119023c40_03294433', "page_css");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_20604964026a5fc1190272b1_05329741', "content");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "layout_gestore.tpl", $_smarty_current_dir);
}
/* {block "page_css"} */
class Block_13464021026a5fc119023c40_03294433 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

    <link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/css/gestore_creazione_evento.css">
<?php
}
}
/* {/block "page_css"} */
/* {block "content"} */
class Block_20604964026a5fc1190272b1_05329741 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>


<div class="gcre-container">

    <div class="gcre-header">
        <div>
            <h1 class="gcre-header__title">Nuovo Torneo</h1>
            <p class="gcre-header__subtitle">Compila i 3 step per pubblicare un nuovo torneo.</p>
        </div>
        <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/eventi/tornei" class="gcre-header__close">
            <i class="ti ti-x"></i> Annulla
        </a>
    </div>

    <div class="gcre-stepper" id="gcreStepper">
        <div class="gcre-stepper__item gcre-stepper__item--active" data-step-indicator="1">
            <div class="gcre-stepper__circle">1</div>
            <span class="gcre-stepper__label">Informazioni</span>
        </div>
        <div class="gcre-stepper__line"></div>
        <div class="gcre-stepper__item" data-step-indicator="2">
            <div class="gcre-stepper__circle">2</div>
            <span class="gcre-stepper__label">Data, capienza e quota</span>
        </div>
        <div class="gcre-stepper__line"></div>
        <div class="gcre-stepper__item" data-step-indicator="3">
            <div class="gcre-stepper__circle">3</div>
            <span class="gcre-stepper__label">Gioco e premio</span>
        </div>
    </div>

    <form id="formCreaTorneo" class="gcre-form-card" method="post" enctype="multipart/form-data"
          action="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/eventi/tornei/nuovo">

                <div class="gcre-step active" data-step="1">
            <h2 class="gcre-step__title">Informazioni generali</h2>
            <p class="gcre-step__subtitle">Nome, descrizione e immagine del torneo.</p>

            <div class="gcre-field-group" data-field="nomeEvento">
                <label class="gcre-label" for="nomeEvento">Nome del torneo</label>
                <input type="text" id="nomeEvento" name="nomeEvento" maxlength="255"
                       class="gcre-input" placeholder="Es. Torneo di Carcassonne" required>
                <span class="gcre-error">Inserisci un nome per il torneo.</span>
            </div>

            <div class="gcre-field-group" data-field="descrizioneEvento">
                <label class="gcre-label" for="descrizioneEvento">Descrizione</label>
                <textarea id="descrizioneEvento" name="descrizioneEvento" class="gcre-textarea"
                          placeholder="Regolamento, formula del torneo, premi..." required></textarea>
                <span class="gcre-error">Inserisci una descrizione.</span>
            </div>

            <div class="gcre-field-group" data-field="imgEvento">
                <label class="gcre-label">Immagine di copertina</label>
                <label class="gcre-upload-box" id="uploadBoxTorneo">
                    <img id="uploadPreviewTorneo" class="gcre-upload-box__preview" src="" alt="" style="display:none;">
                    <i class="ti ti-photo" id="uploadIconTorneo" style="font-size: 28px; color: var(--gestore-muted);"></i>
                    <div class="gcre-upload-box__text">
                        <span class="gcre-upload-box__title" id="uploadTextTorneo">Carica un'immagine</span>
                        <span class="gcre-upload-box__hint">PNG o JPG, consigliata almeno 800x450px</span>
                    </div>
                    <input type="file" name="imgEvento" id="imgEvento" accept="image/*" style="display:none;" required>
                </label>
                <span class="gcre-error">Carica un'immagine di copertina.</span>
            </div>
        </div>

                <div class="gcre-step" data-step="2">
            <h2 class="gcre-step__title">Data, capienza e quota</h2>
            <p class="gcre-step__subtitle">Quando si gioca, quanti posti ci sono e quanto costa iscriversi.</p>

            <div class="gcre-field-group" data-field="dataInizio_input">
                <label class="gcre-label" for="dataInizio_input">Data e ora di inizio</label>
                <input type="datetime-local" id="dataInizio_input" class="gcre-input" required>
                <input type="hidden" name="dataInizio" id="dataInizio">
                <span class="gcre-error">Seleziona una data valida.</span>
            </div>

            <div class="gcre-field-group" data-field="maxPartecipanti">
                <label class="gcre-label" for="maxPartecipanti">Numero massimo di partecipanti</label>
                <input type="number" id="maxPartecipanti" name="maxPartecipanti" class="gcre-input"
                       min="1" step="1" placeholder="Es. 16" required>
                <span class="gcre-error">Inserisci un numero valido (minimo 1).</span>
            </div>

            <div class="gcre-row">
                <div class="gcre-field-group" data-field="valoreQuota">
                    <label class="gcre-label" for="valoreQuota">Quota di iscrizione</label>
                    <input type="number" id="valoreQuota" name="valoreQuota" class="gcre-input"
                           min="0" step="0.01" placeholder="0.00" required>
                    <span class="gcre-error">Inserisci una quota valida (0 se gratuito).</span>
                </div>
                <div class="gcre-field-group" data-field="valuta">
                    <label class="gcre-label" for="valuta">Valuta</label>
                    <select id="valuta" name="valuta" class="gcre-select" required>
                        <?php if ((true && ($_smarty_tpl->hasVariable('valute_enum') && null !== ($_smarty_tpl->getValue('valute_enum') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('valute_enum')) > 0) {?>
                            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('valute_enum'), 'v');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('v')->value) {
$foreach0DoElse = false;
?>
                                <option value="<?php echo $_smarty_tpl->getValue('v')['value'];?>
"><?php echo $_smarty_tpl->getValue('v')['label'];?>
</option>
                            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                        <?php } else { ?>
                                                        <option value="eur">Euro (€)</option>
                            <option value="usd">Dollaro USA ($)</option>
                            <option value="gbp">Sterlina (£)</option>
                        <?php }?>
                    </select>
                    <span class="gcre-error">Seleziona una valuta.</span>
                </div>
            </div>
        </div>

                <div class="gcre-step" data-step="3">
            <h2 class="gcre-step__title">Gioco e premio</h2>
            <p class="gcre-step__subtitle">Su quale gioco si sfidano i partecipanti e cosa vince chi arriva primo.</p>

            <input type="hidden" name="idGioco" id="idGioco">
            <input type="hidden" name="idPremio" id="idPremio">

            <div class="gcre-field-group" data-field="idGioco">
                <label class="gcre-label">Gioco del torneo</label>
                <input type="search" class="gcre-input gcre-picker-search" id="searchGioco" placeholder="Cerca un gioco...">
                <div class="gcre-picker-grid" id="pickerGioco">
                    <?php if ((true && ($_smarty_tpl->hasVariable('giochiDisponibili') && null !== ($_smarty_tpl->getValue('giochiDisponibili') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('giochiDisponibili')) > 0) {?>
                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('giochiDisponibili'), 'gioco');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('gioco')->value) {
$foreach1DoElse = false;
?>
                            <div class="gcre-picker-card" data-id="<?php echo $_smarty_tpl->getValue('gioco')['id'];?>
" data-nome="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('gioco')['nome'], ENT_QUOTES, 'UTF-8', true);?>
">
                                <span class="gcre-picker-card__check"><i class="ti ti-check"></i></span>
                                <img class="gcre-picker-card__img" src="<?php echo $_smarty_tpl->getValue('gioco')['immagine'];?>
" alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('gioco')['nome'], ENT_QUOTES, 'UTF-8', true);?>
">
                                <span class="gcre-picker-card__name"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('gioco')['nome'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                            </div>
                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                    <?php } else { ?>
                        <div class="gcre-picker-empty">Nessun gioco disponibile nel catalogo.</div>
                    <?php }?>
                </div>
                <span class="gcre-error">Seleziona il gioco del torneo.</span>
            </div>

            <div class="gcre-field-group" data-field="idPremio">
                <label class="gcre-label">Premio per il vincitore</label>
                <input type="search" class="gcre-input gcre-picker-search" id="searchPremio" placeholder="Cerca un prodotto...">
                <div class="gcre-picker-grid" id="pickerPremio">
                    <?php if ((true && ($_smarty_tpl->hasVariable('premiDisponibili') && null !== ($_smarty_tpl->getValue('premiDisponibili') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('premiDisponibili')) > 0) {?>
                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('premiDisponibili'), 'prodotto');
$foreach2DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('prodotto')->value) {
$foreach2DoElse = false;
?>
                            <div class="gcre-picker-card" data-id="<?php echo $_smarty_tpl->getValue('prodotto')['id'];?>
" data-nome="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['nome'], ENT_QUOTES, 'UTF-8', true);?>
">
                                <span class="gcre-picker-card__check"><i class="ti ti-check"></i></span>
                                <img class="gcre-picker-card__img" src="<?php echo $_smarty_tpl->getValue('prodotto')['immagine'];?>
" alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['nome'], ENT_QUOTES, 'UTF-8', true);?>
">
                                <span class="gcre-picker-card__name"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['nome'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                            </div>
                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                    <?php } else { ?>
                        <div class="gcre-picker-empty">Nessun prodotto disponibile come premio.</div>
                    <?php }?>
                </div>
                <span class="gcre-error">Seleziona un premio.</span>
            </div>
        </div>

        <div class="gcre-nav">
            <button type="button" class="gcre-btn gcre-btn--ghost" id="btnBackTorneo" style="visibility:hidden;">
                <i class="ti ti-arrow-left"></i> Indietro
            </button>
            <button type="button" class="gcre-btn gcre-btn--primary" id="btnNextTorneo">
                Avanti <i class="ti ti-arrow-right"></i>
            </button>
        </div>
    </form>
</div>

<div class="gcre-overlay" id="overlayTorneo">
    <div class="gcre-modal">
        <div class="gcre-modal__header">
            <h3 class="gcre-modal__title">Rivedi il tuo torneo</h3>
            <p class="gcre-modal__subtitle">Controlla i dati prima di pubblicare.</p>
        </div>
        <div class="gcre-modal__body">
            <img class="gcre-modal__img" id="riepilogoImgTorneo" src="" alt="">
            <div class="gcre-summary-row">
                <span class="gcre-summary-label">Nome</span>
                <span class="gcre-summary-value" id="riepilogoNomeTorneo"></span>
            </div>
            <div class="gcre-summary-row">
                <span class="gcre-summary-label">Data e ora</span>
                <span class="gcre-summary-value" id="riepilogoDataTorneo"></span>
            </div>
            <div class="gcre-summary-row">
                <span class="gcre-summary-label">Partecipanti max</span>
                <span class="gcre-summary-value" id="riepilogoMaxTorneo"></span>
            </div>
            <div class="gcre-summary-row">
                <span class="gcre-summary-label">Quota iscrizione</span>
                <span class="gcre-summary-value" id="riepilogoQuotaTorneo"></span>
            </div>
            <div class="gcre-summary-row">
                <span class="gcre-summary-label">Gioco</span>
                <span class="gcre-summary-value" id="riepilogoGiocoTorneo"></span>
            </div>
            <div class="gcre-summary-row">
                <span class="gcre-summary-label">Premio</span>
                <span class="gcre-summary-value" id="riepilogoPremioTorneo"></span>
            </div>
        </div>
        <div class="gcre-modal__footer">
            <button type="button" class="gcre-btn gcre-btn--ghost" id="btnModificaTorneo">Modifica</button>
            <button type="button" class="gcre-btn gcre-btn--primary" id="btnCreaTorneo">
                <i class="ti ti-check"></i> Crea Torneo
            </button>
        </div>
    </div>

<?php echo '<script'; ?>
>
(function () {
    const form = document.getElementById('formCreaTorneo');
    const steps = Array.from(form.querySelectorAll('.gcre-step'));
    const stepperItems = Array.from(document.querySelectorAll('#gcreStepper .gcre-stepper__item'));
    const btnNext = document.getElementById('btnNextTorneo');
    const btnBack = document.getElementById('btnBackTorneo');
    let current = 1;

    function showStep(n) {
        steps.forEach(s => s.classList.toggle('active', parseInt(s.dataset.step) === n));
        stepperItems.forEach(item => {
            const idx = parseInt(item.dataset.stepIndicator);
            item.classList.toggle('gcre-stepper__item--active', idx === n);
            item.classList.toggle('gcre-stepper__item--done', idx < n);
        });
        btnBack.style.visibility = n === 1 ? 'hidden' : 'visible';
        btnNext.innerHTML = n === steps.length
            ? 'Rivedi e Crea <i class="ti ti-arrow-right"></i>'
            : 'Avanti <i class="ti ti-arrow-right"></i>';
        current = n;
    }

    function validateStep(n) {
        let valid = true;
        const stepEl = steps.find(s => parseInt(s.dataset.step) === n);
        stepEl.querySelectorAll('[data-field]').forEach(group => {
            const key = group.dataset.field;
            let ok = true;

            if (key === 'idGioco') {
                ok = document.getElementById('idGioco').value !== '';
            } else if (key === 'idPremio') {
                ok = document.getElementById('idPremio').value !== '';
            } else {
                const field = group.querySelector('input, textarea, select');
                if (field.type === 'file') {
                    ok = field.files && field.files.length > 0;
                } else {
                    ok = field.value.trim() !== '';
                    if (field.type === 'number' && ok) {
                        ok = parseFloat(field.value) >= parseFloat(field.min || '-Infinity');
                    }
                }
            }
            group.classList.toggle('has-error', !ok);
            if (!ok) valid = false;
        });
        return valid;
    }

    function syncDataInizio() {
        const raw = document.getElementById('dataInizio_input').value;
        if (raw) {
            document.getElementById('dataInizio').value = raw.replace('T', ' ') + ':00';
        }
    }

    btnNext.addEventListener('click', function () {
        if (!validateStep(current)) return;
        if (current === 3) {
            syncDataInizio();
            openRiepilogo();
            return;
        }
        showStep(current + 1);
    });

    btnBack.addEventListener('click', function () {
        if (current > 1) showStep(current - 1);
    });

    // Upload immagine con preview
    const imgInput = document.getElementById('imgEvento');
    imgInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const preview = document.getElementById('uploadPreviewTorneo');
        const icon = document.getElementById('uploadIconTorneo');
        const text = document.getElementById('uploadTextTorneo');
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = 'block';
            icon.style.display = 'none';
            text.textContent = file.name;
        };
        reader.readAsDataURL(file);
    });

    // Picker singola selezione (gioco / premio)
    function setupPicker(gridId, hiddenId, searchId) {
        const grid = document.getElementById(gridId);
        const hidden = document.getElementById(hiddenId);
        const search = document.getElementById(searchId);

        grid.querySelectorAll('.gcre-picker-card').forEach(card => {
            card.addEventListener('click', () => {
                grid.querySelectorAll('.gcre-picker-card').forEach(c => c.classList.remove('gcre-picker-card--selected'));
                card.classList.add('gcre-picker-card--selected');
                hidden.value = card.dataset.id;
            });
        });

        if (search) {
            search.addEventListener('input', () => {
                const q = search.value.trim().toLowerCase();
                grid.querySelectorAll('.gcre-picker-card').forEach(card => {
                    const match = card.dataset.nome.toLowerCase().includes(q);
                    card.style.display = match ? '' : 'none';
                });
            });
        }
    }
    setupPicker('pickerGioco', 'idGioco', 'searchGioco');
    setupPicker('pickerPremio', 'idPremio', 'searchPremio');

    // Riepilogo
    const overlay = document.getElementById('overlayTorneo');

    function openRiepilogo() {
        document.getElementById('riepilogoNomeTorneo').textContent = document.getElementById('nomeEvento').value;
        document.getElementById('riepilogoMaxTorneo').textContent = document.getElementById('maxPartecipanti').value;

        const quota = parseFloat(document.getElementById('valoreQuota').value || '0').toFixed(2);
        const valutaSelect = document.getElementById('valuta');
        const valutaLabel = valutaSelect.options[valutaSelect.selectedIndex]?.text || '';
        document.getElementById('riepilogoQuotaTorneo').textContent = quota + ' (' + valutaLabel + ')';

        const rawDate = document.getElementById('dataInizio_input').value;
        if (rawDate) {
            const d = new Date(rawDate);
            document.getElementById('riepilogoDataTorneo').textContent = d.toLocaleString('it-IT', {
                day: '2-digit', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit'
            });
        }

        const giocoCard = document.querySelector('#pickerGioco .gcre-picker-card--selected');
        document.getElementById('riepilogoGiocoTorneo').textContent = giocoCard ? giocoCard.dataset.nome : '';

        const premioCard = document.querySelector('#pickerPremio .gcre-picker-card--selected');
        document.getElementById('riepilogoPremioTorneo').textContent = premioCard ? premioCard.dataset.nome : '';

        const preview = document.getElementById('uploadPreviewTorneo');
        document.getElementById('riepilogoImgTorneo').src = preview.src || '';

        overlay.classList.add('active');
    }

    document.getElementById('btnModificaTorneo').addEventListener('click', () => overlay.classList.remove('active'));
    document.getElementById('btnCreaTorneo').addEventListener('click', () => {
        syncDataInizio();
        form.submit();
    });
})();
<?php echo '</script'; ?>
>
<?php
}
}
/* {/block "content"} */
}
