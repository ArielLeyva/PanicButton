if (localStorage.theme != "light" && (localStorage.theme === "dark" || (!("theme" in localStorage) && window.matchMedia("(prefers-color-scheme: dark)").matches))) {
    document.documentElement.classList.add("dark")
} else {
    document.documentElement.classList.remove("dark")
}

import "bootstrap/scss/bootstrap.scss"

import "bootstrap-icons/font/bootstrap-icons.css"
import "../css/app.css"
import { createApp } from "vue"
import mitt from "mitt"
import App from "./components/App.vue"
import Utils from "./Utils.js"

const app = createApp(App)
app.config.globalProperties.Utils = Utils
app.config.unwrapInjectedRef = true
/** Implementar bus de eventos */
const emitter = mitt()
app.config.globalProperties.emitter = emitter
app.mount("#app")
