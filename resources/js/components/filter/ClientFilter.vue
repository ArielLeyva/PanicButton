<script>
    import Dropdown from "bootstrap/js/dist/dropdown"

    export default {
        emits: ["filter", "reset"],
    }
</script>
<template>
    <form @change="$emit('filter')" @input="$emit('filter')" @reset="$emit('reset')" class="dropdown">
        <button data-bs-toggle="dropdown" class="mx-1 rounded-xl w-8 focus-visible:outline-indigo-500 dark:text-gray-100 dark:focus-visible:outline-gray-50">
            <i class="bi bi-filter"></i>
        </button>
        <ul class="dropdown-menu p-2 dark:bg-slate-700">
            <li>
                <p class="text-center text-gray-500 font-bold dark:text-gray-200">Datos del cliente</p>
            </li>
            <li class="flex items-center px-2 relative border-b-gray-200 border-b py-2">
                <i class="bi bi-person absolute top-3 left-4 text-gray-500 dark:text-gray-50"></i>
                <input class="border border-gray-400 dark:border-white dark:bg-slate-500 dark:text-gray-50 dark:placeholder:text-gray-200 rounded focus-visible:outline-none pl-8 py-1" name="name" type="text" placeholder="Nombre del cliente" />
            </li>
            <li class="flex items-center px-2 relative border-b-gray-200 border-b py-2">
                <i class="bi bi-person-vcard absolute top-3 left-4 text-gray-500 dark:text-gray-50"></i>
                <input class="border border-gray-400 dark:border-white dark:bg-slate-500 dark:text-gray-50 dark:placeholder:text-gray-200 rounded focus-visible:outline-none pl-8 py-1" name="dni" type="text" placeholder="DNI del cliente" />
            </li>
            <li class="p-2 border-b-gray-200 border-b">
                <p class="text-gray-400 dark:text-gray-200 font-bold">Sexo:</p>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="" name="gender" checked />
                    <label class="form-check-label dark:text-gray-50">Sin especificar</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="Femenino" name="gender" />
                    <label class="form-check-label dark:text-gray-50">Femenino</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="Masculino" name="gender" />
                    <label class="form-check-label dark:text-gray-50">Masculino</label>
                </div>
            </li>
            <li class="p-2">
                <p class="text-gray-400 dark:text-gray-200 font-bold">Estado del servicio:</p>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="" name="state" checked />
                    <label class="form-check-label dark:text-gray-50">Sin especificar</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="Activo" name="state" />
                    <label class="form-check-label dark:text-gray-50">Activo</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="Inactivo" name="state" />
                    <label class="form-check-label dark:text-gray-50">Inactivo</label>
                </div>
            </li>
            <li class="mt-1">
                <button type="reset" class="btn btn-sm border border-indigo-500 dark:border-indigo-300 w-full text-indigo-500 dark:text-indigo-300 hover:text-white hover:bg-indigo-500">Limpiar filtro</button>
            </li>
        </ul>
    </form>
</template>
