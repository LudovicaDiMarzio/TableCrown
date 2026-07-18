<?php
/* Smarty version 5.8.0, created on 2026-07-18 10:43:08
  from 'file:prodotto.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a5b3c9c5ef8a2_80506328',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '61e5509dd7b9a25684d0dc74abf9df1db1b26eb8' => 
    array (
      0 => 'prodotto.tpl',
      1 => 1784364185,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a5b3c9c5ef8a2_80506328 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_11233842066a5b3c9c59b5e6_14361756', "extra_css");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_5744900016a5b3c9c59fcf0_52816285', "content");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_20944370266a5b3c9c5ed131_97720803', "extra_js");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "extra_css"} */
class Block_11233842066a5b3c9c59b5e6_14361756 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

    <link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/css/prodotto.css">
<?php
}
}
/* {/block "extra_css"} */
/* {block "content"} */
class Block_5744900016a5b3c9c59fcf0_52816285 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>


<div class="prodotto-container">
    <div class="container">

    

                <div class="prodotto-top">

                        <div class="prodotto-gallery">
                <div class="gallery-main-wrapper">
                    <div class="gallery-main" id="gallery-main">
                        <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/prodotti/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('immagine'), ENT_QUOTES, 'UTF-8', true);?>
"
                             alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('nome'), ENT_QUOTES, 'UTF-8', true);?>
"
                             class="gallery-main-img is-active"
                             data-index="0">
                    </div>
                </div>
            </div>

                        <div class="prodotto-info">

                        <?php if ($_smarty_tpl->getValue('disponibilita') == 'esaurito') {?>
                <span class="prodotto-badge prodotto-badge-esaurito">Esaurito</span>
            <?php } elseif ($_smarty_tpl->getValue('disponibilita') == 'non_disponibile') {?>
                <span class="prodotto-badge prodotto-badge-non-disponibile">Non disponibile</span>
            <?php } elseif ($_smarty_tpl->getValue('disponibilita') == 'in_arrivo') {?>
                <span class="prodotto-badge prodotto-badge-in-arrivo">In arrivo</span>
            <?php } elseif ($_smarty_tpl->getValue('disponibilita') == 'disponibile') {?>
                <span class="prodotto-badge prodotto-badge-disponibile">Disponibile</span>
            <?php } else { ?>
                <span class="prodotto-badge prodotto-badge-sconosciuto">Stato sconosciuto</span>
            <?php }?>

                <h1 class="prodotto-nome"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('nome'), ENT_QUOTES, 'UTF-8', true);?>
