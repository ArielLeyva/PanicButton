<script>
import Request from "../../Request.js"
import Navbar from "./Navbar.vue"
import ChatInfo from "./ChatInfo.vue"
import Message from "./Message.vue"

export default {
    components: { Navbar, ChatInfo, Message },
    data() {
        return {
            chats: [],
            messages: null,
        }
    },
    created() {
        Request.get('api/messages').then((response) => {
            this.chats = response.data
        })
    }
}
</script>
<template>
    <section
        class="bg-gradient-to-br from-indigo-100 to-fuchsia-100 dark:from-slate-600 dark:via-slate-500 dark:to-slate-600 rounded-md">
        <Navbar @back="messages = null" :messages="messages" />
        <div>
            <div v-if="messages == null" class="p-2 scroll overflow-auto">
                <ChatInfo v-for="chat in chats" :messages="chat" @click="messages = chat" />
            </div>
            <div v-else>
                <div class="scroll overflow-auto p-2">
                    <Message v-for="message in messages" :message="message" />
                </div>
                <form class="w-full flex items-center p-2 rounded-b">
                    <div class="flex items-center rounded-full bg-indigo-200 w-full px-1 mr-2">
                        <textarea
                            class="h-7 mr-2 w-full px-2 pt-1 text-sm bg-transparent dark:text-gray-50 dark:placeholder:text-gray-50 focus-visible:outline-none scroll"></textarea>
                        <button class="p-1 text-indigo-500">
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
</style>
