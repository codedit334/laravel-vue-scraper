<template>
    <div>
        <div class="scraper animate__animated animate__fadeInDown">
            <div v-if="articles.length === 0 && !loading">No articles found.</div>
            <div v-if="loading">Loading...</div>
            <div v-else>
                <div class="articles-grid animate__animated animate__fadeInDown">
                    <div v-for="(article, index) in articles" :key="index" class="article-card">
                        <a :href="article.link" target="_blank" class="article-link">
                            <div class="article-image-wrapper">
                                <img :src="article.image" :alt="article.title" class="article-image" />
                            </div>
                            <div class="article-content">
                                <h2>{{ article.title }}</h2>
                                <p>{{ article.body }}</p>
                            </div>
                        </a>

                        <!-- Recommended Coaches Section -->
                        <div v-if="article.coaches.length > 0" class="coaches">
                            <h3>Recommended Coaches:</h3>
                            <div class="coaches-wrapper">
                                <div v-for="(coach, coachIndex) in article.coaches" :key="coachIndex" class="coach">
                                    <img :src="coach.image" alt="Coach Image" class="coach-image" />
                                    <p><b>{{ coach.work }} :</b> {{ coach.name }}</p>
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
    mounted() {
        this.scrape();
    },
    methods: {
        async scrape() {
            this.loading = true;
            try {
                axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const response = await axios.post('/scrape');
                this.articles = response.data;
                console.log(response.data);
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
    margin-top: 35px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

h1 {
    font-family: 'Roboto', sans-serif;
    font-size: 28px;
    margin-bottom: 20px;
}

button {
    padding: 10px 20px;
    font-size: 16px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-bottom: 20px;
}

button:hover {
    background-color: #0056b3;
}

.articles-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    width: 97%;
    max-width: 1200px;
    padding: 0 20px;
}

.article-card {
    background-color: #fff;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
    display: flex;
    flex-direction: column;
    justify-content: space-between; /* Ensure content is between header and bottom section */
}

.article-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15);
}

.article-link {
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}

.article-image-wrapper {
    overflow: hidden;
    height: 200px;
}

.article-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.article-card:hover .article-image {
    transform: scale(1.1);
}

.article-content {
    padding: 20px;
    flex-grow: 1; /* Makes the content fill the available space */
}

.article-content h2 {
    font-size: 20px;
    margin: 0 0 10px;
    color: #333;
    font-family: 'Roboto', sans-serif;
}

.article-content p {
    font-size: 16px;
    line-height: 1.6;
    color: #666;
}

/* Recommended Coaches Section */
.coaches {
    margin-top: 15px;
    padding: 0 20px;
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
    width: 50px; 
    height: 50px; 
    border-radius: 50%; 
    object-fit: cover; 
    margin-bottom: 5px;
}
</style>
