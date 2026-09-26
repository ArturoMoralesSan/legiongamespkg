<template>

    <div class="box box--lg bg-white b-1 rounded relative">

        <h3>
            Enlace {{ index }}
        </h3>

        <button
            v-if="index > minLink"
            class="btn btn--danger btn--xs rounded-0 absolute top-0 right-0"
            type="button"
            @click="$emit('removeLink', index)"
        >
            Eliminar
        </button>

        <div class="row mb-4">

            <div class="md:col-1/2 sm:col">

                <div class="form-control">

                    <label :for="'link' + index + '_name'">
                        Nombre
                    </label>

                    <text-field
                        :name="'link' + index + '_name'"
                        v-model="fields['link' + index + '_name']"
                        :initial="initial ? initial.title : ''"
                    ></text-field>

                    <field-errors
                        :name="'link' + index + '_name'"
                    ></field-errors>

                </div>

            </div>

            <div class="md:col-1/2 sm:col">

                <div class="form-control">

                    <label :for="'link' + index + '_url'">
                        URL
                    </label>

                    <text-field
                        :name="'link' + index + '_url'"
                        v-model="fields['link' + index + '_url']"
                        :initial="initial ? initial.url : ''"
                    ></text-field>

                    <field-errors
                        :name="'link' + index + '_url'"
                    ></field-errors>

                </div>

            </div>

        </div>

    </div>

</template>

<script>

import TextField from '../base/TextField.vue';
import FieldErrors from '../base/FieldErrors.vue';

export default {

    components: {
        TextField,
        FieldErrors
    },

    props: {

        index: {
            type: Number,
            required: true
        },

        minLink: {
            type: Number,
            required: true
        },

        fields: {
            type: Object,
            required: true
        },

        errors: {
            type: Object,
            required: true
        },

        initial: {
            type: Object,
            default: function () {
                return null;
            }
        }

    }

};

</script>