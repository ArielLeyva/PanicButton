<script>
    import Request from "../../Request.js"
    import NotFound from "./NotFound.vue"

    export default {
        components: { NotFound },
        data() {
            return {
                notifications: [],
            }
        },
        methods: {
            getTime(time) {
                const today = new Date()
                const date = new Date(time)
                const diff = today - date
                if (diff <= 3600000) {
                    return `Hace ${Math.floor(diff / 60000)} minutos`
                } else if (diff <= 86400000) {
                    return `Hace ${Math.floor(diff / 3600000)} horas`
                } else if (diff <= 604800000) {
                    return `Hace ${Math.floor(diff / 86400000)} días`
                } else if (diff <= 2592000000) {
                    return `Hace ${Math.floor(diff / 604800000)} semanas`
                } else {
                    return date.toLocaleDateString("es", {
                        day: "numeric",
                        weekday: "short",
                        month: "short",
                        year: "numeric",
                    })
                }
            },
        },
        created() {
            Request.get("api/notifications").then((response) => {
                // this.notifications = response.data
                for (let i in response.data) {
                    const notification = response.data[i]
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
    <ul class="dropdown-menu scroll">
        <template v-if="notifications.length > 0">
            <li class="dropdown-item cursor-pointer" v-for="notification in notifications">
                <div class="flex">
                    <div class="w-1/6 flex justify-center items-center">
                        <img :src="notification.client.avatar" class="rounded-full w-8 h-8" />
                    </div>
                    <div class="w-10/12">
                        <h4 class="w-80 text-gray-500 overflow-hidden whitespace-nowrap text-ellipsis font-bold">{{ notification.title }}</h4>
                        <p class="w-64 overflow-hidden text-ellipsis">{{ notification.content }}</p>
                        <small class="text-gray-500">{{ getTime(notification.created_at) }}</small>
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
