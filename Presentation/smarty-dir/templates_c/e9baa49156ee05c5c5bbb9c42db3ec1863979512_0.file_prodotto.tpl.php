<?php
/* Smarty version 5.8.0, created on 2026-06-17 11:47:47
  from 'file:prodotto.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a326d43be3ec0_24173317',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e9baa49156ee05c5c5bbb9c42db3ec1863979512' => 
    array (
      0 => 'prodotto.tpl',
      1 => 1781689631,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a326d43be3ec0_24173317 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\damic\\Desktop\\uni\\APPUNTI\\anno3\\secondo_semenstre\\Pweb\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_6152510696a326d43b7fa36_34578929', "extra_css");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_6766265246a326d43b865e0_35557981', "content");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_13637606966a326d43be1de7_32505350', "extra_js");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "extra_css"} */
class Block_6152510696a326d43b7fa36_34578929 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\damic\\Desktop\\uni\\APPUNTI\\anno3\\secondo_semenstre\\Pweb\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

    <link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/css/prodotto.css">
<?php
}
}
/* {/block "extra_css"} */
/* {block "content"} */
class Block_6766265246a326d43b865e0_35557981 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\damic\\Desktop\\uni\\APPUNTI\\anno3\\secondo_semenstre\\Pweb\\TableCrown\\Presentation\\smarty-dir\\templates';
?>


<div class="prodotto-container">
    <div class="container">

                <nav class="prodotto-breadcrumb" aria-label="Breadcrumb">
            <ul class="breadcrumb-list">
                <li><a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/">Home</a></li>
                <li><a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/catalogo">Catalogo</a></li>
                <li class="is-active"><span><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')->getNomeProdotto(), ENT_QUOTES, 'UTF-8', true);?>
</span></li>
            </ul>
        </nav>

                <div class="prodotto-top">

                        <div class="prodotto-gallery">

                <div class="gallery-main-wrapper">
                    <button class="gallery-nav gallery-prev" id="gallery-prev" aria-label="Immagine precedente">
                        <i class="ti ti-chevron-left"></i>
                    </button>

                    <div class="gallery-main" id="gallery-main">
                        <?php $_smarty_tpl->assign('immagini', $_smarty_tpl->getValue('prodotto')->getImmagini(), false, NULL);?>
                        <?php if ((true && ($_smarty_tpl->hasVariable('immagini') && null !== ($_smarty_tpl->getValue('immagini') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('immagini')) > 0) {?>
                            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('immagini'), 'img', false, 'key');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('key')->value => $_smarty_tpl->getVariable('img')->value) {
$foreach0DoElse = false;
?>
                                <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/prodotti/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('img'), ENT_QUOTES, 'UTF-8', true);?>
"
                                     alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')->getNomeProdotto(), ENT_QUOTES, 'UTF-8', true);?>
 - immagine <?php echo $_smarty_tpl->getValue('key')+1;?>
"
                                     class="gallery-main-img<?php if ($_smarty_tpl->getValue('key') == 0) {?> is-active<?php }?>"
                                     data-index="<?php echo $_smarty_tpl->getValue('key');?>
">
                            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                        <?php } else { ?>
                            <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/prodotti/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')->getImgProdotto(), ENT_QUOTES, 'UTF-8', true);?>
"
                                 alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')->getNomeProdotto(), ENT_QUOTES, 'UTF-8', true);?>
"
                                 class="gallery-main-img is-active"
                                 data-index="0">
                        <?php }?>
                    </div>

                    <button class="gallery-nav gallery-next" id="gallery-next" aria-label="Immagine successiva">
                        <i class="ti ti-chevron-right"></i>
                    </button>
                </div>

                                <?php if ((true && ($_smarty_tpl->hasVariable('immagini') && null !== ($_smarty_tpl->getValue('immagini') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('immagini')) > 1) {?>
                    <div class="gallery-thumbs" id="gallery-thumbs">
                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('immagini'), 'img', false, 'key');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('key')->value => $_smarty_tpl->getVariable('img')->value) {
$foreach1DoElse = false;
?>
                            <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/prodotti/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('img'), ENT_QUOTES, 'UTF-8', true);?>
"
                                 alt="Thumbnail <?php echo $_smarty_tpl->getValue('key')+1;?>
"
                                 class="gallery-thumb<?php if ($_smarty_tpl->getValue('key') == 0) {?> is-active<?php }?>"
                                 data-index="<?php echo $_smarty_tpl->getValue('key');?>
">
                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                    </div>
                <?php }?>

            </div>

                        <div class="prodotto-info">

                                <?php if ($_smarty_tpl->getValue('prodotto')->getDisponibilitaProdotto() == 'esaurito') {?>
                    <span class="prodotto-badge prodotto-badge-esaurito">Esaurito</span>
                <?php } elseif ($_smarty_tpl->getValue('prodotto')->getDisponibilitaProdotto() == 'annunciato') {?>
                    <span class="prodotto-badge prodotto-badge-annunciato">Annunciato</span>
                <?php } elseif ($_smarty_tpl->getValue('prodotto')->getDisponibilitaProdotto() == 'Non disponibile') {?>
                    <span class="prodotto-badge prodotto-badge-non-disponibile">Non disponibile</span>
                <?php } elseif ($_smarty_tpl->getValue('prodotto')->getDisponibilitaProdotto() == 'In arrivo') {?>
                    <span class="prodotto-badge prodotto-badge-in-arrivo">In arrivo</span>
                <?php } else { ?>
                    <span class="prodotto-badge prodotto-badge-disponibile">Disponibile</span>
                <?php }?>

                <h1 class="prodotto-nome"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')->getNomeProdotto(), ENT_QUOTES, 'UTF-8', true);?>
