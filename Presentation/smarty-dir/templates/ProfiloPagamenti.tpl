{extends file="common/layout.tpl"}

{block name="extra_css"}
    <link rel="stylesheet" href="{$base_url}/css/ProfiloPagamenti.css">
{/block}

{block name="content"}
<div class="pagamenti-container">
    <div class="container">

        {* ── TOPBAR ── *}
        <div class="pagamenti-topbar">
            <a href="{$base_url}/profilo" class="pagamenti-back-link">
                <i class="ti ti-arrow-left"></i> Torna all'Area Personale
            </a>
        </div>

        {* ── HEADER ── *}
        <div class="pagamenti-header">
            <div class="pagamenti-header-text">
                <span class="pagamenti-eyebrow">Area Personale</span>
                <h1 class="pagamenti-titolo">
                    <i class="ti ti-credit-card"></i> I Miei Metodi di Pagamento
                </h1>
            </div>

            <div class="pagamenti-header-actions">
                {if isset($carte) && $carte|@count > 0}
                    <div class="pagamenti-count-badge">
                        <span class="pagamenti-count-num">{$carte|@count}</span>
                        <span class="pagamenti-count-label">{if $carte|@count == 1}carta{else}carte{/if}</span>
                    </div>
                {/if}

                <button type="button" class="pagamenti-add-btn" id="pagamenti-btn-aggiungi" title="Aggiungi nuova carta">
                    <i class="ti ti-plus"></i>
                </button>
            </div>
        </div>

        {* ── LISTA CARTE ── *}
        {if isset($carte) && $carte|@count > 0}
            <div class="pagamenti-list" id="pagamenti-list">
                {foreach $carte as $carta}
                    {* -- 'predefinito' non ancora restituito da cartaToArray(): in attesa di implementazione lato Control -- *}
                    <div class="pagamenti-card {if isset($carta.predefinito) && $carta.predefinito}pagamenti-card-predefinito{/if}" id="pagamenti-card-{$carta.id|escape}">

                        <div class="pagamenti-card-top">
                            <span class="pagamenti-card-icon"><i class="ti ti-credit-card"></i></span>
                            {if isset($carta.predefinito) && $carta.predefinito}
                                <span class="pagamenti-predefinito-badge">
                                    <i class="ti ti-star-filled"></i> Predefinito
                                </span>
                            {/if}
                        </div>

                        <div class="pagamenti-numero-mascherato">
                            •••• •••• •••• {$carta.ultimeQuattroCifre|escape}
                        </div>

                        <div class="pagamenti-info-list">
                            <div class="pagamenti-info-row">
                                <i class="ti ti-user"></i>
                                <span class="pagamenti-info-value">{$carta.titolare|escape}</span>
                            </div>
                            <div class="pagamenti-info-row">
                                <i class="ti ti-calendar"></i>
                                <span class="pagamenti-info-value">Scadenza {$carta.scadenza|escape}</span>
                            </div>
                        </div>

                        <div class="pagamenti-actions">
                            {if !isset($carta.predefinito) || !$carta.predefinito}
                                <button type="button" class="pagamenti-btn-predefinito" data-id="{$carta.id|escape}">
                                    <i class="ti ti-star"></i> Imposta come predefinito
                                </button>
                            {/if}

                            <button type="button" class="pagamenti-btn-elimina" data-id="{$carta.id|escape}">
                                <i class="ti ti-trash"></i> Elimina
                            </button>
                        </div>

                    </div>
                {/foreach}
            </div>
        {else}
            {* ── STATO VUOTO ── *}
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
        {/if}

        {* ── POPUP FORM (solo aggiungi) ── *}
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

        {* ── POPUP CONFERMA ELIMINAZIONE ── *}
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

        {* ── POPUP MESSAGGI (feedback errore generico) ── *}
        <div class="pagamenti-popup-overlay" id="pagamenti-popup" hidden>
            <div class="pagamenti-popup-box pagamenti-popup-box-confirm">
                <i class="ti ti-alert-triangle pagamenti-popup-icon"></i>
                <p class="pagamenti-popup-message" id="pagamenti-popup-message"></p>
                <button type="button" class="pagamenti-form-btn-primary" id="pagamenti-popup-close">Chiudi</button>
            </div>
        </div>

    </div>
</div>
{/block}

{block name="extra_js"}
<script>
{literal}
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

            fetch('{/literal}{$base_url}{literal}/pagamenti/aggiungi', {
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
            fetch('{/literal}{$base_url}{literal}/pagamenti/elimina', {
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

            fetch('{/literal}{$base_url}{literal}/pagamenti/predefinito', {
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
{/literal}
</script>
{/block}