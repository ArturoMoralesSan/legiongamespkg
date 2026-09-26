@extends('layout.dashboard-master')

{{-- Metadata --}}
@section('title', 'Editar región')
@section('tab_title', 'Editar región | ' . config('app.name'))
@section('description', 'Editar región.')
@section('css_classes', 'dashboard')

@section('content')

<section class="mb-16">
    <div class="dashboard-heading">
        <h1 class="dashboard-heading__title">
            Editar región
        </h1>
    </div>

    <div class="fluid-container mb-16">
        <p class="mb-12">
            @include('components.alert')
            <span class="color-link">«</span>
            <a href="{{ url('admin/regiones/') }}">Ver todas las regiones</a>
        </p>
            <base-form 
                action="{{ url('admin/regiones/'.$regione->id) }}"
                method="PUT"
                enctype="multipart/form-data"
                inline-template
                v-cloak
            >
                <form>
                    <section class="db-panel">
                        <h3 class="db-panel__title">
                            Datos de regiones
                        </h3>

                        <div class="md:row">
                            <div class="md:col-2/3">
                                <div class="form-control">
                                    <label for="name">Nombre</label>
                                    <text-field name="name" v-model="fields.name" maxlength="100" initial="{{ $regione->name }}"></text-field>
                                    <field-errors name="name"></field-errors>
                                </div>
                            </div>
                        </div>
                    </section>

                    <div class="text-center">
                        <form-button class="btn--blue--dashboard btn--wide">
                            Actualizar
                        </form-button>
                    </div>
                </form>
            </user-form>
    </div>
</section>

@endsection
