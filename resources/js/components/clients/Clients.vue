<script>
    export default {
        data() {
            return {
                clients: [
                    {
                        name: "Dr. Stefanie Gibson",
                        dni: 25896589658,
                        avatar: "http://127.0.0.1:8000/src/1.jpg",
                        state: "Connected",
                        address: {
                            street: "5th Avenue",
                            number: "106th",
                            city: "Lake Valentine",
                            state: "Kansas",
                        },
                        button: {
                            number: 154869,
                        },
                        telephone_numbers: [
                            {
                                number: "+53 54256338",
                                type: "mobile",
                            },
                        ],
                    },
                    {
                        name: "Maurine Johns",
                        dni: 98547858963,
                        avatar: "http://127.0.0.1:8000/src/2.jpg",
                        state: "Connected",
                        address: {
                            street: "Harber Vista",
                            number: "75203",
                            apartment: "Suite 221",
                            city: "Port Melyssamouth",
                            state: "Massachusetts",
                        },
                        button: {
                            number: 154869,
                        },
                        telephone_numbers: [
                            {
                                number: "+53 58352114",
                                type: "mobile",
                            },
                            {
                                number: "+53 5635214",
                                type: "mobile",
                            },
                        ],
                    },
                    {
                        name: "Prof. Mervin Bergnaum",
                        dni: 68963258745,
                        avatar: "http://127.0.0.1:8000/src/3.jpg",
                        state: "Disconnected",
                        address: {
                            street: "Okey Way",
                            number: "01427",
                            apartment: "Apt. 155",
                            city: "Port Ansley",
                            state: "Texas",
                        },
                        button: {
                            number: 154869,
                        },
                        telephone_numbers: [
                            {
                                number: "+53 58091603",
                                type: "mobile",
                            },
                            {
                                number: "+22 6123456",
                                type: "normal",
                            },
                        ],
                    },
                    {
                        name: "Mr. Hal Gerlach",
                        dni: 25896589658,
                        avatar: "http://127.0.0.1:8000/src/4.jpg",
                        state: "Connected",
                        address: {
                            street: "5th Avenue",
                            number: "106th",
                            city: "Lake Valentine",
                            state: "Kansas",
                        },
                        button: {
                            number: 154869,
                        },
                        telephone_numbers: [
                            {
                                number: "+53 58091603",
                                type: "mobile",
                            },
                            {
                                number: "+22 6123456",
                                type: "normal",
                            },
                        ],
                    },
                    {
                        name: "Murray Homenick",
                        dni: 25896589658,
                        avatar: "http://127.0.0.1:8000/src/5.jpg",
                        state: "Connected",
                        address: {
                            street: "5th Avenue",
                            number: "106th",
                            city: "Lake Valentine",
                            state: "Kansas",
                        },
                        button: {
                            number: 154869,
                        },
                        telephone_numbers: [
                            {
                                number: "+53 58091603",
                                type: "mobile",
                            },
                            {
                                number: "+22 6123456",
                                type: "normal",
                            },
                        ],
                    },
                    {
                        name: "Roman Renner",
                        dni: 25896589658,
                        avatar: "http://127.0.0.1:8000/src/6.jpeg",
                        state: "Disconnected",
                        address: {
                            street: "5th Avenue",
                            number: "106th",
                            city: "Lake Valentine",
                            state: "Kansas",
                        },
                        button: {
                            number: 154869,
                        },
                        telephone_numbers: [
                            {
                                number: "+53 58091603",
                                type: "mobile",
                            },
                            {
                                number: "+22 6123456",
                                type: "normal",
                            },
                        ],
                    },
                    {
                        name: "Mr. Ike Grimes DVM",
                        dni: 25896589658,
                        avatar: "http://127.0.0.1:8000/src/7.jpeg",
                        state: "Connected",
                        address: {
                            street: "5th Avenue",
                            number: "106th",
                            city: "Lake Valentine",
                            state: "Kansas",
                        },
                        button: {
                            number: 154869,
                        },
                        telephone_numbers: [
                            {
                                number: "+53 58091603",
                                type: "mobile",
                            },
                            {
                                number: "+22 6123456",
                                type: "normal",
                            },
                        ],
                    },
                    {
                        name: "Greyson Hammes",
                        dni: 25896589658,
                        avatar: "http://127.0.0.1:8000/src/8.jpeg",
                        state: "Connected",
                        address: {
                            street: "5th Avenue",
                            number: "106th",
                            city: "Lake Valentine",
                            state: "Kansas",
                        },
                        button: {
                            number: 154869,
                        },
                        telephone_numbers: [
                            {
                                number: "+53 58091603",
                                type: "mobile",
                            },
                            {
                                number: "+22 6123456",
                                type: "normal",
                            },
                        ],
                    },
                    {
                        name: "Mr. Jamie Kshlerin",
                        dni: 25896589658,
                        avatar: "http://127.0.0.1:8000/src/9.jpg",
                        state: "Disconnected",
                        address: {
                            street: "5th Avenue",
                            number: "106th",
                            city: "Lake Valentine",
                            state: "Kansas",
                        },
                        button: {
                            number: 154869,
                        },
                        telephone_numbers: [
                            {
                                number: "+53 58091603",
                                type: "mobile",
                            },
                            {
                                number: "+22 6123456",
                                type: "normal",
                            },
                        ],
                    },
                    {
                        name: "Dr. Dillon Kilback",
                        dni: 25896589658,
                        avatar: "http://127.0.0.1:8000/src/10.jpg",
                        state: "Connected",
                        address: {
                            street: "5th Avenue",
                            number: "106th",
                            city: "Lake Valentine",
                            state: "Kansas",
                        },
                        button: {
                            number: 154869,
                        },
                        telephone_numbers: [
                            {
                                number: "+53 58091603",
                                type: "mobile",
                            },
                            {
                                number: "+22 6123456",
                                type: "normal",
                            },
                        ],
                    },
                    {
                        name: "Dr. Stefanie Gibson",
                        dni: 25896589658,
                        avatar: "http://127.0.0.1:8000/src/11.jpg",
                        state: "Connected",
                        address: {
                            street: "5th Avenue",
                            number: "106th",
                            city: "Lake Valentine",
                            state: "Kansas",
                        },
                        button: {
                            number: 154869,
                        },
                        telephone_numbers: [
                            {
                                number: "+53 58091603",
                                type: "mobile",
                            },
                            {
                                number: "+22 6123456",
                                type: "normal",
                            },
                        ],
                    },
                    {
                        name: "Dr. Stefanie Gibson",
                        dni: 25896589658,
                        avatar: "http://127.0.0.1:8000/src/12.jpg",
                        state: "Disconnected",
                        address: {
                            street: "5th Avenue",
                            number: "106th",
                            city: "Lake Valentine",
                            state: "Kansas",
                        },
                        button: {
                            number: 154869,
                        },
                        telephone_numbers: [
                            {
                                number: "+53 58091603",
                                type: "mobile",
                            },
                            {
                                number: "+22 6123456",
                                type: "normal",
                            },
                        ],
                    },
                    {
                        name: "Dr. Stefanie Gibson",
                        dni: 25896589658,
                        avatar: "http://127.0.0.1:8000/src/13.jpg",
                        state: "Disconnected",
                        address: {
                            street: "5th Avenue",
                            number: "106th",
                            city: "Lake Valentine",
                            state: "Kansas",
                        },
                        button: {
                            number: 154869,
                        },
                        telephone_numbers: [
                            {
                                number: "+53 58091603",
                                type: "mobile",
                            },
                            {
                                number: "+22 6123456",
                                type: "normal",
                            },
                        ],
                    },
                    {
                        name: "Dr. Stefanie Gibson",
                        dni: 25896589658,
                        avatar: "http://127.0.0.1:8000/src/14.jpg",
                        state: "Connected",
                        address: {
                            street: "5th Avenue",
                            number: "106th",
                            city: "Lake Valentine",
                            state: "Kansas",
                        },
                        button: {
                            number: 154869,
                        },
                        telephone_numbers: [
                            {
                                number: "+53 58091603",
                                type: "mobile",
                            },
                            {
                                number: "+22 6123456",
                                type: "normal",
                            },
                        ],
                    },
                    {
                        name: "Dr. Stefanie Gibson",
                        dni: 25896589658,
                        avatar: "http://127.0.0.1:8000/src/15.jpg",
                        state: "Disconnected",
                        address: {
                            street: "5th Avenue",
                            number: "106th",
                            city: "Lake Valentine",
                            state: "Kansas",
                        },
                        button: {
                            number: 154869,
                        },
                        telephone_numbers: [
                            {
                                number: "+53 58091603",
                                type: "mobile",
                            },
                            {
                                number: "+22 6123456",
                                type: "normal",
                            },
                        ],
                    },
                ],
            }
        },
    }