</h1>

                                <div class="prodotto-rating">
                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, array(1,2,3,4,5), 's');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('s')->value) {
$foreach0DoElse = false;
?>
                        <?php if ($_smarty_tpl->getValue('s') <= $_smarty_tpl->getValue('valutazione_media')) {?>
                            <i class="ti ti-star-filled"></i>
                        <?php } elseif (($_smarty_tpl->getValue('s')-$_smarty_tpl->getValue('valutazione_media')) < 1) {?>
                            <i class="ti ti-star-half-filled"></i>
                        <?php } else { ?>
                            <i class="ti ti-star"></i>
                        <?php }?>
                    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                    <span class="prodotto-rating-value">(<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('valutazione_media'),1);?>
)</span>
                    <a href="#recensioni" class="prodotto-rating-link">Leggi Recensioni</a>
                </div>

                                <div class="prodotto-meta">
                    <?php if ((true && ($_smarty_tpl->hasVariable('numeroGiocatoriMin') && null !== ($_smarty_tpl->getValue('numeroGiocatoriMin') ?? null))) && (true && ($_smarty_tpl->hasVariable('numeroGiocatoriMax') && null !== ($_smarty_tpl->getValue('numeroGiocatoriMax') ?? null)))) {?>
                        <span class="prodotto-meta-item">
                            <i class="ti ti-users"></i>
                            <?php echo $_smarty_tpl->getValue('numeroGiocatoriMin');?>
–<?php echo $_smarty_tpl->getValue('numeroGiocatoriMax');?>
 giocatori
                        </span>
                    <?php }?>
                    <?php if ((true && ($_smarty_tpl->hasVariable('etaMinima') && null !== ($_smarty_tpl->getValue('etaMinima') ?? null)))) {?>
                        <span class="prodotto-meta-item">
                            <i class="ti ti-baby-carriage"></i>
                            <?php echo $_smarty_tpl->getValue('etaMinima');?>
+ anni
                        </span>
                    <?php }?>
                    <?php if ((true && ($_smarty_tpl->hasVariable('durataMedia') && null !== ($_smarty_tpl->getValue('durataMedia') ?? null)))) {?>
                        <span class="prodotto-meta-item">
                            <i class="ti ti-clock"></i>
                            <?php echo $_smarty_tpl->getValue('durataMedia');?>
 min
                        </span>
                    <?php }?>
                    <?php if ((true && ($_smarty_tpl->hasVariable('difficolta') && null !== ($_smarty_tpl->getValue('difficolta') ?? null)))) {?>
                        <span class="prodotto-meta-item">
                            <i class="ti ti-flame"></i>
                            <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('difficolta'), ENT_QUOTES, 'UTF-8', true);?>

                        </span>
                    <?php }?>
                    <?php if ((true && ($_smarty_tpl->hasVariable('lingua') && null !== ($_smarty_tpl->getValue('lingua') ?? null)))) {?>
                        <span class="prodotto-meta-item">
                            <i class="ti ti-language"></i>
                            <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('lingua'), ENT_QUOTES, 'UTF-8', true);?>

                        </span>
                    <?php }?>
                </div>

                                <div class="prodotto-prezzo-wrapper">
                    <?php if ($_smarty_tpl->getValue('sconto')) {?>
                        <span class="prodotto-prezzo">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prezzo_scontato'),2);?>
</span>
                        <span class="prodotto-prezzo-old">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prezzo'),2);?>
</span>
                        <span class="prodotto-sconto-badge">-<?php echo sprintf("%.0f",$_smarty_tpl->getValue('percentuale_sconto'));?>
%</span>
                    <?php } elseif ((true && ($_smarty_tpl->hasVariable('prezzo') && null !== ($_smarty_tpl->getValue('prezzo') ?? null)))) {?>
                        <span class="prodotto-prezzo">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prezzo'),2);?>
</span>
                    <?php } else { ?>
                        <span class="prodotto-prezzo-nd">Prezzo N/D</span>
                    <?php }?>
                </div>

            </div>

                        <div class="prodotto-acquisto-box">

                                <div class="acquisto-disponibilita">
                    <?php if ($_smarty_tpl->getValue('disponibilita') == 'disponibile') {?>
                        <i class="ti ti-circle-check"></i>
                        <span>Disponibile</span>
                    <?php } elseif ($_smarty_tpl->getValue('disponibilita') == 'esaurito') {?>
                        <i class="ti ti-circle-x"></i>
                        <span>Esaurito</span>
                    <?php } elseif ($_smarty_tpl->getValue('disponibilita') == 'non disponibile') {?>
                        <i class="ti ti-circle-x"></i>
                        <span>Non disponibile</span>
                    <?php } elseif ($_smarty_tpl->getValue('disponibilita') == 'in arrivo') {?>
                        <i class="ti ti-clock"></i>
                        <span>In arrivo</span>
                    <?php } else { ?>
                        <i class="ti ti-clock"></i>
                        <span>Annunciato</span>
                    <?php }?>
                </div>

                                <?php if ($_smarty_tpl->getValue('disponibilita') == 'disponibile') {?>

                                        <div class="acquisto-quantita">
                        <label class="acquisto-quantita-label" for="qty-input">Quantità:</label>
                        <div class="quantita-stepper">
                            <button class="button quantita-btn" id="qty-minus" type="button" aria-label="Diminuisci quantità">
                                <i class="ti ti-minus"></i>
                            </button>
                            <input type="number"
                                   id="qty-input"
                                   class="input quantita-input"
                                   value="1"
                                   min="1"
                                   max="99"
                                   aria-label="Quantità">
                            <button class="button quantita-btn" id="qty-plus" type="button" aria-label="Aumenta quantità">
                                <i class="ti ti-plus"></i>
                            </button>
                        </div>
                    </div>

                                        <?php if ((true && ($_smarty_tpl->hasVariable('prezzo') && null !== ($_smarty_tpl->getValue('prezzo') ?? null)))) {?>
                        <div class="acquisto-prezzo-tot">
                            <span class="prezzo-tot-label">Totale:</span>
                            <span class="prezzo-tot-value" id="prezzo-tot" data-unit="<?php if ($_smarty_tpl->getValue('sconto')) {
echo $_smarty_tpl->getValue('prezzo_scontato');
} else {
echo $_smarty_tpl->getValue('prezzo');
}?>">
                                €<?php if ($_smarty_tpl->getValue('sconto')) {
echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prezzo_scontato'),2);
} else {
echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prezzo'),2);
}?>
                            </span>
                        </div>
                    <?php }?>

                <?php }?>

                                <?php if ($_smarty_tpl->getValue('disponibilita') == 'disponibile') {?>
                    <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/carrello/aggiungi/<?php echo $_smarty_tpl->getValue('id');?>
"
                       class="button btn-add-cart-prodotto"
                       id="btn-add-cart"
                       data-id="<?php echo $_smarty_tpl->getValue('id');?>
"
                       aria-label="Aggiungi al carrello">
                        <i class="ti ti-shopping-cart"></i> Aggiungi al Carrello
                    </a>
                <?php } else { ?>
                    <button class="button btn-add-cart-prodotto is-disabled" disabled type="button">
                        <i class="ti ti-shopping-cart-off"></i> Non disponibile
                    </button>
                <?php }?>

                                <button class="btn-wishlist<?php if ((true && ($_smarty_tpl->hasVariable('isInWishlist') && null !== ($_smarty_tpl->getValue('isInWishlist') ?? null))) && $_smarty_tpl->getValue('isInWishlist')) {?> is-active<?php }?>" id="btn-wishlist" type="button"
                        data-id="<?php echo $_smarty_tpl->getValue('id');?>
