<script>
    import Dropdown from "bootstrap/js/dist/dropdown"
    export default {
        emits: ["filter"],
        data() {
            return {
                active: "Todos",
                isSearching: false,
                number: null,
            }
        },
        methods: {
            filter(params) {
                if (params == undefined) {
                    params = { client: {} }
                    const data = new FormData(this.$el.querySelector("form"))
                    for (let entry of data.entries()) {
                        params.client[entry[0]] = entry[1]
                    }
                    this.active = "Filtro"
                } else {
                    if (params.all) {
                        this.active = "Todos"
                    } else if (params.state !== undefined) {
                        if (params.state == "Connected") this.active = "Conectados"
                        else this.active = "Desconectados"
                    } else {
                        this.active = "Sin asignar"
                    }
                }
                this.$emit("filter", params)
            },
            reset() {
                this.$emit("filter", { all: true })
                this.active = "Todos"
            },
            search() {
                this.isSearching = !this.isSearching
                if (this.isSearching) {
                    this.number = ""
                } else {
                    this.number = null
                    this.$emit("filter", { number: this.number })
                    this.active = "Todos"
                }
            },
        },
    }
</script>
<template>
    <div class="bg-white flex p-3 rounded items-center">
        <div class="dropdown me-1" v-if="!isSearching">
            <button class="dropdown-toggle font-bold" data-bs-toggle="dropdown">{{ active }}</button>
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
        <div v-else>
            <input @input="filter({ number: number })" v-model="number" class="border border-gray-400 rounded pl-2 focus-visible:outline-none w-40" name="number" type="text" placeholder="Nº de identificación" />
        </div>
        <div class="flex justify-end w-full">
            <form @change="filter()" @input="filter()" @reset="reset" class="dropdown">
                <button data-bs-toggle="dropdown" v-if="!isSearching" class="mx-1 rounded-xl w-8">
                    <i class="bi bi-filter"></i>
                </button>
                <ul class="dropdown-menu p-2">
                    <li>
                        <p class="text-center text-indigo-500">Datos del cliente</p>
                    </li>
                    <li class="flex items-center px-2 relative border-b-gray-200 border-b py-2">
                        <i class="bi bi-person absolute top-3 left-4 text-gray-500"></i>
                        <input class="border border-gray-400 rounded focus-visible:outline-none pl-8 py-1" name="name" type="text" placeholder="Nombre del cliente" />
                    </li>
                    <li class="flex items-center px-2 relative border-b-gray-200 border-b py-2">
                        <i class="bi bi-person-vcard absolute top-3 left-4 text-gray-500"></i>
                        <input class="border border-gray-400 rounded focus-visible:outline-none pl-8 py-1" name="dni" type="text" placeholder="DNI del cliente" />
                    </li>
                    <li class="p-2 border-b-gray-200 border-b">
                        <p class="text-gray-400 font-bold">Sexo:</p>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="" name="gender" checked />
                            <label class="form-check-label">Sin especificar</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="Femenino" name="gender" />
                            <label class="form-check-label">Femenino</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="Masculino" name="gender" />
                            <label class="form-check-label">Masculino</label>
                        </div>
                    </li>
                    <li class="p-2">
                        <p class="text-gray-400 font-bold">Estado del servicio:</p>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="" name="state" checked />
                            <label class="form-check-label">Sin especificar</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="Activo" name="state" />
                            <label class="form-check-label">Activo</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="Inactivo" name="state" />
                            <label class="form-check-label">Inactivo</label>
                        </div>
                    </li>
                    <li class="mt-1">
                        <button type="reset" class="btn btn-sm btn-secondary w-full text-secondary hover:text-white">Limpiar filtro</button>
                    </li>
                </ul>
            </form>
            <button class="mx-1 rounded-xl w-8" @click="search">
                <i class="bi bi-search" :class="{ 'bi-search': !isSearching, 'bi-x': isSearching }"></i>
            </button>
            <button class="mx-1 rounded-xl w-8 bg-indigo-500 text-white">
                <i class="bi bi-plus"></i>
            </button>
        </div>
    </div>
</template>
