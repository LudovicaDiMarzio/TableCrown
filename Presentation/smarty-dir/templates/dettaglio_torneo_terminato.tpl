{* Vista dettaglio Torneo - lato utente. Dati attesi da CDettaglioEvento::mostraDettaglioEvento() *}
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
        <p class="evento-tipo">Torneo &bull; {$gioco}</p>
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

        {if $challenge}
          <p class="evento-challenge-link">
            Fa parte della challenge:
            <a href="{$base_url}/eventi/dettaglio/{$challenge.idEvento}">{$challenge.nomeEvento}</a>
          </p>
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
      </div>

      {* ATTENZIONE: $podio non è ancora passato da costruisciDatiVistaEvento() per ETorneo - vedi nota sopra *}
      <div class="evento-podio box">
        <h2><i class="ti ti-medal"></i> Podio finale</h2>
        {if $podio}
          <ol class="podio-list">
            {foreach $podio as $posto}
              <li class="podio-item podio-posizione-{$posto.posizione}">
                <span class="podio-posizione">{$posto.posizione}&deg;</span>
                <span class="podio-utente">{$posto.utente.nome}</span>
              </li>
            {/foreach}
          </ol>
        {else}
          <p class="evento-vuoto">Il podio non è ancora stato pubblicato.</p>
        {/if}
      </div>

    </div>

  </div>
</section>