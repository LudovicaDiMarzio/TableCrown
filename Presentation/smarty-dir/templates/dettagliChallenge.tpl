{extends file="common/layout.tpl"}

{* ============================================================
   dettagliChallenge.tpl
   Variabili attese dal controller in $challenge:
     - id
     - nome
     - immagine
     - data
     - postiLiberi
     - postiTotali
     - nomeAttivita
     - descrizione
     - prezzo
     - premio           ({id, nome, immagine} — prodotto in palio, opzionale)
     - tornei []        ({id, nome, immagine, data} — i tornei che
                          fanno parte della challenge, può essere vuoto)
   ============================================================ *}

{block name="content"}
<link rel="stylesheet" href="{$base_url}/css/dettagli.css">

<div class="dettaglio-container">
    <div class="container">

        <!-- ── BLOCCO SUPERIORE (con box prezzo) ── -->
        <div class="dettaglio-top dettaglio-top--con-prezzo">

            <div class="dettaglio-gallery">
                <img src="{$challenge.immagine}" alt="{$challenge.nome}" class="dettaglio-img">
            </div>

            <div class="dettaglio-info">
                <h1 class="dettaglio-nome" style="color: #2c3e7a;">{$challenge.nome}</h1>

                <ul class="dettaglio-meta">
                    <li><i class="ti ti-calendar-event"></i> {$challenge.data}</li>
                    <li><i class="ti ti-users"></i> {$challenge.postiLiberi} / {$challenge.postiTotali} posti liberi</li>
                    <li><i class="ti ti-chess-king"></i> {$challenge.nomeAttivita}</li>
                </ul>
            </div>

            <div class="dettaglio-prezzo-box">

                {if $challenge.premio}
                <a href="{$base_url}/prodotto/{$challenge.premio.id}" class="dettaglio-premio-card">
                    <div class="dettaglio-premio-img-wrapper">
                        <img src="{$challenge.premio.immagine}" alt="{$challenge.premio.nome}" class="dettaglio-premio-img">
                    </div>
                    <div class="dettaglio-premio-info">
                        <span class="dettaglio-premio-label">Premio in palio</span>
                        <span class="dettaglio-premio-nome">{$challenge.premio.nome}</span>
                    </div>
                </a>
                {/if}

                <div class="dettaglio-prezzo-tot">
                    <span class="dettaglio-prezzo-tot-label">Totale</span>
                    <span class="dettaglio-prezzo-tot-value" id="prezzo-tot-{$challenge.id}">€ {$challenge.prezzo}</span>
                </div>

                <button type="button" class="btn-iscriviti" data-id="{$challenge.id}" id="btn-iscriviti">
                    Iscriviti
                </button>
            </div>

        </div>

        <!-- ── DESCRIZIONE ── -->
        <div class="dettaglio-descrizione">
            <h2 class="dettaglio-section-title">Descrizione</h2>
            <p class="dettaglio-descrizione-testo">{$challenge.descrizione}</p>
        </div>

        <!-- ── TORNEI INCLUSI (se presenti) ── -->
        {if $challenge.tornei|@count > 0}
        <div class="dettaglio-correlati">
            <h2 class="dettaglio-section-title">Tornei inclusi</h2>
            <div class="dettaglio-correlati-grid">
                {foreach from=$challenge.tornei item=torneo}
                    <a href="{$base_url}/torneo/{$torneo.id}" class="dettaglio-correlato-card">
                        <div class="dettaglio-correlato-img-wrapper">
                            <img src="{$torneo.immagine}" alt="{$torneo.nome}" class="dettaglio-correlato-img">
                        </div>
                        <p class="dettaglio-correlato-nome">{$torneo.nome}</p>
                        <p class="dettaglio-correlato-data">{$torneo.data}</p>
                    </a>
                {/foreach}
            </div>
        </div>
        {/if}

    </div>
</div>

{* ── MODAL FEEDBACK ISCRIZIONE ── *}
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
    const btnIscriviti = document.getElementById('btn-iscriviti');

    const modalOverlay = document.getElementById('modal-prenotazione');
    const modalBox = document.getElementById('modal-prenotazione-box');
    const modalIcona = document.getElementById('modal-prenotazione-icona');
    const modalTitolo = document.getElementById('modal-prenotazione-titolo');
    const modalTesto = document.getElementById('modal-prenotazione-testo');
    const modalChiudi = document.getElementById('modal-prenotazione-chiudi');

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

    if (btnIscriviti) {
        btnIscriviti.addEventListener('click', function () {
            btnIscriviti.disabled = true;

            fetch("{/literal}{$base_url}{literal}/iscrizioneChallenge", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: "idChallenge=" + encodeURIComponent(btnIscriviti.dataset.id)
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
                            "Ti sei iscritto con successo a questa challenge. A presto!"
                        );
                    } else {
                        mostraModale(
                            false,
                            "Iscrizione non riuscita",
                            data.messaggio || "Non è stato possibile completare l'iscrizione. Riprova più tardi."
                        );
                    }
                })
                .catch(function () {
                    mostraModale(
                        false,
                        "Iscrizione non riuscita",
                        "Non è stato possibile completare l'iscrizione. Riprova più tardi o contatta lo staff."
                    );
                })
                .finally(function () {
                    btnIscriviti.disabled = false;
                });
        });
    }
})();
{/literal}
</script>
{/block}