"
                        aria-label="Aggiungi alla wishlist">
                    <i class="ti <?php if ((true && ($_smarty_tpl->hasVariable('isInWishlist') && null !== ($_smarty_tpl->getValue('isInWishlist') ?? null))) && $_smarty_tpl->getValue('isInWishlist')) {?>ti-heart-filled<?php } else { ?>ti-heart<?php }?>" id="wishlist-icon"></i> Wishlist
                </button>

            </div>

        </div>

                <div class="prodotto-details">

            <div class="prodotto-descrizione">
                <h2 class="prodotto-section-title">Descrizione</h2>
                <div class="prodotto-descrizione-testo">
                    <?php echo nl2br((string) (($tmp = $_smarty_tpl->getValue('descrizioneProdotto') ?? null)===null||$tmp==='' ? 'Descrizione non disponibile.' ?? null : $tmp), (bool) 1);?>

                </div>
            </div>

            <?php if ((true && ($_smarty_tpl->hasVariable('componenti') && null !== ($_smarty_tpl->getValue('componenti') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('componenti')) > 0) {?>
                <div class="prodotto-componenti">
                    <h2 class="prodotto-section-title">Componenti</h2>
                    <ul class="componenti-list">
                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('componenti'), 'comp');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('comp')->value) {
$foreach1DoElse = false;
?>
                            <li class="componenti-item">
                                <i class="ti ti-point"></i>
                                <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('comp'), ENT_QUOTES, 'UTF-8', true);?>

                            </li>
                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                    </ul>
                </div>
            <?php }?>

        </div>

                <?php if ((true && ($_smarty_tpl->hasVariable('correlati') && null !== ($_smarty_tpl->getValue('correlati') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('correlati')) > 0) {?>
            <section class="prodotto-correlati">
                <h2 class="prodotto-section-title">Forse ti può interessare...</h2>

                <div class="correlati-wrapper">
                    <div class="correlati-grid" id="correlati-grid">
                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('correlati'), 'correlato');
$foreach2DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('correlato')->value) {
$foreach2DoElse = false;
?>
                            <div class="correlato-card">
                                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/prodotto/<?php echo $_smarty_tpl->getValue('correlato')['id'];?>
" class="correlato-card-link">
                                    <div class="correlato-image-wrapper">
                                        <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/prodotti/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('correlato')['immagine'], ENT_QUOTES, 'UTF-8', true);?>
"
                                             alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('correlato')['nome'], ENT_QUOTES, 'UTF-8', true);?>
"
                                             class="correlato-image">
                                    </div>
                                    <div class="correlato-info">
                                        <h3 class="correlato-nome"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('correlato')['nome'], ENT_QUOTES, 'UTF-8', true);?>
</h3>
                                        <div class="correlato-rating">
                                            <?php $_smarty_tpl->assign('cMedia', $_smarty_tpl->getValue('correlato')['valutazione_media'], false, NULL);?>
                                            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, array(1,2,3,4,5), 's');
