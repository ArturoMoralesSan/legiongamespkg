@extends('layout.master')

@section('title', 'Preparando descarga')

@section('content')

<style>
  @keyframes rxModalPop {
    0% { opacity: 0; transform: scale(0.9) translateY(15px); }
    100% { opacity: 1; transform: scale(1) translateY(0); }
  }
  @keyframes rxNeonGlow {
    0%, 100% { 
      box-shadow: 0 0 20px rgba(255, 0, 60, 0.25), inset 0 0 15px rgba(255, 0, 60, 0.05); 
      border-color: rgba(255, 0, 60, 0.6); 
    }
    50% { 
      box-shadow: 0 0 35px rgba(255, 0, 60, 0.5), inset 0 0 25px rgba(255, 0, 60, 0.12); 
      border-color: rgba(255, 0, 60, 0.9); 
    }
  }
  .rx-grid-bg {
    background-color: #07070a;
    background-image: 
      linear-gradient(rgba(255, 0, 60, 0.07) 1px, transparent 1px),
      linear-gradient(90deg, rgba(255, 0, 60, 0.07) 1px, transparent 1px);
    background-size: 24px 24px;
  }
  .rx-card-anim {
    animation: rxModalPop 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards, rxNeonGlow 4s infinite ease-in-out;
  }
  .rx-btn-neon {
    background: #ff003c;
    color: #fff;
    border: 1px solid #ff2a5f;
    box-shadow: 0 0 15px rgba(255, 0, 60, 0.4);
    transition: all 0.25s ease;
  }
  .rx-btn-neon:hover {
    background: #e00034;
    box-shadow: 0 0 25px rgba(255, 0, 60, 0.7);
    transform: translateY(-2px);
  }
</style>

<section class="download-page">

    <div class="download-card">

        <div class="download-icon">

            <i class="fa-solid fa-download"></i>

        </div>

        <h1 class="download-card-title">

            {{ $downloadTitle ?? $game->title }}

        </h1>

        <p class="text-center">

            Estamos preparando tu descarga.

        </p>

        <div class="countdown">

            <div class="timer-circle">

                <div class="timer-value">

                    <span id="timer">20</span>

                    <small>SEGUNDOS</small>

                </div>

            </div>

        </div>

        <div class="game-info">

            <div class="info-box">

                <strong>Juego</strong>

                <span>

                    {{ $game->title }}

                </span>

            </div>

            <div class="info-box">

                <strong>Tamaño</strong>

                <span>

                    {{ $game->size_mb ?? '--' }}

                </span>

            </div>

            <div class="info-box">

                <strong>Plataformas</strong>

                <div class="platforms">

                    @foreach($game->platforms as $platform)

                        <span class="tag">

                            {{ $platform->name }}

                        </span>

                    @endforeach

                </div>

            </div>

            <div class="info-box">

                <strong>Categorías</strong>

                <div class="platforms">

                    @foreach($game->categories as $category)

                        <span class="tag">

                            {{ $category->name }}

                        </span>

                    @endforeach

                </div>

            </div>

        </div>

        
        <!-- ANUNCIO (se administra en Panel > Publicidad > Anuncios, posición "contenido") -->
        <div class="ad-container" style="text-align: center; margin-top: 25px; padding-top: 15px; border-top: 1px solid rgba(255, 255, 255, 0.1);">
            @include('partials.ad-slot', ['position' => 'content'])
        </div> 
        

    </div>

</section>

<!-- RX8 BLOCKER -->
<div id="rx-block-notice" style="display: none; position: fixed; inset: 0; width: 100%; height: 100%; background: rgba(3, 4, 7, 0.92); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); z-index: 999999; align-items: center; justify-content: center; padding: 20px; box-sizing: border-box; overflow-y: auto;">
  
  <div class="rx-grid-bg rx-card-anim" style="border-radius: 16px; max-width: 400px; width: 100%; padding: 32px 24px; text-align: center; position: relative; overflow: hidden; margin: auto;">
    
    <!-- Badge -->
    <div style="display: inline-flex; align-items: center; justify-content: center; width: 72px; height: 52px; border: 2px solid #ff003c; border-radius: 12px; margin-bottom: 20px; background: rgba(255, 0, 60, 0.08); box-shadow: 0 0 15px rgba(255, 0, 60, 0.3);">
      <span style="font-family: monospace; font-weight: 900; font-size: 1.5rem; color: #ff003c; letter-spacing: -1px; text-decoration: line-through; text-decoration-color: #ff003c; text-decoration-thickness: 3px;">℞</span>
    </div>

    <!-- Principal -->
    <h2 style="margin: 0 0 12px 0; font-size: 1.45rem; font-weight: 800; color: #ffffff; letter-spacing: -0.5px; text-shadow: 0 0 10px rgba(255,255,255,0.2);">
      Ad-Blocker Detected!
    </h2>

    <!-- Mensaje -->
    <p style="margin: 0 0 24px 0; font-size: 0.88rem; color: #a0a5b5; line-height: 1.6; font-family: system-ui, -apple-system, sans-serif;">
      Hemos detectado que tienes un bloqueador activo en tu navegador <b style="color: #fff;">(Brave Shields, Opera Ad-Blocker o extensión de terceros)</b>. Desactívalo para continuar y acceder a la descarga.
    </p>

    <!-- Recargar -->
    <button onclick="window.location.reload();" class="rx-btn-neon" style="width: 100%; padding: 12px 20px; border-radius: 8px; font-weight: 700; font-size: 0.92rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 16px;">
      <i class="fa-solid fa-rotate-right"></i> Reintentar / Recargar página
    </button>

    <!-- Ayuda -->
    <div style="font-size: 0.8rem; color: #6c7284;">
      <span style="cursor: pointer; text-decoration: underline; transition: color 0.2s;" onmouseover="this.style.color='#ff003c'" onmouseout="this.style.color='#6c7284'" onclick="alert('Desactiva el escudo en la barra de direcciones de Brave/Opera o paúsalo en tu extensión.')">
        ¿Cómo solucionarlo? <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 0.7rem; margin-left: 2px;"></i>
      </span>
    </div>

  </div>
