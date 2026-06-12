<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <title>{block name="page_title"}TableCrown{/block}</title>

    {* ── CSS ── *}
    <link rel="stylesheet" href="{$base_url}/plugins/bulma/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.19.0/dist/tabler-icons.min.css">
    <link rel="stylesheet" href="{$base_url}/css/style.css">

    {block name="extra_css"}{/block}
</head>
<body>

    {* ──────────────────────────────────────────── *}
    {* HEADER TABLECROWN (Menu sopra - Logo + Cerca sotto) *}
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
                    
                    <div class="navbar-center-links">
                        <a class="navbar-item{if $current_page == 'catalogo'} is-active{/if}" href="{$base_url}/catalogo">Catalogo</a>
                        <a class="navbar-item{if $current_page == 'eventi'} is-active{/if}" href="{$base_url}/eventi">Eventi</a>
                        <a class="navbar-item{if $current_page == 'offerte'} is-active{/if}" href="{$base_url}/offerte">Offerte</a>
                    </div>

                    <div class="navbar-end-actions">
                        
                        {* Accedi / Account *}
                        {if isset($utente)}
                            <div class="navbar-item has-dropdown is-hoverable">
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

            <div class="navbar-row-bottom-search">
                
                <a class="navbar-logo" href="{$base_url}">
                    <img src="{$base_url}/img/logo.png" alt="TableCrown" class="navbar-logo-img">
                    <span class="navbar-logo-text">Table<span class="navbar-logo-accent">Crown</span></span>
                </a>

                <div class="navbar-search-fullwidth">
                    <form class="navbar-search-form" action="{$base_url}/catalogo" method="get">
                        <input class="input navbar-search-input"
                               type="search"
                               name="q"
                               placeholder="Cerca nel catalogo..."
                               value="{$search_query|default:''|escape}"
                               aria-label="Cerca nel catalogo">
                        <button class="button navbar-search-btn" type="submit" aria-label="Cerca">
                            <i class="ti ti-search"></i>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </nav>

    {* ──────────────────────────────────────────── *}
    {* BREADCRUMB (opzionale)                        *}
    {* ──────────────────────────────────────────── *}
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

    {* ──────────────────────────────────────────── *}
    {* FLASH MESSAGE (opzionale)                     *}
    {* ──────────────────────────────────────────── *}
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

    {* ──────────────────────────────────────────── *}
    {* CONTENUTO PRINCIPALE                          *}
    {* ──────────────────────────────────────────── *}
    <main>
        {block name="content"}{/block}
    </main>

    {* ──────────────────────────────────────────── *}
    {* FOOTER                                        *}
    {* ──────────────────────────────────────────── *}
    <footer class="site-footer">
    <div class="container">
        <div class="columns">
            
            <div class="column is-3">
                <h2 class="footer-heading">TABLECROWN</h2>
                <p class="footer-desc">Il tuo negozio di giochi da tavolo.</p>
                <p class="footer-desc">Prodotti, eventi e community.</p>
                <div class="social-icons">
                    <a href="#"><i class="ti ti-brand-instagram"></i></a>
                    <a href="#"><i class="ti ti-brand-facebook"></i></a>
                    <a href="#"><i class="ti ti-brand-twitch"></i></a>
                </div>
            </div>

            <div class="column is-3">
                <h3 class="footer-heading">INFO</h3>
                <ul class="footer-list">
                    <li><a href="#">Chi siamo</a></li>
                    <li><a href="#">Contattaci</a></li>
                    <li><a href="#">Dove siamo</a></li>
                </ul>
            </div>

            <div class="column is-3">
                <h3 class="footer-heading">ACCOUNT</h3>
                <ul class="footer-list">
                    <li><a href="#">Accedi</a></li>
                    <li><a href="#">Registrati</a></li>
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
                <a href="#" class="footer-review-link">✍ Lasciaci una recensione</a>
            </div>

        </div>

        <div class="footer-divider"></div>

        <div class="footer-bottom">
            <p>© 2026 TableCrown — Tutti i diritti riservati</p>
        </div>
    </div>
</footer>

    {* ──────────────────────────────────────────── *}
    {* JS                                            *}
    {* ──────────────────────────────────────────── *}
    <script src="{$base_url}/plugins/jQuery/jquery.min.js"></script>
    <script src="{$base_url}/plugins/masonry/masonry.min.js"></script>
    <script src="{$base_url}/plugins/match-height/jquery.matchHeight-min.js"></script>
    <script src="{$base_url}/js/script.js"></script>

    {block name="extra_js"}{/block}

</body>
</html>
