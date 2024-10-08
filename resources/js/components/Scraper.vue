<template>
    <div>
        <h1>Web Scraper</h1>
        <button @click="scrape">News</button>
        
         <div class="scraper">
    <h1>News Articles</h1>
    <div v-if="articles.length === 0 && !loading">No articles found.</div>
    <div v-if="loading">Loading...</div>
    <div v-else>
     <div class="articles-wrapper">
      <div v-for="(article, index) in articles" :key="index" class="article">
        <a :href="article.link" target="_blank" class="article-link">
            <h2>{{ article.title }}</h2>
            <img :src="article.image" :alt="article.title" class="article-image" />
            <p>{{ article.body }}</p>
        </a>
      </div>
     </div>
    </div>
  </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            url: '',
            titles: [],
            articles: [],
            loading: false, // This will indicate loading state

        };
    },
    methods: {

        async scrape() {
            this.loading = true; // Set loading to true
            try {
                axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const response = await axios.post('/scrape');
                this.articles = response.data;
                console.log('Scraper data: ', this.articles);
                
            } catch (error) {
                console.error(error);
            } finally {
                this.loading = false; // Set loading to false after fetching
            }
        },
    },
};
</script>

<style scoped>
.scraper {
  padding: 20px;
  display: flex;
  flex-direction: column; /* Stack items vertically */
  align-items: center; /* Center items horizontally */
  justify-content: center; /* Center items vertically if needed */
}

.articles-container {
  display: flex;
  flex-direction: row; /* Align articles in a row */
  flex-wrap: wrap; /* Allow wrapping of articles */
  justify-content: center; /* Center articles in the container */
  width: 100%; /* Full width of the container */
}

.article {
  margin: 20px; /* Margin around each article */
  width: 40%; /* Set width to 40% */
  display: flex; /* Use flexbox for centering */
  flex-direction: column; /* Stack title, image, and body vertically */
  align-items: center; /* Center content horizontally */
  text-align: center; /* Center text */
}

.articles-wrapper {
    width: 100%; 
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.article-title {
  margin: 0 0 10px; /* Add margin below title */
}

.article-image {
  max-width: 100%; /* Make image responsive */
  height: auto;
  display: block; /* Ensure image takes full width */
}

/* Reset link styles */
.article-link {
  text-decoration: none; /* Remove underline */
  color: inherit; /* Use the same color as surrounding text */
  width: 100%; /* Make link take full width */
}

/* Change cursor to pointer on hover */
.article-link:hover {
  cursor: pointer; /* Show pointer cursor on hover */
}
</style>


