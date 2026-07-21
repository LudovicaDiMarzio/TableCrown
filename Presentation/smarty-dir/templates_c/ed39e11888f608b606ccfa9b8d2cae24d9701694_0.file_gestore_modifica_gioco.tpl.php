<?php
/* Smarty version 5.8.0, created on 2026-07-21 21:56:39
  from 'file:gestore_modifica_gioco.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a5fcef7ef45d0_84354390',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ed39e11888f608b606ccfa9b8d2cae24d9701694' => 
    array (
      0 => 'gestore_modifica_gioco.tpl',
      1 => 1784663792,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a5fcef7ef45d0_84354390 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\TableCrown\\Presentation\\smarty-dir\\templates';
?>
<div class="gmp-overlay" id="gmpOverlay">
    <div class="gmp-modal">

        <div class="gmp-modal__header">
            <div class="gmp-modal__product">
                <img src="" alt="" class="gmp-modal__product-img" id="gmpImg">
                <div>
                    <h3 class="gmp-modal__title">Modifica prodotto</h3>
                    <p class="gmp-modal__product-name" id="gmpNome"></p>
                </div>
            </div>
            <button type="button" class="gmp-modal__close" onclick="gmpChiudiModale()" aria-label="Chiudi">
                <i class="ti ti-x"></i>
            </button>
        </div>

        <div class="gmp-modal__body">

                        <div class="gmp-section">
                <div class="gmp-section__header">
                    <i class="ti ti-discount-2"></i> Sconto promozionale
                </div>

                <p class="gmp-current-price" id="gmpPrezzoAttuale"></p>

                <label class="gmp-checkbox">
                    <input type="checkbox" id="gmpToggleSconto"
                           onchange="document.getElementById('gmpScontoFields').classList.toggle('active', this.checked)">
                    <span>Applica / aggiorna sconto</span>
                </label>

                <div id="gmpScontoFields" class="gmp-subfields">
                    <div class="gmp-row">
                        <div class="gmp-field-group">
                            <label class="gmp-label" for="gmpValoreSconto">Percentuale sconto (%)</label>
                            <input type="number" class="gmp-input" id="gmpValoreSconto" min="0" max="100" step="0.01">
                        </div>
                        <div class="gmp-field-group">
                            <label class="gmp-label" for="gmpScadenzaOfferta">Scadenza <span class="gmp-label__optional">(facoltativa)</span></label>
                            <input type="date" class="gmp-input" id="gmpScadenzaOfferta">
                        </div>
                    </div>
                </div>

                <p class="gmp-feedback" id="gmpFeedbackSconto"></p>
            </div>

                        <div class="gmp-section">
                <div class="gmp-section__header">
                    <i class="ti ti-alert-triangle"></i> Stato del prodotto
                </div>

                <label class="gmp-checkbox gmp-checkbox--danger">
                    <input type="checkbox" id="gmpToggleDanno"
                           onchange="document.getElementById('gmpDannoFields').classList.toggle('active', this.checked)">
                    <span>Segnala prodotto danneggiato</span>
                </label>

                <div id="gmpDannoFields" class="gmp-subfields">
                    <div class="gmp-field-group">
                        <label class="gmp-label" for="gmpLivelloDanno">Livello di danno</label>
                        <select class="gmp-select" id="gmpLivelloDanno">
                            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, (($tmp = $_smarty_tpl->getValue('livelloDanno_enum') ?? null)===null||$tmp==='' ? array() ?? null : $tmp), 'opt');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('opt')->value) {
$foreach0DoElse = false;
?>
                                <option value="<?php echo $_smarty_tpl->getValue('opt')['value'];?>
"><?php echo $_smarty_tpl->getValue('opt')['label'];?>
</option>
                            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                        </select>
                    </div>
                    <div class="gmp-field-group">
                        <label class="gmp-label" for="gmpDescrizioneDanno">Descrizione del danno</label>
                        <textarea class="gmp-textarea" id="gmpDescrizioneDanno" maxlength="500"></textarea>
                    </div>
                </div>

                <p class="gmp-feedback" id="gmpFeedbackDanno"></p>
            </div>

        </div>

        <div class="gmp-modal__footer">
            <button type="button" class="gmp-btn gmp-btn--ghost" onclick="gmpChiudiModale()">Annulla</button>
            <button type="button" class="gmp-btn gmp-btn--primary" id="gmpBtnSalva" onclick="gmpSalva()">
                <i class="ti ti-device-floppy"></i> Salva modifiche
            </button>
        </div>

    </div>
</div>

<?php echo '<script'; ?>
>
    let gmpIdProdotto = null;

    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.gmp-btn-modifica');
        if (!btn) return;

        gmpIdProdotto = btn.dataset.id;

        document.getElementById('gmpImg').src = btn.dataset.immagine || '';
        document.getElementById('gmpNome').textContent = btn.dataset.nome || '';
        document.getElementById('gmpPrezzoAttuale').textContent = 'Prezzo attuale: €' + parseFloat(btn.dataset.prezzo || 0).toFixed(2);

        const haSconto = btn.dataset.sconto === '1';
        document.getElementById('gmpToggleSconto').checked = haSconto;
        document.getElementById('gmpScontoFields').classList.toggle('active', haSconto);
        document.getElementById('gmpValoreSconto').value = btn.dataset.percentualeSconto || '';
        document.getElementById('gmpScadenzaOfferta').value = btn.dataset.scadenzaSconto || '';

        const haDanno = btn.dataset.danneggiato === '1';
        document.getElementById('gmpToggleDanno').checked = haDanno;
        document.getElementById('gmpDannoFields').classList.toggle('active', haDanno);
        document.getElementById('gmpLivelloDanno').value = btn.dataset.livelloDanno || '';
        document.getElementById('gmpDescrizioneDanno').value = btn.dataset.descrizioneDanno || '';

        document.getElementById('gmpFeedbackSconto').textContent = '';
        document.getElementById('gmpFeedbackDanno').textContent = '';

        document.getElementById('gmpOverlay').classList.add('active');
    });

    function gmpChiudiModale() {
        document.getElementById('gmpOverlay').classList.remove('active');
        gmpIdProdotto = null;
    }

    document.getElementById('gmpOverlay').addEventListener('click', function (e) {
        if (e.target === this) gmpChiudiModale();
    });

    function gmpSalva() {
        const btnSalva = document.getElementById('gmpBtnSalva');
        btnSalva.disabled = true;

        const fd = new FormData();
        fd.append('id_prodotto', gmpIdProdotto);

        if (document.getElementById('gmpToggleSconto').checked) {
            fd.append('modificaSconto', '1');
            fd.append('valoreSconto', document.getElementById('gmpValoreSconto').value);
            fd.append('scadenzaOfferta', document.getElementById('gmpScadenzaOfferta').value);
        } else {
            fd.append('rimuoviSconto', '1');
        }

        fd.append('danneggiato', document.getElementById('gmpToggleDanno').checked ? '1' : '0');
        fd.append('livelloDanno', document.getElementById('gmpLivelloDanno').value);
        fd.append('descrizioneDanno', document.getElementById('gmpDescrizioneDanno').value);

        fetch('<?php echo $_smarty_tpl->getValue('base_url');?>
/gestore/prodotti/modifica', {
    method: 'POST',
    headers: { 'X-Requested-With': 'XMLHttpRequest' },
    body: fd
})
            .then(res => res.json())
            .then(data => {
                btnSalva.disabled = false;
                if (data.status === 'ok') {
                    gmpChiudiModale();
                    location.reload();
                } else {
                    document.getElementById('gmpFeedbackSconto').textContent = data.message || 'Errore durante il salvataggio.';
                    document.getElementById('gmpFeedbackSconto').classList.add('gmp-feedback--error');
                }
            })
            .catch(() => {
                btnSalva.disabled = false;
                document.getElementById('gmpFeedbackSconto').textContent = 'Errore di rete.';
                document.getElementById('gmpFeedbackSconto').classList.add('gmp-feedback--error');
            });
    }
<?php echo '</script'; ?>
><?php }
}
