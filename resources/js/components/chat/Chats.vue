<script>
import Pusher from "pusher-js"

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
            sending: [],
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
        sort() {
            this.chats.sort((a, b) => {
                const dateA = new Date(a[a.length - 1].created_at)
                const dateB = new Date(b[b.length - 1].created_at)
                if (dateA < dateB) {
                    return 1
                } else {
                    return -1
                }
            })
        },
        init() {
            this.sort()
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
        //Instanciar pusher para recibir mensajes en tiempo real (Websocket)
        const pusher = new Pusher(import.meta.env.VITE_PUSHER_APP_KEY, {
            cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
        })
        //Suscribirse al canal de alertas
        const channel = pusher.subscribe("message-channel")
        //Añadir oyente de alerta presionada
        channel.bind("MessageSended", (data) => {
            const message = data.message
            for (let i in this.sending) {
                if (this.sending[i].id == data.frontend_id) {
                    this.sending.splice(i, 1)
                    break
                }
            }
            for (let i in this.chats) {
                const chat = this.chats[i]
                if (chat[0].client_id == message.client_id) {
                    chat.push(message)
                    break
                }
            }
            this.init()

        })
        channel.bind("MessageRemoved", (data) => {
            const ids = data.ids
            for (let i in this.chats) {
                const chat = this.chats[i]
                if (chat[0].client_id == data.client) {
                    for (let id of ids) {
                        for (let j in chat) {
                            if (id == chat[j].id) {
                                chat.splice(j, 1)
                                break
                            }
                        }
                    }
                    if (chat.length == 0) {
                        this.messages = null
                        this.chats.splice(i, 1)
                    }
                    break
                }
            }
            this.init()
        })
    },
    mounted() {
        this.emitter.on("client-chat", (client) => {
            let isEmpty = true
            for (let chat of this.chats) {
                if (chat[0].client_id == client.id) {
                    isEmpty = false
                    this.messages = chat
                    break
                }
            }
            if (isEmpty) {
                this.chats.unshift([
                    {
                        id: 0,
                        message: '',
                        client_id: client.id,
                        client: client,
                        user_id: null,
                        user: null,
                    }
                ])
                this.unread.unshift(0)
                this.messages = this.chats[0]
            }
        })
    }
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
                <ChatBody ref="chatBody" :messages="messages" :sending="sending" :selection="selection" :user="user" />
            </div>
        </div>
    </section>
</template>
<style scoped>
section {
    height: calc(100vh - 10rem);
    width: 310px;
}

.overflow-auto {
    max-height: calc(100vh - 13rem);
    min-height: calc(100vh - 13rem);
}
</style>
