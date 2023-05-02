<script>
import CustomModal from "../modal/Modal.vue"
import ClientResume from "../clients/ClientResume.vue"
import ClientNotFound from "../ClientNotFound.vue";

export default {
    components: { CustomModal, ClientResume, ClientNotFound },
}
</script>

<template>
    <CustomModal :config="config" @accept="accept" @cancel="cancel">
        <div>
            <p class="mt-1 dark:text-gray-50">
                <i class="bi bi-joystick"></i>
                <strong class="text-gray-500 dark:text-gray-200">Nº de indetificación:</strong>
                {{ alert.button.number }}
            </p>
            <p class="mt-1 dark:text-gray-50">
                <strong class="text-gray-500 dark:text-gray-200 font-bold">Tipo de alerta: </strong>
                <template v-if="alert.type == 'Health'" class="text-sm flex items-center text-sky-600">🚑 Alerta
                    médica</template>
                <template v-else class="text-sm flex items-center text-red-600">🚓 Alerta penal</template>
            </p>
            <p class="mt-1 dark:text-white"><i class="bi bi-calendar"></i> <strong
                    class="text-gray-500 dark:text-gray-200 font-bold">Fecha y hora:</strong> {{
                        Utils.datetime(alert.created_at, Utils.FULL_DATE_TIME) }}</p>
            <ClientResume v-if="alert.button_id !== null" :client="alert.button.client" />
            <ClientNotFound v-else />
        </div>
    </CustomModal>
</template>
<style scoped>
.collapse {
    visibility: unset !important;
}
</style>
