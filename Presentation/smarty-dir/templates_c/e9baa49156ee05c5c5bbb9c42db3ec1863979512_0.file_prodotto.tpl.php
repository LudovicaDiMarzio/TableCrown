<?php
/* Smarty version 5.8.0, created on 2026-06-28 16:34:32
  from 'file:prodotto.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a4130f86bf6b3_93217838',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e9baa49156ee05c5c5bbb9c42db3ec1863979512' => 
    array (
      0 => 'prodotto.tpl',
      1 => 1782657267,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a4130f86bf6b3_93217838 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\damic\\Desktop\\uni\\APPUNTI\\anno3\\secondo_semenstre\\Pweb\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_15525048486a4130f8278dc0_42543969', "extra_css");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_2000824316a4130f82fe754_75558534', "content");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_11952616246a4130f86bd946_23466534', "extra_js");
?>

<?php $_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "extra_css"} */
class Block_15525048486a4130f8278dc0_42543969 extends \Smarty\Runtime\Block
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
class Block_2000824316a4130f82fe754_75558534 extends \Smarty\Runtime\Block
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
                <li class="is-active"><span><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['nome'], ENT_QUOTES, 'UTF-8', true);?>
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
                        <?php if ((true && (true && null !== ($_smarty_tpl->getValue('prodotto')['immagini'] ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('prodotto')['immagini']) > 0) {?>
                            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('prodotto')['immagini'], 'img', false, 'key');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('key')->value => $_smarty_tpl->getVariable('img')->value) {
$foreach0DoElse = false;
?>
                                <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/prodotti/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('img'), ENT_QUOTES, 'UTF-8', true);?>
"
                                     alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['nome'], ENT_QUOTES, 'UTF-8', true);?>
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
/img/prodotti/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['immagine'], ENT_QUOTES, 'UTF-8', true);?>
"
                                 alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['nome'], ENT_QUOTES, 'UTF-8', true);?>
