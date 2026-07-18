{* TableCrown\Presentation\Views - Admin
   utenti_admin.tpl - Lista utenti con recensioni segnalate.

   Variabili attese dal layer Control (CAmministratore::mostraListaUtentiAdmin):
     $utenti => array, ognuna:
         ['id' => int, 'nome' => string, 'stato' => 'attivo'|'sospeso'|'bannato',
          'numeroSegnalazioni' => int]
*}
{extends file="layout_admin.tpl"}

{block name="page_css"}
    <link rel="stylesheet" href="/css/utenti_admin.css">
{/block}

{block name="content"}
    <div class="segn">
        <div class="segn__heading">
            <div>
                <h1>Utenti segnalati</h1>
                <p>Gestisci gli utenti con recensioni segnalate</p>
            </div>
        </div>

        <div class="recensioni-list">
            {foreach $utenti as $u}
                <article class="recensione-card">
                    <div class="recensione-card__header">
                        <div class="recensione-card__info">
                            <span class="recensione-card__prodotto">{$u.nome}</span>
                            <span class="recensione-card__meta">
                                Stato: {$u.stato}
                            </span>
                        </div>
                        <div class="recensione-card__badges">
                            <span class="count-badge">{$u.numeroSegnalazioni} segnalazioni</span>
                        </div>
                    </div>

                    <div class="recensione-card__footer">
                        <a href="/admin/utente/profilo?id={$u.id}" class="btn btn--outline">Dettagli utente</a>

                        {if $u.stato === 'attivo'}
                            <form method="post" action="/admin/utente/sospendi" class="recensione-card__form-elimina"
                                  data-confirm-message="Sospendere questo utente per 3 mesi?">
                                <input type="hidden" name="id_persona" value="{$u.id}">
                                <button type="submit" class="btn btn--warning">Sospendi</button>
                            </form>
                        {/if}

                        {if $u.stato !== 'bannato'}
                            <form method="post" action="/admin/utente/banna" class="recensione-card__form-elimina"
                                  data-confirm-message="Bannare permanentemente questo utente?">
                                <input type="hidden" name="id_persona" value="{$u.id}">
                                <button type="submit" class="btn btn--danger">Banna</button>
                            </form>
                        {/if}
                    </div>
                </article>
            {foreachelse}
                <div class="list-empty">Nessun utente con recensioni segnalate al momento.</div>
            {/foreach}
        </div>
    </div>
{/block}