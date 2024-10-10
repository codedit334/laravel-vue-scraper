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
            activities: [
                {
                    imageSrc:
                        "https://brandingo.net/storage/images/FLUlmnMHkeFtXjDZAVuFMd82O9BxiNKrcGEo4D0L.jpg",
                    title: "Allo Bike: Cours d'apprentissage",
                    price: "200DH",
                },
                {
                    imageSrc:
                        "https://brandingo.net/storage/images/8r2X6MuJk2hcB73TA1Y8fLxN2ZTnQljig8VBW5UH.jpg",
                    title: "Bolt Fitness",
                    price: "50.00 DH",
                },
                {
                    imageSrc:
                        "https://brandingo.net/storage/images/0I513iWxjeeTrq0sxZxo8uYxjA27wLkamCPb1rRk.jpg",
                    title: "K Boxing Club",
                    price: "25.00 DH",
                },
                 {
                    imageSrc:
                        "https://brandingo.net/storage/images/B8y0CCIPRtumfQyoIhyCcF81hgBdsf60tRXP6Ycs.jpg",
                    title: "WeFoot Terrain 5vs5 ( T4 )",
                    price: "300.00 DH",
                },
            ],
        };
    },
};
</script>

<style scoped>
.sportma-page {
    padding: 20px;
}

.cards-container {
    display: flex;
    flex-wrap: wrap;  /* Allows wrapping to the next line */
    gap: 20px;        /* Space between cards */
    justify-content: space-between;  /* Aligns cards to the start */
}

.card {
    flex: 0 1 350px;  /* Prevents the card from growing, keeps a base width of 300px */
    max-width: 350px; /* Ensures cards do not grow beyond this width */
    box-sizing: border-box; /* Include padding and border in the element's total width and height */
}
</style>
