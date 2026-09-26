@extends('layout.dashboard-master')

@section('title', 'Editar juego')
@section('tab_title', 'Editar juego | ' . config('app.name'))
@section('description', 'Editar juego')
@section('css_classes', 'dashboard')

@section('content')

<section class="mb-16">

    <div class="dashboard-heading">

        <h1 class="dashboard-heading__title">
            Editar juego
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
            action="{{ url('admin/juegos/' . $juego->id) }}"
            method="PUT"
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
                                    initial="{{ $juego->title }}"
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
                                    initial="{{ $juego->size_mb }}"
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
                                    initial="{{ $juego->url_game }}"
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
                                    initial-value="{{ $juego->description }}"
                                ></text-area-tiny>

                                <field-errors name="description"></field-errors>

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
                        Agrega, modifica o elimina enlaces adicionales
                        como DLC, actualizaciones, parches,
                        expansiones o contenido adicional.
                    </p>

                    <game-links-form
                        :fields="fields"
                        :errors="errors"
                        :initial-links='@json($juego->links)'
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
                                    Cambiar imagen
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

                        @if($juego->image)

                            <div class="preview-aside">

                                <figure class="preview-aside__box preview-box">

                                    <img
                                        class="preview-box__img"
                                        src="{{ url('uploads/games/' . $juego->image) }}"
                                        alt=""
                                        style="height: 260px;"
                                    >

                                    <figcaption class="preview-box__caption">
                                        Imagen actual
                                    </figcaption>

                                </figure>

                            </div>

                        @endif

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
                                :initial='@json($juego->platforms->pluck("id"))'
                            ></multi-select-field>

                            <field-errors name="platforms"></field-errors>

                        </div>

                        

                        <div class="md:col-1/2">

                            <multi-select-field
                                name="categories[]"
                                label="Categorías"
                                v-model="fields.categories"
                                :options='@json($categories)'
                                :initial='@json($juego->categories->pluck("id"))'
                            ></multi-select-field>

                            <field-errors name="categories"></field-errors>

                        </div>

                    </div>

                </section>


                <div class="text-center">

                    <form-button class="btn--success btn--wide">
                        Actualizar juego
                    </form-button>

                </div>

            </form>

        </base-form>

    </div>

</section>

@endsection