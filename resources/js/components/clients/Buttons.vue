<script>
    import Dropdown from "bootstrap/js/dist/dropdown"

    export default {
        data() {
            return {
                buttons: [
                    { name: "Dr. Stefanie Gibson", avatar: "http://127.0.0.1:8000/src/1.jpg", state: "Connected" },
                    { name: "Maurine Johns", avatar: "http://127.0.0.1:8000/src/2.jpg", state: "Connected" },
                    { name: "Prof. Mervin Bergnaum", avatar: "http://127.0.0.1:8000/src/3.jpg", state: "Disconnected" },
                    { name: "Mr. Hal Gerlach", avatar: "http://127.0.0.1:8000/src/4.jpg", state: "Connected" },
                    { name: "Murray Homenick", avatar: "http://127.0.0.1:8000/src/5.jpg", state: "Connected" },
                    { name: "Roman Renner", avatar: "http://127.0.0.1:8000/src/6.jpeg", state: "Disconnected" },
                    { name: "Mr. Ike Grimes DVM", avatar: "http://127.0.0.1:8000/src/7.jpeg", state: "Connected" },
                    { name: "Greyson Hammes", avatar: "http://127.0.0.1:8000/src/8.jpeg", state: "Connected" },
                    { name: "Mr. Jamie Kshlerin", avatar: "http://127.0.0.1:8000/src/9.jpg", state: "Disconnected" },
                    { name: "Dr. Dillon Kilback", avatar: "http://127.0.0.1:8000/src/10.jpg", state: "Connected" },
                    { name: "Dr. Stefanie Gibson", avatar: "http://127.0.0.1:8000/src/11.jpg", state: "Connected" },
                    { name: "Dr. Stefanie Gibson", avatar: "http://127.0.0.1:8000/src/12.jpg", state: "Disconnected" },
                    { name: "Dr. Stefanie Gibson", avatar: "http://127.0.0.1:8000/src/13.jpg", state: "Disconnected" },
                    { name: "Dr. Stefanie Gibson", avatar: "http://127.0.0.1:8000/src/14.jpg", state: "Connected" },
                    { name: "Dr. Stefanie Gibson", avatar: "http://127.0.0.1:8000/src/15.jpg", state: "Disconnected" },
                ],
            }
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
                        <button class="dropdown-item"><i class="bi bi-printer"></i> Imprimir</button>
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
            <div v-for="button in buttons" class="flex items-center my-2 bg-white p-3 rounded-lg shadow-sm cursor-pointer">
                <img :src="button.avatar" class="rounded-full w-10 h-10" />
                <div class="px-2 w-3/4">
                    <h4 class="whitespace-nowrap text-gray-500 font-bold text-ellipsis w-full overflow-hidden">{{ button.name }}</h4>
                    <p class="text-sm flex items-center" :class="{ 'text-green-600': button.state == 'Connected', 'text-red-600': button.state == 'Disconnected' }">
                        <i class="bi bi-circle-fill mr-1" style="font-size: 0.7em"></i>
                        {{ button.state }}
                    </p>
                </div>
                <div class="flex w-full justify-end">
                    <button><i class="bi bi-three-dots-vertical"></i></button>
                </div>
            </div>
        </div>
    </div>
</template>
