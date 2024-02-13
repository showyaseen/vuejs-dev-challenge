import { defineStore } from 'pinia'
// Import axios to make HTTP requests
import axios from "axios"
export const useDataStore = defineStore("data", {
    state: () => ({
        table: [],
        graph: [],
        errors: [],
        isLoading: false
    }),
    actions: {
        async fetchData() {
            try {
                this.isLoading = true;
                const data = await axios.get(vuejs_dev_challenge.data_rest_url,
                    {
                        headers: {
                            'content-type': 'application/json',
                            'X-WP-Nonce': vuejs_dev_challenge.nonce
                        }
                    })
                this.isLoading = false;
                this.table = Object.assign([], data?.data?.table);
                this.graph = Object.assign([], data.data?.graph);
            }
            catch (error) {
                this.isLoading = false;
                this.errors = error?.response?.data?.data?.errors;
            }
        },
    },
})