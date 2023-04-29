<script>
export default {
    props: {
        message: Object,
        selection: {
            type: Object,
            default: null
        }
    },
    methods: {
        getTimeString() {
            const time = this.Utils.datetime(this.message.created_at, this.Utils.FULL_TIME)
            const comma = time.indexOf(",")
            return time.substring(comma + 2)
        },
    }
}
</script>
<template>
    <div :class="{ 'float-right': message.user_id !== null, 'pl-5': message.user_id !== null, 'pr-5': message.user_id == null }"
        class="w-full flex py-1 first:pt-0 last:pb-0">
        <div v-if="selection !== null && message.user_id !== null" class="select">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="selection" @change="selection.push(message)" />
            </div>
        </div>
        <img v-if="message.user_id !== null" :src="message.user.avatar" class="rounded-full w-8 h-8 mr-2" />
        <p class="text-sm p-2 rounded bg-indigo-500 text-gray-300" style="white-space: pre-line">
            {{ message.message }}
            <span class="float-right text-xs ml-2 mt-1 text-gray-400">
                <template v-if="message.created_at == undefined">
                    <i class="bi bi-clock"></i>
                </template>
                <template v-else>
                    {{ getTimeString() }}
                </template>
            </span>
        </p>
        <img v-if="message.user_id == null" :src="message.client.avatar" class="rounded-full w-8 h-8 ml-2" />
    </div>
</template>
