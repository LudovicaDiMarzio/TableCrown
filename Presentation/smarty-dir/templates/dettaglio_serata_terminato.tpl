{* Vista dettaglio Serata - lato utente. Dati attesi da CDettaglioEvento::mostraDettaglioEvento() *}
<section class="evento-dettaglio-section">
  <div class="container">

    <div class="evento-header">
      <div class="evento-img-wrapper">
        {* ASSUNZIONE: imgEvento come contenuto binario -> base64. Verificare convenzione reale. *}
        <img src="data:image/jpeg;base64,{$imgEvento|base64_encode}" alt="{$nomeEvento}" class="evento-img">
        {if $statoEvento == 'terminato'}
          <span class="evento-stato-badge evento-stato-terminato">
            <i class="ti ti-flag-off"></i> Evento concluso
          </span>
        {/if}
      </div>

      <div class="evento-info">
        <p class="evento-tipo">Serata &bull; {$tipoSerata}</p>
        <h1 class="evento-titolo">{$nomeEvento}</h1>

        <div class="evento-meta">
          <span class="evento-meta-item"><i class="ti ti-calendar"></i> {$dataInizio|date_format:"%d/%m/%Y %H:%M"}</span>
          <span class="evento-meta-item"><i class="ti ti-users"></i> {$numeroPartecipanti}/{$maxPartecipanti} partecipanti</span>
        </div>

        {if $userIscritto}
          <span class="tag evento-tag-iscritto"><i class="ti ti-check"></i> Hai partecipato</span>
        {/if}
      </div>
    </div>

    <div class="evento-descrizione box">
      <h2>Descrizione</h2>
      <p>{$descrizioneEvento}</p>
    </div>

  </div>
</section>