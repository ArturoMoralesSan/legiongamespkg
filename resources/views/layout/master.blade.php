<!doctype html>
<html class="no-js" lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="apple-mobile-web-app-capable" content="yes">

        <!-- DNS prefetch -->
        <link rel="dns-prefetch" href="//fonts.googleapis.com">

        <title>@yield('tab_title', config('app.name'))</title>
        <meta name="description" content="@yield('description')">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- =========================================================
         FUENTES
         ========================================================= -->

    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i&display=swap"
        rel="stylesheet"
    >

    <!-- =========================================================
         LIBRERÍAS
         ========================================================= -->

    <!-- AOS -->
    <link
        href="https://unpkg.com/aos@2.3.1/dist/aos.css"
        rel="stylesheet"
    >

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    >

    <!-- =========================================================
         CSS BASE
         ========================================================= -->

    <link
        href="{{ version('css/main.css') }}"
        rel="stylesheet"
    >

    <!-- =========================================================
         CSS GENERAL DE PÁGINA
         ========================================================= -->

    <link
        href="{{ version('css/page.css') }}"
        rel="stylesheet"
    >

    <!-- =========================================================
         COMPONENTES
         ========================================================= -->

    <link
        href="{{ version('css/header.css') }}"
        rel="stylesheet"
    >

    <link
        href="{{ version('css/footer.css') }}"
        rel="stylesheet"
    >
    <link
        href="{{ version('css/gamer-list.css') }}"
        rel="stylesheet"
    >

     <link
        href="{{ version('css/features.css') }}"
        rel="stylesheet"
    >

    <link
        href="{{ version('css/cards.css') }}"
        rel="stylesheet"
    >

    <link
        href="{{ version('css/hero.css') }}"
        rel="stylesheet"
    >

    <link
        href="{{ version('css/login.css') }}"
        rel="stylesheet"
    >
    </head>
    <body class="@yield('class') {{ auth()->check() ? 'logged' : '' }}" data-root="{{ url('/') }}">
        <div id="app">
            <div id="bar" v-cloak>
                @include ('layout.user-bar')
            </div>
            @if (!Request::is('login'))
                @include('layout.header', [
                    'activeLink' => view()->getSection('active_menu')
                ])
            @endif
            

            <main id="main" class="main" role="main">
                @yield('content')
            </main>

            @if (!Request::is('login'))
                @include('layout.footer')
            @endif

            

            <site-overlay></site-overlay>

        </div>
        @includeWhen(view()->hasSection('has_gallery'), 'components.gallery')

        <!-- Scripts -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="{{ version('js/vendor.js') }}"></script>
        <script src="{{ version('js/main.js') }}"></script>
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            AOS.init();
        </script>
        @yield('scripts')
    </body>
    
    
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4956072266192129"
     crossorigin="anonymous"></script>
    
    
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-ZXLYS7WQJ8"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-ZXLYS7WQJ8');
</script>
    

    {{-- ================================================= --}}
{{-- ANUNCIO --}}
{{-- ================================================= --}}

<style>

    /* ================================================
       VENTANA
       ================================================ */

    #adModalOverlay {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;

        width: 100vw !important;
        height: 100vh !important;

        background:
            rgba(4, 7, 24, 0.92) !important;

        backdrop-filter: blur(7px) !important;
        -webkit-backdrop-filter: blur(7px) !important;

        z-index: 2147483647 !important;

        display: none;

        justify-content: center !important;
        align-items: center !important;

        padding: 15px !important;
        margin: 0 !important;

        box-sizing: border-box !important;
    }


    #adModalOverlay.active {
        display: flex !important;
    }


    .ad-modal-card {
        position: relative !important;

        width: 100% !important;
        max-width: 500px !important;

        background:
            linear-gradient(
                145deg,
                #0d112d 0%,
                #090d22 55%,
                #0b0b1d 100%
            ) !important;

        border: 1px solid rgba(124, 58, 237, 0.45) !important;

        border-radius: 12px !important;

        padding: 42px 10px 15px 10px !important;

        box-shadow:
            0 0 0 1px rgba(37, 99, 235, 0.08),
            0 15px 35px rgba(0, 0, 0, 0.65),
            0 0 30px rgba(91, 33, 182, 0.18) !important;

        display: flex !important;

        flex-direction: column !important;

        align-items: center !important;

        margin: auto !important;

        box-sizing: border-box !important;

        overflow: visible !important;
    }


    /* Línea superior decorativa */
    .ad-modal-card::before {
        content: "" !important;

        position: absolute !important;

        top: 0 !important;
        left: 12px !important;
        right: 12px !important;

        height: 2px !important;

        background:
            linear-gradient(
                90deg,
                transparent,
                #7c3aed,
                #2563eb,
                #7c3aed,
                transparent
            ) !important;

        border-radius: 0 0 10px 10px !important;

        opacity: 0.85 !important;
    }


    /* ================================================
       CLOSE
       ================================================ */

    .ad-modal-close-btn {
        position: absolute !important;

        top: 8px !important;
        right: 10px !important;

        background:
            rgba(30, 24, 67, 0.85) !important;

        color: #e9e7ff !important;

        border: 1px solid
            rgba(124, 58, 237, 0.35) !important;

        font-size: 13px !important;

        font-weight: 700 !important;

        font-family: system-ui, -apple-system, sans-serif !important;

        cursor: pointer !important;

        padding: 6px 13px !important;

        border-radius: 6px !important;

        transition:
            background 0.2s ease,
            border-color 0.2s ease,
            box-shadow 0.2s ease !important;

        z-index: 999 !important;

        -webkit-tap-highlight-color: transparent !important;
    }


    .ad-modal-close-btn:hover {
        background:
            rgba(109, 40, 217, 0.8) !important;

        border-color:
            rgba(139, 92, 246, 0.8) !important;

        color: #ffffff !important;

        box-shadow:
            0 0 12px rgba(124, 58, 237, 0.35) !important;
    }


    .ad-modal-close-btn:active {
        transform: scale(0.97);
    }


    /* ================================================
       IFRAME
       ================================================ */

    .ad-modal-frame {
        border: none !important;

        width: 100% !important;

        height: 250px !important;

        min-height: 250px !important;

        background: transparent !important;

        display: block !important;

        border-radius: 6px !important;

        overflow: hidden !important;
    }


    /* ================================================
       MÓVILES
       ================================================ */

    @media (max-width: 480px) {

        #adModalOverlay {
            padding: 10px !important;
        }


        .ad-modal-card {
            max-width: 100% !important;

            padding:
                42px 5px 12px 5px !important;

            border-radius: 11px !important;
        }


        .ad-modal-frame {
            width: 100% !important;

            height: 250px !important;

            min-height: 250px !important;
        }


        .ad-modal-close-btn {
            top: 8px !important;
            right: 8px !important;

            padding: 6px 12px !important;
        }

    }

