{extends file="layout_gestore.tpl"}

{block name="page_css"}
    <link rel="stylesheet" href="{$base_url}/css/hub_gestore.css">
{/block}


{block name="content"}
    <div class="hub-header">
        <h1 class="hub-header__title">Dashboard Gestore</h1>
        <p class="hub-header__subtitle">Panoramica delle attività del negozio</p>
    </div>

    <div class="hub-stats">
        <div class="hub-stat-card">
            <span class="hub-stat-card__icon hub-stat-card__icon--orders"><span class="ti ti-shopping-cart"></span></span>
            <div class="hub-stat-card__body">
                <span class="hub-stat-card__label">Ordini totali</span>
                <span class="hub-stat-card__value">{$ordiniTotali}</span>
            </div>
        </div>

        <div class="hub-stat-card">
            <span class="hub-stat-card__icon hub-stat-card__icon--sales"><span class="ti ti-currency-euro"></span></span>
            <div class="hub-stat-card__body">
                <span class="hub-stat-card__label">Vendite totali</span>
                <span class="hub-stat-card__value">&euro; {$venditeTotali|number_format:2:",":"."}</span>
            </div>
        </div>
    </div>

    <div class="hub-grid">

        <section class="hub-panel hub-panel--events">
            <div class="hub-panel__header">
                <h2 class="hub-panel__title">Prossimi Eventi</h2>
                <span class="hub-panel__count">{$prossimiEventi|@count}</span>
            </div>

            {if $prossimiEventi|@count === 0}
                <p class="hub-empty">Nessun evento in programma al momento.</p>
            {else}
                <div class="hub-event-list">
                    {foreach $prossimiEventi as $evento}
                        {if $evento.tipo === 'serata'}
                            {assign var="urlTipoEvento" value="serate"}
                            {assign var="labelTipoEvento" value="Serata"}
                        {elseif $evento.tipo === 'torneo'}
                            {assign var="urlTipoEvento" value="tornei"}
                            {assign var="labelTipoEvento" value="Torneo"}
                        {else}
                            {assign var="urlTipoEvento" value="challenge"}
                            {assign var="labelTipoEvento" value="Challenge"}
                        {/if}

                        <article class="hub-event-card">
                            <img src="{$evento.imgEvento}" alt="{$evento.nomeEvento}" class="hub-event-card__img">
                            <div class="hub-event-card__body">
                                <span class="hub-event-card__type">{$labelTipoEvento}</span>
                                <h3 class="hub-event-card__name">{$evento.nomeEvento}</h3>
                                <span class="hub-event-card__date">
                                    <span class="ti ti-calendar"></span>
                                    {$evento.dataInizio|date_format:"%d %B %Y"}
                                </span>
                                <span class="hub-event-card__seats">
                                    <span class="ti ti-users"></span>
                                    {$evento.numeroPartecipanti} / {$evento.maxPartecipanti} iscritti
                                </span>
                            </div>
                            <div class="hub-event-card__actions">
                                <span class="hub-status-badge hub-status-badge--{$evento.statoEvento|lower}">{$evento.statoEvento}</span>
                                <a href="{$base_url}/gestore/eventi/{$urlTipoEvento}" class="hub-btn hub-btn--ghost">Gestisci</a>
                            </div>
                        </article>
                    {/foreach}
                </div>
            {/if}

            
        </section>

        <section class="hub-panel hub-panel--actions">
            <div class="hub-panel__header">
                <h2 class="hub-panel__title">Azioni rapide</h2>
            </div>

            <div class="hub-quick-actions">
                <button type="button" class="hub-quick-action" id="btnAggiungiProdotto">
                    <span class="ti ti-plus"></span> Aggiungi prodotto
                </button>
                <a href="{$base_url}/gestore/crea/serata" class="hub-quick-action hub-quick-action--gold">
                    <span class="ti ti-moon-stars"></span> Crea Serata
                </a>
                <a href="{$base_url}/gestore/crea/torneo" class="hub-quick-action hub-quick-action--gold">
                    <span class="ti ti-trophy"></span> Crea Torneo
                </a>
                <a href="{$base_url}/gestore/crea/challenge" class="hub-quick-action hub-quick-action--gold">
                    <span class="ti ti-swords"></span> Crea Challenge
                </a>
            </div>
        </section>

    </div>

    {* ---------- MODALE SCELTA TIPO PRODOTTO ---------- *}
    <div class="hub-modal-overlay" id="modalAggiungiProdotto">
        <div class="hub-modal" role="dialog" aria-modal="true" aria-labelledby="modalAggiungiProdottoTitle">
            <div class="hub-modal__header">
                <h2 class="hub-modal__title" id="modalAggiungiProdottoTitle">Che tipo di prodotto vuoi aggiungere?</h2>
                <button type="button" class="hub-modal__close" id="btnChiudiModaleProdotto" aria-label="Chiudi">
                    <span class="ti ti-x"></span>
                </button>
            </div>
            <div class="hub-modal__body">
                <a href="{$base_url}/gestore/crea/giochi-da-tavolo" class="hub-modal-choice">
                    <span class="ti ti-dice hub-modal-choice__icon"></span>
                    <span class="hub-modal-choice__label">Gioco</span>
                </a>
                <a href="{$base_url}/gestore/crea/bustine" class="hub-modal-choice">
                    <span class="ti ti-cards hub-modal-choice__icon"></span>
                    <span class="hub-modal-choice__label">Bustina</span>
                </a>
                <a href="{$base_url}/gestore/crea/porta-dadi" class="hub-modal-choice">
                    <span class="ti ti-box hub-modal-choice__icon"></span>
                    <span class="hub-modal-choice__label">Portadadi</span>
                </a>
            </div>
        </div>
    </div>

    <script>
        (function () {
            var btnApri   = document.getElementById('btnAggiungiProdotto');
            var overlay   = document.getElementById('modalAggiungiProdotto');
            var btnChiudi = document.getElementById('btnChiudiModaleProdotto');

            function apriModale() {
                overlay.classList.add('hub-modal-overlay--visibile');
                document.body.classList.add('hub-modal-open');
            }

            function chiudiModale() {
                overlay.classList.remove('hub-modal-overlay--visibile');
                document.body.classList.remove('hub-modal-open');
            }

            if (btnApri) {
                btnApri.addEventListener('click', apriModale);
            }
            if (btnChiudi) {
                btnChiudi.addEventListener('click', chiudiModale);
            }
            if (overlay) {
                overlay.addEventListener('click', function (e) {
                    if (e.target === overlay) chiudiModale();
                });
            }
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') chiudiModale();
            });
        })();
    </script>
{/block}