$foreach3DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('s')->value) {
$foreach3DoElse = false;
?>
                                                <?php if ($_smarty_tpl->getValue('s') <= $_smarty_tpl->getValue('cMedia')) {?>
                                                    <i class="ti ti-star-filled"></i>
                                                <?php } elseif (($_smarty_tpl->getValue('s')-$_smarty_tpl->getValue('cMedia')) < 1) {?>
                                                    <i class="ti ti-star-half-filled"></i>
                                                <?php } else { ?>
                                                    <i class="ti ti-star"></i>
                                                <?php }?>
                                            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                                        </div>
                                        <div class="correlato-prezzo">
                                            <?php if ((true && (true && null !== ($_smarty_tpl->getValue('correlato')['prezzo'] ?? null)))) {?>
                                                <span>€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('correlato')['prezzo'],2);?>
</span>
                                            <?php } else { ?>
                                                <span class="prezzo-nd">N/D</span>
                                            <?php }?>
                                        </div>
                                    </div>
                                </a>
                                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/carrello/aggiungi/<?php echo $_smarty_tpl->getValue('correlato')['id'];?>
"
                                   class="button btn-correlato-cart"
                                   aria-label="Aggiungi <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('correlato')['nome'], ENT_QUOTES, 'UTF-8', true);?>
 al carrello">
                                    <i class="ti ti-shopping-cart"></i> Carrello
                                </a>
                            </div>
                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                    </div>

                    <button class="correlati-nav correlati-next" id="correlati-next" type="button" aria-label="Vedi altri prodotti correlati">
                        <i class="ti ti-chevron-right"></i>
                    </button>
                </div>

            </section>
        <?php }?>

                <section class="prodotto-recensioni" id="recensioni">
            <h2 class="prodotto-section-title">Recensioni</h2>

            <?php if ((true && ($_smarty_tpl->hasVariable('utente') && null !== ($_smarty_tpl->getValue('utente') ?? null))) && $_smarty_tpl->getValue('utente')) {?>
                <?php if ((true && ($_smarty_tpl->hasVariable('userHasPurchased') && null !== ($_smarty_tpl->getValue('userHasPurchased') ?? null))) && $_smarty_tpl->getValue('userHasPurchased')) {?>
                    <div class="recensione-form-wrapper">
                        <button class="button btn-scrivi-recensione" id="btn-scrivi-recensione" type="button">
                            <i class="ti ti-pencil"></i> Scrivi la tua recensione
                        </button>

                        <div class="recensione-form" id="recensione-form" style="display:none;">
                                                        <form action="<?php echo $_smarty_tpl->getValue('base_url');?>
/recensioni/aggiungi" method="post">
                                <input type="hidden" name="id_prodotto" value="<?php echo $_smarty_tpl->getValue('id');?>
">

                                <div class="form-group">
                                    <label class="form-label">Valutazione</label>
                                    <div class="star-picker" id="star-picker" role="group" aria-label="Scegli valutazione">
                                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, array(1,2,3,4,5), 's');
$foreach4DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('s')->value) {
$foreach4DoElse = false;
?>
                                            <i class="ti ti-star star-pick<?php if ($_smarty_tpl->getValue('s') == 1) {?> is-selected<?php }?>" data-value="<?php echo $_smarty_tpl->getValue('s');?>
" aria-label="<?php echo $_smarty_tpl->getValue('s');?>
 stelle"></i>
                                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                                    </div>
                                    <button type="button" class="button-link btn-reset-voto" id="btn-reset-voto">
                                        Voto minimo (1 stella)
                                    </button>
                                    <input type="hidden" name="valutazione" id="rec-voto" value="1">
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="rec-testo">Testo</label>
                                    <textarea id="rec-testo"
                                              name="testo"
                                              class="textarea"
                                              placeholder="Scrivi la tua opinione..."
                                              rows="4"
                                              required></textarea>
                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="button btn-invia-recensione">
                                        <i class="ti ti-send"></i> Invia
                                    </button>
                                    <button type="button" class="button btn-annulla-recensione" id="btn-annulla-recensione">
                                        Annulla
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                <?php } else { ?>
                    <p class="recensione-login-hint">
                        <i class="ti ti-alert-circle"></i> Puoi lasciare una recensione solo dopo aver acquistato questo prodotto.
                    </p>
                <?php }?>
            <?php } else { ?>
                <p class="recensione-login-hint">
                    <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/accedi">Accedi</a> per lasciare una recensione.
                </p>
            <?php }?>

                        <?php if ((true && ($_smarty_tpl->hasVariable('recensioni') && null !== ($_smarty_tpl->getValue('recensioni') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('recensioni')) > 0) {?>
                <div class="recensioni-list">
                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('recensioni'), 'rec');
$foreach5DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('rec')->value) {
$foreach5DoElse = false;
?>
                        <div class="recensione-card">
                            <div class="recensione-header">
                                <span class="recensione-nickname">
                                    <i class="ti ti-user"></i>
                                    <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('rec')['utente'], ENT_QUOTES, 'UTF-8', true);?>

                                </span>
                                <div class="recensione-stars">
                                    <?php $_smarty_tpl->assign('voto', $_smarty_tpl->getValue('rec')['valutazione'], false, NULL);?>
                                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, array(1,2,3,4,5), 's');
