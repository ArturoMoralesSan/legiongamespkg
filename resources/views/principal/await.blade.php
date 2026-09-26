@extends('layout.master')

@section('title', 'Preparando descarga')

@section('content')

<section class="download-page">

    <div class="download-card">

        <div class="download-icon">

            <i class="fa-solid fa-download"></i>

        </div>

        <h1 class="download-card-title">

            {{ $downloadTitle ?? $game->title }}

        </h1>

        <p class="text-center">

            Estamos preparando tu descarga.

        </p>

        <div class="countdown">

            <div class="timer-circle">

                <div class="timer-value">

                    <span id="timer">20</span>

                    <small>SEGUNDOS</small>

                </div>

            </div>

        </div>

        <div class="game-info">

            <div class="info-box">

                <strong>Juego</strong>

                <span>

                    {{ $game->title }}

                </span>

            </div>

            <div class="info-box">

                <strong>Tamaño</strong>

                <span>

                    {{ $game->size_mb ?? '--' }}

                </span>

            </div>

            <div class="info-box">

                <strong>Plataformas</strong>

                <div class="platforms">

                    @foreach($game->platforms as $platform)

                        <span class="tag">

                            {{ $platform->name }}

                        </span>

                    @endforeach

                </div>

            </div>

            <div class="info-box">

                <strong>Categorías</strong>

                <div class="platforms">

                    @foreach($game->categories as $category)

                        <span class="tag">

                            {{ $category->name }}

                        </span>

                    @endforeach

                </div>

            </div>

        </div>

        {{-- BOTÓN MANUAL --}}

        <a
            id="manualDownload"
            href="{{ $downloadUrl }}"
            class="hero-btn"
            style="display:none"
        >

            <span>

                <i class="fa-solid fa-download"></i>

                Descargar ahora

            </span>

        </a>

    </div>

</section>

@endsection


@section('scripts')

<script>

    let seconds = 20;

    const timer = document.getElementById('timer');

    const manualDownload = document.getElementById('manualDownload');

    const downloadUrl = @json($downloadUrl);

    const interval = setInterval(function () {

        seconds--;

        timer.textContent = seconds;

        if (seconds <= 0) {

            clearInterval(interval);

            /*
             * Mostrar botón por si la redirección
             * tarda o el navegador la bloquea.
             */
            manualDownload.style.display = 'inline-flex';

            /*
             * Redirigir automáticamente.
             */
            window.location.href = downloadUrl;

        }

    }, 1000);

</script>

@endsection