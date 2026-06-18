<?php
/* Smarty version 5.8.0, created on 2026-06-18 11:55:09
  from 'file:home.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a33c07d851857_75683039',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3ffb4dea4d0e42a75e520b0d03a07dd29989dd0e' => 
    array (
      0 => 'home.tpl',
      1 => 1781775554,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a33c07d851857_75683039 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\damic\\Desktop\\uni\\APPUNTI\\anno3\\secondo_semenstre\\Pweb\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_1877753816a33c07d819843_71212491', "extra_css");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_3200076696a33c07d81d517_78647717', "content");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_6164577036a33c07d850cd4_17063859', "extra_js");
?>

<?php $_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "extra_css"} */
class Block_1877753816a33c07d819843_71212491 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\damic\\Desktop\\uni\\APPUNTI\\anno3\\secondo_semenstre\\Pweb\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

    <link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/css/home.css">
<?php
}
}
/* {/block "extra_css"} */
/* {block "content"} */
class Block_3200076696a33c07d81d517_78647717 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\damic\\Desktop\\uni\\APPUNTI\\anno3\\secondo_semenstre\\Pweb\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<div class="container px-4">


        <div class="home-search-bar">
        <form class="home-search-form" action="<?php echo $_smarty_tpl->getValue('base_url');?>
/catalogo" method="get">
            <input class="input home-search-input"
                   type="search"
                   name="q"
                   placeholder="Cerca nel catalogo..."
                   value="<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('search_query') ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
"
                   aria-label="Cerca nel catalogo">
            <button class="button home-search-btn" type="submit" aria-label="Cerca">
                <i class="ti ti-search"></i>
            </button>
        </form>
    </div>



                <div class="hero-carousel" id="home-carousel">
        <div class="carousel-inner" id="carousel-inner">
            <div class="carousel-item">
                <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/carousel/slide1.jpg" alt="Nuovi Giochi da Tavolo">
                <div class="carousel-caption">
                    <h2 class="title is-3 has-text-white">Esplora le ultime novità</h2>
                    <p class="subtitle is-5 has-text-warning">I migliori titoli del 2026 arrivano su TableCrown</p>
                </div>
            </div>



            <div class="carousel-item">
                <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/carousel/slide2.jpg" alt="Eventi e Tornei">
                <div class="carousel-caption">
                    <h2 class="title is-3 has-text-white">Tornei della Settimana</h2>
                    <p class="subtitle is-5 has-text-warning">Iscriviti agli eventi ufficiali in Abruzzo</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/carousel/slide3.jpg" alt="Offerte Speciali">
                <div class="carousel-caption">
                    <h2 class="title is-3 has-text-white">Sconti folli di Primavera</h2>
                    <p class="subtitle is-5 has-text-warning">Fino al 40% di sconto sui giochi di strategia</p>
                </div>
            </div>
        </div>
        <div class="carousel-nav">
            <button class="button is-rounded" id="prev-slide"><i class="ti ti-chevron-left"></i></button>
            <button class="button is-rounded" id="next-slide"><i class="ti ti-chevron-right"></i></button>
        </div>
    </div>

                <section class="home-section">
        <h2 class="title section-title is-4 text-uppercase">🔥 Offerte in Scadenza</h2>

        <div class="card-row-vector">
            <?php if ((true && ($_smarty_tpl->hasVariable('offerte') && null !== ($_smarty_tpl->getValue('offerte') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('offerte')) > 0) {?>
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('offerte'), 'prodotto');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('prodotto')->value) {
$foreach0DoElse = false;
?>
                    <div class="card-vector-item">
                        <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/prodotto/<?php echo $_smarty_tpl->getValue('prodotto')->getId();?>
" class="card-link-wrapper">
                            <div class="card home-card-fixed">
                                <div class="card-image">
                                    <figure class="image-container-fixed">
                                        <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/prodotti/<?php echo $_smarty_tpl->getValue('prodotto')->getImmagine();?>
" alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')->getNome(), ENT_QUOTES, 'UTF-8', true);?>
" />
                                    </figure>
                                </div>
                                <div class="card-content">
                                    <p class="card-title-custom"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')->getNome(), ENT_QUOTES, 'UTF-8', true);?>
</p>

                                    <div class="card-rating">
                                        <?php $_smarty_tpl->assign('media', $_smarty_tpl->getValue('prodotto')->getValutazioneMedia(), false, NULL);?>
                                        <?php $_smarty_tpl->assign('stelle', array(1,2,3,4,5), false, NULL);?>
                                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('stelle'), 's');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('s')->value) {
$foreach1DoElse = false;
?>
                                            <?php if ($_smarty_tpl->getValue('s') <= $_smarty_tpl->getValue('media')) {?>
                                                <i class="ti ti-star-filled star-icon"></i>
                                            <?php } elseif (($_smarty_tpl->getValue('s')-$_smarty_tpl->getValue('media')) < 1) {?>
                                                <i class="ti ti-star-half-filled star-icon"></i>
                                            <?php } else { ?>
                                                <i class="ti ti-star star-icon"></i>
                                            <?php }?>
                                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                                    </div>

                                    <div class="price-container">
                                        <?php $_smarty_tpl->assign('prezzo', $_smarty_tpl->getValue('prodotto')->getPrezzo(), false, NULL);?>
                                        <?php if ($_smarty_tpl->getValue('prezzo')) {?>
                                            <?php if ($_smarty_tpl->getValue('prezzo')->hasSconto()) {?>
                                                <span class="price">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prezzo')->calcolaPrezzoScontato(),2);?>
</span>
                                                <span class="price-old">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prezzo')->getValore(),2);?>
</span>
                                            <?php } else { ?>
                                                <span class="price">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prezzo')->getValore(),2);?>
</span>
                                            <?php }?>
                                        <?php } else { ?>
                                            <span class="price-unavailable">Prezzo non disponibile</span>
                                        <?php }?>
                                    </div>

                                    <button class="btn-cart">
                                        <i class="ti ti-shopping-cart"></i> Carrello
                                    </button>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>

                                <div class="card-vector-item card-vector-more">
                    <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/offerte" class="view-more-link" title="Vedi tutte le offerte">
                        <div class="circle-plus">
                            <span>+</span>
                        </div>
                        <span class="view-more-text">Vedi tutti</span>
                    </a>
                </div>

            <?php } else { ?>
                <?php $_smarty_tpl->assign('demo_items', array(1,2,3,4,5), false, NULL);?>
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('demo_items'), 'i');
$foreach2DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('i')->value) {
$foreach2DoElse = false;
?>
                    <div class="card-vector-item">
                        <a href="#" class="card-link-wrapper">
                            <div class="card home-card-fixed">
                                <div class="card-image">
                                    <figure class="image-container-fixed">
                                        <img src="https://bulma.io/assets/images/placeholders/1280x960.png" alt="Placeholder image" />
                                    </figure>
                                </div>
                                <div class="card-content">
                                    <p class="card-title-custom">Gioco in Offerta <?php echo $_smarty_tpl->getValue('i');?>
</p>

                                    <div class="card-rating">
                                        <?php $_smarty_tpl->assign('media', 4, false, NULL);?>
                                        <?php $_smarty_tpl->assign('stelle', array(1,2,3,4,5), false, NULL);?>
                                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('stelle'), 's');
