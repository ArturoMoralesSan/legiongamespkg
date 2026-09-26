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
                        PLATAFORMAS
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
                                    <a href="{{ url('/juegos?platform=' . $platform->id) }}">
                                        {{ number_format($platform->games_count) }}
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