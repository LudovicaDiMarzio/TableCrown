{*
  TableCrown\Presentation\Views\Gestore - Catalogo Challenge
  Estende layout_gestore.tpl.

  Variabili specifiche di pagina (da CGestore::mostraListaChallengeGestore()):
    $eventi => array di challenge mappate da challengeToArray():
      idEvento, nomeEvento, imgEvento, dataInizio, maxPartecipanti,
      statoEvento, numeroPartecipanti, richiedeQuota, postiDisponibili,
      tipo ('challenge'), quotaIscrizione (float), premio (string, nome prodotto),
      tornei (array di ['idEvento','nomeEvento'])

  NB: nessuna paginazione, nessun ordinamento (vedi nota in gestore_eventi_serate.tpl).
  NB2: 'punteggi'/'classificaFinale'/'classificaGenerata'/'torneiSenzaEsito' esistono
  solo nel dettaglio (costruisciDatiVistaEvento), non qui in lista.

  AGGIORNATO secondo "Note di Control per interfacce gestore (eventi)":
  in lista la card mostra SOLO "Vedi dettaglio" -> /gestore/eventi/dettaglio/{id}.
  L'intero flusso della sezione 4 (elenco tornei della challenge con esito
  singolo, avviso torneiSenzaEsito, pulsante "Genera classifica finale" o
  classifica finale già pubblicata) vive nella pagina di dettaglio
  (vista gestore_dettaglio_challenge), non qui: rimossi quindi il pannello
  "Gestisci", i pulsanti rapidi Concludi/Annulla/Elimina/Riprogramma,
  "Inserisci Esito" e "Genera Classifica" che avevo messo in lista.
  Anche i link ai tornei figli ora puntano alla route di dettaglio unificata
  /gestore/eventi/dettaglio/{id} invece che a /gestore/eventi/tornei/{id}.

  FIX: il pulsante "Nuova Challenge" puntava a /gestore/eventi/challenge/nuovo,
  route inesistente. La route reale (vedi CGestore::mostraFormCreaChallenge())
  è GET /gestore/crea/challenge.
*}
{extends file="layout_gestore.tpl"}

{block name="page_css"}
    <link rel="stylesheet" href="{$base_url}/css/eventi_gestore.css">
{/block}

{block name="content"}

<div class="gcat-container">

    {* ── HEADER: titolo, ricerca, crea nuova challenge ── *}
    <div class="gcat-header">
        <div class="gcat-header__titles">
            <h1 class="gcat-header__title">Challenge</h1>
            <p class="gcat-header__count">
                {assign var="tot" value=$eventi|default:[]|@count}
                {if $tot == 1}1 challenge{else}{$tot} challenge{/if}
            </p>
        </div>

        <div class="gcat-header__actions">
            <form class="gcat-search-form" onsubmit="filtraEventiClientSide(this.querySelector('input[name=q]')); return false;">
    <input class="gcat-search-input" type="search" name="q" placeholder="..." aria-label="Cerca eventi">
    <button class="gcat-search-btn" type="submit" aria-label="Cerca">
        <i class="ti ti-search"></i>
    </button>
</form>

            {* NB: creaChallenge() richiede tornei GIA' esistenti e non ancora assegnati
               (idTorneiSelezionati), quindi il form dovrà proporre solo quelli liberi. *}
            <a href="{$base_url}/gestore/crea/challenge" class="gcat-btn-create">
                <i class="ti ti-plus"></i> Nuova Challenge
            </a>
        </div>
    </div>

    <div class="gcat-layout">

        {* ── SIDEBAR FILTRI ── *}
        <aside class="gcat-sidebar">
            <h3 class="gcat-filter-title"><i class="ti ti-filter"></i> Filtri</h3>

            <form method="get" action="{$base_url}/gestore/eventi/challenge">
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
                    <a class="gcat-filter-reset" href="{$base_url}/gestore/eventi/challenge">
                        <i class="ti ti-refresh"></i> Rimuovi filtro
                    </a>
                </div>
            </form>
        </aside>

        {* ── GRID CHALLENGE ── *}
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
                            <span class="gcat-card__type">Challenge &middot; {$evento.tornei|@count} tornei</span>
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
                            </div>

                            {if $evento.tornei|@count > 0}
                                <div class="gcat-card__sub-events">
                                    {foreach $evento.tornei as $torneo}
                                        <a href="{$base_url}/gestore/eventi/dettaglio?id={$torneo.idEvento}" class="gcat-card__sub-event-tag">{$torneo.nomeEvento|escape}</a>
                                    {/foreach}
                                </div>
                            {/if}
                        </div>

                        {* ── FOOTER: solo prezzo + "Vedi dettaglio" (unico pulsante ammesso in lista) ── *}
                        <div class="gcat-card__footer">
                            {if $evento.richiedeQuota}
                                <span class="gcat-card__price">&euro;{$evento.quotaIscrizione|number_format:2}</span>
                            {else}
                                <span class="gcat-card__price-free">Gratuita</span>
                            {/if}
                            <a href="{$base_url}/gestore/eventi/dettaglio?id={$evento.idEvento}" class="gcat-btn-manage">
                                <i class="ti ti-eye"></i> Vedi dettaglio
                            </a>
                        </div>
                    </article>
                {/foreach}
            {else}
                <div class="gcat-empty">
                    <span class="gcat-empty__icon"><i class="ti ti-swords"></i></span>
                    <h3 class="gcat-empty__title">Nessuna challenge trovata</h3>
                    <p class="gcat-empty__text">
                        {if isset($filtri) && isset($filtri.data) && $filtri.data}
                            Non ci sono challenge programmate per la data selezionata.
                        {else}
                            Non è stata ancora pubblicata nessuna challenge.
                        {/if}
                    </p>
                    <a href="{$base_url}/gestore/crea/challenge" class="gcat-btn-create">
                        <i class="ti ti-plus"></i> Crea la prima challenge
                    </a>
                </div>
            {/if}
        </main>

    </div>

</div>
<script>
    function filtraEventiClientSide(input) {
    var query = input.value.trim().toLowerCase();
    var cards = document.querySelectorAll('.gcat-grid .gcat-card');

    cards.forEach(function (card) {
        var nomeEl = card.querySelector('.gcat-card__name');
        var nome = nomeEl ? nomeEl.textContent.toLowerCase() : '';
        card.style.display = (query === '' || nome.indexOf(query) !== -1) ? '' : 'none';
    });
}
</script>
{/block}