<script>
    import Dropdown from "bootstrap/js/dist/dropdown"
    import Request from "../../Request.js"

    import Modal from "../modal/Modal.js"
    import ModalButton from "../modal/ModalButton.js"
    import SelectClientModal from "./SelectClientModal.vue"
    import DetailsModal from "./DetailsModal.vue"

    export default {
        props: {
            button: Object,
            index: Number,
            clients: Array,
        },
        methods: {
            asign() {
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
                modal.fire().then((result) => {
                    if (result.status == "accept") {
                        const id = result.data.get("client_id")
                        const data = new FormData()
                        data.append("_method", "put")
                        Request.post(`api/buttons/asign/${this.button.id}/${id}`, data).then((button) => {
                            this.button.client_id = button.client_id
                            this.button.client = button.client
                        })
                    }
                })
            },
            unasign() {
                const modal = new Modal({
                    title: "¿Seguro que desea desvincular este dispositivo del cliente?",
                    description: "Esta operación es irreversible",
                    icon: "bi bi-exclamation-triangle",
                    background: "#dc3545",
                    accept: new ModalButton({
                        classes: "btn-danger text-danger dark:text-red hover:text-white",
                    }),
                })
                modal.fire().then((result) => {
                    const data = new FormData()
                    data.append("_method", "put")
                    if (result.status == "accept") {
                        Request.post(`api/buttons/unasign/${this.button.id}`, data).then((result) => {
                            this.button.client_id = null
                            this.button.client.name = "Sin asignar"
                            this.button.client.avatar = "src/blank-profile.svg"
                        })
                    }
                })
            },
            remove() {
                const modal = new Modal({
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
                        Request.delete(`api/buttons/${this.button.id}`, new FormData()).then(() => {
                            this.$emit("remove", this.index)
                        })
                    }
                })
            },
            details() {
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
                <p class="text-sm flex items-center" :class="{ 'text-green-600': button.state == 'Connected', 'text-red-600': button.state == 'Disconnected' }">
                    <i class="bi bi-circle-fill mr-1" style="font-size: 0.7em"></i>
                    {{ button.state }} ({{ button.number }})
                </p>
            </div>
        </div>
        <div class="flex w-2/12 justify-end dropdown">
            <button data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical dark:text-white"></i></button>
            <ul class="dropdown-menu dark:bg-slate-700">
                <li>
                    <button class="dropdown-item dark:text-gray-50 dark:hover:bg-slate-400 dark:hover:text-white" @click="details">Ver detalles</button>
                </li>
                <li v-if="button.client.name == 'Sin asignar'">
                    <button class="dropdown-item dark:text-gray-50 dark:hover:bg-slate-400 dark:hover:text-white" @click="asign">Vincular</button>
                </li>
                <li v-else>
                    <button class="dropdown-item dark:text-gray-50 dark:hover:bg-slate-400 dark:hover:text-white" @click="unasign">Desvincular</button>
                </li>
                <li>
                    <button class="dropdown-item dark:text-gray-50 dark:hover:bg-slate-400 dark:hover:text-white" @click="remove">Eliminar</button>
                </li>
            </ul>
        </div>
    </div>
</template>
