<script>
import CustomModal from "../modal/Modal.vue"

export default {
    components: { CustomModal },
    data() {
        return {
            /**
             * Lista de números de teléfonos
             */
            numbers: [""],
            /**
             * Avatar seleccionado
             */
            avatar: null,
            /**
             * Ruta o datos de la imagen a mostrar en pantalla
             */
            image: "src/blank-profile.svg",
        }
    },
    methods: {
        /**
         * Añadir nuevo campo para introducir un número de teléfono
         */
        add() {
            this.numbers.push("")
        },
        /**
         * Eliminar número de teléfono
         */
        remove(index) {
            this.numbers.splice(index, 1)
        },
    },
    mounted() {
        // //Instanciar el input para el avatar
        // this.avatar = this.$el.querySelector("[name='avatar']")
        // //Añadir evento para cuando se seleccione una imagen
        // this.avatar.addEventListener("change", () => {
        //     const files = this.avatar.files
        //     if (!files || !files.length) {
        //         //Si no se seleccionó imagen mostrar avatar por defecto
        //         this.image = "src/blank-profile.svg"
        //     } else {
        //         //Si hay una imagen seleccionada mostrarla en pantalla
        //         this.image = URL.createObjectURL(files[0])
        //     }
        // })
        //Si se van a modificar los datos del cliente instanciar los datos existentes
        if (this.client.telephone_numbers !== undefined) {
            //Instanciar los números de teléfono
            this.numbers = []
            for (let number of this.client.telephone_numbers) {
                this.numbers.push(number.number)
            }
            //Instanciar la imagen
            this.image = this.client.avatar
        }
    },
}
</script>

