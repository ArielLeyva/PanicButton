<script>
    import CustomModal from "../modal/Modal.vue"

    export default {
        components: { CustomModal },
        methods: {
            /**
             * Seleccionar un cliente de la lista y cerrar el modal
             */
            select(client) {
                const data = new FormData()
                data.append("client_id", client.id)
                this.accept(data)
            },
        },
    }
</script>

<template>
    <CustomModal :config="config" @accept="accept" @cancel="cancel">
        <div class="client-list scroll">
            <div v-for="client in clients" class="group my-2 rounded-lg shadow-sm bg-white dark:bg-slate-900 p-2 first:mt-0 last:mb-0">
                <div class="w-full flex items-cente">
                    <div class="w-10/12 flex items-center cursor-pointer" @click="select(client)" data-bs-dismiss="modal">
                        <img :src="client.avatar" class="rounded-full w-8" />
                        <div class="w-10/12 pl-2">
                            <h4 class="w-full text-ellipsis whitespace-nowrap overflow-hidden text-gray-500 dark:text-gray-50 font-bold">{{ client.name }}</h4>
                            <p class="badge" :class="{ 'bg-success': client.buttons.length > 0, 'bg-danger': client.buttons.length == 0 }">
                                <i class="bi bi-joystick mr-1"></i>
                                <template v-if="client.buttons.length == 0"> Sin asignar </template>
                                <template v-else>
                                    <template v-for="button in client.buttons">
                                        {{ button }}
                                    </template>
                                </template>
                            </p>
                        </div>
                    </div>
                    <div class="w-2/12 m-auto flex justify-end">
                        <button
                            data-bs-toggle="collapse"
                            :data-bs-target="'#modal_info_' + client.id"
                            :class="{ 'transform rotate-180 transition-transform': client.collapse !== undefined, 'transform rotate-0 transition-transform': client.collapse == undefined }"
                            @click="client.collapse = client.collapse == undefined ? true : undefined"
                            class="transition-all mt-2 rounded-full w-8 h-8 bg-indigo-500 shadow-lg text-white opacity-0 hover:!opacity-100 group-hover:!opacity-50"
                        >
                            <i class="bi bi-chevron-down"></i>
                        </button>
                    </div>
                </div>
                <div class="collapse mt-2" :id="'modal_info_' + client.id">
                    <div class="card card-body dark:bg-transparent">
                        <p class="dark:text-gray-50"><i class="bi bi-calendar-day"></i> Fecha de nacimiento: {{ client.birthdate }}</p>
                        <p class="dark:text-gray-50"><i class="bi bi-gender-ambiguous"></i> Sexo: {{ client.gender }}</p>
                        <p class="dark:text-gray-50"><i class="bi bi-person-vcard"></i> DNI: {{ client.dni }}</p>
                        <p class="dark:text-gray-50"><i class="bi bi-map"></i> Dirección postal: {{ client.address.number }} {{ client.address.street }} {{ client.address.apartment }}. {{ client.address.city }}, {{ client.address.state }}</p>
                        <p class="dark:text-gray-50" v-for="telephone in client.telephone_numbers">
                            <i class="bi" :class="{ 'bi-telephone': telephone.type == 'normal', 'bi-phone': telephone.type == 'mobile' }"></i>
                            {{ telephone.number }}
                        </p>
                        <p class="dark:text-gray-50">
                            <i class="bi bi-toggle2-off"></i> Estado:
                            <span class="badge" :class="{ 'bg-success': client.state == 'Activo', 'bg-danger': client.state == 'Bloqueado' }">{{ client.state }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </CustomModal>
</template>
<style scoped>
    .collapse {
        visibility: unset !important;
    }
    .client-list {
        max-height: calc(100vh - 15rem);
        overflow: auto;
    }
</style>
