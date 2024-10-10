<template>
  <div>
    <h1>Scraped Activities</h1>
    <div v-html="scrapedContent"></div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      scrapedContent: ''
    };
  },
  mounted() {
    this.fetchScrapedData();
    console.log(this.scrapedContent)
  },
  methods: {
    fetchScrapedData() {
      axios.get('/scrape-activities')
        .then(response => {
          this.scrapedContent = response.data.original.content;
          console.log('Scraped content:', this.scrapedContent)
          console.log('Scraped data:', response.data);
        })
        .catch(error => {
          console.error('Error fetching scraped data:', error);
        });
    }
  }
};
</script>
