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

                <button type="button" class="btn-iscriviti" data-id="{$challenge.id}">
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
{/block}