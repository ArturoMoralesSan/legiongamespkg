@extends('layout.master')

@section('title', $game->title . ' | ' . config('app.name'))
@section('description', $game->description ?? '')
@section('canonical', url('/juegos/' . $game->id))
@section('class', 'game-detail-page')

@section('content')

{{-- =====================================================
    HERO
===================================================== --}}

<hero
    background-image="{{ asset('img/banner4.jpeg') }}"
    :is-parallax-active="true"
    hero-height="35vh"
>
    <template slot="container">

        <div class="hero-grid-center">

            <div class="hero-left">

                <span class="game-detail-hero-label">
                    VIDEOJUEGO
                </span>

                <h1 class="hero-title text-center">
                    {{ $game->title }}
                </h1>

            </div>

        </div>

    </template>
</hero>


{{-- =====================================================
    CONTENIDO
===================================================== --}}

<div class="container">

    <div class="row">

        {{-- =================================================
            CONTENIDO PRINCIPAL
        ================================================== --}}

        <div class="md:col-2/3 col">

            {{-- VOLVER --}}

            <a
                href="{{ url('/juegos') }}"
                class="game-detail-back"
            >
                <i class="fa-solid fa-arrow-left"></i>
                Volver a juegos
            </a>


            {{-- =================================================
                INFORMACIÓN PRINCIPAL
            ================================================== --}}

            <div class="game-detail-main">

                {{-- PORTADA --}}

                <div class="game-detail-cover">

                    @if($game->image)

                        <img
                            src="{{ asset('uploads/games/' . $game->image) }}"
                            alt="{{ $game->title }}"
                        >

                    @else

                        <div class="game-detail-placeholder">

                            <i class="fa-solid fa-gamepad"></i>

                        </div>

                    @endif

                </div>


                {{-- DATOS --}}

                <div class="game-detail-info">

                    <span class="game-detail-label">
                        VIDEOJUEGO
                    </span>

                    <h2 class="game-detail-title">
                        {{ $game->title }}
                    </h2>


                    {{-- PLATAFORMAS --}}

                    @if($game->platforms->count())

                        <div class="game-detail-section">

                            <span class="game-detail-section-title">
                                <i class="fa-solid fa-gamepad"></i>
                                Plataformas
                            </span>

                            <div class="game-detail-tags">

                                @foreach($game->platforms as $platform)

                                    <span class="game-detail-tag">
                                        {{ $platform->name }}
                                    </span>

                                @endforeach

                            </div>

                        </div>

                    @endif


                    {{-- CATEGORÍAS --}}

                    @if($game->categories->count())

                        <div class="game-detail-section">

                            <span class="game-detail-section-title">
                                <i class="fa-solid fa-layer-group"></i>
                                Categorías
                            </span>

                            <div class="game-detail-tags">

                                @foreach($game->categories as $category)

                                    <span class="game-detail-tag">
                                        {{ $category->name }}
                                    </span>

                                @endforeach

                            </div>

                        </div>

                    @endif


                    {{-- TAMAÑO --}}

                    @if($game->size_mb)

                        <div class="game-detail-data">

                            <span>
                                <i class="fa-solid fa-hard-drive"></i>
                                Tamaño
                            </span>

                            <strong>
                                {{ $game->size_mb }}
                            </strong>

                        </div>

                    @endif


                    {{-- AÑO --}}

                    @if(isset($game->year) && $game->year)

                        <div class="game-detail-data">

                            <span>
                                <i class="fa-regular fa-calendar"></i>
                                Año
                            </span>

                            <strong>
                                {{ $game->year }}
                            </strong>

                        </div>

                    @endif


                    {{-- REGIÓN --}}

                    @if(isset($game->region) && $game->region)

                        <div class="game-detail-data">

                            <span>
                                <i class="fa-solid fa-earth-americas"></i>
                                Región
                            </span>

                            <strong>
                                {{ $game->region }}
                            </strong>

                        </div>

                    @endif

                </div>

            </div>


            {{-- =================================================
                DESCRIPCIÓN
            ================================================== --}}

            <section class="game-detail-description">

                <h2>
                    <i class="fa-solid fa-align-left"></i>
                    Descripción
                </h2>


                @if($game->description)
                    <div class="game-detail-description-text">
                        {!! $game->description !!}
                    </div>
                @else
                    <p class="game-detail-empty">
                        No hay una descripción disponible para este juego.
                    </p>
                @endif


            </section>
            <section class="game-detail-description mb-4">

                <h2>
                    <i class="fa-solid fa-align-left"></i>
                    Descarga
                </h2>

                <div class="game-download-grid">

                    {{-- =================================================
                        DESCARGA PRINCIPAL
                    ================================================== --}}

                    @if($game->url_game)

                        <a
                            href="{{ route('download.show', $game) }}"
                            class="download-btn"
                        >
                            <i class="fa-solid fa-download"></i>

                            <span>
                                Descargar juego
                            </span>
                        </a>

                    @endif


                    {{-- =================================================
                        ENLACES ADICIONALES
                    ================================================== --}}

                    @foreach($game->links as $link)

                        <a
                            href="{{ route('download.link', [
                                'game' => $game->id,
                                'link' => $link->id
                            ]) }}"
                            class="download-btn"
                        >

                            <i class="fa-solid fa-download"></i>

                            <span>
                                {{ $link->title }}
                            </span>

                        </a>

                    @endforeach

                </div>

            </section>

        </div>


        {{-- =================================================
            SIDEBAR
        ================================================== --}}

        <div class="md:col-1/3 col">

            @include('partials.sidebar')

        </div>

    </div>

</div>

@endsection