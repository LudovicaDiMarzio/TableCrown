{* TableCrown\Presentation\Views - Admin Area
   Layout master per tutte le pagine dell'area amministratore.
   Le pagine figlie definiscono il block "content" e possono
   aggiungere CSS specifici tramite il block "page_css".

   Variabili attese dal layer Control:
     $admin                      => ['nome' => string, 'ruolo' => string, 'avatarUrl' => string|null]
     $notificheNonLette          => int
     $segnalazioniInAttesaCount  => int
     $activeNav                  => string ('dashboard'|'utenti'|'segnalazioni'|'impostazioni')
     $pageTitle                  => string (facoltativo, per il tag <title>)
*}
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{if $pageTitle}{$pageTitle} - {/if}TableCrown Admin</title>
    <link rel="stylesheet" href="css/layout_admin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    {block name="page_css"}{/block}
</head>
<body class="admin-body">
<div class="admin-shell">

    <aside class="admin-sidebar">
        <div class="admin-sidebar__brand">
            <img src="/assets/img/logo.svg" alt="TableCrown" class="admin-sidebar__logo">
            <div class="admin-sidebar__brand-text">
                <span class="admin-sidebar__name">TableCrown</span>
                <span class="admin-sidebar__role">Amministratore</span>
            </div>
        </div>

        <nav class="admin-sidebar__nav">
            <a href="/admin/dashboard" class="admin-nav__item {if $activeNav === 'dashboard'}is-active{/if}">
                <span class="admin-nav__icon admin-nav__icon--dashboard"></span>
                Dashboard
            </a>
            <a href="/admin/utenti" class="admin-nav__item {if $activeNav === 'utenti'}is-active{/if}">
                <span class="admin-nav__icon admin-nav__icon--utenti"></span>
                Utenti
            </a>
            <a href="/admin/segnalazioni" class="admin-nav__item {if $activeNav === 'segnalazioni'}is-active{/if}">
                <span class="admin-nav__icon admin-nav__icon--segnalazioni"></span>
                Segnalazioni
                {if $segnalazioniInAttesaCount > 0}
                    <span class="admin-nav__badge">{$segnalazioniInAttesaCount}</span>
                {/if}
            </a>
            <a href="/admin/impostazioni" class="admin-nav__item {if $activeNav === 'impostazioni'}is-active{/if}">
                <span class="admin-nav__icon admin-nav__icon--impostazioni"></span>
                Impostazioni
            </a>
        </nav>
    </aside>

    <div class="admin-main">
        <header class="admin-topbar">
            <div class="admin-topbar__spacer"></div>

            <div class="admin-topbar__actions">
                <div class="admin-topbar__profile" id="adminProfileToggle">
                    <span class="admin-topbar__avatar"
                          {if $admin.avatarUrl}style="background-image:url('{$admin.avatarUrl}')"{/if}></span>
                    <div class="admin-topbar__identity">
                        <span class="admin-topbar__admin-name">{$admin.nome}</span>
                        <span class="admin-topbar__admin-role">{$admin.ruolo}</span>
                    </div>
                    <span class="admin-topbar__chevron ti ti-chevron-down"></span>
                    <div class="admin-topbar__dropdown" id="adminProfileDropdown">

                        <a href="/logout" class="admin-topbar__dropdown-item">
                            <span class="ti ti-logout"></span> Esci
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <main class="admin-content">
            {block name="content"}{/block}
        </main>

        <footer class="admin-footer">
            <span>&copy; {$annoCorrente} TableCrown</span>
        </footer>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('adminProfileToggle');
    const dropdown = document.getElementById('adminProfileDropdown');
    if (toggle && dropdown) {
        toggle.addEventListener('click', function (e) {
            e.stopPropagation();
            dropdown.classList.toggle('is-open');
        });
        document.addEventListener('click', function () {
            dropdown.classList.remove('is-open');
        });
    }
});
</script>
</body>
</html>