<script>
    import BaseForm from '../../main/components/forms/base/BaseForm.vue';

    export default {
        extends: BaseForm,

        data() {
            return {
                fields: {
                    vinil_cost: "0",
                    impresion_cost: "0",
                    indirect_cost: "0",
                    subtotal: "0",
                    iva: "0",
                    costo_total: "0",
                    costo_venta: "0",
                    utility: "0"
                }
            };
        },
        watch: {
            fields: {
                deep: true,
                handler() {
                    // Función para limpiar y convertir valores a número
                    const parseNumber = (value) => {
                        if (typeof value === "string") {
                            value = value.replace(/,/g, ""); // Eliminar comas en caso de miles
                        }
                        const num = parseFloat(value);
                        return isNaN(num) ? 0 : num; // Si es NaN, devolver 0
                    };

                    // Convertir valores
                    const vinil = parseNumber(this.fields.vinil_cost);
                    const impresion = parseNumber(this.fields.impresion_cost);
                    const indirecto = parseNumber(this.fields.indirect_cost);
                    const utility = parseNumber(this.fields.utility);

                    // Calcular valores
                    this.fields.subtotal = (vinil + impresion + indirecto).toFixed(4);
                    this.fields.costo_total = (parseNumber(this.fields.subtotal) * (1 + utility / 100)).toFixed(4);
                    this.fields.iva = (parseNumber(this.fields.costo_total) * 0.16).toFixed(4);
                    this.fields.costo_venta = (parseNumber(this.fields.costo_total) + parseNumber(this.fields.iva)).toFixed(4);

                }
            }

        }

    }
</script>
