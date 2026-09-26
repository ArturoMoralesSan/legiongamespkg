@extends('layout.dashboard-master')

@section('title', 'Crear juego')
@section('tab_title', 'Crear juego | ' . config('app.name'))
@section('description', 'Crear juego')
@section('css_classes', 'dashboard')

@section('content')

<section class="mb-16">

    <div class="dashboard-heading">

        <h1 class="dashboard-heading__title">
            Crear juego
        </h1>

    </div>

    <div class="fluid-container mb-16">

        @include('components.alert')

        <p class="mb-12">

            <span class="color-link">«</span>

            <a href="{{ url('admin/juegos') }}">
                Ver todos los juegos
            </a>

        </p>

        <base-form
            action="{{ url('admin/juegos') }}"
            method="POST"
            enctype="multipart/form-data"
            inline-template
            v-cloak
        >

            <form>

                <section class="db-panel mb-16">

                    <h3 class="db-panel__title">
                        Información del juego
                    </h3>

                    <div class="md:row">

                        <div class="md:col-2/3">

                            <div class="form-control">

                                <label>Título</label>

                                <text-field
                                    name="title"
                                    v-model="fields.title"
                                ></text-field>

                                <field-errors name="title"></field-errors>

                            </div>

                        </div>

                        <div class="md:col-1/3">

                            <div class="form-control">

                                <label>Tamaño</label>

                                <text-field
                                    name="size_mb"
                                    v-model="fields.size_mb"
                                ></text-field>

                                <field-errors name="size_mb"></field-errors>

                            </div>

                        </div>

                        <div class="md:col">

                            <div class="form-control">

                                <label>
                                    URL Descarga principal
                                </label>

                                <text-field
                                    name="url_game"
                                    v-model="fields.url_game"
                                ></text-field>

                                <field-errors name="url_game"></field-errors>

                            </div>

                        </div>

                        <div class="md:col">

                            <div class="form-control">

                                <label>Descripción</label>

                                <text-area-tiny
                                    name="description"
                                    v-model="fields.description"
                                    rows="5"
                                ></text-area-tiny>

                                <field-errors name="description"></field-errors>

                            </div>

                        </div>
                        <div class="md:col">

                            <div class="form-control">

                                <label>Sinopsis</label>

                                <text-area-tiny
                                    name="synopsis"
                                    v-model="fields.synopsis"
                                    rows="5"
                                ></text-area-tiny>

                                <field-errors name="synopsis"></field-errors>

                            </div>

                        </div>

                    </div>

                </section>


                {{-- ENLACES ADICIONALES --}}

                <section class="db-panel mb-16">

                    <h3 class="db-panel__title">
                        Enlaces adicionales
                    </h3>

                    <p class="description color-gray-darken-1 mb-6">
                        Agrega enlaces adicionales para este juego,
                        por ejemplo DLC, actualizaciones, parches,
                        expansiones o contenido adicional.
                    </p>

                    <game-links-form
                        :fields="fields"
                        :errors="errors"
                    ></game-links-form>

                </section>


                {{-- PORTADA --}}

                <section class="db-panel mb-16">

                    <h3 class="db-panel__title">
                        Portada
                    </h3>

                    <div class="md:row">

                        <div class="md:col-2/3">

                            <div class="form-control">

                                <label for="image">
                                    Agregar imagen
                                </label>

                                <file-field
                                    name="image"
                                    v-model="fields.image"
                                ></file-field>

                                <field-errors name="image"></field-errors>

                                <ul class="description color-gray-darken-1">

                                    <li>
                                        Tamaño máximo: 4 MB.
                                    </li>

                                    <li>
                                        Sólo archivos jpeg, jpg, png o webp.
                                    </li>

                                </ul>

                            </div>

                        </div>

                    </div>

                </section>


                {{-- CLASIFICACIÓN --}}

                <section class="db-panel mb-16">

                    <h3 class="db-panel__title">
                        Clasificación
                    </h3>

                    <div class="md:row">

                        <div class="md:col-1/2">

                            <multi-select-field
                                name="platforms[]"
                                label="Plataformas"
                                v-model="fields.platforms"
                                :options='@json($platforms)'
                            ></multi-select-field>

                            <field-errors name="platforms"></field-errors>

                        </div>

                        

                        <div class="md:col-1/2">

                            <multi-select-field
                                name="categories[]"
                                label="Categorías"
                                v-model="fields.categories"
                                :options='@json($categories)'
                            ></multi-select-field>

                            <field-errors name="categories"></field-errors>

                        </div>

                    </div>

                </section>


                <div class="text-center">

                    <form-button class="btn--success btn--wide">
                        Guardar juego
                    </form-button>

                </div>

            </form>

        </base-form>

    </div>

</section>

@endsection