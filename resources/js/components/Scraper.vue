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
                        <!-- Recommended Coaches Section -->
                        <div v-if="article.coaches.length > 0" class="coaches">
                            <h3>Recommended Coaches:</h3>
                            <div class="coaches-wrapper">
                                <div v-for="(coach, coachIndex) in article.coaches" :key="coachIndex" class="coach">
                                    <img :src="coach.image" alt="Coach Image" class="coach-image" />
                                    <p>{{ coach.work }} : {{ coach.name }}</p>
                                </div>
                            </div>
                        </div>
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
            loading: false,
        };
    },
    methods: {
        async scrape() {
            this.loading = true;
            try {
                axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const response = await axios.post('/scrape');
                this.articles = response.data;
                console.log('Scraper data: ', this.articles);
            } catch (error) {
                console.error(error);
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>

<style scoped>
.scraper {
  padding: 20px;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.articles-wrapper {
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.article {
  margin: 20px;
  width: 40%;
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
}

.article-image {
  max-width: 100%;
  height: auto;
  display: block;
}

/* Recommended Coaches Section */
.coaches {
  margin-top: 15px;
  text-align: center;
}

.coaches-wrapper {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
}

.coach {
  margin: 5px;
  text-align: center;
}

.coach-image {
  width: 50px; /* Set width for coach image */
  height: 50px; /* Set height for coach image */
  border-radius: 50%; /* Make it rounded */
  object-fit: cover; /* Ensure image covers the circle */
}

/* Reset link styles */
.article-link {
  text-decoration: none;
  color: inherit;
  width: 100%;
}

/* Change cursor to pointer on hover */
.article-link:hover {
  cursor: pointer;
}
</style>
