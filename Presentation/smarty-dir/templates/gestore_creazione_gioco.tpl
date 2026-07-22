{*
  TableCrown\Presentation\Views\Gestore - Creazione Gioco da Tavolo
  Estende layout_gestore.tpl.

  Wizard a 3 step, ricalca ESATTAMENTE le 3 "PAGINA" già commentate
  dentro CGestore::creaGiocoDaTavolo(): dati base / prezzo-magazzino-stato /
  caratteristiche di gioco.

  Form multipart -> POST /gestore/catalogo/giochi-da-tavolo/nuovo

  Campi attesi da creaGiocoDaTavolo():
    nomeProdotto, descrizioneProdotto, categoria[] (>=1), componenti[] (>=1),
    imgProdotto (file, OPZIONALE - vedi nota sul bug di estraiImmagineProdotto()),
    prezzoListino, valuta, scontoAttivo (opz.) -> valoreSconto, scadenzaOfferta (opz.),
    quantita, disponibilita, danneggiato (opz.) -> livelloDanno, descrizioneDanno,
    difficolta, lingua, numeroGiocatoriMin, numeroGiocatoriMax, etaMinima, durataMedia,
    giocoBaseId (opzionale, solo se è un'espansione)

  Variabili di pagina ATTESE dal (futuro) controller GET
  mostraFormCreazioneGiocoGestore(), non ancora implementato in CGestore:
    $categorie_enum   => enumToOptions(Categoria::cases(), ['gdr' => 'GDR'])
    $disponibilita_enum => enumToOptions(DisponibilitaProdotto::cases())
    $danno_enum       => enumToOptions(LivelloDannoGiochi::cases())
    $difficolta_enum  => enumToOptions(DifficoltaGioco::cases())
    $lingue_enum      => array_map(fn($c) => ['value'=>$c->value,'label'=>$c->name], LinguaGioco::cases())
    $valute_enum      => enumToOptions(Valuta::cases()) — CASE DA CONFERMARE
    $giochiBaseDisponibili => prodottiToArray(...) filtrato sui soli EGiocoDaTavolo
                              NON espansione (giocoBase === null)
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
            <h1 class="gcre-header__title">Nuovo Gioco da Tavolo</h1>
            <p class="gcre-header__subtitle">Compila i 3 step per pubblicare un nuovo prodotto.</p>
        </div>
        <a href="{$base_url}/gestore/catalogo/giochi-da-tavolo" class="gcre-header__close">
            <i class="ti ti-x"></i> Annulla
        </a>
    </div>

    <div class="gcre-stepper" id="gcreStepper">
        <div class="gcre-stepper__item gcre-stepper__item--active" data-step-indicator="1">
            <div class="gcre-stepper__circle">1</div>
            <span class="gcre-stepper__label">Dati base</span>
        </div>
        <div class="gcre-stepper__line"></div>
        <div class="gcre-stepper__item" data-step-indicator="2">
            <div class="gcre-stepper__circle">2</div>
            <span class="gcre-stepper__label">Prezzo e magazzino</span>
        </div>
        <div class="gcre-stepper__line"></div>
        <div class="gcre-stepper__item" data-step-indicator="3">
            <div class="gcre-stepper__circle">3</div>
            <span class="gcre-stepper__label">Caratteristiche</span>
        </div>
    </div>

    <form id="formCreaGioco" class="gcre-form-card" method="post" enctype="multipart/form-data"
          action="{$base_url}/gestore/catalogo/giochi-da-tavolo/nuovo">

        {* ══════════ STEP 1: DATI BASE ══════════ *}
        <div class="gcre-step active" data-step="1">
            <h2 class="gcre-step__title">Dati base</h2>
            <p class="gcre-step__subtitle">Nome, descrizione, categorie e componenti del gioco.</p>

            <div class="gcre-field-group" data-field="nomeProdotto">
                <label class="gcre-label" for="nomeProdotto">Nome del prodotto</label>
                <input type="text" id="nomeProdotto" name="nomeProdotto" maxlength="255"
                       class="gcre-input" placeholder="Es. Terraforming Mars" required>
                <span class="gcre-error">Inserisci un nome per il prodotto.</span>
            </div>

            <div class="gcre-field-group" data-field="descrizioneProdotto">
                <label class="gcre-label" for="descrizioneProdotto">Descrizione</label>
                <textarea id="descrizioneProdotto" name="descrizioneProdotto" class="gcre-textarea"
                          placeholder="Ambientazione, meccaniche, punti di forza..." required></textarea>
                <span class="gcre-error">Inserisci una descrizione.</span>
            </div>

            <div class="gcre-field-group" data-field="categoria">
                <label class="gcre-label">Categorie</label>
                <div class="gcre-chip-group" id="categoriaChips">
                    {if isset($categorie_enum) && $categorie_enum|@count > 0}
    {foreach $categorie_enum as $cat}
        <label class="gcre-chip">
            <input type="checkbox" name="categoria[]" value="{$cat.value}">
            {$cat.label}
        </label>
    {/foreach}
{else}
                        {* TODO: CASE REALI DI Categoria DA CONFERMARE — placeholder provvisorio *}
                        <label class="gcre-chip"><input type="checkbox" name="categoria[]" value="strategia">Strategia</label>
                        <label class="gcre-chip"><input type="checkbox" name="categoria[]" value="party">Party</label>
                        <label class="gcre-chip"><input type="checkbox" name="categoria[]" value="famiglia">Famiglia</label>
                        <label class="gcre-chip"><input type="checkbox" name="categoria[]" value="cooperativo">Cooperativo</label>
                        <label class="gcre-chip"><input type="checkbox" name="categoria[]" value="astratto">Astratto</label>
                        <label class="gcre-chip"><input type="checkbox" name="categoria[]" value="gdr">GDR</label>
                    {/if}
                </div>
                <span class="gcre-error">Seleziona almeno una categoria.</span>
            </div>

            <div class="gcre-field-group" data-field="componenti">
                <label class="gcre-label">Componenti inclusi</label>
                <div class="gcre-dynamic-list" id="componentiList">
                    <div class="gcre-dynamic-row">
                        <input type="text" name="componenti[]" class="gcre-input" placeholder="Es. Tabellone principale">
                        <button type="button" class="gcre-dynamic-remove" disabled><i class="ti ti-trash"></i></button>
                    </div>
                </div>
                <button type="button" class="gcre-dynamic-add" id="addComponenteBtn">
                    <i class="ti ti-plus"></i> Aggiungi componente
                </button>
                <span class="gcre-error">Inserisci almeno un componente.</span>
            </div>

            <div class="gcre-field-group" data-field="imgProdotto">
                <label class="gcre-label">Immagine <span class="gcre-label__optional">(opzionale)</span></label>
                <label class="gcre-upload-box" id="uploadBoxGioco">
                    <img id="uploadPreviewGioco" class="gcre-upload-box__preview" src="" alt="" style="display:none;">
                    <i class="ti ti-photo" id="uploadIconGioco" style="font-size: 28px; color: var(--gestore-muted);"></i>
                    <div class="gcre-upload-box__text">
                        <span class="gcre-upload-box__title" id="uploadTextGioco">Carica un'immagine</span>
                        <span class="gcre-upload-box__hint">PNG o JPG, consigliata almeno 800x450px</span>
                    </div>
                    <input type="file" name="img_prodotto" id="imgProdotto" accept="image/*" style="display:none;">
                </label>
            </div>
        </div>

        {* ══════════ STEP 2: PREZZO, MAGAZZINO, STATO/DANNO ══════════ *}
        <div class="gcre-step" data-step="2">
            <h2 class="gcre-step__title">Prezzo e magazzino</h2>
            <p class="gcre-step__subtitle">Prezzo di listino, eventuale sconto, quantità e stato del prodotto.</p>

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
    <option value="EUR">Euro (€)</option>
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

            <div class="gcre-row">
                <div class="gcre-field-group" data-field="quantita">
                    <label class="gcre-label" for="quantita">Quantità in magazzino</label>
                    <input type="number" id="quantita" name="quantita" class="gcre-input"
                           min="0" step="1" placeholder="Es. 25" required>
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

            <div class="gcre-toggle-section">
                <label class="gcre-toggle-header">
                    <input type="checkbox" name="danneggiato" id="danneggiato" value="1">
                    <span class="gcre-toggle-header__label">Il prodotto è danneggiato</span>
                </label>
                <div class="gcre-toggle-body" id="dannoBody">
                    <div class="gcre-field-group" data-field="livelloDanno" data-conditional="danneggiato">
                        <label class="gcre-label" for="livelloDanno">Livello di danno</label>
                        <select id="livelloDanno" name="livelloDanno" class="gcre-select">
                            {if isset($danno_enum) && $danno_enum|@count > 0}
                                {foreach $danno_enum as $d}
                                    <option value="{$d.value}">{$d.label}</option>
                                {/foreach}
                            {else}
                                {* TODO: CASE REALI DI LivelloDannoGiochi DA CONFERMARE — placeholder *}
                                <option value="lieve">Lieve</option>
                                <option value="medio">Medio</option>
                                <option value="grave">Grave</option>
                            {/if}
                        </select>
                        <span class="gcre-error">Seleziona un livello di danno.</span>
                    </div>
                    <div class="gcre-field-group" data-field="descrizioneDanno" data-conditional="danneggiato">
                        <label class="gcre-label" for="descrizioneDanno">Descrizione del danno</label>
                        <textarea id="descrizioneDanno" name="descrizioneDanno" class="gcre-textarea"
                                  maxlength="500" placeholder="Es. Scatola ammaccata su uno spigolo"></textarea>
                        <span class="gcre-error">Descrivi il danno.</span>
                    </div>
                </div>
            </div>
        </div>

        {* ══════════ STEP 3: CARATTERISTICHE DI GIOCO ══════════ *}
        <div class="gcre-step" data-step="3">
            <h2 class="gcre-step__title">Caratteristiche di gioco</h2>
            <p class="gcre-step__subtitle">Difficoltà, lingua, numero di giocatori, età e durata.</p>

            <div class="gcre-row">
                <div class="gcre-field-group" data-field="difficolta">
                    <label class="gcre-label" for="difficolta">Difficoltà</label>
                    <select id="difficolta" name="difficolta" class="gcre-select" required>
                        {if isset($difficolta_enum) && $difficolta_enum|@count > 0}
                            {foreach $difficolta_enum as $d}
                                <option value="{$d.value}">{$d.label}</option>
                            {/foreach}
                        {else}
                            {* TODO: CASE REALI DI DifficoltaGioco DA CONFERMARE — placeholder *}
                            <option value="facile">Facile</option>
                            <option value="media">Media</option>
                            <option value="difficile">Difficile</option>
                        {/if}
                    </select>
                    <span class="gcre-error">Seleziona una difficoltà.</span>
                </div>
                <div class="gcre-field-group" data-field="lingua">
                    <label class="gcre-label" for="lingua">Lingua</label>
                    <select id="lingua" name="lingua" class="gcre-select" required>
                        {if isset($lingue_enum) && $lingue_enum|@count > 0}
                            {foreach $lingue_enum as $l}
                                <option value="{$l.value}">{$l.label}</option>
                            {/foreach}
                        {else}
                            {* TODO: CASE REALI DI LinguaGioco DA CONFERMARE — placeholder *}
                            <option value="IT">IT</option>
                            <option value="EN">EN</option>
                            <option value="FR">FR</option>
                            <option value="DE">DE</option>
                        {/if}
                    </select>
                    <span class="gcre-error">Seleziona una lingua.</span>
                </div>
            </div>

            <div class="gcre-row">
                <div class="gcre-field-group" data-field="numeroGiocatoriMin">
                    <label class="gcre-label" for="numeroGiocatoriMin">Giocatori minimo</label>
                    <input type="number" id="numeroGiocatoriMin" name="numeroGiocatoriMin" class="gcre-input"
                           min="1" step="1" placeholder="Es. 2" required>
                    <span class="gcre-error">Obbligatorio, minimo 1.</span>
                </div>
                <div class="gcre-field-group" data-field="numeroGiocatoriMax">
                    <label class="gcre-label" for="numeroGiocatoriMax">Giocatori massimo</label>
                    <input type="number" id="numeroGiocatoriMax" name="numeroGiocatoriMax" class="gcre-input"
                           min="1" step="1" placeholder="Es. 4" required>
                    <span class="gcre-error">Deve essere maggiore o uguale al minimo.</span>
                </div>
            </div>

            <div class="gcre-row">
                <div class="gcre-field-group" data-field="etaMinima">
                    <label class="gcre-label" for="etaMinima">Età minima consigliata</label>
                    <input type="number" id="etaMinima" name="etaMinima" class="gcre-input"
                           min="1" step="1" placeholder="Es. 10" required>
                    <span class="gcre-error">Obbligatorio, minimo 1.</span>
                </div>
                <div class="gcre-field-group" data-field="durataMedia">
                    <label class="gcre-label" for="durataMedia">Durata media (minuti)</label>
                    <input type="number" id="durataMedia" name="durataMedia" class="gcre-input"
                           min="1" step="1" placeholder="Es. 90" required>
                    <span class="gcre-error">Obbligatorio, minimo 1.</span>
                </div>
            </div>

            <input type="hidden" name="giocoBaseId" id="giocoBaseId">
            <div class="gcre-toggle-section">
                <label class="gcre-toggle-header">
                    <input type="checkbox" id="espansioneToggle">
                    <span class="gcre-toggle-header__label">Questo gioco è un'espansione di un gioco base esistente</span>
                </label>
                <div class="gcre-toggle-body" id="espansioneBody">
                    <div class="gcre-field-group">
                        <label class="gcre-label">Gioco base</label>
                        <input type="search" class="gcre-input gcre-picker-search" id="searchGiocoBase" placeholder="Cerca un gioco...">
                        <div class="gcre-picker-grid" id="pickerGiocoBase">
                            {if isset($giochiBaseDisponibili) && $giochiBaseDisponibili|@count > 0}
                                {foreach $giochiBaseDisponibili as $g}
                                    <div class="gcre-picker-card" data-id="{$g.id}" data-nome="{$g.nome|escape}">
                                        <span class="gcre-picker-card__check"><i class="ti ti-check"></i></span>
                                        <img class="gcre-picker-card__img" src="{$g.immagine}" alt="{$g.nome|escape}">
                                        <span class="gcre-picker-card__name">{$g.nome|escape}</span>
                                    </div>
                                {/foreach}
                            {else}
                                <div class="gcre-picker-empty">Nessun gioco base disponibile nel catalogo.</div>
                            {/if}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="gcre-nav">
            <button type="button" class="gcre-btn gcre-btn--ghost" id="btnBackGioco" style="visibility:hidden;">
                <i class="ti ti-arrow-left"></i> Indietro
            </button>
            <button type="button" class="gcre-btn gcre-btn--primary" id="btnNextGioco">
                Avanti <i class="ti ti-arrow-right"></i>
            </button>
        </div>
    </form>
</div>

{* ── MODALE RIEPILOGO ── *}
<div class="gcre-overlay" id="overlayGioco">
    <div class="gcre-modal">
        <div class="gcre-modal__header">
            <h3 class="gcre-modal__title">Rivedi il tuo prodotto</h3>
            <p class="gcre-modal__subtitle">Controlla i dati prima di pubblicare.</p>
        </div>
        <div class="gcre-modal__body">
            <img class="gcre-modal__img" id="riepilogoImgGioco" src="" alt="">
            <div class="gcre-summary-row">
                <span class="gcre-summary-label">Nome</span>
                <span class="gcre-summary-value" id="riepilogoNomeGioco"></span>
            </div>
            <div class="gcre-summary-row">
                <span class="gcre-summary-label">Categorie</span>
                <div class="gcre-summary-tags" id="riepilogoCategorieGioco"></div>
            </div>
            <div class="gcre-summary-row">
                <span class="gcre-summary-label">Prezzo</span>
                <span class="gcre-summary-value" id="riepilogoPrezzoGioco"></span>
            </div>
            <div class="gcre-summary-row">
                <span class="gcre-summary-label">Quantità</span>
                <span class="gcre-summary-value" id="riepilogoQuantitaGioco"></span>
            </div>
            <div class="gcre-summary-row">
                <span class="gcre-summary-label">Giocatori</span>
                <span class="gcre-summary-value" id="riepilogoGiocatoriGioco"></span>
            </div>
            <div class="gcre-summary-row">
                <span class="gcre-summary-label">Durata / Età min.</span>
                <span class="gcre-summary-value" id="riepilogoDurataGioco"></span>
            </div>
        </div>
        <div class="gcre-modal__footer">
            <button type="button" class="gcre-btn gcre-btn--ghost" id="btnModificaGioco">Modifica</button>
            <button type="button" class="gcre-btn gcre-btn--primary" id="btnCreaGioco">
                <i class="ti ti-check"></i> Crea Prodotto
            </button>
        </div>
    </div>
</div>

<script>
(function () {
    const form = document.getElementById('formCreaGioco');
    const steps = Array.from(form.querySelectorAll('.gcre-step'));
    const stepperItems = Array.from(document.querySelectorAll('#gcreStepper .gcre-stepper__item'));
    const btnNext = document.getElementById('btnNextGioco');
    const btnBack = document.getElementById('btnBackGioco');
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

    // ---- Chip categoria ----
    document.querySelectorAll('#categoriaChips .gcre-chip input').forEach(cb => {
        cb.addEventListener('change', () => cb.closest('.gcre-chip').classList.toggle('gcre-chip--checked', cb.checked));
    });

    // ---- Lista dinamica componenti ----
    const componentiList = document.getElementById('componentiList');
    document.getElementById('addComponenteBtn').addEventListener('click', () => {
        const row = document.createElement('div');
        row.className = 'gcre-dynamic-row';
        row.innerHTML = '<input type="text" name="componenti[]" class="gcre-input" placeholder="Es. Mazzo di carte">' +
            '<button type="button" class="gcre-dynamic-remove"><i class="ti ti-trash"></i></button>';
        componentiList.appendChild(row);
        updateComponentiRemoveButtons();
    });
    componentiList.addEventListener('click', e => {
        const btn = e.target.closest('.gcre-dynamic-remove');
        if (btn && !btn.disabled) {
            btn.closest('.gcre-dynamic-row').remove();
            updateComponentiRemoveButtons();
        }
    });
    function updateComponentiRemoveButtons() {
        const rows = componentiList.querySelectorAll('.gcre-dynamic-row');
        rows.forEach(r => r.querySelector('.gcre-dynamic-remove').disabled = rows.length <= 1);
    }

    // ---- Toggle sezioni condizionali ----
    function setupToggle(checkboxId, bodyId) {
        const cb = document.getElementById(checkboxId);
        const body = document.getElementById(bodyId);
        cb.addEventListener('change', () => body.classList.toggle('active', cb.checked));
    }
    setupToggle('scontoAttivo', 'scontoBody');
    setupToggle('danneggiato', 'dannoBody');
    setupToggle('espansioneToggle', 'espansioneBody');

    // ---- Picker gioco base (singola selezione) ----
    const pickerGiocoBase = document.getElementById('pickerGiocoBase');
    const giocoBaseHidden = document.getElementById('giocoBaseId');
    pickerGiocoBase.querySelectorAll('.gcre-picker-card').forEach(card => {
        card.addEventListener('click', () => {
            pickerGiocoBase.querySelectorAll('.gcre-picker-card').forEach(c => c.classList.remove('gcre-picker-card--selected'));
            card.classList.add('gcre-picker-card--selected');
            giocoBaseHidden.value = card.dataset.id;
        });
    });
    const searchGiocoBase = document.getElementById('searchGiocoBase');
    if (searchGiocoBase) {
        searchGiocoBase.addEventListener('input', function () {
            const q = this.value.trim().toLowerCase();
            pickerGiocoBase.querySelectorAll('.gcre-picker-card').forEach(card => {
                card.style.display = card.dataset.nome.toLowerCase().includes(q) ? '' : 'none';
            });
        });
    }
    document.getElementById('espansioneToggle').addEventListener('change', function () {
        if (!this.checked) giocoBaseHidden.value = '';
    });

    // ---- Upload immagine con preview ----
    document.getElementById('imgProdotto').addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const preview = document.getElementById('uploadPreviewGioco');
        const icon = document.getElementById('uploadIconGioco');
        const text = document.getElementById('uploadTextGioco');
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = 'block';
            icon.style.display = 'none';
            text.textContent = file.name;
        };
        reader.readAsDataURL(file);
    });

    // ---- Validazione step ----
    function validateStep(n) {
        let valid = true;
        const stepEl = steps.find(s => parseInt(s.dataset.step) === n);

        stepEl.querySelectorAll('[data-field]').forEach(group => {
            const key = group.dataset.field;

            // Salta la validazione dei campi dentro una sezione condizionale non attiva
            const conditional = group.dataset.conditional;
            if (conditional && !document.getElementById(conditional).checked) {
                group.classList.remove('has-error');
                return;
            }

            let ok = true;

            if (key === 'categoria') {
                ok = document.querySelectorAll('#categoriaChips input:checked').length > 0;
            } else if (key === 'componenti') {
                ok = Array.from(componentiList.querySelectorAll('input[name="componenti[]"]'))
                    .some(input => input.value.trim() !== '');
            } else if (key === 'imgProdotto') {
                ok = true; // opzionale
            } else {
                const field = group.querySelector('input, textarea, select');
                if (field) {
                    ok = field.value.trim() !== '';
                    if (field.type === 'number' && ok) {
                        ok = parseFloat(field.value) >= parseFloat(field.min || '-Infinity');
                    }
                }
            }
            group.classList.toggle('has-error', !ok);
            if (!ok) valid = false;
        });

        // Regola aggiuntiva step 3: giocatori max >= min
        if (n === 3) {
            const min = parseInt(document.getElementById('numeroGiocatoriMin').value || '0');
            const max = parseInt(document.getElementById('numeroGiocatoriMax').value || '0');
            const ok = max >= min && min > 0;
            document.querySelector('[data-field="numeroGiocatoriMax"]').classList.toggle('has-error', !ok);
            if (!ok) valid = false;
        }

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

    // ---- Riepilogo ----
    const overlay = document.getElementById('overlayGioco');

    function openRiepilogo() {
        document.getElementById('riepilogoNomeGioco').textContent = document.getElementById('nomeProdotto').value;

        const tagsContainer = document.getElementById('riepilogoCategorieGioco');
        tagsContainer.innerHTML = '';
        document.querySelectorAll('#categoriaChips input:checked').forEach(cb => {
            const tag = document.createElement('span');
            tag.className = 'gcre-summary-tag';
            tag.textContent = cb.closest('.gcre-chip').textContent.trim();
            tagsContainer.appendChild(tag);
        });

        const prezzo = parseFloat(document.getElementById('prezzoListino').value || '0').toFixed(2);
        const valutaSelect = document.getElementById('valuta');
        const valutaLabel = valutaSelect.options[valutaSelect.selectedIndex]?.text || '';
        const scontoAttivo = document.getElementById('scontoAttivo').checked;
        const scontoTxt = scontoAttivo ? ' (-' + (document.getElementById('valoreSconto').value || 0) + '%)' : '';
        document.getElementById('riepilogoPrezzoGioco').textContent = prezzo + ' ' + valutaLabel + scontoTxt;

        document.getElementById('riepilogoQuantitaGioco').textContent = document.getElementById('quantita').value;
        document.getElementById('riepilogoGiocatoriGioco').textContent =
            document.getElementById('numeroGiocatoriMin').value + ' - ' + document.getElementById('numeroGiocatoriMax').value;
        document.getElementById('riepilogoDurataGioco').textContent =
            document.getElementById('durataMedia').value + ' min · età ' + document.getElementById('etaMinima').value + '+';

        const preview = document.getElementById('uploadPreviewGioco');
        document.getElementById('riepilogoImgGioco').src = preview.src || '';

        overlay.classList.add('active');
    }

    document.getElementById('btnModificaGioco').addEventListener('click', () => overlay.classList.remove('active'));
    document.getElementById('btnCreaGioco').addEventListener('click', () => form.submit());
})();
</script>

{/block}