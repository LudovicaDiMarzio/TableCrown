{* TableCrown\Presentation\Views - Admin
   home_a.tpl - Dashboard principale dell'amministratore.

   Variabili attese dal layer Control (CAmministratore::mostraDashboardAdmin):
     $segnalazioniInSospeso => int, totale segnalazioni in sospeso sul sistema
     $utentiTotali          => int
     $utentiNuoviOggi       => int
     $utentiSospesiTotali   => int
     $utentiSospesiOggi     => int
     $segnalazioniUrgenti   => array, ognuna:
         ['id' => int, 'data' => 'Y-m-d H:i:s', 'stato' => string,
          'motivazione' => ['id' => int, 'nome' => string, 'gravita' => 'alta'|'media'|'bassa'],
          'utenteSegnalante' => ['id' => int, 'nome' => string],
          'autoreRecensione' => ['id' => int, 'nome' => string],
          'prodotto' => ['id' => int, 'nome' => string]]
*}
{extends file="layout_admin.tpl"}

{block name="page_css"}
    <link rel="stylesheet" href="{$base_url}/css/home_a.css">
{/block}

{block name="content"}
    <div class="dash">
        <div class="dash__heading">
            <h1>Dashboard Amministratore</h1>
            <p>Controllo e moderazione della piattaforma</p>
        </div>

        <section class="dash__stats">
            <article class="stat-card stat-card--danger">
                <span class="stat-card__icon stat-card__icon--danger ti ti-flag-3"></span>
                <div class="stat-card__body">
                    <span class="stat-card__label">Segnalazioni in attesa</span>
                    <span class="stat-card__value">{$segnalazioniInSospeso}</span>
                </div>
            </article>

            <article class="stat-card stat-card--primary">
                <span class="stat-card__icon stat-card__icon--primary ti ti-users"></span>
                <div class="stat-card__body">
                    <span class="stat-card__label">Utenti totali</span>
                    <span class="stat-card__value">{$utentiTotali}</span>

                </div>
            </article>

            <article class="stat-card stat-card--warning">
                <span class="stat-card__icon stat-card__icon--warning ti ti-user-off"></span>
                <div class="stat-card__body">
                    <span class="stat-card__label">Utenti sospesi</span>
                    <span class="stat-card__value">{$utentiSospesiTotali}</span>

                </div>
            </article>
        </section>

        <section class="dash__grid dash__grid--single">
            <div class="panel panel--segnalazioni">
                <div class="panel__header">
                    <h2>
                        Segnalazioni in attesa
                        {if $segnalazioniInSospeso > 0}
                            <span class="panel__badge">{$segnalazioniInSospeso}</span>
                        {/if}
                    </h2>
                    <a href="{$base_url}/admin/recensioni" class="panel__link">Vedi tutte</a>
                </div>

                <ul class="segnalazioni-list">
                    {foreach $segnalazioniUrgenti as $s}
                        <li class="segnalazione-item">
                            <span class="segnalazione-item__icon ti ti-flag-3"></span>
                            <div class="segnalazione-item__body">
                                <span class="segnalazione-item__tipo">{$s.motivazione.nome}</span>
                                <span class="segnalazione-item__meta">
                                    Segnalata da: {$s.utenteSegnalante.nome} &middot;
                                    Recensione di {$s.autoreRecensione.nome} su "{$s.prodotto.nome}"
                                </span>
                                <span class="segnalazione-item__tempo">{$s.data|date_format:"%d/%m/%Y %H:%M"}</span>
                            </div>
                            <span class="badge badge--{$s.motivazione.gravita}">
                                {if $s.motivazione.gravita === 'alta'}Alta
                                {elseif $s.motivazione.gravita === 'media'}Media
                                {else}Bassa
                                {/if}
                            </span>
                           
                        </li>
                    {foreachelse}
                        <li class="list-empty">Nessuna segnalazione in attesa.</li>
                    {/foreach}
                </ul>
            </div>
        </section>
    </div>
{/block}