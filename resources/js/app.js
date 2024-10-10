import './bootstrap';
import { createApp } from 'vue';
import App from './pages/App.vue'; // Adjust the import based on your component structure
// import Register from './views/auth/Register.vue';
import router from './router';

const app = createApp(App);

app.use(router);
app.mount('#app');