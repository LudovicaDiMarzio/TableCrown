<?php
/* Smarty version 5.8.0, created on 2026-07-22 14:48:07
  from 'file:dettagliSerata.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a60bc07050a95_17191663',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2e242b2041184fd4a5af5585378b157b229b3099' => 
    array (
      0 => 'dettagliSerata.tpl',
      1 => 1784632951,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a60bc07050a95_17191663 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>



<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_4793991116a60bc0703b7c0_97078217', "content");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "content"} */
class Block_4793991116a60bc0703b7c0_97078217 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/css/dettagli.css">

<div class="dettaglio-container">
    <div class="container">

        <!-- ── BLOCCO SUPERIORE (senza box prezzo) ── -->
        <div class="dettaglio-top">

            <div class="dettaglio-gallery">
                <span class="dettaglio-badge-attivita"><?php echo $_smarty_tpl->getValue('serata')['nomeAttivita'];?>
</span>
                <img src="<?php echo $_smarty_tpl->getValue('serata')['immagine'];?>
" alt="<?php echo $_smarty_tpl->getValue('serata')['nome'];?>
" class="dettaglio-img">
            </div>

            <div class="dettaglio-info">
                <h1 class="dettaglio-nome dettaglio-nome--serata"><?php echo $_smarty_tpl->getValue('serata')['nome'];?>
</h1>

                <ul class="dettaglio-meta dettaglio-meta--card">
                    <li class="dettaglio-meta-item">
                        <span class="dettaglio-meta-item-icon"><i class="ti ti-calendar-event"></i></span>
                        <span class="dettaglio-meta-item-text">
                            <span class="dettaglio-meta-item-label">Data</span>
                            <span class="dettaglio-meta-item-value"><?php echo $_smarty_tpl->getValue('serata')['data'];?>
</span>
                        </span>
                    </li>
                    <li class="dettaglio-meta-item">
                        <span class="dettaglio-meta-item-icon"><i class="ti ti-chess-king"></i></span>
                        <span class="dettaglio-meta-item-text">
                            <span class="dettaglio-meta-item-label">Attività</span>
                            <span class="dettaglio-meta-item-value"><?php echo $_smarty_tpl->getValue('serata')['nomeAttivita'];?>
</span>
                        </span>
                    </li>
                </ul>

                <div class="dettaglio-disponibilita">
                    <div class="dettaglio-disponibilita-testo">
                        <span>Posti disponibili</span>
                        <span><?php echo $_smarty_tpl->getValue('serata')['postiLiberi'];?>
 / <?php echo $_smarty_tpl->getValue('serata')['postiTotali'];?>
</span>
                    </div>
                    <div class="dettaglio-disponibilita-bar">
                        <div class="dettaglio-disponibilita-fill<?php if ($_smarty_tpl->getValue('serata')['postiTotali'] > 0 && ($_smarty_tpl->getValue('serata')['postiLiberi']/$_smarty_tpl->getValue('serata')['postiTotali']) <= 0.25) {?> dettaglio-disponibilita-fill--scarsa<?php }?>"
                             style="width: <?php if ($_smarty_tpl->getValue('serata')['postiTotali'] > 0) {
echo ($_smarty_tpl->getValue('serata')['postiLiberi']/$_smarty_tpl->getValue('serata')['postiTotali'])*100;
} else { ?>0<?php }?>%;"></div>
                    </div>
                </div>

                <form method="POST" action="<?php echo $_smarty_tpl->getValue('base_url');?>
/eventi/partecipa" id="form-prenota">
                    <input type="hidden" name="id_evento" value="<?php echo $_smarty_tpl->getValue('serata')['id'];?>
">

                    <div class="dettaglio-azione-card">
                        <button type="submit" class="btn-partecipa" id="btn-prenota"
                                <?php if ($_smarty_tpl->getValue('serata')['postiLiberi'] <= 0) {?>disabled<?php }?>>
                            <i class="ti ti-calendar-check"></i>
                            <?php if ($_smarty_tpl->getValue('serata')['postiLiberi'] <= 0) {?>Posti esauriti<?php } else { ?>Prenota<?php }?>
                        </button>
                    </div>
                </form>
            </div>

        </div>

        <!-- ── DESCRIZIONE ── -->
        <div class="dettaglio-descrizione">
            <h2 class="dettaglio-section-title">Descrizione</h2>
            <p class="dettaglio-descrizione-testo"><?php echo $_smarty_tpl->getValue('serata')['descrizione'];?>
</p>
        </div>

    </div>
</div>


<?php echo '<script'; ?>
>
(function () {
    const maxPosti = parseInt("<?php echo (($tmp = $_smarty_tpl->getValue('serata')['postiLiberi'] ?? null)===null||$tmp==='' ? 0 ?? null : $tmp);?>
", 10);
    const input = document.getElementById('input-qty-posti');
    const btnMinus = document.getElementById('btn-qty-minus');
    const btnPlus = document.getElementById('btn-qty-plus');

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
})();
<?php echo '</script'; ?>
>
<?php
}
}
/* {/block "content"} */
}
