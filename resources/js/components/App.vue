<script>
    import Navbar from "./navbar/Navbar.vue"
    import Window from "./Window.vue"
    import ClientsList from "./clients/ClientsList.vue"
    import ButtonsList from "./buttons/ButtonsList.vue"
    import Statistics from "./clients/Statistics.vue"
    import AlertsList from "./alerts/AlertsList.vue"
    export default {
        components: { Navbar, Window, ClientsList, ButtonsList, Statistics, AlertsList },
        data() {
            return {
                /**
                 * Lista de clientes de la base de datos
                 */
                clients: [],
                /**
                 * Lista de botones de la base de datos
                 */
                buttons: [],
                /**
                 * Identificador de la ventana activa
                 */
                window: null,
                /**
                 * Lista de notificaciones de la base de datos
                 */
                notifications: [],
                /**
                 * Notificación del sistema
                 */
                notification: null,
            }
        },
        methods: {
            /**
             * Agrega una notificación a la lista de notificaciones en el frontend y muestra la notificación en pantalla
             */
            notify(notification) {
                //Añadir la notificación a la lista de notificaciones
                this.notifications = [notification, ...this.notifications]
                //Verificar si el dispositivo del usuario admite la API de notificaciones y aceptó el permiso de notificaciones
                if ("Notification" in window && Notification.permission == "granted") {
                    //Crear y mostrar la notificación
                    this.notification = new Notification("Sistema de Alerta Comunitaria", {
                        body: notification.content,
                        icon: "../src/logo_contrast.png",
                        title: notification.title,
                    })
                }
            },
        },
        mounted() {
            //Pedir permiso de notificación al usuario
            if ("Notification" in window) {
                if (Notification.permission == "default" || Notification.permission == "denied") {
                    Notification.requestPermission()
                }
                //Añadir evento para cerrar la notificación cuando se muestre la página
                document.addEventListener("visibilitychange", () => {
                    if (document.visibilityState === "visible" && this.notification !== null) {
                        this.notification.close()
                    }
                })
            }
        },
    }
</script>

<template>
    <Navbar :notifications="notifications" @readed="notifications = []" />
    <main class="bg-gradient-to-br from-indigo-100 to-fuchsia-100 dark:from-slate-600 dark:via-slate-500 dark:to-slate-600 w-full p-1 sm:p-3">
        <div class="block md:flex">
            <section :class="{ hidden: window !== 'buttons' && window !== null }" class="md:w-1/3 lg:w-1/4 main scroll pb-10 sm:pb-0">
                <ButtonsList @notify="notify" @load="(data) => (buttons = data)" :clients="clients" />
            </section>
            <section :class="{ hidden: window !== 'clients' && window !== null }" class="md:w-2/3 lg:w-3/4 main scroll mt-0 sm:mt-5 md:mt-0 pb-10 sm:pb-0">
                <div class="w-full pl-0 sm:pl-4">
                    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm pb-1">
                        <div class="flex md:block lg:flex">
                            <Statistics :buttons="buttons" />
                            <AlertsList @notify="notify" />
                        </div>
                        <ClientsList @load="(data) => (clients = data)" />
                    </div>
                </div>
            </section>
        </div>
    </main>
    <Window @change="(w) => (window = w)" />
</template>
<style>
    main {
        height: calc(100vh - 4rem);
    }
    .main {
        max-height: calc(100vh - 5.5rem);
        overflow: auto;
    }
</style>
