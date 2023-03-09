<script>
    export default {
        emits: ["change"],
        data() {
            return {
                window: null,
            }
        },
        methods: {
            update() {
                if (document.body.offsetWidth >= 768) {
                    this.window = null
                } else if (this.window == null) {
                    this.window = "buttons"
                }
                this.$emit("change", this.window)
            },
            change(window) {
                this.window = window
                this.$emit("change", window)
            },
        },
        mounted() {
            this.update()
            window.addEventListener("resize", () => {
                this.update()
            })
        },
    }
</script>
<template>
    <footer class="z-50 justify-center flex md:hidden absolute bottom-0 w-full bg-white dark:bg-slate-600 shadow-md p-2 border-slate-800 border-t" style="border-width: 1px;">
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
