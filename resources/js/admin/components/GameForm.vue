<script>
import BaseForm from '../../main/components/forms/base/BaseForm.vue';

export default {
    extends: BaseForm,

    props: {
        synopsisAction: {
            type: String,
            required: true
        }
    },

    data() {
        return {
            isGeneratingSynopsis: false
        };
    },

    methods: {
        /**
         * Generar sinopsis del videojuego con Gemini.
         */
        generateSynopsis() {
            if (!this.fields.title || !this.fields.title.trim()) {
                alert('Primero escribe el título del videojuego.');
                return;
            }

            if (this.isGeneratingSynopsis) {
                return;
            }

            this.isGeneratingSynopsis = true;

            window.axios.post(
                this.synopsisAction,
                {
                    title: this.fields.title
                }
            )
            .then(response => {

                if (
                    response.data &&
                    response.data.success &&
                    response.data.synopsis
                ) {
                    const synopsis =
                        response.data.synopsis.trim();

                    this.$set(
                        this.fields,
                        'synopsis',
                        synopsis
                    );

                    console.log(
                        'SINOPSIS GENERADA:',
                        synopsis
                    );

                    console.log(
                        'FIELDS DESPUÉS DE GEMINI:',
                        this.fields
                    );
                }

            })
            .catch(error => {

                console.error(
                    'Error al generar la sinopsis:',
                    error
                );

                let message =
                    'No fue posible generar la sinopsis.';

                if (
                    error.response &&
                    error.response.data &&
                    error.response.data.error
                ) {
                    message =
                        error.response.data.error;
                } else if (
                    error.response &&
                    error.response.data &&
                    error.response.data.message
                ) {
                    message =
                        error.response.data.message;
                }

                alert(message);
            })
            .finally(() => {
                this.isGeneratingSynopsis = false;
            });
        }
    }
};
</script>
