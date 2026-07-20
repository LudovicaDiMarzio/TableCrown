{*
  TableCrown\Presentation\Views - Area Gestore
  Layout master per tutte le pagine dell'area gestore.
  Le pagine figlie fanno {extends file="layout_gestore.tpl"}, definiscono
  il block "content" e possono aggiungere CSS specifici con "page_css".

  Variabili globali attese (da BaseController::preparaDatiLayout()):
    $base_url      => string
    $current_page  => string (es. 'gestore_dashboard', 'gestore_catalogo_giochi', ...)
    $breadcrumbs   => array di ['label' => string, 'url' => string]
    $utente        => ['name' => string] | null
    $flash_message => string (facoltativo)
    $flash_type    => string (facoltativo, 'success'|'danger'|'warning'|...)

  NB: 'ruolo' e 'avatarUrl' NON esistono in utenteToArray(), quindi qui
  "Gestore" è testo statico e l'avatar è un cerchio con l'iniziale del nome.

  FIX: $utente può arrivare a null (es. se preparaDatiLayout() viene chiamato
  in un contesto non ancora autenticato, o durante debug/test). Il blocco
  profilo va quindi protetto con {if $utente}, altrimenti Smarty prova ad
  accedere a $utente['name'] su null e PHP8 solleva il warning
  "Trying to access array offset on value of type null".
*}
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{if $pageTitle}{$pageTitle} - {/if}TableCrown Gestore</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{$base_url}/css/layout_gestore.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    {block name="page_css"}{/block}
</head>
<body class="gestore-body">
<div class="gestore-shell">

    <aside class="gestore-sidebar">
        <div class="gestore-sidebar__brand">
            <img src="{$base_url}/assets/img/logo.svg" alt="TableCrown" class="gestore-sidebar__logo">
            <div class="gestore-sidebar__brand-text">
                <span class="gestore-sidebar__name">TableCrown</span>
                <span class="gestore-sidebar__role">Gestore Negozio</span>
            </div>
        </div>

        {* Calcolo qui se la voce "Prodotti" deve risultare espansa/attiva,
           dato che raggruppa 3 pagine diverse del catalogo *}
        {assign var="prodottiAttivo" value=($current_page === 'gestore_catalogo_giochi' || $current_page === 'gestore_catalogo_bustine' || $current_page === 'gestore_catalogo_portadadi')}

        <nav class="gestore-sidebar__nav">
            <a href="{$base_url}/gestore/dashboard"
               class="gestore-nav__item{if $current_page === 'gestore_dashboard'} is-active{/if}">
                <span class="ti ti-layout-dashboard"></span>
                Dashboard
            </a>

            <div class="gestore-nav__group{if $prodottiAttivo} is-open{/if}">
                <button type="button" class="gestore-nav__item gestore-nav__item--toggle{if $prodottiAttivo} is-active{/if}" data-nav-toggle="prodotti">
                    <span class="ti ti-package"></span>
                    Prodotti
                    <span class="ti ti-chevron-down gestore-nav__chevron"></span>
                </button>
                <div class="gestore-nav__submenu" id="navSubmenu-prodotti">
                    <a href="{$base_url}/gestore/catalogo/giochi-da-tavolo"
                       class="gestore-nav__subitem{if $current_page === 'gestore_catalogo_giochi'} is-active{/if}">Giochi da Tavolo</a>
                    <a href="{$base_url}/gestore/catalogo/bustine"
                       class="gestore-nav__subitem{if $current_page === 'gestore_catalogo_bustine'} is-active{/if}">Bustine</a>
                    <a href="{$base_url}/gestore/catalogo/porta-dadi"
                       class="gestore-nav__subitem{if $current_page === 'gestore_catalogo_portadadi'} is-active{/if}">Porta Dadi</a>
                </div>
            </div>

            <a href="{$base_url}/gestore/eventi/serate"
               class="gestore-nav__item{if $current_page === 'gestore_eventi_serate'} is-active{/if}">
                <span class="ti ti-moon-stars"></span>
                Serate
            </a>
            <a href="{$base_url}/gestore/eventi/tornei"
               class="gestore-nav__item{if $current_page === 'gestore_eventi_tornei'} is-active{/if}">
                <span class="ti ti-trophy"></span>
                Tornei
            </a>
            <a href="{$base_url}/gestore/eventi/challenge"
               class="gestore-nav__item{if $current_page === 'gestore_eventi_challenge'} is-active{/if}">
                <span class="ti ti-swords"></span>
                Challenge
            </a>
        </nav>
    </aside>

    <div class="gestore-main">
        <header class="gestore-topbar">
            {* Breadcrumb, valorizzato da getBreadcrumbs() del controller figlio *}
            <nav class="gestore-breadcrumbs" aria-label="breadcrumb">
                {foreach $breadcrumbs as $crumb name="bc"}
                    {if $smarty.foreach.bc.last}
                        <span class="gestore-breadcrumbs__current">{$crumb.label}</span>
                    {else}
                        <a href="{$crumb.url}">{$crumb.label}</a>
                        <span class="gestore-breadcrumbs__sep">/</span>
                    {/if}
                {/foreach}
            </nav>

            <div class="gestore-topbar__actions">
                <div class="gestore-topbar__profile" id="gestoreProfileToggle">
                    {if $utente}
                        <span class="gestore-topbar__avatar">{$utente.name|truncate:1:"":true|upper}</span>
                        <div class="gestore-topbar__identity">
                            <span class="gestore-topbar__name">{$utente.name}</span>
                            <span class="gestore-topbar__role">Gestore</span>
                        </div>
                    {else}
                        <span class="gestore-topbar__avatar">G</span>
                        <div class="gestore-topbar__identity">
                            <span class="gestore-topbar__name">Gestore</span>
                            <span class="gestore-topbar__role">Non autenticato</span>
                        </div>
                    {/if}
                    <span class="ti ti-chevron-down gestore-topbar__chevron"></span>

                    <div class="gestore-topbar__dropdown" id="gestoreProfileDropdown">
                        <a href="{$base_url}/logout" class="gestore-topbar__dropdown-item">
                            <span class="ti ti-logout"></span> Esci
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <main class="gestore-content">
            {if $flash_message}
                <div class="gestore-flash gestore-flash--{$flash_type}">
                    <span class="gestore-flash__text">{$flash_message}</span>
                </div>
            {/if}

            {block name="content"}{/block}
        </main>

        <footer class="gestore-footer">
            <span>&copy; {$smarty.now|date_format:"%Y"} TableCrown</span>
        </footer>
    </div>

    {* Modal di conferma condiviso, riusabile dalle pagine figlie per azioni
       come elimina prodotto / annulla evento (vedi CGestore::eliminaProdottoGestore, annullaEventoGestore, ecc.) *}
    <div class="gestore-modal-overlay" id="gestoreConfirmOverlay">
        <div class="gestore-modal">
            <div class="gestore-modal__icon"><span class="ti ti-alert-triangle"></span></div>
            <p class="gestore-modal__text" id="gestoreConfirmText"></p>
            <div class="gestore-modal__actions">
                <button type="button" class="gestore-modal__btn gestore-modal__btn--cancel" id="gestoreConfirmCancel">Annulla</button>
                <button type="button" class="gestore-modal__btn gestore-modal__btn--confirm" id="gestoreConfirmOk">Conferma</button>
            </div>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Dropdown profilo (solo logout, dato che non esiste modifica account per il gestore)
    const toggle = document.getElementById('gestoreProfileToggle');
    const dropdown = document.getElementById('gestoreProfileDropdown');
    if (toggle && dropdown) {
        toggle.addEventListener('click', function (e) {
            e.stopPropagation();
            dropdown.classList.toggle('is-open');
        });
        document.addEventListener('click', function () {
            dropdown.classList.remove('is-open');
        });
    }

    // Submenu "Prodotti" nella sidebar
    document.querySelectorAll('[data-nav-toggle]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            btn.closest('.gestore-nav__group').classList.toggle('is-open');
        });
    });

    // Modal di conferma condiviso, per i form con data-confirm-message
    const overlay = document.getElementById('gestoreConfirmOverlay');
    const text = document.getElementById('gestoreConfirmText');
    const btnOk = document.getElementById('gestoreConfirmOk');
    const btnCancel = document.getElementById('gestoreConfirmCancel');
    let pendingForm = null;

    document.querySelectorAll('form[data-confirm-message]').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            pendingForm = form;
            text.textContent = form.dataset.confirmMessage;
            overlay.classList.add('is-open');
        });
    });

    btnOk.addEventListener('click', function () {
        overlay.classList.remove('is-open');
        if (pendingForm) {
            pendingForm.submit();
            pendingForm = null;
        }
    });

    btnCancel.addEventListener('click', function () {
        overlay.classList.remove('is-open');
        pendingForm = null;
    });

    overlay.addEventListener('click', function (e) {
        if (e.target === overlay) {
            overlay.classList.remove('is-open');
            pendingForm = null;
        }
    });
});
</script>
</body>
</html>