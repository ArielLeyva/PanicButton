<script>
    export default {
        /**
         * @emit change: Se emite cuando se cambia la ventana activa en un dispositivo de pequeñas dimensiones
         */
        emits: ["change"],
        data() {
            return {
                /**
                 * Identificador de la ventana activa
                 */
                window: null,
            }
        },
        methods: {
            /**
             * Actualizar ventana activa
             */
            update() {
                if (document.body.offsetWidth >= 768) {
                    this.window = null
                } else if (this.window == null) {
                    this.window = "buttons"
                }
                this.$emit("change", this.window)
            },
            /**
             * Cambiar la ventana activa
             */
            change(window) {
                this.window = window
                this.$emit("change", window)
            },
        },
        mounted() {
            this.update()
            //Añadir evento para cuando se redimensione la ventana actualizar la ventana activa
            window.addEventListener("resize", () => {
                this.update()
            })
        },
    }
</script>
<template>
    <footer class="z-50 justify-center flex md:hidden fixed bottom-0 w-full bg-white dark:bg-slate-600 shadow-md p-2 border-slate-600 border-t" style="border-width: 1px;">
        <button @click="change('buttons')" :class="{ 'dark:text-white text-gray-700': window == 'buttons', 'text-gray-400': window !== 'buttons' }" class="w-1/2 btn-sm">
            <i class="bi bi-joystick"></i>
            <br />
            Dispositivos
        </button>
        <button @click="change('clients')" :class="{ 'dark:text-white text-gray-700': window == 'clients', 'text-gray-400': window !== 'clients' }" class="w-1/2 btn-sm">
            <i class="bi bi-person"></i>
            <br />
            Alertas y clientes
        </button>
    </footer>
</template>
