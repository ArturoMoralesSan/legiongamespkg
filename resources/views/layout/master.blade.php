<!doctype html>
<html class="no-js" lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="apple-mobile-web-app-capable"
        content="yes"
    >

    <!-- DNS prefetch -->
    <link
        rel="dns-prefetch"
        href="//fonts.googleapis.com"
    >

    <title>
        @yield('tab_title', config('app.name'))
    </title>

    <meta
        name="description"
        content="@yield('description')"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

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
        href="{{ asset('css/page.css') }}"
        rel="stylesheet"
    >

    <!-- =========================================================
         COMPONENTES
         ========================================================= -->

    <link
        href="{{ asset('css/header.css') }}"
        rel="stylesheet"
    >

    <link
        href="{{ asset('css/footer.css') }}"
        rel="stylesheet"
    >
    <link
        href="{{ asset('css/gamer-list.css') }}"
        rel="stylesheet"
    >

     <link
        href="{{ asset('css/features.css') }}"
        rel="stylesheet"
    >

    <link
        href="{{ asset('css/cards.css') }}"
        rel="stylesheet"
    >

    <link
        href="{{ asset('css/hero.css') }}"
        rel="stylesheet"
    >

    <link
        href="{{ asset('css/login.css') }}"
        rel="stylesheet"
    >

</head>

<body
    class="@yield('class') {{ auth()->check() ? 'logged' : '' }}"
    data-root="{{ url('/') }}"
>

    <div id="app">

        <div id="bar" v-cloak>
            @include('layout.user-bar')
        </div>

        @if (!Request::is('login'))
            @include('layout.header', [
                'activeLink' => view()->getSection('active_menu')
            ])
        @endif

        <main
            id="main"
            class="main"
            role="main"
        >
            @yield('content')
        </main>

        @if (!Request::is('login'))
            @include('layout.footer')
        @endif

        <site-overlay></site-overlay>

    </div>

    @includeWhen(
        view()->hasSection('has_gallery'),
        'components.gallery'
    )

    <!-- =========================================================
         SCRIPTS
         ========================================================= -->

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