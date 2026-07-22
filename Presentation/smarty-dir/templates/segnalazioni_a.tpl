{* TableCrown\Presentation\Views - Admin
   segnalazioni_a.tpl - Lista recensioni segnalate.

   Variabili attese dal layer Control (CAmministratore::mostraListaRecensioniAdmin):
     $recensioni   => array, ognuna:
         ['id' => int, 'testo' => string, 'data' => 'Y-m-d H:i:s',
          'gravita' => 'alta'|'media'|'bassa',
          'idSegnalazioneDaRisolvere' => int,
          'autore' => ['id' => int, 'nome' => string],
          'prodotto' => ['id' => int, 'nome' => string],
          'numeroSegnalazioni' => int]
     $ordinamento  => string ('recenti'|'gravita'), valore corrente del filtro, echoato da $_GET
*}
{extends file="layout_admin.tpl"}

{block name="page_css"}
    <link rel="stylesheet" href="{$base_url}/css/segnalazioni_a.css">
{/block}

{block name="content"}
    <div class="segn">
        <div class="segn__heading">
            <div>
                <h1>Recensioni segnalate</h1>
                <p>Modera le recensioni segnalate dagli utenti</p>
            </div>

            <form class="segn__filtro" method="get" action="/admin/recensioni">
                
        </div>

        <div class="recensioni-list">
            {foreach $recensioni as $r}
                <article class="recensione-card">
                    <div class="recensione-card__header">
                        <div class="recensione-card__info">
                            <span class="recensione-card__prodotto">{$r.prodotto.nome}</span>
                            <span class="recensione-card__meta">
                                Autore: {$r.autore.nome} &middot; {$r.data|date_format:"%d/%m/%Y %H:%M"}
                            </span>
                        </div>
                        <div class="recensione-card__badges">
                            <span class="count-badge">{$r.numeroSegnalazioni} segnalazioni</span>
                            <span class="badge badge--{$r.gravita}">
                                {if $r.gravita === 'alta'}Alta
                                {elseif $r.gravita === 'media'}Media
                                {else}Bassa
                                {/if}
                            </span>
                        </div>
                    </div>

                    <p class="recensione-card__testo">{$r.testo}</p>

                    <div class="recensione-card__footer">
                        <a href="{$base_url}/admin/utente/profilo?id={$r.autore.id}" class="btn btn--outline">Controlla profilo</a>

                        <form method="post" action="{$base_url}/admin/recensioni/rigetta" class="recensione-card__form-elimina"
                              data-confirm-message="Rigettare questa segnalazione? La recensione resterà pubblicata.">
                            <input type="hidden" name="id_segnalazione" value="{$r.idSegnalazioneDaRisolvere}">
                            <button type="submit" class="btn btn--neutral">Rigetta segnalazione</button>
                        </form>

                        <form method="post" action="{$base_url}/admin/recensioni/elimina" class="recensione-card__form-elimina"
                              data-confirm-message="Eliminare definitivamente questa recensione?">
                            <input type="hidden" name="id_recensione" value="{$r.id}">
                            <input type="hidden" name="id_segnalazione" value="{$r.idSegnalazioneDaRisolvere}">
                            <button type="submit" class="btn btn--danger">Elimina</button>
                        </form>
                    </div>
                </article>
            {foreachelse}
                <div class="list-empty">Nessuna recensione segnalata al momento.</div>
            {/foreach}
        </div>
    </div>
{/block}