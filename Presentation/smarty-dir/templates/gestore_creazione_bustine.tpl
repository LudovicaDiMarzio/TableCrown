{*
  TableCrown\Presentation\Views\Gestore - Creazione Bustine
  Estende layout_gestore.tpl.

  Wizard a 3 step. Form multipart -> POST /gestore/catalogo/bustine/nuovo
  (CGestore::creaBustine()).

  Campi attesi: nomeProdotto, descrizioneProdotto, imgProdotto (file, OPZIONALE),
  prezzoListino, valuta, scontoAttivo (opz.) -> valoreSconto, scadenzaOfferta (opz.),
  quantita, disponibilita.

  Variabili di pagina ATTESE dal futuro controller GET
  mostraFormCreazioneBustineGestore():
    $valute_enum, $disponibilita_enum (stesse enumToOptions() usate altrove)
*}
{extends file="layout_gestore.tpl"}

{block name="page_css"}
    <link rel="stylesheet" href="{$base_url}/css/gestore_creazione_evento.css">
    <link rel="stylesheet" href="{$base_url}/css/gestore_creazione_prodotto.css">
{/block}

{block name="content"}

<div class="gcre-container">

    <div class="gcre-header">
        <div>
            <h1 class="gcre-header__title">Nuove Bustine</h1>
            <p class="gcre-header__subtitle">Compila i 3 step per pubblicare un nuovo prodotto.</p>
        </div>
        <a href="{$base_url}/gestore/catalogo/bustine" class="gcre-header__close">
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
            <span class="gcre-stepper__label">Prezzo</span>
        </div>
        <div class="gcre-stepper__line"></div>
        <div class="gcre-stepper__item" data-step-indicator="3">
            <div class="gcre-stepper__circle">3</div>
            <span class="gcre-stepper__label">Magazzino</span>
        </div>
    </div>

    <form id="formCreaBustine" class="gcre-form-card" method="post" enctype="multipart/form-data"
          action="{$base_url}/gestore/catalogo/bustine/nuovo">

        {* ── STEP 1: Informazioni ── *}
        <div class="gcre-step active" data-step="1">
            <h2 class="gcre-step__title">Informazioni</h2>
            <p class="gcre-step__subtitle">Nome, descrizione e immagine del prodotto.</p>

            <div class="gcre-field-group" data-field="nomeProdotto">
                <label class="gcre-label" for="nomeProdotto">Nome del prodotto</label>
                <input type="text" id="nomeProdotto" name="nomeProdotto" maxlength="255"
                       class="gcre-input" placeholder="Es. Bustina Protettiva 63x88mm" required>
                <span class="gcre-error">Inserisci un nome per il prodotto.</span>
            </div>

            <div class="gcre-field-group" data-field="descrizioneProdotto">
                <label class="gcre-label" for="descrizioneProdotto">Descrizione</label>
                <textarea id="descrizioneProdotto" name="descrizioneProdotto" class="gcre-textarea"
                          placeholder="Materiale, formato, confezione..." required></textarea>
                <span class="gcre-error">Inserisci una descrizione.</span>
            </div>

            <div class="gcre-field-group" data-field="imgProdotto">
                <label class="gcre-label">Immagine <span class="gcre-label__optional">(opzionale)</span></label>
                <label class="gcre-upload-box" id="uploadBoxBustine">
                    <img id="uploadPreviewBustine" class="gcre-upload-box__preview" src="" alt="" style="display:none;">
                    <i class="ti ti-photo" id="uploadIconBustine" style="font-size: 28px; color: var(--gestore-muted);"></i>
                    <div class="gcre-upload-box__text">
                        <span class="gcre-upload-box__title" id="uploadTextBustine">Carica un'immagine</span>
                        <span class="gcre-upload-box__hint">PNG o JPG, consigliata almeno 800x450px</span>
                    </div>
                    <input type="file" name="imgProdotto" id="imgProdotto" accept="image/*" style="display:none;">
                </label>
            </div>
        </div>

        {* ── STEP 2: Prezzo ── *}
        <div class="gcre-step" data-step="2">
            <h2 class="gcre-step__title">Prezzo</h2>
            <p class="gcre-step__subtitle">Prezzo di listino ed eventuale sconto promozionale.</p>

            <div class="gcre-row">
                <div class="gcre-field-group" data-field="prezzoListino">
                    <label class="gcre-label" for="prezzoListino">Prezzo di listino</label>
                    <input type="number" id="prezzoListino" name="prezzoListino" class="gcre-input"
                           min="0" step="0.01" placeholder="0.00" required>
                    <span class="gcre-error">Inserisci un prezzo valido.</span>
                </div>
                <div class="gcre-field-group" data-field="valuta">
                    <label class="gcre-label" for="valuta">Valuta</label>
                    <select id="valuta" name="valuta" class="gcre-select" required>
                        {if isset($valute_enum) && $valute_enum|@count > 0}
                            {foreach $valute_enum as $v}
                                <option value="{$v.value}">{$v.label}</option>
                            {/foreach}
                        {else}
                            {* TODO: CASE REALI DI Valuta DA CONFERMARE — placeholder provvisorio *}
                            <option value="eur">Euro (€)</option>
                            <option value="usd">Dollaro USA ($)</option>
                            <option value="gbp">Sterlina (£)</option>
                        {/if}
                    </select>
                    <span class="gcre-error">Seleziona una valuta.</span>
                </div>
            </div>

            <div class="gcre-toggle-section">
                <label class="gcre-toggle-header">
                    <input type="checkbox" name="scontoAttivo" id="scontoAttivo" value="1">
                    <span class="gcre-toggle-header__label">Applica uno sconto promozionale</span>
                </label>
                <div class="gcre-toggle-body" id="scontoBody">
                    <div class="gcre-row">
                        <div class="gcre-field-group" data-field="valoreSconto" data-conditional="scontoAttivo">
                            <label class="gcre-label" for="valoreSconto">Sconto (%)</label>
                            <input type="number" id="valoreSconto" name="valoreSconto" class="gcre-input"
                                   min="0" max="100" step="0.01" placeholder="Es. 15">
                            <span class="gcre-error">Inserisci un valore tra 0 e 100.</span>
                        </div>
                        <div class="gcre-field-group">
                            <label class="gcre-label" for="scadenzaOfferta">Scadenza offerta <span class="gcre-label__optional">(opzionale)</span></label>
                            <input type="date" id="scadenzaOfferta" name="scadenzaOfferta" class="gcre-input">
                            <span class="gcre-hint">Lascia vuoto per uno sconto permanente.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {* ── STEP 3: Magazzino ── *}
        <div class="gcre-step" data-step="3">
            <h2 class="gcre-step__title">Magazzino</h2>
            <p class="gcre-step__subtitle">Quantità disponibile e stato del prodotto.</p>

            <div class="gcre-row">
                <div class="gcre-field-group" data-field="quantita">
                    <label class="gcre-label" for="quantita">Quantità in magazzino</label>
                    <input type="number" id="quantita" name="quantita" class="gcre-input"
                           min="0" step="1" placeholder="Es. 100" required>
                    <span class="gcre-error">Inserisci una quantità valida.</span>
                </div>
                <div class="gcre-field-group" data-field="disponibilita">
                    <label class="gcre-label" for="disponibilita">Disponibilità</label>
                    <select id="disponibilita" name="disponibilita" class="gcre-select" required>
                        {if isset($disponibilita_enum) && $disponibilita_enum|@count > 0}
                            {foreach $disponibilita_enum as $d}
                                <option value="{$d.value}">{$d.label}</option>
                            {/foreach}
                        {else}
                            {* TODO: CASE REALI DI DisponibilitaProdotto DA CONFERMARE — placeholder *}
                            <option value="disponibile">Disponibile</option>
                            <option value="esaurito">Esaurito</option>
                            <option value="non_disponibile">Non disponibile</option>
                        {/if}
                    </select>
                    <span class="gcre-error">Seleziona una disponibilità.</span>
                </div>
            </div>
        </div>

        <div class="gcre-nav">
            <button type="button" class="gcre-btn gcre-btn--ghost" id="btnBackBustine" style="visibility:hidden;">
                <i class="ti ti-arrow-left"></i> Indietro
            </button>
            <button type="button" class="gcre-btn gcre-btn--primary" id="btnNextBustine">
                Avanti <i class="ti ti-arrow-right"></i>
            </button>
        </div>
    </form>
