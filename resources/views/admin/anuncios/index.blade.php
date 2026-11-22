@extends('layout.dashboard-master')

{{-- Metadata --}}
@section('title', 'Anuncios')
@section('tab_title', 'Anuncios | ' . config('app.name'))
@section('description', 'Lista de anuncios.')
@section('css_classes', 'dashboard')

@section('content')
    <div class="dashboard-heading">
        <h1 class="dashboard-heading__title">
            Anuncios
        </h1>

        <p class="dashboard-heading__caption">
            Hay {{ $ads->count() }} anuncios registrados
            ({{ $ads->where('is_active', true)->count() }} activos).
        </p>
    </div>

    <div class="fluid-container mb-16">
        @include('components.alert')

        <p class="mb-12">
            <a class="btn btn--success btn--sm" href="{{ url('admin/anuncios/create') }}">
                + Agregar anuncio
            </a>
        </p>

        <section class="db-panel">
            <h3 class="db-panel__title">
                Lista de anuncios
            </h3>

            @if (! $ads->count())
                <p class="text-center py-1">
                    Por el momento no hay anuncios registrados.
                </p>
            @else

                <resource-table :breakpoint="800" :model='@json($ads)' inline-template>
                    <table class="table size-caption mx-auto mb-16 md:table--responsive">
                        <thead>
                            <tr class="table-resource__headings">
                                <th>Nombre</th>
                                <th>Posición</th>
                                <th>Páginas</th>
                                <th>Tipo</th>
                                <th>Estado</th>
                                <th class="pr-4">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="ad in resourceList" class="table-resource__row" :key="ad.id">
                                <td data-label="Nombre:">
                                    <img v-if="ad.image_url && ad.type === 'image'" :src="ad.image_url" alt="" style="max-height: 32px; vertical-align: middle; margin-right: 6px;">
                                    @{{ ad.name }}
                                </td>
                                <td data-label="Posición:">
                                    @{{ ad.position_label }}
                                </td>
                                <td data-label="Páginas:">
                                    @{{ ad.pages_label }}
                                </td>
                                <td data-label="Tipo:">
                                    @{{ ad.type === 'image' ? 'Imagen' : (ad.use_iframe ? 'Código (iframe)' : 'Código') }}
                                    <small v-if="ad.delay_seconds || ad.refresh_seconds" style="display:block; color:#888;">
                                        <span v-if="ad.delay_seconds">aparece a los @{{ ad.delay_seconds }}s</span>
                                        <span v-if="ad.refresh_seconds">· recarga @{{ ad.refresh_seconds }}s</span>
                                    </small>
                                </td>
                                <td data-label="Estado:">
                                    <strong :style="{ color: ad.is_active ? '#20c372' : '#999' }">
                                        @{{ ad.is_active ? 'Activo' : 'Inactivo' }}
                                    </strong>
                                </td>

                                <td class="table-resource__actions" data-label="Acciones:">
                                    <a class="btn btn-nowrap btn--sm btn--blue table-resource__button mr-2" :href="$root.path + '/admin/anuncios/' + ad.id + '/edit'">
                                        <img class="svg-icon" src="{{ url('img/svg/edit.svg')}}">
                                        Editar
                                    </a>
                                    <delete-button class="btn--danger table-resource__button" :url="$root.path + '/admin/anuncios/' + ad.id"
                                        :resource-id="ad.id"
                                        :options="{ onDelete: onResourceDelete }"
                                    >
                                        <img class="svg-icon" src="{{ url('img/svg/trash.svg')}}">
                                        Eliminar
                                    </delete-button>
                                </td>
                            </tr>
                        </tbody>

                    </table>

                </resource-table>

            @endif

        </section>
    </div>
@endsection
