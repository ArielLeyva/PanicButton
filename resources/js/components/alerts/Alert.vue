<script>
    import Request from "../../Request.js"

    import Modal from "../modal/Modal.js"
    import ModalButton from "../modal/ModalButton.js"
    import DetailsModal from "./DetailsModal.vue"

    import Alert from "../alert/Alert.js"
    import AlertConfig from "../alert/AlertConfig.js"

    export default {
        props: {
            alert: Object,
            index: Number,
        },
        methods: {
            getDatetime(datetime) {
                const date = new Date(datetime)
                return date.toLocaleDateString("es", {
                    day: "2-digit",
                    month: "numeric",
                    year: "numeric",
                    hour: "2-digit",
                    minute: "2-digit",
                    hour12: true,
                })
            },
            remove() {
                const modal = new Modal({
                    title: "¿Seguro que desea eliminar esta alerta?",
                    description: "Esta operación es irreversible",
                    icon: "bi bi-exclamation-triangle",
                    background: "#e5162a",
                    accept: new ModalButton({
                        classes: "btn-danger text-danger hover:text-white",
                    }),
                })
                modal.fire().then((result) => {
                    if (result.status == "accept") {
                        Request.delete(`api/alerts/${this.alert.id}`, new FormData()).then(() => {
                            this.$emit("remove", this.index)
                            const alert = new Alert(
                                new AlertConfig({
                                    title: "¡Operación satisfactoria!",
                                    text: "Se ha eliminado la alerta",
                                    icon: "bi bi-check2-square",
                                    color: "#198754",
                                })
                            )
                            alert.fire()
                        })
                    }
                })
            },
            details() {
                const modal = new Modal(
                    {
                        window: "Detalles de la alerta",
                        accept: new ModalButton({
                            classes: "btn-success text-success dark:text-green-400 dark:hover:text-white hover:text-white",
                            text: "Aceptar",
                        }),
                    },
                    DetailsModal,
                    [{ alert: this.alert }]
                )
                modal.fire()
            },
            read() {
                const modal = new Modal({
                    title: "¿Seguro que desea marcar como leída esta alerta?",
                    description: "Esta operación es irreversible",
                    icon: "bi bi-exclamation-triangle",
                    background: "#e5162a",
                    accept: new ModalButton({
                        classes: "btn-danger text-danger hover:text-white",
                    }),
                })
                modal.fire().then((result) => {
                    if (result.status == "accept") {
                        const data = new FormData()
                        data.append("_method", "put")
                        if (result.status == "accept") {
                            Request.post(`api/alerts/readed/${this.alert.id}`, data).then((result) => {
                                this.alert.state = "Vista"
                                const alert = new Alert(
                                    new AlertConfig({
                                        title: "¡Operación satisfactoria!",
                                        text: "Se ha marcado como leída esta alerta",
                                        icon: "bi bi-check2-square",
                                        color: "#198754",
                                    })
                                )
                                alert.fire()
                            })
                        }
                    }
                })
            },
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
            <p class="dark:text-white text-sm">{{ getDatetime(alert.created_at) }}</p>
            <span class="badge" :class="{ 'bg-success': alert.state == 'Vista', 'bg-danger': alert.state == 'Pendiente' }">{{ alert.state }}</span>
        </div>
        <div class="w-1/12 flex justify-end dropdown pr-1">
            <button data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical dark:text-white"></i></button>
            <ul class="dropdown-menu dark:bg-slate-700">
                <li>
                    <button @click="read" class="dropdown-item dark:text-gray-50 dark:hover:bg-slate-400 dark:hover:text-white">Marcar como leída</button>
                </li>
                <li>
                    <button @click="details" class="dropdown-item dark:text-gray-50 dark:hover:bg-slate-400 dark:hover:text-white">Ver detalles</button>
                </li>
                <li>
                    <button @click="remove" class="dropdown-item dark:text-gray-50 dark:hover:bg-slate-400 dark:hover:text-white">Eliminar</button>
                </li>
            </ul>
        </div>
    </div>
</template>
