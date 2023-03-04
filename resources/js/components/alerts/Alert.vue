<script>
    import Modal from "../modal/Modal.js"
    import ModalButton from "../modal/ModalButton.js"
    import DetailsModal from "./DetailsModal.vue"

    export default {
        props: {
            alert: Object,
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
                        //TODO (Eliminar)
                    }
                })
            },
            details() {
                const modal = new Modal(
                    {
                        window: "Detalles de la alerta",
                        accept: new ModalButton({
                            classes: "btn-success text-success hover:text-white",
                            text: "Aceptar",
                        }),
                    },
                    DetailsModal,
                    [{ alert: this.alert }]
                )
                modal.fire().then((result) => {
                    if (result.status == "accept") {
                        const id = result.data.get("client_id")
                        //TODO (Vincular)
                    }
                })
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
                        //TODO (Eliminar)
                    }
                })
            },
        },
    }
</script>
<template>
    <div class="rounded bg-white shadow-md flex items-center my-2 p-2 first:mt-0 last:mb-0">
        <img :src="alert.client.avatar" class="rounded-full w-10 h-10" />
        <div class="px-2 w-5/12">
            <h4 class="whitespace-nowrap text-gray-500 font-bold text-ellipsis w-full overflow-hidden">{{ alert.client.name }}</h4>
            <p v-if="alert.type == 'Health'" class="text-sm flex items-center text-sky-600">🚑 Alerta médica</p>
            <p v-else class="text-sm flex items-center text-red-600">🚓 Alerta penal</p>
        </div>
        <div class="w-5/12 text-center">
            <p>{{ getDatetime(alert.created_at) }}</p>
            <span class="badge" :class="{ 'bg-success': alert.state == 'Vista', 'bg-danger': alert.state == 'Pendiente' }">{{ alert.state }}</span>
        </div>
        <div class="w-1/12 flex justify-end dropdown pr-1">
            <button data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button>
            <ul class="dropdown-menu">
                <li>
                    <button @click="read" class="dropdown-item">Marcar como leída</button>
                </li>
                <li>
                    <button @click="details" class="dropdown-item">Ver detalles</button>
                </li>
                <li>
                    <button @click="remove" class="dropdown-item">Eliminar</button>
                </li>
            </ul>
        </div>
    </div>
</template>