</div>

{* ── MODALE RIEPILOGO ── *}
<div class="gcre-overlay" id="overlayBustine">
    <div class="gcre-modal">
        <div class="gcre-modal__header">
            <h3 class="gcre-modal__title">Rivedi il tuo prodotto</h3>
            <p class="gcre-modal__subtitle">Controlla i dati prima di pubblicare.</p>
        </div>
        <div class="gcre-modal__body">
            <img class="gcre-modal__img" id="riepilogoImgBustine" src="" alt="">
            <div class="gcre-summary-row">
                <span class="gcre-summary-label">Nome</span>
                <span class="gcre-summary-value" id="riepilogoNomeBustine"></span>
            </div>
            <div class="gcre-summary-row">
                <span class="gcre-summary-label">Prezzo</span>
                <span class="gcre-summary-value" id="riepilogoPrezzoBustine"></span>
            </div>
            <div class="gcre-summary-row">
                <span class="gcre-summary-label">Quantità</span>
                <span class="gcre-summary-value" id="riepilogoQuantitaBustine"></span>
            </div>
        </div>
        <div class="gcre-modal__footer">
            <button type="button" class="gcre-btn gcre-btn--ghost" id="btnModificaBustine">Modifica</button>
            <button type="button" class="gcre-btn gcre-btn--primary" id="btnCreaBustine">
                <i class="ti ti-check"></i> Crea Prodotto
            </button>
        </div>
    </div>
