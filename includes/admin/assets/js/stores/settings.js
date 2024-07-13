/**
 * Store for handling the settings.
 *
 * This store manages the state and actions related to settings, including fetching and saving settings from/to a REST API.
 *
 * @package ytaha-admin-dashboard
 */

import { defineStore } from 'pinia';
import axios from "axios";

export const useSettingStore = defineStore("settings", {
    state: () => ({
        settings: [],
        errors: [],
        savedSucess: false,
        isLoading: false
    }),
    actions: {
        /**
         * Fetch settings from the REST API.
         */
        async fetchSettings() {
            try {
                this.isLoading = true;
                const data = await axios.get(admin_dashboard.settings_rest_url, {
                    headers: {
                        'content-type': 'application/json',
                        'X-WP-Nonce': admin_dashboard.nonce
                    }
                });
                this.isLoading = false;
                this.settings = data.data;
            } catch (error) {
                this.isLoading = false;
                this.errors = error?.response?.data?.data?.errors;
            }
        },

        /**
         * Save settings to the REST API.
         *
         * @param {Object} settings - The settings to save.
         */
        async saveSettings(settings) {
            try {
                const data = await axios.put(admin_dashboard.settings_rest_url, {
                    settings
                }, {
                    headers: {
                        'content-type': 'application/json',
                        'X-WP-Nonce': admin_dashboard.nonce
                    }
                });
                Object.keys(data.data).forEach((key) => {
                    this.settings[key] = data.data[key];
                });
                this.savedSucess = true;
                setTimeout(() => this.savedSucess = false, 5000);
            } catch (error) {
                this.errors = error?.response?.data?.data?.errors;
            }
        },

        /**
         * Clear all errors.
         */
        async clearErrors() {
            this.errors = [];
        },
    },
});
