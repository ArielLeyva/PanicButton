<script>
    import Mixin from "./AlertMixin.js"

    export default {
        /**
         * @mixin: ./AlertMixin.js
         */
        mixins: [Mixin],
    }
</script>

<template>
    <div class="toast align-items-center border-0 dark:bg-slate-400" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex position-relative">
            <div class="toast-body flex items-center">
                <div class="mx-2 flex items-center justify-center">
                    <i class="text-6xl" :class="config.icon" :style="{ color: config.color }"></i>
                </div>
                <div class="border-l border-l-gray-300 py-2 px-3">
                    <h6 class="mb-1 text-black font-bold dark:text-gray-200">{{ config.title }}</h6>
                    <p class="mb-0 text-gray-600 dark:text-gray-50">{{ config.text }}</p>
                </div>
            </div>
            <div :style="{ background: config.color }" class="toast-progress"></div>
            <button type="button" class="btn-close me-2 mt-2 ms-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</template>

<style scoped>
    .toast-progress {
        position: absolute;
        width: 100%;
        height: 5px;
        bottom: 0;
        border-bottom-left-radius: var(--bs-toast-border-radius);
        border-bottom-right-radius: var(--bs-toast-border-radius);
        transition: width ease-in-out 0.1s;
    }
</style>
