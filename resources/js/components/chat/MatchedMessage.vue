<script>
import Message from './Message.vue';

export default {
    components: { Message },
    props: {
        message: Object,
        selection: {
            type: Object,
            default: null
        }
    },
}
</script>
<template>
    <div class="border-b border-gray-300 py-2 last:border-b-0">
        <p class="text-xs text-gray-400 text-center">{{ Utils.datetime(message.created_at, Utils.FULL_DATE_TIME) }}</p>
        <Message :message="message" :selection="selection" />
    </div>
</template>
