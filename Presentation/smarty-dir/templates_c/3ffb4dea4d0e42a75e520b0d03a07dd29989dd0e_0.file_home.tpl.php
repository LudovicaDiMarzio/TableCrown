<?php
/* Smarty version 5.8.0, created on 2026-06-13 16:19:51
  from 'file:home.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a2d6707424140_02483190',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3ffb4dea4d0e42a75e520b0d03a07dd29989dd0e' => 
    array (
      0 => 'home.tpl',
      1 => 1781360365,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a2d6707424140_02483190 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\damic\\Desktop\\uni\\APPUNTI\\anno3\\secondo_semenstre\\Pweb\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_9012031446a2d67073f9379_26717724', "content");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_4659484566a2d67074235b6_51214003', "extra_js");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "content"} */
class Block_9012031446a2d67073f9379_26717724 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\damic\\Desktop\\uni\\APPUNTI\\anno3\\secondo_semenstre\\Pweb\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<div class="container px-4">

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
                                <div class="media">
                                    <div class="media-left">
                                        <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/categorie/<?php echo $_smarty_tpl->getValue('prodotto')->getCategoriaIcona();?>
" class="editor-avatar" alt="Categoria" />
                                    </div>
                                    <div class="media-content">
                                        <p class="card-title-custom"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')->getNome(), ENT_QUOTES, 'UTF-8', true);?>
</p>
                                        <p class="subtitle"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')->getEditore(), ENT_QUOTES, 'UTF-8', true);?>
</p>
                                    </div>
                                </div>
                                
                                <p class="game-description">
                                    <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')->getDescrizioneBreve(), ENT_QUOTES, 'UTF-8', true);?>

                                </p>
                                
                                <div class="price-container">
                                    <span class="price">€<?php echo $_smarty_tpl->getValue('prodotto')->getPrezzoScontato();?>
</span>
                                    <span class="price-old">€<?php echo $_smarty_tpl->getValue('prodotto')->getPrezzoListino();?>
</span>
                                </div>
                                
                                <div class="footer-custom">
                                    <time datetime="<?php echo $_smarty_tpl->getValue('prodotto')->getDataScadenza();?>
">
                                        <i class="ti ti-clock"></i> Scade il: <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')->getDataScadenzaFormat(), ENT_QUOTES, 'UTF-8', true);?>

                                    </time>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
            <?php } else { ?>
                <?php $_smarty_tpl->assign('demo_items', array(1,2,3,4,5), false, NULL);?>
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('demo_items'), 'i');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('i')->value) {
$foreach1DoElse = false;
?>
                    <div class="card-vector-item">
                        <div class="card home-card-fixed">
                            <div class="card-image">
                                <figure class="image-container-fixed">
                                    <img src="https://bulma.io/assets/images/placeholders/1280x960.png" alt="Placeholder image" />
                                </figure>
                            </div>
                            <div class="card-content">
                                <div class="media">
                                    <div class="media-left">
                                        <img src="https://bulma.io/assets/images/placeholders/96x96.png" class="editor-avatar" alt="Placeholder image" />
                                    </div>
                                    <div class="media-content">
                                        <p class="card-title-custom">Gioco in Offerta <?php echo $_smarty_tpl->getValue('i');?>
</p>
                                        <p class="subtitle">Editore Demo</p>
                                    </div>
                                </div>
                                
                                <p class="game-description">
                                    Offerta incredibile a tempo limitato. Aggiungi subito al carrello TableCrown.
                                </p>
                                
                                <div class="price-container">
                                    <span class="price">€29.90</span>
                                    <span class="price-old">€49.90</span>
                                </div>
                                
                                <div class="footer-card-custom">
                                    <time datetime="2026-06-15"><i class="ti ti-clock"></i> 11:59 PM - 15 Giu 2026</time>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
            <?php }?>
        </div>
    </section>

                <section class="home-section">
        <h2 class="title section-title is-4 text-uppercase">✨ Nuovi Arrivi</h2>
        
        <div class="card-row-vector">
            <?php if ((true && ($_smarty_tpl->hasVariable('nuovi_arrivi') && null !== ($_smarty_tpl->getValue('nuovi_arrivi') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('nuovi_arrivi')) > 0) {?>
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('nuovi_arrivi'), 'prodotto');
$foreach2DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('prodotto')->value) {
$foreach2DoElse = false;
?>
                    <div class="card-vector-item">
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
                                <div class="media">
                                    <div class="media-left">
                                        <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/categorie/<?php echo $_smarty_tpl->getValue('prodotto')->getCategoriaIcona();?>
" class="editor-avatar" alt="Categoria" />
                                    </div>
                                    <div class="media-content">
                                        <p class="card-title-custom"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')->getNome(), ENT_QUOTES, 'UTF-8', true);?>
</p>
                                        <p class="subtitle"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')->getEditore(), ENT_QUOTES, 'UTF-8', true);?>
</p>
                                    </div>
                                </div>
                                
                                <p class="game-description">
                                    <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')->getDescrizioneBreve(), ENT_QUOTES, 'UTF-8', true);?>

                                </p>
                                
                                <div class="price-container">
                                    <span class="price">€<?php echo $_smarty_tpl->getValue('prodotto')->getPrezzo();?>
</span>
                                </div>
                                
                                <div class="footer-card-custom">
                                    <time datetime="<?php echo $_smarty_tpl->getValue('prodotto')->getDataInserimento();?>
">
                                        <i class="ti ti-calendar"></i> Disponibile da oggi
                                    </time>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
            <?php } else { ?>
                <?php $_smarty_tpl->assign('demo_arrivals', array(1,2,3,4,5), false, NULL);?>
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('demo_arrivals'), 'j');
$foreach3DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('j')->value) {
$foreach3DoElse = false;
?>
                    <div class="card-vector-item">
                        <div class="card home-card-fixed">
                            <div class="card-image">
                                <figure class="image-container-fixed">
                                    <img src="https://bulma.io/assets/images/placeholders/1280x960.png" alt="Placeholder image" />
                                </figure>
                            </div>
                            <div class="card-content">
                                <div class="media">
                                    <div class="media-left">
                                        <img src="https://bulma.io/assets/images/placeholders/96x96.png" class="editor-avatar" alt="Placeholder image" />
                                    </div>
                                    <div class="media-content">
                                        <p class="card-title-custom">Nuovo Arrivo <?php echo $_smarty_tpl->getValue('j');?>
</p>
                                        <p class="subtitle">Editore Demo</p>
                                    </div>
                                </div>
                                
                                <p class="game-description">
                                    Appena arrivato in magazzino. Scopri le meccaniche e i components di alta qualità.
                                </p>
                                
                                <div class="price-container">
                                    <span class="price">€39.90</span>
                                </div>
                                
                                <div class="footer-card-custom">
                                    <time datetime="2026-06-12"><i class="ti ti-calendar"></i> Caricato il: 12 Giu 2026</time>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
            <?php }?>
        </div>
    </section>

</div>
<?php
}
}
/* {/block "content"} */
/* {block "extra_js"} */
class Block_4659484566a2d67074235b6_51214003 extends \Smarty\Runtime\Block
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