</h1>

                                <div class="prodotto-rating">
                    <?php $_smarty_tpl->assign('media', $_smarty_tpl->getValue('prodotto')->getValutazioneMedia(), false, NULL);?>
                    <?php $_smarty_tpl->assign('stelle', array(1,2,3,4,5), false, NULL);?>
                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('stelle'), 's');
$foreach2DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('s')->value) {
$foreach2DoElse = false;
?>
                        <?php if ($_smarty_tpl->getValue('s') <= $_smarty_tpl->getValue('media')) {?>
                            <i class="ti ti-star-filled"></i>
                        <?php } elseif (($_smarty_tpl->getValue('s')-$_smarty_tpl->getValue('media')) < 1) {?>
                            <i class="ti ti-star-half-filled"></i>
                        <?php } else { ?>
                            <i class="ti ti-star"></i>
                        <?php }?>
                    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                    <span class="prodotto-rating-value">(<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('media'),1);?>
)</span>
                    <a href="#recensioni" class="prodotto-rating-link">Leggi Recensioni</a>
                </div>

                                <div class="prodotto-meta">
                    <?php if ($_smarty_tpl->getValue('prodotto')->getGiocatoriMin() && $_smarty_tpl->getValue('prodotto')->getGiocatoriMax()) {?>
                        <span class="prodotto-meta-item">
                            <i class="ti ti-users"></i>
                            <?php echo $_smarty_tpl->getValue('prodotto')->getGiocatoriMin();?>
–<?php echo $_smarty_tpl->getValue('prodotto')->getGiocatoriMax();?>
 giocatori
                        </span>
                    <?php }?>
                    <?php if ($_smarty_tpl->getValue('prodotto')->getEtaMin()) {?>
                        <span class="prodotto-meta-item">
                            <i class="ti ti-baby-carriage"></i>
                            <?php echo $_smarty_tpl->getValue('prodotto')->getEtaMin();?>
+ anni
                        </span>
                    <?php }?>
                    <?php if ($_smarty_tpl->getValue('prodotto')->getDurata()) {?>
                        <span class="prodotto-meta-item">
                            <i class="ti ti-clock"></i>
                            <?php echo $_smarty_tpl->getValue('prodotto')->getDurata();?>
 min
                        </span>
                    <?php }?>
                    <?php if ($_smarty_tpl->getValue('prodotto')->getDifficolta()) {?>
                        <span class="prodotto-meta-item">
                            <i class="ti ti-flame"></i>
                            <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')->getDifficolta(), ENT_QUOTES, 'UTF-8', true);?>

                        </span>
                    <?php }?>
                    <?php if ($_smarty_tpl->getValue('prodotto')->getLingua()) {?>
                        <span class="prodotto-meta-item">
                            <i class="ti ti-language"></i>
                            <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')->getLingua(), ENT_QUOTES, 'UTF-8', true);?>

                        </span>
                    <?php }?>
                </div>

                                <div class="prodotto-prezzo-wrapper">
                    <?php $_smarty_tpl->assign('prezzo', $_smarty_tpl->getValue('prodotto')->getPrezzo(), false, NULL);?>
                    <?php if ((true && ($_smarty_tpl->hasVariable('prezzo') && null !== ($_smarty_tpl->getValue('prezzo') ?? null)))) {?>
                        <?php if ($_smarty_tpl->getValue('prezzo')->hasSconto()) {?>
                            <span class="prodotto-prezzo">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prezzo')->calcolaPrezzoScontato(),2);?>
</span>
                            <span class="prodotto-prezzo-old">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prezzo')->getValore(),2);?>
</span>
                            <span class="prodotto-badge-sconto">-<?php echo $_smarty_tpl->getValue('prezzo')->getSconto();?>
%</span>
                        <?php } else { ?>
                            <span class="prodotto-prezzo">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prezzo')->getValore(),2);?>
</span>
                        <?php }?>
                    <?php } else { ?>
                        <span class="prodotto-prezzo-nd">Prezzo N/D</span>
                    <?php }?>
                </div>

            </div>

                        <div class="prodotto-acquisto-box">

                                <div class="acquisto-disponibilita">
                    <?php if ($_smarty_tpl->getValue('prodotto')->getDisponibilitaProdotto() == 'disponibile') {?>
                        <i class="ti ti-circle-check"></i>
                        <span>Disponibile</span>
                    <?php } elseif ($_smarty_tpl->getValue('prodotto')->getDisponibilitaProdotto() == 'esaurito') {?>
                        <i class="ti ti-circle-x"></i>
                        <span>Esaurito</span>
                    <?php } elseif ($_smarty_tpl->getValue('prodotto')->getDisponibilitaProdotto() == 'Non disponibile') {?>
                        <i class="ti ti-circle-x"></i>
                        <span>Non disponibile</span>
                    <?php } elseif ($_smarty_tpl->getValue('prodotto')->getDisponibilitaProdotto() == 'In arrivo') {?>
                        <i class="ti ti-clock"></i>
                        <span>In arrivo</span>
                    <?php } else { ?>
                        <i class="ti ti-clock"></i>
                        <span>Annunciato</span>
                    <?php }?>
                </div>

                                <div class="acquisto-quantita">
                    <label class="acquisto-quantita-label" for="qty-input">Quantità:</label>
                    <div class="quantita-stepper">
                        <button class="button quantita-btn" id="qty-minus" aria-label="Diminuisci quantità">
                            <i class="ti ti-minus"></i>
                        </button>
                        <input type="number"
                               id="qty-input"
                               class="input quantita-input"
                               value="1"
                               min="1"
                               max="99"
                               aria-label="Quantità">
                        <button class="button quantita-btn" id="qty-plus" aria-label="Aumenta quantità">
                            <i class="ti ti-plus"></i>
                        </button>
                    </div>
                </div>

                                <div class="acquisto-prezzo-tot">
                    <?php if ((true && ($_smarty_tpl->hasVariable('prezzo') && null !== ($_smarty_tpl->getValue('prezzo') ?? null)))) {?>
                        <?php if ($_smarty_tpl->getValue('prezzo')->hasSconto()) {?>
                            <span class="prezzo-tot-label">Totale:</span>
                            <span class="prezzo-tot-value" id="prezzo-tot" data-unit="<?php echo $_smarty_tpl->getValue('prezzo')->calcolaPrezzoScontato();?>
">
                                €<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prezzo')->calcolaPrezzoScontato(),2);?>

                            </span>
                        <?php } else { ?>
                            <span class="prezzo-tot-label">Totale:</span>
                            <span class="prezzo-tot-value" id="prezzo-tot" data-unit="<?php echo $_smarty_tpl->getValue('prezzo')->getValore();?>
">
                                €<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prezzo')->getValore(),2);?>

                            </span>
                        <?php }?>
                    <?php }?>
                </div>

                                <?php if ($_smarty_tpl->getValue('prodotto')->getDisponibilitaProdotto() != 'esaurito') {?>
                    <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/carrello/aggiungi/<?php echo $_smarty_tpl->getValue('prodotto')->getIdProdotto();?>
"
                       class="button btn-add-cart-prodotto"
                       id="btn-add-cart"
                       aria-label="Aggiungi al carrello">
                        <i class="ti ti-shopping-cart"></i> Aggiungi al Carrello
                    </a>
                <?php } else { ?>
                    <button class="button btn-add-cart-prodotto is-disabled" disabled>
                        <i class="ti ti-shopping-cart-off"></i> Non disponibile
                    </button>
                <?php }?>

                                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/wishlist/aggiungi/<?php echo $_smarty_tpl->getValue('prodotto')->getIdProdotto();?>
