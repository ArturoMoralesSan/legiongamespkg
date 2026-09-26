@extends('layout.master')

@section('title', config('app.name'))
@section('description', '')
@section('canonical', config('app.url'))
@section('class', 'home')

@section('content')

{{-- HERO --}}
<section id="inicio" class="hero-home">

    <hero
        background-image="{{ asset('img/banner4.jpeg') }}"
        :is-parallax-active="true"
        hero-height="35vh"
    >
        <template slot="container">
            <div class="hero-grid-center">
                <div class="hero-left">
                    <h1 class="hero-title text-center">
                        REGIONES
                    </h1>
                </div>
            </div>
        </template>
    </hero>
</section>
<section class="features-section">
    <div class="container">
        <div class="row">
            <div class="md:col-2/3 col">
                <div class="platforms-section">

                    <div class="platform-grid">

                        @foreach($regionsgames as $region)
                            <div class="platform-card">
                                <div class="platform-icon">
                                    <i class="fa-solid fa-earth-americas"></i>
                                </div>

                                <div class="platform-name">
                                    {{ $region->name }}
                                </div>

                                <div class="platform-count">
                                    <a href="{{ url('/juegos?region=' . $region->id) }}">
                                        {{ number_format($region->games_count) }}
                                        Juegos
                                    </a>
                                </div>

                            </div>
                        @endforeach

                    </div>

                </div>
            </div>
            {{-- SIDEBAR --}}
            <div class="md:col-1/3 col">
                @include('partials.sidebar')
            </div>
        </div>
    </div>

</section>

@endsection