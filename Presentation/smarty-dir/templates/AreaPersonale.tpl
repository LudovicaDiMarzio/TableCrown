{extends file="common/layout.tpl"}

{block name="extra_css"}
    <link rel="stylesheet" href="{$base_url}/css/AreaPersonale.css">
{/block}

{block name="content"}
<div class="account-container">
    <div class="container">

        <div class="account-layout">

            {* ── COLONNA PRINCIPALE ── *}
            <div class="account-main">

                {* ── HEADER: AVATAR + SALUTO + AZIONI ── *}
                <div class="account-header">

                    <div class="account-avatar">
                        {if isset($utente.avatar) && $utente.avatar}
                            <img src="{$base_url}/img/avatar/{$utente.avatar|escape}"
                                 onerror="this.onerror=null; this.src='{$base_url}/img/avatar-default.png'"
                                 alt="{$utente.name|escape}"
                                 class="account-avatar-img">
                        {else}
                            <i class="ti ti-user"></i>
                        {/if}
                    </div>

                    <div class="account-welcome">
                        <span class="account-eyebrow">Area Personale</span>
                        <h1 class="account-titolo">Ciao, {$utente.name|escape}!</h1>

                        <div class="account-header-links">
                            <a href="{$base_url}/logout" class="account-link-secondary">
                                <i class="ti ti-logout"></i> Logout
                            </a>
                        </div>
                    </div>

                </div>

                {* ── GRIGLIA VOCI ACCOUNT ── *}
                <div class="account-grid">
                    {foreach $account_menu as $voce}
                        {* Escludo la voce "I Miei Dadi" (confronto Smarty nativo, nessuna funzione PHP) *}
                        {if $voce.label != 'I Miei Dadi'}
                            <a href="{$base_url}{$voce.url|escape}" class="account-card">
                                <span class="account-card-icon">
                                    <i class="ti ti-chevron-right"></i>
                                </span>
                                <span class="account-card-label">{$voce.label|escape}</span>
                                <span class="account-card-arrow">
                                    <i class="ti ti-arrow-right"></i>
                                </span>
                            </a>
                        {/if}
                    {/foreach}

                    {* ── METODI DI PAGAMENTO ── *}
                    <a href="{$base_url}/profilo/pagamenti" class="account-card">
                        <span class="account-card-icon">
                            <i class="ti ti-credit-card"></i>
                        </span>
                        <span class="account-card-label">Metodi di Pagamento</span>
                        <span class="account-card-arrow">
                            <i class="ti ti-arrow-right"></i>
                        </span>
                    </a>
                </div>

            </div>

            {* ── COLONNA DESTRA: GAMIFICATION ── *}
            <aside class="account-summary" id="account-summary">

                <div class="account-summary-block">
                    <h2 class="account-summary-title">
                        <i class="ti ti-trophy"></i> Tornei Vinti
                    </h2>
                    <div class="account-summary-tornei-value">
                        <span class="account-tornei-attuali">{$tornei_vinti}</span><span class="account-tornei-sep">/</span><span class="account-tornei-totali">{$tornei_obiettivo}</span>
                    </div>

                    <div class="account-progress-track">
                        <div class="account-progress-fill"
                             style="width: {if $tornei_obiettivo > 0}{($tornei_vinti / $tornei_obiettivo) * 100}{else}0{/if}%;"></div>
                    </div>
                </div>

                <div class="account-livello-wrapper">
                    <div class="account-livello-row">
                        <span class="account-livello-label">
                            <i class="ti ti-star"></i> {$playerLevel|escape|capitalize}
                        </span>
                        <button type="button"
                                class="account-livello-info"
                                id="account-livello-info-btn"
                                aria-label="Informazioni livello giocatore"
                                aria-expanded="false">
                            <i class="ti ti-info-circle"></i>
                        </button>
                    </div>

                    <div class="account-livello-tooltip" id="account-livello-tooltip" role="tooltip">
                        {if $torneiMancanti}
                            Vinci altri {$torneiMancanti} tornei per diventare il livello successivo!
                        {else}
                            Hai raggiunto il livello massimo!
                        {/if}
                    </div>
                </div>

            </aside>

        </div>

    </div>
</div>
{/block}

{block name="extra_js"}
<script>
{literal}
(function() {

    // ── TOOLTIP LIVELLO GIOCATORE (click su mobile, hover gestito da CSS su desktop) ──
    var btn     = document.getElementById('account-livello-info-btn');
    var tooltip = document.getElementById('account-livello-tooltip');

    if (btn && tooltip) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            var aperto = tooltip.classList.toggle('is-visibile');
            btn.setAttribute('aria-expanded', aperto ? 'true' : 'false');
        });

        document.addEventListener('click', function(e) {
            if (!tooltip.contains(e.target) && e.target !== btn && !btn.contains(e.target)) {
                tooltip.classList.remove('is-visibile');
                btn.setAttribute('aria-expanded', 'false');
            }
        });
    }

})();
{/literal}
</script>
{/block}