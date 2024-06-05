<script>
import axios from '../axiosConfig';

export default {
    data() {
        return {
            name: '',
            email: '',
            country_id: null,
            countries: [],
            error: null,
        };
    },
    mounted() {
        axios.get('/countries').then(response => {
            this.countries = response.data.data;
        });

    },
    methods: {
        async createCompany() {
            try {
                await axios.post('/companies', {
                    name: this.name,
                    email: this.email,
                    country_id: this.country_id,
                });
                this.$router.push('/list-companies');
            } catch (error) {
                if (error.response) {
                    this.error = error.response.data.message || 'Failed to create company';
                } else {
                    this.error = 'Failed to create company';
                }
            }
        },
    },
};
</script>
<style scoped>
.create-company-page {
    max-width: 600px;
    margin: 50px auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.form-group {
    margin-bottom: 15px;
}

.error-message {
    color: red;
    margin-bottom: 15px;
}
</style>
<template>
    <div class="create-company-page">
        <h1>Create Company</h1>
        <form @submit.prevent="createCompany">
            <div class="form-group">
                <label for="name">Company Name</label>
                <input type="text" id="name" v-model="name" required class="form-control" />
            </div>
            <div class="form-group">
                <label for="email">Company Email</label>
                <input type="email" id="email" v-model="email" required class="form-control" />
            </div>
            <div class="form-group">
                <label for="country">Country</label>
                <select id="country" v-model="country_id" required class="form-control">
                    <option v-for="country in countries" :key="country.id" :value="country.id">
                        {{ country.name }}
                    </option>
                </select>
            </div>
            <div v-if="error" class="error-message">
                {{ error }}
            </div>
            <button type="submit" class="btn btn-primary">Create Company</button>
        </form>
    </div>
</template>
