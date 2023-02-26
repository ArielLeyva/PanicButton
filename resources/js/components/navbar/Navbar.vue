<script>
    import Dropdown from "bootstrap/js/dist/dropdown"
    import Notifications from "./Notifications.vue"
    export default {
        components: { Notifications },
    }
</script>
<template>
    <nav class="w-full h-12 bg-white flex items-center p-2 text-black">
        <div>
            <h4 class="text-indigo-500 whitespace-nowrap font-bold">Name here...</h4>
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
