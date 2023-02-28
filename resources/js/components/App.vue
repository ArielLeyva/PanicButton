<script>
    import Navbar from "./navbar/Navbar.vue"

    import Clients from "./clients/Clients.vue"
    import ButtonsList from "./buttons/ButtonsList.vue"
    import Statistics from "./clients/Statistics.vue"
    export default {
        components: { Navbar, Clients, ButtonsList, Statistics },
    }
</script>

<template>
    <Navbar />
    <main class="flex bg-gradient-to-br from-indigo-100 via-transparent to-indigo-50 min-h-screen w-full p-5">
        <section class="md:w-1/4">
            <ButtonsList />
        </section>
        <section class="md:w-3/4">
            <div class="w-full pl-4">
                <div class="bg-white rounded-lg shadow-sm">
                    <Statistics />
                    <Clients />
                </div>
            </div>
        </section>
    </main>
</template>
