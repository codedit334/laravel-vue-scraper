<template>
    <div>
        <h1>Web Scraper</h1>
        <input v-model="url" placeholder="Enter URL" />
        <button @click="scrape">Scrape</button>
        <div v-if="titles.length">
            <h2>Titles:</h2>
            <ul>
                <li v-for="(title, index) in titles" :key="index">{{ title }}</li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            url: '',
            titles: [],
        };
    },
    methods: {
        async scrape() {
            try {
                const response = await axios.post('/api/scrape', { url: this.url });
                this.titles = response.data;
            } catch (error) {
                console.error(error);
            }
        },
    },
};
</script>