</style>


<!-- CONT RX ANUNCIO -->

<div id="adModalOverlay">

    <div class="ad-modal-card">

        <button
            type="button"
            class="ad-modal-close-btn"
            onclick="closeAdModal()"
            title="Cerrar anuncio"
            aria-label="Cerrar anuncio"
        >
            ✕ Close
        </button>


        <iframe
            id="adModalFrame"
            class="ad-modal-frame"
            scrolling="no"
            frameborder="0"
        ></iframe>

    </div>

</div>

<script>

(function() {

    const adScriptUrl =
        "//untimely-hello.com/bqXGV.s/dPGIlS0xYCW/cb/XeSma9TuQZ/UClykEPMTccrzEOKDSgR5/ORDSkUtaNXzdMJ4/ODDSkk5NMhwF";

    const initialDelayMs = 8000;

    const refreshIntervalMs = 20000;

    const reopenDelayMs = 20000;


    let refreshTimer = null;
    let reopenTimer = null;
    let initialTimer = null;


    /*
     * ================================================
     * CERRAR ANUNCIO
     * ================================================
     */

    window.closeAdModal = function() {

        const modal =
            document.getElementById('adModalOverlay');


        if (!modal) {
            return;
        }


        modal.classList.remove('active');

        modal.style.setProperty(
            'display',
            'none',
            'important'
        );


        if (refreshTimer) {

            clearInterval(refreshTimer);

            refreshTimer = null;

        }


        if (reopenTimer) {

            clearTimeout(reopenTimer);

            reopenTimer = null;

        }



        reopenTimer = setTimeout(function() {

            loadAdModal();

            startAutoRefresh();

        }, reopenDelayMs);

    };

    function loadAdModal() {

        const iframe =
            document.getElementById('adModalFrame');

        const modal =
            document.getElementById('adModalOverlay');


        if (!iframe || !modal) {
            return;
        }


        const iframeContent = `

            <!DOCTYPE html>

            <html lang="es">

            <head>

                <meta
                    name="viewport"
                    content="width=device-width, initial-scale=1.0"
                >

                <style>

                    html,
                    body {

                        margin: 0;

                        padding: 0;

                        width: 100%;

                        text-align: center;

                        background: transparent;

                        overflow: hidden;

                    }


                    img,
                    iframe,
                    div {

                        max-width: 100% !important;

                    }

                </style>

            </head>


            <body>

                <script
                    data-cfasync="false"
                    src="${adScriptUrl}">
                <\/script>

            </body>

            </html>

        `;


        iframe.srcdoc = iframeContent;


        /*
         * anuncio.
         */

        modal.classList.add('active');

        modal.style.setProperty(
            'display',
            'flex',
            'important'
        );

    }

    function startAutoRefresh() {

        if (refreshTimer) {

            clearInterval(refreshTimer);

        }


        refreshTimer = setInterval(
            function() {

                loadAdModal();

            },
            refreshIntervalMs
        );

    }

    function startInitialDelay() {

        if (initialTimer) {

            clearTimeout(initialTimer);

        }


        initialTimer = setTimeout(
            function() {

                loadAdModal();

                startAutoRefresh();

            },
            initialDelayMs
        );

    }

    function initAd() {

        startInitialDelay();

    }

    if (document.readyState === 'complete') {

        initAd();

    } else {

        window.addEventListener(
            'load',
            initAd,
            {
                once: true
            }
        );

    }

})();

