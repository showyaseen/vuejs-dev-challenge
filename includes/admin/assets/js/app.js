import { createApp } from 'vue';
import App from './App.vue';
import router from './router'; // Assuming you have a router.js file

// Create a Vue 3 app instance
const app = createApp(App);

// Use the router
app.use(router);

// Mount the app to the #app element in your HTML
app.mount('#vuejs-dev-challenge-render');