$foreach6DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('s')->value) {
$foreach6DoElse = false;
?>
                                        <?php if ($_smarty_tpl->getValue('s') <= $_smarty_tpl->getValue('voto')) {?>
                                            <i class="ti ti-star-filled"></i>
                                        <?php } else { ?>
                                            <i class="ti ti-star"></i>
                                        <?php }?>
                                    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                                </div>
                            </div>
                            <p class="recensione-testo"><?php echo nl2br((string) htmlspecialchars((string)$_smarty_tpl->getValue('rec')['testo'], ENT_QUOTES, 'UTF-8', true), (bool) 1);?>
</p>

                            <?php if ((true && ($_smarty_tpl->hasVariable('utente') && null !== ($_smarty_tpl->getValue('utente') ?? null))) && $_smarty_tpl->getValue('utente')) {?>
                                <div class="recensione-azioni">
                                    <?php if ($_smarty_tpl->getValue('rec')['utente'] == $_smarty_tpl->getValue('utente')['name']) {?>
                                                                                <form action="<?php echo $_smarty_tpl->getValue('base_url');?>
/recensioni/elimina"
                                              method="post"
                                              class="form-elimina-recensione"
                                              data-confirm="Eliminare questa recensione?">
                                            <input type="hidden" name="id_recensione" value="<?php echo $_smarty_tpl->getValue('rec')['id'];?>
">
                                            <button type="submit" class="button-link btn-elimina-recensione">
                                                <i class="ti ti-trash"></i> Elimina
                                            </button>
                                        </form>
                                    <?php } elseif ((true && ($_smarty_tpl->hasVariable('motivazioni') && null !== ($_smarty_tpl->getValue('motivazioni') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('motivazioni')) > 0) {?>
                                        <button type="button"
                                                class="button-link btn-segnala-recensione"
                                                data-target="segnala-form-<?php echo $_smarty_tpl->getValue('rec')['id'];?>
">
                                            <i class="ti ti-flag"></i> Segnala
                                        </button>

                                        <div class="segnala-form" id="segnala-form-<?php echo $_smarty_tpl->getValue('rec')['id'];?>
" style="display:none;">
                                            <form action="<?php echo $_smarty_tpl->getValue('base_url');?>
/recensioni/segnala" method="post">
                                                <input type="hidden" name="id_recensione" value="<?php echo $_smarty_tpl->getValue('rec')['id'];?>
">
                                                <div class="form-group">
                                                    <label class="form-label" for="motivazione-<?php echo $_smarty_tpl->getValue('rec')['id'];?>
">Motivo della segnalazione</label>
                                                    <select id="motivazione-<?php echo $_smarty_tpl->getValue('rec')['id'];?>
" name="id_motivazione" class="input" required>
                                                        <option value="" disabled selected>Seleziona un motivo</option>
                                                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('motivazioni'), 'motivo');
$foreach7DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('motivo')->value) {
$foreach7DoElse = false;
?>
                                                            <option value="<?php echo $_smarty_tpl->getValue('motivo')['id'];?>
"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('motivo')['label'], ENT_QUOTES, 'UTF-8', true);?>
</option>
                                                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                                                    </select>
                                                </div>
                                                <div class="form-actions">
                                                    <button type="submit" class="button btn-invia-segnalazione">
                                                        <i class="ti ti-send"></i> Invia segnalazione
                                                    </button>
                                                    <button type="button"
                                                            class="button btn-annulla-segnalazione"
                                                            data-target="segnala-form-<?php echo $_smarty_tpl->getValue('rec')['id'];?>
">
                                                        Annulla
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    <?php }?>
                                </div>
                            <?php }?>
                        </div>
                    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                </div>
            <?php } else { ?>
                <p class="recensioni-empty">Nessuna recensione ancora. Sii il primo!</p>
            <?php }?>

        </section>

    </div>
</div>

<div class="minicart-modal" id="minicart-modal" aria-hidden="true">
    <div class="modal-background"></div>

    <div class="minicart-content">
        <button id="close-minicart" class="modal-close-btn" type="button" aria-label="Chiudi pop-up">&times;</button>

        <h3 class="minicart-success-title">Prodotto aggiunto al carrello!</h3>

        <div class="minicart-product">
            <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/prodotti/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('immagine'), ENT_QUOTES, 'UTF-8', true);?>
