import { createRouter, createWebHistory } from 'vue-router';
// import Home from '../views/Home.vue';
// import About from '../views/About.vue';
import Sportma from '../pages/Sportma.vue';
import Register from '../views/auth/Register.vue';

const routes = [
//   { path: '/', component: Home },
  { path: '/register', component: Register },
  { path: '/sportma', component: Sportma }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
