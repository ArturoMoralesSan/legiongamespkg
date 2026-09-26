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
                        CATEGORIAS
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

                        @foreach($categoriesgames as $category)
                            <div class="platform-card">
                                <div class="platform-icon">
                                    <i class="fa-solid fa-table-list"></i>
                                </div>

                                <div class="platform-name">
                                    {{ $category->name }}
                                </div>

                                <div class="platform-count">
                                    <a href="{{ url('/juegos?category=' . $category->id) }}">
                                        {{ number_format($category->games_count) }}
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