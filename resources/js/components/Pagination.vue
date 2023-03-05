<script>
    export default {
        emits: ["paginate"],
        props: {
            /**
             * Alertas de la página
             */
            alerts: Array,
            rows: {
                type: Number,
                default: 4,
            },
        },
        data() {
            return {
                /**
                 * Contiene los botones de de paginación de la tabla que son ocultados para ajustarse al ancho disponible
                 */
                hiddenButtons: [],
                /**
                 * Contiene los botones de paginación cuyo número es reemplazado por el texto "..." para indicar que se han ocultado botones de la paginación para ajustarse al ancho disponible
                 */
                ellipsisButtons: [],
                page: 0,
                pages: Math.ceil(this.alerts.length / this.rows),
            }
        },
        watch: {
            alerts(p, l) {
                this.pages = Math.ceil(p.length / this.rows)
                setTimeout(() => {
                    this.resize()
                }, 100)
            },
        },
        methods: {
            /**
             * Ir a la página siguiente
             */
            nextPage() {
                this.page++
                this.$emit("paginate", this.page)
            },
            /**
             * Ir a la página anterior
             */
            previousPage() {
                this.page--
                this.$emit("paginate", this.page)
            },
            /**
             * Mostrar una página por su índice
             * @param {number} index Índice de la página a mostrar
             */
            selectPage(index) {
                this.page = index
                this.$emit("paginate", this.page)
            },
            /**
             * Ocultar los botones sobrantes según el ancho disponible para mostrar los botones de paginación
             */
            resize() {
                this.hiddenButtons = []
                this.ellipsisButtons = []
                //Página actual
                const num = this.page
                //Ancho disponible menos el padding
                const width = this.$el.offsetWidth - 25
                //Cantidad de botones
                const length = this.alerts.length
                //Cantidad de botones que no caben
                let diff = length + 2 - Math.ceil(width / 45)
                if (diff > 0) {
                    //Si la página actual no es la primera añadir "..." a la primera página
                    if (num != 0) {
                        diff++
                        this.ellipsisButtons.push(0)
                    }
                    //Si la página actual no es la última añadir "..." a la última página
                    if (num != length - 1) {
                        diff++
                        this.ellipsisButtons.push(length - 1)
                    }
                    //Ocultar las páginas que no caben
                    for (let i = 0, left = 0, rigth = length; i < diff; i++) {
                        //Alternar para ocultar por la derecha o por la izquierda
                        if (i % 2 == 0) {
                            //Si se puede ocultar por la izquierda
                            if (left < num) {
                                //Ocultar por la izquierda
                                this.hiddenButtons.push(left)
                                left++
                            } else {
                                //Ocultar por la derecha
                                this.hiddenButtons.push(rigth)
                                rigth--
                            }
                        } else {
                            //Si se puede ocultar por la derecha
                            if (rigth > num) {
                                //Ocultar por la derecha
                                this.hiddenButtons.push(rigth)
                                rigth--
                            } else {
                                //Ocultar por la izquierda
                                this.hiddenButtons.push(left)
                                left++
                            }
                        }
                    }
                }
            },
        },
        mounted() {
            //Detectar cuando cambie el ancho de la ventana del navegador y actualizar los botones de paginación que deben ser ocultados o mostrados según el nuevo ancho disponible
            window.addEventListener("resize", () => {
                this.resize()
            })
        },
    }
</script>
<template>
    <nav class="navigation mt-2 text-sm">
        <ul class="pagination justify-content-center mb-2">
            <li class="page-item">
                <a class="page-link dark:bg-slate-500 dark:text-white" :class="{ disabled: page == 0 }" role="button" @click="previousPage"><i class="bi bi-chevron-double-left"></i></a>
            </li>
            <template v-for="(alert, index) in pages">
                <li v-if="!hiddenButtons.includes(index) || ellipsisButtons.includes(index)" class="page-item">
                    <a class="page-link dark:bg-slate-500 dark:border-gray-200 dark:text-white" :class="{ active: index == page }" role="button" @click="selectPage(index)">
                        <template v-if="ellipsisButtons.includes(index)"> ... </template>
                        <template v-else>
                            {{ index + 1 }}
                        </template>
                    </a>
                </li>
            </template>
            <li class="page-item">
                <a class="page-link dark:bg-slate-500 dark:text-white" :class="{ disabled: page >= pages - 1 }" role="button" @click="nextPage"><i class="bi bi-chevron-double-right"></i></a>
            </li>
        </ul>
    </nav>
</template>
<style>
    .page-link.active,
    .active > .page-link {
        z-index: 3;
        background-color: #6366f1 !important;
        border-color: #6366f1;
    }
</style>
