<script>
export default {
    props: {
        message: Object,
    },
    methods: {
        getTimeString() {
            const time = this.Utils.datetime(this.message.created_at, this.Utils.FULL_TIME)
            const comma = time.indexOf(",")
            return time.substring(comma + 2)
        }
    }
}
</script>
<template>
    <div :class="{ 'float-right': message.user_id !== null, 'pl-5': message.user_id !== null, 'pr-5': message.user_id == null }"
        class="w-full flex py-1 first:pt-0 last:pb-0">
        <img v-if="message.user_id !== null" :src="message.user.avatar" class="rounded-full w-8 h-8 mr-2" />
        <p class="text-sm p-2 rounded bg-indigo-500 text-gray-300">
            {{ message.message }}
            <span class="float-right text-xs ml-2 mt-1 text-gray-400">{{ getTimeString() }}</span>
        </p>
        <img v-if="message.user_id == null" :src="message.client.avatar" class="rounded-full w-8 h-8 ml-2" />
    </div>
</template>
