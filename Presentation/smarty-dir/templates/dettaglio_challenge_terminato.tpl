{* Vista dettaglio Challenge - lato utente. Dati attesi da CDettaglioEvento::mostraDettaglioEvento() *}
<section class="evento-dettaglio-section">
  <div class="container">

    <div class="evento-header">
      <div class="evento-img-wrapper">
        <img src="data:image/jpeg;base64,{$imgEvento|base64_encode}" alt="{$nomeEvento}" class="evento-img">
        {if $statoEvento == 'terminato'}
          <span class="evento-stato-badge evento-stato-terminato">
            <i class="ti ti-flag-off"></i> Evento concluso
          </span>
        {/if}
      </div>

      <div class="evento-info">
        <p class="evento-tipo">Challenge</p>
        <h1 class="evento-titolo">{$nomeEvento}</h1>

        <div class="evento-meta">
          <span class="evento-meta-item"><i class="ti ti-calendar"></i> {$dataInizio|date_format:"%d/%m/%Y %H:%M"}</span>
          <span class="evento-meta-item"><i class="ti ti-users"></i> {$numeroPartecipanti}/{$maxPartecipanti} partecipanti</span>
          {if $richiedeQuota}
            <span class="evento-meta-item"><i class="ti ti-ticket"></i> Quota: {$quotaIscrizione|string_format:"%.2f"} &euro;</span>
          {/if}
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

    <div class="evento-columns">

      <div class="evento-premio box">
        <h2><i class="ti ti-trophy"></i> Premio in palio</h2>
        <div class="premio-card">
          <img src="data:image/jpeg;base64,{$premio.immagine|base64_encode}" alt="{$premio.nome}" class="premio-img">
          <p class="premio-nome">{$premio.nome}</p>
        </div>
        <ul class="punteggi-list">
          <li><span class="punteggio-pos">1&deg;</span> {$punteggi.primo} punti</li>
          <li><span class="punteggio-pos">2&deg;</span> {$punteggi.secondo} punti</li>
          <li><span class="punteggio-pos">3&deg;</span> {$punteggi.terzo} punti</li>
        </ul>
      </div>

      <div class="evento-classifica box">
        <h2><i class="ti ti-list-numbers"></i> Classifica finale</h2>
        {if $classificaGenerata}
          <table class="classifica-table">
            <thead>
              <tr>
                <th>Pos.</th>
                <th>Utente</th>
                <th>Punti</th>
              </tr>
            </thead>
            <tbody>
              {foreach $classificaFinale as $riga}
                <tr class="classifica-riga-{$riga.posizione}">
                  <td>{$riga.posizione}&deg;</td>
                  <td>{$riga.utente.nome}</td>
                  <td>{$riga.punteggioTotale}</td>
                </tr>
              {/foreach}
            </tbody>
          </table>
        {else}
          <p class="evento-vuoto">La classifica finale non è ancora stata pubblicata.</p>
        {/if}
      </div>

    </div>

    <div class="evento-tornei box">
      <h2><i class="ti ti-swords"></i> Tornei della challenge</h2>
      <div class="tornei-grid">
        {foreach $tornei as $torneo}
          <a href="{$base_url}/eventi/dettaglio/{$torneo.idEvento}" class="torneo-mini-card">
            <p class="torneo-mini-nome">{$torneo.nomeEvento}</p>
            <p class="torneo-mini-gioco">{$torneo.gioco}</p>
          </a>
        {/foreach}
      </div>
    </div>

  </div>
</section>