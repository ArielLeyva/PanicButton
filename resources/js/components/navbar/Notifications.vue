<script>
    import Request from "../../Request.js"
    import NotFound from "./NotFound.vue"

    export default {
        components: { NotFound },
        props: {
            /**
             * Lista de notificaciones no leídas
             */
            unreaded: Array,
        },
        watch: {
            unreaded() {
                this.notifications.unshift(...this.unreaded)
            },
        },
        data() {
            return {
                /**
                 * Lista de notificaciones de la base de datos
                 */
                notifications: [],
            }
        },
        created() {
            //Obtener las notificaciones de la base de datos
            Request.get("api/notifications").then((response) => {
                for (let i in response.data) {
                    const notification = response.data[i]
                    //Agregar nombre del cliente a la notificación
                    if (notification.client !== null && notification.client !== undefined) {
                        notification.content = notification.content.replace("%client%", notification.client.name)
                    }
                    this.notifications.push(notification)
                }
            })
        },
    }
</script>
<template>
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
