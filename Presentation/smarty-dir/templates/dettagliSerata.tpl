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

        <nav class="dettaglio-breadcrumb">
            <a href="{$base_url}/">Home</a> / <a href="{$base_url}/eventi">Eventi</a> / {$serata.nome}
        </nav>

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

                <div class="dettaglio-azione-card">
                    <span class="dettaglio-azione-label">Quanti posti vuoi prenotare?</span>
                    <div class="dettaglio-azione-row">
                        <div class="dettaglio-qty" id="qty-prenota">
                            <button type="button" class="dettaglio-qty-btn" id="btn-qty-minus"
                                    {if $serata.postiLiberi <= 0}disabled{/if}>−</button>
                            <input type="number" class="dettaglio-qty-input" id="input-qty-posti"
                                   value="1" min="1" max="{$serata.postiLiberi}" readonly>
                            <button type="button" class="dettaglio-qty-btn" id="btn-qty-plus"
                                    {if $serata.postiLiberi <= 0}disabled{/if}>+</button>
                        </div>
                        <a href="#recensioni" class="dettaglio-recensioni-link" style="display:none;"></a>
                    </div>

                    <button type="button" class="btn-partecipa" data-id="{$serata.id}" id="btn-prenota"
                            {if $serata.postiLiberi <= 0}disabled{/if}>
                        <i class="ti ti-calendar-check"></i>
                        {if $serata.postiLiberi <= 0}Posti esauriti{else}Prenota{/if}
                    </button>
                </div>
            </div>

        </div>

        <!-- ── DESCRIZIONE ── -->
        <div class="dettaglio-descrizione">
            <h2 class="dettaglio-section-title">Descrizione</h2>
            <p class="dettaglio-descrizione-testo">{$serata.descrizione}</p>
        </div>

    </div>
</div>

{* ── MODAL FEEDBACK PRENOTAZIONE ── *}
<div class="dettaglio-modal-overlay" id="modal-prenotazione">
    <div class="dettaglio-modal-box" id="modal-prenotazione-box">
        <div class="dettaglio-modal-icona" id="modal-prenotazione-icona"></div>
        <h3 class="dettaglio-modal-titolo" id="modal-prenotazione-titolo"></h3>
        <p class="dettaglio-modal-testo" id="modal-prenotazione-testo"></p>
        <button type="button" class="button dettaglio-modal-chiudi" id="modal-prenotazione-chiudi">Chiudi</button>
    </div>
</div>

{/block}

{block name="extra_js"}
<script>
{literal}
(function () {
    const maxPosti = parseInt("{/literal}{$serata.postiLiberi|default:0}{literal}", 10);
    const input = document.getElementById('input-qty-posti');
    const btnMinus = document.getElementById('btn-qty-minus');
    const btnPlus = document.getElementById('btn-qty-plus');
    const btnPrenota = document.getElementById('btn-prenota');

    const modalOverlay = document.getElementById('modal-prenotazione');
    const modalBox = document.getElementById('modal-prenotazione-box');
    const modalIcona = document.getElementById('modal-prenotazione-icona');
    const modalTitolo = document.getElementById('modal-prenotazione-titolo');
    const modalTesto = document.getElementById('modal-prenotazione-testo');
    const modalChiudi = document.getElementById('modal-prenotazione-chiudi');

    function clamp(val) {
        if (val < 1) return 1;
        if (val > maxPosti) return maxPosti;
        return val;
    }

    if (btnMinus) {
        btnMinus.addEventListener('click', function () {
            input.value = clamp(parseInt(input.value, 10) - 1);
        });
    }

    if (btnPlus) {
        btnPlus.addEventListener('click', function () {
            input.value = clamp(parseInt(input.value, 10) + 1);
        });
    }

    function mostraModale(successo, titolo, testo) {
        modalBox.classList.remove('dettaglio-modal--successo', 'dettaglio-modal--errore');
        modalBox.classList.add(successo ? 'dettaglio-modal--successo' : 'dettaglio-modal--errore');
        modalIcona.innerHTML = successo
            ? '<i class="ti ti-check"></i>'
            : '<i class="ti ti-x"></i>';
        modalTitolo.textContent = titolo;
        modalTesto.textContent = testo;
        modalOverlay.classList.add('is-visibile');
    }

    function nascondiModale() {
        modalOverlay.classList.remove('is-visibile');
    }

    if (modalChiudi) modalChiudi.addEventListener('click', nascondiModale);
    if (modalOverlay) {
        modalOverlay.addEventListener('click', function (e) {
            if (e.target === modalOverlay) nascondiModale();
        });
    }
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') nascondiModale();
    });

    if (btnPrenota) {
        btnPrenota.addEventListener('click', function () {
            const posti = parseInt(input.value, 10);

            btnPrenota.disabled = true;

            fetch("{/literal}{$base_url}{literal}/prenotazioneSerata", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: "idSerata=" + encodeURIComponent(btnPrenota.dataset.id) + "&posti=" + encodeURIComponent(posti)
            })
                .then(function (res) {
                    if (!res.ok) throw new Error("Risposta non valida dal server");
                    return res.json();
                })
                .then(function (data) {
                    if (data.status === 'ok') {
                        mostraModale(
                            true,
                            "Iscrizione confermata",
                            "Hai prenotato " + posti + (posti === 1 ? " posto" : " posti") + " per questa serata. A presto!"
                        );
                    } else {
                        mostraModale(
                            false,
                            "Prenotazione non riuscita",
                            data.messaggio || "Non è stato possibile completare la prenotazione. Riprova più tardi."
                        );
                    }
                })
                .catch(function () {
                    mostraModale(
                        false,
                        "Prenotazione non riuscita",
                        "Non è stato possibile completare la prenotazione. Riprova più tardi o contatta lo staff."
                    );
                })
                .finally(function () {
                    btnPrenota.disabled = false;
                });
        });
    }
})();
{/literal}
</script>
{/block}