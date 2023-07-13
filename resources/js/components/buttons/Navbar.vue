<script>
import Dropdown from "bootstrap/js/dist/dropdown"
import Request from "../../Request.js"

import ClientFilter from "../filter/ClientFilter.vue"
import Modal from "../modal/Modal.js"
import ModalButton from "../modal/ModalButton.js"
import ModalInput from "../modal/ModalInput.js"

import Alert from "../alert/Alert.js"
import AlertConfig from "../alert/AlertConfig.js"

export default {
    /**
     * @emit filter: Se emite cuando se selecciona algún filtro
     */
    emits: ["filter"],
    components: { ClientFilter },
    props: {
        /**
         * Lista de botones en la base de datos
         */
        backup: Array,
    },
    data() {
        return {
            /**
             * Nombre del filtro de botones activo
             */
            active: "Todos",
            /**
             * <code>true</code> si se está buscando un botón por su identificador
             */
            isSearching: false,
            /**
             * Identificador del botón introducido por el usuario para buscar
             */
            number: null,
        }
    },
    methods: {
        /**
         * Aplicar un filtro a la lista de botones
         * @param {Object} params: Lista de filtros a aplicar
         */
        filter(params) {
            const items = this.backup.filter((button) => {
                //Iterar sobre todos los parámetros del filtro
                for (let key in params) {
                    //Valor del parámetro de filtro
                    const param = params[key]
                    switch (key) {
                        case "state":
                            this.active = param == "Connected" ? "Conectados" : "Desconectados"
                            if (button.state !== param) {
                                return false
                            }
                            break
                        case "desvinculated":
                            this.active = "Desvinculados"
                            if (button.client_id !== null) {
                                return false
                            }
                            break
                        case "all":
                            //Actualizar nombre del filtro activo
                            this.active = "Todos"
                            break
                        case "client":
                            //Actualizar nombre del filtro activo
                            this.active = "Cliente"
                            //Verificar si el cliente asigando al botón cumple con los requisitos del filtro
                            if (!this.Utils.filter(button.client, param)) {
                                return false
                            }
                            break
                    }
                    //Retornar true si la alerta cumple con todos los parámetros del filtro
                    return true
                }
            })
            //Emitir evento
            this.$emit("filter", items)
        },
        /**
         * Quitar el filtro aplicado sobre la lista de botones
         */
        reset() {
            this.filter({ all: true })
        },
        /**
         * Mostrar formulario para buscar un dispositivo por su número de identificación
         */
        search() {
            this.isSearching = !this.isSearching
            if (this.isSearching) {
                this.number = ""
            } else {
                this.number = null
                this.filter({ number: this.number })
                this.active = "Todos"
            }
        },
        /**
         * Registrar un nuevo botón
         */
        add() {
            /**
             * Constuir el modal para pedir el número de identificación del botón al usuario
             */
            const modal = new Modal({
                title: "Registrar un nuevo dispositivo",
                icon: "bi bi-joystick",
                background: "#157347",
                inputs: [
                    new ModalInput({
                        label: "Identificador del dispositivo",
                        name: "number",
                        icon: "bi bi-joystick",
                    }),
                ],
                accept: new ModalButton({
                    classes: "btn-success text-success hover:text-white",
                    text: "Registrar",
                }),
            })
            //Mostrar el modal
            modal.fire().then((result) => {
                if (result.status == "accept") {
                    //Si el usuario presiona registrar hacer la petición
                    Request.post("api/buttons", result.data).then((data) => {
                        //Emitir el evento
                        this.$emit("added", data)
                        this.emitter.emit("button-added", this.button)
                        //Mostrar la notificación de eliminación en la pantalla
                        this.Utils.notify("Se ha registrado un nuevo dispositivo")
                    })
                }
            })
        },
    },
}
</script>
<template>
    <div class="bg-white dark:bg-slate-800 flex p-3 rounded items-center">
        <div class="dropdown me-1" v-if="!isSearching">
            <button class="dropdown-toggle font-bold dark:text-white" data-bs-toggle="dropdown">{{ active }}</button>
            <ul class="dropdown-menu dark:bg-slate-700">
                <li>
                    <button @click="filter({ all: true })"
                        class="dropdown-item dark:text-gray-50 dark:hover:bg-slate-400 dark:hover:text-white">Todos los
                        dispositivos</button>
                </li>
                <li>
                    <button @click="filter({ state: 'Connected' })"
                        class="dropdown-item dark:text-gray-50 dark:hover:bg-slate-400 dark:hover:text-white">Dispositivos
                        conectados</button>
                </li>
                <li>
                    <button @click="filter({ state: 'Disconnected' })"
                        class="dropdown-item dark:text-gray-50 dark:hover:bg-slate-400 dark:hover:text-white">Dispositivos
                        desconectados</button>
                </li>
                <li>
                    <hr class="dropdown-divider dark:border-gray-500" />
                </li>
                <li>
                    <button @click="filter({ desvinculated: true })"
                        class="dropdown-item dark:text-gray-50 dark:hover:bg-slate-400 dark:hover:text-white">Sin
                        asignar</button>
                </li>
            </ul>
        </div>
        <div v-else>
            <input @input="filter({ number: number })" v-model="number"
                class="border border-gray-400 dark:border-gray-50 dark:text-gray-50 dark:placeholder:text-gray-50 dark:bg-slate-500 rounded pl-2 focus-visible:outline-none w-40"
                name="number" type="text" placeholder="Nº de identificación" />
        </div>
        <div class="flex justify-end w-full">
            <ClientFilter @filter="filter" @reset="reset" v-if="!isSearching" />
            <!-- <button class="mx-1 rounded-xl w-8" @click="search">
                <i class="bi bi-search dark:text-gray-50" :class="{ 'bi-search': !isSearching, 'bi-x': isSearching }"></i>
            </button> -->
            <button @click="add" class="mx-1 rounded-xl w-8 bg-indigo-500 text-white">
                <i class="bi bi-plus"></i>
            </button>
        </div>
    </div>
</template>