"
                 alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('nome'), ENT_QUOTES, 'UTF-8', true);?>
"
                 class="minicart-img">
            <div class="minicart-info">
                <p class="minicart-nome"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('nome'), ENT_QUOTES, 'UTF-8', true);?>
</p>
                <p class="minicart-prezzo">
                    <?php if ($_smarty_tpl->getValue('sconto')) {?>
                        €<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prezzo_scontato'),2);?>

                    <?php } elseif ((true && ($_smarty_tpl->hasVariable('prezzo') && null !== ($_smarty_tpl->getValue('prezzo') ?? null)))) {?>
                        €<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prezzo'),2);?>

                    <?php }?>
                </p>
            </div>
        </div>

        <div class="minicart-actions">
            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/catalogo" class="button btn-minicart-continua">
                <i class="ti ti-arrow-left"></i> Continua Shopping
            </a>
            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/carrello" class="button btn-minicart-ordine">
                <i class="ti ti-shopping-cart"></i> Completa Ordine
            </a>
        </div>
    </div>
</div>

<?php
}
}
/* {/block "content"} */
/* {block "extra_js"} */
class Block_20944370266a5b3c9c5ed131_97720803 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<?php echo '<script'; ?>
>
var utenteLoggato = <?php if ((true && ($_smarty_tpl->hasVariable('utente') && null !== ($_smarty_tpl->getValue('utente') ?? null)))) {?>true<?php } else { ?>false<?php }?>;
var wishlistInizialmenteAttiva = <?php if ((true && ($_smarty_tpl->hasVariable('isInWishlist') && null !== ($_smarty_tpl->getValue('isInWishlist') ?? null))) && $_smarty_tpl->getValue('isInWishlist')) {?>true<?php } else { ?>false<?php }?>;
var CARRELLO_AGGIUNGI_URL = "<?php echo $_smarty_tpl->getValue('base_url');?>
/carrello/aggiungi";
var WISHLIST_AGGIUNGI_URL = "<?php echo $_smarty_tpl->getValue('base_url');?>
/wishlist/aggiungi";
var WISHLIST_RIMUOVI_URL = "<?php echo $_smarty_tpl->getValue('base_url');?>
/wishlist/rimuovi";
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>

