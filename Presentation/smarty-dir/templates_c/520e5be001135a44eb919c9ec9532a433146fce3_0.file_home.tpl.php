<?php
/* Smarty version 5.8.0, created on 2026-07-21 10:06:45
  from 'file:home.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a5f2895381400_22470366',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '520e5be001135a44eb919c9ec9532a433146fce3' => 
    array (
      0 => 'home.tpl',
      1 => 1784621202,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a5f2895381400_22470366 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_15422179036a5f2895349a01_94867759', "extra_css");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_11183289336a5f289534d0c6_11920698', "content");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_10964401776a5f28953802b1_20926252', "extra_js");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "extra_css"} */
class Block_15422179036a5f2895349a01_94867759 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

    <link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/public/css/home.css">
<?php
}
}
/* {/block "extra_css"} */
/* {block "content"} */
class Block_11183289336a5f289534d0c6_11920698 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>

<div class="container px-4">


        <div class="home-search-bar">
        <form class="home-search-form" action="<?php echo $_smarty_tpl->getValue('base_url');?>
/catalogo/giochi-da-tavolo" method="get">
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
                    <?php $_smarty_tpl->assign('haSconto', (($tmp = $_smarty_tpl->getValue('prodotto')['sconto'] ?? null)===null||$tmp==='' ? false ?? null : $tmp), false, NULL);?>
                    <?php $_smarty_tpl->assign('prezzoEffettivo', $_smarty_tpl->getValue('haSconto') && (true && (true && null !== ($_smarty_tpl->getValue('prodotto')['prezzo_scontato'] ?? null))) ? $_smarty_tpl->getValue('prodotto')['prezzo_scontato'] : (($tmp = $_smarty_tpl->getValue('prodotto')['prezzo'] ?? null)===null||$tmp==='' ? null ?? null : $tmp), false, NULL);?>

                    <div class="card-vector-item">
                        <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/prodotto?id=<?php echo $_smarty_tpl->getValue('prodotto')['id'];?>
" class="card-link-wrapper">
                            <div class="card home-card-fixed">
                                <div class="card-image">
                                    <figure class="image-container-fixed">
                                        <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/prodotti/<?php echo $_smarty_tpl->getValue('prodotto')['immagine'];?>
" alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['nome'], ENT_QUOTES, 'UTF-8', true);?>
" />
                                    </figure>
                                </div>
                                <div class="card-content">
                                    <p class="card-title-custom"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['nome'], ENT_QUOTES, 'UTF-8', true);?>
</p>

                                    <div class="card-rating">
                                        <?php $_smarty_tpl->assign('media', $_smarty_tpl->getValue('prodotto')['valutazione_media'], false, NULL);?>
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
                                        <?php if ($_smarty_tpl->getValue('haSconto') && (true && (true && null !== ($_smarty_tpl->getValue('prodotto')['prezzo_scontato'] ?? null)))) {?>
                                            <span class="price">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prodotto')['prezzo_scontato'],2);?>
</span>
                                            <?php if ((true && (true && null !== ($_smarty_tpl->getValue('prodotto')['prezzo'] ?? null)))) {?>
                                                <span class="price-old">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prodotto')['prezzo'],2);?>
</span>
                                            <?php }?>
                                        <?php } elseif ((true && (true && null !== ($_smarty_tpl->getValue('prodotto')['prezzo'] ?? null)))) {?>
                                            <span class="price">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prodotto')['prezzo'],2);?>
</span>
                                        <?php } else { ?>
                                            <span class="price-unavailable">Prezzo non disponibile</span>
                                        <?php }?>
                                    </div>

                                    <button class="btn-cart"
                                            data-id="<?php echo $_smarty_tpl->getValue('prodotto')['id'];?>
"
                                            data-nome="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['nome'], ENT_QUOTES, 'UTF-8', true);?>
"
                                            data-img="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/prodotti/<?php echo $_smarty_tpl->getValue('prodotto')['immagine'];?>
