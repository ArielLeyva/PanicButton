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
                const items = []
                if (this.buttons[""] !== undefined) {
                    items.push(...this.buttons[""])
                }
                if (this.buttons.Activo !== undefined) {
                    items.push(...this.buttons.Activo)
                }
                if (this.buttons.Bloqueado !== undefined) {
                    items.push(...this.buttons.Bloqueado)
                }
                for (let key in params) {
                    switch (key) {
                        case "state":
                            if (this.buttons[params[key]] !== undefined) {
                                this.display.push(...this.buttons[params[key]])
                            }
                            break
                        case "desvinculated":
                            if (params[key]) {
                                for (let button of items) {
                                    if (button.client.name == "Sin asignar") {
                                        this.display.push(button)
                                    }
                                }
                            }
                            break
                        case "all":
                            this.display.push(...items)
                            break
                        case "number":
                            for (let button of items) {
                                if (params[key] == null || button.number.toString().includes(params[key])) {
                                    this.display.push(button)
                                }
                            }
                            break
                        case "client":
                            const client = params.client
                            this.display = items.filter((button) => {
                                for (let key in client) {
                                    if (client[key] !== "") {
                                        switch (key) {
                                            case "name":
                                            case "dni":
                                                if (button.client[key] == undefined || !button.client[key].toString().toLowerCase().includes(client[key].toString().toLowerCase())) {
                                                    return false
                                                }
                                                break
                                            case "state":
                                            case "gender":
                                                if (button.client[key] !== client[key]) {
                                                    return false
                                                }
                                                break
                                        }
                                    }
                                }
                                return true
                            })
                            break
                    }
                }
            },
            remove(index) {
                const button = this.display[index]
                this.display.splice(index, 1)
                this.splice(this.buttons[""])
                this.splice(this.buttons.Activo, button)
                this.splice(this.buttons.Bloqueado, button)
            },
            splice(items, button) {
                if (items !== undefined) {
                    for (let i in items) {
                        if (items[i].id == button.id) {
                            items.splice(i, 1)
                            break
                        }
                    }
                }
            },
            add(button) {
                // if (button.state == "Connected") {
                //     if (this.buttons.Connected == undefined) this.buttons.Connected = []
                //     this.buttons.Connected.unshift(button)
                // } else {
                //     if (this.buttons.Disconnected == undefined) this.buttons.Disconnected = []
                //     this.buttons.Disconnected.unshift(button)
                // }
                this.buttons[""].unshift(button)
                this.display.unshift(button)
            },
        },
        mounted() {
            Request.get("api/buttons").then((response) => {
                console.log(response)
                this.buttons = response.data
                if (this.buttons[""] !== undefined) {
                    this.display.push(...this.buttons[""])
                }
                if (this.buttons.Activo !== undefined) {
                    this.display.push(...this.buttons.Activo)
                }
                if (this.buttons.Bloqueado !== undefined) {
                    this.display.push(...this.buttons.Bloqueado)
                }
                this.$emit("load", this.buttons)
            })
        },
    }
</script>

<template>
    <div>
        <div class="main scroll">
            <Navbar @added="add" @filter="filter" />
            <div class="buttons-list">
                <NotFound v-if="display.length == 0" />
                <ButtonInfo v-for="(button, index) in display" @remove="remove" :button="button" :index="index" :clients="clients" />
            </div>
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