"
                   class="btn-wishlist"
                   aria-label="Aggiungi alla wishlist">
                    <i class="ti ti-heart"></i> Wishlist
                </a>

            </div>

        </div>

                <div class="prodotto-details">

            <div class="prodotto-descrizione">
                <h2 class="prodotto-section-title">Descrizione</h2>
                <div class="prodotto-descrizione-testo">
                    <?php echo nl2br((string) (($tmp = $_smarty_tpl->getValue('prodotto')->getDescrizione() ?? null)===null||$tmp==='' ? 'Descrizione non disponibile.' ?? null : $tmp), (bool) 1);?>

                </div>
            </div>

            <?php if ($_smarty_tpl->getValue('prodotto')->getComponenti()) {?>
                <div class="prodotto-componenti">
                    <h2 class="prodotto-section-title">Componenti</h2>
                    <ul class="componenti-list">
                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('prodotto')->getComponenti(), 'comp');
$foreach3DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('comp')->value) {
$foreach3DoElse = false;
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
$foreach4DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('correlato')->value) {
$foreach4DoElse = false;
?>
                            <div class="correlato-card">
                                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/prodotto/<?php echo $_smarty_tpl->getValue('correlato')->getIdProdotto();?>
" class="correlato-card-link">
                                    <div class="correlato-image-wrapper">
                                        <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/prodotti/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('correlato')->getImgProdotto(), ENT_QUOTES, 'UTF-8', true);?>
