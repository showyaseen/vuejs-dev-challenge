import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import { createPinia } from 'pinia'

// Create a Vue 3 app instance
const app = createApp(App);

// Use the router
app.use(router);

// Use the Pinia store management
app.use(createPinia())

// Mount the app to the #vuejs-dev-challenge-render element
app.mount('#vuejs-dev-challenge-render');
