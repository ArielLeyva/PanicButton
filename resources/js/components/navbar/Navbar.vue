<script>
    import Dropdown from "bootstrap/js/dist/dropdown"
    import Request from "../../Request.js"
    import Notifications from "./Notifications.vue"

    export default {
        components: { Notifications },
        data() {
            return {
                user: null,
                theme: localStorage.theme,
            }
        },
        methods: {
            changeTheme() {
                if (localStorage.theme === "dark" || (!("theme" in localStorage) && window.matchMedia("(prefers-color-scheme: dark)").matches)) {
                    console.log("light")
                    localStorage.setItem("theme", "light")
                    this.theme = "light"
                    document.documentElement.classList.remove("dark")
                } else {
                    console.log("dark")
                    localStorage.setItem("theme", "dark")
                    this.theme = "dark"
                    document.documentElement.classList.add("dark")
                }
            },
        },
        created() {
            Request.get("api/user").then((response) => (this.user = response.data))
        },
        mounted() {
            console.log(this.theme)
        },
    }
</script>
<template>
    <nav class="w-full h-16 bg-white dark:bg-slate-900 flex items-center p-2 text-black dark:text-white shadow">
        <div>
            <h4 class="text-indigo-500 dark:text-white whitespace-nowrap flex">
                <img :src="user == null ? 'src/blank-profile.svg' : user.avatar" class="rounded-full w-10 h-10" />
                <div class="px-2">
                    <h4 class="whitespace-nowrap font-bold text-ellipsis w-full overflow-hidden">
                        <template v-if="user == null">
                            <span class="placeholder w-40"></span>
                        </template>
                        <template v-else>{{ user.name }}</template>
                    </h4>
                    <p class="text-sm flex items-center text-gray-500 dark:text-gray-50">
                        <i class="bi bi-person-fill-check mr-1" style="font-size: 0.7em"></i>
                        Administrador
                    </p>
                </div>
            </h4>
        </div>
        <div class="w-full flex justify-end pr-2">
            <div class="dropdown">
                <button class="text-gray-500 dark:text-gray-200 hover:text-black dark:hover:text-white mx-3" data-bs-toggle="dropdown">
                    <i class="bi bi-bell-fill"></i>
                </button>
                <Notifications />
            </div>
            <button @click="changeTheme" class="text-gray-500 dark:text-gray-200 hover:text-black dark:hover:text-white mx-3">
                <i class="bi" :class="{ 'bi-sun-fill': theme == 'light', 'bi-moon-fill': theme == undefined || theme == 'dark' }"></i>
            </button>
            <button class="text-gray-500 dark:text-gray-200 hover:text-black dark:hover:text-white mx-3">
                <i class="bi bi-box-arrow-left"></i>
            </button>
        </div>
    </nav>
</template>
