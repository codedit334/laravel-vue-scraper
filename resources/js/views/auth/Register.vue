<template>
    <div class="register-container">
        <h2>Register</h2>
        <form @submit.prevent="register">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" v-model="form.name" required />
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" v-model="form.email" required />
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <input
                    type="text"
                    id="address"
                    v-model="form.address"
                    required
                />
            </div>

            <div class="form-group">
                <label for="gender">Gender</label>
                <select
                    id="gender"
                    v-model="form.gender"
                    class="custom-select"
                    required
                >
                    <option value="" disabled selected>
                        Select your gender
                    </option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    v-model="form.password"
                    required
                />
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input
                    type="password"
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    required
                />
            </div>

            <div>
                <label class="typo__label">Interests</label>
                <multiselect
                    v-model="form.interests"
                    :options="options"
                    :multiple="true"
                    :close-on-select="false"
                    :clear-on-select="false"
                    :preserve-search="true"
                    placeholder="Pick some interests"
                    label="name"
                    track-by="name"
                    id="interests"
                >
                    <template #selection="{ values, search, isOpen }">
                        <span
                            class="multiselect__single"
                            v-if="values.length"
                            v-show="!isOpen"
                            >{{ values.length }} interests selected</span
                        >
                    </template>
                </multiselect>
                <div class="tags-container">
                    <span
                        v-for="(item, index) in form.interests"
                        :key="index"
                        class="tag"
                    >
                        {{ item.name }}
                    </span>
                </div>
            </div>

            <button type="submit" class="button">Register</button>

            <div v-if="errorMessage" class="error">{{ errorMessage }}</div>
            <div v-if="successMessage" class="success">
                {{ successMessage }}
            </div>
        </form>
    </div>

    <div
        style="margin-top: 200px; margin-bottom: 200px; align-items: center"
    ></div>
</template>

<script>
import axios from "axios";
import Multiselect from "vue-multiselect";

export default {
    name: "Register",
    components: { Multiselect },
    data() {
        return {
            options: [
                { name: "Football" },
                { name: "Basketball" },
                { name: "Fitness" },
                { name: "Cycling" },
                { name: "Tennis" },
                { name: "Boxing" },
            ],
            form: {
                name: "",
                email: "",
                gender: "",
                address: "",
                password: "",
                password_confirmation: "",
                interests: [],
            },
            errorMessage: "",
            successMessage: "",
        };
    },
    methods: {
        async register() {
            try {
                this.errorMessage = "";
                this.successMessage = "";

                // Make sure to send the form data to the correct endpoint
                const response = await axios.post("/api/register", this.form);

                this.successMessage = response.data.message;

                // Dispatch login action
                this.$store.dispatch("login", {
                    user: response.data.user,
                    token: response.data.token,
                });
                
                // Redirect to the home page
                this.$router.push('/');
                this.form = {
                    name: "",
                    email: "",
                    gender: "",
                    password: "",
                    password_confirmation: "",
                    interests: [],
                };
            } catch (error) {
                if (error.response && error.response.data.errors) {
                    this.errorMessage = Object.values(
                        error.response.data.errors
                    )
                        .flat()
                        .join(" ");
                } else {
                    this.errorMessage = "An error occurred. Please try again.";
                }
            }
        },
    },
};
</script>

<style scoped>
.multiselect {
    width: 100%;
    max-width: 400px;
    margin: 20px 0;
}
.register-container {
    max-width: 400px;
    margin: auto;
    margin-top: 50px;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color: #fff;
}

h2 {
    text-align: center;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
}

input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.button {
    width: 100%;
    background-color: #007bff;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.button:hover {
    background-color: #0056b3;
}

.error {
    color: red;
    margin-top: 10px;
}

.success {
    color: green;
    margin-top: 10px;
}
.tags-container {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 33px;
}

.tag {
    background-color: #007bff; /* Blue background */
    color: #fff; /* White text */
    padding: 2px 8px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    font-size: 12.5px;
}
.custom-select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
}

.custom-select:focus {
    border-color: #007bff; /* Blue border on focus */
    outline: none; /* Remove outline */
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Blue shadow on focus */
}
</style>
