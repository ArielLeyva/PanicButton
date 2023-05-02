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
            <p class="text-sm flex items-center float-right" :class="{ 'text-green-600': button.state == 'Connected', 'text-red-600': button.state == 'Disconnected' }">
                <i class="bi bi-circle-fill mr-1" style="font-size: 0.7em"></i>
                {{ button.state }}
            </p>
            <p class="dark:text-gray-50"><i class="bi bi-joystick"></i> <strong class="text-gray-500 dark:text-gray-50">Nº de indetificación:</strong> {{ button.number }}</p>
            <ClientResume v-if="button.client_id !== null" :client="button.client" />
            <ClientNotFound v-else />
        </div>
    </CustomModal>
</template>
<style scoped>
    .collapse {
        visibility: unset !important;
    }
</style>
