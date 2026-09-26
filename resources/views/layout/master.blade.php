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

        <style>
            
            /* =========================
                BASE GAMER DARK
            ========================= */
            body {
                background: radial-gradient(circle at top, #0b1430 0%, #070b1a 60%);
                color: #e5e7eb;
            }

            i,
            svg,
            .icon,
            [class*="icon"] {
                color: transparent;

                background: linear-gradient(135deg, #3b82f6, #a855f7);
                -webkit-background-clip: text;
                background-clip: text;

                text-shadow:
                    0 0 8px rgba(59,130,246,0.35),
                    0 0 14px rgba(168,85,247,0.25);

                transition: all 0.2s ease;
            }

            body.home .user-bar {
                align-items: center;
                background-color: #0B1421;
                display: flex;
                width: 100%;
                height: 60px;
                justify-content: space-between;
                position: fixed;
                top: 0;
                z-index: 5;
            }

            body.logged .main-header {
                top: 60px;
            }
            .details-btn {
                align-items: center;
                background: rgba(59, 130, 246, 0.08);
                border: 1px solid rgba(168, 85, 247, 0.25);
                border-radius: 12px;
                color: #a855f7;
                display: flex;
                height: 42px;
                justify-content: center;
                text-decoration: none;
                transition: 0.3s ease;
                width: 42px;
            }

            .details-btn:hover {
                background: rgba(168, 85, 247, 0.15);
                border-color: #a855f7;
                box-shadow:
                    0 0 8px rgba(168, 85, 247, 0.6),
                    0 0 20px rgba(168, 85, 247, 0.4),
                    0 0 35px rgba(59, 130, 246, 0.25);
                color: #fff;
                transform: translateY(-2px);
            }

            .details-btn i {
                transition: 0.3s ease;
            }

            .details-btn:hover i {
                filter: drop-shadow(0 0 6px #a855f7);
            }

            .game-detail-description-text,
            .game-detail-description-text p,
            .game-detail-description-text span,
            .game-detail-description-text div,
            .game-detail-description-text strong,
            .game-detail-description-text em,
            .game-detail-description-text b,
            .game-detail-description-text i {
                color: #FFFFFF !important;
            }
        </style>
        <!-- Icons -->
        @include('layout.icons')

        <!-- CSS -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i&display=swap" rel="stylesheet">
        <link href="{{ version('css/main.css') }}" rel="stylesheet">
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" rel="stylesheet">
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
</html>
