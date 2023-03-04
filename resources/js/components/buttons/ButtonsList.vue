<script>
    import Navbar from "./Navbar.vue"
    import ButtonInfo from "./ButtonInfo.vue"
    import NotFound from "./NotFound.vue"
    import Request from "../../Request.js"

    export default {
        components: { ButtonInfo, Navbar, NotFound },
        emits: ["load"],
        props: {
            clients: Array,
        },
        data() {
            return {
                buttons: [],
                display: [],
            }
        },
        methods: {
            filter(params) {
                this.display = []
                for (let key in params) {
                    switch (key) {
                        case "state":
                            if (this.buttons[params[key]] !== undefined) {
                                this.display.push(...this.buttons[params[key]])
                            }
                            break
                        case "desvinculated":
                            if (params[key]) {
                                const items = []
                                if (this.buttons.Connected !== undefined) {
                                    items.push(...this.buttons.Connected)
                                }
                                if (this.buttons.Disconnected !== undefined) {
                                    items.push(...this.buttons.Disconnected)
                                }
                                for (let button of items) {
                                    if (button.client.name == "Sin asignar") {
                                        this.display.push(button)
                                    }
                                }
                            }
                            break
                        case "all":
                            this.display.push(...this.buttons.Connected)
                            this.display.push(...this.buttons.Disconnected)
                            break
                    }
                }
            },
        },
        mounted() {
            Request.get("api/buttons").then((response) => {
                this.buttons = response.data
                if (this.buttons.Disconnected !== undefined) {
                    this.display.push(...this.buttons.Disconnected)
                }
                if (this.buttons.Connected !== undefined) {
                    this.display.push(...this.buttons.Connected)
                }
                this.$emit("load", this.buttons)
            })
        },
    }
</script>

<template>
    <div class="main scroll">
        <Navbar @filter="filter" />
        <div class="buttons-list">
            <NotFound v-if="display.length == 0" />
            <ButtonInfo v-for="button in display" :button="button" :clients="clients" />
        </div>
    </div>
</template>
<style scoped>
    .main {
        max-height: calc(100vh - 6rem);
        overflow: auto;
    }
    .buttons-list {
        min-height: calc(100vh - 10rem);
    }
</style>
