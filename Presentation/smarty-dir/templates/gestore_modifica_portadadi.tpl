{*
  TableCrown\Presentation\Views\Gestore - Modale Modifica Porta Dadi (frammento)
  NON usa {extends}: è un partial incluso in catalogo_porta_dadi.tpl, fuori dal foreach.
  Nessuna sezione "danno" (riservata a EGiocoDaTavolo).
  Tutti i valori vengono iniettati via JS dai data-* del bottone .gmp-btn-modifica
  cliccato, NON da variabili Smarty ($prodotto non esiste in questo contesto).
*}

<div class="gmp-overlay" id="gmpOverlayPortaDadi">
    <div class="gmp-modal">

        <div class="gmp-modal__header">
            <div class="gmp-modal__product">
                <img src="" alt="" class="gmp-modal__product-img" id="gmpPortaDadiImg">
                <div>
                    <h3 class="gmp-modal__title">Modifica prodotto</h3>
                    <p class="gmp-modal__product-name" id="gmpPortaDadiNome"></p>
                </div>
            </div>
            <button type="button" class="gmp-modal__close" onclick="gmpChiudiModalePortaDadi()" aria-label="Chiudi">
                <i class="ti ti-x"></i>
            </button>
        </div>

        <div class="gmp-modal__body">

            <div class="gmp-section">
                <div class="gmp-section__header">
                    <i class="ti ti-discount-2"></i> Sconto promozionale
                </div>

                <p class="gmp-current-price" id="gmpPortaDadiPrezzoAttuale"></p>

                <label class="gmp-checkbox">
                    <input type="checkbox" id="gmpPortaDadiToggleSconto"
                           onchange="document.getElementById('gmpPortaDadiScontoFields').classList.toggle('active', this.checked)">
                    <span>Applica / aggiorna sconto</span>
                </label>

                <div id="gmpPortaDadiScontoFields" class="gmp-subfields">
                    <div class="gmp-row">
                        <div class="gmp-field-group">
                            <label class="gmp-label" for="gmpPortaDadiValoreSconto">Percentuale sconto (%)</label>
                            <input type="number" class="gmp-input" id="gmpPortaDadiValoreSconto" min="0" max="100" step="0.01">
                        </div>
                        <div class="gmp-field-group">
                            <label class="gmp-label" for="gmpPortaDadiScadenzaOfferta">Scadenza <span class="gmp-label__optional">(facoltativa)</span></label>
                            <input type="date" class="gmp-input" id="gmpPortaDadiScadenzaOfferta">
                        </div>
                    </div>
                </div>

                <p class="gmp-feedback" id="gmpPortaDadiFeedback"></p>
            </div>

        </div>

        <div class="gmp-modal__footer">
            <button type="button" class="gmp-btn gmp-btn--ghost" onclick="gmpChiudiModalePortaDadi()">Annulla</button>
            <button type="button" class="gmp-btn gmp-btn--primary" id="gmpPortaDadiBtnSalva" onclick="gmpSalvaPortaDadi()">
                <i class="ti ti-device-floppy"></i> Salva modifiche
            </button>
        </div>

    </div>
</div>

<script>
    let gmpPortaDadiIdProdotto = null;

    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.gmp-btn-modifica');
        if (!btn || btn.dataset.isGioco === '1') return;

        gmpPortaDadiIdProdotto = btn.dataset.id;

        document.getElementById('gmpPortaDadiImg').src = btn.dataset.immagine || '';
        document.getElementById('gmpPortaDadiNome').textContent = btn.dataset.nome || '';
        document.getElementById('gmpPortaDadiPrezzoAttuale').textContent = 'Prezzo attuale: €' + parseFloat(btn.dataset.prezzo || 0).toFixed(2);

        const haSconto = btn.dataset.sconto === '1';
        document.getElementById('gmpPortaDadiToggleSconto').checked = haSconto;
        document.getElementById('gmpPortaDadiScontoFields').classList.toggle('active', haSconto);
        document.getElementById('gmpPortaDadiValoreSconto').value = btn.dataset.percentualeSconto || '';
        document.getElementById('gmpPortaDadiScadenzaOfferta').value = btn.dataset.scadenzaSconto || '';

        document.getElementById('gmpPortaDadiFeedback').textContent = '';

        document.getElementById('gmpOverlayPortaDadi').classList.add('active');
    });

    function gmpChiudiModalePortaDadi() {
        document.getElementById('gmpOverlayPortaDadi').classList.remove('active');
        gmpPortaDadiIdProdotto = null;
    }

    document.getElementById('gmpOverlayPortaDadi').addEventListener('click', function (e) {
        if (e.target === this) gmpChiudiModalePortaDadi();
    });

    function gmpSalvaPortaDadi() {
        const btnSalva = document.getElementById('gmpPortaDadiBtnSalva');
        btnSalva.disabled = true;

        const params = new URLSearchParams();
        params.append('id_prodotto', gmpPortaDadiIdProdotto);

        if (document.getElementById('gmpPortaDadiToggleSconto').checked) {
            params.append('modificaSconto', '1');
            params.append('valoreSconto', document.getElementById('gmpPortaDadiValoreSconto').value);
            params.append('scadenzaOfferta', document.getElementById('gmpPortaDadiScadenzaOfferta').value);
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
                    gmpChiudiModalePortaDadi();
                    location.reload();
                } else {
                    document.getElementById('gmpPortaDadiFeedback').textContent = data.message || 'Errore durante il salvataggio.';
                    document.getElementById('gmpPortaDadiFeedback').classList.add('gmp-feedback--error');
                }
            })
            .catch(() => {
                btnSalva.disabled = false;
                document.getElementById('gmpPortaDadiFeedback').textContent = 'Errore di rete.';
                document.getElementById('gmpPortaDadiFeedback').classList.add('gmp-feedback--error');
            });
    }
</script>