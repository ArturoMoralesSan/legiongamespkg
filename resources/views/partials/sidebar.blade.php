<aside class="sidebar"> 

    {{-- SÍGUENOS --}} 
    <div class="sidebar-card"> 
        <h6 class="sidebar-title"> <i class="fa-solid fa-heart-circle-plus"></i> Síguenos</h6> 
        <div class="social-grid"> 
            <a class="brand__social--link" href="https://www.facebook.com/Legiongamesgodrgh/"><i class="fa-brands fa-square-facebook"></i></a> 
            <a class="brand__social--link" href="https://www.youtube.com/@legiongamesgod"><i class="fa-brands fa-youtube"></i></a> 
            <a class="brand__social--link" href="https://t.me/+B9y0Czn8Hcc3N2Jh"><i class="fa-brands fa-telegram"></i></a> 
        </div> 
    </div> 

    <!-- ANUNCIO RX BANNER -->
    <style>
        .ad-sidebar-card {
            position: relative;
            display: none; 
            padding: 10px;
            overflow: hidden;
            text-align: center;
        }

        .ad-sidebar-content {
            position: relative;
            width: 100%;
        }

        .ad-sidebar-close-btn {
            position: absolute;
            top: -2px;
            right: 0px;
            background: #ef4444;
            color: #ffffff;
            border: none;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            font-size: 11px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            transition: background 0.2s ease;
            -webkit-tap-highlight-color: transparent;
        }

        .ad-sidebar-close-btn:hover,
        .ad-sidebar-close-btn:active {
            background: #dc2626;
        }

        .ad-sidebar-frame {
            border: none;
            width: 100%;
            height: 250px;
            min-height: 250px;
            overflow: hidden;
            display: block;
            background: transparent;
        }
    </style>

    <div class="sidebar-card ad-sidebar-card" id="adSidebarCard">
        <div class="ad-sidebar-content">
            <button class="ad-sidebar-close-btn" onclick="closeSidebarAd()" title="Cerrar anuncio">✕</button>
            <iframe id="adSidebarFrame" class="ad-sidebar-frame" scrolling="no"></iframe>
        </div>
    </div>

    <script>
        (function() {
            const adScriptUrl = "\/\/untimely-hello.com\/b\/XNV.sPdYGfl\/0\/Y\/WpcG\/zeomS9zu_ZMUBlMknPxTVcaz_O\/TgIu4SNNT_Mqt\/N\/zMMw5CMpj\/gZ1HNBwZ";
            const refreshIntervalMs = 20000; 
            const reopenDelayMs = 20000;     

            let refreshTimer = null;
            let reopenTimer = null;
            let fallbackTimer = null;

            window.showSidebarAd = function() {
                const card = document.getElementById('adSidebarCard');
                if (card && card.style.display !== 'block') {
                    card.style.display = 'block';
                }
            };

            function loadSidebarAd() {
                const iframe = document.getElementById('adSidebarFrame');
                const card = document.getElementById('adSidebarCard');
                if (!iframe || !card) return;

                card.style.display = 'none';
                if (fallbackTimer) clearTimeout(fallbackTimer);

                
                fallbackTimer = setTimeout(() => {
                    window.showSidebarAd();
                }, 1200);

                const iframeContent = `
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <style>
                            html, body { 
                                margin: 0; 
                                padding: 0; 
                                text-align: center; 
                                background: transparent; 
                                width: 100%;
                                overflow: hidden;
                            }
                            img, iframe, div { max-width: 100% !important; }
                        </style>
                    </head>
                    <body>
                        <script data-cfasync="false" src="${adScriptUrl}"><\/script>
                        <script>
                            (function() {
                                function notifyParent() {
                                    try {
                                        if (window.parent && window.parent.showSidebarAd) {
                                            window.parent.showSidebarAd();
                                        }
                                    } catch(e) {}
                                }
                                window.addEventListener('load', notifyParent);
                                setTimeout(notifyParent, 400);
                            })();
                        <\/script>
                    </body>
                    </html>
                `;

                iframe.srcdoc = iframeContent;
            }

            function startAutoRefresh() {
                if (refreshTimer) clearInterval(refreshTimer);
                refreshTimer = setInterval(loadSidebarAd, refreshIntervalMs);
            }

            loadSidebarAd();
            startAutoRefresh();

            window.closeSidebarAd = function() {
                const card = document.getElementById('adSidebarCard');
                if (!card) return;

                card.style.display = 'none';

                if (refreshTimer) clearInterval(refreshTimer);
                if (reopenTimer) clearTimeout(reopenTimer);
                if (fallbackTimer) clearTimeout(fallbackTimer);

                reopenTimer = setTimeout(() => {
                    loadSidebarAd();
                    startAutoRefresh();
                }, reopenDelayMs);
            };
        })();
    </script>
    

    {{-- ESTADÍSTICAS --}} 
    <div class="sidebar-card"> 
        <h6 class="sidebar-title"><i class="fa-solid fa-chart-simple"></i> Biblioteca Gamer</h6> 
        <div class="stats"> 
            <div class="stat-item"> <span>Juegos</span> <b>{{ $stats['games'] ?? 0 }}</b> </div> 
            <div class="stat-item"> <span>Plataformas</span> <b>{{ $stats['platforms'] ?? 0 }}</b> </div> 
            <div class="stat-item"> <span>Categorias</span> <b>{{ $stats['categories'] ?? 0 }}</b> </div> 
        </div> 
    </div> 

</aside>
