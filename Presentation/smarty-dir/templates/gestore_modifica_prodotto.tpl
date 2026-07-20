{*
  TableCrown\Presentation\Views\Gestore - Modifica Prodotto (modale)
  Va incluso una sola volta nelle pagine di catalogo lato gestore
  (gestore_prodotti.tpl / gestore_catalogo_giochi.tpl / gestore_catalogo_bustine.tpl /
  gestore_catalogo_portadadi.tpl), tramite {include file="gestore_modifica_prodotto.tpl"}
  prima della chiusura di {block name="content"}.

  Il modale è UNICO e condiviso da tutti i prodotti della pagina: viene popolato
  via JS leggendo i data-* del bottone "Modifica" cliccato sulla card/riga prodotto.
  NOTA: il JS qui sotto usa concatenazione di stringhe (+) invece dei template
  literal `${...}`, perché Smarty scambierebbe ${...} per un proprio tag.

  Ogni bottone "Modifica" nella lista prodotti deve avere questa forma
  (i campi provengono da BaseController::prodottoToArray()):
    <button type="button" class="gmp-btn-modifica"
        data-id="{$prodotto.id}"
        data-nome="{$prodotto.nome|escape}"
        data-immagine="{$prodotto.immagine}"
        data-prezzo="{$prodotto.prezzo}"
        data-sconto="{if $prodotto.sconto}1{else}0{/if}"
        data-percentuale-sconto="{$prodotto.percentuale_sconto|default:0}"
        data-is-gioco="{if $prodotto.tipoSlug == 'giochi-da-tavolo'}1{else}0{/if}"
        data-danneggiato="{if $prodotto.danneggiato}1{else}0{/if}"
        data-livello-danno="{$prodotto.livello_danno|default:''}">
        <i class="ti ti-edit"></i> Modifica
    </button>

  Endpoint: POST /gestore/prodotti/modifica (CGestore::modificaProdottoGestore())
  Campi inviati:
    id_prodotto        (hidden, sempre)
    modificaSconto      (bool, checkbox "Applica/modifica sconto")
    valoreSconto         (float 0-100, richiesto solo se modificaSconto)
    scadenzaOfferta      (date, opzionale — sconto permanente se vuoto)
    rimuoviSconto         (bool, checkbox "Rimuovi sconto attivo")
    danneggiato           (bool, solo se prodotto instanceof EGiocoDaTavolo)
    livelloDanno           (enum LivelloDannoGiochi, richiesto solo se danneggiato)
    descrizioneDanno        (string max 500, richiesto solo se danneggiato)

  NOTA: data-danneggiato / data-livello-danno servono SOLO a precompilare il modale
  (mostrare lo stato attuale del pezzo), non vengono inviati come tali al backend:
  il backend non espone ad oggi un'azione di "rimozione danno", quindi se il
  prodotto risulta già danneggiato la checkbox viene precaricata già spuntata,
  in modo che il gestore possa correggere/aggiornare livello e descrizione
  semplicemente risalvando (CGestore::modificaProdottoGestore() richiama comunque
  aggiungiDanno() sul prodotto).

  Variabile di pagina ATTESA dal controller GET che carica il catalogo gestore:
    $livelloDanno_enum => enumToOptions(LivelloDannoGiochi::cases())
*}

