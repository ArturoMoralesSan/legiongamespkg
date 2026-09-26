
<site-header
    :logo="'{{ url('img/logo.png') }}'"
    :uri="'{{ url('/') }}'"
    :breakpoint="760"
>
    <template slot="button-session">
        <div class="menu__container">
            <site-menu
                :breakpoint="760"
                :links='@json($links)'
                active-link="{{ $activeLink }}"
            >
                <template slot="close">
                    Cerrar X
                </template>
            </site-menu>
            <!-- @guest
                <a href="{{ url('login') }}" class="btn-login-menu">
                    <span>
                        <i class="fa-solid fa-user"></i>
                        Iniciar sesión
                    </span>
                </a>
            @endguest -->
        </div>
    </template>
</site-header>


