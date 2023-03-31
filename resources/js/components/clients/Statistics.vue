<script>
    import Chart from "chart.js/auto"

    export default {
        props: {
            /**
             * Lista de botones de la base de datos
             */
            buttons: Array,
        },
        watch: {
            buttons() {
                //Establecer los valores en 0
                this.connected = 0
                this.disconnected = 0
                this.unassigned = 0
                //Iterar sobre los botones para leer su estado
                for (let button of this.buttons) {
                    if (button.client_id == null) {
                        this.unassigned++
                    } else {
                        if (button.state == "Connected") {
                            this.connected++
                        } else {
                            this.disconnected++
                        }
                    }
                }
                //Reinicializar el gráfico
                this.init()
            },
        },
        data() {
            return {
                /**
                 * Número de dispositivos conectados
                 */
                connected: 0,
                /**
                 * Número de dispositivos desconectados
                 */
                disconnected: 0,
                /**
                 * Número de dispositivos sin asignar
                 */
                unassigned: 0,
                /**
                 * Gráfico
                 */
                chart: null,
            }
        },
        methods: {
            init() {
                //Colores del gráfico
                const colors = ["rgb(20, 165, 40)", "rgb(240, 34, 34)", "rgb(163 163 163)"]
                //Crear las cuñas del gráfico de pastel
                const items = [
                    {
                        name: "Dispositivos conectados",
                        cant: this.connected,
                        color: colors[0],
                    },
                    {
                        name: "Dispositivos desconectados",
                        cant: this.disconnected,
                        color: colors[1],
                    },
                    {
                        name: "Dispositivos sin asignar",
                        cant: this.unassigned,
                        color: colors[2],
                    },
                ]
                //Crear la configuración de Chart.js
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
                //Inicializar el gráfico
                const canvas = this.$el.querySelector(".chart").getContext("2d")
                //Destruir el gráfico si ya existe
                if (this.chart) {
                    this.chart.destroy()
                }
                //Añadir el gráfico al DOM
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
