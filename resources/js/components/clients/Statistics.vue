<script>
    import Chart from "chart.js/auto"

    export default {
        props: {
            buttons: Object,
        },
        watch: {
            buttons() {
                this.free = 0
                this.occupied = 0
                this.unassigned = 0
                for (let button of this.buttons) {
                    if (button.client_id == null) {
                        this.unassigned++
                    } else {
                        if (button.client.state == "Activo") {
                            this.occupied++
                        } else {
                            this.free++
                        }
                    }
                }
                this.init()
            },
        },
        data() {
            return {
                free: 0,
                occupied: 0,
                unassigned: 0,
                chart: null,
            }
        },
        methods: {
            init() {
                const colors = ["rgb(20, 165, 40)", "rgb(240, 34, 34)", "rgb(163 163 163)"]
                const items = [
                    {
                        name: "Clientes activos",
                        cant: this.occupied,
                        color: colors[0],
                    },
                    {
                        name: "Clientes inactivos",
                        cant: this.free,
                        color: colors[1],
                    },
                    {
                        name: "Dispositivos sin asignar",
                        cant: this.unassigned,
                        color: colors[2],
                    },
                ]
                const data = [],
                    labels = [],
                    backgroundColor = []
                for (let i in items) {
                    let item = items[i]
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
                const canvas = this.$el.querySelector(".chart").getContext("2d")
                if (this.chart) {
                    this.chart.destroy()
                }
                this.chart = new Chart(canvas, config)
            },
        },
        mounted() {
            this.init()
        },
    }
</script>
<template>
    <div class="w-1/3 md:w-8/12 lg:w-1/3 m-auto hidden md:block">
        <p class="text-indigo-500 mb-2 font-bold text-center mt-2 dark:text-gray-50">Dispositivos</p>
        <canvas class="chart"></canvas>
    </div>
</template>
