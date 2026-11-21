@extends('layout.master')

@section('title', 'Enlace expirado')

@section('content')

<section class="download-page">

    <div class="download-card" style="text-align:center;">

        <div class="download-icon">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>

        <h1 class="download-card-title">
            Enlace expirado
        </h1>

        <p class="text-center">
            Este enlace de descarga ya no es valido (expiro o ya fue usado).
            Vuelve a la pagina del juego y genera uno nuevo.
        </p>

        <a href="{{ url('juegos') }}" class="btn btn--sm btn--blue" style="display:inline-block; margin-top:16px;">
            Volver a juegos
        </a>

    </div>

</section>

@endsection