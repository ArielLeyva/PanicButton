<script>
    import Dropdown from "bootstrap/js/dist/dropdown"
    import Request from "../../Request.js"
    import Alert from "./Alert.vue"
    import Pagination from "../Pagination.vue"
    import Navbar from "./Navbar.vue"

    export default {
        components: { Alert, Pagination, Navbar },
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
    <div class="w-2/3 px-4">
        <Navbar :backup="backup" @filter="(matched) => (alerts = matched)" />
        <div class="bg-gray-100 p-2 rounded-lg mt-1">
            <Alert v-for="alert in display" :alert="alert" />
        </div>
        <Pagination @paginate="paginate" :alerts="alerts" />
    </div>
</template>
