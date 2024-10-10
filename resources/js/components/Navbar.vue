<template>
  <nav class="navbar">
    <div class="navbar-container">
      <div class="logo">
        <h1>Sportma Remastered</h1>
      </div>
      <div class="nav-wrapper" style="display: flex; align-items: center; gap: 60px ">
      <div class="nav-links">
        <router-link to="/sportma">Sportma</router-link>
        <router-link to="/scrape">News</router-link>
      </div>
      <div class="nav-buttons">
        <router-link to="/login" class="button">Login</router-link>
        <router-link to="/register" class="button">Register</router-link>
      </div>

      </div>
    </div>
  </nav>
</template>

<script>
export default {
  name: 'Navbar'
}
</script>

<style scoped>
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

.logo h1 {
  margin: 0;
  font-size: 24px;
  font-family: Arial, sans-serif;
}

.nav-buttons {
  display: flex;
  gap: 10px;
}

.nav-links {
  display: flex;
  gap: 20px;
  color: white; /* White text */
  text-decoration: none; /* Removes underline */

}

.nav-links a {
  color: #FF8200;/* White text */
  text-decoration: none; /* Removes underline */
  font-family: Arial, sans-serif;
  font-weight: bold;
  font-size: 14px;
}

.nav-links a:hover {
  color: orange  !important;/* White text */
  text-decoration: underline; /* Underlines when hovered */
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
