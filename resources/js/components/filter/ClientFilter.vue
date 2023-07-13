<script>
    import "bootstrap/js/dist/dropdown"

    export default {
        /**
         * @emit filter: Se emite cuando cambian las entradas del formulario de filtro de cliente
         * - @param {Object} client: Datos del cliente introducidos en el formulario
         * @emit reset: Se emite cuando se presiona el botón "Limpiar filtro"
         */
        emits: ["filter", "reset"],
        data() {
            return {
                /**
                 * Datos del clientes introducidos en el formulario
                 */
                client: {},
            }
        },
    }
</script>
<template>
    <form @change="$emit('filter', { client: client })" @input="$emit('filter', { client: client })" @reset="$emit('reset')" class="dropdown">
        <button data-bs-toggle="dropdown" class="mx-1 rounded-xl w-8 focus-visible:outline-indigo-500 dark:text-gray-100 dark:focus-visible:outline-gray-50">
            <i class="bi bi-filter"></i>
        </button>
        <ul class="dropdown-menu p-2 dark:bg-slate-700">
            <li>
                <p class="text-center text-gray-500 font-bold dark:text-gray-200">Datos del cliente</p>
            </li>
            <li class="flex items-center px-2 relative border-b-gray-200 border-b py-2">
                <i class="bi bi-person absolute top-3 left-4 text-gray-500 dark:text-gray-50"></i>
                <input class="border border-gray-400 dark:border-white dark:bg-slate-500 dark:text-gray-50 dark:placeholder:text-gray-200 rounded focus-visible:outline-none pl-8 py-1" type="text" placeholder="Nombre del cliente" v-model="client.name" />
            </li>
            <li class="flex items-center px-2 relative border-b-gray-200 border-b py-2">
                <i class="bi bi-person-vcard absolute top-3 left-4 text-gray-500 dark:text-gray-50"></i>
                <input class="border border-gray-400 dark:border-white dark:bg-slate-500 dark:text-gray-50 dark:placeholder:text-gray-200 rounded focus-visible:outline-none pl-8 py-1" type="text" placeholder="DNI del cliente" v-model="client.dni" />
            </li>
            <li class="p-2 border-b-gray-200 border-b">
                <p class="text-gray-400 dark:text-gray-200 font-bold">Sexo:</p>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="" checked v-model="client.gender" />
                    <label class="form-check-label dark:text-gray-50">Sin especificar</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="Femenino" v-model="client.gender" />
                    <label class="form-check-label dark:text-gray-50">Femenino</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="Masculino" v-model="client.gender" />
                    <label class="form-check-label dark:text-gray-50">Masculino</label>
                </div>
            </li>
            <li class="p-2">
                <p class="text-gray-400 dark:text-gray-200 font-bold">Estado del servicio:</p>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="" checked v-model="client.state" />
                    <label class="form-check-label dark:text-gray-50">Sin especificar</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="Activo" v-model="client.state" />
                    <label class="form-check-label dark:text-gray-50">Activo</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="Inactivo" v-model="client.state" />
                    <label class="form-check-label dark:text-gray-50">Inactivo</label>
                </div>
            </li>
            <li class="mt-1">
                <button type="reset" class="btn btn-sm border border-indigo-500 dark:border-indigo-300 w-full text-indigo-500 dark:text-indigo-300 hover:text-white hover:bg-indigo-500">Limpiar filtro</button>
            </li>
        </ul>
    </form>
</template>
