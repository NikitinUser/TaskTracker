/**
 * LocalStorage wrappers
 */

export default {
    getItem(key, defaultValue = null) {
        let value = JSON.parse(localStorage.getItem(key))
        if (!value) {
            return defaultValue
        }

        return value
    },

    setItem(key, value) {
        localStorage.setItem(key, JSON.stringify(value))
    },

    removeItem(key) {
        localStorage.removeItem(key)
    }
}
