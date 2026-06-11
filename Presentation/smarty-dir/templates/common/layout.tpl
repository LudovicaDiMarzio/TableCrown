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
    {* HEADER                                        *}
    {* ──────────────────────────────────────────── *}

    {* Riga 1: Logo + icone account/wishlist/carrello *}
    <div class="header-top">
        <div class="container">

            <a class="navbar-logo" href="{$base_url}">
                <img src="{$base_url}/img/logo.png"
                     alt="TableCrown"
                     class="navbar-logo-img">
                {* Fallback testuale se l'immagine non è ancora presente *}
                <span class="navbar-logo-text">Table<span class="navbar-logo-accent">Crown</span></span>
            </a>

            <div class="header-top-actions">

                {* Accedi / Account *}
                {if isset($utente)}
                    <div class="navbar-item has-dropdown is-hoverable">
                        <a class="navbar-link navbar-user-link">
                            <i class="ti ti-user-circle navbar-icon"></i>
                            <span class="navbar-username">{$utente->getNickname()|escape}</span>
                        </a>
                        <div class="navbar-dropdown is-right">
                            <a class="navbar-item" href="{$base_url}/profilo">
                                <i class="ti ti-user navbar-dropdown-icon"></i>Il mio account
                            </a>
                            <a class="navbar-item" href="{$base_url}/profilo/ordini">
                                <i class="ti ti-package navbar-dropdown-icon"></i>I miei ordini
                            </a>
                            <a class="navbar-item" href="{$base_url}/profilo/eventi">
                                <i class="ti ti-calendar navbar-dropdown-icon"></i>I miei eventi
                            </a>
                            <hr class="navbar-divider">
                            <a class="navbar-item navbar-logout" href="{$base_url}/logout">
                                <i class="ti ti-logout navbar-dropdown-icon"></i>Logout
                            </a>
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

    {* Riga 2: Navbar con voci di menu + barra di ricerca *}
    <nav class="navbar navigation" role="navigation" aria-label="navigazione principale">
        <div class="container">

            <div class="navbar-brand">
                <a role="button" class="navbar-burger" id="navbar-burger"
                   aria-label="Apri menu" aria-expanded="false" data-target="navbar-menu">
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                </a>
            </div>

            <div id="navbar-menu" class="navbar-menu">

                <div class="navbar-start">
                    <a class="navbar-item{if $current_page == 'catalogo'} is-active{/if}"
                       href="{$base_url}/catalogo">Catalogo</a>
                    <a class="navbar-item{if $current_page == 'eventi'} is-active{/if}"
                       href="{$base_url}/eventi">Eventi</a>
                    <a class="navbar-item{if $current_page == 'offerte'} is-active{/if}"
                       href="{$base_url}/offerte">Offerte</a>
                    <a class="navbar-item{if $current_page == 'dadi'} is-active{/if}"
                       href="{$base_url}/dadi-custom">Dadi Custom</a>
                </div>

                {* Barra di ricerca nella navbar-end *}
                <div class="navbar-end">
                    <div class="navbar-item navbar-search-wrap">
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

            <div class="columns is-multiline">

                {* ── Col 1: Brand + social ── *}
                <div class="column is-4-desktop is-12-tablet">
                    <p class="footer-heading">TableCrown</p>
                    <p class="footer-desc">
                        Il tuo negozio di giochi da tavolo.<br>
                        Prodotti, eventi e community.
                    </p>
                    <div class="social-icons">
                        <a href="#" aria-label="Twitch">
                            <i class="ti ti-brand-twitch"></i>
                        </a>
                        <a href="#" aria-label="Instagram">
                            <i class="ti ti-brand-instagram"></i>
                        </a>
                        <a href="#" aria-label="Facebook">
                            <i class="ti ti-brand-facebook"></i>
                        </a>
                    </div>
                </div>

                {* ── Col 2: Link utili ── *}
                <div class="column is-2-desktop is-6-tablet">
                    <p class="footer-heading">Info</p>
                    <ul class="footer-list">
                        <li><a href="{$base_url}/chi-siamo">Chi siamo</a></li>
                        <li><a href="{$base_url}/contatti">Contattaci</a></li>
                        <li><a href="{$base_url}/dove-siamo">Dove siamo</a></li>
                    </ul>
                </div>

                {* ── Col 3: Account ── *}
                <div class="column is-2-desktop is-6-tablet">
                    <p class="footer-heading">Account</p>
                    <ul class="footer-list">
                        {if isset($utente)}
                            <li><a href="{$base_url}/profilo">Il mio profilo</a></li>
                            <li><a href="{$base_url}/profilo/ordini">I miei ordini</a></li>
                            <li><a href="{$base_url}/logout">Logout</a></li>
                        {else}
                            <li><a href="{$base_url}/accedi">Accedi</a></li>
                            <li><a href="{$base_url}/registrati">Registrati</a></li>
                        {/if}
                    </ul>
                </div>

                {* ── Col 4: Contatti ── *}
                <div class="column is-4-desktop is-12-tablet">
                    <p class="footer-heading">Contatti</p>
                    <ul class="footer-list footer-contacts">
                        <li>
                            <i class="ti ti-phone footer-contact-icon"></i>
                            +39 344 253621
                        </li>
                        <li>
                            <i class="ti ti-map-pin footer-contact-icon"></i>
                            Giulianova, Abruzzo
                        </li>
                    </ul>
                    <a class="footer-review-link" href="{$base_url}/recensioni/nuova">
                        ✍ Lasciaci una recensione
                    </a>
                </div>

            </div>

            <div class="footer-divider"></div>
            <p class="footer-bottom">
                © {$smarty.now|date_format:"%Y"} TableCrown — Tutti i diritti riservati
            </p>

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
