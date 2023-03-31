<script>
    import Request from "../../Request.js"

    import Navbar from "./Navbar.vue"
    import NotFound from "./NotFound.vue"
    import ClientInfo from "./ClientInfo.vue"
    import Pagination from "../Pagination.vue"

    export default {
        /**
         * @emit load: Se emite cuando se cargan los clientes de la base de datos
         */
        emits: ["load"],
        components: { Navbar, NotFound, ClientInfo, Pagination },
        data() {
            return {
                /**
                 * Lista de clientes de la base de datos
                 */
                backup: [],
                /**
                 * Lista de clientes a mostrar en pantalla
                 */
                clients: [],
                /**
                 * Lista de clientes en la página actual
                 */
                display: [],
                /**
                 * Número de clientes a mostrar por página
                 */
                rows: 7,
            }
        },
        watch: {
            clients() {
                this.paginate(0)
            },
        },
        methods: {
            /**
             * Cambiar la página
             */
            paginate(page) {
                //Mostrar las filas a partir de este índice mínimo
                const min = this.rows * page
                //Mostrar las filas hasta este índice máximo
                const max = min + this.rows
                //Actualizar los clientes de la página
                this.display = []
                for (let i = min; i < max; i++) {
                    if (i < this.clients.length) {
                        this.display.push(this.clients[i])
                    } else {
                        break
                    }
                }
            },
            /**
             * Añadir un cliente a la lista de clientes en el frontend
             */
            add(client) {
                this.backup.push(client)
                this.clients.push(client)
                this.paginate(this.$refs.paginate.page)
            },
            /**
             * Actualizar datos de un cliente en el frontend
             */
            update(index, data) {
                this.set(this.backup, data)
                this.set(this.display, data)
                this.display[index] = data
            },
            /**
             * Establecer datos a un cliente
             */
            set(items, client) {
                for (let i in items) {
                    if (items[i].id == client.id) {
                        items[i] = client
                        break
                    }
                }
            },
            /**
             * Eliminar un cliente de la lista de clientes en el frontend
             */
            remove(index) {
                const client = this.display[index]
                this.Utils.splice(this.backup, client)
                this.Utils.splice(this.clients, client)
                this.paginate(this.$refs.paginate.page)
            },
        },
        created() {
            //Cargar lista de clientes de la base de datos
            Request.get("api/clients").then((response) => {
                this.backup = response.data
                this.clients = [...this.backup]
                //Emitir evento
                this.$emit("load", this.clients)
            })
        },
    }
</script>
<template>
    <div class="mt-2">
        <Navbar @filter="(items) => (clients = items)" @add="add" :backup="backup" />
        <div class="bg-gray-100 dark:bg-slate-500 p-2 m-4 rounded-xl">
            <div class="flex items-center text-xs">
                <div class="w-100 sm:w-4/12 text-indigo-500 dark:text-gray-200 font-bold text-center">Cliente</div>
                <div class="hidden sm:block sm:w-3/12 text-indigo-500 dark:text-gray-200 font-bold text-center">Teléfonos</div>
                <div class="hidden w-1/2 sm:w-5/12 text-indigo-500 dark:text-gray-200 font-bold text-center">Dirección</div>
            </div>
            <ClientInfo v-if="display.length > 0" v-for="(client, index) in display" @remove="remove" @update="(data) => update(index, data)" :index="index" :client="client" />
            <NotFound v-else />
        </div>

        <Pagination v-if="display.length !== 0" @paginate="paginate" ref="paginate" :rows="rows" :alerts="clients" />
    </div>
</template>
<style scoped>
    @media (min-width: 530px) {
        .flex.items-center.text-xs > div:last-child {
            display: block !important;
        }
        .flex.items-center.text-xs > div:first-child {
            width: 50% !important;
        }
    }
</style>
