import { createRouter, createWebHistory } from 'vue-router';
import Login from '../views/auth/Login.vue';
import Sportma from '../pages/Sportma.vue';
import Reservation from '../pages/Reservation.vue';
import Register from '../views/auth/Register.vue';
import Scraper from '../components/Scraper.vue';

const routes = [
  { path: '/', component: Sportma },
  { path: '/login', component: Login },
  { path: '/register', name: 'register', component: Register },
  { path: '/sportma', component: Sportma },
  { path: '/news', component: Scraper },
  { path: '/reservation', component: Reservation }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
