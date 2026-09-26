<template>
    <div class="layout">
        <div class="row">

            <aside class="sidebar col-1/3">

                <h3>
                    <i class="fa-solid fa-search"></i>
                    Encuentra tu juego
                </h3>

                <!-- SEARCH -->
                <div class="filter-block">
                    <input
                        v-model="search"
                        type="text"
                        class="input"
                        placeholder="Buscar juegos..."
                    >
                </div>

                <!-- ======================
                    ALFABETO
                ====================== -->

                <div class="filter-block">

                    <span class="filter-title">
                        Buscar por letra
                    </span>

                    <div class="alphabet-grid tag-cloud">

                        <span
                            class="tag"
                            :class="{ active: letter === '' }"
                            @click="letter=''"
                        >
                            Todas
                        </span>

                        <span
                            v-for="l in alphabet"
                            :key="l"
                            class="tag"
                            :class="{ active: letter === l }"
                            @click="letter = l"
                        >
                            {{ l }}
                        </span>

                    </div>

                </div>

                <!-- PLATFORMS -->
                <div class="filter-block">

                    <span class="filter-title">
                        Plataformas
                    </span>

                    <div class="tag-cloud">

                        <span
                            class="tag"
                            :class="{ active: platform === '' }"
                            @click="platform = ''"
                        >
                            Todas
                        </span>

                        <span
                            v-for="p in platforms"
                            :key="p.id"
                            class="tag"
                            :class="{ active: platform === p.id }"
                            @click="platform = p.id"
                        >
                            {{ p.name }}
                        </span>

                    </div>

                </div>

                <!-- CATEGORIES -->
                <div class="filter-block">

                    <span class="filter-title">
                        Categorías
                    </span>

                    <div class="tag-cloud">

                        <span
                            class="tag"
                            :class="{ active: category === '' }"
                            @click="category=''"
                        >
                            Todas
                        </span>

                        <span
                            v-for="c in categories"
                            :key="c.id"
                            class="tag"
                            :class="{ active: category===c.id }"
                            @click="category=c.id"
                        >
                            {{ c.name }}
                        </span>

                    </div>

                </div>

            </aside>

            <!-- ======================
                LISTA DE JUEGOS
            ====================== -->
            <main class="games-content col-2/3">
                <div
                    v-if="loading"
                    class="games-loading text-center py-4"
                >
                    Cargando juegos...
                </div>

                <div
                    v-if="!loading && games.length === 0"
                    class="games-empty text-center py-4"
                >
                    No hay juegos disponibles
                </div>

                <div
                    v-if="!loading && games.length"
                    class="games-card-grid"
                >

                    <a
                        v-for="game in games"
                        :key="game.id"
                        :href="`/juegos/${game.id}`"
                        class="games-card"
                    >

                        <!-- IMAGEN -->

                        <div class="games-card-image">

                            <img
                                v-if="game.image"
                                :src="`/uploads/games/${game.image}`"
                                :alt="game.title"
                            >

                            <div
                                v-else
                                class="games-card-placeholder"
                            >
                                <i class="fa-solid fa-gamepad"></i>
                            </div>

                            <div class="games-card-overlay">
                                <i class="fa-solid fa-eye"></i>
                                <span>Ver detalles</span>
                            </div>

                        </div>

                        <!-- INFORMACIÓN -->

                        <div class="games-card-body">

                            <h4 class="games-card-title">
                                {{ game.title }}
                            </h4>

                            <p
                                v-if="game.size_mb"
                                class="games-card-size"
                            >
                                {{ game.size_mb }}
                            </p>

                            <div class="games-card-tags">

                                <span
                                    v-for="p in game.platforms"
                                    :key="'p'+p.id"
                                    class="games-card-tag"
                                >
                                    {{ p.name }}
                                </span>

                                <span
                                    v-for="c in game.categories"
                                    :key="'c'+c.id"
                                    class="games-card-tag"
                                >
                                    {{ c.name }}
                                </span>

                            </div>

                        </div>

                    </a>

                </div>

            </main>
        </div>
    </div>

</template>

