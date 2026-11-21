@extends('layout.master')

@section('title', 'Política de Privacidad - ' . config('app.name'))
@section('description', 'Política de privacidad de legiongamespkg.com')

@section('content')

<style>
.legal-page,
.legal-page * {
    background: none !important;
    -webkit-background-clip: initial !important;
    background-clip: initial !important;
    -webkit-text-fill-color: initial !important;
    opacity: 1 !important;
    text-shadow: none !important;
}
.legal-page {
    max-width: 820px !important;
    margin: 0 auto !important;
    padding: 20px 0 60px !important;
    color: #cbd5e1 !important;
    line-height: 1.7 !important;
}
.legal-page__title {
    color: #f8fafc !important;
    font-size: 2rem !important;
    margin-bottom: 24px !important;
    display: block !important;
}
.legal-page h2 {
    color: #f8fafc !important;
    font-size: 1.1rem !important;
    margin: 28px 0 10px !important;
    display: block !important;
}
.legal-page p,
.legal-page li {
    color: #cbd5e1 !important;
}
.legal-page ul {
    padding-left: 20px !important;
}
.legal-page a {
    color: #c084fc !important;
    text-decoration: underline !important;
}
</style>

<section class="features-section mt-4">
    <div class="container">
        <div class="legal-page">

            <h1 class="legal-page__title">
                Política de Privacidad
            </h1>

            <p>
                En legiongamespkg.com, la privacidad de nuestros visitantes es de suma
                importancia para nosotros. Este documento de Política de Privacidad
                describe los tipos de información personal que recibe y recopila
                legiongamespkg.com y cómo se utiliza.
            </p>

            <h2>1. Archivos de Registro (Log Files)</h2>
            <p>
                Al igual que muchos otros sitios web, legiongamespkg.com hace uso de
                archivos de registro. La información dentro de los archivos de registro
                incluye direcciones de protocolo de Internet (IP), tipo de navegador,
                proveedor de servicios de Internet (ISP), fecha/hora, páginas de
                referencia/salida y el número de clics para analizar tendencias,
                administrar el sitio, rastrear el movimiento del usuario en el sitio y
                recopilar información demográfica.
            </p>

            <h2>2. Cookies y Web Beacons</h2>
            <p>
                legiongamespkg.com utiliza cookies para almacenar información sobre las
                preferencias de los visitantes, registrar información específica del
                usuario sobre qué páginas accede o visita, y personalizar el contenido
                de la página web según el tipo de navegador del visitante u otra
                información que el visitante envía a través de su navegador.
            </p>

            <h2>3. Cookie de Google DoubleClick DART y AdSense</h2>
            <ul>
                <li>Google, como proveedor de terceros, utiliza cookies para publicar anuncios en legiongamespkg.com.</li>
                <li>El uso de la cookie de DART le permite a Google y a sus socios mostrar anuncios a los usuarios en función de su visita a legiongamespkg.com y/o a otros sitios en Internet.</li>
                <li>Los usuarios pueden optar por no usar la cookie de DART visitando la Política de Privacidad de la red de anuncios y contenido de Google en la siguiente URL:
                    <a href="https://policies.google.com/technologies/ads" target="_blank" rel="noopener">
                        https://policies.google.com/technologies/ads
                    </a>
                </li>
            </ul>
            <p>
                Nuestros socios publicitarios (como Google AdSense) pueden utilizar
                cookies y web beacons en nuestro sitio para medir la efectividad de sus
                campañas publicitarias y/o personalizar el contenido publicitario que
                usted ve. legiongamespkg.com no tiene acceso ni control sobre estas
                cookies utilizadas por anunciantes de terceros.
            </p>

            <h2>4. Enlaces de Terceros</h2>
            <p>
                Este sitio web puede contener enlaces a otros sitios web de terceros. No
                nos hacemos responsables de las prácticas de privacidad ni del contenido
                de dichos sitios web externos.
            </p>

            <h2>5. Consentimiento</h2>
            <p>
                Al utilizar nuestro sitio web, usted acepta nuestra Política de
                Privacidad y está de acuerdo con sus términos.
            </p>

        </div>
    </div>
</section>

@endsection
