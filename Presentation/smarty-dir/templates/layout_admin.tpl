{* TableCrown\Presentation\Views - Admin Area
   Layout master per tutte le pagine dell'area amministratore.
   Le pagine figlie definiscono il block "content" e possono
   aggiungere CSS specifici tramite il block "page_css".

   Variabili attese dal layer Control:
     $admin                      => ['nome' => string, 'ruolo' => string, 'avatarUrl' => string|null]
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
    <link rel="stylesheet" href="{$base_url}/css/layout_admin.css">
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
            <a href="{$base_url}/admin/dashboard" class="admin-nav__item">
                <span class="admin-nav__icon admin-nav__icon--dashboard"></span>
                Dashboard
            </a>
            <a href="{$base_url}/admin/utenti" class="admin-nav__item">
                <span class="admin-nav__icon admin-nav__icon--utenti"></span>
                Utenti
            </a>
            <a href="{$base_url}/admin/recensioni" class="admin-nav__item">
                <span class="admin-nav__icon admin-nav__icon--segnalazioni"></span>
                Segnalazioni
                {if $segnalazioniInAttesaCount > 0}
                    <span class="admin-nav__badge">{$segnalazioniInAttesaCount}</span>
                {/if}
            </a>
        </nav>
    </aside>

    <div class="admin-main">
        <header class="admin-topbar">
            <div class="admin-topbar__spacer"></div>

            <div class="admin-topbar__actions">
                <div class="admin-topbar__profile" id="adminProfileToggle">
                    <span class="admin-topbar__avatar"></span>
                    <div class="admin-topbar__identity">
                        <span class="admin-topbar__admin-name">{$utente.name}</span>
                        <span class="admin-topbar__admin-role">Amministratore</span>
                    </div>
                    <span class="admin-topbar__chevron ti ti-chevron-down"></span>
                    <div class="admin-topbar__dropdown" id="adminProfileDropdown">

                        <a href="{$base_url}/logout" class="admin-topbar__dropdown-item">
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

    <!-- Modal di conferma, condiviso da tutte le pagine admin -->
    <div class="admin-modal-overlay" id="adminConfirmOverlay">
        <div class="admin-modal">
            <div class="admin-modal__icon"><span class="ti ti-alert-triangle"></span></div>
            <p class="admin-modal__text" id="adminConfirmText"></p>
            <div class="admin-modal__actions">
                <button type="button" class="admin-modal__btn admin-modal__btn--cancel" id="adminConfirmCancel">Annulla</button>
                <button type="button" class="admin-modal__btn admin-modal__btn--confirm" id="adminConfirmOk">Conferma</button>
            </div>
        </div>
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

    // Modal di conferma per i form con data-confirm-message
    const overlay = document.getElementById('adminConfirmOverlay');
    const text = document.getElementById('adminConfirmText');
    const btnOk = document.getElementById('adminConfirmOk');
    const btnCancel = document.getElementById('adminConfirmCancel');
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