"
                                            data-prezzo="<?php echo $_smarty_tpl->getValue('prezzoEffettivo');?>
">
                                        <i class="ti ti-shopping-cart"></i> Acquista
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
                <p class="empty-section-message">Nessuna offerta disponibile al momento.</p>
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
                    <?php $_smarty_tpl->assign('haSconto', (($tmp = $_smarty_tpl->getValue('prodotto')['sconto'] ?? null)===null||$tmp==='' ? false ?? null : $tmp), false, NULL);?>
                    <?php $_smarty_tpl->assign('prezzoEffettivo', $_smarty_tpl->getValue('haSconto') && (true && (true && null !== ($_smarty_tpl->getValue('prodotto')['prezzo_scontato'] ?? null))) ? $_smarty_tpl->getValue('prodotto')['prezzo_scontato'] : (($tmp = $_smarty_tpl->getValue('prodotto')['prezzo'] ?? null)===null||$tmp==='' ? null ?? null : $tmp), false, NULL);?>

                    <div class="card-vector-item">
                        <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/prodotto?id=<?php echo $_smarty_tpl->getValue('prodotto')['id'];?>
" class="card-link-wrapper">
                            <div class="card home-card-fixed">
                                <div class="card-image">
                                    <figure class="image-container-fixed">
                                        <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/prodotti/<?php echo $_smarty_tpl->getValue('prodotto')['immagine'];?>
" alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['nome'], ENT_QUOTES, 'UTF-8', true);?>
" />
                                    </figure>
                                </div>
                                <div class="card-content">
                                    <p class="card-title-custom"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['nome'], ENT_QUOTES, 'UTF-8', true);?>
</p>

                                    <div class="card-rating">
                                        <?php $_smarty_tpl->assign('media', $_smarty_tpl->getValue('prodotto')['valutazione_media'], false, NULL);?>
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
                                        <?php if ($_smarty_tpl->getValue('haSconto') && (true && (true && null !== ($_smarty_tpl->getValue('prodotto')['prezzo_scontato'] ?? null)))) {?>
                                            <span class="price">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prodotto')['prezzo_scontato'],2);?>
</span>
                                            <?php if ((true && (true && null !== ($_smarty_tpl->getValue('prodotto')['prezzo'] ?? null)))) {?>
                                                <span class="price-old">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prodotto')['prezzo'],2);?>
</span>
                                            <?php }?>
                                        <?php } elseif ((true && (true && null !== ($_smarty_tpl->getValue('prodotto')['prezzo'] ?? null)))) {?>
                                            <span class="price">€<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('prodotto')['prezzo'],2);?>
</span>
                                        <?php } else { ?>
                                            <span class="price-unavailable">Prezzo non disponibile</span>
                                        <?php }?>
                                    </div>

                                    <button class="btn-cart"
                                            data-id="<?php echo $_smarty_tpl->getValue('prodotto')['id'];?>
"
                                            data-nome="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('prodotto')['nome'], ENT_QUOTES, 'UTF-8', true);?>
"
                                            data-img="<?php echo $_smarty_tpl->getValue('base_url');?>
/img/prodotti/<?php echo $_smarty_tpl->getValue('prodotto')['immagine'];?>
"
                                            data-prezzo="<?php echo $_smarty_tpl->getValue('prezzoEffettivo');?>
">
                                        <i class="ti ti-shopping-cart"></i> Acquista
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
                <p class="empty-section-message">Nessun nuovo arrivo disponibile al momento.</p>
            <?php }?>
        </div>
    </section>

</div>

<div class="minicart-modal" id="minicart-modal" aria-hidden="true">
    <div class="modal-background"></div>

    <div class="minicart-content">
        <button id="close-minicart" class="modal-close-btn" type="button" aria-label="Chiudi pop-up">&times;</button>

        <h3 class="minicart-success-title">Prodotto aggiunto al carrello!</h3>

        <div class="minicart-product">
            <img src="" alt="" class="minicart-img" id="minicart-img">
            <div class="minicart-info">
                <p class="minicart-nome" id="minicart-nome"></p>
                <p class="minicart-prezzo" id="minicart-prezzo"></p>
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

