@extends('layout.master')

@section('title', $platform->name)
@section('description', '')
@section('canonical', config('app.url'))
@section('class', 'platform-alphabet')

@section('content')

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
                        {{ strtoupper($platform->name) }}
                    </h1>

                    <p class="text-center mt-2">
                        Selecciona una letra
                    </p>

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
                        @foreach($alphabet as $letter)
                            @php
                                $count = $letters[$letter] ?? 0;
                            @endphp

                            <div class="platform-card {{ $count ? '' : 'disabled-card' }}">

                                
                                @if($count)
                                    <a href="{{ url('/juegos?platform=' . $platform->id . '&letter=' . $letter) }}">
                                @endif


                                <div class="platform-icon image">

                                    @if(file_exists(public_path('img/alphabet/'.$letter.'.png')))
                                        <img
                                            src="{{ asset('img/alphabet/'.$letter.'.png') }}"
                                            class="letter-image"
                                            alt="{{ $letter }}"
                                        >
                                    @else
                                        <span class="letter-placeholder">
                                            {{ $letter }}
                                        </span>
                                    @endif

                                </div>

                                <div class="platform-count">
                                    {{ number_format($count) }} Juegos
                                </div>

                                @if($count)
                                    </a>
                                @endif

                            </div>

                        @endforeach

                    </div>

                </div>

            </div>

            <div class="md:col-1/3 col">
                @include('partials.sidebar')
            </div>

        </div>
    </div>
</section>

@endsection