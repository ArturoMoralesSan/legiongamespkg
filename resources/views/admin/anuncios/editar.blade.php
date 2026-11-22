@extends('layout.dashboard-master')

@section('title', 'Editar anuncio')
@section('tab_title', 'Editar anuncio | ' . config('app.name'))
@section('description', 'Editar anuncio')
@section('css_classes', 'dashboard')

@section('content')

<section class="mb-16">

    <div class="dashboard-heading">
        <h1 class="dashboard-heading__title">
            Editar anuncio
        </h1>
    </div>

    <div class="fluid-container mb-16">

        @include('components.alert')

        <p class="mb-12">
            <span class="color-link">«</span>
            <a href="{{ url('admin/anuncios') }}">Ver todos los anuncios</a>
        </p>

        @include('admin.anuncios._form', [
            'action' => url('admin/anuncios/' . $anuncio->id),
            'method' => 'PUT',
            'submitLabel' => 'Actualizar anuncio',
        ])

    </div>

</section>

@endsection
