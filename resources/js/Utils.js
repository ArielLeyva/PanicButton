import Alert from "./components/alert/Alert.js"
import AlertConfig from "./components/alert/AlertConfig.js"

export default class Utils {
    static FULL_DATE_TIME = {
        day: "2-digit",
        month: "numeric",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
        hour12: true,
    }

    static FULL_TIME = {
        hour: "2-digit",
        minute: "2-digit",
        hour12: true,
    }

    static datetime(datetime, format) {
        const date = new Date(datetime)
        return date.toLocaleDateString("es", format)
    }

    static elapsedtime(time) {
        const today = new Date()
        const date = new Date(time)
        const diff = today - date
        if (diff <= 3600000) {
            return `Hace ${Math.floor(diff / 60000)} minutos`
        } else if (diff <= 86400000) {
            return `Hace ${Math.floor(diff / 3600000)} horas`
        } else if (diff <= 604800000) {
            return `Hace ${Math.floor(diff / 86400000)} días`
        } else if (diff <= 2592000000) {
            return `Hace ${Math.floor(diff / 604800000)} semanas`
        } else {
            return date.toLocaleDateString("es", {
                day: "numeric",
                weekday: "short",
                month: "short",
                year: "numeric",
            })
        }
    }

    static notify(text) {
        const alert = new Alert(
            new AlertConfig({
                title: "¡Operación satisfactoria!",
                text: text,
                icon: "bi bi-check2-square",
                color: "#198754",
            })
        )
        alert.fire()
    }

    static splice(items, item) {
        for (let i in items) {
            if (items[i].id == item.id) {
                items.splice(i, 1)
                break
            }
        }
    }

    static filter(haystack, needle) {
        for (let key in haystack) {
            if (needle[key] !== undefined && needle[key] !== "") {
                switch (key) {
                    case "name":
                    case "dni":
                        if (haystack[key] == undefined || !haystack[key].toString().toLowerCase().includes(needle[key].toString().toLowerCase())) {
                            return false
                        }
                        break
                    case "state":
                    case "gender":
                        if (haystack[key] !== needle[key]) {
                            return false
                        }
                        break
                }
            }
        }
        return true
    }
}
