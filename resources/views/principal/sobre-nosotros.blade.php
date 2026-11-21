@extends('layout.master')

@section('title', 'Sobre Nosotros - ' . config('app.name'))
@section('description', 'Sobre legiongamespkg.com')

@section('content')

<section class="features-section">
    <div class="container">
        <div class="legal-page">

            <h1 class="legal-page__title">
                Sobre nosotros
            </h1>

            <p>
                Bienvenido a legiongamespkg.com, una comunidad dedicada al
                entretenimiento digital, la preservación de videojuegos y la difusión de
                guías informativas, tutoriales y herramientas sobre consolas y
                retro-gaming.
            </p>

            <h2>Nuestra Misión</h2>
            <p>
                Nuestro objetivo principal es ofrecer un espacio centralizado donde los
                entusiastas de las consolas retro y los videojuegos puedan encontrar
                información detallada, noticias, guías paso a paso e instructivos claros
                sobre configuración, instalación y optimización de software.
            </p>

            <h2>¿Qué ofrecemos en legiongamespkg.com?</h2>
            <ul>
                <li><strong>Guías y Tutoriales:</strong> Artículos redactados para ayudar a los usuarios a configurar y gestionar sus herramientas y archivos de forma sencilla.</li>
                <li><strong>Noticias e Información:</strong> Actualizaciones sobre la scene de videojuegos y desarrollo independiente.</li>
                <li><strong>Comunidad:</strong> Un punto de encuentro para apasionados del gaming retro y clásico.</li>
            </ul>

            <h2>Aviso Legal</h2>
            <p>
                legiongamespkg.com es un sitio informativo y educativo. Todos los
                nombres de marcas, juegos y marcas comerciales mencionadas en este sitio
                son propiedad de sus respectivos dueños.
            </p>

            <p>
                Si tienes alguna pregunta, sugerencia o consulta sobre nuestro sitio, no
                dudes en ponerte en contacto con nosotros a través de nuestra página de
                Contacto.
            </p>

        </div>
    </div>
</section>

@endsection
