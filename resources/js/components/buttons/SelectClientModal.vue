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
