{extends file="common/layout.tpl"}

{block name="content"}
<link rel="stylesheet" href="{$base_url}/css/eventi.css">

<div class="eventi-container">
    <div class="container">

        <div class="eventi-grid">

            <a href="{$base_url}/eventi/serate" class="evento-card-link">
                <article class="evento-card">
                    <h2 class="evento-title">Serate</h2>
                    <div class="evento-image-wrapper">
                        <img src="{$base_url}/image/eventi/serate.jpg" alt="Serate" class="evento-image">
                    </div>
                    <p class="evento-description">Serate a tema con giochi in compagnia, musica e tanto divertimento.</p>
                    <p class="evento-tagline">Vieni con noi, daaai!</p>
                </article>
            </a>

            <a href="{$base_url}/eventi/tornei" class="evento-card-link">
                <article class="evento-card">
                    <h2 class="evento-title">Tornei</h2>
                    <div class="evento-image-wrapper">
                        <img src="{$base_url}/image/eventi/tornei.jpg" alt="Tornei" class="evento-image">
                    </div>
                    <p class="evento-description">Sfide competitive tra giocatori, premi e tornei a eliminazione.</p>
                    <p class="evento-tagline">Si va a lettooo!!!</p>
                </article>
            </a>

            <a href="{$base_url}/eventi/challenge" class="evento-card-link">
                <article class="evento-card">
                    <h2 class="evento-title">Challenge</h2>
                    <div class="evento-image-wrapper">
                        <img src="{$base_url}/image/eventi/challenge.jpg" alt="Challenge" class="evento-image">
                    </div>
                    <p class="evento-description">Sblocca obiettivi, scala la classifica e conquista il podio.</p>
                    <p class="evento-tagline">Peffo'!!</p>
                </article>
            </a>

        </div>
    </div>
</div>
{/block}