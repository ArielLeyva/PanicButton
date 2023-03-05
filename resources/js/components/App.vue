<script>
    import Navbar from "./navbar/Navbar.vue"

    import Clients from "./clients/Clients.vue"
    import ButtonsList from "./buttons/ButtonsList.vue"
    import Statistics from "./clients/Statistics.vue"
    import AlertsList from "./alerts/AlertsList.vue"
    export default {
        components: { Navbar, Clients, ButtonsList, Statistics, AlertsList },
        data() {
            return {
                clients: [],
                buttons: {},
            }
        },
    }
</script>

<template>
    <Navbar />
    <main class="block md:flex bg-gradient-to-br from-indigo-100 to-fuchsia-100 w-full p-3">
        <section class="md:w-1/3 lg:w-1/4 main scroll">
            <ButtonsList @load="(data) => (buttons = data)" :clients="clients" />
        </section>
        <section class="md:w-2/3 lg:w-3/4 main scroll mt-5 md:mt-0">
            <div class="w-full pl-4">
                <div class="bg-white rounded-lg shadow-sm pb-1">
                    <div class="flex md:block lg:flex">
                        <Statistics :buttons="buttons" />
                        <AlertsList />
                    </div>
                    <Clients @load="(data) => (clients = data)" />
                </div>
            </div>
        </section>
    </main>
</template>
<style>
    .main {
        max-height: calc(100vh - 5.5rem);
        overflow: auto;
    }
</style>