<div class="login-modal" id="login-modal" aria-hidden="true">
    <div class="modal-background"></div>

    <div class="login-modal-content">
        <button id="close-login-modal" class="modal-close-btn" type="button" aria-label="Chiudi pop-up">&times;</button>

        <div class="login-modal-icon">
            <i class="ti ti-lock"></i>
        </div>

        <h3 class="login-modal-title">Accedi per continuare</h3>
        <p class="login-modal-text">
            Devi avere un account per aggiungere prodotti al carrello e procedere all'acquisto.
        </p>

        <div class="login-modal-actions">
            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/accedi" class="button btn-login-modal-accedi">
                <i class="ti ti-login"></i> Accedi
            </a>
            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/registrati" class="button btn-login-modal-registrati">
                Crea un account
            </a>
        </div>
    </div>
</div>

<div class="unavailable-modal" id="unavailable-modal" aria-hidden="true">
    <div class="modal-background"></div>

    <div class="unavailable-modal-content">
        <button id="close-unavailable-modal" class="modal-close-btn" type="button" aria-label="Chiudi pop-up">&times;</button>

        <div class="unavailable-modal-icon">
            <i class="ti ti-ban"></i>
        </div>

        <h3 class="unavailable-modal-title">Prodotto non disponibile</h3>
        <p class="unavailable-modal-text" id="unavailable-modal-text">
            Questo prodotto non è al momento acquistabile.
        </p>

        <div class="unavailable-modal-actions">
            <a href="<?php echo $_smarty_tpl->getValue('base_url');?>
" class="button btn-unavailable-modal">
                <i class="ti ti-arrow-left"></i> Torna al catalogo
            </a>
        </div>
    </div>
</div>

<?php
}
}
/* {/block "content"} */
/* {block "extra_js"} */
class Block_10964401776a5f28953802b1_20926252 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
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


<?php echo '<script'; ?>
>
    // Percorso base del sito, valutato qui da Smarty prima del JS puro sotto.
    const baseUrl = "<?php echo $_smarty_tpl->getValue('base_url');?>
