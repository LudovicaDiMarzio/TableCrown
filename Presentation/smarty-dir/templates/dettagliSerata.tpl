{extends file="common/layout.tpl"}

{* ============================================================
   dettagliSerata.tpl
   Variabili attese dal controller in $serata:
     - id
     - nome
     - immagine
     - data              (stringa già formattata, es. "12/09/2026")
     - postiLiberi
     - postiTotali
     - nomeAttivita      (es. "Catan", "Scacchi"...)
     - descrizione
   ============================================================ *}

{block name="content"}
<link rel="stylesheet" href="{$base_url}/css/dettagli.css">

<div class="dettaglio-container">
    <div class="container">

        <!-- ── BLOCCO SUPERIORE (senza box prezzo) ── -->
        <div class="dettaglio-top">

            <div class="dettaglio-gallery">
                <span class="dettaglio-badge-attivita">{$serata.nomeAttivita}</span>
                <img src="{$serata.immagine}" alt="{$serata.nome}" class="dettaglio-img">
            </div>

            <div class="dettaglio-info">
                <h1 class="dettaglio-nome dettaglio-nome--serata">{$serata.nome}</h1>

                <ul class="dettaglio-meta dettaglio-meta--card">
                    <li class="dettaglio-meta-item">
                        <span class="dettaglio-meta-item-icon"><i class="ti ti-calendar-event"></i></span>
                        <span class="dettaglio-meta-item-text">
                            <span class="dettaglio-meta-item-label">Data</span>
                            <span class="dettaglio-meta-item-value">{$serata.data}</span>
                        </span>
                    </li>
                    <li class="dettaglio-meta-item">
                        <span class="dettaglio-meta-item-icon"><i class="ti ti-chess-king"></i></span>
                        <span class="dettaglio-meta-item-text">
                            <span class="dettaglio-meta-item-label">Attività</span>
                            <span class="dettaglio-meta-item-value">{$serata.nomeAttivita}</span>
                        </span>
                    </li>
                </ul>

                <div class="dettaglio-disponibilita">
                    <div class="dettaglio-disponibilita-testo">
                        <span>Posti disponibili</span>
                        <span>{$serata.postiLiberi} / {$serata.postiTotali}</span>
                    </div>
                    <div class="dettaglio-disponibilita-bar">
                        <div class="dettaglio-disponibilita-fill{if $serata.postiTotali > 0 && ($serata.postiLiberi / $serata.postiTotali) <= 0.25} dettaglio-disponibilita-fill--scarsa{/if}"
                             style="width: {if $serata.postiTotali > 0}{($serata.postiLiberi / $serata.postiTotali) * 100}{else}0{/if}%;"></div>
                    </div>
                </div>

                <form method="POST" action="{$base_url}/eventi/partecipa" id="form-prenota">
                    <input type="hidden" name="id_evento" value="{$serata.id}">

                    <div class="dettaglio-azione-card">
                        <button type="submit" class="btn-partecipa" id="btn-prenota"
                                {if $serata.postiLiberi <= 0}disabled{/if}>
                            <i class="ti ti-calendar-check"></i>
                            {if $serata.postiLiberi <= 0}Posti esauriti{else}Prenota{/if}
                        </button>
                    </div>
                </form>
            </div>

        </div>

        <!-- ── DESCRIZIONE ── -->
        <div class="dettaglio-descrizione">
            <h2 class="dettaglio-section-title">Descrizione</h2>
            <p class="dettaglio-descrizione-testo">{$serata.descrizione}</p>
        </div>

    </div>
</div>


<script>
(function () {
    const maxPosti = parseInt("{$serata.postiLiberi|default:0}", 10);
    const input = document.getElementById('input-qty-posti');
    const btnMinus = document.getElementById('btn-qty-minus');
    const btnPlus = document.getElementById('btn-qty-plus');

    function clamp(val) {
        if (val < 1) return 1;
        if (val > maxPosti) return maxPosti;
        return val;
    }

    btnMinus.addEventListener('click', function () {
        input.value = clamp(parseInt(input.value, 10) - 1);
    });

    btnPlus.addEventListener('click', function () {
        input.value = clamp(parseInt(input.value, 10) + 1);
    });
})();
</script>
{/block}