"
                                             alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('correlato')->getNomeProdotto(), ENT_QUOTES, 'UTF-8', true);?>
"
                                             class="correlato-image">
                                    </div>
                                    <div class="correlato-info">
                                        <h3 class="correlato-nome"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('correlato')->getNomeProdotto(), ENT_QUOTES, 'UTF-8', true);?>
</h3>
                                        <div class="correlato-rating">
                                            <?php $_smarty_tpl->assign('cMedia', $_smarty_tpl->getValue('correlato')->getValutazioneMedia(), false, NULL);?>
                                            <?php $_smarty_tpl->assign('stelle', array(1,2,3,4,5), false, NULL);?>
                                            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('stelle'), 's');
$foreach5DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('s')->value) {
$foreach5DoElse = false;
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
                                            <?php $_smarty_tpl->assign('cPrezzo', $_smarty_tpl->getValue('correlato')->getPrezzo(), false, NULL);?>
                                            <?php if ((true && ($_smarty_tpl->hasVariable('cPrezzo') && null !== ($_smarty_tpl->getValue('cPrezzo') ?? null)))) {?>
                                                <?php if ($_smarty_tpl->getValue('cPrezzo')->hasSconto()) {?>
                                                    <span class="correlato-prezzo-scontato">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('cPrezzo')->calcolaPrezzoScontato(),2);?>
</span>
                                                    <span class="correlato-prezzo-old">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('cPrezzo')->getValore(),2);?>
</span>
                                                <?php } else { ?>
                                                    <span>€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('cPrezzo')->getValore(),2);?>
