<template>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="logo">
                <img :src="logoSrc" alt="Sportma Logo" />
            </div>
            <div
                class="nav-wrapper"
                style="display: flex; align-items: center; gap: 60px"
            >
                <div class="nav-links">
                    <router-link to="/sportma">Sportma</router-link>
                    <router-link to="/scrape">News</router-link>
                </div>
                <div class="nav-buttons">
                    <template v-if="isLoggedIn">
                        <span class="user-name">Welcome, {{ userName }}</span>
                        <button @click="logout" class="button">Logout</button>
                    </template>
                    <template v-else>
                        <router-link to="/login" class="button"
                            >Login</router-link
                        >
                        <router-link to="/register" class="button"
                            >Register</router-link
                        >
                    </template>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
import { mapState } from "vuex";

export default {
    name: "Navbar",
    data() {
    return {
      logoSrc: '/images/sportma-orange.png' // Adjust the path as needed
    };
  },
    computed: {
        ...mapState({
            userName: (state) => (state.user ? state.user.name : ""),
            isLoggedIn: (state) => !!state.user,
        }),
    },
    methods: {
        logout() {
            // Call your Vuex action to log out the user
            this.$store.dispatch("logout");
            // Optionally, redirect to the home page after logout
            this.$router.push("/");
        },
    },
};
</script>

<style scoped>
.logo {
  display: flex;
  align-items: center;
}

.logo img {
  width: 150px; /* Adjust the size as needed */
  margin-left: 20px; /* Space between logo and text */
}
.navbar {
    background-color: #007bff; /* Blue background */
    color: white; /* White text */
    padding: 10px 20px;
}

.navbar-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.nav-links {
    display: flex;
    gap: 20px;
    font-family: Arial, sans-serif;
    font-size: 16px;
}

.nav-links a {
    text-decoration: none;
    color: white;
}

.nav-links a:hover {
    color: #f1f1f1;
}

.logo h1 {
    margin: 0;
    font-size: 24px;
    font-family: Arial, sans-serif;
}

.nav-buttons {
    display: flex;
    align-items: center; /* Center align items vertically */
    gap: 10px;
}

.user-name {
    font-family: Arial, sans-serif;
    color: white; /* White text for username */
    font-weight: bold;
}

.button {
    background-color: #fff; /* White button */
    color: #007bff; /* Blue text */
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    text-decoration: none; /* Removes underline */
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s;
}

.button:hover {
    background-color: #f1f1f1; /* Light gray on hover */
}
</style>
