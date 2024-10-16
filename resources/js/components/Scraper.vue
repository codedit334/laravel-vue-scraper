<template>
    <div>
        <div class="scraper animate__animated animate__fadeInDown">
            <div v-if="articles.length === 0 && !loading">
                No articles found.
            </div>
            <div v-if="loading">Loading...</div>
            <div v-else>
                <!-- Loop through each category group -->
                <div
                    v-for="(articles, category) in groupedArticles"
                    :key="category"
                    class="articles-section animate__animated animate__fadeInDown"
                >
                    <h2>{{ category !== "undefined" ? category : "Other" }}</h2>
                    <!-- Swiper Carousel -->
                    <swiper
                        :modules="modules"
                        :slides-per-view="3"
                        :space-between="30"
                        navigation
                        :pagination="{ clickable: true }"
                        @swiper="onSwiper"
                        @slideChange="onSlideChange"
                        class="articles-swiper"
                    >
                        <swiper-slide
                            v-for="(article, index) in articles"
                            :key="index"
                            class="swiper-slide"
                        >
                            <div class="article-card">
                                <a
                                    :href="article.link"
                                    target="_blank"
                                    class="article-link"
                                >
                                    <div class="article-image-wrapper">
                                        <img
                                            :src="article.image"
                                            :alt="article.title"
                                            class="article-image"
                                        />
                                    </div>
                                    <div class="article-content">
                                        <h2>{{ article.title.length > 35 ? article.title.slice(0, 35) + '...' : article.title }}</h2>
                                        <p>{{ article.body.length > 200 ? article.body.slice(0, 200) + '...' : article.body }}</p>
                                    </div>
                                </a>

                                <!-- Recommended Coaches Section -->
                                <div
                                    v-if="article.coaches.length > 0"
                                    class="coaches"
                                >
                                    <h3>Recommended Coaches:</h3>
                                    <div class="coaches-wrapper">
                                        <div
                                            v-for="(
                                                coach, coachIndex
                                            ) in article.coaches"
                                            :key="coachIndex"
                                            class="coach"
                                        >
                                            <img
                                                :src="coach.image"
                                                alt="Coach Image"
                                                class="coach-image"
                                            />
                                            <p>
                                                <b>{{ coach.work }} Coach:</b>
                                                {{ coach.name }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </swiper-slide>
                    </swiper>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Navigation, Pagination, A11y } from "swiper/modules";
import { Swiper, SwiperSlide } from "swiper/vue";

// Import Swiper styles
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";

export default {
    components: {
        Swiper,
        SwiperSlide,
    },
     setup() {
      const onSwiper = (swiper) => {
        console.log(swiper);
      };
      const onSlideChange = () => {
        console.log('slide change');
      };
      return {
        onSwiper,
        onSlideChange,
        modules: [Navigation, Pagination, A11y],
      };
    },
    data() {
        return {
            articles: [],
            groupedArticles: {},
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
                const response = await axios.post("/scrape");
                this.articles = response.data;
                this.groupArticlesByCategory();
            } catch (error) {
                console.error(error);
            } finally {
                this.loading = false;
            }
        },
        groupArticlesByCategory() {
            const grouped = this.articles.reduce((groups, article) => {
                const category = article.cat || "Other";
                if (!groups[category]) {
                    groups[category] = [];
                }
                groups[category].push(article);
                return groups;
            }, {});

            const { Other, ...rest } = grouped;
            this.groupedArticles = { ...rest, Other };
        },
    },
};
</script>

<style>
.scraper {
    padding: 20px;
    margin-top: 35px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.articles-swiper {
    width: 100%;
    max-width: 1050px;
    margin-top: 20px;
}

.article-card {
    background-color: #fff;
    border-radius: 15px;
    overflow: hidden;
    margin-bottom: 20px;
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 700px; /* Set a fixed height for long cards */
    max-height: 900px; /* Ensure a consistent max height */
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
    height: 250px; /* Increase height for long card image */
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
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.article-content h2 {
    font-size: 16px;
    margin: 0 0 10px;
    color: #333;
    font-family: "Roboto", sans-serif;
}

.article-content p {
    font-size: 16px;
    line-height: 1.6;
    color: #666;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 5; /* Limit text to 5 lines */
    -webkit-box-orient: vertical;
}

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

/*
.swiper-button-next {
    right: var(--swiper-navigation-sides-offset, -45px);
    left: auto;
}

.swiper-button-prev {
    left: var(--swiper-navigation-sides-offset, -45px);
    right: auto;
}
*/
</style>
