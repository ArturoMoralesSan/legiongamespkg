<template>
    <div class="multi-select">

        <label v-if="label">{{ label }}</label>

        <div class="multi-select-box">

            <div
                v-for="option in options"
                :key="option.id"
                class="multi-select-item"
                :class="{ active: isSelected(option.id) }"
                @click="toggle(option.id)"
            >
                {{ option.name }}
            </div>

        </div>

        <!-- enviar array a Laravel -->
        <input
            v-for="id in value"
            :key="'ms-' + id"
            type="hidden"
            :name="name"
            :value="id"
        >

    </div>
</template>

<script>
export default {
    props: {

        // v-model (Vue 2)
        value: {
            type: Array,
            default: function () {
                return [];
            }
        },

        options: {
            type: Array,
            default: function () {
                return [];
            }
        },

        name: {
            type: String,
            required: true
        },

        label: {
            type: String,
            default: ''
        },

        // opcional para edición
        initial: {
            type: Array,
            default: function () {
                return [];
            }
        }
    },

    mounted() {
        // SOLO inicializa si viene vacío
        if (this.value.length === 0 && this.initial.length > 0) {
            this.$emit('input', this.initial);
        }
    },

    methods: {

        toggle(id) {

            var selected = this.value.slice();

            var index = selected.indexOf(id);

            if (index > -1) {
                selected.splice(index, 1);
            } else {
                selected.push(id);
            }

            this.$emit('input', selected);
        },

        isSelected(id) {
            return this.value.indexOf(id) !== -1;
        }
    }
};
</script>

<style scoped>
.multi-select-box {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.multi-select-item {
    padding: 6px 10px;
    border: 1px solid #ccc;
    cursor: pointer;
    border-radius: 6px;
    font-size: 13px;
    user-select: none;
    transition: all .2s ease;
}

.multi-select-item:hover {
    border-color: #4f46e5;
}

.multi-select-item.active {
    background: #4f46e5;
    color: white;
    border-color: #4f46e5;
}
</style>