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
                    :preselect-first="true"
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
                <pre class="language-json">
                    <code v-for="(item, index) in form.interests" :key="index">
                      {{ item.name }}
                    </code>
                </pre>
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
                { name: "Adonis" },
                { name: "Rails" },
                { name: "Sinatra" },
                { name: "Laravel" },
                { name: "Phoenix" },
            ],
            form: {
                name: "",
                email: "",
                password: "",
                password_confirmation: "",
                interests: [], 
            },
            errorMessage: "",
            successMessage: "",
        };
    },
    mounted() {
        // Set the CSRF token for Axios globally
        axios.defaults.headers.common["X-CSRF-TOKEN"] = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");
    },
    methods: {
        async register() {
            try {
                this.errorMessage = "";
                this.successMessage = "";

                // Make sure to send the form data to the correct endpoint
                const response = await axios.post("/api/register", this.form);

                this.successMessage = response.data.message;
                this.form = {
                    name: "",
                    email: "",
                    password: "",
                    password_confirmation: "",
                    interests: [], // Reset the interests field
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
</style>
