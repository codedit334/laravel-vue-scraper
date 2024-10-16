<template>
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-links">
                <router-link to="/">Home</router-link>
                <router-link to="/sportma">Sportma</router-link>
                <router-link to="/news">News</router-link>
            </div>
            <div class="footer-info">
                <p>&copy; {{ currentYear }} Sportma. All rights reserved.</p>
            </div>
        </div>
    </footer>
</template>

<script>
export default {
    name: "Footer",
    computed: {
        currentYear() {
            return new Date().getFullYear();
        },
    },
};
</script>

<style scoped>
.footer {
    background-color: #007bff; /* Match the navbar color */
    color: white; /* White text */
    padding: 20px 0;
    width: 100%;
}

.footer-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 0 30px;
}

.footer-links {
    display: flex;
    gap: 20px;
    font-family: Arial, sans-serif;
    font-size: 16px;
}

.footer-links a {
    text-decoration: none;
    color: white;
}

.footer-links a:hover {
    color: #f1f1f1; /* Lighter shade on hover */
}

.footer-info {
    font-family: Arial, sans-serif;
    font-size: 14px;
}
</style>
