<script>
    import Request from "../../Request.js"
    import Collapse from "bootstrap/js/dist/collapse"
    export default {
        emits: ["load"],
        data() {
            return {
                clients: [],
            }
        },
        created() {
            Request.get("api/clients").then((response) => {
                // console.log(response)
                this.clients = response.data
                this.$emit("load", this.clients)
            })
        },
    }
</script>
<template>
    <div class="bg-gray-100 p-2 m-4 rounded-xl">
        <div class="flex items-center text-xs">
            <div class="w-4/12 text-indigo-500 font-bold text-center">Cliente</div>
            <div class="w-3/12 text-indigo-500 font-bold text-center">Teléfonos</div>
            <div class="w-5/12 text-indigo-500 font-bold text-center">Dirección</div>
        </div>
        <div v-for="client in clients" class="groupr my-2 rounded-lg shadow-sm bg-white p-2">
            <div class="w-full flex items-cente">
                <div class="w-4/12 flex items-center">
                    <img :src="client.avatar" class="rounded-full w-8" />
                    <div class="w-10/12 pl-2">
                        <h4 class="w-full text-ellipsis whitespace-nowrap overflow-hidden text-gray-500 font-bold">{{ client.name }}</h4>
                        <p class="text-gray-400"><i class="bi bi-joystick"></i> {{ client.button }}</p>
                    </div>
                </div>
                <div class="w-3/12 m-auto">
                    <p v-for="telephone in client.telephone_numbers" class="text-center">
                        <i class="bi" :class="{ 'bi-telephone': telephone.type == 'normal', 'bi-phone': telephone.type == 'mobile' }"></i>
                        {{ telephone.number }}
                    </p>
                </div>
                <div class="w-5/12">
                    <button
                        data-bs-toggle="collapse"
                        :data-bs-target="'#info_' + client.id"
                        :class="{ 'transform rotate-180 transition-transform': client.collapse !== undefined, 'transform rotate-0 transition-transform': client.collapse == undefined }"
                        @click="client.collapse = client.collapse == undefined ? true : undefined"
                        class="transition-all float-right mt-2 rounded-full w-8 h-8 bg-indigo-500 shadow-lg text-white opacity-0 hover:!opacity-100 group-hover:!opacity-50"
                    >
                        <i class="bi bi-chevron-down"></i>
                    </button>
                    <p>{{ client.address.number }} {{ client.address.street }} {{ client.address.apartment }}. {{ client.address.city }}, {{ client.address.state }}</p>
                </div>
            </div>
            <div class="collapse mt-2" :id="'info_' + client.id">
                <div class="card card-body">
                    <p><i class="bi bi-calendar-day"></i> <strong class="text-gray-500 font-bold">Fecha de nacimiento:</strong> {{ client.birthdate }}</p>
                    <p><i class="bi bi-gender-ambiguous"></i> <strong class="text-gray-500 font-bold">Sexo:</strong> {{ client.gender }}</p>
                    <p><i class="bi bi-person-vcard"></i> <strong class="text-gray-500 font-bold">DNI:</strong> {{ client.dni }}</p>
                    <p>
                        <i class="bi bi-toggle2-off"></i> <strong class="text-gray-500 font-bold">Estado:</strong>
                        <span class="badge ml-1" :class="{ 'bg-success': client.state == 'Activo', 'bg-danger': client.state == 'Bloqueado' }">{{ client.state }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
    .collapse {
        visibility: unset !important;
    }
</style>
