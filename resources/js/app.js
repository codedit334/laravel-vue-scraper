import './bootstrap';
import { createApp } from 'vue';
import App from './pages/App.vue'; // Adjust the import based on your component structure
import router from './router';

const app = createApp(App);

app.use(router);
app.mount('#app');