</script>
    
    <!-- ANUNCIO ANCLA -->

<style>
    *, *:before, *:after {
        box-sizing: border-box;
    }

    .ad-anchor-wrapper {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        width: 100%;
        background-color: rgba(15, 23, 42, 0.95);
        backdrop-filter: blur(8px);
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.5);
        z-index: 999999;
        display: none;
        justify-content: center;
        align-items: center;
        padding: 8px 0;
    }

    .ad-anchor-content {
        position: relative;
        width: 100%;
        max-width: 728px;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0 10px;
    }

    .ad-close-btn {
        position: absolute;
        top: -18px;
        right: 12px;
        background: #ef4444;
        color: #ffffff;
        border: none;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        font-size: 14px;
        font-weight: bold;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s ease;
        -webkit-tap-highlight-color: transparent;
    }

    .ad-close-btn:hover,
    .ad-close-btn:active {
        background: #dc2626;
    }

    .ad-frame {
        border: none;
        width: 100%;
        height: 90px;
        min-height: 90px;
        overflow: hidden;
        display: block;
        background: transparent;
    }

    @media (max-width: 480px) {
        .ad-close-btn {
            top: -16px;
            right: 8px;
        }
    }
</style>

<div class="ad-anchor-wrapper" id="adAnchor">
    <div class="ad-anchor-content">
        <button 
            class="ad-close-btn" 
            onclick="closeAd()" 
            title="Cerrar anuncio">
            ✕
        </button>

        <iframe 
            id="adFrame" 
            class="ad-frame" 
            scrolling="no">
        </iframe>
    </div>
</div>

<script>
(function() {

    const adScriptUrl = "//untimely-hello.com/bqXGV.s/dPGIlS0xYCW/cb/XeSma9TuQZ/UClykEPMTccrzEOKDSgR5/ORDSkUtaNXzdMJ4/ODDSkk5NMhwF";

    const refreshIntervalMs = 30000;
    const reopenDelayMs = 30000;

    let refreshTimer = null;
    let reopenTimer = null;
    let fallbackTimer = null;


    // Mostrar anuncio
    window.showAdBanner = function() {

        const adAnchor = document.getElementById('adAnchor');

        if (
            adAnchor &&
            adAnchor.style.display !== 'flex'
        ) {
            adAnchor.style.display = 'flex';
        }
    };


    // Cargar anuncio
    function loadAd() {

        const iframe = document.getElementById('adFrame');
        const adAnchor = document.getElementById('adAnchor');

        if (!iframe || !adAnchor) {
            return;
        }


        // Ocultar mientras carga
        adAnchor.style.display = 'none';


        // Limpiar temporizador anterior
        if (fallbackTimer) {
            clearTimeout(fallbackTimer);
        }


        // Respaldo para mostrar el anuncio
        // después de 1.2 segundos
        fallbackTimer = setTimeout(function() {

            window.showAdBanner();

        }, 1200);


        // Contenido interno del iframe
        const iframeContent = `
            <!DOCTYPE html>
            <html>

            <head>

                <meta 
                    name="viewport" 
                    content="width=device-width, initial-scale=1.0"
                >

                <style>

                    html,
                    body {
                        margin: 0;
                        padding: 0;
                        text-align: center;
                        background: transparent;
                        width: 100%;
                        overflow: hidden;
                    }

                    img,
                    iframe,
                    div {
                        max-width: 100% !important;
                    }

                </style>

            </head>

            <body>

                <script 
                    data-cfasync="false" 
                    src="${adScriptUrl}">
                <\/script>


                <script>

                    (function() {

                        function notifyParent() {

                            try {

                                if (
                                    window.parent &&
                                    window.parent.showAdBanner
                                ) {

                                    window.parent.showAdBanner();

                                }

                            } catch(e) {}

                        }


                        window.addEventListener(
                            'load',
                            notifyParent
                        );


                        setTimeout(
                            notifyParent,
                            400
                        );

                    })();

                <\/script>

            </body>

            </html>
        `;


        iframe.srcdoc = iframeContent;
    }


    // Actualización automática
    function startAutoRefresh() {

        if (refreshTimer) {
            clearInterval(refreshTimer);
        }

        refreshTimer = setInterval(
            loadAd,
            refreshIntervalMs
        );
    }


    // Carga inicial
    loadAd();

    startAutoRefresh();


    // Cerrar anuncio
    window.closeAd = function() {

        const adAnchor =
            document.getElementById('adAnchor');

        if (!adAnchor) {
            return;
        }


        // Ocultar
        adAnchor.style.display = 'none';


        // Detener actualización
        if (refreshTimer) {
            clearInterval(refreshTimer);
        }


        // Cancelar reapertura anterior
        if (reopenTimer) {
            clearTimeout(reopenTimer);
        }


        // Cancelar respaldo
        if (fallbackTimer) {
            clearTimeout(fallbackTimer);
        }


        // Volver a mostrar después de 30 segundos
        reopenTimer = setTimeout(function() {

            loadAd();

            startAutoRefresh();

        }, reopenDelayMs);

    };

})();
</script>
    
</html>