</div>

<script>
(function () {
    const form = document.getElementById('formCreaBustine');
    const steps = Array.from(form.querySelectorAll('.gcre-step'));
    const stepperItems = Array.from(document.querySelectorAll('#gcreStepper .gcre-stepper__item'));
    const btnNext = document.getElementById('btnNextBustine');
    const btnBack = document.getElementById('btnBackBustine');
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

    setupToggle('scontoAttivo', 'scontoBody');
    function setupToggle(checkboxId, bodyId) {
        const cb = document.getElementById(checkboxId);
        const body = document.getElementById(bodyId);
        cb.addEventListener('change', () => body.classList.toggle('active', cb.checked));
    }

    document.getElementById('imgProdotto').addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const preview = document.getElementById('uploadPreviewBustine');
        const icon = document.getElementById('uploadIconBustine');
        const text = document.getElementById('uploadTextBustine');
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = 'block';
            icon.style.display = 'none';
            text.textContent = file.name;
        };
        reader.readAsDataURL(file);
    });

    function validateStep(n) {
        let valid = true;
        const stepEl = steps.find(s => parseInt(s.dataset.step) === n);
        stepEl.querySelectorAll('[data-field]').forEach(group => {
            const conditional = group.dataset.conditional;
            if (conditional && !document.getElementById(conditional).checked) {
                group.classList.remove('has-error');
                return;
            }
            if (group.dataset.field === 'imgProdotto') return; // opzionale

            const field = group.querySelector('input, textarea, select');
            let ok = field.value.trim() !== '';
            if (field.type === 'number' && ok) {
                ok = parseFloat(field.value) >= parseFloat(field.min || '-Infinity');
            }
            group.classList.toggle('has-error', !ok);
            if (!ok) valid = false;
        });
        return valid;
    }

    btnNext.addEventListener('click', function () {
        if (!validateStep(current)) return;
        if (current === 3) {
            openRiepilogo();
            return;
        }
        showStep(current + 1);
    });

    btnBack.addEventListener('click', function () {
        if (current > 1) showStep(current - 1);
    });

    const overlay = document.getElementById('overlayBustine');

    function openRiepilogo() {
        document.getElementById('riepilogoNomeBustine').textContent = document.getElementById('nomeProdotto').value;

        const prezzo = parseFloat(document.getElementById('prezzoListino').value || '0').toFixed(2);
        const valutaSelect = document.getElementById('valuta');
        const valutaLabel = valutaSelect.options[valutaSelect.selectedIndex]?.text || '';
        const scontoAttivo = document.getElementById('scontoAttivo').checked;
        const scontoTxt = scontoAttivo ? ' (-' + (document.getElementById('valoreSconto').value || 0) + '%)' : '';
        document.getElementById('riepilogoPrezzoBustine').textContent = prezzo + ' ' + valutaLabel + scontoTxt;

        document.getElementById('riepilogoQuantitaBustine').textContent = document.getElementById('quantita').value;

        const preview = document.getElementById('uploadPreviewBustine');
        document.getElementById('riepilogoImgBustine').src = preview.src || '';

        overlay.classList.add('active');
    }

    document.getElementById('btnModificaBustine').addEventListener('click', () => overlay.classList.remove('active'));
    document.getElementById('btnCreaBustine').addEventListener('click', () => form.submit());
})();
</script>

{/block}