<script>
import Message from './Message.vue'
import ChatForm from './ChatForm.vue'
import MatchedMessage from './MatchedMessage.vue'

export default {
    props: {
        messages: Object,
        sending: Array,
        selection: Object,
        user: Object,
    },
    components: { Message, MatchedMessage, ChatForm },
    data() {
        return {
            matched: null,
            preview: "",
        }
    },
    methods: {
        send() {
            this.scroll()
            this.preview = ''
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
        showPreview(e) {
            const files = e.target.files
            if (!files || !files.length) {
                this.preview = ''
            } else {
                this.preview = URL.createObjectURL(files[0])
            }
        },
        match(e) {
            const text = e.target.value
            this.matched = []
            if (text !== '') {
                for (let message of this.messages) {
                    if (message.message.toLowerCase().includes(text.toLowerCase())) {
                        this.matched.push(message)
                    }
                }
            }
        }
    },
    mounted() {
        this.emitter.on("search-message", () => {
            this.matched = []
        })
    }
}
</script>
<template>
    <div>
        <div class="scroll overflow-auto p-2 message-list" :class="{ 'pt-12': matched !== null }">
            <template v-if="matched == null">
                <Message v-for=" message  in  messages " :message="message" :selection="selection" />
                <Message v-for=" message  in  sending " :message="message" />
            </template>
            <template v-else>
                <MatchedMessage v-for=" message  in  matched " :message="message" :selection="selection" />
            </template>
        </div>
        <div v-if="matched !== null" class="absolute top-0 left-0 p-2">
            <div class="rounded-full bg-indigo-200 flex items-center px-3 py-1">
                <input @input="match"
                    class="bg-transparent dark:text-gray-800 focus-visible:outline-none text-sm" />
                <button @click="matched = null" class="text-indigo-500"><i class="bi bi-x"></i></button>
            </div>
        </div>
        <div v-if="preview !== ''" class="absolute w-full top-0 left-0"
            style="background-color: rgba(0, 0, 0, .5); height: calc(100% - 2.75rem);"></div>
        <transition name="preview">
            <div v-if="preview !== ''"
                class="absolute rounded-md bg-indigo-300 border border-indigo-600 bottom-11 left-6 w-10/12 p-1">
                <img :src="preview" class="w-full rounded-md" />
                <button @click="preview = ''"
                    class="absolute top-1 right-1 p-0.5 w-7 h-7 bg-slate-600 rounded-full text-white opacity-70 hover:opacity-100 transition-opacity"><i
                        class="bi bi-x"></i></button>
            </div>
        </transition>
        <ChatForm :messages="messages" :sending="sending" :user="user" :preview="preview" @sended="send"
            @preview="showPreview" />
    </div>
</template>
<style scoped>
.overflow-auto {
    max-height: calc(100vh - 16rem);
    min-height: calc(100vh - 16rem);
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
