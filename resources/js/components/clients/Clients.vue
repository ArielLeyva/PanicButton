<script>
    import Request from "../../Request.js"

    import Navbar from "./Navbar.vue"
    import NotFound from "./NotFound.vue"
    import ClientInfo from "./ClientInfo.vue"
    import Pagination from "../Pagination.vue"

    export default {
        emits: ["load"],
        components: { Navbar, NotFound, ClientInfo, Pagination },
        data() {
            return {
                backup: [],
                clients: [],
                display: [],
                rows: 7,
            }
        },
        watch: {
            clients() {
                this.paginate(0)
            },
        },
        methods: {
            paginate(page) {
                //Mostrar las filas a partir de este índice mínimo
                const min = this.rows * page
                //Mostrar las filas hasta este índice máximo
                const max = min + this.rows
                const items = []
                for (let i = min; i < max; i++) {
                    if (i < this.clients.length) {
                        items.push(this.clients[i])
                    } else {
                        break
                    }
                }
                this.display = items
            },
        },
        created() {
            Request.get("api/clients").then((response) => {
                this.backup = response.data
                this.clients = [...this.backup]
                // this.paginate(0)
                this.$emit("load", this.clients)
            })
        },
    }
</script>
<template>
    <div class="mt-2">
        <Navbar @filter="(items) => (clients = items)" :backup="backup" />
        <div class="bg-gray-100 p-2 m-4 rounded-xl">
            <div class="flex items-center text-xs">
                <div class="w-4/12 text-indigo-500 font-bold text-center">Cliente</div>
                <div class="w-3/12 text-indigo-500 font-bold text-center">Teléfonos</div>
                <div class="w-5/12 text-indigo-500 font-bold text-center">Dirección</div>
            </div>
            <ClientInfo v-if="display.length > 0" v-for="client in display" :client="client" />
            <NotFound v-else />
        </div>

        <Pagination v-if="display.length !== 0" @paginate="paginate" ref="paginate" :rows="rows" :alerts="clients" />
    </div>
</template>
