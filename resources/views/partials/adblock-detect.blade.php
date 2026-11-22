{{--
    Detección de bloqueadores de anuncios (compartida).

    Expone window.adBlockCheck: una Promise que resuelve true si hay
    bloqueador. La usan:
      - partials/ad-runtime     → no muestra anuncios si hay bloqueador.
      - partials/adblock-notice → muestra el aviso configurado en el panel.

    Métodos:
    1. Señuelo: un div con clases que los bloqueadores ocultan.
    2. Red: intenta pedir el script de AdSense; si el navegador lo bloquea
       (Brave, Opera, uBlock, AdGuard, DNS...) la petición falla.
--}}
<script>
window.adBlockCheck = window.adBlockCheck || new Promise(function (resolve) {
    var pending = 2;
    var done = false;

    function finish(blocked) {
        if (done) return;

        if (blocked) {
            done = true;
            resolve(true);
            return;
        }

        if (--pending === 0) {
            done = true;
            resolve(false);
        }
    }

    // Si la petición de red tarda demasiado, no esperar más.
    setTimeout(function () {
        if (!done) {
            done = true;
            resolve(false);
        }
    }, 3000);

    // 1) Señuelo
    var bait = document.createElement('div');
    bait.className = 'adsbox ad-placement doubleclick ad-placeholder google-ad pub_300x250 text-ad';
    bait.setAttribute('aria-hidden', 'true');
    bait.style.cssText = 'width:1px!important;height:1px!important;position:absolute!important;left:-9999px!important;top:-9999px!important;';
    bait.innerHTML = '&nbsp;';
    document.body.appendChild(bait);

    setTimeout(function () {
        var style = window.getComputedStyle(bait);
        var blocked = !bait.parentNode
            || bait.offsetHeight === 0
            || bait.clientWidth === 0
            || style.display === 'none'
            || style.visibility === 'hidden';

        if (bait.parentNode) bait.parentNode.removeChild(bait);
        finish(blocked);
    }, 300);

    // 2) Petición al script de AdSense
    if (!window.fetch) {
        finish(false);
        return;
    }

    fetch('https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js', {
        method: 'HEAD',
        mode: 'no-cors',
        cache: 'no-store'
    }).then(function () {
        finish(false);
    }).catch(function () {
        // Sin conexión no es un bloqueador.
        finish(navigator.onLine !== false);
    });
});
</script>
