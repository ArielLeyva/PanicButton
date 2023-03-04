<script>
    import Dropdown from "bootstrap/js/dist/dropdown"
    export default {
        emits: ["filter"],
        data() {
            return {
                active: "Todos",
            }
        },
        methods: {
            filter(params) {
                this.$emit("filter", params)
                if (params.all) {
                    this.active = "Todos"
                } else if (params.state !== undefined) {
                    if (params.state == "Connected") this.active = "Conectados"
                    else this.active = "Desconectados"
                } else {
                    this.active = "Sin asignar"
                }
            },
        },
    }
</script>
<template>
    <div class="bg-white flex p-3 rounded items-center">
        <div class="dropdown me-1">
            <button class="dropdown-toggle font-bold" data-bs-toggle="dropdown">{{active}}</button>
            <ul class="dropdown-menu">
                <li>
                    <button @click="filter({ all: true })" class="dropdown-item">Todos los dispositivos</button>
                </li>
                <li>
                    <button @click="filter({ state: 'Connected' })" class="dropdown-item">Dispositivos conectados</button>
                </li>
                <li>
                    <button @click="filter({ state: 'Disconnected' })" class="dropdown-item">Dispositivos desconectados</button>
                </li>
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <li>
                    <button @click="filter({ desvinculated: true })" class="dropdown-item">Sin asignar</button>
                </li>
            </ul>
        </div>
        <div class="flex justify-end w-full">
            <button class="mx-1 rounded-xl w-8">
                <i class="bi bi-filter"></i>
            </button>
            <button class="mx-1 rounded-xl w-8">
                <i class="bi bi-search"></i>
            </button>
            <button class="mx-1 rounded-xl w-8 bg-indigo-500 text-white">
                <i class="bi bi-plus"></i>
            </button>
        </div>
    </div>
</template>
