import { defineStore } from 'pinia'
// Import axios to make HTTP requests
import axios from "axios"
export const useSettingStore = defineStore("setting", {
    state: () => ({
        settings: [],
    }),
    getters: {
        getSettings(state) {
            return state.settings
        }
    },
    actions: {
        async fetchSettings() {
            try {
                const data = await axios.get('https://jsonplaceholder.typicode.com/settings')
                this.settings = data.data
            }
            catch (error) {
                console.log(error)
            }
        }
    },
})