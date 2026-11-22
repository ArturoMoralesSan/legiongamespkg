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

            {{-- ANUNCIOS: arriba, izquierda y derecha --}}
            @include('partials.ad-slot', ['position' => 'top'])
            @include('partials.ad-slot', ['position' => 'left'])
            @include('partials.ad-slot', ['position' => 'right'])

            <main id="main" class="main" role="main">
                @yield('content')
            </main>

            {{-- ANUNCIOS: al final --}}
            @include('partials.ad-slot', ['position' => 'bottom'])

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

        {{-- ANUNCIOS flotantes + motor de anuncios (fuera de #app para que Vue no lo toque).
             Se configuran en Panel > Publicidad > Anuncios. --}}
        @include('partials.ad-slot', ['position' => 'modal'])
        @include('partials.ad-slot', ['position' => 'anchor'])
        @include('partials.ad-slot', ['position' => 'global'])
        @include('partials.adblock-detect')
        @include('partials.ad-runtime')
        @include('partials.adblock-notice')
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
    

    {{-- Reset global (antes venía dentro del CSS del anuncio ancla) --}}
    <style>*, *:before, *:after { box-sizing: border-box; }</style>
    
</html>