</span>
                                                <?php }?>
                                            <?php } else { ?>
                                                <span class="prezzo-nd">N/D</span>
                                            <?php }?>
                                        </div>
                                    </div>
                                </a>
                                <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/carrello/aggiungi/<?php echo $_smarty_tpl->getValue('correlato')->getIdProdotto();?>
"
                                   class="button btn-correlato-cart"
                                   aria-label="Aggiungi <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('correlato')->getNomeProdotto(), ENT_QUOTES, 'UTF-8', true);?>
 al carrello">
                                    <i class="ti ti-shopping-cart"></i> Carrello
                                </a>
                            </div>
                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                    </div>

                    <button class="correlati-nav correlati-next" id="correlati-next" aria-label="Vedi altri prodotti correlati">
                        <i class="ti ti-chevron-right"></i>
                    </button>
                </div>

            </section>
        <?php }?>

                <section class="prodotto-recensioni" id="recensioni">
            <h2 class="prodotto-section-title">Recensioni</h2>

                        <?php if ((true && ($_smarty_tpl->hasVariable('utente') && null !== ($_smarty_tpl->getValue('utente') ?? null))) && $_smarty_tpl->getValue('utente')) {?>
                <div class="recensione-form-wrapper">
                    <button class="button btn-scrivi-recensione" id="btn-scrivi-recensione">
                        <i class="ti ti-pencil"></i> Scrivi la tua recensione
                    </button>

                    <div class="recensione-form" id="recensione-form" style="display:none;">
                        <form action="<?php echo $_smarty_tpl->getValue('base_url');?>
/recensione/aggiungi/<?php echo $_smarty_tpl->getValue('prodotto')->getIdProdotto();?>
" method="post">

                            <div class="form-group">
                                <label class="form-label" for="rec-titolo">Titolo</label>
                                <input type="text"
                                       id="rec-titolo"
                                       name="titolo"
                                       class="input"
                                       placeholder="Titolo della recensione"
                                       required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Valutazione</label>
                                <div class="star-picker" id="star-picker" role="group" aria-label="Scegli valutazione">
                                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, array(1,2,3,4,5), 's');
$foreach6DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('s')->value) {
$foreach6DoElse = false;
?>
                                        <i class="ti ti-star star-pick" data-value="<?php echo $_smarty_tpl->getValue('s');?>
" aria-label="<?php echo $_smarty_tpl->getValue('s');?>
 stelle"></i>
                                    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                                </div>
                                <input type="hidden" name="voto" id="rec-voto" value="0">
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
                    <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/login">Accedi</a> per lasciare una recensione.
                </p>
            <?php }?>

                        <?php if ((true && ($_smarty_tpl->hasVariable('recensioni') && null !== ($_smarty_tpl->getValue('recensioni') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('recensioni')) > 0) {?>
                <div class="recensioni-list">
                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('recensioni'), 'rec');
$foreach7DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('rec')->value) {
$foreach7DoElse = false;
?>
                        <div class="recensione-card">
                            <div class="recensione-header">
                                <span class="recensione-nickname">
                                    <i class="ti ti-user"></i>
                                    <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('rec')->getNicknameUtente(), ENT_QUOTES, 'UTF-8', true);?>

                                </span>
                                <div class="recensione-stars">
                                    <?php $_smarty_tpl->assign('voto', $_smarty_tpl->getValue('rec')->getVoto(), false, NULL);?>
                                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, array(1,2,3,4,5), 's');
$foreach8DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('s')->value) {
$foreach8DoElse = false;
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
                            <p class="recensione-titolo"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('rec')->getTitolo(), ENT_QUOTES, 'UTF-8', true);?>
