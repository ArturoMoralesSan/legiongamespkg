@extends('layout.master')

@section('title', config('app.name'))
@section('description', '')
@section('canonical', config('app.url'))
@section('class', 'home')

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
                        JUEGOS
                    </h1>
                </div>
            </div>
        </template>
    </hero>
</section>
{{-- CATALOGO --}}
<section id="juegos" class="catalog-section section__xl">
    
    <div class="container">
        <game-catalog
            :platforms='@json($platforms)'
            :categories='@json($categories)'
            :initial-games='@json($games)'
        ></game-catalog>

    </div>

</section>

@endsection