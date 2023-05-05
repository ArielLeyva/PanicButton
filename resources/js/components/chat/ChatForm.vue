<script>
import Request from '../../Request.js'
export default {
    emits: ['sended', 'preview'],
    props: {
        messages: Array,
        sending: Array,
        user: Object,
        preview: Object,
    },
    watch: {
        preview() {
            if (this.preview == '') {
                this.$el.querySelector('[type="file"]').value = ''
            }
        }
    },
    methods: {
        send(e) {
            if (this.messages !== null) {
                const data = new FormData(e.target)
                data.append('frontend_id', Math.floor(Math.random() * (10000000 + 1)))
                Request.post('api/messages', data)
                this.sending.push({
                    id: data.get('frontend_id'),
                    message: data.get('message'),
                    client_id: this.messages[0].client_id,
                    client: this.messages[0].client,
                    user_id: this.user.id,
                    user: this.user,
                })
                console.log(this.sending)
                this.$el.querySelector('[name="message"]').value = ''
                this.$emit('sended')
            }
        },
        selectImage() {
            this.$el.querySelector('[type="file"]').click()
        },
    }
}
</script>
<template>
    <form @submit.prevent="send" class="w-full flex items-center p-2 rounded-b">
        <input type="hidden" name="client_id" :value="messages[0].client_id" />
        <input type="file" name="image" class="hidden" @change="(e) => $emit('preview', e)" />
        <div class="flex items-center rounded-full bg-indigo-200 w-full px-1 mr-2">
            <textarea name="message"
                class="h-7 mr-2 w-full px-2 pt-1 text-sm bg-transparent dark:text-gray-900 focus-visible:outline-none scroll"
                required></textarea>
            <button @click="selectImage" type="button" class="p-1 text-indigo-500">
                <i class="bi bi-paperclip"></i>
            </button>
        </div>
        <button class="bg-indigo-500 rounded-full p-1 w-10 h-8">
            <i class="bi bi-send-fill text-white"></i>
        </button>
    </form>
</template>
