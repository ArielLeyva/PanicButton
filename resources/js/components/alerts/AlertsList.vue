<script>
    import Request from "../../Request.js"
    import Alert from "./Alert.vue"
    import Pagination from "../Pagination.vue"

    export default {
        components: { Alert, Pagination },
        data() {
            return {
                alerts: [],
                display: [],
            }
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
                // console.log(response)
                this.alerts = response.data
                // this.display = this.alerts
                this.paginate(0)
            })
        },
    }
</script>
<template>
    <div class="w-2/3 px-4">
        <p class="text-indigo-500 mb-2 font-bold text-center mt-2">Alertas</p>
        <div class="bg-gray-100 p-2 rounded-lg mt-1">
            <Alert v-for="alert in display" :alert="alert" />
        </div>
        <Pagination @paginate="paginate" :alerts="alerts" />
    </div>
</template>
