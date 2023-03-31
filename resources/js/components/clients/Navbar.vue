<script>
    import Request from "../../Request.js"

    import Modal from "../modal/Modal.js"
    import ModalButton from "../modal/ModalButton.js"
    import ClientModal from "./ClientModal.vue"

    import Alert from "../alert/Alert.js"
    import AlertConfig from "../alert/AlertConfig.js"

    import ClientFilter from "../filter/ClientFilter.vue"

    export default {
        components: { ClientFilter },
        props: {
            /**
             * Lista de clientes de la base de datos
             */
            backup: Array,
        },
        data() {
            return {
                /**
                 * Nombre del filtro activo
                 */
                active: "Todos",
            }
        },
        methods: {
            /**
             * Registrar un nuevo cliente
             */
            add() {
                //Construir el modal con el formulario de registro
                const modal = new Modal(
                    {
                        window: "Registrar un nuevo cliente",
                        // icon: "bi bi-person",
                        // background: "#157347",
                        accept: new ModalButton({
                            classes: "btn-success text-success hover:text-white",
                            text: "Registrar",
                        }),
                    },
                    ClientModal,
                    [{ client: { address: {} } }]
                )
                //Mostrar el modal
                modal.fire().then((result) => {
                    if (result.status == "accept") {
                        //Si el usuario elige aceptar hacer la petición
                        Request.post("api/clients", result.data).then((data) => {
                            //Emitir evento
                            this.$emit("add", data)
                            //Mostrar la notificación de eliminación en la pantalla
                            this.Utils.notify("Se ha registrado el cliente correctamente")
                        })
                    }
                })
            },
            /**
             * Aplicar un filtro a la lista de clientes
             */
            filter(params) {
                const items = this.backup.filter((item) => {
                    for (let key in params) {
                        const param = params[key]
                        switch (key) {
                            case "assign":
                                if ((param && item.buttons.length == 0) || (!param && item.buttons.length !== 0)) {
                                    return false
                                }
                                this.active = param ? "Asignados" : "Sin asignar"
                                break
                            case "all":
                                this.active = "Todos"
                                break
                            case "client":
                                //Actualizar nombre del filtro activo
                                this.active = "Cliente"
                                //Verificar si el cliente de la alerta cumple con los requisitos del filtro
                                if (!this.Utils.filter(item, param)) {
                                    return false
                                }
                                break
                        }
                        return true
                    }
                })
                this.$emit("filter", items)
            },
        },
    }
</script>
<template>
    <div>
        <div class="float-right flex mr-5 items-center">
            <ClientFilter @filter="filter" @reset="filter({ all: true })" />
            <div class="dropdown p-1 pr-2">
                <button class="dropdown-toggle dark:text-white font-bold" data-bs-toggle="dropdown">{{ active }}</button>
                <ul class="dropdown-menu dark:bg-slate-700">
                    <li>
                        <button @click="filter({ assign: true })" class="dropdown-item dark:text-gray-50 dark:hover:bg-slate-400 dark:hover:text-white">Clientes asignados</button>
                    </li>
                    <li>
                        <button @click="filter({ assign: false })" class="dropdown-item dark:text-gray-50 dark:hover:bg-slate-400 dark:hover:text-white">Clientes sin asignar</button>
                    </li>
                    <li>
                        <hr class="dropdown-divider dark:border-gray-300" />
                    </li>
                    <li>
                        <button @click="filter({ all: true })" class="dropdown-item dark:text-gray-50 dark:hover:bg-slate-400 dark:hover:text-white">Todos los clientes</button>
                    </li>
                </ul>
            </div>
        </div>
        <button @click="add" class="btn btn-sm ml-5 text-indigo-500 border border-indigo-500 dark:border-indigo-300 dark:text-indigo-300 hover:text-white hover:bg-indigo-500 dark:hover:text-white">Registrar nuevo cliente</button>
    </div>
</template>