$foreach3DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('s')->value) {
$foreach3DoElse = false;
?>
                                            <?php if ($_smarty_tpl->getValue('s') <= $_smarty_tpl->getValue('media')) {?>
                                                <i class="ti ti-star-filled star-icon"></i>
                                            <?php } elseif (($_smarty_tpl->getValue('s')-$_smarty_tpl->getValue('media')) < 1) {?>
                                                <i class="ti ti-star-half-filled star-icon"></i>
                                            <?php } else { ?>
                                                <i class="ti ti-star star-icon"></i>
                                            <?php }?>
                                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                                    </div>

                                    <div class="price-container">
                                        <span class="price">€29.90</span>
                                        <span class="price-old">€49.90</span>
                                    </div>

                                    <button class="btn-cart">
                                        <i class="ti ti-shopping-cart"></i> Carrello
                                    </button>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>

                                <div class="card-vector-item card-vector-more">
                    <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/offerte" class="more-link-wrapper" title="Vedi tutte le offerte">
                        <div class="more-circle-btn">
                            <span class="more-plus-icon">+</span>
                        </div>
                        <span class="more-text">Vedi tutte</span>
                    </a>
                </div>
            <?php }?>
        </div>
    </section>

                <section class="home-section">
        <h2 class="title section-title is-4 text-uppercase">✨ Nuovi Arrivi</h2>

        <div class="card-row-vector">
            <?php if ((true && ($_smarty_tpl->hasVariable('nuovi_arrivi') && null !== ($_smarty_tpl->getValue('nuovi_arrivi') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('nuovi_arrivi')) > 0) {?>
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('nuovi_arrivi'), 'prodotto');
$foreach4DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('prodotto')->value) {
$foreach4DoElse = false;
?>
                    <div class="card-vector-item">
                        <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/prodotto/<?php echo $_smarty_tpl->getValue('prodotto')->getId();?>
" class="card-link-wrapper">
                            <div class="card home-card-fixed">
                                <div class="card-image">
                                    <figure class="image-container-fixed">
                                        <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/prodotti/<?php echo $_smarty_tpl->getValue('prodotto')->getImmagine();?>
" alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')->getNome(), ENT_QUOTES, 'UTF-8', true);?>
" />
                                    </figure>
                                </div>
                                <div class="card-content">
                                    <p class="card-title-custom"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')->getNome(), ENT_QUOTES, 'UTF-8', true);?>
</p>

                                    <div class="card-rating">
                                        <?php $_smarty_tpl->assign('media', $_smarty_tpl->getValue('prodotto')->getValutazioneMedia(), false, NULL);?>
                                        <?php $_smarty_tpl->assign('stelle', array(1,2,3,4,5), false, NULL);?>
                                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('stelle'), 's');
$foreach5DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('s')->value) {
$foreach5DoElse = false;
?>
                                            <?php if ($_smarty_tpl->getValue('s') <= $_smarty_tpl->getValue('media')) {?>
                                                <i class="ti ti-star-filled star-icon"></i>
                                            <?php } elseif (($_smarty_tpl->getValue('s')-$_smarty_tpl->getValue('media')) < 1) {?>
                                                <i class="ti ti-star-half-filled star-icon"></i>
                                            <?php } else { ?>
                                                <i class="ti ti-star star-icon"></i>
                                            <?php }?>
                                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                                    </div>

                                    <div class="price-container">
                                        <?php $_smarty_tpl->assign('prezzo', $_smarty_tpl->getValue('prodotto')->getPrezzo(), false, NULL);?>
                                        <?php if ($_smarty_tpl->getValue('prezzo')) {?>
                                            <?php if ($_smarty_tpl->getValue('prezzo')->hasSconto()) {?>
                                                <span class="price">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prezzo')->calcolaPrezzoScontato(),2);?>
</span>
                                                <span class="price-old">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prezzo')->getValore(),2);?>
</span>
                                            <?php } else { ?>
                                                <span class="price">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prezzo')->getValore(),2);?>
</span>
                                            <?php }?>
                                        <?php } else { ?>
                                            <span class="price-unavailable">Prezzo non disponibile</span>
                                        <?php }?>
                                    </div>

                                    <button class="btn-cart">
                                        <i class="ti ti-shopping-cart"></i> Carrello
                                    </button>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>

                                <div class="card-vector-item card-vector-more">
                    <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/catalogo?ordinamento=novita" class="more-link-wrapper" title="Vedi tutti i nuovi arrivi">
                        <div class="more-circle-btn">
                            <span class="more-plus-icon">+</span>
                        </div>
                        <span class="more-text">Vedi tutti</span>
                    </a>
                </div>

            <?php } else { ?>
                <?php $_smarty_tpl->assign('demo_arrivals', array(1,2,3,4,5), false, NULL);?>
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('demo_arrivals'), 'j');
$foreach6DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('j')->value) {
$foreach6DoElse = false;
?>
                    <div class="card-vector-item">
                        <a href="#" class="card-link-wrapper">
                            <div class="card home-card-fixed">
                                <div class="card-image">
                                    <figure class="image-container-fixed">
                                        <img src="https://bulma.io/assets/images/placeholders/1280x960.png" alt="Placeholder image" />
                                    </figure>
                                </div>
                                <div class="card-content">
                                    <p class="card-title-custom">Nuovo Arrivo <?php echo $_smarty_tpl->getValue('j');?>
</p>

                                    <div class="card-rating">
                                        <?php $_smarty_tpl->assign('media', 4, false, NULL);?>
                                        <?php $_smarty_tpl->assign('stelle', array(1,2,3,4,5), false, NULL);?>
                                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('stelle'), 's');
