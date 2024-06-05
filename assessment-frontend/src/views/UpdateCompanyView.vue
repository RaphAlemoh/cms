<template>
    <div class="update-company-page">
        <h1>Update Company</h1>
        <form @submit.prevent="updateCompany">
            <div class="form-group">
                <label for="name">Company Name</label>
                <input type="text" id="name" v-model="company.name" required class="form-control" />
            </div>
            <div class="form-group">
                <label for="email">Company Email</label>
                <input type="email" id="email" v-model="company.email" required class="form-control" />
            </div>
            <div class="form-group">
                <label for="country">Country</label>
                <select id="country" v-model="company.country_id" required class="form-control">
                    <option v-for="country in countries" :key="country.id" :value="country.id">
                        {{ country.name }}
                    </option>
                </select>
            </div>
            <div v-if="error" class="error-message">
                {{ error }}
            </div>
            <button type="submit" class="btn btn-primary">Update Company</button>
            <button @click="deleteCompany" type="button" class="btn btn-danger">Delete Company</button>
        </form>
    </div>
</template>

<script>
import axios from '../axiosConfig';

export default {
    data() {
        return {
            company: {
                name: '',
                email: '',
                country_id: null,
            },
            countries: [],
            error: null,
        };
    },
    mounted() {
        this.fetchCompany();
        this.fetchCountries();
    },
    methods: {
        async fetchCompany() {
            try {
                const response = await axios.get(`/companies/${this.$route.params.id}`);
                this.company = response.data;
            } catch (error) {
                console.error('Error fetching company:', error);
            }
        },
        async fetchCountries() {
            try {
                const response = await axios.get('/countries');
                this.countries = response.data.data;
            } catch (error) {
                console.error('Error fetching countries:', error);
            }
        },
        async updateCompany() {
            try {
                await axios.put(`/companies/${this.$route.params.id}`);
                this.$router.push('/dashboard');
            } catch (error) {
                if (error.response) {
                    this.error = error.response.data.error || 'Failed to update company';
                } else {
                    this.error = 'Failed to update company';
                }
            }
        },
        async deleteCompany() {
            try {
                await axios.delete(`/companies/${this.$route.params.id}`);
                this.$router.push('/dashboard');
            } catch (error) {
                if (error.response) {
                    this.error = error.response.data.error || 'Failed to delete company';
                } else {
                    this.error = 'Failed to delete company';
                }
            }
        },
    },
};
</script>

<style scoped>
.update-company-page {
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