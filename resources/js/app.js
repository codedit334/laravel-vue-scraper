import './bootstrap';
import Vue from 'vue';
import Scraper from './components/Scraper.vue';

const app = new Vue({
    el: '#app',
    components: {
        Scraper,
    },
});