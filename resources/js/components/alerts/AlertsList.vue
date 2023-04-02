<script>
    import Pusher from "pusher-js"
    import Dropdown from "bootstrap/js/dist/dropdown"
    import Request from "../../Request.js"

    import AlertInfo from "./AlertInfo.vue"
    import NotFound from "./NotFound.vue"
    import Pagination from "../Pagination.vue"
    import Navbar from "./Navbar.vue"

    import audio from "../../../sounds/notification-sound.mp3"

    export default {
        components: { AlertInfo, Pagination, Navbar, NotFound },
        /**
         * @emit notify Se llama cuando se recibe una alerta
         */
        emits: ["notify"],
        data() {
            return {
                /**
                 * Todas las alertas en la base de datos
                 */
                backup: [],
                /**
                 * Alertas a mostrar en pantalla
                 */
                alerts: [],
                /**
                 * Alertas de la página visible en pantalla
                 */
                display: [],
            }
        },
        watch: {
            alerts() {
                this.paginate(0)
            },
        },
        methods: {
            /**
             * Cambiar la página visible
             * @param {Number} page: Número de la página a mostrar
             */
            paginate(page) {
                //Mostrar las filas a partir de este índice mínimo
                const min = 4 * page
                //Mostrar las filas hasta este índice máximo
                const max = min + 4
                this.display = []
                //Actualizar las alertas de la página
                for (let i = min; i < max; i++) {
                    if (i < this.alerts.length) {
                        this.display.push(this.alerts[i])
                    } else {
                        break
                    }
                }
            },
            /**
             * Eliminar una alerta
             * @param {Number} index: Índice de la alerta en la página
             */
            remove(index) {
                //Obtener los datos de la alerta a eliminar
                const alert = this.display[index]
                //Eliminar alerta del backup de alertas
                this.Utils.splice(this.backup, alert)
                //Eliminar la alerta de la lista de alertas a mostrar
                this.Utils.splice(this.alerts, alert)
                //Actualizar paginación
                this.paginate(this.$refs.paginate.page)
            },
        },
        created() {
            //Recuperar las alertas de la base de datos
            Request.get("api/alerts").then((response) => {
                this.backup = response.data
                this.alerts = [...this.backup]
                //Establecer la página en 0
                this.paginate(0)
            })
            //Instanciar pusher para recibir mensajes en tiempo real (Websocket)
            const pusher = new Pusher(import.meta.env.VITE_PUSHER_APP_KEY, {
                cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
            })
            //Instanciar sonido de alerta recibida
            const sound = new Audio(audio)
            //Suscribirse al canal de alertas
            const channel = pusher.subscribe("alert-channel")
            //Añadir oyente de alerta presionada
            channel.bind("AlertPressed", (data) => {
                //Datos de la alerta
                const alert = data.alert
                //Reproducir el sonido
                sound.play()
                const notification = {
                    id: Math.random(),
                    title: "Alerta presionada",
                    client_id: alert.client_id,
                    client: alert.client,
                    content: `%client% ha presionado su botón de pánico con una alerta ${alert.type == "Police" ? "Policial" : "Médica"}`,
                    text: `${alert.client.name} ha presionado su botón de pánico con una alerta ${alert.type == "Police" ? "Policial" : "Médica"}`,
                    created_at: new Date(),
                }
                //Emitir evento de alerta recibida
                this.$emit("notify", notification)
                //Añadir la alerta nueva a la lista de alertas
                this.backup.unshift(alert)
                this.alerts.unshift(alert)
                //Establecer la primera página
                this.paginate(0)
            })
            this.emitter.on("client-removed", (client) => {
                for (let i in this.backup) {
                    if (this.backup[i].client_id == client.id) {
                        this.Utils.splice(this.alerts, this.backup[i])
                        this.backup.splice(i, 1)
                    }
                }
                //Actualizar paginación
                this.paginate(this.$refs.paginate.page)
            })
        },
    }
</script>
<template>
    <div class="w-full lg:w-2/3 px-4">
        <Navbar :backup="backup" @filter="(matched) => (alerts = matched)" />
        <div v-if="display.length > 0" class="bg-gray-100 dark:bg-slate-500 p-2 rounded-lg mt-1">
            <AlertInfo v-for="(alert, index) in display" @remove="remove" :index="index" :alert="alert" />
        </div>
        <NotFound v-else />
        <Pagination v-if="display.length !== 0" @paginate="paginate" ref="paginate" :alerts="alerts" />
    </div>
</template>
