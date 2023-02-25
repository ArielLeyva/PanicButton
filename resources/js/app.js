import './bootstrap';
import '../css/app.css';
import { createApp } from "vue"
import App from "./components/App.vue"

const app = createApp(App)
app.config.unwrapInjectedRef = true
app.mount("#app")