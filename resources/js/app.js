import './bootstrap';
import { createApp } from 'vue';
import App from './components/App.vue'; // Adjust the import based on your component structure

const app = createApp(App);
app.mount('#app');