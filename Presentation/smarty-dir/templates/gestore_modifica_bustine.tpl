{*
  TableCrown\Presentation\Views\Gestore - Modale Modifica Bustine (frammento)
  NON usa {extends}: è un partial incluso in catalogo_bustine.tpl, fuori dal foreach.
  Nessuna sezione "danno" (riservata a EGiocoDaTavolo).
  Tutti i valori vengono iniettati via JS dai data-* del bottone .gmp-btn-modifica
  cliccato, NON da variabili Smarty ($prodotto non esiste in questo contesto).
*}

<div class="gmp-overlay" id="gmpOverlayBustine">
    <div class="gmp-modal">

        <div class="gmp-modal__header">
            <div class="gmp-modal__product">
                <img src="" alt="" class="gmp-modal__product-img" id="gmpBustineImg">
                <div>
                    <h3 class="gmp-modal__title">Modifica prodotto</h3>
                    <p class="gmp-modal__product-name" id="gmpBustineNome"></p>
                </div>
            </div>
            <button type="button" class="gmp-modal__close" onclick="gmpChiudiModaleBustine()" aria-label="Chiudi">
                <i class="ti ti-x"></i>
            </button>
        </div>

        <div class="gmp-modal__body">

            <div class="gmp-section">
                <div class="gmp-section__header">
                    <i class="ti ti-discount-2"></i> Sconto promozionale
                </div>

                <p class="gmp-current-price" id="gmpBustinePrezzoAttuale"></p>

                <label class="gmp-checkbox">
                    <input type="checkbox" id="gmpBustineToggleSconto"
                           onchange="document.getElementById('gmpBustineScontoFields').classList.toggle('active', this.checked)">
                    <span>Applica / aggiorna sconto</span>
                </label>

                <div id="gmpBustineScontoFields" class="gmp-subfields">
                    <div class="gmp-row">
                        <div class="gmp-field-group">
                            <label class="gmp-label" for="gmpBustineValoreSconto">Percentuale sconto (%)</label>
                            <input type="number" class="gmp-input" id="gmpBustineValoreSconto" min="0" max="100" step="0.01">
                        </div>
                        <div class="gmp-field-group">
                            <label class="gmp-label" for="gmpBustineScadenzaOfferta">Scadenza <span class="gmp-label__optional">(facoltativa)</span></label>
                            <input type="date" class="gmp-input" id="gmpBustineScadenzaOfferta">
                        </div>
                    </div>
                </div>

                <p class="gmp-feedback" id="gmpBustineFeedback"></p>
            </div>

        </div>

        <div class="gmp-modal__footer">
            <button type="button" class="gmp-btn gmp-btn--ghost" onclick="gmpChiudiModaleBustine()">Annulla</button>
            <button type="button" class="gmp-btn gmp-btn--primary" id="gmpBustineBtnSalva" onclick="gmpSalvaBustine()">
                <i class="ti ti-device-floppy"></i> Salva modifiche
            </button>
        </div>

    </div>
</div>

<script>
    let gmpBustineIdProdotto = null;

    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.gmp-btn-modifica');
        if (!btn || btn.dataset.isGioco === '1') return;

        gmpBustineIdProdotto = btn.dataset.id;

        document.getElementById('gmpBustineImg').src = btn.dataset.immagine || '';
        document.getElementById('gmpBustineNome').textContent = btn.dataset.nome || '';
        document.getElementById('gmpBustinePrezzoAttuale').textContent = 'Prezzo attuale: €' + parseFloat(btn.dataset.prezzo || 0).toFixed(2);

        const haSconto = btn.dataset.sconto === '1';
        document.getElementById('gmpBustineToggleSconto').checked = haSconto;
        document.getElementById('gmpBustineScontoFields').classList.toggle('active', haSconto);
        document.getElementById('gmpBustineValoreSconto').value = btn.dataset.percentualeSconto || '';
        document.getElementById('gmpBustineScadenzaOfferta').value = btn.dataset.scadenzaSconto || '';

        document.getElementById('gmpBustineFeedback').textContent = '';

        document.getElementById('gmpOverlayBustine').classList.add('active');
    });

    function gmpChiudiModaleBustine() {
        document.getElementById('gmpOverlayBustine').classList.remove('active');
        gmpBustineIdProdotto = null;
    }

    document.getElementById('gmpOverlayBustine').addEventListener('click', function (e) {
        if (e.target === this) gmpChiudiModaleBustine();
    });

    function gmpSalvaBustine() {
        const btnSalva = document.getElementById('gmpBustineBtnSalva');
        btnSalva.disabled = true;

        const params = new URLSearchParams();
        params.append('id_prodotto', gmpBustineIdProdotto);

        if (document.getElementById('gmpBustineToggleSconto').checked) {
            params.append('modificaSconto', '1');
            params.append('valoreSconto', document.getElementById('gmpBustineValoreSconto').value);
            params.append('scadenzaOfferta', document.getElementById('gmpBustineScadenzaOfferta').value);
        } else {
            params.append('rimuoviSconto', '1');
        }

        fetch('{$base_url}/gestore/prodotti/modifica', {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: params
        })
            .then(res => res.json())
            .then(data => {
                btnSalva.disabled = false;
                if (data.status === 'ok') {
                    gmpChiudiModaleBustine();
                    location.reload();
                } else {
                    document.getElementById('gmpBustineFeedback').textContent = data.message || 'Errore durante il salvataggio.';
                    document.getElementById('gmpBustineFeedback').classList.add('gmp-feedback--error');
                }
            })
            .catch(() => {
                btnSalva.disabled = false;
                document.getElementById('gmpBustineFeedback').textContent = 'Errore di rete.';
                document.getElementById('gmpBustineFeedback').classList.add('gmp-feedback--error');
            });
    }
</script>