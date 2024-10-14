<template>
    <div class="sportma-page">
        <h1>Sportma Activities</h1>
        <div class="cards-container">
            <!-- Loop through the activities array and display a card for each activity -->
            <card-component
                v-for="(activity, index) in activities"
                :key="index"
                :image-src="activity.imageSrc"
                :title="activity.title"
                :address="activity.address"
                :price="activity.price"
            />
        </div>
    </div>
</template>

<script>
import SportmaCard from "../components/SportmaCard.vue"; // Import the Card component

export default {
    components: {
        CardComponent: SportmaCard, // Register the Card component
    },
    data() {
        return {
            // An array of activities with data for the cards
            activities: [],
            loading: true,
            error: null,
        };
    },
    mounted() {
        this.fetchActivities();
    },
    methods: {
        async fetchActivities() {
            try {
                const response = await axios.get("/api/activities"); // Adjust this URL to your API endpoint
                
                this.activities = response.data.activities;
            } catch (err) {
                this.error =
                    "Failed to load activities. Please try again later.";
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>

<style scoped>
.sportma-page {
    padding: 20px;
}
.sportma-page h1 {
    font-family: "Roboto", sans-serif;
}
.cards-container {
    display: flex;
    flex-wrap: wrap; /* Allows wrapping to the next line */
    gap: 20px; /* Space between cards */
    justify-content: space-between; /* Aligns cards to the start */
}

.card {
    flex: 0 1 350px; /* Prevents the card from growing, keeps a base width of 300px */
    max-width: 350px; /* Ensures cards do not grow beyond this width */
    box-sizing: border-box; /* Include padding and border in the element's total width and height */
}
</style>
