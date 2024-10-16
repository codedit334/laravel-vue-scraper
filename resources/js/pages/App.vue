<template>
  <div id="app" class="animate__animated animate__fadeInDown">
    <Navbar/>
    <div style="min-height: 100vh;">
      <router-view></router-view> <!-- Vue Router View -->
    </div>
    <Footer/>
  </div>
</template>

<script>
import Navbar from '../components/Navbar.vue';
import Scraper from '../components/Scraper.vue';
import Sportma from './Sportma.vue';
import Footer from '../components/Footer.vue';

export default {
  name: 'App',
  components: {
    Navbar,
    Scraper,
    Sportma,
    Footer,
  },
};
</script>

<style scoped>
body {
  margin: 0;
  padding: 0;

}
#app {
  text-align: center;
}

h1 {
  color: #42b983;
}

p {
  font-size: 18px;
  color: #35495e;
}
</style>
