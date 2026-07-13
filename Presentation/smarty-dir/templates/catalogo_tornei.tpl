{extends file="common/layout.tpl"}

{block name="content"}
<link rel="stylesheet" href="{$base_url}/css/catalogo_tornei.css">

<div class="eventi-lista-container">
    <div class="container">

        {if isset($breadcrumbs) && $breadcrumbs|@count > 0}
        <nav class="eventi-breadcrumb">
            {foreach $breadcrumbs as $crumb}
                {if $crumb@last}
                    <span>{$crumb.label|escape}</span>
                {else}
                    <a href="{$crumb.url|escape}">{$crumb.label|escape}</a>
                    <i class="ti ti-chevron-right"></i>
                {/if}
            {/foreach}
        </nav>
        {/if}

        <div class="eventi-lista-layout">

            <aside class="eventi-sidebar">
                <h2 class="eventi-filtri-title">Filtri</h2>

                <form id="form-filtri-eventi" class="eventi-filtri-form" method="get" action="{$base_url}/catalogo/tornei">

                    <div class="eventi-filter-group">
                        <h3 class="eventi-filter-group-title">Cerca</h3>
                        <input type="text"
                               name="query_string"
                               class="eventi-ricerca-input"
                               placeholder="Cerca per nome..."
                               value="{$filtri.query_string|default:''|escape}">
                    </div>

                    <div class="eventi-filter-group eventi-filter-group-last">
                        <h3 class="eventi-filter-group-title">Data</h3>
                        <input type="date" name="data" class="eventi-date-input" value="{$filtri.data|default:''}">
                        <button type="submit" class="button btn-apply-data">
                            <i class="ti ti-check"></i> Applica filtri
                        </button>
                    </div>

                </form>
            </aside>

            <div class="eventi-lista-main">
                <div class="eventi-grid">
                    {foreach from=$eventi item=evento}
                    {assign var="stato" value=$evento.statoEvento}
                    {assign var="passato" value=($stato == 'Terminato')}
                    {assign var="postiDisponibili" value=$evento.maxPartecipanti - $evento.numeroPartecipanti}
                    {assign var="esaurito" value=($postiDisponibili <= 0)}

                    <article class="evento-list-card{if $passato} evento-list-card-passato{/if}{if $esaurito} evento-list-card-esaurito{/if}">

                        {if $esaurito}
                        <span class="evento-badge-esaurito">Posti esauriti</span>
                        {/if}

                        <h3 class="evento-list-nome">
                            {$evento.nomeEvento|escape}
                            {if $passato}<span class="evento-passato-label">(passato)</span>{/if}
                        </h3>

                        <div class="evento-list-image-wrapper">
                            <img src="{$base_url}/image/eventi/{$evento.imgEvento|escape}"
                                 alt="{$evento.nomeEvento|escape}"
                                 class="evento-list-image">
                        </div>

                        <div class="evento-list-meta-row">
                            <span class="evento-tipo-badge">{$evento.gioco|escape}</span>
                            <span class="evento-prezzo">
                                {$evento.quotaIscrizione|string_format:"%.2f"} €
                            </span>
                        </div>

                        <div class="evento-list-info-row">
                            <span class="evento-data">
                                <i class="ti ti-calendar"></i> {$evento.dataInizio|date_format:"%d/%m/%Y"}
                            </span>
                            <span class="evento-ora">
                                <i class="ti ti-clock"></i> {$evento.dataInizio|date_format:"%H:%M"}
                            </span>
                        </div>

                        <div class="evento-posti">
                            Posti disponibili: <strong>{$postiDisponibili}/{$evento.maxPartecipanti}</strong>
                        </div>

                        {if $evento.challenge}
                        <a href="{$base_url}/eventi/dettaglio/{$evento.challenge.idEvento}" class="evento-challenge-link">
                            <i class="ti ti-trophy"></i> Fa parte della challenge: {$evento.challenge.nomeEvento|escape}
                        </a>
                        {/if}

                        <div class="evento-list-actions">
                            {if $passato}
                                <a href="{$base_url}/eventi/risultati/{$evento.idEvento}" class="btn-evento-secondary">
                                    Visualizza risultati
                                </a>
                            {else}
                                <a href="{$base_url}/eventi/dettaglio/{$evento.idEvento}" class="btn-evento-primary">
                                    Scopri di più
                                </a>
                            {/if}
                        </div>

                    </article>
                    {foreachelse}
                    <p class="eventi-lista-empty">Nessun torneo trovato.</p>
                    {/foreach}
                </div>
            </div>

        </div>
    </div>
</div>
{/block}