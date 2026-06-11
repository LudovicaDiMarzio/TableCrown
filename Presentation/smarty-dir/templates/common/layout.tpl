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
    <footer class="footer has-background-dark has-text-white" style="padding: 3rem 1.5rem;">
    <div class="container">
        <div class="columns">
            
            <div class="column is-3">
                <h2 class="subtitle is-5 has-text-white font-weight-bold">TABLECROWN</h2>
                <p class="is-size-7">Il tuo negozio di giochi da tavolo.</p>
                <p class="is-size-7">Prodotti, eventi e community.</p>
                <div class="social-icons mt-3">
                    </div>
            </div>

            <div class="column is-3">
                <h3 class="title is-6 has-text-white mb-2">INFO</h3>
                <ul class="is-size-7">
                    <li><a href="#" class="has-text-grey-light">Chi siamo</a></li>
                    <li><a href="#" class="has-text-grey-light">Contattaci</a></li>
                    <li><a href="#" class="has-text-grey-light">Dove siamo</a></li>
                </ul>
            </div>

            <div class="column is-3">
                <h3 class="title is-6 has-text-white mb-2">ACCOUNT</h3>
                <ul class="is-size-7">
                    <li><a href="#" class="has-text-grey-light">Accedi</a></li>
                    <li><a href="#" class="has-text-grey-light">Registrati</a></li>
                </ul>
            </div>

            <div class="column is-3">
                <h3 class="title is-6 has-text-white mb-2">CONTATTI</h3>
                <p class="is-size-7 has-text-grey-light">📞 +39 344 253621</p>
                <p class="is-size-7 has-text-grey-light">📍 Giulianova, Abruzzo</p>
                <p class="is-size-7 mt-2"><a href="#" class="has-text-warning">✍ Lasciaci una recensione</a></p>
            </div>

        </div>

        <hr class="has-background-grey-dark my-4">

        <div class="content has-text-centered is-size-7 has-text-grey">
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