<template>
    <CustomModal :config="config" @accept="accept" @cancel="cancel">
        <div style="background-color: indigo;color: white;border-radius: 5px;">

        </div>
        <form class="alert-form scroll">
            <!-- <input type="file" name="avatar" class="hidden" />
            <div class="flex justify-center relative">
                <img @click="avatar.click()" class="w-20 rounded-full cursor-pointer" :src="image" />
                <button type="button" @click="reset" class="bg-transparent text-gray-600 dark:text-gray-50 absolute top-0"
                    style="right: calc(50% - 3.75rem)"><i class="bi bi-trash"></i></button>
            </div> -->
            <fieldset class="flex">
                <div class="flex items-center px-2 relative py-2 w-1/2">
                    <i class="bi bi-person absolute top-3 left-4 text-gray-500 dark:text-gray-50"></i>
                    <input
                        class="border border-gray-400 dark:border-white dark:bg-slate-500 dark:text-gray-50 dark:placeholder:text-gray-200 rounded focus-visible:outline-none pl-8 py-1"
                        name="name" type="text" placeholder="Nombre del cliente" :value="client.name" />
                </div>
                <div class="flex items-center px-2 relative py-2 w-1/2">
                    <i class="bi bi-person-vcard absolute top-3 left-4 text-gray-500 dark:text-gray-50"></i>
                    <input
                        class="border border-gray-400 dark:border-white dark:bg-slate-500 dark:text-gray-50 dark:placeholder:text-gray-200 rounded focus-visible:outline-none pl-8 py-1"
                        name="dni" type="text" placeholder="DNI del cliente" :value="client.dni" />
                </div>
            </fieldset>
            <fieldset>
                <div class="flex items-center px-2 relative py-2 w-1/2">
                    <i class="bi bi-envelope absolute top-3 left-4 text-gray-500 dark:text-gray-50"></i>
                    <input
                        class="border border-gray-400 dark:border-white dark:bg-slate-500 dark:text-gray-50 dark:placeholder:text-gray-200 rounded focus-visible:outline-none pl-8 py-1"
                        name="email" type="email" placeholder="Correo electrónico" :value="client.email" />
                </div>
            </fieldset>
            <fieldset class="flex">
                <div class="mt-3 w-1/2">
                    <span class="text-gray-500 font-bold dark:text-gray-300">Sexo</span>
                    <div class="form-check mb-1">
                        <input class="form-check-input" type="radio" name="gender" value="Femenino" id="female" checked />
                        <label class="form-check-label dark:text-white" for="female">Femmenino</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" value="Masculino" id="male"
                            :checked="client.gender == 'Masculino'" />
                        <label class="form-check-label dark:text-white" for="male">Masculino</label>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="text-gray-500 font-bold dark:text-gray-100">Estado del cliente</span>
                    <div class="form-check mb-1">
                        <input class="form-check-input" type="radio" name="state" value="Activo" id="state-active"
                            checked />
                        <label class="form-check-label dark:text-white" for="state-active">Activo</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="state" value="Inactivo" id="state-inactive"
                            :checked="client.state == 'Inactivo'" />
                        <label class="form-check-label dark:text-white" for="state-inactive">Inactivo</label>
                    </div>
                </div>
            </fieldset>
            <fieldset class="mt-2">
                <label class="text-gray-500 font-bold dark:text-gray-100">Dirección postal</label>
                <div class="flex">
                    <div class="flex items-center px-2 relative py-2 w-1/2">
                        <input
                            class="border border-gray-400 dark:border-white dark:bg-slate-500 dark:text-gray-50 dark:placeholder:text-gray-200 rounded focus-visible:outline-none pl-2 w-full py-1"
                            name="address[street]" type="text" placeholder="Calle, camino o avenida"
                            :value="client.address.street" />
                    </div>
                    <div class="flex items-center px-2 relative py-2 w-1/2">
                        <input
                            class="border border-gray-400 dark:border-white dark:bg-slate-500 dark:text-gray-50 dark:placeholder:text-gray-200 rounded focus-visible:outline-none pl-2 w-full py-1"
                            name="address[number]" type="text" placeholder="Número de casa, apartamento, piso"
                            :value="client.address.number" />
                    </div>
                </div>
                <div class="flex">
                    <div class="flex items-center px-2 relative py-2 w-1/2">
                        <input
                            class="border border-gray-400 dark:border-white dark:bg-slate-500 dark:text-gray-50 dark:placeholder:text-gray-200 rounded focus-visible:outline-none pl-2 w-full py-1"
                            name="address[city]" type="text" placeholder="Ciudad" :value="client.address.city" />
                    </div>
                    <div class="flex items-center px-2 relative py-2 w-1/2">
                        <input
                            class="border border-gray-400 dark:border-white dark:bg-slate-500 dark:text-gray-50 dark:placeholder:text-gray-200 rounded focus-visible:outline-none pl-2 w-full py-1"
                            name="address[state]" type="text" placeholder="Estado" :value="client.address.state" />
                    </div>
                </div>
                <div class="flex">
                    <div class="flex items-center px-2 relative py-2 w-1/2">
                        <input
                            class="border border-gray-400 dark:border-white dark:bg-slate-500 dark:text-gray-50 dark:placeholder:text-gray-200 rounded focus-visible:outline-none pl-2 w-full py-1"
                            name="address[postal_code]" type="text" placeholder="Código postal"
                            :value="client.address.postal_code" />
                    </div>
                </div>
            </fieldset>
            <fieldset class="mt-2">
                <button type="button" @click="add" class="float-right bg-indigo-500 rounded p-1 text-white text-sm"><i
                        class="bi bi-plus"></i> Añadir número</button>
                <label class="text-gray-500 font-bold dark:text-gray-100">Números de teléfono</label>
                <div class="mt-2">
                    <div v-for="(number, index) in numbers" class="flex items-center px-2 relative py-2">
                        <input
                            class="border border-gray-400 dark:border-white dark:bg-slate-500 dark:text-gray-50 dark:placeholder:text-gray-200 rounded focus-visible:outline-none pl-2 w-full py-1"
                            name="telephone_numbers[]" type="tel" placeholder="Número de teléfono" :value="number" />
                        <button type="button" @click="remove(index)"
                            class="bg-red-600 rounded p-1 text-white text-sm ml-2 whitespace-nowrap"><i
                                class="bi bi-trash"></i> Eliminar</button>
                    </div>
                </div>
            </fieldset>
        </form>
    </CustomModal>
</template>
<style scoped>
.alert-form {
    max-height: calc(100vh - 15rem);
    overflow: auto;
}
</style>
