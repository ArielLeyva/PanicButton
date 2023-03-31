<script>
    import Dropdown from "bootstrap/js/dist/dropdown"

    import ClientFilter from "../filter/ClientFilter.vue"

    export default {
        /**
         * @emit filter: Se llama cuando se aplica o quita un filtro a la lista de alertas
         * - @param {Array} items: Lista de alertas que cumplen con los parámetros del filtro
         */
        emits: ["filter"],
        components: { ClientFilter },
        props: {
            /**
             * Lista de alertas en la base de datos
             */
            backup: Array,
        },
        data() {
            return {
                /**
                 * Nombre del filtro de alertas activo
                 */
                active: "Todas",
                /**
                 * Filtros de tiempo
                 */
                times: {
                    1: "Últimas 24 horas",
                    7: "Últimos 7 días",
                    15: "Últimos 15 días",
                    30: "Últimos 30 días",
                },
            }
        },
        methods: {
            /**
             * Aplicar un filtro a las alertas en la base de datos
             * @event filter
             */
            filter(params) {
                //Aplicar filtro a la lista intacta de alertas
                const items = this.backup.filter((alert) => {
                    //Iterar sobre todos los parámetros del filtro
                    for (let key in params) {
                        //Valor del parámetro de filtro
                        const param = params[key]
                        switch (key) {
                            case "date":
                                //Actualizar nombre del filtro activo
                                this.active = this.times[param]
                                //Obtener la fecha y hora de la alerta
                                const date = new Date(alert.created_at)
                                //Verificar que la fecha y hora se encuentre dentro del rango de filtro de fecha
                                if (Date.now() - date > param * 86400000) {
                                    return false
                                }
                                break
                            case "all":
                                //Actualizar nombre del filtro activo
                                this.active = "Todas"
                                break
                            case "client":
                                //Actualizar nombre del filtro activo
                                this.active = "Cliente"
                                //Verificar si el cliente de la alerta cumple con los requisitos del filtro
                                if (!this.Utils.filter(alert.client, param)) {
                                    return false
                                }
                                break
                        }
                        //Retornar true si la alerta cumple con todos los parámetros del filtro
                        return true
                    }
                })
                //Emitir evento
                this.$emit("filter", items)
            },
        },
    }
</script>
<template>
    <div>
        <div class="float-right flex items-center mb-1">
            <!-- TODO (Quitar este filtro de reset y poner el filtro de todo) -->
            <ClientFilter @filter="filter" @reset="filter({ all: true })" />
            <div class="dropdown p-1 pr-2">
                <button class="dropdown-toggle font-bold dark:text-white" data-bs-toggle="dropdown">{{ active }}</button>
                <ul class="dropdown-menu dark:bg-slate-700">
                    <li>
                        <button @click="filter({ date: 30 })" class="dropdown-item dark:text-gray-50 dark:hover:bg-slate-400 dark:hover:text-white">Últimos 30 días</button>
                    </li>
                    <li>
                        <button @click="filter({ date: 15 })" class="dropdown-item dark:text-gray-50 dark:hover:bg-slate-400 dark:hover:text-white">Últimos 15 días</button>
                    </li>
                    <li>
                        <button @click="filter({ date: 7 })" class="dropdown-item dark:text-gray-50 dark:hover:bg-slate-400 dark:hover:text-white">Últimos 7 días</button>
                    </li>
                    <li>
                        <button @click="filter({ date: 1 })" class="dropdown-item dark:text-gray-50 dark:hover:bg-slate-400 dark:hover:text-white">Últimas 24 horas</button>
                    </li>
                    <li>
                        <hr class="dropdown-divider dark:border-gray-500" />
                    </li>
                    <li>
                        <button @click="filter({ all: true })" class="dropdown-item dark:text-gray-50 dark:hover:bg-slate-400 dark:hover:text-white">Todas</button>
                    </li>
                </ul>
            </div>
        </div>
        <p class="text-indigo-500 mb-2 font-bold mt-2 dark:text-gray-50">Alertas</p>
    </div>
</template>
