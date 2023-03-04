<script>
    import CustomModal from "../modal/Modal.vue"

    export default {
        components: { CustomModal },
    }
</script>

<template>
    <CustomModal :config="config" @accept="accept" @cancel="cancel">
        <div>
            <p class="text-sm flex items-center float-right" :class="{ 'text-green-600': button.state == 'Connected', 'text-red-600': button.state == 'Disconnected' }">
                <i class="bi bi-circle-fill mr-1" style="font-size: 0.7em"></i>
                {{ button.state }}
            </p>
            <p><i class="bi bi-joystick"></i> <strong class="text-gray-500">Número de indetificación:</strong> {{ button.number }}</p>
            <p class="text-center text-indigo-500 font-bold mt-4">Detalles del cliente</p>
            <div v-if="button.client.name !== 'Sin asignar'">
                <div class="w-full flex items-center">
                    <img :src="button.client.avatar" class="rounded-full w-10 h-10" />
                    <div class="px-2 w-3/4">
                        <h4 class="whitespace-nowrap text-gray-500 font-bold text-ellipsis w-full overflow-hidden">{{ button.client.name }}</h4>
                        <p><i class="bi-person-vcard"></i> {{ button.client.dni }}</p>
                    </div>
                </div>
                <p class="mt-1"><i class="bi bi-calendar-day"></i> <strong class="text-gray-500 font-bold">Fecha de nacimiento:</strong> {{ button.client.birthdate }}</p>
                <p class="mt-1"><i class="bi bi-gender-ambiguous"></i> <strong class="text-gray-500 font-bold">Sexo:</strong> {{ button.client.gender }}</p>
                <p class="mt-1">
                    <i class="bi bi-map"></i> <strong class="text-gray-500 font-bold">Dirección postal:</strong> {{ button.client.address.number }} {{ button.client.address.street }} {{ button.client.address.apartment }}. {{ button.client.address.city }}, {{ button.client.address.state }}
                </p>
                <p class="mt-1">
                    <i class="bi bi-telephone"></i> <strong class="text-gray-500 font-bold">Números de teléfono:</strong>
                    <template v-for="telephone in button.client.telephone_numbers">
                        <i class="bi" :class="{ 'bi-telephone': telephone.type == 'normal', 'bi-phone': telephone.type == 'mobile' }"></i>
                        {{ telephone.number }}
                    </template>
                </p>
                <p class="mt-1">
                    <i class="bi bi-toggle2-off"></i> <strong class="text-gray-500 font-bold">Estado:</strong>
                    <span class="badge" :class="{ 'bg-success': button.client.state == 'Activo', 'bg-danger': button.client.state == 'Bloqueado' }">{{ button.client.state }}</span>
                </p>
            </div>
            <div v-else class="text-center">
                <i class="bi bi-person-x text-5xl text-gray-500"></i>
                <p class="text-center">No asignado a ningún cliente</p>
            </div>
        </div>
    </CustomModal>
</template>
<style scoped>
    .collapse {
        visibility: unset !important;
    }
</style>
