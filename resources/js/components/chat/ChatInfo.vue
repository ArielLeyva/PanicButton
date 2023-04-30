<script>
export default {
    emits: ['click'],
    props: {
        messages: Array,
        unread: Number,
    },
}
</script>
<template>
    <div @click="$emit('click')"
        class="flex px-1 items-center border-b py-3 last:border-b-0 border-b-gray-400 cursor-pointer">
        <img :src="messages[0].client.avatar" class="rounded-full w-10 h-10" />
        <div class="ms-2 flex w-full">
            <div>
                <h1 class="text-gray-600 dark:text-gray-200 font-bold">{{ messages[0].client.name }}</h1>
                <p class="dark:text-gray-300 text-sm w-52 truncate block">{{ messages[messages.length - 1].message }}</p>
            </div>
            <div v-if="unread !== 0" class="d-flex items-center p-1">
                <span class="bg-indigo-500 rounded-full w-5 h-5 text-white text-center text-sm"> {{ unread }} </span>
            </div>
        </div>
    </div>
</template>