<script>
export default {

    props: {
        platforms: { type: Array, default: () => [] },
        regions: { type: Array, default: () => [] },
        categories: { type: Array, default: () => [] },
        initialGames: { type: Array, default: () => [] }
    },

    data() {
        return {

            search: '',
            platform: '',
            region: '',
            category: '',
            letter: '',

            alphabet: [
                'A','B','C','D','E','F','G',
                'H','I','J','K','L','M','N',
                'Ñ','O','P','Q','R','S','T',
                'U','V','W','X','Y','Z','#'
            ],

            games: this.initialGames,

            loading: false,

            timeout: null

        };
    },

    mounted() {
        this.syncFromUrl();
    },

    watch: {

        search(value) {

            // Si escribe algo en búsqueda,
            // quitamos filtro por letra
            if (value && this.letter) {
                this.letter = '';
            }

            this.updateUrl();
            this.debounceFetch();
        },

        platform() {
            this.updateUrl();
            this.fetch();
        },

        region() {
            this.updateUrl();
            this.fetch();
        },

        category() {
            this.updateUrl();
            this.fetch();
        },

        letter() {
            this.updateUrl();
            this.fetch();
        }

    },

    methods: {

        /* ======================
            URL -> VUE
        ====================== */

        syncFromUrl() {

            const q = new URLSearchParams(window.location.search);

            this.search = q.get('search') || '';

            this.platform = q.get('platform')
                ? Number(q.get('platform'))
                : '';

            this.region = q.get('region')
                ? Number(q.get('region'))
                : '';

            this.category = q.get('category')
                ? Number(q.get('category'))
                : '';

            this.letter = q.get('letter') || '';

            this.fetch();

        },

        /* ======================
            VUE -> URL
        ====================== */

        updateUrl() {

            const params = new URLSearchParams();

            if (this.search)
                params.set('search', this.search);

            if (this.platform)
                params.set('platform', this.platform);

            if (this.region)
                params.set('region', this.region);

            if (this.category)
                params.set('category', this.category);

            if (this.letter)
                params.set('letter', this.letter);

            const url = '/juegos?' + params.toString();

            window.history.replaceState({}, '', url);

        },

        /* ======================
            BUSQUEDA
        ====================== */

        debounceFetch() {

            clearTimeout(this.timeout);

            this.timeout = setTimeout(() => {

                this.fetch();

            }, 400);

        },

        /* ======================
            API
        ====================== */

        fetch() {

            this.loading = true;

            axios.get('/api/games/search', {

                params: {

                    search: this.search,
                    platform: this.platform,
                    region: this.region,
                    category: this.category,
                    letter: this.letter

                }

            })
            .then(response => {

                this.games = response.data;

            })
            .finally(() => {

                this.loading = false;

            });

        }

    }

};
</script>

<style scoped>


/* ======================
    LAYOUT GAMER
====================== */
.layout {
    display: flex;
    gap: 16px;
    padding: 16px;
}

/* ==========================================
   SIDEBAR PREMIUM NEON
========================================== */

.sidebar {
    background: rgba(7, 11, 26, 0.92);

    border: 1px solid rgba(139, 92, 246, 0.15);
    border-radius: 16px;

    padding: 18px;

    overflow: hidden;

    transition: all .3s ease;
}

.sidebar::after {
    content: "";
    position: absolute;
    top: 0;
    left: 20%;
    width: 60%;
    height: 2px;
    background: linear-gradient(90deg, #3b82f6, #8b5cf6, #ec4899);
    opacity: .5;
}



/* neon line */
.sidebar::after {
    content: "";

    position: absolute;
    top: 0;
    left: 20%;

    width: 60%;
    height: 2px;

    background: linear-gradient(
        90deg,
        #3b82f6,
        #8b5cf6,
        #ec4899
    );
}

.sidebar > * {
    position: relative;
    z-index: 2;
}

.sidebar:hover {
    border-color: rgba(168,85,247,.35);

    box-shadow:
        0 0 10px rgba(59,130,246,.12),
        0 0 25px rgba(139,92,246,.15),
        0 0 40px rgba(236,72,153,.08);
}

/* ==========================================
   TITULO
========================================== */

.sidebar h3 {
    color: #f8fafc;
    font-size: 22px;
    font-weight: 800;
    margin-bottom: 18px;
}

/* ==========================================
   FILTERS
========================================== */

.filter-block {
    margin-bottom: 18px;
}

.filter-title {
    display: block;

    margin-bottom: 8px;

    color: #94a3b8;
    font-size: 12px;
    font-weight: 700;

    text-transform: uppercase;
    letter-spacing: 1px;
}

/* ==========================================
   INPUTS
========================================== */

.input {
    width: 100%;

    padding: 12px 14px;

    border-radius: 12px;

    background: rgba(255,255,255,.03);

    border: 1px solid rgba(168,85,247,.15);

    color: #f8fafc;

    transition: .25s ease;
}

.input::placeholder {
    color: #64748b;
}

.input:focus {
    outline: none;

    border-color: rgba(168,85,247,.45);

    box-shadow:
        0 0 0 3px rgba(168,85,247,.12),
        0 0 15px rgba(59,130,246,.10);
}

/* ==========================================
   TAGS
========================================== */

.tag {
    background: rgba(255,255,255,.03) !important;

    border: 1px solid rgba(168,85,247,.15);

    color: #cbd5e1;

    border-radius: 999px !important;

    transition: .25s ease;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    padding: 6px 14px;

    min-height: 32px;

    white-space: nowrap;

    text-align: center;
}

.tag:hover {
    border-color: rgba(168,85,247,.45);

    color: #fff;

    box-shadow:
        0 0 8px rgba(139,92,246,.15);
}

.tag.active {
    background: rgba(168,85,247,.15) !important;

    border: 1px solid rgba(168,85,247,.45);

    color: #fff;

    box-shadow:
        0 0 10px rgba(59,130,246,.15),
        0 0 20px rgba(168,85,247,.15);
}

/* ======================
    CONTENT
====================== */
.content {
    flex: 2;
}

</style>