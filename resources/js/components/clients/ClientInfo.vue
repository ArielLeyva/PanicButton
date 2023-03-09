<script>
    import Collapse from "bootstrap/js/dist/collapse"
    import Request from "../../Request.js"

    import Modal from "../modal/Modal.js"
    import ModalButton from "../modal/ModalButton.js"
    import AddClientModal from "./AddClientModal.vue"

    export default {
        emits: ["update"],
        props: {
            client: Object,
            index: Number,
        },
        methods: {
            collapse() {
                this.client.collapse = this.client.collapse == undefined ? true : undefined
            },
            remove() {
                const modal = new Modal({
                    title: "¿Seguro que desea eliminar este cliente?",
                    description: "Esta operación es irreversible",
                    icon: "bi bi-exclamation-triangle",
                    background: "#e5162a",
                    accept: new ModalButton({
                        classes: "btn-danger text-danger hover:text-white",
                    }),
                })
                modal.fire().then((result) => {
                    if (result.status == "accept") {
                        Request.delete(`api/clients/${this.client.id}`, new FormData()).then(() => {
                            this.$emit("remove", this.index)
                        })
                    }
                })
            },
            edit() {
                const modal = new Modal(
                    {
                        window: "Editar datos del cliente",
                        // icon: "bi bi-person",
                        // background: "#157347",
                        accept: new ModalButton({
                            classes: "btn-success text-success hover:text-white",
                            text: "Actualizar",
                        }),
                    },
                    AddClientModal,
                    [{ client: this.client }]
                )
                modal.fire().then((result) => {
                    if (result.status == "accept") {
                        const data = result.data
                        data.append("_method", "put")
                        Request.post(`api/clients/${this.client.id}`, data).then((data) => {
                            this.$emit("update", data)
                        })
                    }
                })
            },
        },
    }
</script>
<template>
    <div class="groupr my-2 rounded-lg shadow-sm bg-white dark:bg-slate-900 p-2">
        <div @click="collapse" data-bs-toggle="collapse" :data-bs-target="'#info_' + client.id" class="w-full flex items-cente cursor-pointer">
            <div class="w-100 sm:w-4/12 flex items-center client">
                <img :src="client.avatar" class="rounded-full w-8" />
                <div class="w-10/12 pl-2">
                    <h4 class="w-full text-ellipsis whitespace-nowrap overflow-hidden text-gray-500 dark:text-gray-50 font-bold">{{ client.name }}</h4>
                    <p v-if="client.buttons.length > 0" class="text-gray-400 dark:text-gray-200">
                        <i class="bi bi-joystick"></i>
                        <template v-for="button in client.buttons"> ({{ button }}) </template>
                    </p>
                    <span class="badge bg-danger" v-else> <i class="bi bi-joystick"></i> Sin asignar </span>
                </div>
            </div>
            <div class="hidden sm:block sm:w-3/12 m-auto">
                <p v-for="telephone in client.telephone_numbers" class="text-center dark:text-gray-100">
                    <i class="bi" :class="{ 'bi-telephone': telephone.type == 'normal', 'bi-phone': telephone.type == 'mobile' }"></i>
                    {{ telephone.number }}
                </p>
            </div>
            <div class="hidden w-1/2 sm:w-5/12 address">
                <p class="dark:text-gray-100">{{ client.address.number }} {{ client.address.street }} {{ client.address.apartment }}. {{ client.address.city }}, {{ client.address.state }}</p>
            </div>
        </div>
        <div class="collapse mt-2" :id="'info_' + client.id">
            <div class="card card-body dark:bg-transparent">
                <p class="dark:text-white"><i class="bi bi-calendar-day dark:text-gray-50"></i> <strong class="text-gray-500 font-bold dark:text-gray-200">Fecha de nacimiento:</strong> {{ client.birthdate }}</p>
                <p class="dark:text-white"><i class="bi bi-gender-ambiguous dark:text-gray-50"></i> <strong class="text-gray-500 font-bold dark:text-gray-200">Sexo:</strong> {{ client.gender }}</p>
                <p class="dark:text-white"><i class="bi bi-person-vcard dark:text-gray-50"></i> <strong class="text-gray-500 font-bold dark:text-gray-200">DNI:</strong> {{ client.dni }}</p>
                <p class="dark:text-white"><i class="bi bi-book dark:text-gray-50"></i> <strong class="text-gray-500 font-bold dark:text-gray-200">Detalles adicionales:</strong> {{ client.details }}</p>
                <p class="sm:hidden dark:text-gray-100">
                    <i class="bi bi-telephone dark:text-gray-50"></i> <strong class="text-gray-500 font-bold dark:text-gray-200">Números de teléfono: </strong>
                    <template v-for="telephone in client.telephone_numbers"> ({{ telephone.number }}) </template>
                </p>
                <p class="dark:text-gray-100 sm:hidden">
                    <i class="bi bi-map dark:text-gray-50"></i> <strong class="text-gray-500 font-bold dark:text-gray-200">Dirección postal: </strong>{{ client.address.number }} {{ client.address.street }} {{ client.address.apartment }}. {{ client.address.city }}, {{ client.address.state }}
                </p>
                <p class="dark:text-white">
                    <i class="bi bi-toggle2-off dark:text-gray-50"></i> <strong class="text-gray-500 font-bold dark:text-gray-200">Estado:</strong>
                    <span class="badge ml-1" :class="{ 'bg-success': client.state == 'Activo', 'bg-danger': client.state == 'Bloqueado' }">{{ client.state }}</span>
                </p>
                <p class="mt-2">
                    <button @click="edit" class="bg-indigo-500 text-white rounded mr-2 my-1 p-1"><i class="bi bi-pencil-square"></i> Actualizar</button>
                    <button @click="remove" class="bg-indigo-500 text-white rounded mr-2 my-1 p-1"><i class="bi bi-trash"></i> Eliminar</button>
                </p>
            </div>
        </div>
    </div>
</template>
<style scoped>
    .collapse {
        visibility: unset !important;
    }
    @media (min-width: 530px) {
        .address {
            display: block !important;
        }
        .client {
            width: 50% !important;
        }
    }
</style>
