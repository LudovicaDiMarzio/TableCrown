{extends file="layout_admin.tpl"}

{block name="page_css"}
    <link rel="stylesheet" href="{$base_url}/css/dettagli_utente_admin.css">
{/block}

{block name="content"}
<div class="profile-page">

    <div class="profile-page__top">
        <a href="{$base_url}/admin/utenti" class="profile-page__back">&larr; Torna alla lista utenti</a>
    </div>

    <div class="profile-header">
        <div class="profile-header__identity">
            <div class="profile-avatar">
                <span>{$utenteProfilo.nome|truncate:1:"":true|upper}</span>
            </div>
            <div class="profile-header__info">
                <h1>{$utenteProfilo.nome}</h1>
                <div class="profile-header__meta">
                    <span class="profile-header__id">ID #{$utenteProfilo.id}</span>
                    <span class="badge badge--{$utenteProfilo.stato}">{$utenteProfilo.stato|replace:'_':' '}</span>
                </div>
            </div>
        </div>

        <div class="profile-header__actions">
            {if $utenteProfilo.stato != 'bannato' && $utenteProfilo.stato != 'sospeso'}
                <form action="{$base_url}/admin/utente/sospendi" method="post"
                      data-confirm-message="Sospendere {$utenteProfilo.nome} per 3 mesi? Non potrà accedere al proprio account fino alla scadenza.">
                    <input type="hidden" name="id_persona" value="{$utenteProfilo.id}">
                    <button type="submit" class="btn btn--warning">Sospendi</button>
                </form>
            {/if}
            {if $utenteProfilo.stato != 'bannato'}
                <form action="{$base_url}/admin/utente/banna" method="post"
                      data-confirm-message="Bannare {$utenteProfilo.nome} in modo permanente? L'account non potrà più essere riattivato.">
                    <input type="hidden" name="id_persona" value="{$utenteProfilo.id}">
                    <button type="submit" class="btn btn--danger">Banna</button>
                </form>
            {/if}
        </div>
    </div>

    <div class="panel">
        <div class="panel__header">
            <h2>Recensioni dell'utente</h2>
            {if $recensioniSegnalate|@count > 0}
                <span class="panel__badge">{$recensioniSegnalate|@count}</span>
            {/if}
        </div>

        {if $recensioniSegnalate|@count > 0}
            <ul class="recensione-list">
                {foreach from=$recensioniSegnalate item="recensione"}
                    <li class="recensione-card">
                        <div class="recensione-card__avatar" {if $recensione.prodotto.immagine}style="background-image:url('{$recensione.prodotto.immagine}')"{/if}></div>

                        <div class="recensione-card__body">
                            <div class="recensione-card__head">
                                <span class="recensione-card__utente">{$recensione.utente}</span>
                                <span class="recensione-card__data">{$recensione.data|date_format:"%d/%m/%Y"}</span>
                            </div>
                            <p class="recensione-card__prodotto">su <a href="/prodotto?id={$recensione.prodotto.id}">{$recensione.prodotto.nome}</a></p>
                            <p class="recensione-card__testo">{$recensione.testo}</p>
                        </div>

                        <form action="{$base_url}/admin/recensioni/elimina" method="post" class="recensione-card__form"
                              data-confirm-message="Rimuovere questa recensione dal sito?">
                            <input type="hidden" name="id_recensione" value="{$recensione.id}">
                            <button type="submit" class="btn btn--danger-outline btn--small">Rimuovi</button>
                        </form>
                    </li>
                {/foreach}
            </ul>
        {else}
            <p class="list-empty">Questo utente non ha ancora scritto recensioni.</p>
        {/if}
    </div>

</div>
{/block}