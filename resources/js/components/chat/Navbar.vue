<script>
export default {
    /**
     * @emit filter: Se emite cuando se selecciona algún filtro
     */
    emits: ["filter", "back", "remove", "select", "unselect"],
    props: {
        messages: Object,
        selection: Object,
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
            <i class="bi" :class="{ 'bi-arrow-left-short': messages !== null, 'bi-x': messages == null }"></i>
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
            <button class="mx-1 rounded-xl w-6 text-white">
                <i class="bi bi-filter"></i>
            </button>
            <div class="flex justify-end dropdown text-sm" v-if="messages !== null">
                <button data-bs-toggle="dropdown" class="mx-1 rounded-xl w-6 text-white"><i
                        class="bi bi-three-dots-vertical"></i></button>
                <ul class="dropdown-menu dark:bg-slate-700">
                    <li>
                        <button @click="emitter.emit('search-message')"
                            class="dropdown-item dark:text-gray-50 dark:hover:bg-slate-400 dark:hover:text-white">Buscar</button>
                    </li>
                    <li v-if="selection == null">
                        <button class="dropdown-item dark:text-gray-50 dark:hover:bg-slate-400 dark:hover:text-white"
                            @click="$emit('select')">Seleccionar mensajes</button>
                    </li>
                    <li v-else>
                        <button class="dropdown-item dark:text-gray-50 dark:hover:bg-slate-400 dark:hover:text-white"
                            @click="$emit('unselect')">Cancelar selección</button>
                    </li>
                    <li>
                        <button :disabled="selection == null || selection.length == 0"
                            class="dropdown-item dark:text-gray-50 dark:hover:bg-slate-400 dark:hover:text-white"
                            @click="$emit('remove')">Eliminar mensajes</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
