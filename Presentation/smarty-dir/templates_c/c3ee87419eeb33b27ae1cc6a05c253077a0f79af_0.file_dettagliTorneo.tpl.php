<?php
/* Smarty version 5.8.0, created on 2026-07-20 21:24:14
  from 'file:dettagliTorneo.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a5e75de754404_30428150',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c3ee87419eeb33b27ae1cc6a05c253077a0f79af' => 
    array (
      0 => 'dettagliTorneo.tpl',
      1 => 1784575451,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a5e75de754404_30428150 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>



<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_18065972636a5e75de73b7b5_66091714', "content");
?>


<?php echo '<script'; ?>
>
(function () {
    const maxPosti = parseInt("<?php echo (($tmp = $_smarty_tpl->getValue('serata')['postiLiberi'] ?? null)===null||$tmp==='' ? 0 ?? null : $tmp);?>
", 10);
    const input = document.getElementById('input-qty-posti');
    const btnMinus = document.getElementById('btn-qty-minus');
    const btnPlus = document.getElementById('btn-qty-plus');
    const btnPrenota = document.getElementById('btn-prenota');

    const modalOverlay = document.getElementById('modal-prenotazione');
    const modalBox = document.getElementById('modal-prenotazione-box');
    const modalIcona = document.getElementById('modal-prenotazione-icona');
    const modalTitolo = document.getElementById('modal-prenotazione-titolo');
    const modalTesto = document.getElementById('modal-prenotazione-testo');
    const modalChiudi = document.getElementById('modal-prenotazione-chiudi');

    function clamp(val) {
        if (val < 1) return 1;
        if (val > maxPosti) return maxPosti;
        return val;
    }

    btnMinus.addEventListener('click', function () {
        input.value = clamp(parseInt(input.value, 10) - 1);
    });

    btnPlus.addEventListener('click', function () {
        input.value = clamp(parseInt(input.value, 10) + 1);
    });

    function mostraModale(successo, titolo, testo) {
        modalBox.classList.remove('dettaglio-modal--successo', 'dettaglio-modal--errore');
        modalBox.classList.add(successo ? 'dettaglio-modal--successo' : 'dettaglio-modal--errore');
        modalIcona.innerHTML = successo
            ? '<i class="ti ti-check"></i>'
            : '<i class="ti ti-x"></i>';
        modalTitolo.textContent = titolo;
        modalTesto.textContent = testo;
        modalOverlay.classList.add('is-visibile');
    }

    function nascondiModale() {
        modalOverlay.classList.remove('is-visibile');
    }

    modalChiudi.addEventListener('click', nascondiModale);
    modalOverlay.addEventListener('click', function (e) {
        if (e.target === modalOverlay) nascondiModale();
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') nascondiModale();
    });

    if (btnPrenota) {
        btnPrenota.addEventListener('click', function () {
            const posti = parseInt(input.value, 10);

            btnPrenota.disabled = true;

            // TODO: sostituire con la vera chiamata al Controller quando l'endpoint sarà pronto
            fetch("<?php echo $_smarty_tpl->getValue('base_url');?>
/prenotazioneSerata", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "idSerata=" + encodeURIComponent(btnPrenota.dataset.id) + "&posti=" + encodeURIComponent(posti)
            })
                .then(function (res) {
                    if (!res.ok) throw new Error("Risposta non valida dal server");
                    return res.text();
                })
                .then(function () {
                    mostraModale(
                        true,
                        "Iscrizione confermata",
                        "Hai prenotato " + posti + (posti === 1 ? " posto" : " posti") + " per questa serata. A presto!"
                    );
                })
                .catch(function () {
                    mostraModale(
                        false,
                        "Prenotazione non riuscita",
                        "Non è stato possibile completare la prenotazione. Riprova più tardi o contatta lo staff."
                    );
                })
                .finally(function () {
                    btnPrenota.disabled = false;
                });
        });
    }
})();
<?php echo '</script'; ?>
>
<?php $_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "content"} */
class Block_18065972636a5e75de73b7b5_66091714 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/css/dettagli.css">

