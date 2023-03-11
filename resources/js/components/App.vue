<script>
    import Navbar from "./navbar/Navbar.vue"
    import Window from "./Window.vue"
    import Clients from "./clients/Clients.vue"
    import ButtonsList from "./buttons/ButtonsList.vue"
    import Statistics from "./clients/Statistics.vue"
    import AlertsList from "./alerts/AlertsList.vue"
    export default {
        components: { Navbar, Window, Clients, ButtonsList, Statistics, AlertsList },
        data() {
            return {
                clients: [],
                buttons: {},
                window: null,
                notifications: [],
                notification: null,
            }
        }, 
        methods: {
            notify(alert) {
                const notification = {
                    id: Math.random(),
                    title: "Alerta presionada",
                    client_id: alert.client_id,
                    client: alert.client,
                    content: `${alert.client.name} ha presionado su botón de pánico con una alerta ${alert.type == "Police" ? "Policial" : "Médica"}`,
                    created_at: new Date(),
                }
                this.notifications = [notification, ...this.notifications]
                if ("Notification" in window && Notification.permission == "granted") {
                    this.notification = new Notification("Sistema de Alerta Comunitaria", {
                        body: notification.content,
                        icon: "../src/logo_contrast.png",
                        title: notification.title,
                    })
                }
            },
        },
        mounted() {
            if ("Notification" in window) {
                if (Notification.permission == "default" || Notification.permission == "denied") {
                    Notification.requestPermission()
                }
                document.addEventListener("visibilitychange", () => {
                    if (document.visibilityState === "visible" || this.notification !== null) {
                        this.notification.close()
                    }
                })
            }
        },
    }
</script>

<template>
    <Navbar :notifications="notifications" @read="notifications = []" />
    <main class="bg-gradient-to-br from-indigo-100 to-fuchsia-100 dark:from-slate-600 dark:via-slate-500 dark:to-slate-600 w-full p-1 sm:p-3">
        <div class="block md:flex">
            <section :class="{ hidden: window !== 'buttons' && window !== null }" class="md:w-1/3 lg:w-1/4 main scroll pb-10 sm:pb-0">
                <ButtonsList @load="(data) => (buttons = data)" :clients="clients" />
            </section>
            <section :class="{ hidden: window !== 'clients' && window !== null }" class="md:w-2/3 lg:w-3/4 main scroll mt-0 sm:mt-5 md:mt-0 pb-10 sm:pb-0">
                <div class="w-full pl-0 sm:pl-4">
                    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm pb-1">
                        <div class="flex md:block lg:flex">
                            <Statistics :buttons="buttons" />
                            <AlertsList @alert="notify" />
                        </div>
                        <Clients @load="(data) => (clients = data)" />
                    </div>
                </div>
            </section>
        </div>
    </main>
    <Window @change="(w) => (window = w)" />
</template>
<style>
    .main {
        max-height: calc(100vh - 5.5rem);
        overflow: auto;
    }
</style>
