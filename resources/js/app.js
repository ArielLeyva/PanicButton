if (localStorage.theme != "light" && (localStorage.theme === "dark" || (!("theme" in localStorage) && window.matchMedia("(prefers-color-scheme: dark)").matches))) {
    document.documentElement.classList.add("dark")
} else {
    document.documentElement.classList.remove("dark")
}

import "./bootstrap"
import "bootstrap/scss/bootstrap.scss"

import "bootstrap-icons/font/bootstrap-icons.css"
import "../css/app.css"
import { createApp } from "vue"
import App from "./components/App.vue"

const app = createApp(App)
app.config.unwrapInjectedRef = true
app.mount("#app")
