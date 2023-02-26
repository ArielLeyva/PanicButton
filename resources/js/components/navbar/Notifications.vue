<script>
    export default {
        data() {
            return {
                notifications: [
                    {
                        title: "Lorem ipsun dolor",
                        text: "Laborum nostrud commodo duis minim mollit culpa pariatur esse eu dolore commodo ad ex non.",
                        client: {
                            name: "Example name",
                            avatar: "http://127.0.0.1:8000/src/1.jpg",
                        },
                    },
                    {
                        title: "Lorem ipsun dolor",
                        text: "Laborum nostrud commodo duis minim mollit culpa pariatur esse eu dolore commodo ad ex non.",
                        client: {
                            name: "Example name",
                            avatar: "http://127.0.0.1:8000/src/1.jpg",
                        },
                    },
                    {
                        title: "Lorem ipsun dolor",
                        text: "Laborum nostrud commodo duis minim mollit culpa pariatur esse eu dolore commodo ad ex non.",
                        client: {
                            name: "Example name",
                            avatar: "http://127.0.0.1:8000/src/1.jpg",
                        },
                    },
                    {
                        title: "Lorem ipsun dolor",
                        text: "Laborum nostrud commodo duis minim mollit culpa pariatur esse eu dolore commodo ad ex non.",
                        client: {
                            name: "Example name",
                            avatar: "http://127.0.0.1:8000/src/1.jpg",
                        },
                    },
                    {
                        title: "Lorem ipsun dolor",
                        text: "Laborum nostrud commodo duis minim mollit culpa pariatur esse eu dolore commodo ad ex non.",
                        client: {
                            name: "Example name",
                            avatar: "http://127.0.0.1:8000/src/1.jpg",
                        },
                    },
                    {
                        title: "Lorem ipsun dolor",
                        text: "Laborum nostrud commodo duis minim mollit culpa pariatur esse eu dolore commodo ad ex non.",
                        client: {
                            name: "Example name",
                            avatar: "http://127.0.0.1:8000/src/1.jpg",
                        },
                    },
                    {
                        title: "Lorem ipsun dolor",
                        text: "Laborum nostrud commodo duis minim mollit culpa pariatur esse eu dolore commodo ad ex non.",
                        client: {
                            name: "Example name",
                            avatar: "http://127.0.0.1:8000/src/1.jpg",
                        },
                    },
                    {
                        title: "Lorem ipsun dolor",
                        text: "Laborum nostrud commodo duis minim mollit culpa pariatur esse eu dolore commodo ad ex non.",
                        client: {
                            name: "Example name",
                            avatar: "http://127.0.0.1:8000/src/1.jpg",
                        },
                    },
                    {
                        title: "Lorem ipsun dolor",
                        text: "Laborum nostrud commodo duis minim mollit culpa pariatur esse eu dolore commodo ad ex non.",
                        client: {
                            name: "Example name",
                            avatar: "http://127.0.0.1:8000/src/1.jpg",
                        },
                    },
                    {
                        title: "Lorem ipsun dolor",
                        text: "Laborum nostrud commodo duis minim mollit culpa pariatur esse eu dolore commodo ad ex non.",
                        client: {
                            name: "Example name",
                            avatar: "http://127.0.0.1:8000/src/1.jpg",
                        },
                    },
                ],
            }
        },
    }
</script>
<template>
    <ul class="dropdown-menu">
        <li class="dropdown-item cursor-pointer" v-for="notification in notifications">
            <div class="flex">
                <div class="w-1/6 flex justify-center items-center">
                    <img :src="notification.client.avatar" class="rounded-full w-8 h-8" />
                </div>
                <div class="w-10/12">
                    <h4 class="w-80 text-gray-500 overflow-hidden whitespace-nowrap text-ellipsis">{{ notification.title }}</h4>
                    <p class="w-64 overflow-hidden text-ellipsis">{{ notification.text }}</p>
                </div>
            </div>
        </li>
    </ul>
</template>
