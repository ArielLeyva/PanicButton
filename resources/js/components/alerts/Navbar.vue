<script>
    import Dropdown from "bootstrap/js/dist/dropdown"

    import ClientFilter from "../filter/ClientFilter.vue"

    export default {
        emits: ["filter"],
        components: { ClientFilter },
        props: {
            backup: Array,
        },
        data() {
            return {
                active: "Todas",
            }
        },
        methods: {
            filter(params) {
                if (params == undefined) {
                    params = { client: {} }
                    const data = new FormData(this.$el.querySelector("form"))
                    for (let entry of data.entries()) {
                        params.client[entry[0]] = entry[1]
                    }
                    this.active = "Filtro"
                }
                const items = this.backup.filter((alert) => {
                    for (let key in params) {
                        const param = params[key]
                        switch (key) {
                            case "date":
                                const date = new Date(alert.created_at)
                                if (new Date() - date > param) {
                                    return false
                                }
                                switch (param) {
                                    case 86400000:
                                        this.active = "Últimas 24 horas"
                                        break
                                    case 7 * 86400000:
                                        this.active = "Últimos 7 días"
                                        break
                                    case 15 * 86400000:
                                        this.active = "Últimos 15 días"
                                        break
                                    case 30 * 86400000:
                                        this.active = "Últimos 30 días"
                                        break
                                }
                                break
                            case "all":
                                this.active = "Todas"
                                break
                            case "client":
                                const client = params.client
                                for (let key in client) {
                                    if (client[key] !== "") {
                                        switch (key) {
                                            case "name":
                                            case "dni":
                                                if (alert.client[key] == undefined || !alert.client[key].toString().toLowerCase().includes(client[key].toString().toLowerCase())) {
                                                    return false
                                                }
                                                break
                                            case "state":
                                            case "gender":
                                                if (alert.client[key] !== client[key]) {
                                                    return false
                                                }
                                                break
                                        }
                                    }
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
        <div class="float-right flex items-center mb-1">
            <ClientFilter @filter="filter" @reset="filter({ date: 30 * 86400000 })" />
            
            <div class="dropdown p-1 pr-2">
                <button class="dropdown-toggle font-bold dark:text-white" data-bs-toggle="dropdown">{{ active }}</button>
                <ul class="dropdown-menu dark:bg-slate-700">
                    <li>
                        <button @click="filter({ date: 30 * 86400000 })" class="dropdown-item dark:text-gray-50 dark:hover:bg-slate-400 dark:hover:text-white">Últimos 30 días</button>
                    </li>
                    <li>
                        <button @click="filter({ date: 15 * 86400000 })" class="dropdown-item dark:text-gray-50 dark:hover:bg-slate-400 dark:hover:text-white">Últimos 15 días</button>
                    </li>
                    <li>
                        <button @click="filter({ date: 7 * 86400000 })" class="dropdown-item dark:text-gray-50 dark:hover:bg-slate-400 dark:hover:text-white">Últimos 7 días</button>
                    </li>
                    <li>
                        <button @click="filter({ date: 86400000 })" class="dropdown-item dark:text-gray-50 dark:hover:bg-slate-400 dark:hover:text-white">Últimas 24 horas</button>
                    </li>
                    <li>
                        <hr class="dropdown-divider dark:border-gray-500" />
                    </li>
                    <li>
                        <button @click="filter({ all: true })" class="dropdown-item dark:text-gray-50 dark:hover:bg-slate-400 dark:hover:text-white">Todas</button>
                    </li>
                </ul>
            </div>
        </div>
        <p class="text-indigo-500 mb-2 font-bold mt-2 dark:text-gray-50">Alertas</p>
    </div>
</template>
