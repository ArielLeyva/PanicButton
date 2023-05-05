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
            <p class="float-end text-gray-400 text-sm">{{ Utils.elapsedtime(alert.created_at) }}</p>
            <p class="mt-1 dark:text-gray-50">
                <i class="bi bi-joystick mr-1"></i>
                <strong class="text-gray-500 dark:text-gray-200">Nº de indetificación:</strong>
                {{ alert.button.number }}
            </p>
            <p class="mt-1 dark:text-white"><i class="bi bi-calendar mr-1"></i><strong
                    class="text-gray-500 dark:text-gray-200 font-bold">Fecha y hora:</strong> {{
                        Utils.datetime(alert.created_at, Utils.FULL_DATE_TIME) }}</p>
            <ClientResume @resolve="resolve" v-if="alert.button_id !== null" :client="alert.button.client" />
            <ClientNotFound v-else />
        </div>
    </CustomModal>
</template>
<style scoped>
.collapse {
    visibility: unset !important;
}
</style>