"
                                 class="gallery-main-img is-active"
                                 data-index="0">
                        <?php }?>
                    </div>

                    <button class="gallery-nav gallery-next" id="gallery-next" aria-label="Immagine successiva">
                        <i class="ti ti-chevron-right"></i>
                    </button>
                </div>

                                <?php if ((true && (true && null !== ($_smarty_tpl->getValue('prodotto')['immagini'] ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('prodotto')['immagini']) > 1) {?>
                    <div class="gallery-thumbs" id="gallery-thumbs">
                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('prodotto')['immagini'], 'img', false, 'key');
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

                                <?php if ($_smarty_tpl->getValue('prodotto')['disponibilita'] == 'esaurito') {?>
                    <span class="prodotto-badge prodotto-badge-esaurito">Esaurito</span>
                <?php } elseif ($_smarty_tpl->getValue('prodotto')['disponibilita'] == 'annunciato') {?>
                    <span class="prodotto-badge prodotto-badge-annunciato">Annunciato</span>
                <?php } elseif ($_smarty_tpl->getValue('prodotto')['disponibilita'] == 'non disponibile') {?>
                    <span class="prodotto-badge prodotto-badge-non-disponibile">Non disponibile</span>
                <?php } elseif ($_smarty_tpl->getValue('prodotto')['disponibilita'] == 'in arrivo') {?>
                    <span class="prodotto-badge prodotto-badge-in-arrivo">In arrivo</span>
                <?php } else { ?>
                    <span class="prodotto-badge prodotto-badge-disponibile">Disponibile</span>
                <?php }?>

                <h1 class="prodotto-nome"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['nome'], ENT_QUOTES, 'UTF-8', true);?>
</h1>

                                <div class="prodotto-rating">
                    <?php $_smarty_tpl->assign('media', $_smarty_tpl->getValue('prodotto')['valutazione_media'], false, NULL);?>
                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, array(1,2,3,4,5), 's');
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
                    <?php if ((true && (true && null !== ($_smarty_tpl->getValue('prodotto')['giocatori_min'] ?? null))) && (true && (true && null !== ($_smarty_tpl->getValue('prodotto')['giocatori_max'] ?? null)))) {?>
                        <span class="prodotto-meta-item">
                            <i class="ti ti-users"></i>
                            <?php echo $_smarty_tpl->getValue('prodotto')['giocatori_min'];?>
–<?php echo $_smarty_tpl->getValue('prodotto')['giocatori_max'];?>
 giocatori
                        </span>
                    <?php }?>
                    <?php if ((true && (true && null !== ($_smarty_tpl->getValue('prodotto')['eta_min'] ?? null)))) {?>
                        <span class="prodotto-meta-item">
                            <i class="ti ti-baby-carriage"></i>
                            <?php echo $_smarty_tpl->getValue('prodotto')['eta_min'];?>
+ anni
                        </span>
                    <?php }?>
                    <?php if ((true && (true && null !== ($_smarty_tpl->getValue('prodotto')['durata'] ?? null)))) {?>
                        <span class="prodotto-meta-item">
                            <i class="ti ti-clock"></i>
                            <?php echo $_smarty_tpl->getValue('prodotto')['durata'];?>
 min
                        </span>
                    <?php }?>
                    <?php if ((true && (true && null !== ($_smarty_tpl->getValue('prodotto')['difficolta'] ?? null)))) {?>
                        <span class="prodotto-meta-item">
                            <i class="ti ti-flame"></i>
                            <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['difficolta'], ENT_QUOTES, 'UTF-8', true);?>

                        </span>
                    <?php }?>
                    <?php if ((true && (true && null !== ($_smarty_tpl->getValue('prodotto')['lingua'] ?? null)))) {?>
                        <span class="prodotto-meta-item">
                            <i class="ti ti-language"></i>
                            <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['lingua'], ENT_QUOTES, 'UTF-8', true);?>

                        </span>
                    <?php }?>
                </div>

                                <div class="prodotto-prezzo-wrapper">
                    <?php if ($_smarty_tpl->getValue('prodotto')['sconto']) {?>
                        <span class="prodotto-prezzo">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prodotto')['prezzo_scontato'],2);?>
</span>
                        <span class="prodotto-prezzo-old">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prodotto')['prezzo'],2);?>
</span>
                        <span class="prodotto-badge-sconto">-<?php echo $_smarty_tpl->getValue('prodotto')['percentuale_sconto'];?>
%</span>
                    <?php } elseif ((true && (true && null !== ($_smarty_tpl->getValue('prodotto')['prezzo'] ?? null)))) {?>
                        <span class="prodotto-prezzo">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prodotto')['prezzo'],2);?>
</span>
                    <?php } else { ?>
                        <span class="prodotto-prezzo-nd">Prezzo N/D</span>
                    <?php }?>
                </div>

            </div>

                        <div class="prodotto-acquisto-box">

                                <div class="acquisto-disponibilita">
                    <?php if ($_smarty_tpl->getValue('prodotto')['disponibilita'] == 'disponibile') {?>
                        <i class="ti ti-circle-check"></i>
                        <span>Disponibile</span>
                    <?php } elseif ($_smarty_tpl->getValue('prodotto')['disponibilita'] == 'esaurito') {?>
                        <i class="ti ti-circle-x"></i>
                        <span>Esaurito</span>
                    <?php } elseif ($_smarty_tpl->getValue('prodotto')['disponibilita'] == 'non disponibile') {?>
                        <i class="ti ti-circle-x"></i>
                        <span>Non disponibile</span>
                    <?php } elseif ($_smarty_tpl->getValue('prodotto')['disponibilita'] == 'in arrivo') {?>
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

                                <div class="acquisto-prezzo-tot">
                    <?php if ($_smarty_tpl->getValue('prodotto')['sconto']) {?>
                        <span class="prezzo-tot-label">Totale:</span>
                        <span class="prezzo-tot-value" id="prezzo-tot" data-unit="<?php echo $_smarty_tpl->getValue('prodotto')['prezzo_scontato'];?>
">
                            €<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prodotto')['prezzo_scontato'],2);?>

                        </span>
                    <?php } elseif ((true && (true && null !== ($_smarty_tpl->getValue('prodotto')['prezzo'] ?? null)))) {?>
                        <span class="prezzo-tot-label">Totale:</span>
                        <span class="prezzo-tot-value" id="prezzo-tot" data-unit="<?php echo $_smarty_tpl->getValue('prodotto')['prezzo'];?>
">
                            €<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prodotto')['prezzo'],2);?>

                        </span>
                    <?php }?>
                </div>

                                <?php if ($_smarty_tpl->getValue('prodotto')['disponibilita'] != 'esaurito') {?>
                    <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/carrello/aggiungi/<?php echo $_smarty_tpl->getValue('prodotto')['id'];?>
"
                       class="button btn-add-cart-prodotto"
                       id="btn-add-cart"
                       data-id="<?php echo $_smarty_tpl->getValue('prodotto')['id'];?>
"
                       aria-label="Aggiungi al carrello">
                        <i class="ti ti-shopping-cart"></i> Aggiungi al Carrello
                    </a>
                <?php } else { ?>
                    <button class="button btn-add-cart-prodotto is-disabled" disabled type="button">
                        <i class="ti ti-shopping-cart-off"></i> Non disponibile
                    </button>
                <?php }?>

                                <button class="btn-wishlist" id="btn-wishlist" type="button"
                        data-url="<?php echo $_smarty_tpl->getValue('base_url');?>
/wishlist/aggiungi/<?php echo $_smarty_tpl->getValue('prodotto')['id'];?>
"
                        aria-label="Aggiungi alla wishlist">
                    <i class="ti ti-heart" id="wishlist-icon"></i> Wishlist
                </button>

            </div>

        </div>

                <div class="prodotto-details">

            <div class="prodotto-descrizione">
                <h2 class="prodotto-section-title">Descrizione</h2>
                <div class="prodotto-descrizione-testo">
                    <?php echo nl2br((string) (($tmp = $_smarty_tpl->getValue('prodotto')['descrizione'] ?? null)===null||$tmp==='' ? 'Descrizione non disponibile.' ?? null : $tmp), (bool) 1);?>

                </div>
            </div>

            <?php if ((true && (true && null !== ($_smarty_tpl->getValue('prodotto')['componenti'] ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('prodotto')['componenti']) > 0) {?>
                <div class="prodotto-componenti">
                    <h2 class="prodotto-section-title">Componenti</h2>
                    <ul class="componenti-list">
                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('prodotto')['componenti'], 'comp');
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
                                            <?php if ($_smarty_tpl->getValue('correlato')['sconto']) {?>
                                                <span class="correlato-prezzo-scontato">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('correlato')['prezzo_scontato'],2);?>
</span>
                                                <span class="correlato-prezzo-old">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('correlato')['prezzo'],2);?>
</span>
                                            <?php } elseif ((true && (true && null !== ($_smarty_tpl->getValue('correlato')['prezzo'] ?? null)))) {?>
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
/recensione/aggiungi/<?php echo $_smarty_tpl->getValue('prodotto')['id'];?>
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
$foreach7DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('rec')->value) {
$foreach7DoElse = false;
?>
                        <div class="recensione-card">
                            <div class="recensione-header">
                                <span class="recensione-nickname">
                                    <i class="ti ti-user"></i>
                                    <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('rec')['nickname'], ENT_QUOTES, 'UTF-8', true);?>

                                </span>
                                <div class="recensione-stars">
                                    <?php $_smarty_tpl->assign('voto', $_smarty_tpl->getValue('rec')['voto'], false, NULL);?>
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
                            <p class="recensione-titolo"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('rec')['titolo'], ENT_QUOTES, 'UTF-8', true);?>