(function() {

    function richiedeLogin() {
        var modal = document.getElementById('login-modal-nav');
        if (modal) {
            modal.classList.add('is-active');
            modal.setAttribute('aria-hidden', 'false');
            var btn = document.getElementById('close-login-modal-nav');
            if (btn) btn.focus();
        }
    }

    // ── TOAST NOTIFICHE ──
    function mostraToast(messaggio, tipo) {
        var toast = document.createElement('div');
        toast.textContent = messaggio;
        toast.style.cssText = [
            'position:fixed', 'bottom:1.5rem', 'right:1.5rem',
            'padding:.75rem 1.25rem', 'border-radius:6px',
            'color:#fff', 'font-size:.9rem', 'z-index:9999',
            'box-shadow:0 2px 8px rgba(0,0,0,.25)',
            'background:' + (tipo === 'errore' ? '#c0392b' : '#27ae60')
        ].join(';');
        document.body.appendChild(toast);
        setTimeout(function() { toast.remove(); }, 4000);
    }

    // ── STEPPER QUANTITÀ + PREZZO TOTALE ──
    var qtyInput  = document.getElementById('qty-input');
    var prezzoTot = document.getElementById('prezzo-tot');

    function aggiornaPrezzo() {
        if (!prezzoTot || !qtyInput) return;
        var unit = parseFloat(prezzoTot.dataset.unit) || 0;
        var qty  = parseInt(qtyInput.value) || 1;
        prezzoTot.textContent = '€' + (unit * qty).toFixed(2);
    }

    var btnMinus = document.getElementById('qty-minus');
    if (btnMinus) {
        btnMinus.addEventListener('click', function(e) {
            e.preventDefault();
            if (!qtyInput) return;
            var val = parseInt(qtyInput.value) || 1;
            if (val > 1) { qtyInput.value = val - 1; aggiornaPrezzo(); }
        });
    }

    var btnPlus = document.getElementById('qty-plus');
    if (btnPlus) {
        btnPlus.addEventListener('click', function(e) {
            e.preventDefault();
            if (!qtyInput) return;
            qtyInput.value = (parseInt(qtyInput.value) || 1) + 1;
            aggiornaPrezzo();
        });
    }

    if (qtyInput) qtyInput.addEventListener('input', aggiornaPrezzo);

    // ── MODAL MINICART ──
    var modal   = document.getElementById('minicart-modal');
    var btnCart = document.getElementById('btn-add-cart');
    var idProdotto = btnCart ? btnCart.dataset.id : null;

    function apriMinicart() {
        if (!modal) return;
        modal.classList.add('is-active');
        modal.setAttribute('aria-hidden', 'false');
        var closeBtn = document.getElementById('close-minicart');
        if (closeBtn) closeBtn.focus();
    }

    function chiudiMinicart() {
        if (!modal) return;
        modal.classList.remove('is-active');
        modal.setAttribute('aria-hidden', 'true');
        if (btnCart) btnCart.focus();
    }

    function aggiungiAlCarrello(idProdotto, quantita, callback) {
        var controller = new AbortController();
        var timeout = setTimeout(function() { controller.abort(); }, 5000);

        fetch(CARRELLO_AGGIUNGI_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: 'id_prodotto=' + encodeURIComponent(idProdotto) + '&quantita=' + encodeURIComponent(quantita),
            signal: controller.signal
        })
        .then(function(res) {
            clearTimeout(timeout);
            if (res.status === 401) {
                richiedeLogin();
                throw new Error('auth');
            }
            if (!res.ok) throw new Error('server');
            return res.json();
        })
        .then(function(data) {
            if (data.success === false) {
                mostraToast(data.message || 'Errore nell\'aggiunta del prodotto.', 'errore');
                return;
            }
            apriMinicart();
            var cartBadge = document.getElementById('cart-count');
            if (cartBadge && data.cart_count !== undefined) {
                cartBadge.textContent = data.cart_count;
                cartBadge.style.display = data.cart_count > 0 ? 'inline' : 'none';
            }
            if (callback) callback(data);
        })
        .catch(function(err) {
            clearTimeout(timeout);
            if (err.message === 'auth') return; // già gestito sopra
            var msg = err.name === 'AbortError'
                ? 'Connessione lenta, prodotto non aggiunto.'
                : 'Errore nell\'aggiunta del prodotto.';
            mostraToast(msg, 'errore');
        });
    }

    if (btnCart) {
        btnCart.addEventListener('click', function(e) {
            e.preventDefault();
            if (!utenteLoggato) {
                richiedeLogin();
                return;
            }
            var qty = parseInt(qtyInput ? qtyInput.value : 1) || 1;
            aggiungiAlCarrello(idProdotto, qty);
        });
    }

    document.querySelectorAll('.btn-correlato-cart').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            if (!utenteLoggato) {
                richiedeLogin();
                return;
            }
            var hrefParts = this.getAttribute('href').split('/');
            var idCorrelato = hrefParts[hrefParts.length - 1];
            aggiungiAlCarrello(idCorrelato, 1);
        });
    });

    var closeMinicart = document.getElementById('close-minicart');
    if (closeMinicart) closeMinicart.addEventListener('click', function(e) { e.preventDefault(); chiudiMinicart(); });

    var modalBg = modal ? modal.querySelector('.modal-background') : null;
    if (modalBg) modalBg.addEventListener('click', chiudiMinicart);

    document.querySelectorAll('.minicart-actions a').forEach(function(btn) {
        btn.addEventListener('click', function(e) { e.stopPropagation(); });
    });

    // ── CAROSELLO CORRELATI ──
    var correlatiNext = document.getElementById('correlati-next');
    var correlatiGrid = document.getElementById('correlati-grid');

    if (correlatiNext && correlatiGrid) {
        correlatiNext.addEventListener('click', function() {
            var card = correlatiGrid.querySelector('.correlato-card');
            var scrollAmount = card ? card.offsetWidth + 20 : 280;
            var fineRaggiunta = correlatiGrid.scrollLeft + correlatiGrid.clientWidth >= correlatiGrid.scrollWidth - 5;
            if (fineRaggiunta) {
                correlatiGrid.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                correlatiGrid.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            }
        });
    }

    // ── TOGGLE FORM RECENSIONE ──
    var btnRecensione  = document.getElementById('btn-scrivi-recensione');
    var formRecensione = document.getElementById('recensione-form');

    if (btnRecensione && formRecensione) {
        btnRecensione.addEventListener('click', function(e) {
            e.preventDefault();
            formRecensione.style.display = formRecensione.style.display === 'block' ? 'none' : 'block';
        });
    }

    var btnAnnulla = document.getElementById('btn-annulla-recensione');
    if (btnAnnulla) {
        btnAnnulla.addEventListener('click', function(e) {
            e.preventDefault();
            if (formRecensione) formRecensione.style.display = 'none';
        });
    }

    // ── STAR PICKER RECENSIONE ──
    var stars     = document.querySelectorAll('.star-pick');
    var votoInput = document.getElementById('rec-voto');

    function aggiornaStelle(valore) {
        stars.forEach(function(s, i) {
            s.classList.toggle('ti-star-filled', i < valore);
            s.classList.toggle('ti-star',        i >= valore);
        });
    }

    stars.forEach(function(star) {
        star.addEventListener('mouseover', function() { aggiornaStelle(parseInt(this.dataset.value)); });
        star.addEventListener('click', function(e) {
            e.preventDefault();
            var val = parseInt(this.dataset.value);
            if (votoInput) votoInput.value = val;
            aggiornaStelle(val);
        });
    });

    var starPicker = document.getElementById('star-picker');
    if (starPicker) {
        starPicker.addEventListener('mouseleave', function() {
            aggiornaStelle(parseInt(votoInput ? votoInput.value : 1) || 1);
        });
    }

    var btnResetVoto = document.getElementById('btn-reset-voto');
    if (btnResetVoto) {
        btnResetVoto.addEventListener('click', function(e) {
            e.preventDefault();
            if (votoInput) votoInput.value = 1;
            aggiornaStelle(1);
        });
    }

    // ── TOGGLE FORM SEGNALAZIONE (delegato, ce n'è uno per recensione) ──
    document.querySelectorAll('.btn-segnala-recensione, .btn-annulla-segnalazione').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            var target = document.getElementById(this.dataset.target);
            if (!target) return;
            target.style.display = target.style.display === 'block' ? 'none' : 'block';
        });
    });

    // ── CONFERMA ELIMINAZIONE RECENSIONE ──
    document.querySelectorAll('.form-elimina-recensione').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            var msg = this.dataset.confirm || 'Confermi l\'eliminazione?';
            if (!window.confirm(msg)) {
                e.preventDefault();
            }
        });
    });

    // ── WISHLIST ──
    var btnWishlist  = document.getElementById('btn-wishlist');
    var wishlistIcon = document.getElementById('wishlist-icon');
    var idProdottoWishlist = btnWishlist ? btnWishlist.dataset.id : null;
    var inWishlist = wishlistInizialmenteAttiva;

    function impostaIconaWishlist(stato) {
        wishlistIcon.classList.toggle('ti-heart',        !stato);
        wishlistIcon.classList.toggle('ti-heart-filled',  stato);
        btnWishlist.classList.toggle('is-active',          stato);
    }

    if (btnWishlist) {
        btnWishlist.addEventListener('click', function() {
            if (!utenteLoggato) {
                richiedeLogin();
                return;
            }

            var statoPrecedente = inWishlist;
            var url = inWishlist ? WISHLIST_RIMUOVI_URL : WISHLIST_AGGIUNGI_URL;

            inWishlist = !inWishlist;
            impostaIconaWishlist(inWishlist);

            var controller = new AbortController();
            var timeout = setTimeout(function() { controller.abort(); }, 5000);

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'id_prodotto=' + encodeURIComponent(idProdottoWishlist),
                signal: controller.signal
            })
            .then(function(res) {
                clearTimeout(timeout);
                if (res.status === 401) {
                    richiedeLogin();
                    throw new Error('auth');
                }
                if (!res.ok) throw new Error('server');
                return res.json();
            })
            .then(function(data) {
                if (!data.success) {
                    inWishlist = statoPrecedente;
                    impostaIconaWishlist(inWishlist);
                    mostraToast(data.message || 'Errore nella wishlist.', 'errore');
                }
            })
            .catch(function(err) {
                clearTimeout(timeout);
                inWishlist = statoPrecedente;
                impostaIconaWishlist(inWishlist);
                if (err.message === 'auth') return; // già gestito sopra
                var msg = err.name === 'AbortError'
                    ? 'Connessione lenta, wishlist non aggiornata.'
                    : 'Errore nella wishlist.';
                mostraToast(msg, 'errore');
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
