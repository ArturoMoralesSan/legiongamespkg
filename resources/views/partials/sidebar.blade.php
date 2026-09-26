<aside class="sidebar">

    {{-- SÍGUENOS --}}
    <div class="sidebar-card">
        <h6 class="sidebar-title"> <i class="fa-solid fa-heart-circle-plus"></i> Síguenos</h6>

        <div class="social-grid">
            <a class="brand__social--link" href="https://www.facebook.com/Legiongamesgodrgh/"><i class="fa-brands fa-square-facebook"></i></a>
            <a class="brand__social--link" href="https://www.youtube.com/@legiongamesgod"><i class="fa-brands fa-youtube"></i></a>
            <a class="brand__social--link" href="https://t.me/LegionGamesGodRGH"><i class="fa-brands fa-telegram"></i></a>
            
        </div>
    </div>

    {{-- ESTADÍSTICAS --}}
    <div class="sidebar-card">
        <h6 class="sidebar-title"><i class="fa-solid fa-chart-simple"></i> Biblioteca Gamer</h6>

        <div class="stats">
            <div class="stat-item">
                <span>Juegos</span>
                <b>{{ $stats['games'] ?? 0 }}</b>
            </div>

            <div class="stat-item">
                <span>Plataformas</span>
                <b>{{ $stats['platforms'] ?? 0 }}</b>
            </div>

            <div class="stat-item">
                <span>Categorias</span>
                <b>{{ $stats['categories'] ?? 0 }}</b>
            </div>
        </div>
    </div>

</aside>