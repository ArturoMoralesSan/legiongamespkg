<template>
    <form
        class="search-form__dashboard search-form-width"
        action=""
        method="get"
        @submit.prevent
    >
        <div class="row">

            <div class="col-1/3">

                <input
                    class="form-field search-form_input"
                    name="search"
                    placeholder="Buscar"
                    ref="searchinput"
                    :value="selected"
                    @input="search"
                >

            </div>

            <div class="col-1/3">

                <select
                    v-if="platforms.length"
                    class="form-field"
                    v-model="platform"
                    @change="filter"
                >
                    <option value="">
                        Todas las plataformas
                    </option>

                    <option
                        v-for="item in platforms"
                        :key="item.id"
                        :value="String(item.id)"
                        v-text="item.name"
                    ></option>

                </select>

            </div>

            <div class="col-1/3">

                <select
                    v-if="categories.length"
                    class="form-field"
                    v-model="category"
                    @change="filter"
                >
                    <option value="">
                        Todas las categorías
                    </option>

                    <option
                        v-for="item in categories"
                        :key="item.id"
                        :value="String(item.id)"
                        v-text="item.name"
                    ></option>

                </select>

            </div>

        </div>
    </form>
</template>

<script>
export default {

    props: {

        selected: {
            type: String,
            default: '',
            required: false
        },

        platforms: {
            type: Array,
            default: function () {
                return [];
            }
        },

        categories: {
            type: Array,
            default: function () {
                return [];
            }
        },

        selectedPlatform: {
            type: [String, Number],
            default: ''
        },

        selectedCategory: {
            type: [String, Number],
            default: ''
        }

    },

    data() {
        return {
            platform: String(this.selectedPlatform || ''),
            category: String(this.selectedCategory || ''),
            searchTimeout: null
        };
    },

    methods: {

        search() {

            clearTimeout(this.searchTimeout);

            this.searchTimeout = setTimeout(() => {

                this.filter();

            }, 1000);

        },

        filter() {

            let queryString = window.location.search;

            let urlParams =
                new URLSearchParams(queryString);

            let reloadUrl =
                this.$root.path + window.location.pathname;

            let search =
                this.$refs.searchinput.value.trim();

            if (search) {

                urlParams.set(
                    'search',
                    search
                );

            } else {

                urlParams.delete('search');

            }

            if (this.platform) {

                urlParams.set(
                    'platform',
                    this.platform
                );

            } else {

                urlParams.delete('platform');

            }

            if (this.category) {

                urlParams.set(
                    'category',
                    this.category
                );

            } else {

                urlParams.delete('category');

            }

            urlParams.delete('page');

            let urlParameter =
                reloadUrl + '?' + urlParams.toString();

            window.location.href =
                urlParameter;

        }

    }

};
</script>
