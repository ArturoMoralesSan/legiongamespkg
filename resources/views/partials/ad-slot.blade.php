{{--
    Posición de anuncios.
    Uso: @include('partials.ad-slot', ['position' => 'top'])

    El sitio es una app Vue (#app) y Vue elimina las etiquetas <script> de su
    plantilla, así que aquí sólo se deja un contenedor vacío (v-pre). El código
    real se manda al stack "ad-templates" (fuera de #app) y partials/ad-runtime
    lo inserta, recarga, cierra y reabre según lo configurado en el panel.

    Las posiciones flotantes (modal, anchor) no necesitan contenedor.
--}}
@php
    $slotAds = \App\Support\AdManager::for($position);
    $isFloating = in_array($position, config('ads.floating', []), true);
@endphp

@if($slotAds->isNotEmpty())

    @unless($isFloating)
        <div class="ad-slot ad-slot--{{ $position }}" data-ad-slot="{{ $position }}" v-pre></div>
    @endunless

    @push('ad-templates')
        @foreach($slotAds as $ad)
            <template
                data-ad
                data-ad-id="{{ $ad->id }}"
                data-position="{{ $position }}"
                data-iframe="{{ $ad->type === 'code' && $ad->use_iframe ? 1 : 0 }}"
                data-height="{{ $ad->iframe_height ?: '' }}"
                data-closable="{{ $ad->closable ? 1 : 0 }}"
                data-delay="{{ (int) $ad->delay_seconds }}"
                data-refresh="{{ (int) $ad->refresh_seconds }}"
                data-reopen="{{ (int) $ad->reopen_seconds }}"
            >
                @if($ad->type === 'image')
                    @if($ad->image_url)
                        @if($ad->link_url)
                            <a href="{{ $ad->link_url }}" target="_blank" rel="sponsored noopener">
                                <img src="{{ $ad->image_url }}" alt="{{ $ad->name }}" loading="lazy">
                            </a>
                        @else
                            <img src="{{ $ad->image_url }}" alt="{{ $ad->name }}" loading="lazy">
                        @endif
                    @endif
                @else
                    {!! $ad->code !!}
                @endif
            </template>
        @endforeach
    @endpush

@endif