</p>
                            <p class="recensione-testo"><?php echo nl2br((string) htmlspecialchars((string)$_smarty_tpl->getValue('rec')['testo'], ENT_QUOTES, 'UTF-8', true), (bool) 1);?>
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

    <div class="minicart-content">
        <button id="close-minicart" class="modal-close-btn" type="button" aria-label="Chiudi pop-up">&times;</button>

        <h3 class="minicart-success-title">Prodotto aggiunto al carrello!</h3>

        <div class="minicart-product">
            <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/prodotti/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['immagine'], ENT_QUOTES, 'UTF-8', true);?>
"
                 alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['nome'], ENT_QUOTES, 'UTF-8', true);?>
"
                 class="minicart-img">
            <div class="minicart-info">
                <p class="minicart-nome"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['nome'], ENT_QUOTES, 'UTF-8', true);?>
</p>
                <p class="minicart-prezzo">
                    <?php if ($_smarty_tpl->getValue('prodotto')['sconto']) {?>
                        €<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prodotto')['prezzo_scontato'],2);?>

                    <?php } elseif ((true && (true && null !== ($_smarty_tpl->getValue('prodotto')['prezzo'] ?? null)))) {?>
                        €<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prodotto')['prezzo'],2);?>

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
class Block_11952616246a4130f86bd946_23466534 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\damic\\Desktop\\uni\\APPUNTI\\anno3\\secondo_semenstre\\Pweb\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<?php echo '<script'; ?>
>
var utenteLoggato = <?php if ((true && ($_smarty_tpl->hasVariable('utente') && null !== ($_smarty_tpl->getValue('utente') ?? null)))) {?>true<?php } else { ?>false<?php }?>;
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>

(function() {

    // ── HELPER: APRI MODAL LOGIN (riusa quello globale del layout) ──
    function richiedeLogin() {
        var modal = document.getElementById('login-modal-nav');
        if (modal) {
            modal.classList.add('is-active');
            modal.setAttribute('aria-hidden', 'false');
            var btn = document.getElementById('close-login-modal-nav');
            if (btn) btn.focus();
        }
    }

    // ── GALLERIA IMMAGINI ──
    var imgs   = document.querySelectorAll('.gallery-main-img');
    var thumbs = document.querySelectorAll('.gallery-thumb');
    var currentImg = 0;

    function showImg(index) {
        imgs.forEach(function(i) { i.classList.remove('is-active'); });
        thumbs.forEach(function(t) { t.classList.remove('is-active'); });
        currentImg = (index + imgs.length) % imgs.length;
        if (imgs[currentImg])   imgs[currentImg].classList.add('is-active');
        if (thumbs[currentImg]) thumbs[currentImg].classList.add('is-active');
    }

    var galleryPrev = document.getElementById('gallery-prev');
    var galleryNext = document.getElementById('gallery-next');
    if (galleryPrev) galleryPrev.addEventListener('click', function() { showImg(currentImg - 1); });
    if (galleryNext) galleryNext.addEventListener('click', function() { showImg(currentImg + 1); });

    thumbs.forEach(function(thumb) {
        thumb.addEventListener('click', function() {
            showImg(parseInt(this.dataset.index));
        });
    });

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

    // ── AJAX AGGIUNGI AL CARRELLO ──
    function aggiungiAlCarrello(idProdotto, quantita, callback) {
        fetch('/carrello/aggiungi', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: 'id_prodotto=' + idProdotto + '&quantita=' + quantita
        })
        .then(function(res) {
            if (!res.ok) throw new Error('Errore HTTP: ' + res.status);
            return res.json();
        })
        .then(function(data) {
            if (data.success) {
                apriMinicart();
                var cartBadge = document.getElementById('cart-count');
                if (cartBadge && data.cart_count !== undefined) {
                    cartBadge.textContent = data.cart_count;
                    cartBadge.style.display = data.cart_count > 0 ? 'inline' : 'none';
                }
                if (callback) callback(data);
            } else {
                console.error('Errore carrello:', data.messaggio);
            }
        })
        .catch(function(err) {
            console.error('Fetch carrello fallita:', err);
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
            aggiornaStelle(parseInt(votoInput ? votoInput.value : 0) || 0);
        });
    }

    // ── WISHLIST ──
    var btnWishlist  = document.getElementById('btn-wishlist');
    var wishlistIcon = document.getElementById('wishlist-icon');
    var inWishlist   = false;

    if (btnWishlist) {
        btnWishlist.addEventListener('click', function() {
            if (!utenteLoggato) {
                richiedeLogin();
                return;
            }

            inWishlist = !inWishlist;
            wishlistIcon.classList.toggle('ti-heart',        !inWishlist);
            wishlistIcon.classList.toggle('ti-heart-filled',  inWishlist);
            btnWishlist.classList.toggle('is-active',          inWishlist);

            fetch('/wishlist/aggiungi', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'id_prodotto=' + idProdotto
            })
            .then(function(res) {
                if (!res.ok) throw new Error('Errore HTTP: ' + res.status);
                return res.json();
            })
            .then(function(data) {
                if (!data.success) {
                    inWishlist = !inWishlist;
                    wishlistIcon.classList.toggle('ti-heart',        !inWishlist);
                    wishlistIcon.classList.toggle('ti-heart-filled',  inWishlist);
                    btnWishlist.classList.toggle('is-active',          inWishlist);
                    console.error('Errore wishlist:', data.messaggio);
                }
            })
            .catch(function(err) { console.error('Fetch wishlist fallita:', err); });
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
