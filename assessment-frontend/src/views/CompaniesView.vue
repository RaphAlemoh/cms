<template>
    <div class="list-companies-page">
        <h1>My Companies</h1>
        <ul>
            <li v-for="company in companies" :key="company.id">
                <span>{{ company.name }}</span>
                <button @click="editCompany(company)" class="btn btn-primary">Edit</button>
                <button @click="deleteCompany(company.id)" class="btn btn-danger">Delete</button>
            </li>
        </ul>
    </div>
</template>

<script>
import axios from '../axiosConfig';

export default {
    data() {
        return {
            companies: [],
        };
    },
    mounted() {
        this.fetchCompanies();
    },
    methods: {
        async fetchCompanies() {
            try {
                const response = await axios.get('/companies');
                this.companies = response.data.data;
            } catch (error) {
                console.error('Error fetching companies:', error);
            }
        },
        editCompany(company) {
            this.$router.push(`/update-company/${company.id}`);
        },
        async deleteCompany(companyId) {
            try {
                await axios.delete(`/companies/${companyId}`);
                this.companies = this.companies.filter(company => company.id !== companyId);
            } catch (error) {
                console.error('Error deleting company:', error);
            }
        },
    },
};
</script>

<style scoped>
.list-companies-page {
    max-width: 600px;
    margin: 50px auto;
}

ul {
    list-style-type: none;
    padding: 0;
}

li {
    margin-bottom: 10px;
}

button {
    margin-left: 10px;
}
</style>