</p>
                            <p class="recensione-testo"><?php echo nl2br((string) htmlspecialchars((string)$_smarty_tpl->getValue('rec')->getTesto(), ENT_QUOTES, 'UTF-8', true), (bool) 1);?>
</p>
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
    
    <div class="minicart-content" style="position: relative;">
        
        <button id="close-minicart" class="modal-close-btn" aria-label="Chiudi pop-up">&times;</button>
        
        <h3 class="minicart-success-title">Prodotto aggiunto al carrello!</h3>

        <div class="minicart-product">
            <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/prodotti/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')->getImgProdotto(), ENT_QUOTES, 'UTF-8', true);?>
"
                 alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')->getNomeProdotto(), ENT_QUOTES, 'UTF-8', true);?>
"
                 class="minicart-img">
            <div class="minicart-info">
                <p class="minicart-nome"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')->getNomeProdotto(), ENT_QUOTES, 'UTF-8', true);?>
</p>
                <p class="minicart-prezzo">
                    <?php if ((true && ($_smarty_tpl->hasVariable('prezzo') && null !== ($_smarty_tpl->getValue('prezzo') ?? null)))) {?>
                        <?php if ($_smarty_tpl->getValue('prezzo')->hasSconto()) {?>
                            €<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prezzo')->calcolaPrezzoScontato(),2);?>

                        <?php } else { ?>
                            €<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prezzo')->getValore(),2);?>

                        <?php }?>
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
class Block_13637606966a326d43be1de7_32505350 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\damic\\Desktop\\uni\\APPUNTI\\anno3\\secondo_semenstre\\Pweb\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<?php echo '<script'; ?>
>
document.addEventListener('DOMContentLoaded', function () {

    // ── GALLERIA IMMAGINI ──
    const imgs = document.querySelectorAll('.gallery-main-img');
    const thumbs = document.querySelectorAll('.gallery-thumb');
    let currentImg = 0;

    function showImg(index) {
        imgs.forEach(i => i.classList.remove('is-active'));
        thumbs.forEach(t => t.classList.remove('is-active'));
        currentImg = (index + imgs.length) % imgs.length;
        if (imgs[currentImg]) imgs[currentImg].classList.add('is-active');
        if (thumbs[currentImg]) thumbs[currentImg].classList.add('is-active');
    }

    document.getElementById('gallery-prev')?.addEventListener('click', () => showImg(currentImg - 1));
    document.getElementById('gallery-next')?.addEventListener('click', () => showImg(currentImg + 1));

    thumbs.forEach(thumb => {
        thumb.addEventListener('click', function () {
            showImg(parseInt(this.dataset.index));
        });
    });

    // ── STEPPER QUANTITÀ + PREZZO TOTALE ──
    const qtyInput = document.getElementById('qty-input');
    const prezzoTot = document.getElementById('prezzo-tot');

    function aggiornaPrezzo() {
        if (!prezzoTot) return;
        const unit = parseFloat(prezzoTot.dataset.unit) || 0;
        const qty = parseInt(qtyInput.value) || 1;
        prezzoTot.textContent = '€' + (unit * qty).toFixed(2);
    }

    document.getElementById('qty-minus')?.addEventListener('click', function () {
        if (parseInt(qtyInput.value) > 1) {
            qtyInput.value = parseInt(qtyInput.value) - 1;
            aggiornaPrezzo();
        }
    });

    document.getElementById('qty-plus')?.addEventListener('click', function () {
        qtyInput.value = parseInt(qtyInput.value) + 1;
        aggiornaPrezzo();
    });

    qtyInput?.addEventListener('input', aggiornaPrezzo);

   
    // ── AGGIORNA HREF CARRELLO CON QUANTITÀ (Gestione AJAX + Modal) ──
    const btnCart = document.getElementById('btn-add-cart');
    if (btnCart && qtyInput) {
        // Salviamo l'URL di base iniziale del link così com'è
        const baseHref = btnCart.getAttribute('href');
        
        // Funzione pulita per aggiornare l'URL del pulsante aggiungi al carrello
        const aggiornaUrlCarrello = () => {
            const qty = parseInt(qtyInput.value) || 1;
            btnCart.setAttribute('href', baseHref + '?qty=' + qty);
        };

        // Ascolta l'input manuale nella casella di testo
        qtyInput.addEventListener('input', aggiornaUrlCarrello);
        
        // FIX: Ascolta anche i click sui pulsanti più e meno per aggiornare l'URL al volo!
        document.getElementById('qty-minus')?.addEventListener('click', aggiornaUrlCarrello);
        document.getElementById('qty-plus')?.addEventListener('click', aggiornaUrlCarrello);

        // ── INTERCETTAZIONE CLICK E APERTURA POP-UP ──
        btnCart.addEventListener('click', function (e) {
            e.preventDefault(); // Blocca IMMEDIATAMENTE il cambio pagina del browser

            const targetUrl = this.getAttribute('href');
            const modal = document.getElementById('minicart-modal');

            // 1. Mostriamo il pop-up SUBITO. L'utente lo vede all'istante del click.
            if (modal) {
                modal.classList.add('is-active');
                modal.setAttribute('aria-hidden', 'false');
            }

            // 2. Inviamo la richiesta al server in background (AJAX)
            // Il controller PHP aggiungerà il prodotto alla sessione normalmente.
            fetch(targetUrl)
            .then(response => {
                if (!response.ok) {
                    console.error("Il server ha risposto con un errore, ma il prodotto potrebbe essere stato aggiunto.");
                }
            })
            .catch(error => {
                // Anche se la fetch va in errore (es. per i redirect su localhost), 
                // la pagina non salta e il pop-up resta visibile a schermo!
                console.warn("Fetch intercettata in background (tranquillo, il pop-up resta attivo):", error);
            });
        });
    }

    // ── TOGGLE FORM RECENSIONE ──
    document.getElementById('btn-scrivi-recensione')?.addEventListener('click', function () {
        const form = document.getElementById('recensione-form');
        if (form) form.style.display = form.style.display === 'none' ? 'block' : 'none';
    });

    document.getElementById('btn-annulla-recensione')?.addEventListener('click', function () {
        document.getElementById('recensione-form').style.display = 'none';
    });

    // ── STAR PICKER RECENSIONE ──
    const stars = document.querySelectorAll('.star-pick');
    const votoInput = document.getElementById('rec-voto');

    stars.forEach(star => {
        star.addEventListener('mouseover', function () {
            const val = parseInt(this.dataset.value);
            stars.forEach((s, i) => {
                s.classList.toggle('ti-star-filled', i < val);
                s.classList.toggle('ti-star', i >= val);
            });
        });

        star.addEventListener('click', function () {
            const val = parseInt(this.dataset.value);
            if (votoInput) votoInput.value = val;
        });
    });

    document.getElementById('star-picker')?.addEventListener('mouseleave', function () {
        const val = parseInt(votoInput?.value) || 0;
        stars.forEach((s, i) => {
            s.classList.toggle('ti-star-filled', i < val);
            s.classList.toggle('ti-star', i >= val);
        });
    });

    // ── GESTIONE CHIUSURA POP-UP CON LA X ──
    const btnClose = document.getElementById('close-minicart');
    const modal = document.getElementById('minicart-modal');

    if (btnClose && modal) {
        btnClose.addEventListener('click', function() {
            modal.classList.remove('is-active');
            modal.setAttribute('aria-hidden', 'true');
        });
    }

    // ── CHIUSURA POP-UP SULLO SFONDO SCURO ESTERNO ──
    const modalBg = document.querySelector('#minicart-modal .modal-background');
    if (modalBg && modal) {
        modalBg.addEventListener('click', function() {
            modal.classList.remove('is-active');
            modal.setAttribute('aria-hidden', 'true');
        });
    }
});
<?php echo '</script'; ?>
>
<?php
}
}
/* {/block "extra_js"} */
}
