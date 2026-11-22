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
                NOTAS RÁPIDAS (opcional)
            ================================================== --}}

            @if(filled($game->notes))

                <section class="game-detail-description game-detail-notes">

                    <h2>
                        <i class="fa-regular fa-note-sticky"></i>
                        Notas
                    </h2>

                    <div class="game-detail-notes__text">
                        {!! nl2br(e($game->notes)) !!}
                    </div>

                </section>

            @endif

            {{-- =================================================
                Sinopsis
            ================================================== --}}

            <section class="game-detail-description">

                <h2>
                    <i class="fa-solid fa-align-left"></i>
                    Sinopsis
                </h2>


                @if($game->synopsis)
                    <div class="game-detail-description-text">
                        {!! $game->synopsis !!}
                    </div>
                @else
                    <p class="game-detail-empty">
                        No hay una sinopsis disponible para este juego.
                    </p>
                @endif


            </section>


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
            {{-- =================================================
                GALERÍA (opcional)
            ================================================== --}}

            @if($game->images->count())

                <section class="game-detail-description game-gallery" data-game-gallery>

                    <h2>
                        <i class="fa-solid fa-images"></i>
                        Galería
                    </h2>

                    <div class="game-gallery__slider" data-gallery-slider>

                        <div class="game-gallery__viewport">

                            <div class="game-gallery__track" data-gallery-track>

                                @foreach($game->images as $galleryImage)

                                    <a
                                        href="{{ $galleryImage->url }}"
                                        class="game-gallery__slide"
                                        data-gallery-item
                                        aria-label="Ver imagen {{ $loop->iteration }} de {{ $loop->count }}"
                                    >
                                        <img
                                            src="{{ $galleryImage->url }}"
                                            alt="{{ $game->title }} - imagen {{ $loop->iteration }}"
                                            loading="{{ $loop->first ? 'eager' : 'lazy' }}"
                                        >
                                    </a>

                                @endforeach

                            </div>

                        </div>

                        @if($game->images->count() > 1)

                            <button
                                type="button"
                                class="game-gallery__nav game-gallery__nav--prev"
                                data-gallery-prev
                                aria-label="Imagen anterior"
                            >
                                <i class="fa-solid fa-chevron-left"></i>
                            </button>

                            <button
                                type="button"
                                class="game-gallery__nav game-gallery__nav--next"
                                data-gallery-next
                                aria-label="Imagen siguiente"
                            >
                                <i class="fa-solid fa-chevron-right"></i>
                            </button>

                            <div class="game-gallery__dots">

                                @foreach($game->images as $galleryImage)

                                    <button
                                        type="button"
                                        class="game-gallery__dot {{ $loop->first ? 'is-active' : '' }}"
                                        data-gallery-dot="{{ $loop->index }}"
                                        aria-label="Ir a la imagen {{ $loop->iteration }}"
                                    ></button>

                                @endforeach

                            </div>

                        @endif

                    </div>

                </section>

            @endif


            {{-- ANUNCIOS: dentro del contenido --}}

            @include('partials.ad-slot', ['position' => 'content'])


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

@section('scripts')
<script>
    (function () {
        var gallery = document.querySelector('[data-game-gallery]');
        if (!gallery) return;

        var items = Array.prototype.slice.call(gallery.querySelectorAll('[data-gallery-item]'));
        var current = 0;

        /* ---------- Slider ---------- */
        var track = gallery.querySelector('[data-gallery-track]');
        var dots = Array.prototype.slice.call(gallery.querySelectorAll('[data-gallery-dot]'));
        var slide = 0;

        function goTo(index) {
            slide = (index + items.length) % items.length;
            track.style.transform = 'translateX(-' + (slide * 100) + '%)';
            dots.forEach(function (dot, i) {
                dot.classList.toggle('is-active', i === slide);
                dot.setAttribute('aria-current', i === slide ? 'true' : 'false');
            });
        }

        var prevBtn = gallery.querySelector('[data-gallery-prev]');
        var nextBtn = gallery.querySelector('[data-gallery-next]');
        if (prevBtn) prevBtn.addEventListener('click', function () { goTo(slide - 1); });
        if (nextBtn) nextBtn.addEventListener('click', function () { goTo(slide + 1); });
        dots.forEach(function (dot) {
            dot.addEventListener('click', function () {
                goTo(parseInt(dot.getAttribute('data-gallery-dot'), 10));
            });
        });

        // Swipe en móvil
        var startX = null;
        var swiped = false;
        track.addEventListener('touchstart', function (e) {
            startX = e.touches[0].clientX;
            swiped = false;
        }, { passive: true });
        track.addEventListener('touchend', function (e) {
            if (startX === null) return;
            var dx = e.changedTouches[0].clientX - startX;
            if (Math.abs(dx) > 40 && items.length > 1) {
                swiped = true;
                goTo(dx < 0 ? slide + 1 : slide - 1);
            }
            startX = null;
        });

        /* ---------- Lightbox ---------- */

        var box = document.createElement('div');
        box.className = 'game-lightbox';
        box.innerHTML =
            '<button type="button" class="game-lightbox__close" aria-label="Cerrar">&times;</button>' +
            '<button type="button" class="game-lightbox__nav game-lightbox__nav--prev" aria-label="Anterior">&#10094;</button>' +
            '<img class="game-lightbox__img" alt="">' +
            '<button type="button" class="game-lightbox__nav game-lightbox__nav--next" aria-label="Siguiente">&#10095;</button>' +
            '<span class="game-lightbox__counter"></span>';
        document.body.appendChild(box);

        var img = box.querySelector('.game-lightbox__img');
        var counter = box.querySelector('.game-lightbox__counter');

        if (items.length < 2) {
            box.querySelectorAll('.game-lightbox__nav').forEach(function (b) { b.style.display = 'none'; });
        }

        function show(index) {
            current = (index + items.length) % items.length;
            img.src = items[current].getAttribute('href');
            counter.textContent = (current + 1) + ' / ' + items.length;
            box.classList.add('is-open');
            document.body.style.overflow = 'hidden';
        }

        function close() {
            box.classList.remove('is-open');
            document.body.style.overflow = '';
            goTo(current); // el slider queda en la última imagen vista
        }

        items.forEach(function (item, index) {
            item.addEventListener('click', function (e) {
                e.preventDefault();
                if (swiped) { swiped = false; return; }
                show(index);
            });
        });

        box.querySelector('.game-lightbox__close').addEventListener('click', close);
        box.querySelector('.game-lightbox__nav--prev').addEventListener('click', function () { show(current - 1); });
        box.querySelector('.game-lightbox__nav--next').addEventListener('click', function () { show(current + 1); });
        box.addEventListener('click', function (e) { if (e.target === box) close(); });

        document.addEventListener('keydown', function (e) {
            if (!box.classList.contains('is-open')) {
                // Flechas del teclado cuando el foco está dentro del slider
                if (gallery.contains(document.activeElement)) {
                    if (e.key === 'ArrowLeft') goTo(slide - 1);
                    if (e.key === 'ArrowRight') goTo(slide + 1);
                }
                return;
            }
            if (e.key === 'Escape') close();
            if (e.key === 'ArrowLeft') show(current - 1);
            if (e.key === 'ArrowRight') show(current + 1);
        });
    })();
</script>
@endsection
