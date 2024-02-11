import { defineStore } from 'pinia'
// Import axios to make HTTP requests
import axios from "axios"
export const useSettingStore = defineStore("settings", {
    state: () => ({
        settings: [],
        errors: [],
        savedSucess: false
    }),
    getters: {
        getSettings(state) {
            return state.settings
        },
        getErrors(state) {
            return state.errors
        }
    },
    actions: {
        async fetchSettings() {
            try {
                const data = await axios.get(vuejs_dev_challenge.settings_rest_url,
                    {
                        headers: {
                            'content-type': 'application/json',
                            'X-WP-Nonce': vuejs_dev_challenge.nonce
                        }
                    })
                this.settings = data.data;
            }
            catch (error) {
                this.errors = error?.response?.data?.data?.errors;
            }
        },
        async saveSettings(settings) {
            try {
                const data = await axios.put(vuejs_dev_challenge.settings_rest_url,
                    {
                        settings
                    },
                    {
                        headers: {
                            'content-type': 'application/json',
                            'X-WP-Nonce': vuejs_dev_challenge.nonce
                        }
                    })
                this.settings = data.data
                this.savedSucess = true;
                setTimeout(() => this.savedSucess = false, 5000)
            }
            catch (error) {
                this.errors = error?.response?.data?.data?.errors;
            }
        },
        async clearErrors() {
            this.errors = [];
        },
    },
})