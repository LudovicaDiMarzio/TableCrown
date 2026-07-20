{*
  TableCrown\Presentation\Views\Gestore - Modifica Prodotto (Porta Dadi)
  Estende layout_gestore.tpl.
  Struttura identica a gestore_modifica_bustine.tpl (nessuna sezione danno,
  riservata a EGiocoDaTavolo). File separato solo per coerenza 1:1 con
  i 3 tipi di prodotto e per isolare eventuali differenze future.

  Variabili di pagina attese:
    $prodotto => prodottoToArray() ESTESO con:
      id, nome, immagine, tipo, tipoSlug, quantita, prezzo, disponibilita,
      sconto (bool), percentuale_sconto, scadenza_sconto (Y-m-d|null)

  TODO T1/T3: EPrezzo non espone la valuta in prodottoToArray(); qui assumiamo EUR.
*}
{extends file="layout_gestore.tpl"}

{block name="page_css"}
    <link rel="stylesheet" href="{$base_url}/css/gestore_prodotti.css">
    <link rel="stylesheet" href="{$base_url}/css/gestore_modifica_prodotto.css">
{/block}

{block name="content"}

<div class="gmod-container">

    {* ── HEADER: riepilogo prodotto ── *}
    <div class="gmod-header">
        <img src="{$prodotto.immagine}" alt="{$prodotto.nome|escape}" class="gmod-header__img">
        <div class="gmod-header__info">
            <span class="gmod-header__type">{$prodotto.tipo|escape}</span>
            <h1 class="gmod-header__title">{$prodotto.nome|escape}</h1>
            <div class="gmod-header__meta">
                <span class="gmod-header__badge gmod-header__badge--{$prodotto.disponibilita|lower|replace:' ':'_'}">{$prodotto.disponibilita}</span>
                <span class="gmod-header__price">
                    {if $prodotto.sconto}
                        <s>&euro;{$prodotto.prezzo|number_format:2}</s>
                        &euro;{$prodotto.prezzo_scontato|number_format:2}
                    {else}
                        &euro;{$prodotto.prezzo|number_format:2}
                    {/if}
                </span>
            </div>
        </div>
        <button type="button" class="gmod-btn-delete" onclick="eliminaProdotto()">
            <i class="ti ti-trash"></i> Elimina prodotto
        </button>
    </div>

    <div class="gmod-grid gmod-grid--senza-danno">

        {* ── QUANTITÀ (AJAX, stepper) ── *}
        <section class="gmod-card">
            <h2 class="gmod-card__title"><i class="ti ti-package"></i> Quantità in magazzino</h2>
            <div class="gmod-stepper" data-id-prodotto="{$prodotto.id}">
                <button type="button" class="gmod-stepper__btn" onclick="aggiornaQuantita(-1)" aria-label="Diminuisci quantità">
                    <i class="ti ti-minus"></i>
                </button>
                <span class="gmod-stepper__value" id="quantitaValue">{$prodotto.quantita}</span>
                <button type="button" class="gmod-stepper__btn" onclick="aggiornaQuantita(1)" aria-label="Aumenta quantità">
                    <i class="ti ti-plus"></i>
                </button>
            </div>
        </section>

        {* ── SCONTO PROMOZIONALE ── *}
        <section class="gmod-card">
            <h2 class="gmod-card__title"><i class="ti ti-discount-2"></i> Sconto promozionale</h2>

            <form method="post" action="{$base_url}/gestore/prodotti/modifica" class="gmod-form">
                <input type="hidden" name="id_prodotto" value="{$prodotto.id}">

                <label class="gmod-toggle">
                    <input type="checkbox" name="modificaSconto" value="1" id="toggleSconto"
                           {if $prodotto.sconto}checked{/if}
                           onchange="document.getElementById('scontoFields').hidden = !this.checked">
                    Applica / aggiorna sconto
                </label>

                <div id="scontoFields" class="gmod-form__subfields" {if !$prodotto.sconto}hidden{/if}>
                    <div class="gmod-form__row">
                        <label class="gmod-form__label" for="valoreSconto">Percentuale sconto (%)</label>
                        <input type="number" class="gmod-form__input" id="valoreSconto" name="valoreSconto"
                               min="0" max="100" step="0.01"
                               value="{$prodotto.percentuale_sconto|default:''}">
                    </div>
                    <div class="gmod-form__row">
                        <label class="gmod-form__label" for="scadenzaOfferta">Scadenza (facoltativa)</label>
                        <input type="date" class="gmod-form__input" id="scadenzaOfferta" name="scadenzaOfferta"
                               value="{$prodotto.scadenza_sconto|default:''}">
                        <span class="gmod-form__hint">Lascia vuoto per uno sconto permanente</span>
                    </div>
                </div>

                <div class="gmod-form__actions">
                    <button type="submit" class="gmod-btn-save">
                        <i class="ti ti-device-floppy"></i> Salva sconto
                    </button>
                    {if $prodotto.sconto}
                        <button type="submit" name="rimuoviSconto" value="1" class="gmod-btn-remove"
                                onclick="return confirm('Rimuovere lo sconto attivo su questo prodotto?')">
                            <i class="ti ti-x"></i> Rimuovi sconto
                        </button>
                    {/if}
                </div>
            </form>
        </section>

    </div>

</div>

{/block}

{block name="extra_js"}
<script>
    function aggiornaQuantita(delta) {
        const container = document.querySelector('.gmod-stepper');
        const idProdotto = container.dataset.idProdotto;
        const valueEl = document.getElementById('quantitaValue');

        fetch('{$base_url}/gestore/prodotti/quantita', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id_prodotto: idProdotto, delta_quantita: delta })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'ok') {
                valueEl.textContent = data.quantita;
            } else {
                alert(data.message || 'Errore durante l\'aggiornamento della quantità.');
            }
        })
        .catch(() => alert('Errore di rete durante l\'aggiornamento della quantità.'));
    }

    function eliminaProdotto() {
        if (!confirm('Confermi la rimozione di questo prodotto dal catalogo? L\'operazione non cancella lo storico recensioni.')) return;

        fetch('{$base_url}/gestore/catalogo/prodotto/elimina', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id_prodotto: {$prodotto.id} })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'ok') {
                window.location.href = '{$base_url}/gestore/prodotti';
            } else {
                alert(data.message || 'Errore durante la rimozione del prodotto.');
            }
        })
        .catch(() => alert('Errore di rete durante la rimozione del prodotto.'));
    }
</script>
{/block}