";

    

    function initHomeCartLogic() {

    const minicartModal  = document.getElementById('minicart-modal');
    const minicartImg     = document.getElementById('minicart-img');
    const minicartNome    = document.getElementById('minicart-nome');
    const minicartPrezzo  = document.getElementById('minicart-prezzo');

    function apriMinicart(dati) {
        if (!minicartModal) return;
        minicartImg.src = dati.img;
        minicartImg.alt = dati.nome;
        minicartNome.textContent = dati.nome;
        minicartPrezzo.textContent = '€' + parseFloat(dati.prezzo || 0).toFixed(2);

        minicartModal.classList.add('is-active');
        minicartModal.setAttribute('aria-hidden', 'false');
        document.getElementById('close-minicart')?.focus();
    }

    function chiudiMinicart() {
        if (!minicartModal) return;
        minicartModal.classList.remove('is-active');
        minicartModal.setAttribute('aria-hidden', 'true');
    }

    document.getElementById('close-minicart')?.addEventListener('click', function (e) {
        e.preventDefault();
        chiudiMinicart();
    });

    minicartModal?.querySelector('.modal-background')?.addEventListener('click', chiudiMinicart);

    minicartModal?.querySelectorAll('.minicart-actions a').forEach(function (btn) {
        btn.addEventListener('click', function (e) { e.stopPropagation(); });
    });

    const loginModal = document.getElementById('login-modal');

    function apriLoginModal() {
        if (!loginModal) return;
        loginModal.classList.add('is-active');
        loginModal.setAttribute('aria-hidden', 'false');
        document.getElementById('close-login-modal')?.focus();
    }

    function chiudiLoginModal() {
        if (!loginModal) return;
        loginModal.classList.remove('is-active');
        loginModal.setAttribute('aria-hidden', 'true');
    }

    document.getElementById('close-login-modal')?.addEventListener('click', function (e) {
        e.preventDefault();
        chiudiLoginModal();
    });

    loginModal?.querySelector('.modal-background')?.addEventListener('click', chiudiLoginModal);

    loginModal?.querySelectorAll('.login-modal-actions a').forEach(function (btn) {
        btn.addEventListener('click', function (e) { e.stopPropagation(); });
    });

    const unavailableModal = document.getElementById('unavailable-modal');
    const unavailableModalText = document.getElementById('unavailable-modal-text');

    function apriUnavailableModal(messaggio) {
        if (!unavailableModal) return;
        if (messaggio) {
            unavailableModalText.textContent = messaggio;
        }
        unavailableModal.classList.add('is-active');
        unavailableModal.setAttribute('aria-hidden', 'false');
        document.getElementById('close-unavailable-modal')?.focus();
    }

    function chiudiUnavailableModal() {
        if (!unavailableModal) return;
        unavailableModal.classList.remove('is-active');
        unavailableModal.setAttribute('aria-hidden', 'true');
    }

    document.getElementById('close-unavailable-modal')?.addEventListener('click', function (e) {
        e.preventDefault();
        chiudiUnavailableModal();
    });

    unavailableModal?.querySelector('.modal-background')?.addEventListener('click', chiudiUnavailableModal);

    unavailableModal?.querySelectorAll('.unavailable-modal-actions a').forEach(function (btn) {
        btn.addEventListener('click', function (e) { e.stopPropagation(); });
    });

    function aggiungiAlCarrello(idProdotto, quantita, dati) {
        fetch(baseUrl + '/carrello/aggiungi', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: 'id_prodotto=' + idProdotto + '&quantita=' + quantita
        })
        .then(function(res) {
            var status = res.status;
            return res.text().then(function(text) {
                var data = parseJsonSicuro(text);
                if (data === null) {
                    console.error('Risposta non interpretabile come JSON:', text);
                    return { status: status, body: { error: 'parse_error' } };
                }
                return { status: status, body: data };
            });
        })
        .then(function(result) {
            if (result.body.error === 'parse_error') {
                console.error('Errore tecnico nella risposta del server.');
                return;
            }
            if (result.status === 401 || result.body.error === 'auth_required') {
                apriLoginModal();
                return;
            }
            if (result.body.success !== false) {
                apriMinicart(dati);
                var cartBadge = document.getElementById('cart-count');
                if (cartBadge && result.body.cart_count !== undefined) {
                    cartBadge.textContent = result.body.cart_count;
                    cartBadge.style.display = result.body.cart_count > 0 ? 'inline' : 'none';
                }
            } else {
                apriUnavailableModal(result.body.message);
            }
        })
        .catch(function(err) {
            console.error('Fetch carrello fallita:', err);
        });
    }

    function parseJsonSicuro(text) {
        try {
            return JSON.parse(text);
        } catch (e) {
            var inizio = text.indexOf('{');
            var fine = text.lastIndexOf('}');
            if (inizio === -1 || fine === -1 || fine < inizio) {
                return null;
            }
            try {
                return JSON.parse(text.substring(inizio, fine + 1));
            } catch (e2) {
                return null;
            }
        }
    }

    document.querySelectorAll('.btn-cart').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            const dati = {
                id: this.dataset.id,
                nome: this.dataset.nome,
                img: this.dataset.img,
                prezzo: this.dataset.prezzo
            };

            aggiungiAlCarrello(dati.id, 1, dati);
        });
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initHomeCartLogic);
} else {
    initHomeCartLogic();
}



<?php echo '</script'; ?>
>

<?php
}
}
/* {/block "extra_js"} */
}
