<script>
    import Dropdown from "bootstrap/js/dist/dropdown"
    import ButtonInfo from "./ButtonInfo.vue"
    import Request from "../../Request.js"

    export default {
        components: { ButtonInfo },
        data() {
            return {
                buttons: [],
                display: [],
            }
        },
        mounted() {
            Request.get("api/buttons").then((response) => {
                this.buttons = response.data
                if (this.buttons.Disconnected !== undefined) {
                    this.display.push(...this.buttons.Disconnected)
                }
                if (this.buttons.Connected !== undefined) {
                    this.display.push(...this.buttons.Connected)
                }
            })
        },
    }
</script>

<template>
    <div>
        <div class="bg-white flex p-3 rounded items-center">
            <div class="dropdown me-1">
                <button class="dropdown-toggle font-bold" data-bs-toggle="dropdown">Todos</button>
                <ul class="dropdown-menu" id="save-as">
                    <li>
                        <button class="dropdown-item"><i class="bi bi-filetype-pdf"></i> Todos los dispositivos</button>
                    </li>
                    <li>
                        <button class="dropdown-item"><i class="bi bi-filetype-xlsx"></i> Dispositivos conectados</button>
                    </li>
                    <li>
                        <button class="dropdown-item"><i class="bi bi-filetype-csv"></i> Dispositivos desconectados</button>
                    </li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li>
                        <button class="dropdown-item"><i class="bi bi-printer"></i> Sin asignar</button>
                    </li>
                </ul>
            </div>
            <div class="flex justify-end w-full">
                <button class="mx-1 rounded-xl w-8">
                    <i class="bi bi-filter"></i>
                </button>
                <button class="mx-1 rounded-xl w-8">
                    <i class="bi bi-search"></i>
                </button>
                <button class="mx-1 rounded-xl w-8 bg-indigo-500 text-white">
                    <i class="bi bi-plus"></i>
                </button>
            </div>
        </div>
        <div>
            <ButtonInfo v-for="button in display" :button="button" />
        </div>
    </div>
</template>
