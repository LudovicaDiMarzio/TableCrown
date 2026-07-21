<?php
/* Smarty version 5.8.0, created on 2026-07-21 20:57:26
  from 'file:gestore_creazione_serata.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a5fc116ac0228_72187664',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3e3ce6aeb9831c5b551be359ae2fcb288565f568' => 
    array (
      0 => 'gestore_creazione_serata.tpl',
      1 => 1784555438,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a5fc116ac0228_72187664 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_18987282176a5fc116ab9486_22462450', "page_css");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_14683945666a5fc116abcae6_27618375', "content");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "layout_gestore.tpl", $_smarty_current_dir);
}
/* {block "page_css"} */
class Block_18987282176a5fc116ab9486_22462450 extends \Smarty\Runtime\Block
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
class Block_14683945666a5fc116abcae6_27618375 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>


<div class="gcre-container">

    <div class="gcre-header">
        <div>
            <h1 class="gcre-header__title">Nuova Serata</h1>
            <p class="gcre-header__subtitle">Compila i 3 step per pubblicare una nuova serata.</p>
        </div>
        <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/eventi/serate" class="gcre-header__close">
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
            <span class="gcre-stepper__label">Immagine e capienza</span>
        </div>
        <div class="gcre-stepper__line"></div>
        <div class="gcre-stepper__item" data-step-indicator="3">
            <div class="gcre-stepper__circle">3</div>
            <span class="gcre-stepper__label">Data e tipo</span>
        </div>
    </div>

    <form id="formCreaSerata" class="gcre-form-card" method="post" enctype="multipart/form-data"
          action="<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/eventi/serate/nuovo">

                <div class="gcre-step active" data-step="1">
            <h2 class="gcre-step__title">Informazioni generali</h2>
            <p class="gcre-step__subtitle">Nome e descrizione della serata.</p>

            <div class="gcre-field-group" data-field="nomeEvento">
                <label class="gcre-label" for="nomeEvento">Nome della serata</label>
                <input type="text" id="nomeEvento" name="nomeEvento" maxlength="255"
                       class="gcre-input" placeholder="Es. Quiz Night da Tavolo" required>
                <span class="gcre-error">Inserisci un nome per la serata.</span>
            </div>

            <div class="gcre-field-group" data-field="descrizioneEvento">
                <label class="gcre-label" for="descrizioneEvento">Descrizione</label>
                <textarea id="descrizioneEvento" name="descrizioneEvento" class="gcre-textarea"
                          placeholder="Racconta ai partecipanti cosa troveranno..." required></textarea>
                <span class="gcre-error">Inserisci una descrizione.</span>
            </div>
        </div>

                <div class="gcre-step" data-step="2">
            <h2 class="gcre-step__title">Immagine e capienza</h2>
            <p class="gcre-step__subtitle">Copertina della serata e numero massimo di partecipanti.</p>

            <div class="gcre-field-group" data-field="imgEvento">
                <label class="gcre-label">Immagine di copertina</label>
                <label class="gcre-upload-box" id="uploadBoxSerata">
                    <img id="uploadPreviewSerata" class="gcre-upload-box__preview" src="" alt="" style="display:none;">
                    <i class="ti ti-photo" id="uploadIconSerata" style="font-size: 28px; color: var(--gestore-muted);"></i>
                    <div class="gcre-upload-box__text">
                        <span class="gcre-upload-box__title" id="uploadTextSerata">Carica un'immagine</span>
                        <span class="gcre-upload-box__hint">PNG o JPG, consigliata almeno 800x450px</span>
                    </div>
                    <input type="file" name="imgEvento" id="imgEvento" accept="image/*" style="display:none;" required>
                </label>
                <span class="gcre-error">Carica un'immagine di copertina.</span>
            </div>

            <div class="gcre-field-group" data-field="maxPartecipanti">
                <label class="gcre-label" for="maxPartecipanti">Numero massimo di partecipanti</label>
                <input type="number" id="maxPartecipanti" name="maxPartecipanti" class="gcre-input"
                       min="1" step="1" placeholder="Es. 20" required>
                <span class="gcre-error">Inserisci un numero valido (minimo 1).</span>
            </div>
        </div>

                <div class="gcre-step" data-step="3">
            <h2 class="gcre-step__title">Data e tipologia</h2>
            <p class="gcre-step__subtitle">Quando si terrà la serata e di che tipo è.</p>

            <div class="gcre-field-group" data-field="dataInizio_input">
                <label class="gcre-label" for="dataInizio_input">Data e ora di inizio</label>
                <input type="datetime-local" id="dataInizio_input" class="gcre-input" required>
                <input type="hidden" name="dataInizio" id="dataInizio">
                <span class="gcre-error">Seleziona una data valida.</span>
            </div>

            <div class="gcre-field-group" data-field="tipoSerata">
                <label class="gcre-label" for="tipoSerata">Tipo di serata</label>
                <input type="text" id="tipoSerata" name="tipoSerata" class="gcre-input"
                       list="tipiSerataSuggeriti" placeholder="Es. Quiz a tema" required>
                <datalist id="tipiSerataSuggeriti">
                    <option value="Quiz a tema">
                    <option value="Serata Giochi Cooperativi">
                    <option value="Gioco Libero">
                    <option value="Presentazione Novità">
                    <option value="Torneo Amichevole">
                </datalist>
                <span class="gcre-hint">Puoi scegliere un suggerimento o scriverne uno tuo.</span>
                <span class="gcre-error">Indica il tipo di serata.</span>
            </div>
        </div>

                <div class="gcre-nav">
            <button type="button" class="gcre-btn gcre-btn--ghost" id="btnBackSerata" style="visibility:hidden;">
                <i class="ti ti-arrow-left"></i> Indietro
            </button>
            <button type="button" class="gcre-btn gcre-btn--primary" id="btnNextSerata">
                Avanti <i class="ti ti-arrow-right"></i>
            </button>
        </div>
    </form>
