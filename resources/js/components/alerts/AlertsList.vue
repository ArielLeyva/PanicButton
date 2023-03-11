<script>
    import Pusher from "pusher-js"
    import Dropdown from "bootstrap/js/dist/dropdown"
    import Request from "../../Request.js"

    import Alert from "./Alert.vue"
    import NotFound from "./NotFound.vue"
    import Pagination from "../Pagination.vue"
    import Navbar from "./Navbar.vue"

    import audio from "../../../sounds/notification-sound.mp3"

    export default {
        components: { Alert, Pagination, Navbar, NotFound },
        emits: ["alert"],
        data() {
            return {
                backup: [],
                alerts: [],
                display: [],
            }
        },
        watch: {
            alerts() {
                this.paginate(0)
            },
        },
        methods: {
            paginate(page) {
                //Mostrar las filas a partir de este índice mínimo
                const min = 4 * page
                //Mostrar las filas hasta este índice máximo
                const max = min + 4
                const items = []
                for (let i = min; i < max; i++) {
                    if (i < this.alerts.length) {
                        items.push(this.alerts[i])
                    } else {
                        break
                    }
                }
                this.display = items
            },
            remove(index) {
                const alert = this.display[index]
                this.splice(this.backup, alert)
                this.splice(this.alerts, alert)
                this.paginate(this.$refs.paginate.page)
            },
            splice(items, alert) {
                for (let i in items) {
                    if (items[i].id == alert.id) {
                        items.splice(i, 1)
                        break
                    }
                }
            },
        },
        created() {
            Request.get("api/alerts").then((response) => {
                this.backup = response.data
                console.log(this.backup)
                this.alerts = [...this.backup]
                this.paginate(0)
            })
            const pusher = new Pusher("8caec03daf5228df1fcc", {
                cluster: "sa1",
            })
            const sound = new Audio(audio)
            //Canal de chats
            const channel = pusher.subscribe("alert-channel")
            const _this = this
            channel.bind("AlertPressed", (data) => {
                const alert = data.alert
                sound.play()
                this.$emit("alert", alert)
                _this.backup.unshift(alert)
                _this.alerts.unshift(alert)
                _this.paginate(0)
            })
            setTimeout(() => {
                const alert = {
                    id: 25,
                    client_id: 12,
                    type: "Police",
                    state: "Pendiente",
                    created_at: "2023-03-11T15:04:17.000000Z",
                    updated_at: "2023-03-11T15:04:17.000000Z",
                    client: {
                        id: 12,
                        name: "Reinaldo Tamayo Álvarez",
                        avatar: "https://sac-monitoreo.online/src/users/12.jpg",
                        dni: "23658758961",
                        gender: "Masculino",
                        details: "Fugiat nulla consequat duis anim pariatur ipsum veniam ad ut sint fugiat nulla sunt veniam.",
                        birthdate: "22-10-1984",
                        address_id: 12,
                        state: "Activo",
                        created_at: null,
                        updated_at: null,
                        address: {
                            id: 12,
                            street: "Hansen Hills",
                            number: "298",
                            apartment: "Apt. 325",
                            city: "Lake Valentine",
                            state: "Kansas",
                            postal_code: "69222",
                            coordinates: null,
                            created_at: null,
                            updated_at: null,
                        },
                        buttons: ["753124"],
                        telephone_numbers: [
                            {
                                id: 12,
                                number: "+57 56969658",
                                client_id: 12,
                            },
                        ],
                    },
                }
                this.$emit("alert", alert)
            })
        },
    }
</script>
<template>
    <div class="w-full lg:w-2/3 px-4">
        <Navbar :backup="backup" @filter="(matched) => (alerts = matched)" />
        <div v-if="display.length > 0" class="bg-gray-100 dark:bg-slate-500 p-2 rounded-lg mt-1">
            <Alert v-for="(alert, index) in display" @remove="remove" :index="index" :alert="alert" />
        </div>
        <NotFound v-else />
        <Pagination v-if="display.length !== 0" @paginate="paginate" ref="paginate" :alerts="alerts" />
    </div>
</template>
