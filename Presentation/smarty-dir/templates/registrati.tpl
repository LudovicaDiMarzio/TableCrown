{extends file="common/layout.tpl"}

{block name="extra_css"}
    <link rel="stylesheet" href="{$base_url}/css/auth.css">
{/block}

{block name="content"}

<div class="auth-container">
    <div class="container">
        <div class="auth-card auth-card-wide">

            <div class="auth-card-header">
                <div class="auth-icon">
                    <i class="ti ti-user-plus"></i>
                </div>
                <h1 class="auth-title">Crea il tuo account</h1>
                <p class="auth-subtitle">Unisciti alla community TableCrown</p>
            </div>

            <form class="auth-form" action="{$base_url}/registrati" method="post" id="register-form">

                <div class="auth-field">
                    <label for="nickname" class="auth-label">Nickname</label>
                    <div class="auth-input-wrapper">
                        <i class="ti ti-user"></i>
                        <input class="input auth-input"
                               type="text"
                               name="nome"
                               id="nickname"
                               placeholder="MastroDadi92"
                               value="{$nickname_value|default:''|escape}"
                               required
                               minlength="3"
                               maxlength="30"
                               autocomplete="username">
                    </div>
                </div>

                <div class="auth-fields-row">
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
                        <label for="eta" class="auth-label">Età</label>
                        <div class="auth-input-wrapper">
                            <i class="ti ti-baby-carriage"></i>
                            <input class="input auth-input"
                                   type="number"
                                   name="eta"
                                   id="eta"
                                   placeholder="18"
                                   value="{$eta_value|default:''|escape}"
                                   required
                                   min="18"
                                   max="120"
                                   autocomplete="off">
                        </div>
                    </div>
                </div>

                <div class="auth-fields-row">
                    <div class="auth-field">
                        <label for="password" class="auth-label">Password</label>
                        <div class="auth-input-wrapper">
                            <i class="ti ti-lock"></i>
                            <input class="input auth-input"
                                   type="password"
                                   name="password"
                                   id="password"
                                   placeholder="Min. 8 caratteri"
                                   required
                                   minlength="8"
                                   autocomplete="new-password">
                        </div>
                    </div>

                    <div class="auth-field">
                        <label for="password_conferma" class="auth-label">Conferma Password</label>
                        <div class="auth-input-wrapper">
                            <i class="ti ti-lock-check"></i>
                            <input class="input auth-input"
                                   type="password"
                                   name="password_conferma"
                                   id="password_conferma"
                                   placeholder="Ripeti password"
                                   required
                                   minlength="8"
                                   autocomplete="new-password">
                        </div>
                    </div>
                </div>

                <label class="auth-checkbox-label auth-checkbox-terms">
                    <input type="checkbox" name="accetta_termini" value="1" required>
                    <span>Accetto i <a href="{$base_url}/termini" class="auth-link-inline" target="_blank">Termini di Servizio</a> e la <a href="{$base_url}/privacy" class="auth-link-inline" target="_blank">Privacy Policy</a></span>
                </label>

                <button class="button auth-submit-btn" type="submit">
                    <i class="ti ti-user-plus"></i> Crea account
                </button>

            </form>

            <div class="auth-divider">
                <span>oppure</span>
            </div>

            <p class="auth-footer-text">
                Hai già un account?
                <a href="{$base_url}/accedi" class="auth-link">Accedi</a>
            </p>

        </div>
    </div>
</div>

{/block}