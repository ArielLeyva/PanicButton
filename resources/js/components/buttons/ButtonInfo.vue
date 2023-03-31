<script>
    import Dropdown from "bootstrap/js/dist/dropdown"
    import Request from "../../Request.js"

    import Modal from "../modal/Modal.js"
    import ModalButton from "../modal/ModalButton.js"
    import SelectClientModal from "./SelectClientModal.vue"
    import DetailsModal from "./DetailsModal.vue"

    import Alert from "../alert/Alert.js"
    import AlertConfig from "../alert/AlertConfig.js"

    export default {
        props: {
            /**
             * Datos del botón
             */
            button: Object,
            /**
             * Índice que ocupa el botón en la lista en pantalla
             */
            index: Number,
            /**
             * Lista de clientes en la base de datos
             */
            clients: Array,
        },
        methods: {
            /**
             * Asignar un cliente al botón
             */
            assign() {
                //Construir el modal para seleccionar el cliente
                const modal = new Modal(
                    {
                        window: "Vincular dispositivo a un cliente",
                        accept: new ModalButton({
                            classes: "btn-success text-success dark:text-green-400 dark:hover:text-white hover:text-white",
                            text: "Seleccionar",
                        }),
                    },
                    SelectClientModal,
                    [{ clients: this.clients }]
                )
                //Mostrar el modal
                modal.fire().then((result) => {
                    if (result.status == "accept") {
                        //Si el usuario elige un cliente hacer petición
                        const id = result.data.get("client_id")
                        const data = new FormData()
                        data.append("_method", "put")
                        Request.post(`api/buttons/assign/${this.button.id}/${id}`, data).then((button) => {
                            //Actualizar cliente del botón
                            this.button.client_id = button.client_id
                            this.button.client = button.client
                            //Mostrar la notificación de eliminación en la pantalla
                            this.Utils.notify("Se ha asignado un cliente a este dispositivo")
                        })
                    }
                })
            },
            /**
             * Desvincular cliente del botón
             */
            unassign() {
                //Construir un modal para pedir la confirmación del usuario
                const modal = new Modal({
                    title: "¿Seguro que desea desvincular este dispositivo del cliente?",
                    description: "Esta operación es irreversible",
                    icon: "bi bi-exclamation-triangle",
                    background: "#dc3545",
                    accept: new ModalButton({
                        classes: "btn-danger text-danger dark:text-red hover:text-white",
                    }),
                })
                //Mostrar el modal
                modal.fire().then((result) => {
                    if (result.status == "accept") {
                        //Si el usuario selecciona aceptar hacer petición
                        const data = new FormData()
                        data.append("_method", "put")
                        Request.post(`api/buttons/unasign/${this.button.id}`, data).then((result) => {
                            //Desvincular cliente del botón en el frontend
                            this.button.client_id = null
                            this.button.client.name = "Sin asignar"
                            this.button.client.avatar = "src/blank-profile.svg"
                            //Mostrar la notificación de eliminación en la pantalla
                            this.Utils.notify("Este dispositivo ahora no tiene clientes asignados")
                        })
                    }
                })
            },
            /**
             * Eliminar botón de la base de datos
             */
            remove() {
                //Construir modal para pedir confirmación al usuario
                const modal = new Modal({
                    title: "¿Seguro que desea eliminar este dispositivo?",
                    description: "Esta operación es irreversible",
                    icon: "bi bi-exclamation-triangle",
                    background: "#e5162a",
                    accept: new ModalButton({
                        classes: "btn-danger text-danger hover:text-white",
                    }),
                })
                //Mostar el modal
                modal.fire().then((result) => {
                    if (result.status == "accept") {
                        //Si el usuario selecciona aceptar hacer la petición
                        Request.delete(`api/buttons/${this.button.id}`, new FormData()).then(() => {
                            //Emitir evento
                            this.$emit("remove", this.index)
                            //Mostrar la notificación de eliminación en la pantalla
                            this.Utils.notify("Se ha eliminado el dispositivo correctamente")
                        })
                    }
                })
            },
            /**
             * Mostrar todos los detalles del botón
             */
            showDetails() {
                //Construir el modal
                const modal = new Modal(
                    {
                        window: "Detalles del dispositivo",
                        accept: new ModalButton({
                            classes: "btn-success text-success dark:text-green-400 dark:hover:text-white hover:text-white",
                            text: "Aceptar",
                        }),
                    },
                    DetailsModal,
                    [{ button: this.button }]
                )
                //Mostrar el modal
                modal.fire()
            },
        },
    }
</script>
<template>
    <div class="flex items-center my-2 bg-white dark:bg-slate-800 p-3 rounded-lg shadow-sm cursor-pointer">
        <div class="w-10/12 flex" @click="details">
            <img :src="button.client.avatar" class="rounded-full w-10 h-10" />
            <div class="px-2 w-11/12">
                <h4 class="whitespace-nowrap text-gray-500 dark:text-gray-100 font-bold text-ellipsis w-full overflow-hidden">{{ button.client.name }}</h4>
                <p v-if="button.client.name == 'Sin asignar'" class="text-sm flex items-center text-warning">{{ button.number }}</p>
                <p v-else class="text-sm flex items-center" :class="{ 'text-green-600': button.state == 'Connected', 'text-red-600': button.state == 'Disconnected' }">
                    <i class="bi bi-circle-fill mr-1" style="font-size: 0.7em"></i>
                    {{ button.number }}
                    <template v-if="button.state == 'Connected'"> (Conectado) </template>
                    <template v-else> (Desconectado) </template>
                </p>
            </div>
        </div>
        <div class="flex w-2/12 justify-end dropdown">
            <button data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical dark:text-white"></i></button>
            <ul class="dropdown-menu dark:bg-slate-700">
                <li>
                    <button class="dropdown-item dark:text-gray-50 dark:hover:bg-slate-400 dark:hover:text-white" @click="showDetails">Ver detalles</button>
                </li>
                <li v-if="button.client.name == 'Sin asignar'">
                    <button class="dropdown-item dark:text-gray-50 dark:hover:bg-slate-400 dark:hover:text-white" @click="assign">Vincular</button>
                </li>
                <li v-else>
                    <button class="dropdown-item dark:text-gray-50 dark:hover:bg-slate-400 dark:hover:text-white" @click="unassign">Desvincular</button>
                </li>
                <li>
                    <button class="dropdown-item dark:text-gray-50 dark:hover:bg-slate-400 dark:hover:text-white" @click="remove">Eliminar</button>
                </li>
            </ul>
        </div>
    </div>
</template>
