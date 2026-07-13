{extends file="common/layout.tpl"}

{block name="extra_css"}
    <link rel="stylesheet" href="{$base_url}/css/auth.css">
{/block}

{block name="content"}

<div class="auth-container">
    <div class="container">
        <div class="auth-card">

            <div class="auth-card-header">
                <div class="auth-icon">
                    <i class="ti ti-login"></i>
                </div>
                <h1 class="auth-title">Bentornato</h1>
                <p class="auth-subtitle">Accedi al tuo account TableCrown</p>
            </div>

            <form class="auth-form" action="{$base_url}/accedi" method="post" id="login-form">

                {if isset($redirect_to)}
                    <input type="hidden" name="redirect_to" value="{$redirect_to|escape}">
                {/if}

                <div class="auth-field">
                    <label for="email" class="auth-label">Email</label>
                    <div class="auth-input-wrapper">
                        <i class="ti ti-mail"></i>
                        <input class="input auth-input"
                               type="email"
                               name="email"
                               id="email"
                               placeholder="nome@esempio.it"
                               value="{$email_value|default:''|escape}"
                               required
                               autocomplete="email">
                    </div>
                </div>

                <div class="auth-field">
                    <label for="password" class="auth-label">Password</label>
                    <div class="auth-input-wrapper">
                        <i class="ti ti-lock"></i>
                        <input class="input auth-input"
                               type="password"
                               name="password"
                               id="password"
                               placeholder="••••••••"
                               required
                               autocomplete="current-password">
                        <button type="button" class="auth-toggle-password" id="toggle-password" aria-label="Mostra password">
                            <i class="ti ti-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="auth-row-between">
                    <label class="auth-checkbox-label">
                        <input type="checkbox" name="ricordami" value="1"
                               {if isset($ricordami) && $ricordami} checked{/if}>
                        <span>Ricordami</span>
                    </label>
                    <a href="{$base_url}/password-dimenticata" class="auth-link-inline">Password dimenticata?</a>
                </div>

                <button class="button auth-submit-btn" type="submit">
                    <i class="ti ti-login"></i> Accedi
                </button>

            </form>

            <div class="auth-divider">
                <span>oppure</span>
            </div>

            <p class="auth-footer-text">
                Non hai un account?
                <a href="{$base_url}/registrati" class="auth-link">Registrati ora</a>
            </p>

        </div>
    </div>
</div>

{/block}

{block name="extra_js"}
<script>
{literal}
document.addEventListener('DOMContentLoaded', function() {
    var toggleBtn = document.getElementById('toggle-password');
    var passwordInput = document.getElementById('password');

    if (toggleBtn && passwordInput) {
        toggleBtn.addEventListener('click', function() {
            var isHidden = passwordInput.type === 'password';
            passwordInput.type = isHidden ? 'text' : 'password';
            toggleBtn.querySelector('i').className = isHidden ? 'ti ti-eye-off' : 'ti ti-eye';
        });
    }
});
{/literal}
</script>
{/block}