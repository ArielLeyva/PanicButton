<script>
    import Request from "../../Request.js"

    import Modal from "../modal/Modal.js"
    import ModalButton from "../modal/ModalButton.js"
    import DetailsModal from "./DetailsModal.vue"

    import Alert from "../alert/Alert.js"
    import AlertConfig from "../alert/AlertConfig.js"

    export default {
        props: {
            /**
             * Datos de la alerta
             */
            alert: Object,
            /**
             * Índice de la alerta en la lista visible
             */
            index: Number,
        },
        methods: {
            /**
             * Elimina la alerta de la base de datos
             */
            remove() {
                //Mostrar un modal de confirmación antes de eliminar la alerta
                const modal = new Modal({
                    title: "¿Seguro que desea eliminar esta alerta?",
                    description: "Esta operación es irreversible",
                    icon: "bi bi-exclamation-triangle",
                    background: "#e5162a",
                    accept: new ModalButton({
                        classes: "btn-danger text-danger hover:text-white",
                    }),
                })
                //Mostrar el modal de confirmación
                modal.fire().then((result) => {
                    //Si el usuario elige "Aceptar" eliminar la alerta
                    if (result.status == "accept") {
                        //Hacer la petición para eliminar la alerta de la base de datos
                        Request.delete(`api/alerts/${this.alert.id}`, new FormData()).then(() => {
                            //Emitir el evento de eliminación de la alerta
                            this.$emit("remove", this.index)
                            //Mostrar la notificación de eliminación en la pantalla
                            this.Utils.notify("Se ha eliminado la alerta")
                        })
                    }
                })
            },
            /**
             * Muestra los detalles de la alerta
             */
            showDetails() {
                //Crear el modal con los detalles de la alerta
                const modal = new Modal(
                    {
                        window: "Detalles de la alerta",
                        accept: new ModalButton({
                            classes: "btn-success text-success dark:text-green-400 dark:hover:text-white hover:text-white",
                            text: "Aceptar",
                        }),
                    },
                    //Pasar una plantilla para mostrar los detalles de la alerta
                    DetailsModal,
                    //Pasar los datos de la alerta
                    [{ alert: this.alert }]
                )
                //Mostrar el modal
                modal.fire()
            },
            /**
             * Marca como leída la alerta
             */
            markAsReaded() {
                //Crear un modal de confirmación antes de marcar como leída la alerta
                const modal = new Modal({
                    title: "¿Seguro que desea marcar como leída esta alerta?",
                    description: "Esta operación es irreversible",
                    icon: "bi bi-exclamation-triangle",
                    background: "#e5162a",
                    accept: new ModalButton({
                        classes: "btn-danger text-danger hover:text-white",
                    }),
                })
                //Mostrar el modal
                modal.fire().then((result) => {
                    if (result.status == "accept") {
                        const data = new FormData()
                        data.append("_method", "put")
                        //Si el usuario selecciona "Aceptar" marcar como leída la alerta
                        if (result.status == "accept") {
                            //Hacer la petición para marcar como leída la alerta
                            Request.post(`api/alerts/readed/${this.alert.id}`, data).then((result) => {
                                //Cambiar el estado de la alerta
                                this.alert.state = "Vista"
                                //Mostrar la notificación en pantalla
                                this.Utils.notify("Se ha marcado como leída esta alerta")
                            })
                        }
                    }
                })
            },
        },
        mounted() {
            this.emitter.on("client-updated", (client) => {
                if (client.id == this.alert.client_id) {
                    this.alert.client = client
                }
            })
        },
    }
</script>
<template>
    <div class="rounded bg-white dark:bg-slate-800 shadow-md flex items-center my-2 p-2 first:mt-0 last:mb-0">
        <img @click="details" :src="alert.client.avatar" class="rounded-full w-10 h-10 cursor-pointer" />
        <div @click="details" class="px-2 w-5/12 cursor-pointer">
            <h4 class="whitespace-nowrap text-gray-500 dark:text-gray-200 font-bold text-ellipsis w-full overflow-hidden">{{ alert.client.name }}</h4>
            <p v-if="alert.type == 'Health'" class="text-sm flex items-center text-sky-600">🚑 Alerta médica</p>
            <p v-else class="text-sm flex items-center text-red-600">🚓 Alerta penal</p>
        </div>
        <div @click="details" class="w-5/12 text-center cursor-pointer">
            <p class="dark:text-white text-sm">{{ Utils.datetime(alert.created_at, Utils.FULL_DATE_TIME) }}</p>
            <span class="badge" :class="{ 'bg-success': alert.state == 'Vista', 'bg-danger': alert.state == 'Pendiente' }">{{ alert.state }}</span>
        </div>
        <div class="w-1/12 flex justify-end dropdown pr-1">
            <button data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical dark:text-white"></i></button>
            <ul class="dropdown-menu dark:bg-slate-700">
                <li>
                    <button @click="markAsReaded" class="dropdown-item dark:text-gray-50 dark:hover:bg-slate-400 dark:hover:text-white">Marcar como leída</button>
                </li>
                <li>
                    <button @click="showDetails" class="dropdown-item dark:text-gray-50 dark:hover:bg-slate-400 dark:hover:text-white">Ver detalles</button>
                </li>
                <li>
                    <button @click="remove" class="dropdown-item dark:text-gray-50 dark:hover:bg-slate-400 dark:hover:text-white">Eliminar</button>
                </li>
            </ul>
        </div>
    </div>
</template>
