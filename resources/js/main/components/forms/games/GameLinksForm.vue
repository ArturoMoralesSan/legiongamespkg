<template>

    <div>

        <div
            v-for="i in fields.links_count"
            :key="i"
            class="mb-4"
        >

            <GameLink
                :index="i"
                :min-link="minLink"
                :fields="fields"
                :errors="errors"
                :initial="initialLinks[i - 1] || null"
                @removeLink="removeLink"
            >
            </GameLink>

        </div>

        <div class="pt-4">

            <button
                type="button"
                class="btn btn--light"
                @click="addLink"
            >

                <img
                    class="mr-1 align-top"
                    :src="$root.path + '/img/svg/plus-circle-primary.svg'"
                    alt=""
                    width="20px"
                >

                <span class="align-top">
                    Agregar enlace
                </span>

            </button>

        </div>

    </div>

</template>

<script>

import GameLink from './GameLink.vue';

export default {

    components: {
        GameLink
    },

    props: {

        fields: {
            type: Object,
            required: true
        },

        errors: {
            type: Object,
            required: true
        },

        /*
         * Enlaces existentes.
         * En crear llegará vacío.
         * En editar llegará con los enlaces guardados.
         */
        initialLinks: {
            type: Array,
            default: function () {
                return [];
            }
        }

    },

    data() {

        return {

            minLink: 0

        };

    },

    mounted() {

        /*
         * Si existen enlaces guardados,
         * cargarlos en los campos dinámicos.
         */
        if (this.initialLinks.length > 0) {

            this.$set(
                this.fields,
                'links_count',
                this.initialLinks.length
            );

            this.initialLinks.forEach((link, index) => {

                const position = index + 1;

                this.$set(
                    this.fields,
                    'link' + position + '_name',
                    link.name || ''
                );

                this.$set(
                    this.fields,
                    'link' + position + '_url',
                    link.url || ''
                );

            });

        } else {

            /*
             * Si el padre todavía no creó links_count,
             * lo creamos aquí.
             */
            if (
                typeof this.fields.links_count === 'undefined' ||
                !this.fields.links_count
            ) {

                this.$set(
                    this.fields,
                    'links_count',
                    this.minLink
                );

            }

        }

    },

    methods: {

        /**
         * Agregar un enlace.
         */
        addLink() {

            this.fields.links_count++;

        },

        /**
         * Copiar los campos de un enlace a otro.
         */
        copyLinkFields(source, target) {

            const regex = new RegExp(
                '^link' + source + '_'
            );

            for (let field in this.fields) {

                if (regex.test(field)) {

                    this.$set(
                        this.fields,
                        field.replace(
                            'link' + source + '_',
                            'link' + target + '_'
                        ),
                        this.fields[field]
                    );

                }

            }

        },

        /**
         * Eliminar los campos de un enlace.
         */
        deleteLinkFields(index) {

            const regex = new RegExp(
                '^link' + index + '_'
            );

            for (let field in this.fields) {

                if (regex.test(field)) {

                    this.$delete(
                        this.fields,
                        field
                    );

                }

            }

        },

        /**
         * Eliminar un enlace y reorganizar los índices.
         */
        removeLink(index) {

            for (
                let i = 0;
                i < this.fields.links_count - index;
                i++
            ) {

                this.copyLinkFields(
                    index + i + 1,
                    index + i
                );

            }

            this.deleteLinkFields(
                this.fields.links_count
            );

            this.fields.links_count--;

        }

    }

};

</script>