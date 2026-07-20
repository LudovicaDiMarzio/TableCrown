{*
  TableCrown\Presentation\Views\Gestore - Catalogo Serate
  Estende layout_gestore.tpl.

  Variabili specifiche di pagina (da BaseController::renderListaEventi(),
  chiamato da CGestore::mostraListaSerateGestore()):
    $eventi => array di serate mappate da serataToArray():
      idEvento, nomeEvento, imgEvento, dataInizio, maxPartecipanti,
      statoEvento, numeroPartecipanti, richiedeQuota, postiDisponibili,
      tipo ('serata'), tipoSerata
    $filtri => ['data' => string|null (Y-m-d), 'query_string' => string|null]

  NB: nessuna paginazione (PMfindSerate non usa limit/offset), nessun
  ordinamento (non esiste un equivalente di estraiFiltriPrezzo() per gli
  eventi). L'unico filtro reale disponibile è la data (estraiFiltroData()).

  AGGIORNATO secondo "Note di Control per interfacce gestore (eventi)":
  la card della lista, con modalita: 'gestore' in $datiPagina, mostra SOLO
  il pulsante "Vedi dettaglio" -> /gestore/eventi/dettaglio/{id}. Tutte le
  azioni sullo stato (Attiva, Concludi, Annulla, Modifica dati, Riprogramma)
  e, per Torneo/Challenge, la pubblicazione esiti, partono da lì e NON dalla
  card di lista. Rimossi quindi il pannello "Gestisci" e i form rapidi che
  avevo messo qui in precedenza.
*}
{extends file="layout_gestore.tpl"}

{block name="page_css"}
    <link rel="stylesheet" href="{$base_url}/css/eventi_gestore.css">
{/block}

{block name="content"}

<div class="gcat-container">

    {* ── HEADER: titolo, ricerca, crea nuova serata ── *}
    <div class="gcat-header">
        <div class="gcat-header__titles">
            <h1 class="gcat-header__title">Serate</h1>
            <p class="gcat-header__count">
                {assign var="tot" value=$eventi|default:[]|@count}
                {if $tot == 1}1 serata{else}{$tot} serate{/if}
            </p>
        </div>

        <div class="gcat-header__actions">
            {* La ricerca eventi è gestita da un controller/vista diversi
               (CGestore::mostraRisultatiRicercaEventiGestore), quindi la
               search box punta sempre lì, non resta sulla pagina corrente *}
            <form class="gcat-search-form" action="{$base_url}/gestore/eventi/ricerca" method="get">
                <input class="gcat-search-input" type="search" name="q" placeholder="Cerca tra tutti gli eventi..." aria-label="Cerca eventi">
                <button class="gcat-search-btn" type="submit" aria-label="Cerca">
                    <i class="ti ti-search"></i>
                </button>
            </form>

            {* TODO T1: verificare che questa route GET esista per mostrare il form di creazione *}
            <a href="{$base_url}/gestore/eventi/serate/nuovo" class="gcat-btn-create">
                <i class="ti ti-plus"></i> Nuova Serata
            </a>
        </div>
    </div>

    <div class="gcat-layout">

        {* ── SIDEBAR FILTRI (unico filtro reale: la data) ── *}
        <aside class="gcat-sidebar">
            <h3 class="gcat-filter-title"><i class="ti ti-filter"></i> Filtri</h3>

            <form method="get" action="{$base_url}/gestore/eventi/serate">
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
                    <a class="gcat-filter-reset" href="{$base_url}/gestore/eventi/serate">
                        <i class="ti ti-refresh"></i> Rimuovi filtro
                    </a>
                </div>
            </form>
        </aside>

        {* ── GRID SERATE ── *}
        <main class="gcat-grid">
            {if isset($eventi) && $eventi|@count > 0}
                {foreach $eventi as $evento}
                    {assign var="stato" value=$evento.statoEvento|lower}
                    <article class="gcat-card{if $stato == 'terminato'} gcat-card--concluded{/if}">

                        <div class="gcat-card__img-wrapper">
                            <img src="{$evento.imgEvento}" alt="{$evento.nomeEvento|escape}" class="gcat-card__img">
                            <span class="gcat-card__status gcat-card__status--{$stato}">{$evento.statoEvento}</span>
                            {if $evento.richiedeQuota}
                                <span class="gcat-card__quota">A pagamento</span>
                            {/if}
                        </div>

                        <div class="gcat-card__body">
                            <span class="gcat-card__type">{$evento.tipoSerata|escape}</span>
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
                            </div>
                        </div>

                        {* ── FOOTER: solo prezzo + "Vedi dettaglio" (unico pulsante ammesso in lista) ── *}
                        <div class="gcat-card__footer">
                            {if $evento.richiedeQuota}
                                <span class="gcat-card__price">A pagamento</span>
                            {else}
                                <span class="gcat-card__price-free">Gratuita</span>
                            {/if}
                            <a href="{$base_url}/gestore/eventi/dettaglio/{$evento.idEvento}" class="gcat-btn-manage">
                                <i class="ti ti-eye"></i> Vedi dettaglio
                            </a>
                        </div>
                    </article>
                {/foreach}
            {else}
                <div class="gcat-empty">
                    <span class="gcat-empty__icon"><i class="ti ti-moon-off"></i></span>
                    <h3 class="gcat-empty__title">Nessuna serata trovata</h3>
                    <p class="gcat-empty__text">
                        {if isset($filtri) && isset($filtri.data) && $filtri.data}
                            Non ci sono serate programmate per la data selezionata.
                        {else}
                            Non è stata ancora pubblicata nessuna serata.
                        {/if}
                    </p>
                    <a href="{$base_url}/gestore/eventi/serate/nuovo" class="gcat-btn-create">
                        <i class="ti ti-plus"></i> Crea la prima serata
                    </a>
                </div>
            {/if}
        </main>

    </div>

</div>

{/block}