<div class="gmp-overlay" id="gmpOverlay">
    <div class="gmp-modal">
        <div class="gmp-modal__header">
            <div class="gmp-modal__product">
                <img id="gmpProdottoImg" class="gmp-modal__product-img" src="" alt="">
                <div>
                    <h3 class="gmp-modal__title">Modifica prodotto</h3>
                    <p class="gmp-modal__product-name" id="gmpProdottoNome"></p>
                </div>
            </div>
            <button type="button" class="gmp-modal__close" id="gmpClose" aria-label="Chiudi">
                <i class="ti ti-x"></i>
            </button>
        </div>

        <form id="formModificaProdotto" class="gmp-modal__body">
            <input type="hidden" name="id_prodotto" id="gmpIdProdotto">

            {* ── SCONTO PROMOZIONALE ── *}
            <div class="gmp-section">
                <div class="gmp-section__header">
                    <i class="ti ti-discount-2"></i>
                    <span>Sconto promozionale</span>
                </div>

                <p class="gmp-current-price" id="gmpPrezzoAttuale"></p>

                <label class="gmp-checkbox">
                    <input type="checkbox" name="modificaSconto" id="gmpModificaSconto">
                    <span>Applica / modifica sconto</span>
                </label>

                <div class="gmp-subfields" id="gmpScontoFields">
                    <div class="gmp-row">
                        <div class="gmp-field-group" data-field="valoreSconto">
                            <label class="gmp-label" for="valoreSconto">Percentuale sconto (%)</label>
                            <input type="number" id="valoreSconto" name="valoreSconto" class="gmp-input"
                                   min="0" max="100" step="0.01" placeholder="Es. 15">
                            <span class="gmp-error">Inserisci un valore tra 0 e 100.</span>
                        </div>
                        <div class="gmp-field-group" data-field="scadenzaOfferta">
                            <label class="gmp-label" for="scadenzaOfferta">
                                Scadenza offerta <span class="gmp-label__optional">(opzionale)</span>
                            </label>
                            <input type="date" id="scadenzaOfferta" name="scadenzaOfferta" class="gmp-input">
                            <span class="gmp-hint">Lascia vuoto per uno sconto permanente.</span>
                        </div>
                    </div>
                </div>

                <label class="gmp-checkbox gmp-checkbox--danger" id="gmpRimuoviScontoWrap" style="display:none;">
                    <input type="checkbox" name="rimuoviSconto" id="gmpRimuoviSconto">
                    <span>Rimuovi lo sconto attivo</span>
                </label>
            </div>

            {* ── DANNO (solo giochi da tavolo) ── *}
            <div class="gmp-section" id="gmpSectionDanno" style="display:none;">
                <div class="gmp-section__header">
                    <i class="ti ti-alert-triangle"></i>
                    <span>Stato del pezzo</span>
                </div>

                <p class="gmp-current-damage" id="gmpDannoAttuale" style="display:none;"></p>

                <label class="gmp-checkbox">
                    <input type="checkbox" name="danneggiato" id="gmpDanneggiato">
                    <span>Segna come danneggiato</span>
                </label>

                <div class="gmp-subfields" id="gmpDannoFields">
                    <div class="gmp-field-group" data-field="livelloDanno">
                        <label class="gmp-label" for="livelloDanno">Livello di danno</label>
                        <select id="livelloDanno" name="livelloDanno" class="gmp-select">
                            {if isset($livelloDanno_enum) && $livelloDanno_enum|@count > 0}
                                {foreach $livelloDanno_enum as $l}
                                    <option value="{$l.value}">{$l.label}</option>
                                {/foreach}
                            {else}
                                {* TODO: case reali di LivelloDannoGiochi da confermare — placeholder provvisorio *}
                                <option value="lieve">Lieve</option>
                                <option value="moderato">Moderato</option>
                                <option value="grave">Grave</option>
                            {/if}
                        </select>
                        <span class="gmp-error">Seleziona un livello di danno.</span>
                    </div>
                    <div class="gmp-field-group" data-field="descrizioneDanno">
                        <label class="gmp-label" for="descrizioneDanno">Descrizione del danno</label>
                        <textarea id="descrizioneDanno" name="descrizioneDanno" class="gmp-textarea"
                                  maxlength="500" placeholder="Es. Scatola ammaccata, componenti integri..."></textarea>
                        <span class="gmp-error">Descrivi brevemente il danno.</span>
                    </div>
                </div>
            </div>

            <p class="gmp-feedback" id="gmpFeedback"></p>
        </form>

        <div class="gmp-modal__footer">
            <button type="button" class="gmp-btn gmp-btn--ghost" id="gmpAnnulla">Annulla</button>
            <button type="button" class="gmp-btn gmp-btn--primary" id="gmpSalva">
                <i class="ti ti-check"></i> Salva modifiche
            </button>
        </div>
    </div>
</div>

