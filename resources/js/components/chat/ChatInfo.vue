<script>
export default {
    emits: ['click'],
    props: {
        messages: Array
    },
    methods: {
        getLastMessage() {
            const message = this.messages[this.messages.length - 1].message
            if (message.length > 40) {
                // return message.substring(0, 40) + '...'
                return message
            } else {
                return message
            }
        }
    }
}
</script>
<template>
    <div @click="$emit('click')" class="flex px-1 items-center border-b py-3 last:border-b-0 border-b-gray-400 cursor-pointer">
        <img :src="messages[0].client.avatar" class="rounded-full w-10 h-10" />
        <div class="ms-2">
            <h1 class="text-gray-600 dark:text-gray-200 font-bold">{{ messages[0].client.name }}</h1>
            <p class="dark:text-gray-300 text-sm w-60 truncate block">{{ getLastMessage() }}</p>
        </div>
    </div>
</template>