</div>

@endsection


@section('scripts')

<script>

    let seconds = 20;

    const timer = document.getElementById('timer');

    /*
     * ENLACES PROTEGIDOS
     * La URL real ya NO se manda al navegador. En su lugar, se pide un
     * token temporal al servidor. Solo cuando el token es valido, el
     * servidor hace la redireccion real (ver /api/protected-links/go/{token}).
     */
    const gameId = {{ $game->id }};
    const linkId = @json($linkId ?? null);

    let protectedToken = null;
    let tokenReady = false;
    let tokenFailed = false;

    function mintUrl() {
        if (linkId) {
            return '/api/protected-links/' + gameId + '/token/' + linkId;
        }
        return '/api/protected-links/' + gameId + '/token';
    }

    const tokenPromise = fetch(mintUrl(), {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        cache: 'no-store',
        credentials: 'same-origin'
    })
        .then(function (response) {
            return response.json().then(function (data) {
                if (!response.ok) {
                    throw new Error(data.error || 'No se pudo preparar la descarga.');
                }
                return data;
            });
        })
        .then(function (data) {
            protectedToken = data.token;
            tokenReady = true;
        })
        .catch(function () {
            tokenFailed = true;
        });

    function goToDownload() {
        if (tokenFailed) {
            timer.textContent = '--';
            return;
        }

        if (tokenReady) {
            window.location.href = '/api/protected-links/go/' + encodeURIComponent(protectedToken);
            return;
        }

        // El token todavia no llega (raro, solo por lentitud de red);
        // esperamos a que la peticion termine antes de redirigir.
        tokenPromise.then(function () {
            goToDownload();
        });
    }

    let adBlockDetected = false;

    const rxNotice = document.getElementById('rx-block-notice');

    // AdBlock (se activa/desactiva en Panel > Publicidad > Detección de AdBlock)
    const blockDownloadOnAdBlock = @json(\App\Support\AdBlockSettings::all()['download_block']);

    function triggerAdBlock() {
        if (!blockDownloadOnAdBlock) return;

        if (!adBlockDetected) {
            adBlockDetected = true;
            if (typeof interval !== 'undefined') clearInterval(interval);
            if (rxNotice) rxNotice.style.display = 'flex';
            if (timer) timer.textContent = '--';
        }
    }

    // Temporizador de descarga original
    const interval = setInterval(function () {

        if (adBlockDetected) return;

        seconds--;

        timer.textContent = seconds;

        if (seconds <= 0) {

            clearInterval(interval);

            /*
             * Redirigir automáticamente (a traves del token protegido).
             */
            goToDownload();

        }

    }, 1000);

    // AdBlockers
    const fakeAd = document.createElement('div');
    fakeAd.className = 'adsbox ad-placement doubleclick ad-placeholder google-ad';
    fakeAd.style.cssText = 'width: 1px !important; height: 1px !important; position: absolute !important; left: -9999px !important;';
    document.body.appendChild(fakeAd);

    window.setTimeout(function() {
        if (fakeAd.offsetHeight === 0 || fakeAd.offsetLeft === 0 || fakeAd.clientWidth === 0 || window.getComputedStyle(fakeAd).display === 'none') {
            triggerAdBlock();
        }
        fakeAd.remove();
    }, 300);

    // Brave
    if (navigator.brave && typeof navigator.brave.isBrave === 'function') {
        navigator.brave.isBrave().then(function(isBrave) {
            if (isBrave) {
                const testScript = document.createElement('script');
                testScript.src = 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js';
                testScript.onerror = function() { triggerAdBlock(); };
                document.head.appendChild(testScript);
            }
        });
    }

    // Opera
    const isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
    if (isOpera) {
        const operaScript = document.createElement('script');
        operaScript.src = 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js';
        operaScript.onerror = function() { triggerAdBlock(); };
        document.head.appendChild(operaScript);
    }

</script>

@endsection
