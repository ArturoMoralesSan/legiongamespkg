<footer id="footer" class="main-footer" role="contentinfo">
    <div class="footer__container-direction">
        <div class="container">
            <div class="row">
                <div class="footer__col-text col lg:col-2/3">
                    <p class="footer_container-title mb-0">
                        <img class="footer__image" src="{{ url('img/logo.png') }}" alt="">
                        <strong>
                            LegionGames
                        </strong>
                    </p>
                </div>
                
                <div class="footer__col-text col lg:col-1/3 d-flex flex-col">
                    <p class="footer_container-title mb-0">

                        <strong>
                            Redes sociales
                        </strong>

                    </p>
                    <div class="brand__social--container">
                        <a class="brand__social--link" href="https://www.facebook.com/Legiongamesgodrgh/"><i class="fa-brands fa-square-facebook"></i></a>
                        <a class="brand__social--link" href="https://www.youtube.com/@legiongamesgod"><i class="fa-brands fa-youtube"></i></a>
                        <a class="brand__social--link" href="https://t.me/+B9y0Czn8Hcc3N2Jh"><i class="fa-brands fa-telegram"></i></a>
                    </div>
                </div>
            </div>

            <div class="row footer__legal-row">
                <div class="col lg:col-1/1">
                    <div class="footer__legal-links">
                        <a href="{{ url('sobre-nosotros') }}">
                            Sobre Nosotros
                        </a>
                        <span class="footer__legal-sep">•</span>
                        <a href="{{ url('politica-privacidad') }}">
                            Política de Privacidad
                        </a>
                        <span class="footer__legal-sep">•</span>
                        <a href="{{ url('terminos-condiciones') }}">
                            Términos y Condiciones
                        </a>
                        <br>
                        <span>
                            DMCA Removal Request
                        </span>
                    </div>
                </div>
            </div>

            
            <div class="row footer__dmca-row">
                <div class="col lg:col-1/1">
                    <div class="footer-dmca-block">

                        <div class="dmca-email-box">
                            <span class="dmca-email-label">Contact email:</span>
                            <a class="dmca-email-link" href="mailto:legiongamespkg.dmca@proton.me?subject=Solicitud%20de%20Eliminaci%C3%B3n%20DMCA">
                                legiongamespkg.dmca@proton.me
                            </a>
                        </div>

                        <details class="dmca-details">
                            <summary>Ver detalles sobre derechos de autor y quiénes pueden solicitar la retirada</summary>
                            <div class="dmca-content">
                                <p>
                                    Respetamos los derechos de propiedad intelectual ajenos y nos acogemos a las disposiciones de la 
                                    <strong>Digital Millennium Copyright Act (DMCA)</strong>. Si consideras que algún material o enlace 
                                    disponible en este sitio infringe tus derechos de autor, puedes solicitar su eliminación formal.
                                </p>
                                
                                <strong>¿Quiénes deben enviar esta solicitud?</strong>
                                <ul>
                                    <li>El titular exclusivo de los derechos de autor o propiedad intelectual del material.</li>
                                    <li>Un representante legal o agente expresamente autorizado para actuar en nombre del titular de los derechos.</li>
                                </ul>

                                <p class="dmca-notice">
                                    <em>Para procesar la solicitud, el correo debe incluir la URL exacta del contenido en cuestión y la prueba o acreditación correspondiente de titularidad.</em>
                                </p>
                                <p class="dmca-notice">
                                    <em>Una vez validada la información, la solicitud será procesada en un lapso de 48 a 72 horas hábiles.</em>
                                </p>
                            </div>
                        </details>

                    </div>
                </div>
            </div> 
        </div> 
    </div>
</footer>

<style>
.footer__legal-row {
    margin-top: 20px;
    padding-top: 16px;
    border-top: 1px solid rgba(255, 255, 255, 0.08);
    text-align: center;
}

.footer__legal-links {
    font-size: 0.85rem;
}

.footer__legal-links a {
    color: #cbd5e1 !important;
    text-decoration: none !important;
}

.footer__legal-links a:hover {
    color: #c084fc !important;
    text-decoration: underline !important;
}

.footer__legal-sep {
    color: #475569;
    margin: 0 10px;
}

.footer__dmca-row {
    margin-top: 25px;
    padding-top: 20px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.footer-dmca-block {
    background-color: #0b0e14 !important;
    padding: 24px 20px !important;
    border-radius: 8px !important;
    color: #ffffff !important;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif !important;
    font-size: 0.95rem !important;
    line-height: 1.6 !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
}

.dmca-main-title {
    color: #ffffff !important;
    font-size: 1.35rem !important;
    font-weight: 600 !important;
    margin: 0 0 16px 0 !important;
    letter-spacing: 0.3px !important;
}

.dmca-email-box {
    margin-bottom: 16px !important;
}

.dmca-email-label {
    display: block !important;
    color: #ffffff !important;
    font-weight: 600 !important;
    font-size: 0.95rem !important;
    margin-bottom: 4px !important;
}

.dmca-email-link {
    color: #c084fc !important;
    font-size: 0.95rem !important;
    text-decoration: none !important;
    word-break: break-all !important;
}

.dmca-email-link:hover {
    text-decoration: underline !important;
}

.dmca-details {
    margin-top: 12px !important;
}

.dmca-details summary {
    color: #cbd5e1 !important;
    cursor: pointer !important;
    font-size: 0.9rem !important;
    user-select: none !important;
    outline: none !important;
    transition: color 0.2s ease !important;
}

.dmca-details summary:hover {
    color: #ffffff !important;
}

.dmca-content {
    margin-top: 14px !important;
    padding: 18px 20px !important;
    background-color: #121624 !important;
    border-left: 4px solid #a855f7 !important;
    border-radius: 6px !important;
    color: #ffffff !important;
    font-size: 0.9rem !important;
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.2);
}

.dmca-content p {
    margin: 0 0 14px 0 !important;
    color: #ffffff !important;
}

.dmca-content strong {
    color: #ffffff !important;
    font-weight: 600 !important;
}

.dmca-content ul {
    margin: 8px 0 16px 0 !important;
    padding-left: 20px !important;
    color: #ffffff !important;
}

.dmca-content ul li {
    margin-bottom: 6px !important;
    color: #ffffff !important;
}

.dmca-notice {
    font-size: 0.85rem !important;
    color: #e2e8f0 !important;
    margin-bottom: 6px !important;
}

.dmca-notice:last-child {
    margin-bottom: 0 !important;
}
</style>

