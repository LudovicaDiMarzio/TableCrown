<?php
/* Smarty version 5.8.0, created on 2026-07-11 11:06:32
  from 'file:ModificaAccount.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a5207982bbb19_56192156',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '03e2d17f09341c2d42ee277078b146f3539dcc41' => 
    array (
      0 => 'ModificaAccount.tpl',
      1 => 1783760709,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a5207982bbb19_56192156 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_13106443776a5207982a56b9_13076062', "extra_css");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_20954901576a5207982a99c1_09128088', "content");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_15508079766a5207982ba6b4_45428078', "extra_js");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "extra_css"} */
class Block_13106443776a5207982a56b9_13076062 extends \Smarty\Runtime\Block
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
class Block_20954901576a5207982a99c1_09128088 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<div class="modifica-account-container">
    <div class="container">

                <div class="modifica-account-topbar">
            <div class="modifica-account-breadcrumb">
                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/account" class="modifica-account-breadcrumb-link">Il mio account</a>
                <span class="modifica-account-breadcrumb-sep">&gt;</span>
                <span class="modifica-account-breadcrumb-current">Modifica account</span>
            </div>

            <div class="modifica-account-topbar-actions">
                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/logout" class="modifica-account-logout">
                    Log-out
                </a>

                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/account/elimina" class="modifica-account-elimina" id="modifica-account-elimina-link">
                    Elimina account
                </a>
            </div>
        </div>

        <form action="<?php echo $_smarty_tpl->getValue('base_url');?>
/account/modifica" method="post" class="modifica-account-form" enctype="multipart/form-data" id="modifica-account-form">

                        <div class="modifica-account-avatar-wrap">
                <div class="modifica-account-avatar">
                    <?php if ((true && (true && null !== ($_smarty_tpl->getValue('utente')['avatar'] ?? null))) && $_smarty_tpl->getValue('utente')['avatar']) {?>
                        <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/avatar/<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('utente')['avatar'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
"
                             onerror="this.onerror=null; this.src='<?php echo $_smarty_tpl->getValue('base_url');?>
/img/avatar-default.png'"
                             alt="<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('utente')['nome'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
"
                             class="modifica-account-avatar-img"
                             id="modifica-account-avatar-preview">
                    <?php } else { ?>
                        <span class="modifica-account-avatar-placeholder" id="modifica-account-avatar-preview">IMG</span>
                    <?php }?>
                </div>

                <label for="modifica-account-avatar-input" class="modifica-account-avatar-edit">
                    <i class="ti ti-pencil"></i> Edit
                </label>
                <input type="file"
                       id="modifica-account-avatar-input"
                       name="avatar"
                       accept="image/*"
                       class="modifica-account-avatar-input">
            </div>

                        <div class="modifica-account-fields">

                <div class="modifica-account-field">
                    <label for="nickname" class="modifica-account-label modifica-account-label--blue">Nickname</label>
                    <input type="text"
                           id="nickname"
                           name="nickname"
                           class="modifica-account-input"
                           value="<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('utente')['nome'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
">
                </div>

                <div class="modifica-account-field">
                    <label for="email" class="modifica-account-label modifica-account-label--blue">Email</label>
                    <input type="email"
                           id="email"
                           name="email"
                           class="modifica-account-input"
                           value="<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('utente')['email'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
">
                </div>

                <div class="modifica-account-field">
                    <label for="eta" class="modifica-account-label modifica-account-label--blue">Età</label>
                    <input type="number"
                           id="eta"
                           name="eta"
                           min="18"
                           class="modifica-account-input"
                           value="<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('utente')['eta'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
">
                </div>

                <div class="modifica-account-field modifica-account-field-checkbox">
                    <label class="modifica-account-checkbox-label">
                        <input type="checkbox"
                               name="mostra_foto"
                               value="1"
                               <?php if ((true && (true && null !== ($_smarty_tpl->getValue('utente')['mostra_foto'] ?? null))) && $_smarty_tpl->getValue('utente')['mostra_foto']) {?>checked<?php }?>>
                        Mostra la mia foto profilo pubblicamente
                    </label>
                </div>

            </div>

                        <div class="modifica-account-actions">
                <button type="button"
                        class="modifica-account-btn-secondary"
                        id="modifica-account-password-toggle"
                        aria-expanded="false"
                        aria-controls="modifica-account-password-card">
                    Modifica Password
                </button>

                <button type="submit" class="modifica-account-btn-primary">Salva</button>
            </div>

        </form>

                <div class="modifica-account-password-card" id="modifica-account-password-card" hidden>
            <form action="<?php echo $_smarty_tpl->getValue('base_url');?>
/account/password" method="post" class="modifica-account-password-form" id="modifica-account-password-form">

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

                <button type="submit" class="modifica-account-btn-primary modifica-account-btn-password-salva">Salva</button>

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
class Block_15508079766a5207982ba6b4_45428078 extends \Smarty\Runtime\Block
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

    // ── VALIDAZIONE ETÀ >= 18 ──
    var form = document.getElementById('modifica-account-form');
    var etaInput = document.getElementById('eta');

    if (form && etaInput) {
        form.addEventListener('submit', function(e) {
            var eta = parseInt(etaInput.value, 10);
            if (isNaN(eta) || eta < 18) {
                e.preventDefault();
                alert('Devi avere almeno 18 anni per registrarti.');
                etaInput.focus();
            }
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
                headers: { 'Content-Type': 'application/json' },
                credentials: 'same-origin',
                body: JSON.stringify({
                    psw_vecchia: pswVecchia,
                    psw_nuova: pswNuova
                })
            })
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                if (data.status === 'ok') {
                    window.location.href = '<?php echo $_smarty_tpl->getValue('base_url');?>
/account';
                } else if (data.reason === 'nuova_non_valida') {
                    mostraPopup('La nuova password non va bene, provane un\'altra.');
                } else if (data.reason === 'vecchia_errata') {
                    mostraPopup('La vecchia password non è quella corretta, riprova.');
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
/account/elimina', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                credentials: 'same-origin',
                body: JSON.stringify({ password: password })
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