</script>
<template>
    <div class="bg-gray-100 p-2 m-4 rounded-xl">
        <div class="flex items-center text-xs">
            <div class="w-4/12 text-indigo-500 font-bold text-center">Cliente</div>
            <div class="w-3/12 text-indigo-500 font-bold text-center">Teléfonos</div>
            <div class="w-5/12 text-indigo-500 font-bold text-center">Dirección</div>
        </div>
        <div v-for="client in clients" class="group flex items-center my-2 rounded-lg shadow-sm bg-white p-2">
            <div class="w-4/12 flex items-center">
                <img :src="client.avatar" class="rounded-full w-8" />
                <div class="pl-2">
                    <h4 class="w-full text-ellipsis whitespace-nowrap overflow-hidden text-gray-500 font-bold">{{ client.name }}</h4>
                    <p class="text-gray-400"><i class="bi bi-person-vcard"></i> {{ client.dni }}</p>
                </div>
            </div>
            <div class="w-3/12">
                <p v-for="telephone in client.telephone_numbers">
                    <i class="bi" :class="{ 'bi-telephone': telephone.type == 'normal', 'bi-phone': telephone.type == 'mobile' }"></i>
                    {{ telephone.number }}
                </p>
            </div>
            <div class="w-5/12">
                <button class="transition-opacity float-right mt-2 rounded-full w-8 h-8 bg-indigo-500 shadow-lg text-white opacity-0 hover:!opacity-100 group-hover:!opacity-50"><i class="bi bi-chevron-down"></i></button>
                <p>{{ client.address.number }} {{ client.address.street }} {{ client.address.apartment }}. {{ client.address.city }}, {{client.address.state}}</p>
            </div>
        </div>
    </div>
</template>