<div class="dettaglio-container">
    <div class="container">

        <!-- ── BLOCCO SUPERIORE (con box prezzo) ── -->
        <div class="dettaglio-top dettaglio-top--con-prezzo">

            <div class="dettaglio-gallery">
                <img src="<?php echo $_smarty_tpl->getValue('torneo')['immagine'];?>
" alt="<?php echo $_smarty_tpl->getValue('torneo')['nome'];?>
" class="dettaglio-img">
            </div>

            <div class="dettaglio-info">
                <h1 class="dettaglio-nome" style="color: #2c3e7a;"><?php echo $_smarty_tpl->getValue('torneo')['nome'];?>
</h1>

                <ul class="dettaglio-meta">
                    <li><i class="ti ti-calendar-event"></i> <?php echo $_smarty_tpl->getValue('torneo')['data'];?>
</li>
                    <li><i class="ti ti-users"></i> <?php echo $_smarty_tpl->getValue('torneo')['postiLiberi'];?>
 / <?php echo $_smarty_tpl->getValue('torneo')['postiTotali'];?>
 posti liberi</li>
                    <li><i class="ti ti-chess-king"></i> <?php echo $_smarty_tpl->getValue('torneo')['nomeAttivita'];?>
</li>
                </ul>
            </div>

            <div class="dettaglio-prezzo-box">

                <?php if ($_smarty_tpl->getValue('torneo')['premio']) {?>
                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/prodotto/<?php echo $_smarty_tpl->getValue('torneo')['premio']['id'];?>
" class="dettaglio-premio-card">
                    <div class="dettaglio-premio-img-wrapper">
                        <img src="<?php echo $_smarty_tpl->getValue('torneo')['premio']['immagine'];?>
" alt="<?php echo $_smarty_tpl->getValue('torneo')['premio']['nome'];?>
" class="dettaglio-premio-img">
                    </div>
                    <div class="dettaglio-premio-info">
                        <span class="dettaglio-premio-label">Premio in palio</span>
                        <span class="dettaglio-premio-nome"><?php echo $_smarty_tpl->getValue('torneo')['premio']['nome'];?>
</span>
                    </div>
                </a>
                <?php }?>

                <div class="dettaglio-prezzo-tot">
                    <span class="dettaglio-prezzo-tot-label">Totale</span>
                    <span class="dettaglio-prezzo-tot-value" id="prezzo-tot-<?php echo $_smarty_tpl->getValue('torneo')['id'];?>
">€ <?php echo $_smarty_tpl->getValue('torneo')['prezzo'];?>
</span>
                </div>

                <button type="button" class="btn-iscriviti" data-id="<?php echo $_smarty_tpl->getValue('torneo')['id'];?>
">
                    Iscriviti
                </button>
            </div>

        </div>

        <!-- ── DESCRIZIONE ── -->
        <div class="dettaglio-descrizione">
            <h2 class="dettaglio-section-title">Descrizione</h2>
            <p class="dettaglio-descrizione-testo"><?php echo $_smarty_tpl->getValue('torneo')['descrizione'];?>
</p>
        </div>

        <!-- ── CHALLENGE DI APPARTENENZA (se presente) ── -->
        <?php if ($_smarty_tpl->getValue('torneo')['challenge']) {?>
        <div class="dettaglio-correlati">
            <h2 class="dettaglio-section-title">Fa parte della Challenge</h2>
            <div class="dettaglio-correlati-grid">
                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/eventi/dettaglio?id=<?php echo $_smarty_tpl->getValue('torneo')['challenge']['idEvento'];?>
" class="dettaglio-correlato-card">
                    <div class="dettaglio-correlato-img-wrapper">
                        <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/placeholder.jpg" alt="<?php echo $_smarty_tpl->getValue('torneo')['challenge']['nomeEvento'];?>
" class="dettaglio-correlato-img">
                    </div>
                    <p class="dettaglio-correlato-nome"><?php echo $_smarty_tpl->getValue('torneo')['challenge']['nomeEvento'];?>
</p>
                </a>
            </div>
        </div>
        <?php }?>

    </div>
</div>
<?php
}
}
/* {/block "content"} */
}
