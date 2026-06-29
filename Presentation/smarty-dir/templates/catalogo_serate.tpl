{extends file="common/layout.tpl"}

{block name="content"}
<link rel="stylesheet" href="{$base_url}/css/catalogo_serate.css">

<div class="eventi-lista-container">
    <div class="container">

        <nav class="eventi-breadcrumb">
            <a href="{$base_url}/">Home</a>
            <i class="ti ti-chevron-right"></i>
            <a href="{$base_url}/eventi">Eventi</a>
            <i class="ti ti-chevron-right"></i>
            <span>Serate</span>
        </nav>

        <div class="eventi-lista-layout">

            <aside class="eventi-sidebar">
                <h2 class="eventi-filtri-title">Filtri</h2>

                <form id="form-filtri-eventi" class="eventi-filtri-form" method="get" action="{$base_url}/catalogo/serate">

                    <div class="eventi-filter-group">
                        <h3 class="eventi-filter-group-title">Data</h3>
                        <input type="date" name="data" class="eventi-date-input" value="{$filtri.data|default:''}">
                        <button type="submit" class="button btn-apply-data">
                            <i class="ti ti-check"></i> Applica Data
                        </button>
                    </div>

                    <div class="eventi-filter-group">
                        <h3 class="eventi-filter-group-title">Tipologia</h3>
                        <div class="eventi-checkbox-group">
                            <label class="eventi-checkbox-label">
                                <input type="checkbox" name="tipologia[]" value="presentazione"
                                       {if $filtri.tipologia && in_array('presentazione', $filtri.tipologia)}checked{/if}>
                                <span class="eventi-checkbox-text">Presentazione</span>
                            </label>
                            <label class="eventi-checkbox-label">
                                <input type="checkbox" name="tipologia[]" value="gioco_libero"
                                       {if $filtri.tipologia && in_array('gioco_libero', $filtri.tipologia)}checked{/if}>
                                <span class="eventi-checkbox-text">Gioco Libero</span>
                            </label>
                        </div>
                    </div>

                    <div class="eventi-filter-group eventi-filter-group-last">
                        <div class="eventi-radio-options">
                            <label class="eventi-radio-label">
                                <input type="radio" name="stato" value="passati"
                                       {if $filtri.stato == 'passati'}checked{/if}>
                                <span class="eventi-radio-text">Eventi passati</span>
                            </label>
                            <label class="eventi-radio-label">
                                <input type="radio" name="stato" value="programma"
                                       {if $filtri.stato == 'programma' || !$filtri.stato}checked{/if}>
                                <span class="eventi-radio-text">Eventi in programma</span>
                            </label>
                        </div>
                    </div>

                </form>
            </aside>

            <div class="eventi-lista-main">
                <div class="eventi-grid">
                    {foreach from=$eventi item=evento}
                    {assign var="stato" value=$evento.statoEvento}
                    {assign var="passato" value=($stato == 'Terminato')}
                    {assign var="postiDisponibili" value=$evento.maxPartecipanti - $evento.numeroPartecipanti}

                    <article class="evento-list-card{if $passato} evento-list-card-passato{/if}">

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
                            <span class="evento-tipo-badge">{$evento.tipoSerata|escape}</span>
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

                        <div class="evento-list-actions">
                            {if $passato}
                                <a href="{$base_url}/eventi/risultati/{$evento.idEvento}" class="btn-evento-secondary">
                                    Visualizza risultati
                                </a>
                            {else}
                                <div class="evento-stepper" data-max="{$postiDisponibili}">
                                    <button type="button" class="evento-stepper-btn" data-action="decrease">−</button>
                                    <input type="number" class="evento-stepper-input" value="1" min="1" max="{$postiDisponibili}">
                                    <button type="button" class="evento-stepper-btn" data-action="increase">+</button>
                                </div>
                                <a href="{$base_url}/eventi/prenota/{$evento.idEvento}" class="btn-evento-primary">
                                    Iscriviti
                                </a>
                            {/if}
                        </div>

                        {if !$passato}
                        <a href="{$base_url}/eventi/dettaglio/{$evento.idEvento}" class="evento-scopri-link">
                            Scopri di più
                        </a>
                        {/if}

                    </article>
                    {foreachelse}
                    <p class="eventi-lista-empty">Nessuna serata trovata.</p>
                    {/foreach}
                </div>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form-filtri-eventi');
    if (form) {
        form.querySelectorAll('input[type="checkbox"], input[type="radio"]').forEach(function (input) {
            input.addEventListener('change', function () {
                form.submit();
            });
        });
    }

    document.querySelectorAll('.evento-stepper').forEach(function (stepper) {
        const max = parseInt(stepper.dataset.max, 10) || 99;
        const input = stepper.querySelector('.evento-stepper-input');

        stepper.querySelectorAll('.evento-stepper-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                let value = parseInt(input.value, 10) || 1;
                if (btn.dataset.action === 'increase' && value < max) value++;
                if (btn.dataset.action === 'decrease' && value > 1) value--;
                input.value = value;
            });
        });
    });
});
</script>
{/block}