<script>
import Request from "../../Request.js"
import Navbar from "./Navbar.vue"
import ChatInfo from "./ChatInfo.vue"
import Message from "./Message.vue"

export default {
    components: { Navbar, ChatInfo, Message },
    emits: ['close'],
    props: {
        user: Object
    },
    data() {
        return {
            chats: [],
            messages: null,
            text: '',
            sending: [],
            selection: null,
            preview: ""
        }
    },
    methods: {
        send(e) {
            if (this.messages !== null) {
                const data = new FormData(e.target)
                data.append('frontend_id', Math.random())
                Request.post('api/messages', data).then((data) => {
                    const message = data
                    for (let i in this.sending) {
                        if (this.sending[i].id == message.frontend_id) {
                            this.sending.splice(i, 1)
                            break
                        }
                    }
                    this.messages.push(message)
                })
                this.sending.push({
                    id: data.get('frontend_id'),
                    message: data.get('message'),
                    client_id: this.messages[0].client_id,
                    client: this.messages[0].client,
                    user_id: this.user.id,
                    user: this.user,
                })
                this.scroll()
                this.$el.querySelector('[name="message"]').value = ""
            }
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
        scroll() {
            const messageList = this.$el.querySelector(".message-list")
            const length = (messageList.scrollHeight - messageList.scrollTop) / 50
            let i = 1
            const interval = setInterval(() => {
                messageList.scrollTop += length
                i++
                if (i > 50) clearInterval(interval)
            }, 5)
        },
        back() {
            if (this.messages !== null) {
                this.messages = null
                this.selection = null
            } else {
                this.$emit('close')
            }
        },
        showPreview(e) {
            const files = e.target.files
            if (!files || !files.length) {
                this.preview = ""
            } else {
                this.preview = URL.createObjectURL(files[0])
            }
        },
        selectImage() {
            this.$el.querySelector('[type="file"]').click()
        },
        unselectImage() {
            this.$el.querySelector('[type="file"]').value = ''
            this.preview = ''
        }
    },
    created() {
        Request.get('api/messages').then((response) => {
            this.chats = response.data
        })
    },
    mounted() {
        // this.$el.querySelector('[type="file"]').addEventListener("change", () => {
        //     const files = this.annexed.files
        //     if (!files || !files.length) {
        //         this.src = ""
        //     } else {
        //         this.src = URL.createObjectURL(files[0])
        //     }
        //     preview.src = this.src
        // })
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
                <ChatInfo v-for=" chat  in  chats " :messages="chat" @click="messages = chat" />
            </div>
            <div v-else class="relative">
                <div class="scroll overflow-auto p-2 message-list">
                    <Message v-for=" message  in  messages " :message="message" :selection="selection" />
                    <Message v-for=" message  in  sending " :message="message" />
                </div>
                <div v-if="preview !== ''" class="absolute w-full top-0 left-0"
                    style="background-color: rgba(0, 0, 0, .5); height: calc(100% - 2.75rem);"></div>
                <transition name="preview">
                    <div v-if="preview !== ''"
                        class="absolute rounded-md bg-indigo-300 border border-indigo-600 bottom-11 left-6 w-10/12 p-1">
                        <img :src="preview" class="w-full rounded-md" />
                        <button @click="unselectImage"
                            class="absolute top-1 right-1 p-0.5 w-7 h-7 bg-slate-600 rounded-full text-white opacity-70 hover:opacity-100 transition-opacity"><i
                                class="bi bi-x"></i></button>
                    </div>
                </transition>
                <form @submit.prevent="send" class="w-full flex items-center p-2 rounded-b">
                    <input type="hidden" name="client_id" :value="messages[0].client_id" />
                    <input type="file" name="image" class="hidden" @change="showPreview" />
                    <div class="flex items-center rounded-full bg-indigo-200 w-full px-1 mr-2">
                        <textarea name="message"
                            class="h-7 mr-2 w-full px-2 pt-1 text-sm bg-transparent dark:text-gray-50 dark:placeholder:text-gray-50 focus-visible:outline-none scroll"
                            required></textarea>
                        <button @click="selectImage" type="button" class="p-1 text-indigo-500">
                            <i class="bi bi-paperclip"></i>
                        </button>
                    </div>
                    <button class="bg-indigo-500 rounded-full p-1 w-10 h-8">
                        <i class="bi bi-send-fill text-white"></i>
                    </button>
                </form>
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
    max-height: calc(100vh - 16rem);
}

@keyframes backInUp {
    0% {
        transform: translateY(1200px) scale(0.7);
        opacity: 0.7;
    }

    80% {
        transform: translateY(0px) scale(0.7);
        opacity: 0.7;
    }

    100% {
        transform: scale(1);
        opacity: 1;
    }
}

.preview-enter-active {
    animation: backInUp 0.5s;
    animation-fill-mode: forwards;
    animation-timing-function: ease-in;
}

.preview-leave-active {
    animation: backInUp 0.5s;
    animation-fill-mode: backwards;
    animation-direction: reverse;
    animation-timing-function: ease-out;
}
</style>
