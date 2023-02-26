import './bootstrap';
import "bootstrap-icons/font/bootstrap-icons.css";
// import "bootstrap/scss/bootstrap.scss";
import '../css/app.css';
import { createApp } from "vue"
import Login from "./components/Login.vue"

const app = createApp(Login)
app.config.unwrapInjectedRef = true
app.mount("#app")