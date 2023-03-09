<script>
    import CustomModal from "../modal/Modal.vue"

    export default {
        components: { CustomModal },
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
        },
    }
</script>

<template>
    <CustomModal :config="config" @accept="accept" @cancel="cancel">
        <div>
            <p class="mt-1 dark:text-gray-50">
                <i class="bi bi-joystick"></i>
                <strong class="text-gray-500 dark:text-gray-200">Número de indetificación:</strong>
                <template v-for="button in alert.client.buttons"> ({{ button }}) </template>
            </p>
            <p class="mt-1 dark:text-gray-50">
                <strong class="text-gray-500 dark:text-gray-200 font-bold">Tipo de alerta: </strong>
                <template v-if="alert.type == 'Health'" class="text-sm flex items-center text-sky-600">🚑 Alerta médica</template>
                <template v-else class="text-sm flex items-center text-red-600">🚓 Alerta penal</template>
            </p>
            <p class="mt-1 dark:text-white"><i class="bi bi-calendar"></i> <strong class="text-gray-500 dark:text-gray-200 font-bold">Fecha y hora:</strong> {{ getDatetime(alert.created_at) }}</p>
            <p class="text-center text-indigo-500 dark:text-gray-200 font-bold mt-4">Detalles del cliente</p>
            <div>
                <div class="w-full flex items-center">
                    <img :src="alert.client.avatar" class="rounded-full w-10 h-10" />
                    <div class="px-2 w-3/4">
                        <h4 class="whitespace-nowrap text-gray-500 dark:text-gray-200 font-bold text-ellipsis w-full overflow-hidden">{{ alert.client.name }}</h4>
                        <p class="dark:text-white"><i class="bi-person-vcard"></i> {{ alert.client.dni }}</p>
                    </div>
                </div>
                <p class="mt-1 dark:text-white"><i class="bi bi-calendar-day"></i> <strong class="text-gray-500 dark:text-gray-200 font-bold">Fecha de nacimiento:</strong> {{ alert.client.birthdate }}</p>
                <p class="mt-1 dark:text-white"><i class="bi bi-gender-ambiguous"></i> <strong class="text-gray-500 dark:text-gray-200 font-bold">Sexo:</strong> {{ alert.client.gender }}</p>
                <p class="mt-1 dark:text-white"><i class="bi bi-map"></i> <strong class="text-gray-500 dark:text-gray-200 font-bold">Dirección postal:</strong> {{ alert.client.address.number }} {{ alert.client.address.street }} {{ alert.client.address.apartment }}. {{ alert.client.address.city }}, {{ alert.client.address.state }}</p>
                <p class="mt-1 dark:text-white">
                    <i class="bi bi-telephone"></i> <strong class="text-gray-500 dark:text-gray-200 font-bold">Números de teléfono:</strong>
                    <template v-for="telephone in alert.client.telephone_numbers">
                        <i class="bi" :class="{ 'bi-telephone': telephone.type == 'normal', 'bi-phone': telephone.type == 'mobile' }"></i>
                        {{ telephone.number }}
                    </template>
                </p>
                <p class="dark:text-white"><i class="bi bi-book dark:text-gray-50"></i> <strong class="text-gray-500 font-bold dark:text-gray-200">Detalles adicionales:</strong> {{ alert.client.details }}</p>
                <p class="mt-1 dark:text-white">
                    <i class="bi bi-toggle2-off"></i> <strong class="text-gray-500 dark:text-gray-200 font-bold">Estado:</strong>
                    <span class="badge" :class="{ 'bg-success': alert.client.state == 'Activo', 'bg-danger': alert.client.state == 'Bloqueado' }">{{ alert.client.state }}</span>
                </p>
            </div>
        </div>
    </CustomModal>
</template>
<style scoped>
    .collapse {
        visibility: unset !important;
    }
</style>
