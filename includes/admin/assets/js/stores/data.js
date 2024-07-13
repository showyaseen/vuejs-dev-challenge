/**
 * Store for handling the data.
 *
 * This store manages the state and actions related to data fetching for tables and graphs from a REST API.
 *
 * @package ytaha-admin-dashboard
 */

import { defineStore } from 'pinia';
import axios from "axios";

export const useDataStore = defineStore("data", {
    state: () => ({
        table: [],
        graph: [],
        errors: [],
        isLoading: false
    }),
    actions: {
        /**
         * Fetch data for the table and graph from the REST API.
         */
        async fetchData() {
            try {
                this.isLoading = true;
                const data = await axios.get(admin_dashboard.data_rest_url, {
                    headers: {
                        'content-type': 'application/json',
                        'X-WP-Nonce': admin_dashboard.nonce
                    }
                });
                this.isLoading = false;
                this.table = Object.assign([], data?.data?.table);
                this.graph = Object.assign([], data.data?.graph);
            } catch (error) {
                this.isLoading = false;
                this.errors = error?.response?.data?.data?.errors;
            }
        },
    },
});
