<script>
    export default {
        props: {
            button: Object,
        },
    }
</script>
<template>
    <div class="flex items-center my-2 bg-white p-3 rounded-lg shadow-sm cursor-pointer">
        <img :src="button.client.avatar" class="rounded-full w-10 h-10" />
        <div class="px-2 w-3/4">
            <h4 class="whitespace-nowrap text-gray-500 font-bold text-ellipsis w-full overflow-hidden">{{ button.client.name }}</h4>
            <p class="text-sm flex items-center" :class="{ 'text-green-600': button.state == 'Connected', 'text-red-600': button.state == 'Disconnected' }">
                <i class="bi bi-circle-fill mr-1" style="font-size: 0.7em"></i>
                {{ button.state }}
            </p>
        </div>
        <div class="flex w-full justify-end">
            <button><i class="bi bi-three-dots-vertical"></i></button>
        </div>
    </div>
</template>
