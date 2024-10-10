<template>
  <div id="app">
    <Navbar />
    <Sportma />
    <Scraper />
  </div>
</template>

<script>
import Navbar from '../components/Navbar.vue';
import Scraper from '../components/Scraper.vue';
import Sportma from './Sportma.vue';

export default {
  name: 'App',
  components: {
    Navbar,
    Scraper,
    Sportma
    // Register your components here if needed
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
