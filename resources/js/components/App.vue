<script>
import Navbar from "./navbar/Navbar.vue"
import Window from "./Window.vue"
import ClientsList from "./clients/ClientsList.vue"
import ButtonsList from "./buttons/ButtonsList.vue"
import Statistics from "./clients/Statistics.vue"
import AlertsList from "./alerts/AlertsList.vue"
import Chats from "./chat/Chats.vue"
export default {
    components: { Navbar, Window, ClientsList, ButtonsList, Statistics, AlertsList, Chats },
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
             * Notificación del sistema
             */
            notification: null,
            /**
             * Visibilidad del chat
             */
            chatVisible: true
        }
    },
    methods: {
        /**
         * Agrega una notificación a la lista de notificaciones en el frontend y muestra la notificación en pantalla
         */
        notify(notification) {
            //Añadir la notificación a la lista de notificaciones
            this.emitter.emit("notification-received", notification)
            //Verificar si el dispositivo del usuario admite la API de notificaciones y aceptó el permiso de notificaciones
            if ("Notification" in window && Notification.permission == "granted") {
                //Crear y mostrar la notificación
                this.notification = new Notification("Sistema de Alerta Comunitaria", {
                    body: notification.text,
                    // icon: "../src/logo_contrast.png",
                    icon: notification.client.avatar,
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
    <Navbar />
    <main
        class="bg-gradient-to-br from-indigo-100 to-fuchsia-100 dark:from-slate-600 dark:via-slate-500 dark:to-slate-600 w-full p-1 sm:p-3">
        <div class="block md:flex">
            <section :class="{ hidden: window !== 'buttons' && window !== null }"
                class="md:w-1/3 lg:w-1/4 main scroll pb-10 sm:pb-0">
                <ButtonsList @notify="notify" @load="(data) => (buttons = data)" :clients="clients" />
            </section>
            <section :class="{ hidden: window !== 'clients' && window !== null }"
                class="md:w-2/3 lg:w-3/4 main scroll mt-0 sm:mt-5 md:mt-0 pb-10 sm:pb-0">
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
        <div class="absolute bottom-5 right-5 z-50 overflow-hidden">
            <transition name="chat">
                <div v-show="!chatVisible" class="mb-2">
                    <Chats />
                </div>
            </transition>
            <div class="relative">
                <span class="badge bg-red-600 text-white rounded-full absolute top-0 right-0">4</span>
                <button
                    class="bg-indigo-500 p-3 w-12 h-12 text-center text-white border-none rounded-full shadow-lg float-right"
                    @click="chatVisible = !chatVisible">
                    <i class="bi bi-chat"></i>
                </button>
            </div>
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

@keyframes backInRight {
    0% {
        transform: translateX(2000px) scale(0.7);
        opacity: 0.7;
    }

    80% {
        transform: translateX(0px) scale(0.7);
        opacity: 0.7;
    }

    100% {
        transform: scale(1);
        opacity: 1;
    }
}

.chat-enter-active {
    animation: backInRight 0.5s;
    animation-fill-mode: forwards;
    animation-timing-function: ease-in;
}

.chat-leave-active {
    animation: backInRight 0.5s;
    animation-fill-mode: backwards;
    animation-direction: reverse;
    animation-timing-function: ease-out;
}
</style>
