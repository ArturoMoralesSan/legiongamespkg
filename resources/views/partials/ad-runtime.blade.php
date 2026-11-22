{{--
    Motor de anuncios. Lee los <template data-ad> generados por
    partials/ad-slot y los muestra con el comportamiento definido en el panel:

    - data-iframe   : carga el código dentro de un iframe (srcdoc), aislado
                      de la página. Así funcionaban los anuncios RX.
    - data-height   : alto del iframe en px.
    - data-closable : agrega botón ✕.
    - data-delay    : segundos antes de mostrarse la primera vez.
    - data-refresh  : cada cuántos segundos se recarga (0 = nunca).
    - data-reopen   : segundos para reaparecer tras cerrarlo (0 = no vuelve).

    Si hay bloqueador de anuncios (window.adBlockCheck, ver
    partials/adblock-detect) no se monta ningún anuncio, para no dejar
    cajas vacías. Si el script de un anuncio no carga, ese anuncio se oculta.
--}}
@stack('ad-templates')

<script>
(function () {
    var templates = document.querySelectorAll('template[data-ad]');

    if (!templates.length) return;

    function num(value) {
        return parseInt(value, 10) || 0;
    }

    /* Inserta HTML en la página recreando los <script> para que se ejecuten. */
    function injectHtml(target, tpl, onFail) {
        var fragment = tpl.content.cloneNode(true);

        Array.prototype.forEach.call(fragment.querySelectorAll('script'), function (old) {
            var script = document.createElement('script');

            Array.prototype.forEach.call(old.attributes, function (attr) {
                script.setAttribute(attr.name, attr.value);
            });

            if (old.src) {
                script.async = old.hasAttribute('async');
                script.onerror = onFail;
            }
            script.text = old.textContent;
            old.parentNode.replaceChild(script, old);
        });

        target.innerHTML = '';
        target.appendChild(fragment);
    }

    /* Carga el código dentro de un iframe aislado (igual que antes). */
    function injectIframe(target, tpl, height, onFail) {
        var iframe = document.createElement('iframe');

        // El iframe (srcdoc) es del mismo origen: su script avisa con este
        // evento si algún <script> del anuncio no se pudo cargar.
        iframe.addEventListener('adfailed', onFail);

        iframe.className = 'ad-frame';
        iframe.setAttribute('scrolling', 'no');
        iframe.setAttribute('frameborder', '0');
        if (height) iframe.style.height = height + 'px';

        iframe.srcdoc =
            '<!DOCTYPE html><html lang="es"><head>' +
            '<meta name="viewport" content="width=device-width, initial-scale=1.0">' +
            '<base target="_blank">' +
            '<style>html,body{margin:0;padding:0;width:100%;text-align:center;background:transparent;overflow:hidden}' +
            'img,iframe,div{max-width:100%!important}</style>' +
            '<script>window.addEventListener("error",function(e){var t=e.target;' +
            'if(t&&t.tagName==="SCRIPT"&&t.src){try{window.frameElement.dispatchEvent(new Event("adfailed"))}catch(_){}}},true);<\/script>' +
            '</head><body>' + tpl.innerHTML + '</body></html>';

        target.innerHTML = '';
        target.appendChild(iframe);
    }

    /* Construye el contenedor visible de cada anuncio según su posición. */
    function buildBox(position, closable) {
        var box, content;

        if (position === 'modal') {
            box = document.createElement('div');
            box.className = 'ad-modal';
            box.innerHTML = '<div class="ad-modal__card"><div class="ad-modal__content"></div></div>';
            document.body.appendChild(box);
            content = box.querySelector('.ad-modal__content');
        }
        else if (position === 'anchor') {
            box = document.createElement('div');
            box.className = 'ad-anchor';
            box.innerHTML = '<div class="ad-anchor__content"><div class="ad-anchor__inner"></div></div>';
            document.body.appendChild(box);
            content = box.querySelector('.ad-anchor__inner');
        }
        else if (position === 'global') {
            // Sólo ejecuta el script (pop-under, push…): nada visible.
            box = document.createElement('div');
            box.className = 'ad-global';
            box.hidden = true;
            document.body.appendChild(box);
            return { box: box, content: box };
        }
        else {
            var slot = document.querySelector('[data-ad-slot="' + position + '"]');

            if (!slot) return null;

            box = document.createElement('div');
            box.className = 'ad-slot__item';
            content = document.createElement('div');
            content.className = 'ad-slot__content';
            box.appendChild(content);
            slot.appendChild(box);
            slot.classList.add('is-loaded');
        }

        if (closable) {
            var close = document.createElement('button');

            close.type = 'button';
            close.className = 'ad-close';
            close.title = 'Cerrar anuncio';
            close.setAttribute('aria-label', 'Cerrar anuncio');
            close.innerHTML = position === 'modal' ? 'Cerrar ✕' : '✕';
            var closeHolder =
                position === 'modal' ? box.querySelector('.ad-modal__card') :
                position === 'anchor' ? box.querySelector('.ad-anchor__content') :
                box;

            closeHolder.appendChild(close);
            box.closeButton = close;
        }

        return { box: box, content: content };
    }

    function mount(tpl) {
        var position = tpl.getAttribute('data-position');
        var useIframe = tpl.getAttribute('data-iframe') === '1';
        var height = num(tpl.getAttribute('data-height'));
        var closable = tpl.getAttribute('data-closable') === '1';
        var delay = num(tpl.getAttribute('data-delay')) * 1000;
        var refresh = num(tpl.getAttribute('data-refresh')) * 1000;
        var reopen = num(tpl.getAttribute('data-reopen')) * 1000;

        if (position === 'global') {
            useIframe = false;
            closable = false;
            refresh = 0;
            reopen = 0;
        }

        var parts = buildBox(position, closable);

        if (!parts) return;

        var refreshTimer = null;
        var reopenTimer = null;
        var failed = false;

        /* El anuncio no cargó (bloqueado o caído): se quita y no vuelve. */
        function fail() {
            if (failed) return;
            failed = true;
            clearInterval(refreshTimer);
            clearTimeout(reopenTimer);
            parts.box.classList.remove('is-open');
            parts.content.innerHTML = '';

            if (position === 'modal' || position === 'anchor') {
                parts.box.parentNode && parts.box.parentNode.removeChild(parts.box);
            }
        }

        function render() {
            if (failed) return;

            if (useIframe) {
                injectIframe(parts.content, tpl, height, fail);
            } else {
                injectHtml(parts.content, tpl, fail);
            }
        }

        function show() {
            if (failed) return;
            render();
            parts.box.classList.add('is-open');

            if (refresh) {
                clearInterval(refreshTimer);
                refreshTimer = setInterval(render, refresh);
            }
        }

        function hide() {
            parts.box.classList.remove('is-open');
            clearInterval(refreshTimer);
            clearTimeout(reopenTimer);
            parts.content.innerHTML = '';

            if (reopen) {
                reopenTimer = setTimeout(show, reopen);
            }
        }

        if (parts.box.closeButton) {
            parts.box.closeButton.addEventListener('click', hide);
        }

        if (delay) {
            setTimeout(show, delay);
        } else {
            show();
        }
    }

    function start() {
        // Las ventanas modales esperan a que cargue la página (como antes).
        if (document.readyState === 'complete') {
            Array.prototype.forEach.call(templates, mount);
            return;
        }

        Array.prototype.forEach.call(templates, function (tpl) {
            if (tpl.getAttribute('data-position') !== 'modal') mount(tpl);
        });

        window.addEventListener('load', function () {
            Array.prototype.forEach.call(templates, function (tpl) {
                if (tpl.getAttribute('data-position') === 'modal') mount(tpl);
            });
        }, { once: true });
    }

    /* Con bloqueador no se muestra nada (ni cajas vacías). */
    function removeSlots() {
        Array.prototype.forEach.call(document.querySelectorAll('[data-ad-slot]'), function (slot) {
            slot.parentNode && slot.parentNode.removeChild(slot);
        });
    }

    (window.adBlockCheck || Promise.resolve(false)).then(function (blocked) {
        if (blocked) {
            removeSlots();
        } else {
            start();
        }
    });
})();
</script>
