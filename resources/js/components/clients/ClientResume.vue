<script>
export default {
    props: {
        client: Object,
    },
}
</script>
<template>
    <div class="mt-4">
        <div class="sm:flex">
            <div class="sm:w-1/3 flex justify-center items-center">
                <div class="text-center">
                    <img :src="client.avatar" class="rounded-full w-28 h-28 border-4"
                        :class="{ 'border-red-600': client.state == 'Bloqueado', 'border-green-600': client.state == 'Activo' }" />
                    <button data-bs-dismiss="modal" @click="$emit('resolve', { status: 'chat', data: client })"
                        class="text-xs bg-indigo-500 rounded p-1 text-white whitespace-nowrap mt-2">
                        <i class="bi bi-chat"></i> Chatear
                    </button>
                </div>
            </div>
            <div class="sm:w-2/3 p-2">
                <div class="flex">
                    <div class="p-2 flex items-center">
                        <div class="bg-indigo-500 rounded-full w-8 h-8 p-1 flex items-center justify-center">
                            <i class="bi bi-person text-white"></i>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-gray-500 dark:text-gray-200 font-bold">
                            {{ client.name }}</h4>
                        <a :href="'mailto:' + client.email" class="dark:text-white">{{ client.email }}</a>
                    </div>
                </div>
                <div class="flex mt-2">
                    <div class="p-2 flex items-center">
                        <div class="bg-indigo-500 rounded-full w-8 h-8 p-1 flex items-center justify-center">
                            <i class="bi bi-geo-alt text-white"></i>
                        </div>
                    </div>
                    <div>
                        <p class="dark:text-gray-200">{{ client.address.number }} {{ client.address.street }} {{
                            client.address.apartment }}. {{
        client.address.city }},
                            {{ client.address.state }}</p>
                    </div>
                </div>
                <div class="text-center mt-2">
                    <a v-for="telephone in client.telephone_numbers"
                        class="text-xs bg-indigo-500 rounded p-1 text-white whitespace-nowrap mx-1"
                        :href="'tel:' + telephone.number">
                        {{ telephone.number }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>
