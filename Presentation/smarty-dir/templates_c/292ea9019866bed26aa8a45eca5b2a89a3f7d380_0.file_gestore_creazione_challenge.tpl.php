<?php
/* Smarty version 5.8.0, created on 2026-07-21 20:57:31
  from 'file:gestore_creazione_challenge.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a5fc11b2613b8_11404472',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '292ea9019866bed26aa8a45eca5b2a89a3f7d380' => 
    array (
      0 => 'gestore_creazione_challenge.tpl',
      1 => 1784555450,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a5fc11b2613b8_11404472 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_6708187836a5fc11b240e13_17018970', "page_css");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_8222240306a5fc11b2446e8_79651494', "content");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "layout_gestore.tpl", $_smarty_current_dir);
}
/* {block "page_css"} */
class Block_6708187836a5fc11b240e13_17018970 extends \Smarty\Runtime\Block
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
class Block_8222240306a5fc11b2446e8_79651494 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>


<div class="gcre-container">

    <div class="gcre-header">
        <div>
            <h1 class="gcre-header__title">Nuova Challenge</h1>
            <p class="gcre-header__subtitle">Compila i 3 step per pubblicare una nuova challenge.</p>
        </div>
        <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/eventi/challenge" class="gcre-header__close">
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
            <span class="gcre-stepper__label">Data, capienza e premio</span>
        </div>
        <div class="gcre-stepper__line"></div>
        <div class="gcre-stepper__item" data-step-indicator="3">
            <div class="gcre-stepper__circle">3</div>
            <span class="gcre-stepper__label">Punteggi e tornei</span>
        </div>
    </div>

    <form id="formCreaChallenge" class="gcre-form-card" method="post" enctype="multipart/form-data"
          action="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/eventi/challenge/nuovo">

                <div class="gcre-step active" data-step="1">
            <h2 class="gcre-step__title">Informazioni generali</h2>
            <p class="gcre-step__subtitle">Nome, descrizione e immagine della challenge.</p>

            <div class="gcre-field-group" data-field="nomeEvento">
                <label class="gcre-label" for="nomeEvento">Nome della challenge</label>
                <input type="text" id="nomeEvento" name="nomeEvento" maxlength="255"
                       class="gcre-input" placeholder="Es. Grand Prix Autunnale" required>
                <span class="gcre-error">Inserisci un nome per la challenge.</span>
            </div>

            <div class="gcre-field-group" data-field="descrizioneEvento">
                <label class="gcre-label" for="descrizioneEvento">Descrizione</label>
                <textarea id="descrizioneEvento" name="descrizioneEvento" class="gcre-textarea"
                          placeholder="Spiega come funziona la challenge e i tornei coinvolti..." required></textarea>
                <span class="gcre-error">Inserisci una descrizione.</span>
            </div>

            <div class="gcre-field-group" data-field="imgEvento">
                <label class="gcre-label">Immagine di copertina</label>
                <label class="gcre-upload-box" id="uploadBoxChallenge">
                    <img id="uploadPreviewChallenge" class="gcre-upload-box__preview" src="" alt="" style="display:none;">
                    <i class="ti ti-photo" id="uploadIconChallenge" style="font-size: 28px; color: var(--gestore-muted);"></i>
                    <div class="gcre-upload-box__text">
                        <span class="gcre-upload-box__title" id="uploadTextChallenge">Carica un'immagine</span>
                        <span class="gcre-upload-box__hint">PNG o JPG, consigliata almeno 800x450px</span>
                    </div>
                    <input type="file" name="imgEvento" id="imgEvento" accept="image/*" style="display:none;" required>
                </label>
                <span class="gcre-error">Carica un'immagine di copertina.</span>
            </div>
        </div>

                <div class="gcre-step" data-step="2">
            <h2 class="gcre-step__title">Data, capienza e premio</h2>
            <p class="gcre-step__subtitle">Quando inizia, quanti posti ci sono e cosa vince il primo classificato.</p>

            <div class="gcre-field-group" data-field="dataInizio_input">
                <label class="gcre-label" for="dataInizio_input">Data e ora di inizio</label>
                <input type="datetime-local" id="dataInizio_input" class="gcre-input" required>
                <input type="hidden" name="dataInizio" id="dataInizio">
                <span class="gcre-error">Seleziona una data valida.</span>
            </div>

            <div class="gcre-field-group" data-field="maxPartecipanti">
                <label class="gcre-label" for="maxPartecipanti">Numero massimo di partecipanti</label>
                <input type="number" id="maxPartecipanti" name="maxPartecipanti" class="gcre-input"
                       min="1" step="1" placeholder="Es. 32" required>
                <span class="gcre-error">Inserisci un numero valido (minimo 1).</span>
            </div>

            <div class="gcre-row">
                <div class="gcre-field-group" data-field="valoreQuota">
                    <label class="gcre-label" for="valoreQuota">Quota di iscrizione</label>
                    <input type="number" id="valoreQuota" name="valoreQuota" class="gcre-input"
                           min="0" step="0.01" placeholder="0.00" required>
                    <span class="gcre-error">Inserisci una quota valida (0 se gratuita).</span>
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

            <input type="hidden" name="idPremio" id="idPremio">
            <div class="gcre-field-group" data-field="idPremio">
                <label class="gcre-label">Premio per il vincitore della challenge</label>
                <input type="search" class="gcre-input gcre-picker-search" id="searchPremio" placeholder="Cerca un prodotto...">
                <div class="gcre-picker-grid" id="pickerPremio">
                    <?php if ((true && ($_smarty_tpl->hasVariable('premiDisponibili') && null !== ($_smarty_tpl->getValue('premiDisponibili') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('premiDisponibili')) > 0) {?>
                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('premiDisponibili'), 'prodotto');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('prodotto')->value) {
$foreach1DoElse = false;
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

                <div class="gcre-step" data-step="3">
            <h2 class="gcre-step__title">Punteggi e tornei collegati</h2>
            <p class="gcre-step__subtitle">Punti assegnati per posizione e i tornei (da 3 a 7) che compongono la challenge.</p>

            <div class="gcre-row">
                <div class="gcre-field-group" data-field="punteggioPrimoClassificato">
                    <label class="gcre-label" for="punteggioPrimoClassificato">Punti 1° classificato</label>
                    <input type="number" id="punteggioPrimoClassificato" name="punteggioPrimoClassificato"
                           class="gcre-input" min="1" step="1" placeholder="Es. 10" required>
                    <span class="gcre-error">Obbligatorio, deve essere maggiore del 2°.</span>
                </div>
                <div class="gcre-field-group" data-field="punteggioSecondoClassificato">
                    <label class="gcre-label" for="punteggioSecondoClassificato">Punti 2° classificato</label>
                    <input type="number" id="punteggioSecondoClassificato" name="punteggioSecondoClassificato"
                           class="gcre-input" min="1" step="1" placeholder="Es. 6" required>
                    <span class="gcre-error">Obbligatorio, deve essere maggiore del 3°.</span>
                </div>
            </div>

            <div class="gcre-field-group" data-field="punteggioTerzoClassificato" style="max-width: calc(50% - 8px);">
                <label class="gcre-label" for="punteggioTerzoClassificato">Punti 3° classificato</label>
                <input type="number" id="punteggioTerzoClassificato" name="punteggioTerzoClassificato"
                       class="gcre-input" min="0" step="1" placeholder="Es. 3" required>
                <span class="gcre-error">Obbligatorio, deve essere inferiore al 2°.</span>
            </div>

            <div class="gcre-field-group" data-field="idTorneiSelezionati">
                <label class="gcre-label">Tornei della challenge</label>
                <span class="gcre-picker-counter" id="torneiCounter">0 / 7 selezionati (minimo 3)</span>
                <input type="search" class="gcre-input gcre-picker-search" id="searchTorneo" placeholder="Cerca un torneo...">
                <div class="gcre-picker-grid" id="pickerTornei">
                    <?php if ((true && ($_smarty_tpl->hasVariable('torneiDisponibili') && null !== ($_smarty_tpl->getValue('torneiDisponibili') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('torneiDisponibili')) > 0) {?>
                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('torneiDisponibili'), 'torneo');
$foreach2DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('torneo')->value) {
$foreach2DoElse = false;
?>
                            <div class="gcre-picker-card" data-id="<?php echo $_smarty_tpl->getValue('torneo')['idEvento'];?>
" data-nome="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('torneo')['nomeEvento'], ENT_QUOTES, 'UTF-8', true);?>
">
                                <span class="gcre-picker-card__check"><i class="ti ti-check"></i></span>
                                <?php if ((true && (true && null !== ($_smarty_tpl->getValue('torneo')['imgEvento'] ?? null)))) {?>
                                    <img class="gcre-picker-card__img" src="<?php echo $_smarty_tpl->getValue('torneo')['imgEvento'];?>
" alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('torneo')['nomeEvento'], ENT_QUOTES, 'UTF-8', true);?>
">
                                <?php }?>
                                <span class="gcre-picker-card__name"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('torneo')['nomeEvento'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                                <?php if ((true && (true && null !== ($_smarty_tpl->getValue('torneo')['gioco'] ?? null)))) {?>
                                    <span class="gcre-picker-card__meta"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('torneo')['gioco'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                                <?php }?>
                            </div>
                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                    <?php } else { ?>
                        <div class="gcre-picker-empty">Nessun torneo libero disponibile (crea prima almeno 3 tornei non assegnati).</div>
                    <?php }?>
                </div>
                <span class="gcre-error" id="torneiError">Seleziona da 3 a 7 tornei.</span>
            </div>
        </div>

        <div class="gcre-nav">
            <button type="button" class="gcre-btn gcre-btn--ghost" id="btnBackChallenge" style="visibility:hidden;">
                <i class="ti ti-arrow-left"></i> Indietro
            </button>
            <button type="button" class="gcre-btn gcre-btn--primary" id="btnNextChallenge">
                Avanti <i class="ti ti-arrow-right"></i>
            </button>
        </div>
    </form>
</div>

<div class="gcre-overlay" id="overlayChallenge">
    <div class="gcre-modal">
        <div class="gcre-modal__header">
            <h3 class="gcre-modal__title">Rivedi la tua challenge</h3>
            <p class="gcre-modal__subtitle">Controlla i dati prima di pubblicare.</p>
        </div>
        <div class="gcre-modal__body">
            <img class="gcre-modal__img" id="riepilogoImgChallenge" src="" alt="">
            <div class="gcre-summary-row">
                <span class="gcre-summary-label">Nome</span>
                <span class="gcre-summary-value" id="riepilogoNomeChallenge"></span>
            </div>
            <div class="gcre-summary-row">
                <span class="gcre-summary-label">Data e ora</span>
                <span class="gcre-summary-value" id="riepilogoDataChallenge"></span>
            </div>
            <div class="gcre-summary-row">
                <span class="gcre-summary-label">Partecipanti max</span>
                <span class="gcre-summary-value" id="riepilogoMaxChallenge"></span>
            </div>
            <div class="gcre-summary-row">
                <span class="gcre-summary-label">Quota iscrizione</span>
                <span class="gcre-summary-value" id="riepilogoQuotaChallenge"></span>
            </div>
            <div class="gcre-summary-row">
                <span class="gcre-summary-label">Premio</span>
                <span class="gcre-summary-value" id="riepilogoPremioChallenge"></span>
            </div>
            <div class="gcre-summary-row">
                <span class="gcre-summary-label">Punteggi (1° / 2° / 3°)</span>
                <span class="gcre-summary-value" id="riepilogoPuntiChallenge"></span>
            </div>
            <div class="gcre-summary-row">
                <span class="gcre-summary-label">Tornei collegati</span>
                <div class="gcre-summary-tags" id="riepilogoTorneiChallenge"></div>
            </div>
        </div>
        <div class="gcre-modal__footer">
            <button type="button" class="gcre-btn gcre-btn--ghost" id="btnModificaChallenge">Modifica</button>
            <button type="button" class="gcre-btn gcre-btn--primary" id="btnCreaChallenge">
                <i class="ti ti-check"></i> Crea Challenge
            </button>
        </div>
    </div>

<?php echo '<script'; ?>
>
(function () {
    const form = document.getElementById('formCreaChallenge');
    const steps = Array.from(form.querySelectorAll('.gcre-step'));
    const stepperItems = Array.from(document.querySelectorAll('#gcreStepper .gcre-stepper__item'));
    const btnNext = document.getElementById('btnNextChallenge');
    const btnBack = document.getElementById('btnBackChallenge');
    let current = 1;
    const MIN_TORNEI = 3;
    const MAX_TORNEI = 7;

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

            if (key === 'idPremio') {
                ok = document.getElementById('idPremio').value !== '';
            } else if (key === 'idTorneiSelezionati') {
                const n = getSelectedTornei().length;
                ok = n >= MIN_TORNEI && n <= MAX_TORNEI;
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

        // Regola aggiuntiva: primo > secondo > terzo (verificaPunteggi() lato entity)
        if (n === 3) {
            const p1 = parseFloat(document.getElementById('punteggioPrimoClassificato').value || '-1');
            const p2 = parseFloat(document.getElementById('punteggioSecondoClassificato').value || '-1');
            const p3 = parseFloat(document.getElementById('punteggioTerzoClassificato').value || '-1');
            const ordineOk = p1 > p2 && p2 > p3;
            ['punteggioPrimoClassificato', 'punteggioSecondoClassificato', 'punteggioTerzoClassificato'].forEach(id => {
                document.querySelector('[data-field="' + id + '"]').classList.toggle('has-error', !ordineOk);
            });
            if (!ordineOk) valid = false;
        }

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
        const preview = document.getElementById('uploadPreviewChallenge');
        const icon = document.getElementById('uploadIconChallenge');
        const text = document.getElementById('uploadTextChallenge');
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = 'block';
            icon.style.display = 'none';
            text.textContent = file.name;
        };
        reader.readAsDataURL(file);
    });

    // Picker premio (singola selezione)
    const pickerPremio = document.getElementById('pickerPremio');
    const idPremioHidden = document.getElementById('idPremio');
    pickerPremio.querySelectorAll('.gcre-picker-card').forEach(card => {
        card.addEventListener('click', () => {
            pickerPremio.querySelectorAll('.gcre-picker-card').forEach(c => c.classList.remove('gcre-picker-card--selected'));
            card.classList.add('gcre-picker-card--selected');
            idPremioHidden.value = card.dataset.id;
        });
    });
    document.getElementById('searchPremio').addEventListener('input', function () {
        const q = this.value.trim().toLowerCase();
        pickerPremio.querySelectorAll('.gcre-picker-card').forEach(card => {
            card.style.display = card.dataset.nome.toLowerCase().includes(q) ? '' : 'none';
        });
    });

    // Picker tornei (selezione multipla, min 3 - max 7)
    const pickerTornei = document.getElementById('pickerTornei');
    const counterEl = document.getElementById('torneiCounter');

    function getSelectedTornei() {
        return Array.from(pickerTornei.querySelectorAll('.gcre-picker-card--selected'));
    }

    function updateTorneiCounter() {
        const n = getSelectedTornei().length;
        counterEl.textContent = n + ' / ' + MAX_TORNEI + ' selezionati (minimo ' + MIN_TORNEI + ')';
        counterEl.classList.toggle('gcre-picker-counter--ok', n >= MIN_TORNEI && n <= MAX_TORNEI);
    }

    pickerTornei.querySelectorAll('.gcre-picker-card').forEach(card => {
        card.addEventListener('click', () => {
            const selected = getSelectedTornei();
            const isSelected = card.classList.contains('gcre-picker-card--selected');

            if (!isSelected && selected.length >= MAX_TORNEI) {
                return; // limite massimo raggiunto
            }

            card.classList.toggle('gcre-picker-card--selected');
            syncTorneiHiddenInputs();
            updateTorneiCounter();
        });
    });

    document.getElementById('searchTorneo').addEventListener('input', function () {
        const q = this.value.trim().toLowerCase();
        pickerTornei.querySelectorAll('.gcre-picker-card').forEach(card => {
            card.style.display = card.dataset.nome.toLowerCase().includes(q) ? '' : 'none';
        });
    });

    function syncTorneiHiddenInputs() {
        form.querySelectorAll('input[name="idTorneiSelezionati[]"]').forEach(el => el.remove());
        getSelectedTornei().forEach(card => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'idTorneiSelezionati[]';
            input.value = card.dataset.id;
            form.appendChild(input);
        });
    }

    updateTorneiCounter();

    // Riepilogo
    const overlay = document.getElementById('overlayChallenge');

    function openRiepilogo() {
        document.getElementById('riepilogoNomeChallenge').textContent = document.getElementById('nomeEvento').value;
        document.getElementById('riepilogoMaxChallenge').textContent = document.getElementById('maxPartecipanti').value;

        const quota = parseFloat(document.getElementById('valoreQuota').value || '0').toFixed(2);
        const valutaSelect = document.getElementById('valuta');
        const valutaLabel = valutaSelect.options[valutaSelect.selectedIndex]?.text || '';
        document.getElementById('riepilogoQuotaChallenge').textContent = quota + ' (' + valutaLabel + ')';

        const rawDate = document.getElementById('dataInizio_input').value;
        if (rawDate) {
            const d = new Date(rawDate);
            document.getElementById('riepilogoDataChallenge').textContent = d.toLocaleString('it-IT', {
                day: '2-digit', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit'
            });
        }

        const premioCard = document.querySelector('#pickerPremio .gcre-picker-card--selected');
        document.getElementById('riepilogoPremioChallenge').textContent = premioCard ? premioCard.dataset.nome : '';

        const p1 = document.getElementById('punteggioPrimoClassificato').value;
        const p2 = document.getElementById('punteggioSecondoClassificato').value;
        const p3 = document.getElementById('punteggioTerzoClassificato').value;
        document.getElementById('riepilogoPuntiChallenge').textContent = p1 + ' / ' + p2 + ' / ' + p3;

        const tagsContainer = document.getElementById('riepilogoTorneiChallenge');
        tagsContainer.innerHTML = '';
        getSelectedTornei().forEach(card => {
            const tag = document.createElement('span');
            tag.className = 'gcre-summary-tag';
            tag.textContent = card.dataset.nome;
            tagsContainer.appendChild(tag);
        });

        const preview = document.getElementById('uploadPreviewChallenge');
        document.getElementById('riepilogoImgChallenge').src = preview.src || '';

        overlay.classList.add('active');
    }

    document.getElementById('btnModificaChallenge').addEventListener('click', () => overlay.classList.remove('active'));
    document.getElementById('btnCreaChallenge').addEventListener('click', () => {
        syncDataInizio();
        syncTorneiHiddenInputs();
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
