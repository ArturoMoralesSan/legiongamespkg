@extends('layout.dashboard-master')

{{-- Metadata --}}
@section('title', 'Regiones')
@section('tab_title', 'Regiones | ' . config('app.name'))
@section('description', 'Lista de Regiones.')
@section('css_classes', 'dashboard')

@section('content')
    <div class="dashboard-heading">
        <h1 class="dashboard-heading__title">
            Regiones
        </h1>

        <p class="dashboard-heading__caption">
            Hay {{ $regions->count() }} regiones registradas.
        </p>
    </div>

    <div class="fluid-container mb-16">
        @include('components.alert')
        <section class="db-panel">
            <h3 class="db-panel__title">
                Lista de regiones
            </h3>

            @if (! $regions->count())
                <p class="text-center py-1">
                    Por el momento no hay regiones registradas.
                </p>
            @else

                <resource-table :breakpoint="800" :model="{{ $regions }}" inline-template>
                    <table class="table size-caption mx-auto mb-16 md:table--responsive">
                        <thead>
                            <tr class="table-resource__headings">
                                <th>Nombre</th>
                                <th class="pr-4">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="regionItem in resourceList" class="table-resource__row" :key="regionItem.id">
                                <td data-label="Nombre:">
                                    @{{ regionItem.name }}
                                </td>
                                

                                <td class="table-resource__actions" data-label="Acciones:">
                                    <a class="btn btn-nowrap btn--sm btn--blue table-resource__button mr-2" :href="$root.path + '/admin/regiones/' + regionItem.id + '/edit'">
                                        <img class="svg-icon" src="{{ url('img/svg/edit.svg')}}">
                                        Editar
                                    </a>
                                    <delete-button class="btn--danger table-resource__button" :url="$root.path + '/admin/regiones/' + regionItem.id"
                                        :resource-id="regionItem.id"
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
