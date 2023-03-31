<script>
    import Navbar from "./Navbar.vue"
    import ButtonInfo from "./ButtonInfo.vue"
    import NotFound from "./NotFound.vue"
    import Request from "../../Request.js"

    export default {
        components: { ButtonInfo, Navbar, NotFound },
        /**
         * @emit load: Se emite cuando se cargan todos los botones de la base de datos
         */
        emits: ["load"],
        props: {
            /**
             * Lista de clientes de la base de datos
             */
            clients: Array,
        },
        data() {
            return {
                /**
                 * Lista de botones de la base de datos
                 */
                buttons: [],
                /**
                 * Lista de botones a mostrar en pantalla
                 */
                display: [],
            }
        },
        methods: {
            /**
             * Eliminar un botón de la lista de botones del frontend
             */
            remove(index) {
                const button = this.display[index]
                this.display.splice(index, 1)
                this.Utils.splice(this.buttons, button)
            },
            /**
             * Añadir un nuevo botón a la lista de botones en el frontend
             */
            add(button) {
                this.buttons.unshift(button)
                this.display.unshift(button)
            },
        },
        mounted() {
            //Obtener la lista de botones de la base de datos
            Request.get("api/buttons").then((response) => {
                this.buttons = response.data
                this.display = [...this.buttons]
                this.$emit("load", this.buttons)
            })
            //Instanciar pusher para recibir mensajes en tiempo real (Websocket)
            const pusher = new Pusher(import.meta.env.VITE_PUSHER_APP_KEY, {
                cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
            })
            //Suscribirse al canal de cambios de estado de los botones
            const channel = pusher.subscribe("button-state-channel")
            //Añadir oyente para un cambio de estado
            channel.bind("ButtonStateChanged", (data) => {
                //Obtener id del botón
                const id = data.id
                //Obtener nuevo estado del botón
                const state = data.state
                //Actualizar el estado del botón
                for (let button of this.buttons) {
                    if (button.id == id) {
                        button.state = state
                        //Mostrar una notificación
                        const notification = {
                            id: Math.random(),
                            title: state == "Connected" ? "Dispositivo conectado" : "Dispositivo desconectado",
                            client_id: button.client_id,
                            client: button.client,
                            content: `El dispositivo de ${button.client.name} ${state == "Connected" ? "ha retomado la conexión Wi-Fi" : "ha perdido la conexión Wi-Fi"}`,
                            created_at: new Date(),
                        }
                        //Emitir evento de notificación
                        this.$emit("notify", notification)
                        break
                    }
                }
            })
        },
    }
</script>

<template>
    <div>
        <div class="main scroll">
            <Navbar @added="add" @filter="(matched) => (display = matched)" :backup="buttons" />
            <div class="buttons-list">
                <NotFound v-if="display.length == 0" />
                <ButtonInfo v-for="(button, index) in display" @remove="remove" :button="button" :index="index" :clients="clients" />
            </div>
        </div>
    </div>
</template>
<style scoped>
    .main {
        max-height: calc(100vh - 6rem);
        overflow: auto;
    }
    .buttons-list {
        min-height: calc(100vh - 10rem);
    }
</style>
