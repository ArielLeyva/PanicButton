<script>
import Request from "../../Request.js"
import Navbar from "./Navbar.vue"
import ChatInfo from "./ChatInfo.vue"
import ChatBody from "./ChatBody.vue"

export default {
    components: { Navbar, ChatInfo, ChatBody },
    emits: ['close', 'unread'],
    props: {
        user: Object
    },
    data() {
        return {
            chats: [],
            messages: null,
            selection: null,
            unread: [],
        }
    },
    watch: {
        messages() {
            if (this.messages !== null) {
                const ids = []
                for (let message of this.messages) {
                    if (message.state !== 'seen') {
                        ids.push(message.id)
                        message.state = 'seen'
                    }
                }
                const data = new FormData()
                data.append('ids', ids)
                data.append('_method', 'PUT')
                Request.post('api/messages/read', data)
                this.init()
            }
        }
    },
    methods: {
        init() {
            this.unread = []
            let unread = 0
            for (let chat of this.chats) {
                let count = 0;
                for (let message of chat) {
                    if (message.user_id == null && message.state != 'seen') {
                        count++
                    }
                }
                this.unread.push(count)
                unread += count
            }

            this.$emit('unread', unread)
        },
        remove() {
            const data = new FormData()
            const ids = []
            if (this.selection.length == 0) return
            for (let message of this.selection) {
                ids.push(message.id)
            }
            data.append('ids', ids)
            Request.delete('api/messages', data).then(() => {
                for (let id of ids) {
                    for (let i in this.messages) {
                        if (id == this.messages[i].id) {
                            this.messages.splice(i, 1)
                            break
                        }
                    }
                }
                this.selection = null
            })
        },
        back() {
            if (this.messages !== null) {
                this.messages = null
                this.selection = null
            } else {
                this.$emit('close')
            }
        },
    },
    created() {
        Request.get('api/messages').then((response) => {
            this.chats = response.data
            this.init()
        })
    },
}
</script>
<template>
    <section
        class="bg-gradient-to-br from-indigo-100 to-fuchsia-100 dark:from-slate-600 dark:via-slate-500 dark:to-slate-600 rounded-md">
        <Navbar @back="back" :messages="messages" :selection="selection" @select="selection = []"
            @unselect="selection = null" @remove="remove" />
        <div>
            <div v-if="messages == null" class="p-2 scroll overflow-auto">
                <ChatInfo v-for=" (chat, index)  in  chats " :messages="chat" @click="messages = chat"
                    :unread="unread[index]" />
            </div>
            <div v-else class="relative">
                <ChatBody :messages="messages" :selection="selection" :user="user" />
            </div>
        </div>
    </section>
</template>
<style scoped>
section {
    height: calc(100vh - 10rem);
    width: 310px;
}
</style>
