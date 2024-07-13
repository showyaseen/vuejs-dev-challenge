/**
 * This is the main entry file for the Vue.js application.
 *
 * It creates the Vue app, sets up the router and state management, and mounts the app to the DOM.
 *
 * @package YTAHA\AdminDashboard
 */

import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import { createPinia } from 'pinia';
const { __ } = wp.i18n;
const appContainer = document.getElementById(admin_dashboard.app_container);

// Conditionally load the app based on JavaScript availability.
if (appContainer) {
    // Create a Vue 3 app instance
    const app = createApp(App);

    // Use the router
    app.use(router);

    // Use the Pinia store management
    app.use(createPinia());

    // Mount the app to the #admin-dashboard-render element
    app.mount(appContainer);
}
