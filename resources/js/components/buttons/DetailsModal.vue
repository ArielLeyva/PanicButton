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
            <p class="dark:text-gray-50">
                <span class="badge" :class="{ 'bg-green-600': button.on, 'bg-red-600': !button.on }">
                    <i class="bi bi-power"></i>
                    <template v-if="button.on">
                        Encendido
                    </template>
                    <template>
                        Apagado
                    </template>
                </span>
            </p>
            <ClientResume @resolve="resolve" v-if="button.client_id !== null" :client="button.client" />
            <ClientNotFound v-else />
        </div>
    </CustomModal>
</template>
<style scoped>
    .collapse {
        visibility: unset !important;
    }
</style>
