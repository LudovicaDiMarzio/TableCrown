{*
  TableCrown\Presentation\Views\Gestore - Hub Gestore (Dashboard)
  Estende layout_gestore.tpl.

  Variabili specifiche di pagina (da CGestore::mostraDashboardGestore()):
    $ordiniTotali   => int
    $venditeTotali  => float
    $prossimiEventi => array di eventi mappati (mappaEvento() -> serataToArray/torneoToArray/challengeToArray)
      ognuno ha almeno: idEvento, nomeEvento, imgEvento, dataInizio, maxPartecipanti,
      statoEvento, numeroPartecipanti, richiedeQuota, postiDisponibili, tipo
      + campi specifici per tipo ('torneo'/'challenge': quotaIscrizione, premio, gioco/tornei)

  NB: qui NON ci sono "eventi attivi", "partecipanti totali", "ordini recenti",
  "avvisi" o grafici vendite: il controller non li passa, quindi non sono in questa vista.
*}
{extends file="layout_gestore.tpl"}

{block name="page_css"}
    <link rel="stylesheet" href="{$base_url}/css/hub_gestore.css">
{/block}

{block name="content"}
    <div class="hub-header">
        <h1 class="hub-header__title">Dashboard Gestore</h1>
        <p class="hub-header__subtitle">Panoramica delle attività del negozio</p>
    </div>

    {* ---------- STATISTICHE (solo i 2 dati realmente disponibili) ---------- *}
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

        {* ---------- PROSSIMI EVENTI ---------- *}
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
                        {* Mappo il tipo evento sull'url plurale corretta della sezione gestore *}
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

            <a href="{$base_url}/gestore/eventi/serate" class="hub-panel__more">Vedi tutti gli eventi &rarr;</a>
        </section>

        {* ---------- AZIONI RAPIDE ---------- *}
        <section class="hub-panel hub-panel--actions">
            <div class="hub-panel__header">
                <h2 class="hub-panel__title">Azioni rapide</h2>
            </div>

            <div class="hub-quick-actions">
                {* TODO T1: verificare che queste route GET esistano per mostrare i form di creazione *}
                <a href="{$base_url}/gestore/catalogo/giochi-da-tavolo/nuovo" class="hub-quick-action">
                    <span class="ti ti-plus"></span> Aggiungi prodotto
                </a>
                <a href="{$base_url}/gestore/eventi/serate/nuovo" class="hub-quick-action hub-quick-action--gold">
                    <span class="ti ti-moon-stars"></span> Crea Serata
                </a>
                <a href="{$base_url}/gestore/eventi/tornei/nuovo" class="hub-quick-action hub-quick-action--gold">
                    <span class="ti ti-trophy"></span> Crea Torneo
                </a>
                <a href="{$base_url}/gestore/eventi/challenge/nuovo" class="hub-quick-action hub-quick-action--gold">
                    <span class="ti ti-swords"></span> Crea Challenge
                </a>
            </div>
        </section>

    </div>
{/block}