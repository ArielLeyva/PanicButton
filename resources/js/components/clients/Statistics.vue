<script>
    import Chart from "chart.js/auto"

    export default {
        data() {
            const colors = ["rgb(20, 165, 40)", "rgb(240, 34, 34)"]
            const items = [
                {
                    name: "Dispositivos conectados",
                    cant: "15",
                    color: colors[0],
                },
                {
                    name: "Dispositivos desconectados",
                    cant: "3",
                    color: colors[1],
                },
            ]
            return {
                items: items,
                alerts: [
                    {
                        client: {
                            name: "Maurine Johns",
                            avatar: "http://127.0.0.1:8000/src/2.jpg",
                            address: {
                                street: "5th Avenue",
                                number: "106th",
                                city: "Lake Valentine",
                                state: "Kansas",
                            },
                        },
                        type: "health",
                        created_at: "05/03 12:35PM",
                    },
                    {
                        client: {
                            name: "Murray Homenick",
                            avatar: "http://127.0.0.1:8000/src/4.jpg",
                            address: {
                                street: "Harber Vista",
                                number: "75203",
                                apartment: "Suite 221",
                                city: "Port Melyssamouth",
                                state: "Massachusetts",
                            },
                        },
                        type: "police",
                        created_at: "04/03 11:21PM",
                    },
                    {
                        client: {
                            name: "Greyson Hammes",
                            avatar: "http://127.0.0.1:8000/src/8.jpeg",
                            address: {
                                street: "Okey Way",
                                number: "01427",
                                apartment: "Apt. 155",
                                city: "Port Ansley",
                                state: "Texas",
                            },
                        },
                        type: "health",
                        created_at: "04/03 10:03PM",
                    },
                ],
            }
        },
        mounted() {
            const data = [],
                labels = [],
                backgroundColor = []
            for (let i in this.items) {
                let item = this.items[i]
                labels.push(item.name)
                data.push(item.cant)
                backgroundColor.push(item.color)
            }
            const config = {
                type: "doughnut",
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: "Dispositivos",
                            data: data,
                            backgroundColor: backgroundColor,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                        },
                        title: {
                            display: false,
                        },
                    },
                },
            }
            const ctx = this.$el.querySelector(".chart").getContext("2d")
            new Chart(ctx, config)
        },
    }
</script>
<template>
    <div class="flex">
        <div class="w-1/3">
            <p class="text-indigo-500 mb-2 font-bold text-center mt-2">Dispositivos</p>
            <canvas class="chart"></canvas>
        </div>
        <div class="w-2/3 px-4">
            <p class="text-indigo-500 mb-2 font-bold text-center mt-2">Alertas</p>
            <div class="bg-gray-100 p-2 rounded-lg mt-1">
                <div class="rounded bg-white shadow-md flex items-center my-2 p-2" v-for="alert in alerts">
                    <img :src="alert.client.avatar" class="rounded-full w-10 h-10" />
                    <div class="px-2 w-5/12">
                        <h4 class="whitespace-nowrap text-gray-500 font-bold text-ellipsis w-full overflow-hidden">{{ alert.client.name }}</h4>
                        <p v-if="alert.type == 'health'" class="text-sm flex items-center text-sky-600">
                            <!-- <i class="bi bi-heart-pulse-fill"></i> -->
                            🚑 Alerta médica
                        </p>
                        <p v-else class="text-sm flex items-center text-red-600">
                            <!-- <i class="bi bi-heart-pulse-fill"></i> -->
                            🚓 Alerta penal
                        </p>
                    </div>
                    <div class="w-5/3">
                        <p>{{ alert.client.address.number }} {{ alert.client.address.street }} {{ alert.client.address.apartment }}. {{ alert.client.address.city }}, {{ alert.client.address.state }}</p>
                    </div>
                    <div class="w-1/12 flex justify-end">
                        <button><i class="bi bi-three-dots-vertical"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
