@extends('layout.dashboard-master')

@section('title', 'Detección de AdBlock')
@section('tab_title', 'Detección de AdBlock | ' . config('app.name'))
@section('description', 'Configurar la detección de bloqueadores de anuncios')
@section('css_classes', 'dashboard')

@section('content')

<section class="mb-16">

    <div class="dashboard-heading">
        <h1 class="dashboard-heading__title">
            Detección de AdBlock
        </h1>

        <p class="dashboard-heading__caption">
            Qué pasa cuando un visitante tiene un bloqueador de anuncios
            (uBlock, AdBlock, AdGuard, Brave, Opera...).
        </p>
    </div>

    <div class="fluid-container mb-16">

        @include('components.alert')

        <p class="mb-12">
            <span class="color-link">«</span>
            <a href="{{ url('admin/anuncios') }}">Ver anuncios</a>
        </p>

        <base-form
            action="{{ url('admin/publicidad/adblock') }}"
            method="PUT"
            :initial='@json(['message' => $settings['message']])'
            inline-template
            v-cloak
        >
            <form>

                {{-- AVISO EN EL SITIO --}}

                <section class="db-panel mb-16">

                    <h3 class="db-panel__title">
                        Aviso en el sitio
                    </h3>

                    <div class="md:row">

                        <div class="md:col">
                            <div class="form-control">
                                <checkbox-field
                                    name="enabled"
                                    v-model="fields.enabled"
                                    :initial="{{ $settings['enabled'] ? 'true' : 'false' }}"
                                >
                                    Mostrar aviso cuando se detecte un bloqueador
                                </checkbox-field>
                            </div>
                        </div>

                    </div>

                    <div class="md:row" v-show="fields.enabled">

                        <div class="md:col-1/2">
                            <div class="form-control">
                                <label for="mode">Tipo de aviso</label>
                                <select-field
                                    name="mode"
                                    v-model="fields.mode"
                                    :options='@json($modes)'
                                    initial="{{ $settings['mode'] }}"
                                ></select-field>
                                <field-errors name="mode"></field-errors>
                                <p class="description color-gray-darken-1" v-if="fields.mode === 'block'">
                                    Con "Bloqueo" el visitante no puede usar el sitio hasta desactivarlo.
                                    Puede aumentar las salidas del sitio.
                                </p>
                            </div>
                        </div>

                        <div class="md:col-1/2" v-show="fields.mode === 'soft'">
                            <div class="form-control">
                                <label>&nbsp;</label>
                                <checkbox-field
                                    name="remember_dismiss"
                                    v-model="fields.remember_dismiss"
                                    :initial="{{ $settings['remember_dismiss'] ? 'true' : 'false' }}"
                                >
                                    Si lo cierra, no volver a mostrarlo en esa visita
                                </checkbox-field>
                                <p class="description color-gray-darken-1">
                                    Desactivado: aparece en cada página que abra.
                                </p>
                            </div>
                        </div>

                        <div class="md:col">
                            <div class="form-control">
                                <multi-select-field
                                    name="pages[]"
                                    label="Páginas donde se muestra"
                                    v-model="fields.pages"
                                    :options='@json($pages)'
                                    :initial='@json($settings['pages'])'
                                ></multi-select-field>
                                <field-errors name="pages" :array="true"></field-errors>
                                <p class="description color-gray-darken-1">
                                    Si no seleccionas ninguna, se muestra en <strong>todas</strong>.
                                </p>
                            </div>
                        </div>

                        <div class="md:col">
                            <div class="form-control">
                                <label for="title">Título</label>
                                <text-field
                                    name="title"
                                    v-model="fields.title"
                                    maxlength="150"
                                    initial="{{ $settings['title'] }}"
                                ></text-field>
                                <field-errors name="title"></field-errors>
                            </div>
                        </div>

                        <div class="md:col">
                            <div class="form-control">
                                <label for="message">Mensaje</label>
                                <textarea
                                    id="message"
                                    name="message"
                                    class="form-field"
                                    rows="4"
                                    maxlength="1000"
                                    v-model="fields.message"
                                    :aria-invalid="errors.message ? 'true' : null"
                                ></textarea>
                                <field-errors name="message"></field-errors>
                            </div>
                        </div>

                    </div>

                </section>

                {{-- PÁGINA DE DESCARGA --}}

                <section class="db-panel mb-16">

                    <h3 class="db-panel__title">
                        Página de descarga
                    </h3>

                    <div class="form-control">
                        <checkbox-field
                            name="download_block"
                            v-model="fields.download_block"
                            :initial="{{ $settings['download_block'] ? 'true' : 'false' }}"
                        >
                            Bloquear la descarga si tiene un bloqueador activo
                        </checkbox-field>
                        <p class="description color-gray-darken-1">
                            Detiene el contador y muestra el aviso rojo "Ad-Blocker Detected!" hasta que lo desactive.
                            Si lo apagas, la descarga funciona igual con o sin bloqueador.
                        </p>
                    </div>

                </section>

                <div class="text-center">
                    <form-button class="btn--success btn--wide">
                        Guardar configuración
                    </form-button>
                </div>

            </form>
        </base-form>

    </div>

</section>

@endsection
