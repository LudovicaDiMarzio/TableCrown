{extends file="common/layout.tpl"}

{block name="extra_css"}
    <link rel="stylesheet" href="{$base_url}/css/ModificaAccount.css">
{/block}

{block name="content"}
<div class="modifica-account-container">
    <div class="container">

        {* ── BREADCRUMB + ELIMINA ACCOUNT ── *}
        <div class="modifica-account-topbar">
            <div class="modifica-account-breadcrumb">
                <a href="{$base_url}/account" class="modifica-account-breadcrumb-link">Il mio account</a>
                <span class="modifica-account-breadcrumb-sep">&gt;</span>
                <span class="modifica-account-breadcrumb-current">Modifica account</span>
            </div>

            <a href="{$base_url}/account/elimina"
               class="modifica-account-elimina"
               onclick="return confirm('Sei sicuro di voler eliminare il tuo account? L\'operazione è irreversibile.');">
                Elimina account
            </a>
        </div>

        <form action="{$base_url}/account/modifica" method="post" class="modifica-account-form" enctype="multipart/form-data">

            {* ── AVATAR ── *}
            <div class="modifica-account-avatar-wrap">
                <div class="modifica-account-avatar">
                    {if isset($utente.avatar) && $utente.avatar}
                        <img src="{$base_url}/img/avatar/{$utente.avatar|default:''|escape}"
                             onerror="this.onerror=null; this.src='{$base_url}/img/avatar-default.png'"
                             alt="{$utente.nome|default:''|escape}"
                             class="modifica-account-avatar-img"
                             id="modifica-account-avatar-preview">
                    {else}
                        <span class="modifica-account-avatar-placeholder" id="modifica-account-avatar-preview">IMG</span>
                    {/if}
                </div>

                <label for="modifica-account-avatar-input" class="modifica-account-avatar-edit">
                    <i class="ti ti-pencil"></i> Edit
                </label>
                <input type="file"
                       id="modifica-account-avatar-input"
                       name="avatar"
                       accept="image/*"
                       class="modifica-account-avatar-input">
            </div>

            {* ── CAMPI PRINCIPALI ── *}
            <div class="modifica-account-fields">

                <div class="modifica-account-field">
                    <label for="nickname" class="modifica-account-label">Nickname</label>
                    <input type="text"
                           id="nickname"
                           name="nickname"
                           class="modifica-account-input"
                           value="{$utente.nome|default:''|escape}">
                </div>

                <div class="modifica-account-field">
                    <label for="email" class="modifica-account-label">Email</label>
                    <input type="email"
                           id="email"
                           name="email"
                           class="modifica-account-input"
                           value="{$utente.email|default:''|escape}">
                </div>

                <div class="modifica-account-field">
                    <label for="eta" class="modifica-account-label">Età</label>
                    <input type="number"
                           id="eta"
                           name="eta"
                           min="0"
                           class="modifica-account-input"
                           value="{$utente.eta|default:''|escape}">
                </div>

                <div class="modifica-account-field modifica-account-field-checkbox">
                    <label class="modifica-account-checkbox-label">
                        <input type="checkbox"
                               name="mostra_foto"
                               value="1"
                               {if isset($utente.mostra_foto) && $utente.mostra_foto}checked{/if}>
                        Mostra la mia foto profilo pubblicamente
                    </label>
                </div>

            </div>

            {* ── AZIONI: SALVA / MODIFICA PASSWORD ── *}
            <div class="modifica-account-actions">
                <button type="button"
                        class="modifica-account-btn-secondary"
                        id="modifica-account-password-toggle"
                        aria-expanded="false"
                        aria-controls="modifica-account-password-card">
                    Modifica Password
                </button>

                <button type="submit" class="modifica-account-btn-primary">Salva</button>
            </div>

        </form>

        {* ── CARD PASSWORD (nascosta finché non si clicca "Modifica Password") ── *}
        <div class="modifica-account-password-card" id="modifica-account-password-card" hidden>
            <form action="{$base_url}/account/password" method="post" class="modifica-account-password-form">

                <div class="modifica-account-field">
                    <label for="psw_vecchia" class="modifica-account-label">Psw Vecchia</label>
                    <input type="password" id="psw_vecchia" name="psw_vecchia" class="modifica-account-input">
                </div>

                <div class="modifica-account-field">
                    <label for="psw_nuova" class="modifica-account-label">Psw Nuova</label>
                    <input type="password" id="psw_nuova" name="psw_nuova" class="modifica-account-input">
                </div>

                <div class="modifica-account-field">
                    <label for="psw_conferma" class="modifica-account-label">Psw Conferma</label>
                    <input type="password" id="psw_conferma" name="psw_conferma" class="modifica-account-input">
                </div>

                <button type="submit" class="modifica-account-btn-primary modifica-account-btn-password-salva">Salva</button>

            </form>
        </div>

    </div>
</div>
{/block}

{block name="extra_js"}
<script>
{literal}
(function() {

    // ── TOGGLE CARD MODIFICA PASSWORD ──
    var toggleBtn = document.getElementById('modifica-account-password-toggle');
    var card      = document.getElementById('modifica-account-password-card');

    if (toggleBtn && card) {
        toggleBtn.addEventListener('click', function() {
            var aperto = card.hasAttribute('hidden');
            if (aperto) {
                card.removeAttribute('hidden');
            } else {
                card.setAttribute('hidden', '');
            }
            toggleBtn.setAttribute('aria-expanded', aperto ? 'true' : 'false');
        });
    }

    // ── PREVIEW AVATAR AL CAMBIO FILE ──
    var avatarInput  = document.getElementById('modifica-account-avatar-input');
    var avatarPreview = document.getElementById('modifica-account-avatar-preview');

    if (avatarInput && avatarPreview) {
        avatarInput.addEventListener('change', function(e) {
            var file = e.target.files[0];
            if (!file) return;

            var reader = new FileReader();
            reader.onload = function(ev) {
                if (avatarPreview.tagName === 'IMG') {
                    avatarPreview.src = ev.target.result;
                } else {
                    var img = document.createElement('img');
                    img.src = ev.target.result;
                    img.className = 'modifica-account-avatar-img';
                    img.id = 'modifica-account-avatar-preview';
                    avatarPreview.replaceWith(img);
                    avatarPreview = img;
                }
            };
            reader.readAsDataURL(file);
        });
    }

})();
{/literal}
</script>
{/block}