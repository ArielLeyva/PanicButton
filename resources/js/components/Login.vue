<template>
    <main class="w-screen h-screen flex items-center justify-center">
        <div>
            <h1 class="text-3xl text-white mb-5 text-center">Iniciar sesión</h1>
            <form autocomplete="off" class="w-72">
                <div class="bg-white bg-opacity-40 p-3 rounded-md">
                    <i class="bi bi-envelope text-white mr-2"></i>
                    <input class="bg-transparent appearance-none text-white placeholder-white focus-visible:outline-none focus:outline-none" name="email" placeholder="Correo electrónico" type="email" />
                </div>
                <div class="bg-white bg-opacity-40 p-3 rounded-md mt-4">
                    <i class="bi bi-key text-white mr-2"></i>
                    <input class="fill-transparent bg-transparent appearance-none text-white placeholder-white focus-visible:outline-none focus:outline-none" name="password" placeholder="Contraseña" type="password" />
                </div>
                <div class="mt-4">
                    <input type="checkbox" name="remember" class="mr-2" />
                    <label class="text-white">Recordar credenciales</label>
                </div>
                <p class="text-center mt-10">
                    <button type="submit" class="bg-white bg-opacity-40 py-2 rounded-full text-white px-10">Iniciar sesión</button>
                </p>
                <p class="text-center mt-5">
                    <a class="text-white text-center underline" href="#">He olvidado mi contraseña</a>
                </p>
            </form>
        </div>
    </main>
</template>

<style scoped>
    main {
        background-image: url(../../img/login_background.svg);
        background-position: center;
        background-size: cover;
    }
    input:-internal-autofill-selected {
        background-color: transparent !important;
        color: white;
    }
    input:-webkit-autofill,
    input:-webkit-autofill:hover,
    input:-webkit-autofill:focus {
        -webkit-box-shadow: 0 0 0px 1000px transparent inset;
        background-color: transparent !important;
    }
    input:-webkit-autofill {
        -webkit-text-fill-color: #000;
    }
</style>
