{{--
    Formulario compartido de anuncios.
    Variables: $action, $method, $submitLabel, $positions, $pages, $types, $anuncio (opcional)
--}}
@php
    $anuncio = $anuncio ?? null;
@endphp

<base-form
    action="{{ $action }}"
    method="{{ $method }}"
    enctype="multipart/form-data"
    :initial='@json(['code' => $anuncio->code ?? ''])'
    inline-template
    v-cloak
>
    <form>

        <section class="db-panel mb-16">

            <h3 class="db-panel__title">
                Datos del anuncio
            </h3>

            <div class="md:row">

                <div class="md:col-2/3">
                    <div class="form-control">
                        <label for="name">Nombre interno</label>
                        <text-field
                            name="name"
                            v-model="fields.name"
                            maxlength="255"
                            initial="{{ $anuncio->name ?? '' }}"
                        ></text-field>
                        <field-errors name="name"></field-errors>
                        <p class="description color-gray-darken-1">
                            Sólo para identificarlo en el panel, ej. "AdSense header 728x90".
                        </p>
                    </div>
                </div>

                <div class="md:col-1/3">
                    <div class="form-control">
                        <label for="order">Orden</label>
                        <text-field
                            name="order"
                            v-model="fields.order"
                            type="number"
                            initial="{{ $anuncio->order ?? 0 }}"
                        ></text-field>
                        <field-errors name="order"></field-errors>
                        <p class="description color-gray-darken-1">
                            Si hay varios en la misma posición, se muestran de menor a mayor.
                        </p>
                    </div>
                </div>

                <div class="md:col-1/2">
                    <div class="form-control">
                        <label for="position">Posición</label>
                        <select-field
                            name="position"
                            v-model="fields.position"
                            :options='@json($positions)'
                            initial="{{ $anuncio->position ?? 'top' }}"
                        ></select-field>
                        <field-errors name="position"></field-errors>
                    </div>
                </div>

                <div class="md:col-1/2">
                    <div class="form-control">
                        <label for="type">Tipo</label>
                        <select-field
                            name="type"
                            v-model="fields.type"
                            :options='@json($types)'
                            initial="{{ $anuncio->type ?? 'code' }}"
                        ></select-field>
                        <field-errors name="type"></field-errors>
                    </div>
                </div>

                <div class="md:col">
                    <div class="form-control">
                        <multi-select-field
                            name="pages[]"
                            label="Páginas donde se muestra"
                            v-model="fields.pages"
                            :options='@json($pages)'
                            :initial='@json($anuncio->pages ?? [])'
                        ></multi-select-field>
                        <field-errors name="pages" :array="true"></field-errors>
                        <p class="description color-gray-darken-1">
                            Si no seleccionas ninguna, se muestra en <strong>todas</strong> las páginas.
                        </p>
                    </div>
                </div>

                <div class="md:col">
                    <div class="form-control">
                        <checkbox-field
                            name="is_active"
                            v-model="fields.is_active"
                            :initial="{{ ($anuncio->is_active ?? true) ? 'true' : 'false' }}"
                        >
                            Activo
                        </checkbox-field>
                    </div>
                </div>

            </div>

        </section>

        {{-- CÓDIGO --}}

        <section class="db-panel mb-16" v-show="fields.type === 'code'">

            <h3 class="db-panel__title">
                Código del anuncio
            </h3>

            <div class="form-control">
                <label for="code">HTML / script</label>
                <textarea
                    id="code"
                    name="code"
                    class="form-field"
                    rows="10"
                    style="font-family: monospace;"
                    v-model="fields.code"
                    :aria-invalid="errors.code ? 'true' : null"
                ></textarea>
                <field-errors name="code"></field-errors>
                <p class="description color-gray-darken-1">
                    Pega el bloque &lt;ins&gt; de AdSense (o el código de tu red). El script
                    principal de AdSense ya se carga en el layout, no hace falta repetirlo.
                </p>
            </div>

        </section>

        {{-- IMAGEN --}}

        <section class="db-panel mb-16" v-show="fields.type === 'image'">

            <h3 class="db-panel__title">
                Banner
            </h3>

            <div class="md:row">

                <div class="md:col-2/3">

                    <div class="form-control">
                        <label for="image">
                            {{ $anuncio && $anuncio->image ? 'Cambiar imagen' : 'Agregar imagen' }}
                        </label>
                        <file-field
                            name="image"
                            v-model="fields.image"
                        ></file-field>
                        <field-errors name="image"></field-errors>
                        <ul class="description color-gray-darken-1">
                            <li>Tamaño máximo: 4 MB.</li>
                            <li>Sólo archivos jpeg, jpg, png, webp o gif.</li>
                        </ul>
                    </div>

                    <div class="form-control">
                        <label for="link-url">Enlace al hacer clic (opcional)</label>
                        <text-field
                            name="link_url"
                            v-model="fields.link_url"
                            initial="{{ $anuncio->link_url ?? '' }}"
                            placeholder="https://..."
                        ></text-field>
                        <field-errors name="link_url"></field-errors>
                    </div>

                </div>

                @if($anuncio && $anuncio->image)
                    <div class="preview-aside">
                        <figure class="preview-aside__box preview-box">
                            <img
                                class="preview-box__img"
                                src="{{ $anuncio->image_url }}"
                                alt=""
                                style="max-height: 260px;"
                            >
                            <figcaption class="preview-box__caption">
                                Imagen actual
                            </figcaption>
                        </figure>
                    </div>
                @endif

            </div>

        </section>


        {{-- COMPORTAMIENTO --}}

        <section class="db-panel mb-16">

            <h3 class="db-panel__title">
                Comportamiento
            </h3>

            <div class="md:row">

                <div class="md:col" v-show="fields.type === 'code' && fields.position !== 'global'">
                    <div class="form-control">
                        <checkbox-field
                            name="use_iframe"
                            v-model="fields.use_iframe"
                            :initial="{{ ($anuncio->use_iframe ?? false) ? 'true' : 'false' }}"
                        >
                            Cargar dentro de un iframe aislado
                        </checkbox-field>
                        <p class="description color-gray-darken-1">
                            Recomendado para redes como RX / scripts que escriben en la página.
                            Para AdSense déjalo desactivado.
                        </p>
                    </div>
                </div>

                <div class="md:col-1/2" v-show="fields.type === 'code' && fields.use_iframe && fields.position !== 'global'">
                    <div class="form-control">
                        <label for="iframe-height">Alto del iframe (px)</label>
                        <text-field
                            name="iframe_height"
                            v-model="fields.iframe_height"
                            type="number"
                            initial="{{ $anuncio->iframe_height ?? 250 }}"
                        ></text-field>
                        <field-errors name="iframe_height"></field-errors>
                        <p class="description color-gray-darken-1">
                            Ej. 250 para 300x250, 90 para 728x90.
                        </p>
                    </div>
                </div>

                <div class="md:col" v-show="fields.position !== 'global'">
                    <div class="form-control">
                        <checkbox-field
                            name="closable"
                            v-model="fields.closable"
                            :initial="{{ ($anuncio->closable ?? false) ? 'true' : 'false' }}"
                        >
                            Mostrar botón para cerrar (✕)
                        </checkbox-field>
                    </div>
                </div>

                <div class="md:col-1/3">
                    <div class="form-control">
                        <label for="delay-seconds">Aparecer después de (seg)</label>
                        <text-field
                            name="delay_seconds"
                            v-model="fields.delay_seconds"
                            type="number"
                            initial="{{ $anuncio->delay_seconds ?? 0 }}"
                        ></text-field>
                        <field-errors name="delay_seconds"></field-errors>
                    </div>
                </div>

                <div class="md:col-1/3" v-show="fields.position !== 'global'">
                    <div class="form-control">
                        <label for="refresh-seconds">Recargar cada (seg)</label>
                        <text-field
                            name="refresh_seconds"
                            v-model="fields.refresh_seconds"
                            type="number"
                            initial="{{ $anuncio->refresh_seconds ?? 0 }}"
                        ></text-field>
                        <field-errors name="refresh_seconds"></field-errors>
                    </div>
                </div>

                <div class="md:col-1/3" v-show="fields.closable && fields.position !== 'global'">
                    <div class="form-control">
                        <label for="reopen-seconds">Reaparecer tras cerrar (seg)</label>
                        <text-field
                            name="reopen_seconds"
                            v-model="fields.reopen_seconds"
                            type="number"
                            initial="{{ $anuncio->reopen_seconds ?? 0 }}"
                        ></text-field>
                        <field-errors name="reopen_seconds"></field-errors>
                    </div>
                </div>

                <div class="md:col">
                    <p class="description color-gray-darken-1">
                        0 = desactivado. Ejemplo de ventana modal: aparecer a los 8 s,
                        recargar cada 20 s y reaparecer 20 s después de cerrarla.
                        No uses "recargar" con AdSense: va contra sus políticas.
                    </p>
                    <p class="description color-gray-darken-1" v-show="fields.position === 'global'">
                        <strong>Script global:</strong> se ejecuta una vez por página, sin iframe,
                        sin recargar y sin botón de cerrar. La red controla cuántas veces sale
                        el pop-under por usuario.
                    </p>
                </div>

            </div>

        </section>

        <div class="text-center">
            <form-button class="btn--success btn--wide">
                {{ $submitLabel }}
            </form-button>
        </div>

    </form>
</base-form>
