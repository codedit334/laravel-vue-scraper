import { createRouter, createWebHistory } from 'vue-router';
// import Home from '../views/Home.vue';
// import About from '../views/About.vue';
import Sportma from '../pages/Sportma.vue';

const routes = [
//   { path: '/', component: Home },
//   { path: '/about', component: About },
  { path: '/sportma', component: Sportma }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
