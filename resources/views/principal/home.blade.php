@extends('layout.master')

@section('title', config('app.name'))
@section('description', '')
@section('canonical', config('app.url'))
@section('class', 'home')

@section('content')

{{-- HERO --}}
<section id="inicio" class="hero-home">

    <hero
        background-image="{{ asset('img/banner1.jpeg') }}"
        :is-parallax-active="true"
        hero-height="70vh"
    >
        <template slot="container">
            <div class="hero-grid">
                <div class="hero-left">
                    <span class="hero-subtitle">
                        BIENVENIDO A
                    </span>

                    <h1 class="hero-title">
                        LEGIONGAMESPKG
                    </h1>

                    <p class="hero-description">
                        Tu mejor fuente de juegos para Playstation.
                        Descargas directas, rápidas y sin límites.
                    </p>

                    <div class="hero-search">
                        <form action="{{ url('juegos') }}" method="GET" class="hero-search-form">

                            <i class="fa-solid fa-magnifying-glass"></i>

                            <input
                                type="text"
                                name="search"
                                placeholder="Buscar juegos..."
                                autocomplete="off"
                            >

                            <button type="submit">
                                Buscar
                            </button>

                        </form>
                    </div>
                </div>
            </div>
        </template>
    </hero>
</section>

{{-- FEATURES --}}
<!-- <section class="features-section">
    <div class="container">
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-download"></i></div>
                <div>
                    <h4>Descargas Directas</h4>
                    <p>Enlaces rápidos y seguros</p>
                </div>
            </div>

            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-shield"></i></div>
                <div>
                    <h4>Sin Límites</h4>
                    <p>Descarga sin restricciones</p>
                </div>
            </div>

            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-gamepad"></i></div>

                <div>
                    <h4>Juegos Optimizados</h4>
                    <p>Listos para Xbox 360 RGH</p>
                </div>
            </div>

            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-bolt"></i></div>
                <div>
                    <h4>Actualizaciones</h4>
                    <p>DLCs, parches y más</p>
                </div>
            </div>

        </div>

    </div>

</section> -->
<section class="features-section">
    <div class="container">
        <h6 class="gamelist--title  text-center mb-4">
            Plataformas NPS
        </h6>
        <div class="platform-grid">

            @foreach($platformsgames as $platform)
                <div class="platform-card">

                    <div class="platform-icon">
                        @switch(strtolower($platform->name))

                            @case('psp')
                                <i class="fa-solid fa-mobile-screen"></i>
                                @break

                            @case('psvita')
                            @case('ps vita')
                                <i class="fa-solid fa-gamepad"></i>
                                @break

                            @case('psx')
                            @case('ps1')
                                <i class="fa-solid fa-compact-disc"></i>
                                @break

                            @case('ps2')
                                <i class="fa-solid fa-compact-disc"></i>
                                @break

                            @case('ps3')
                                <i class="fa-solid fa-gamepad"></i>
                                @break

                            @case('ps4')
                                <i class="fa-solid fa-gamepad"></i>
                                @break

                            @default
                                <i class="fa-solid fa-tv"></i>
                        @endswitch
                    </div>

                    <div class="platform-name">
                        {{ $platform->name }}
                    </div>

                    <div class="platform-count">
                        <a href="{{ url('/plataforma/' . $platform->id .'/alfabeto') }}">
                            {{ number_format($platform->games_count) }}
                            Juegos
                        </a>
                    </div>

                </div>
            @endforeach

        </div>
    </div>
</section>
<section class="features-section">
    <div class="container">
        <div class="row">
            {{-- LISTA --}}
            <div class="md:col-2/3 col">
                @include('partials.gamelist')
            </div>
            {{-- SIDEBAR --}}
            <div class="md:col-1/3 col">
                @include('partials.sidebar')
            </div>
        </div>
    </div>

</section>

@endsection