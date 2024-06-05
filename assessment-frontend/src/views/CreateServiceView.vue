<template>
    <div class="create-service-page">
        <h1>Create Service</h1>
        <form @submit.prevent="createService">
            <div class="form-group">
                <label for="company">Company</label>
                <select id="company" v-model="company_id" required class="form-control">
                    <option v-for="company in companies" :key="company.id" :value="company.id">
                        {{ company.name }}
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label for="name">Service Name</label>
                <input type="text" id="name" v-model="name" required class="form-control" />
            </div>
            <div v-if="error" class="error-message">
                {{ error }}
            </div>
            <button type="submit" class="btn btn-primary">Create Service</button>
        </form>
    </div>
</template>

<script>
import axios from '../axiosConfig';

export default {
    data() {
        return {
            company_id: null,
            name: '',
            companies: [],
            error: null,
        };
    },
    mounted() {
        axios.get('/companies').then(response => {
            this.companies = response.data.data;
        });
    },
    methods: {
        async createService() {
            try {
                await axios.post('/services', {
                    company_id: this.company_id,
                    name: this.name,
                });
                this.$router.push('/list-companies');
            } catch (error) {
                if (error.response) {
                    this.error = error.response.data.message || 'Failed to create service';
                } else {
                    this.error = 'Failed to create service';
                }
            }
        },
    },
};
</script>

<style scoped>
.create-service-page {
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