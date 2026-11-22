<?php

/*
|--------------------------------------------------------------------------
| Anuncios
|--------------------------------------------------------------------------
|
| "positions": lugares del sitio donde se puede colocar un anuncio. Cada
| posición se pinta con @include('partials.ad-slot', ['position' => '...']).
|
| "pages": páginas en las que se puede mostrar. "patterns" usa el mismo
| formato que Request::is(). Un anuncio sin páginas se muestra en todas.
|
*/

return [

    'positions' => [
        'top'     => 'Arriba (debajo del menú)',
        'bottom'  => 'Al final (antes del pie de página)',
        'left'    => 'Lateral izquierdo (fijo, sólo escritorio)',
        'right'   => 'Lateral derecho (fijo, sólo escritorio)',
        'sidebar' => 'Barra lateral (columna derecha del contenido)',
        'content' => 'Dentro del contenido (detalle de juego, antes de descargas)',
        'modal'   => 'Ventana modal (emergente sobre la página)',
        'anchor'  => 'Ancla inferior (barra fija abajo)',
        'global'  => 'Script global (pop-under, push… sin espacio visible)',
    ],

    // Posiciones que no tienen un lugar en la página: se crean flotando.
    'floating' => ['modal', 'anchor', 'global'],

    // Posiciones que sólo cargan un script: nunca en iframe, sin recargar
    // ni cerrar (recargar un pop-under rompe su límite de 1 por usuario).
    'script_only' => ['global'],

    'pages' => [
        'home'        => ['label' => 'Inicio',            'patterns' => ['/']],
        'games'       => ['label' => 'Listado de juegos', 'patterns' => ['juegos']],
        'game_detail' => ['label' => 'Detalle de juego',  'patterns' => ['juegos/*']],
        'platforms'   => ['label' => 'Plataformas',       'patterns' => ['plataformas', 'plataforma/*']],
        'categories'  => ['label' => 'Categorías',        'patterns' => ['categorias']],
        'regions'     => ['label' => 'Regiones',          'patterns' => ['regiones']],
        'download'    => ['label' => 'Descarga',          'patterns' => ['download/*']],
        'news'        => ['label' => 'Noticias',          'patterns' => ['noticia/*']],
        'legal'       => ['label' => 'Páginas legales',   'patterns' => ['politica-privacidad', 'terminos-condiciones', 'sobre-nosotros']],
    ],

    // Nunca mostrar anuncios en estas rutas.
    'excluded' => ['admin', 'admin/*', 'login', 'register', 'password/*'],

];
