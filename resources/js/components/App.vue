<template>
  <div id="app">
    <h1>Welcome to Your Vue 3 App!</h1>
    <p>This is a simple example of an App.vue component.</p>
    <Scraper /> <!-- Include your Scraper component here -->
    
  </div>
</template>

<script>
import Scraper from './Scraper.vue';

export default {
  name: 'App',
  components: {
    Scraper
    // Register your components here if needed
  },
};
</script>

<style scoped>
#app {
  text-align: center;
  margin-top: 50px;
}

h1 {
  color: #42b983;
}

p {
  font-size: 18px;
  color: #35495e;
}
</style>
