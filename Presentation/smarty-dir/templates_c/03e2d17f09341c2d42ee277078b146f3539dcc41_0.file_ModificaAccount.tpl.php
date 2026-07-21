<?php
/* Smarty version 5.8.0, created on 2026-07-21 09:52:08
  from 'file:ModificaAccount.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a5f2528735271_70016851',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '03e2d17f09341c2d42ee277078b146f3539dcc41' => 
    array (
      0 => 'ModificaAccount.tpl',
      1 => 1784620325,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a5f2528735271_70016851 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_8243048526a5f25287210d5_72442145', "extra_css");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_13805049566a5f25287262a8_48808670', "content");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_7747424226a5f25287333f7_53434436', "extra_js");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "extra_css"} */
class Block_8243048526a5f25287210d5_72442145 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

    <link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/css/ModificaAccount.css">
<?php
}
}
/* {/block "extra_css"} */
/* {block "content"} */
class Block_13805049566a5f25287262a8_48808670 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<div class="modifica-account-container">
    <div class="container">

                <div class="modifica-account-topbar">
            <div class="modifica-account-topbar-actions">
                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/logout" class="modifica-account-logout">
                    <i class="ti ti-logout"></i> Log-out
                </a>

                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/profilo/modifica/elimina" class="modifica-account-elimina" id="modifica-account-elimina-link">
                    <i class="ti ti-trash"></i> Elimina account
                </a>
            </div>
        </div>

        <form action="<?php echo $_smarty_tpl->getValue('base_url');?>
/profilo/modifica" method="post" class="modifica-account-form" enctype="multipart/form-data" id="modifica-account-form">

            
                        <div class="modifica-account-avatar-wrap">
                <div class="modifica-account-avatar-circle">
                    <div class="modifica-account-avatar">
                        <?php if ((true && ($_smarty_tpl->hasVariable('immagineUtente') && null !== ($_smarty_tpl->getValue('immagineUtente') ?? null))) && $_smarty_tpl->getValue('immagineUtente')) {?>
                            <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/avatar/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('immagineUtente'), ENT_QUOTES, 'UTF-8', true);?>
"
                                 onerror="this.onerror=null; this.src='<?php echo $_smarty_tpl->getValue('base_url');?>
/img/avatar-default.png'"
                                 alt="<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('nomeUtente') ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
"
                                 class="modifica-account-avatar-img"
                                 id="modifica-account-avatar-preview">
                        <?php } else { ?>
                            <span class="modifica-account-avatar-placeholder" id="modifica-account-avatar-preview">IMG</span>
                        <?php }?>
                    </div>

                    <label for="modifica-account-avatar-input" class="modifica-account-avatar-edit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 4h-6a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-6" />
                            <path d="M17.5 3.5a2.121 2.121 0 0 1 3 3l-9.5 9.5l-4 1l1 -4l9.5 -9.5z" />
                        </svg>
                    </label>
                </div>

                <input type="file"
                       id="modifica-account-avatar-input"
                       name="img_profilo"
                       accept="image/*"
                       class="modifica-account-avatar-input">

                <span class="modifica-account-avatar-hint">Tocca la matita per cambiare foto</span>
            </div>

                        <div class="modifica-account-card">
                <div class="modifica-account-fields">

                    <div class="modifica-account-field">
                        <label for="nome" class="modifica-account-label">
                            <i class="ti ti-user"></i> Nickname
                        </label>
                        <input type="text"
                               id="nome"
                               name="nome"
                               class="modifica-account-input"
                               value="<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('nomeUtente') ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
">
                    </div>

                    <div class="modifica-account-field">
                        <label for="email" class="modifica-account-label">
                            <i class="ti ti-mail"></i> Email
                        </label>
                        <input type="email"
                               id="email"
                               name="email"
                               class="modifica-account-input"
                               value="<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('emailUtente') ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
">
                    </div>

                </div>
            </div>

                        <div class="modifica-account-actions">
                <button type="button"
                        class="modifica-account-btn-secondary"
                        id="modifica-account-password-toggle"
                        aria-expanded="false"
                        aria-controls="modifica-account-password-card">
                    <i class="ti ti-lock"></i> Modifica Password
                </button>

                <button type="submit" class="modifica-account-btn-primary">
                    <i class="ti ti-check"></i> Salva
                </button>
            </div>

        </form>

                <div class="modifica-account-password-card" id="modifica-account-password-card" hidden>
            <h3 class="modifica-account-password-title">
                <i class="ti ti-shield-lock"></i> Cambia Password
            </h3>

            <form action="<?php echo $_smarty_tpl->getValue('base_url');?>
/profilo/modifica/password" method="post" class="modifica-account-password-form" id="modifica-account-password-form">

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

                <button type="submit" class="modifica-account-btn-primary modifica-account-btn-password-salva">
                    <i class="ti ti-check"></i> Salva
                </button>

            </form>
        </div>

                <div class="modifica-account-popup-overlay" id="modifica-account-popup" hidden>
            <div class="modifica-account-popup-box">
                <p class="modifica-account-popup-message" id="modifica-account-popup-message"></p>
                <button type="button" class="modifica-account-btn-primary" id="modifica-account-popup-close">Chiudi</button>
            </div>
        </div>

                <div class="modifica-account-popup-overlay" id="modifica-account-elimina-popup" hidden>
            <div class="modifica-account-popup-box">
                <i class="ti ti-alert-triangle modifica-account-popup-icon"></i>
                <p class="modifica-account-popup-message">Sei sicuro di voler eliminare l'account?</p>

                <div class="modifica-account-field">
                    <label for="elimina_password" class="modifica-account-label">Inserisci la password per finalizzare l'operazione</label>
                    <input type="password" id="elimina_password" name="elimina_password" class="modifica-account-input">
                </div>

                <p class="modifica-account-popup-error" id="modifica-account-elimina-error" hidden>La password è errata, riprova.</p>

                <div class="modifica-account-popup-actions">
                    <button type="button" class="modifica-account-btn-secondary" id="modifica-account-elimina-annulla">Annulla</button>
                    <button type="button" class="modifica-account-btn-primary" id="modifica-account-elimina-conferma">Conferma</button>
                </div>
            </div>
        </div>

    </div>
