<script>
    import CustomModal from "../modal/Modal.vue"

    export default {
        components: { CustomModal },
    }
</script>

<template>
    <CustomModal :config="config" @accept="accept" @cancel="cancel">
        <form class="alert-form">
            <div class="form-floating mb-3">
                <input min="6" max="6" type="text" placeholder="Número de indetificación" class="form-control dark:bg-slate-300" name="number" required />
                <label>Número de indetificación <i class="bi bi-check-all"></i></label>
            </div>
            <div class="mt-3">
                <span class="text-gray-500 font-bold dark:text-gray-100">Estado del dispositivo</span>
                <div class="form-check mb-1">
                    <input class="form-check-input" type="radio" name="state" value="Connected" id="state-active" checked />
                    <label class="form-check-label dark:text-white" for="state-active">Conectado</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="state" value="Disconnected" id="state-inactive" />
                    <label class="form-check-label dark:text-white" for="state-inactive">Desconectado</label>
                </div>
            </div>
        </form>
    </CustomModal>
</template>