$foreach7DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('s')->value) {
$foreach7DoElse = false;
?>
                                            <?php if ($_smarty_tpl->getValue('s') <= $_smarty_tpl->getValue('media')) {?>
                                                <i class="ti ti-star-filled star-icon"></i>
                                            <?php } elseif (($_smarty_tpl->getValue('s')-$_smarty_tpl->getValue('media')) < 1) {?>
                                                <i class="ti ti-star-half-filled star-icon"></i>
                                            <?php } else { ?>
                                                <i class="ti ti-star star-icon"></i>
                                            <?php }?>
                                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                                    </div>

                                    <div class="price-container">
                                        <span class="price">€39.90</span>
                                    </div>

                                    <button class="btn-cart">
                                        <i class="ti ti-shopping-cart"></i> Carrello
                                    </button>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>

                                <div class="card-vector-item card-vector-more">
                    <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/catalogo?ordinamento=novita" class="more-link-wrapper" title="Vedi tutti i nuovi arrivi">
                        <div class="more-circle-btn">
                            <span class="more-plus-icon">+</span>
                        </div>
                        <span class="more-text">Vedi tutti</span>
                    </a>
                </div>
            <?php }?>
        </div>
    </section>

</div>
<?php
}
}
/* {/block "content"} */
/* {block "extra_js"} */
class Block_6164577036a33c07d850cd4_17063859 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\damic\\Desktop\\uni\\APPUNTI\\anno3\\secondo_semenstre\\Pweb\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<?php echo '<script'; ?>
>
    $(document).ready(function() {
        let currentSlide = 0;
        const totalSlides = 3;
        const $inner = $('#carousel-inner');

        function moveSlide(index) {
            currentSlide = (index + totalSlides) % totalSlides;
            $inner.css('transform', 'translateX(-' + (currentSlide * 100 / totalSlides) + '%)');
        }

        $('#next-slide').click(function() { moveSlide(currentSlide + 1); });
        $('#prev-slide').click(function() { moveSlide(currentSlide - 1); });

        setInterval(function() {
            moveSlide(currentSlide + 1);
        }, 5000);
    });
<?php echo '</script'; ?>
>
<?php
}
}
/* {/block "extra_js"} */
}
