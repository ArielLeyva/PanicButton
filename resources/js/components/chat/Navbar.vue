<script>
export default {
    /**
     * @emit filter: Se emite cuando se selecciona algún filtro
     */
    emits: ["filter", "back"],
    props: {
        messages: Object,
    },
    data() {
        return {
            /**
             * Nombre del filtro de botones activo
             */
            active: "Todos",
            /**
             * Identificador del botón introducido por el usuario para buscar
             */
            number: null,
        }
    },
    methods: {
        /**
         * Aplicar un filtro a la lista de botones
         * @param {Object} params: Lista de filtros a aplicar
         */
        filter(params) {

        },
    },
}
</script>
<template>
    <div class="bg-indigo-500 flex py-3 px-1 rounded-t items-center">
        <button @click="$emit('back')" class="mx-1 rounded-xl w-8 text-white">
            <i class="bi bi-arrow-left-short"></i>
        </button>
        <h3 class="text-white font-bold truncate w-full">
            <template v-if="messages == null">
                Chats
            </template>
            <template v-else>
                {{ messages[0].client.name }}
            </template>
        </h3>
        <div class="flex justify-end">
            <button class="mx-1 rounded-xl w-8 text-white">
                <i class="bi bi-filter"></i>
            </button>
            <button class="mx-1 rounded-xl w-8 text-white">
                <i class="bi bi-plus"></i>
            </button>
            <button class="mx-1 rounded-xl w-8 text-white">
                <i class="bi bi-three-dots-vertical"></i>
            </button>
        </div>
    </div>
</template>
