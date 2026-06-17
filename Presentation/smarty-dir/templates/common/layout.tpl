<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <title>{block name="page_title"}TableCrown{/block}</title>

    {* ── CSS ── *}
    <link rel="stylesheet" href="{$base_url}/plugins/bulma/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.19.0/dist/tabler-icons.min.css">
    <link rel="stylesheet" href="{$base_url}/css/base.css">
    <link rel="stylesheet" href="{$base_url}/css/layout.css">

    {block name="extra_css"}{/block}
</head>
<body>

    {* ──────────────────────────────────────────── *}
    {* HEADER TABLECROWN (Logo a sx - Menu e azioni a dx) *}
    {* ──────────────────────────────────────────── *}
    <nav class="navbar navigation" role="navigation" aria-label="navigazione principale">
        <div class="container is-fluid px-5"> 
            
            <div class="navbar-row-top-clean">
                
                <div class="navbar-brand-mobile-only">
                    <a role="button" class="navbar-burger" id="navbar-burger" aria-label="Apri menu" aria-expanded="false" data-target="navbar-menu-custom">
                        <span aria-hidden="true"></span>
                        <span aria-hidden="true"></span>
                        <span aria-hidden="true"></span>
                    </a>
                </div>

                <div id="navbar-menu-custom" class="navbar-menu-custom-links">

                    {* LOGO *}
                    <a class="navbar-logo" href="{$base_url}">
                        <img src="{$base_url}/img/logo.png" alt="TableCrown" class="navbar-logo-img">
                    </a>
                    
                    <div class="navbar-center-links">
                        <a class="navbar-item{if isset($current_page) && $current_page == 'catalogo'} is-active{/if}" href="{$base_url}/catalogo">Catalogo</a>
                        <a class="navbar-item{if isset($current_page) && $current_page == 'eventi'} is-active{/if}" href="{$base_url}/eventi">Eventi</a>
                        <a class="navbar-item{if isset($current_page) && $current_page == 'offerte'} is-active{/if}" href="{$base_url}/offerte">Offerte</a>
                    </div>

                    <div class="navbar-end-actions">
                        
                        {* Accedi / Account *}
                        {if isset($utente)}
                            <div class="navbar-item has-dropdown" id="user-dropdown">
                                <a class="navbar-link navbar-user-link">
                                    <i class="ti ti-user-circle navbar-icon"></i>
                                    <span class="navbar-username">{$utente->getNickname()|escape}</span>
                                </a>
                                <div class="navbar-dropdown is-right">
                                    <a class="navbar-item" href="{$base_url}/profilo"><i class="ti ti-user"></i> Il mio account</a>
                                    <a class="navbar-item" href="{$base_url}/profilo/ordini"><i class="ti ti-package"></i> I miei ordini</a>
                                    <a class="navbar-item" href="{$base_url}/profilo/eventi"><i class="ti ti-calendar"></i> I miei eventi</a>
                                    <hr class="navbar-divider">
                                    <a class="navbar-item navbar-logout" href="{$base_url}/logout"><i class="ti ti-logout"></i> Logout</a>
                                </div>
                            </div>
                        {else}
                            <a class="header-top-link" href="{$base_url}/accedi">Accedi</a>
                        {/if}

                        {* Wishlist *}
                        <a class="header-top-link" href="{$base_url}/wishlist" title="La mia wishlist">
                            <i class="ti ti-heart navbar-icon"></i>
                            <span class="header-top-label">Wishlist</span>
                        </a>

                        {* Carrello *}
                        <a class="header-top-link" href="{$base_url}/carrello" title="Carrello">
                            <i class="ti ti-shopping-cart navbar-icon"></i>
                            <span class="header-top-label">Carrello</span>
                            {if isset($cart_count) && $cart_count > 0}
                                <span class="cart-badge">{$cart_count}</span>
                            {/if}
                        </a>
                    </div>
                    
                </div>
            </div>

        </div>
    </nav>

    {* ── BREADCRUMB ── *}
    {if isset($breadcrumbs) && $breadcrumbs|@count > 0}
    <section class="section breadcrumb-section">
        <div class="container">
            <nav class="breadcrumb is-small" aria-label="breadcrumbs">
                <ul>
                    {foreach $breadcrumbs as $crumb}
                        {if $crumb@last}
                            <li class="is-active">
                                <a href="#" aria-current="page">{$crumb.label|escape}</a>
                            </li>
                        {else}
                            <li><a href="{$crumb.url|escape}">{$crumb.label|escape}</a></li>
                        {/if}
                    {/foreach}
                </ul>
            </nav>
        </div>
    </section>
    {/if}

    {* ── FLASH MESSAGE ── *}
    {if isset($flash_message)}
    <section class="section flash-section">
        <div class="container">
            <div class="notification is-{$flash_type|default:'info'} is-light auto-hide">
                <button class="delete" aria-label="Chiudi"></button>
                {$flash_message|escape}
            </div>
        </div>
    </section>
    {/if}

    {* ── CONTENUTO PRINCIPALE ── *}
    <main>
        {block name="content"}{/block}
    </main>

    {* ── FOOTER ── *}
    <footer class="site-footer">
        <div class="container">
            <div class="columns">
                
                <div class="column is-3">
                    <h2 class="footer-heading">TABLECROWN</h2>
                    <p class="footer-desc">Il tuo negozio di giochi da tavolo.</p>
                    <p class="footer-desc">Prodotti, eventi e community.</p>
                    <div class="social-icons">
                        <a href="#" aria-label="Instagram"><i class="ti ti-brand-instagram"></i></a>
                        <a href="#" aria-label="Facebook"><i class="ti ti-brand-facebook"></i></a>
                        <a href="#" aria-label="Twitch"><i class="ti ti-brand-twitch"></i></a>
                    </div>
                </div>

                <div class="column is-3">
                    <h3 class="footer-heading">INFO</h3>
                    <ul class="footer-list">
                        <li><a href="{$base_url}/chi-siamo">Chi siamo</a></li>
                        <li><a href="{$base_url}/contatti">Contattaci</a></li>
                        <li><a href="{$base_url}/dove-siamo">Dove siamo</a></li>
                    </ul>
                </div>

                <div class="column is-3">
                    <h3 class="footer-heading">ACCOUNT</h3>
                    <ul class="footer-list">
                        <li><a href="{$base_url}/accedi">Accedi</a></li>
                        <li><a href="{$base_url}/registrati">Registrati</a></li>
                    </ul>
                </div>

                <div class="column is-3">
                    <h3 class="footer-heading">CONTATTI</h3>
                    <ul class="footer-list footer-contacts">
                        <li>
                            <i class="ti ti-phone footer-contact-icon"></i>
                            <span>+39 344 253621</span>
                        </li>
                        <li>
                            <i class="ti ti-map-pin footer-contact-icon"></i>
                            <span>Giulianova, Abruzzo</span>
                        </li>
                    </ul>
                    <a href="{$base_url}/recensioni/nuova" class="footer-review-link">✍ Lasciaci una recensione</a>
                </div>

            </div>

            <div class="footer-divider"></div>

            <div class="footer-bottom">
                <p>© 2026 TableCrown — Tutti i diritti riservati</p>
            </div>
        </div>
    </footer>

    {* ── JS ── *}
    <script src="{$base_url}/plugins/jQuery/jquery.min.js"></script>
    <script src="{$base_url}/plugins/masonry/masonry.min.js"></script>
    <script src="{$base_url}/plugins/match-height/jquery.matchHeight-min.js"></script>
    <script src="{$base_url}/js/script.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dropdown = document.getElementById('user-dropdown');
            if (dropdown) {
            dropdown.querySelector('.navbar-link').addEventListener('click', function (e) {
                    e.stopPropagation();
                    dropdown.classList.toggle('is-active');
                });
                document.addEventListener('click', function () {
                    dropdown.classList.remove('is-active');
                });
            }
        });
</script>

</body>
</html>
