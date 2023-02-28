<script>
    import Request from "../../Request.js"
    export default {
        data() {
            return {
                clients: []
            }
        },
        created() {
            Request.get("api/clients").then((response) => {
                this.clients = response.data
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
        <div v-for="client in clients" class="group flex items-center my-2 rounded-lg shadow-sm bg-white p-2">
            <div class="w-4/12 flex items-center">
                <img :src="client.avatar" class="rounded-full w-8" />
                <div class="w-10/12 pl-2">
                    <h4 class="w-full text-ellipsis whitespace-nowrap overflow-hidden text-gray-500 font-bold">{{ client.name }}</h4>
                    <p class="text-gray-400"><i class="bi bi-person-vcard"></i> {{ client.dni }}</p>
                </div>
            </div>
            <div class="w-3/12">
                <p v-for="telephone in client.telephone_numbers">
                    <i class="bi" :class="{ 'bi-telephone': telephone.type == 'normal', 'bi-phone': telephone.type == 'mobile' }"></i>
                    {{ telephone.number }}
                </p>
            </div>
            <div class="w-5/12">
                <button class="transition-opacity float-right mt-2 rounded-full w-8 h-8 bg-indigo-500 shadow-lg text-white opacity-0 hover:!opacity-100 group-hover:!opacity-50"><i class="bi bi-chevron-down"></i></button>
                <p>{{ client.address.number }} {{ client.address.street }} {{ client.address.apartment }}. {{ client.address.city }}, {{ client.address.state }}</p>
            </div>
        </div>
    </div>
</template>