</div>

<div class="gcre-overlay" id="overlaySerata">
    <div class="gcre-modal">
        <div class="gcre-modal__header">
            <h3 class="gcre-modal__title">Rivedi la tua serata</h3>
            <p class="gcre-modal__subtitle">Controlla i dati prima di pubblicare.</p>
        </div>
        <div class="gcre-modal__body">
            <img class="gcre-modal__img" id="riepilogoImgSerata" src="" alt="">
            <div class="gcre-summary-row">
                <span class="gcre-summary-label">Nome</span>
                <span class="gcre-summary-value" id="riepilogoNomeSerata"></span>
            </div>
            <div class="gcre-summary-row">
                <span class="gcre-summary-label">Descrizione</span>
                <span class="gcre-summary-value" id="riepilogoDescSerata"></span>
            </div>
            <div class="gcre-summary-row">
                <span class="gcre-summary-label">Tipo</span>
                <span class="gcre-summary-value" id="riepilogoTipoSerata"></span>
            </div>
            <div class="gcre-summary-row">
                <span class="gcre-summary-label">Data e ora</span>
                <span class="gcre-summary-value" id="riepilogoDataSerata"></span>
            </div>
            <div class="gcre-summary-row">
                <span class="gcre-summary-label">Partecipanti max</span>
                <span class="gcre-summary-value" id="riepilogoMaxSerata"></span>
            </div>
        </div>
        <div class="gcre-modal__footer">
            <button type="button" class="gcre-btn gcre-btn--ghost" id="btnModificaSerata">Modifica</button>
            <button type="button" class="gcre-btn gcre-btn--primary" id="btnCreaSerata">
                <i class="ti ti-check"></i> Crea Serata
            </button>
        </div>
    </div>

<?php echo '<script'; ?>
>
(function () {
    const form = document.getElementById('formCreaSerata');
    const steps = Array.from(form.querySelectorAll('.gcre-step'));
    const stepperItems = Array.from(document.querySelectorAll('#gcreStepper .gcre-stepper__item'));
    const btnNext = document.getElementById('btnNextSerata');
    const btnBack = document.getElementById('btnBackSerata');
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
            const field = group.querySelector('input, textarea, select');
            let ok = true;
            if (field) {
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
        const raw = document.getElementById('dataInizio_input').value; // YYYY-MM-DDTHH:MM
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
        const preview = document.getElementById('uploadPreviewSerata');
        const icon = document.getElementById('uploadIconSerata');
        const text = document.getElementById('uploadTextSerata');
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = 'block';
            icon.style.display = 'none';
            text.textContent = file.name;
        };
        reader.readAsDataURL(file);
    });

    // Riepilogo
    const overlay = document.getElementById('overlaySerata');

    function openRiepilogo() {
        document.getElementById('riepilogoNomeSerata').textContent = document.getElementById('nomeEvento').value;
        document.getElementById('riepilogoDescSerata').textContent = document.getElementById('descrizioneEvento').value;
        document.getElementById('riepilogoTipoSerata').textContent = document.getElementById('tipoSerata').value;
        document.getElementById('riepilogoMaxSerata').textContent = document.getElementById('maxPartecipanti').value;

        const rawDate = document.getElementById('dataInizio_input').value;
        if (rawDate) {
            const d = new Date(rawDate);
            document.getElementById('riepilogoDataSerata').textContent = d.toLocaleString('it-IT', {
                day: '2-digit', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit'
            });
        }

        const preview = document.getElementById('uploadPreviewSerata');
        document.getElementById('riepilogoImgSerata').src = preview.src || '';

        overlay.classList.add('active');
    }

    document.getElementById('btnModificaSerata').addEventListener('click', () => overlay.classList.remove('active'));
    document.getElementById('btnCreaSerata').addEventListener('click', () => {
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
