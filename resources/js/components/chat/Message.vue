<script>
export default {
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
    <div :class="{ 'justify-content-end': message.user_id !== null, 'pl-5': message.user_id !== null, 'pr-5': message.user_id == null, hidden: message.message == '' }"
        class="w-full flex py-1 first:pt-0 last:pb-0">
        <div v-if="selection !== null && message.user_id !== null" class="select">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="selection" @change="selection.push(message)" />
            </div>
        </div>
        <img v-if="message.user_id !== null" :src="message.user.avatar" class="rounded-full w-8 h-8 mr-2" />
        <div>
            <img v-if="message.image !== null && message.image !== undefined"
                class="rounded mb-0.5 border border-indigo-500" :src="message.image" />
            <div class="text-sm p-2 rounded bg-indigo-500 text-gray-300">
                <p style="white-space: pre-line">{{ message.message }}</p>
                <div class="flex justify-end">
                    <span class="text-xs text-gray-400">
                        <template v-if="message.created_at == undefined">
                            <i class="bi bi-clock"></i>
                        </template>
                        <template v-else>
                            {{ Utils.time(message.created_at, Utils.FULL_TIME) }}
                        </template>
                    </span>
                </div>
            </div>
        </div>
        <img v-if="message.user_id == null" :src="message.client.avatar" class="rounded-full w-8 h-8 ml-2" />
    </div>
</template>
