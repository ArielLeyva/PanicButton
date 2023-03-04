<script>
    export default {
        props: {
            backup: Array,
        },
        data() {
            return {
                active: "Todos",
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
                }
                const items = this.backup.filter((item) => {
                    for (let key in params) {
                        const param = params[key]
                        switch (key) {
                            case "asign":
                                if ((param && item.buttons.length == 0) || (!param && item.buttons.length !== 0)) {
                                    return false
                                }
                                this.active = param ? "Asignados" : "Sin asignar"
                                break
                            case "all":
                                this.active = "Todos"
                                break
                            case "client":
                                const client = params.client
                                for (let key in client) {
                                    if (client[key] !== "") {
                                        switch (key) {
                                            case "name":
                                            case "dni":
                                                if (item[key] == undefined || !item[key].toString().toLowerCase().includes(client[key].toString().toLowerCase())) {
                                                    return false
                                                }
                                                break
                                            case "state":
                                            case "gender":
                                                if (item[key] !== client[key]) {
                                                    return false
                                                }
                                                break
                                        }
                                    }
                                }
                                break
                        }
                        return true
                    }
                })
                this.$emit("filter", items)
            },
        },
    }
</script>
<template>
    <div>
        <div class="float-right flex mr-5">
            <form @change="filter()" @input="filter()" @reset="filter({ date: 30 * 86400000 })" class="dropdown">
                <button data-bs-toggle="dropdown" class="mx-1 rounded-xl w-8 mt-1 focus-visible:outline-indigo-500">
                    <i class="bi bi-filter"></i>
                </button>
                <ul class="dropdown-menu p-2">
                    <li>
                        <p class="text-center text-gray-500 font-bold">Datos del cliente</p>
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
                        <button type="reset" class="btn btn-sm border border-indigo-500 w-full text-indigo-500 hover:text-white hover:bg-indigo-500">Limpiar filtro</button>
                    </li>
                </ul>
            </form>
            <div class="dropdown p-1 pr-2">
                <button class="dropdown-toggle font-bold" data-bs-toggle="dropdown">{{ active }}</button>
                <ul class="dropdown-menu">
                    <li>
                        <button @click="filter({ asign: true })" class="dropdown-item">Clientes asignados</button>
                    </li>
                    <li>
                        <button @click="filter({ asign: false })" class="dropdown-item">Clientes sin asignar</button>
                    </li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li>
                        <button @click="filter({ all: true })" class="dropdown-item">Todos los clientes</button>
                    </li>
                </ul>
            </div>
        </div>
        <button class="btn btn-sm ml-5 text-indigo-500 border border-indigo-500 hover:text-white hover:bg-indigo-500">Registrar nuevo cliente</button>
    </div>
</template>
