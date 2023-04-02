<script>
    import Request from "../../Request.js"
    import NotFound from "./NotFound.vue"

    export default {
        components: { NotFound },
        data() {
            return {
                /**
                 * Lista de notificaciones de la base de datos
                 */
                notifications: [],
                /**
                 * Lista intacta de notificaciones de la base de datos
                 */
                backup: [],
                unreaded: 0,
            }
        },
        methods: {
            init() {
                this.notifications = []
                for (let i in this.backup) {
                    const notification = Object.assign({}, this.backup[i])
                    //Agregar nombre del cliente a la notificación
                    if (notification.client !== null && notification.client !== undefined) {
                        notification.content = notification.content.replace("%client%", notification.client.name)
                    }
                    this.notifications.push(notification)
                }
            },
        },
        created() {
            //Obtener las notificaciones de la base de datos
            Request.get("api/notifications").then((response) => {
                this.backup = response.data
                this.init()
            })
        },
        mounted() {
            this.emitter.on("client-updated", (client) => {
                for (let i in this.backup) {
                    if (this.backup[i].client_id == client.id) {
                        this.backup.client = client
                    }
                }
                this.init()
            })
            this.emitter.on("notification-received", (notification) => {
                this.unreaded++
                this.backup.unshift(notification)
                this.init()
            })
            this.emitter.on("client-removed", (client) => {
                for (let i in this.backup) {
                    if (this.backup[i].client_id == client.id) {
                        this.backup.splice(i, 1)
                    }
                }
                this.init()
            })
        },
    }
</script>
<template>
    <div class="dropdown relative">
        <span v-if="notifications.length > 0" @click="unreaded = 0" class="badge bg-danger rounded-full absolute cursor-pointer" data-bs-toggle="dropdown" style="right: -0.25rem; top: -0.65rem">{{ notifications.length }}</span>
        <button @click="unreaded = 0" class="text-gray-500 dark:text-gray-200 hover:text-black dark:hover:text-white mx-3" data-bs-toggle="dropdown">
            <i class="bi bi-bell-fill"></i>
        </button>
        <ul class="dropdown-menu scroll dark:bg-slate-700">
            <template v-if="notifications.length > 0">
                <li class="dropdown-item cursor-pointer dark:hover:bg-slate-400" v-for="notification in notifications">
                    <div class="flex">
                        <div class="w-1/6 flex justify-center items-center">
                            <img :src="notification.client.avatar" class="rounded-full w-8 h-8" />
                        </div>
                        <div class="w-10/12">
                            <h4 class="w-80 text-gray-500 dark:text-gray-100 overflow-hidden whitespace-nowrap text-ellipsis font-bold">{{ notification.title }}</h4>
                            <p class="w-64 overflow-hidden text-ellipsis dark:text-white">{{ notification.content }}</p>
                            <small class="text-gray-500 dark:text-gray-200">{{ Utils.elapsedtime(notification.created_at) }}</small>
                        </div>
                    </div>
                </li>
            </template>
            <template v-else>
                <NotFound />
            </template>
        </ul>
    </div>
</template>
<style>
    ul {
        max-height: calc(100vh - 5rem);
        overflow-y: auto;
        overflow-x: hidden;
    }
    .dropdown-item.active,
    .dropdown-item:active {
        color: #000;
        text-decoration: none;
        background-color: rgba(76, 0, 130, 0.171);
    }
</style>