<script>
(function () {
    var GMP_BASE_URL = "{$base_url}";

    var overlay = document.getElementById('gmpOverlay');
    var form = document.getElementById('formModificaProdotto');
    var feedback = document.getElementById('gmpFeedback');

    var modificaSconto = document.getElementById('gmpModificaSconto');
    var scontoFields = document.getElementById('gmpScontoFields');
    var rimuoviScontoWrap = document.getElementById('gmpRimuoviScontoWrap');
    var rimuoviSconto = document.getElementById('gmpRimuoviSconto');

    var sectionDanno = document.getElementById('gmpSectionDanno');
    var dannoAttuale = document.getElementById('gmpDannoAttuale');
    var danneggiato = document.getElementById('gmpDanneggiato');
    var dannoFields = document.getElementById('gmpDannoFields');
    var livelloDannoSelect = document.getElementById('livelloDanno');

    // Etichette leggibili per il riepilogo "stato attuale": tengono conto
    // dei value effettivamente disponibili nel <select id="livelloDanno">,
    // così restano coerenti anche col fallback provvisorio del template.
    function labelLivelloDanno(value) {
        var option = livelloDannoSelect.querySelector('option[value="' + value + '"]');
        return option ? option.textContent : value;
    }

    // Apre il modale leggendo i data-* del bottone "Modifica" cliccato (event delegation:
    // funziona anche per bottoni renderizzati dinamicamente/paginazione AJAX)
    document.addEventListener('click', function (e) {
        var btn = e.target.closest('.gmp-btn-modifica');
        if (!btn) return;

        // Reset completo del form ad ogni apertura, per non trascinare stato
        // residuo dal prodotto modificato in precedenza
        form.reset();
        feedback.textContent = '';
        feedback.className = 'gmp-feedback';
        scontoFields.classList.remove('active');
        dannoFields.classList.remove('active');
        danneggiato.checked = false;
        dannoAttuale.style.display = 'none';
        form.querySelectorAll('.has-error').forEach(function (el) {
            el.classList.remove('has-error');
        });

        document.getElementById('gmpIdProdotto').value = btn.dataset.id;
        document.getElementById('gmpProdottoNome').textContent = btn.dataset.nome;
        document.getElementById('gmpProdottoImg').src = btn.dataset.immagine;

        var prezzo = parseFloat(btn.dataset.prezzo || '0').toFixed(2);
        var haSconto = btn.dataset.sconto === '1';
        var percentuale = btn.dataset.percentualeSconto || 0;
        document.getElementById('gmpPrezzoAttuale').textContent = haSconto
            ? 'Prezzo attuale: €' + prezzo + ' (sconto attivo del ' + percentuale + '%)'
            : 'Prezzo attuale: €' + prezzo + ' (nessuno sconto attivo)';

        rimuoviScontoWrap.style.display = haSconto ? 'flex' : 'none';

        // Sezione "Danno" visibile solo per i giochi da tavolo
        var isGioco = btn.dataset.isGioco === '1';
        sectionDanno.style.display = isGioco ? 'block' : 'none';

        if (isGioco) {
            var giaDanneggiato = btn.dataset.danneggiato === '1';
            var livelloAttuale = btn.dataset.livelloDanno || '';

            if (giaDanneggiato) {
                // Il backend non espone una vera "rimozione danno": mostriamo lo stato
                // attuale e precarichiamo checkbox + livello, così il gestore può
                // semplicemente correggere/aggiornare livello e descrizione e salvare.
                dannoAttuale.textContent = 'Stato attuale: danneggiato (' + labelLivelloDanno(livelloAttuale) + ')';
                dannoAttuale.style.display = 'block';

                danneggiato.checked = true;
                dannoFields.classList.add('active');
                if (livelloAttuale) {
                    livelloDannoSelect.value = livelloAttuale;
                }
            }
        }

        overlay.classList.add('active');
    });

    // modificaSconto e rimuoviSconto sono mutuamente esclusivi
    modificaSconto.addEventListener('change', function () {
        scontoFields.classList.toggle('active', this.checked);
        if (this.checked) rimuoviSconto.checked = false;
    });
    rimuoviSconto.addEventListener('change', function () {
        if (this.checked) {
            modificaSconto.checked = false;
            scontoFields.classList.remove('active');
        }
    });

    danneggiato.addEventListener('change', function () {
        dannoFields.classList.toggle('active', this.checked);
    });

    function chiudi() {
        overlay.classList.remove('active');
    }
    document.getElementById('gmpClose').addEventListener('click', chiudi);
    document.getElementById('gmpAnnulla').addEventListener('click', chiudi);
    overlay.addEventListener('click', function (e) {
        if (e.target === overlay) chiudi();
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && overlay.classList.contains('active')) chiudi();
    });

    function validate() {
        var valid = true;

        if (modificaSconto.checked) {
            var v = document.getElementById('valoreSconto');
            var group = v.closest('.gmp-field-group');
            var ok = v.value !== '' && parseFloat(v.value) >= 0 && parseFloat(v.value) <= 100;
            group.classList.toggle('has-error', !ok);
            if (!ok) valid = false;
        }

        if (danneggiato.checked) {
            var descr = document.getElementById('descrizioneDanno');
            var ok2 = descr.value.trim() !== '';
            descr.closest('.gmp-field-group').classList.toggle('has-error', !ok2);
            if (!ok2) valid = false;
        }

        return valid;
    }

    document.getElementById('gmpSalva').addEventListener('click', function () {
        if (!validate()) return;

        var btn = this;
        btn.disabled = true;
        feedback.textContent = '';
        feedback.className = 'gmp-feedback';

        fetch(GMP_BASE_URL + '/gestore/prodotti/modifica', {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: new FormData(form),
        })
            .then(function (res) { return res.json(); })
            .then(function (data) {
                btn.disabled = false;
                if (data.status === 'ok') {
                    feedback.textContent = data.message || 'Prodotto aggiornato con successo!';
                    feedback.classList.add('gmp-feedback--success');
                    setTimeout(function () { window.location.reload(); }, 900);
                } else {
                    feedback.textContent = data.message || 'Si è verificato un errore.';
                    feedback.classList.add('gmp-feedback--error');
                }
            })
            .catch(function () {
                btn.disabled = false;
                feedback.textContent = 'Errore di comunicazione con il server. Riprova.';
                feedback.classList.add('gmp-feedback--error');
            });
    });
})();
</script>