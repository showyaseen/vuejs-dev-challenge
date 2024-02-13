import { defineStore } from 'pinia'
// Import axios to make HTTP requests
import axios from "axios"
export const useSettingStore = defineStore("settings", {
    state: () => ({
        settings: [],
        errors: [],
        savedSucess: false,
        isLoading: false
    }),
    actions: {
        async fetchSettings() {
            try {
                this.isLoading = true;
                const data = await axios.get(vuejs_dev_challenge.settings_rest_url,
                    {
                        headers: {
                            'content-type': 'application/json',
                            'X-WP-Nonce': vuejs_dev_challenge.nonce
                        }
                    })
                this.isLoading = false;
                this.settings = data.data;
            }
            catch (error) {
                this.isLoading = false;
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
                Object.keys(data.data).forEach((key) => {
                    this.settings[key] = data.data[key];
                });
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