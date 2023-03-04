<script>
    import Dropdown from "bootstrap/js/dist/dropdown"
    import Modal from "../modal/Modal.js"
    import ModalButton from "../modal/ModalButton.js"
    import SelectClientModal from "./SelectClientModal.vue"
    import DetailsModal from "./DetailsModal.vue"

    export default {
        props: {
            button: Object,
            clients: Array,
        },
        methods: {
            asign() {
                const modal = new Modal(
                    {
                        window: "Vincular dispositivo a un cliente",
                        accept: new ModalButton({
                            classes: "btn-success text-success hover:text-white",
                            text: "Seleccionar",
                        }),
                    },
                    SelectClientModal,
                    [{ clients: this.clients }]
                )
                modal.fire().then((result) => {
                    if (result.status == "accept") {
                        const id = result.data.get("client_id")
                        //TODO (Vincular)
                    }
                })
            },
            unasign() {
                const modal = new Modal({
                    // window: "Confirmar operación",
                    title: "¿Seguro que desea desvincular este dispositivo del cliente?",
                    description: "Esta operación es irreversible",
                    icon: "bi bi-exclamation-triangle",
                    background: "#dc3545",
                    accept: new ModalButton({
                        classes: "btn-danger text-danger hover:text-white",
                    }),
                })
                modal.fire().then((result) => {
                    if (result.status == "accept") {
                        //TODO (Desvincular)
                    }
                })
            },
            remove() {
                const modal = new Modal({
                    // window: "Confirmar operación",
                    title: "¿Seguro que desea eliminar este dispositivo?",
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
                        window: "Detalles del dispositivo",
                        accept: new ModalButton({
                            classes: "btn-success text-success hover:text-white",
                            text: "Aceptar",
                        }),
                    },
                    DetailsModal,
                    [{ button: this.button }]
                )
                modal.fire().then((result) => {
                    if (result.status == "accept") {
                        const id = result.data.get("client_id")
                        //TODO (Vincular)
                    }
                })
            },
        },
    }
</script>
<template>
    <div class="flex items-center my-2 bg-white p-3 rounded-lg shadow-sm cursor-pointer">
        <img @click="details" :src="button.client.avatar" class="rounded-full w-10 h-10" />
        <div class="px-2 w-9/12" @click="details">
            <h4 class="whitespace-nowrap text-gray-500 font-bold text-ellipsis w-full overflow-hidden">{{ button.client.name }}</h4>
            <p class="text-sm flex items-center" :class="{ 'text-green-600': button.state == 'Connected', 'text-red-600': button.state == 'Disconnected' }">
                <i class="bi bi-circle-fill mr-1" style="font-size: 0.7em"></i>
                {{ button.state }} ({{ button.number }})
            </p>
        </div>
        <div class="flex w-1/12 justify-end dropdown">
            <button data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button>
            <ul class="dropdown-menu">
                <li>
                    <button class="dropdown-item" @click="details">Ver detalles</button>
                </li>
                <li v-if="button.client.name == 'Sin asignar'">
                    <button class="dropdown-item" @click="asign">Vincular</button>
                </li>
                <li v-else>
                    <button class="dropdown-item" @click="unasign">Desvincular</button>
                </li>
                <li>
                    <button class="dropdown-item" @click="remove">Eliminar</button>
                </li>
            </ul>
        </div>
    </div>
</template>
