{{--
    Aviso de AdBlock en el sitio.
    Se configura en Panel > Publicidad > Anuncios > Detección de AdBlock
    (App\Support\AdBlockSettings): activo, aviso o bloqueo, páginas,
    recordar cierre, título y mensaje.

    Si el bloqueo de la página de descarga está activo, ahí no se muestra:
    await.blade.php ya bloquea la descarga con su propio aviso.

    La detección está en partials/adblock-detect.blade.php.
--}}
@if(\App\Support\AdBlockSettings::noticeAppliesHere())
@php
    $adblock = \App\Support\AdBlockSettings::all();
    $adblockClosable = $adblock['mode'] === 'soft';
@endphp

<div class="adblock-notice" id="adblock-notice" role="dialog" aria-modal="true" aria-labelledby="adblock-notice-title" hidden>
    <div class="adblock-notice__card">
        <div class="adblock-notice__icon">
            <i class="fa-solid fa-shield-halved"></i>
        </div>

        <h2 class="adblock-notice__title" id="adblock-notice-title">
            {{ $adblock['title'] }}
        </h2>

        <p class="adblock-notice__text">
            {!! nl2br(e($adblock['message'])) !!}
        </p>

        @if($adblock['download_block'])
            <p class="adblock-notice__text adblock-notice__text--small">
                Las descargas requieren desactivarlo.
            </p>
        @endif

        <div class="adblock-notice__actions">
            <button type="button" class="adblock-notice__btn adblock-notice__btn--primary" data-adblock-reload>
                <i class="fa-solid fa-rotate-right"></i>
                Ya lo desactivé, recargar
            </button>

            @if($adblockClosable)
                <button type="button" class="adblock-notice__btn" data-adblock-dismiss>
                    Continuar de todos modos
                </button>
            @endif
        </div>
    </div>
</div>

<script>
(function () {
    var STORAGE_KEY = 'adblockNoticeDismissed';
    var CLOSABLE = @json($adblockClosable);
    var REMEMBER = @json($adblockClosable && $adblock['remember_dismiss']);
    var notice = document.getElementById('adblock-notice');

    if (!notice) return;

    function dismissed() {
        if (!REMEMBER) return false;
        try { return sessionStorage.getItem(STORAGE_KEY) === '1'; } catch (e) { return false; }
    }

    if (dismissed()) return;

    var shown = false;

    function show() {
        if (shown || dismissed()) return;
        shown = true;
        notice.hidden = false;
        // Forzar reflow para que se vea la animación de entrada.
        void notice.offsetWidth;
        notice.classList.add('is-open');

        // En modo bloqueo no se puede usar la página detrás del aviso.
        if (!CLOSABLE) document.documentElement.style.overflow = 'hidden';
    }

    function close() {
        if (!CLOSABLE) return;
        if (REMEMBER) {
            try { sessionStorage.setItem(STORAGE_KEY, '1'); } catch (e) {}
        }
        notice.classList.remove('is-open');
        setTimeout(function () { notice.hidden = true; }, 250);
    }

    if (CLOSABLE) {
        notice.querySelector('[data-adblock-dismiss]').addEventListener('click', close);
    }
    notice.querySelector('[data-adblock-reload]').addEventListener('click', function () {
        window.location.reload();
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && shown) close();
    });

    // Detección compartida: partials/adblock-detect.blade.php
    if (window.adBlockCheck) {
        window.adBlockCheck.then(function (blocked) {
            if (blocked) show();
        });
    }
})();
</script>

@endif
