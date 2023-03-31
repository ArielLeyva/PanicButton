/**
 * Manejas las entradas del formulario del formulario del modal
 */
export default class ModalInput {
    /**
     * @param {String} type Tipo de entrada
     * @param {String} label Texto de la entrada
     * @param {String} name Valor de la etiqueta "name" de la entrada, se utiliza para obtener luego el valor de la entrada en el FormData que resuelve la Promesa del modal
     * @param {String} icon Nombre de clase a aplicar al ícono de la entrada
     * @param {String} value Valor inicial de la entrada
     * @param {boolean} checked Valor inicial del atributo "checked" de la entrada si es de tipo checked o radio
     *
     */
    constructor({ type = "text", label = "", icon = "", name = "input", value = "", checked }) {
        this.type = type
        this.label = label
        this.icon = icon
        this.name = name
        this.value = value
        this.checked = checked
    }
}
