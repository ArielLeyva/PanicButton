<script>
    import Chart from "chart.js/auto"

    export default {
        props: {
            buttons: Object,
        },
        watch: {
            buttons() {
                this.init()
            },
        },
        data() {
            return {
                chart: null,
            }
        },
        methods: {
            init() {
                const colors = ["rgb(20, 165, 40)", "rgb(240, 34, 34)"]
                const items = [
                    {
                        name: "Dispositivos conectados",
                        cant: this.buttons.Connected == undefined ? 0 : this.buttons.Connected.length,
                        color: colors[0],
                    },
                    {
                        name: "Dispositivos desconectados",
                        cant: this.buttons.Disconnected == undefined ? 0 : this.buttons.Disconnected.length,
                        color: colors[1],
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
        <p class="text-indigo-500 mb-2 font-bold text-center mt-2">Dispositivos</p>
        <canvas class="chart"></canvas>
    </div>
</template>
