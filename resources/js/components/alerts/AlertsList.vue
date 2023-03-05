<script>
    import Dropdown from "bootstrap/js/dist/dropdown"
    import Request from "../../Request.js"

    import Alert from "./Alert.vue"
    import NotFound from "./NotFound.vue"
    import Pagination from "../Pagination.vue"
    import Navbar from "./Navbar.vue"

    export default {
        components: { Alert, Pagination, Navbar, NotFound },
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
                this.alerts = [...this.backup]
                this.paginate(0)
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
