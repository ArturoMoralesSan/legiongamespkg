@extends('layout.dashboard-master')

@section('title', 'Juegos')

@section('tab_title', 'Juegos | ' . config('app.name'))

@section('description', 'Lista de juegos.')

@section('css_classes', 'dashboard')

@section('content')

<div class="dashboard-heading">

    <h1 class="dashboard-heading__title">
        Juegos
    </h1>

    <p class="dashboard-heading__caption">
    Se muestran {{ $paginatedGames->count() }} de {{ $paginatedGames->total() }} juegos registrados.
</p>

</div>

<div class="fluid-container mb-16">

    <form-search-select
        selected="{{ app('request')->input('search') }}"
        :platforms="{{ $platforms }}"
        :categories="{{ $categories }}"
        selected-platform="{{ app('request')->input('platform') }}"
        selected-category="{{ app('request')->input('category') }}"
    >

        <template slot="svg-search">
            <img
                class="search-form_icon"
                src="{{ url('img/svg/search.svg') }}"
                alt=""
            >
        </template>

    </form-search-select>

    @include('components.alert')

    <section class="db-panel">

        <h3 class="db-panel__title">
            Lista de juegos
        </h3>

        @if (! $paginatedGames->count())

            <p class="text-center py-1">
                Por el momento no hay juegos registrados.
            </p>

        @else

            <resource-table
                :breakpoint="800"
                :model="{{ $paginatedGames->getCollection() }}"
                inline-template
            >

                <table class="table size-caption mx-auto mb-16 md:table--responsive">

                    <thead>

                        <tr class="table-resource__headings">

                            <th>
                                Título
                            </th>

                            <th>
                                Tamaño
                            </th>

                            <th>
                                Plataformas
                            </th>

                            <th>
                                Categorías
                            </th>

                            <th>
                                Imagen
                            </th>

                            <th class="pr-4">
                                Acciones
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        <tr
                            v-for="gameItem in resourceList"
                            class="table-resource__row"
                            :key="gameItem.id"
                        >

                            <td data-label="Título:">
                                @{{ gameItem.title }}
                            </td>

                            <td data-label="Tamaño:">
                                @{{ gameItem.size_mb }}
                            </td>

                            <td data-label="Plataformas:">

                                <span
                                    v-for="platform in gameItem.platforms"
                                    :key="platform.id"
                                    class="mr-1"
                                >
                                    @{{ platform.name }}
                                </span>

                            </td>

                            <td data-label="Categorías:">

                                <span
                                    v-for="category in gameItem.categories"
                                    :key="category.id"
                                    class="mr-1"
                                >
                                    @{{ category.name }}
                                </span>

                            </td>

                            <td data-label="Imagen:">

                                <img
                                    :src="'/uploads/games/' + gameItem.image"
                                    alt=""
                                    style="height: 60px;"
                                >

                            </td>

                            <td
                                class="table-resource__actions"
                                data-label="Acciones:"
                            >
                                <a 
                                    class="btn btn-nowrap btn--sm btn--blue table-resource__button mr-2"
                                    :href="$root.path + '/juegos/' + gameItem.id"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >
                                    Ver
                                </a>

                                <a
                                    class="btn btn-nowrap btn--sm btn--blue table-resource__button mr-2"

                                    :href="$root.path + '/admin/juegos/' + gameItem.id + '/edit'"
                                >

                                    <img
                                        class="svg-icon"
                                        src="{{ url('img/svg/edit.svg') }}"
                                    >

                                    Editar

                                </a>

                                <delete-button
                                    class="btn--danger table-resource__button"
                                    :url="$root.path + '/admin/juegos/' + gameItem.id"
                                    :resource-id="gameItem.id"
                                    :options="{ onDelete: onResourceDelete }"
                                >

                                    <img
                                        class="svg-icon"
                                        src="{{ url('img/svg/trash.svg') }}"
                                    >

                                    Eliminar

                                </delete-button>

                            </td>

                        </tr>

                    </tbody>

                </table>

            </resource-table>

            {!! $links !!}

        @endif

    </section>

</div>

@endsection
