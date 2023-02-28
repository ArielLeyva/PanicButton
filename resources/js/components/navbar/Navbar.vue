<script>
    import Dropdown from "bootstrap/js/dist/dropdown"
    import Notifications from "./Notifications.vue"
    export default {
        components: { Notifications },
    }
</script>
<template>
    <nav class="w-full h-16 bg-white flex items-center p-2 text-black shadow">
        <div>
            <h4 class="text-indigo-500 whitespace-nowrap flex">
                <img src="http://127.0.0.1:8000/src/1.jpg" class="rounded-full w-10 h-10" />
                <div class="px-2">
                    <h4 class="whitespace-nowrap font-bold text-ellipsis w-full overflow-hidden">Ayrton López</h4>
                    <p class="text-sm flex items-center text-gray-500">
                        <i class="bi bi-person-fill-check mr-1" style="font-size: 0.7em"></i>
                        Administrador
                    </p>
                </div>
            </h4>
        </div>
        <div class="w-full flex justify-end pr-2">
            <div class="dropdown">
                <button class="text-gray-500 hover:text-black mx-3" data-bs-toggle="dropdown">
                    <i class="bi bi-bell-fill"></i>
                </button>
                <Notifications />
            </div>
            <button class="text-gray-500 hover:text-black mx-3">
                <i class="bi bi-sun-fill"></i>
            </button>
            <button class="text-gray-500 hover:text-black mx-3">
                <i class="bi bi-box-arrow-left"></i>
            </button>
        </div>
    </nav>
</template>
