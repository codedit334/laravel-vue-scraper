import './bootstrap';
import 'animate.css';
import { createApp } from 'vue';
import App from './pages/App.vue'; // Adjust the import based on your component structure
// import Register from './views/auth/Register.vue';
import router from './router';
import axios from 'axios';
import store from './store';


axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`;

const app = createApp(App);

store.dispatch('tryAutoLogin');

app.use(store);
app.use(router);
app.mount('#app');