{*
  TableCrown\Presentation\Views\Gestore - Catalogo Tornei
  Estende layout_gestore.tpl.

  Variabili specifiche di pagina (da CGestore::mostraListaTorneiGestore()):
    $eventi => array di tornei mappati da torneoToArray():
      idEvento, nomeEvento, imgEvento, dataInizio, maxPartecipanti,
      statoEvento, numeroPartecipanti, richiedeQuota, postiDisponibili,
      tipo ('torneo'), quotaIscrizione (float), premio (string, nome prodotto),
      gioco (string, nome gioco), challenge (['idEvento','nomeEvento']|null)
    $filtri => ['data' => string|null (Y-m-d), 'query_string' => string|null]

  NB: nessuna paginazione, nessun ordinamento (vedi nota in gestore_eventi_serate.tpl).

  AGGIORNATO secondo "Note di Control per interfacce gestore (eventi)":
  in lista la card mostra SOLO "Vedi dettaglio" -> /gestore/eventi/dettaglio/{id}.
  Il flusso "Aggiungi/Modifica esito" (podio torneo) descritto nella sezione 3
  del documento vive nella pagina di dettaglio (vista gestore_dettaglio_torneo),
  non qui: rimossi quindi il pannello "Gestisci" e i pulsanti rapidi
  Concludi/Annulla/Elimina/Riprogramma/Inserisci Esito che avevo messo in lista.
  Anche il link al sotto-evento "challenge" ora punta alla route di dettaglio
  unificata /gestore/eventi/dettaglio/{id} invece che a /gestore/eventi/challenge/{id}.
*}
{extends file="layout_gestore.tpl"}

{block name="page_css"}
    <link rel="stylesheet" href="{$base_url}/css/eventi_gestore.css">
{/block}

{block name="content"}

<div class="gcat-container">

    {* ── HEADER: titolo, ricerca, crea nuovo torneo ── *}
    <div class="gcat-header">
        <div class="gcat-header__titles">
            <h1 class="gcat-header__title">Tornei</h1>
            <p class="gcat-header__count">
                {assign var="tot" value=$eventi|default:[]|@count}
                {if $tot == 1}1 torneo{else}{$tot} tornei{/if}
            </p>
        </div>

        <div class="gcat-header__actions">
            <form class="gcat-search-form" action="{$base_url}/gestore/eventi/ricerca" method="get">
                <input class="gcat-search-input" type="search" name="q" placeholder="Cerca tra tutti gli eventi..." aria-label="Cerca eventi">
                <button class="gcat-search-btn" type="submit" aria-label="Cerca">
                    <i class="ti ti-search"></i>
                </button>
            </form>

            {* TODO T1: verificare che questa route GET esista per mostrare il form di creazione *}
            <a href="{$base_url}/gestore/eventi/tornei/nuovo" class="gcat-btn-create">
                <i class="ti ti-plus"></i> Nuovo Torneo
            </a>
        </div>
    </div>

    <div class="gcat-layout">

        {* ── SIDEBAR FILTRI ── *}
        <aside class="gcat-sidebar">
            <h3 class="gcat-filter-title"><i class="ti ti-filter"></i> Filtri</h3>

            <form method="get" action="{$base_url}/gestore/eventi/tornei">
                <div class="gcat-filter-group">
                    <label class="gcat-filter-label" for="filtro-data">Data evento</label>
                    <input type="date"
                           class="gcat-filter-date"
                           id="filtro-data"
                           name="filtro_data"
                           value="{if isset($filtri) && isset($filtri.data)}{$filtri.data}{/if}"
                           onchange="this.form.submit()">
                </div>

                <div class="gcat-filter-actions">
                    <a class="gcat-filter-reset" href="{$base_url}/gestore/eventi/tornei">
                        <i class="ti ti-refresh"></i> Rimuovi filtro
                    </a>
                </div>
            </form>
        </aside>

        {* ── GRID TORNEI ── *}
        <main class="gcat-grid">
            {if isset($eventi) && $eventi|@count > 0}
                {foreach $eventi as $evento}
                    {assign var="stato" value=$evento.statoEvento|lower}
                    <article class="gcat-card{if $stato == 'terminato'} gcat-card--concluded{/if}">

                        <div class="gcat-card__img-wrapper">
                            <img src="{$evento.imgEvento}" alt="{$evento.nomeEvento|escape}" class="gcat-card__img">
                            <span class="gcat-card__status gcat-card__status--{$stato}">{$evento.statoEvento}</span>
                            {if $evento.richiedeQuota}
                                <span class="gcat-card__quota">&euro;{$evento.quotaIscrizione|number_format:2}</span>
                            {/if}
                        </div>

                        <div class="gcat-card__body">
                            <span class="gcat-card__type">Torneo &middot; {$evento.gioco|escape}</span>
                            <h3 class="gcat-card__name">{$evento.nomeEvento|escape}</h3>

                            <div class="gcat-card__meta">
                                <span class="gcat-card__meta-row">
                                    <i class="ti ti-calendar"></i> {$evento.dataInizio|date_format:"%d %B %Y, %H:%M"}
                                </span>
                                <span class="gcat-card__meta-row{if $evento.postiDisponibili <= 0} gcat-card__seats-full{/if}">
                                    <i class="ti ti-users"></i>
                                    {$evento.numeroPartecipanti} / {$evento.maxPartecipanti} iscritti
                                    {if $evento.postiDisponibili <= 0}&mdash; Al completo{/if}
                                </span>
                                <span class="gcat-card__meta-row">
                                    <i class="ti ti-gift"></i> Premio: {$evento.premio|escape}
                                </span>
                                {if $evento.challenge}
                                    <span class="gcat-card__meta-row">
                                        <i class="ti ti-swords"></i>
                                        Parte della challenge
                                        <a href="{$base_url}/gestore/eventi/dettaglio/{$evento.challenge.idEvento}" class="gcat-card__sub-event-tag">{$evento.challenge.nomeEvento|escape}</a>
                                    </span>
                                {/if}
                            </div>
                        </div>

                        {* ── FOOTER: solo prezzo + "Vedi dettaglio" (unico pulsante ammesso in lista) ── *}
                        <div class="gcat-card__footer">
                            {if $evento.richiedeQuota}
                                <span class="gcat-card__price">&euro;{$evento.quotaIscrizione|number_format:2}</span>
                            {else}
                                <span class="gcat-card__price-free">Gratuito</span>
                            {/if}
                            <a href="{$base_url}/gestore/eventi/dettaglio/{$evento.idEvento}" class="gcat-btn-manage">
                                <i class="ti ti-eye"></i> Vedi dettaglio
                            </a>
                        </div>
                    </article>
                {/foreach}
            {else}
                <div class="gcat-empty">
                    <span class="gcat-empty__icon"><i class="ti ti-trophy-off"></i></span>
                    <h3 class="gcat-empty__title">Nessun torneo trovato</h3>
                    <p class="gcat-empty__text">
                        {if isset($filtri) && isset($filtri.data) && $filtri.data}
                            Non ci sono tornei programmati per la data selezionata.
                        {else}
                            Non è stato ancora pubblicato nessun torneo.
                        {/if}
                    </p>
                    <a href="{$base_url}/gestore/eventi/tornei/nuovo" class="gcat-btn-create">
                        <i class="ti ti-plus"></i> Crea il primo torneo
                    </a>
                </div>
            {/if}
        </main>

    </div>

</div>

{/block}