</div>
<?php
}
}
/* {/block "content"} */
/* {block "extra_js"} */
class Block_7747424226a5f25287333f7_53434436 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<?php echo '<script'; ?>
>

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

   

    // ── POPUP MESSAGGI (modifica account) ──
    var popup        = document.getElementById('modifica-account-popup');
    var popupMessage = document.getElementById('modifica-account-popup-message');
    var popupClose   = document.getElementById('modifica-account-popup-close');

    function mostraPopup(messaggio) {
        popupMessage.textContent = messaggio;
        popup.removeAttribute('hidden');
    }

    if (popupClose) {
        popupClose.addEventListener('click', function() {
            popup.setAttribute('hidden', '');
        });
    }

    // ── SUBMIT MODIFICA PASSWORD (AJAX) ──
    var passwordForm     = document.getElementById('modifica-account-password-form');
    var pswVecchiaInput  = document.getElementById('psw_vecchia');
    var pswNuovaInput    = document.getElementById('psw_nuova');
    var pswConfermaInput = document.getElementById('psw_conferma');

    if (passwordForm) {
        passwordForm.addEventListener('submit', function(e) {
            e.preventDefault();

            var pswVecchia  = pswVecchiaInput.value;
            var pswNuova    = pswNuovaInput.value;
            var pswConferma = pswConfermaInput.value;

            if (pswNuova !== pswConferma) {
                mostraPopup('La nuova password e la conferma non coincidono.');
                return;
            }

            fetch(passwordForm.action, {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
        'X-Requested-With': 'XMLHttpRequest'
    },
    credentials: 'same-origin',
    body: 'vecchia_password=' + encodeURIComponent(pswVecchia)
        + '&nuova_password=' + encodeURIComponent(pswNuova)
        + '&conferma_password=' + encodeURIComponent(pswConferma)
})
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                if (data.status === 'ok') {
                    window.location.href = '<?php echo $_smarty_tpl->getValue('base_url');?>
/profilo/modifica';
                } else if (data.reason === 'nuova_non_valida') {
                    mostraPopup('La nuova password non va bene, provane un\'altra.');
                } else if (data.reason === 'vecchia_errata') {
                    mostraPopup('La vecchia password non è quella corretta, riprova.');
                } else if (data.reason === 'errore_salvataggio') {
                    mostraPopup('Si è verificato un errore durante il salvataggio della password, riprova più tardi.');
                } else {
                    mostraPopup('Si è verificato un errore, riprova più tardi.');
                }
            })
            .catch(function() {
                mostraPopup('Si è verificato un errore di connessione, riprova più tardi.');
            });
        });
    }

    // ── POPUP CONFERMA ELIMINAZIONE ACCOUNT ──
    var eliminaLink      = document.getElementById('modifica-account-elimina-link');
    var eliminaPopup      = document.getElementById('modifica-account-elimina-popup');
    var eliminaPassword   = document.getElementById('elimina_password');
    var eliminaError      = document.getElementById('modifica-account-elimina-error');
    var eliminaAnnullaBtn = document.getElementById('modifica-account-elimina-annulla');
    var eliminaConfermaBtn = document.getElementById('modifica-account-elimina-conferma');

    function chiudiEliminaPopup() {
        eliminaPopup.setAttribute('hidden', '');
        eliminaPassword.value = '';
        eliminaError.setAttribute('hidden', '');
    }

    if (eliminaLink && eliminaPopup) {
        eliminaLink.addEventListener('click', function(e) {
            e.preventDefault();
            eliminaError.setAttribute('hidden', '');
            eliminaPassword.value = '';
            eliminaPopup.removeAttribute('hidden');
            eliminaPassword.focus();
        });
    }

    if (eliminaAnnullaBtn) {
        eliminaAnnullaBtn.addEventListener('click', function() {
            chiudiEliminaPopup();
        });
    }

    if (eliminaConfermaBtn) {
        eliminaConfermaBtn.addEventListener('click', function() {
            var password = eliminaPassword.value;

            if (!password) {
                eliminaError.textContent = 'Inserisci la password per continuare.';
                eliminaError.removeAttribute('hidden');
                return;
            }

            fetch('<?php echo $_smarty_tpl->getValue('base_url');?>
/profilo/modifica/elimina', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
        'X-Requested-With': 'XMLHttpRequest'
    },
    credentials: 'same-origin',
    body: 'password=' + encodeURIComponent(password)
})
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                if (data.status === 'ok') {
                    window.location.href = '<?php echo $_smarty_tpl->getValue('base_url');?>
/';
                } else if (data.reason === 'password_errata') {
                    eliminaError.textContent = 'La password è errata, riprova.';
                    eliminaError.removeAttribute('hidden');
                    eliminaPassword.value = '';
                    eliminaPassword.focus();
                } else {
                    eliminaError.textContent = 'Si è verificato un errore, riprova più tardi.';
                    eliminaError.removeAttribute('hidden');
                }
            })
            .catch(function() {
                eliminaError.textContent = 'Si è verificato un errore di connessione, riprova più tardi.';
                eliminaError.removeAttribute('hidden');
            });
        });
    }

})();

<?php echo '</script'; ?>
>
<?php
}
}
/* {/block "extra_js"} */
}
