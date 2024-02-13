import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import { createPinia } from 'pinia'
const { __ } = wp.i18n;
const appContainer = document.getElementById(vuejs_dev_challenge.app_container);

// Conditionally load the app based on JavaScript availability.
if (appContainer) {
    // Create a Vue 3 app instance
    const app = createApp(App);

    // Use the router
    app.use(router);

    // Use the Pinia store management
    app.use(createPinia())

    // provide text_domain for other components
    app.provide('textDomain', vuejs_dev_challenge.text_domain);

    // Mount the app to the #vuejs-dev-challenge-render element
    app.mount('#vuejs-dev-challenge-render');
}
