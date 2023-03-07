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
    <div class="justify-center flex md:hidden mb-1">
        <button @click="change('buttons')" :class="{ 'bg-indigo-500': window == 'buttons', 'bg-indigo-300': window !== 'buttons' }" class="rounded-lg text-white mx-1 p-2 btn-sm">Dispositivos</button>
        <button @click="change('clients')" :class="{ 'bg-indigo-500': window == 'clients', 'bg-indigo-300': window !== 'clients' }" class="rounded-lg bg-indigo-300 text-white mx-1 p-2 btn-sm">Alertas y clientes</button>
    </div>
</template>
