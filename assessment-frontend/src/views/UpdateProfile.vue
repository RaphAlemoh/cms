<template>
    <div class="update-profile-page">
        <h1>Update Profile</h1>
        <form @submit.prevent="updateProfile">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" v-model="user.name" required class="form-control" />
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" v-model="user.email" required class="form-control" />
            </div>
            <div class="form-group">
                <label for="mobile">Mobile</label>
                <input type="text" id="mobile" v-model="user.mobile" required class="form-control" />
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" v-model="user.address" required class="form-control" />
            </div>
            <div class="form-group">
                <label for="country">Country</label>
                <select id="country" v-model="user.country_id" required class="form-control">
                    <option v-for="country in countries" :key="country.id" :value="country.id">
                        {{ country.name }}
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label for="image">Profile Image</label>
                <input type="file" id="image" @change="onFileChange" class="form-control" />
            </div>
            <div v-if="error" class="error-message">
                {{ error }}
            </div>
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>
</template>

<script>
import axios from '../axiosConfig';

export default {
    data() {
        return {
            user: {
                name: '',
                email: '',
                mobile: '',
                address: '',
                country_id: null,
                image: null,
            },
            countries: [],
            error: null,
        };
    },
    mounted() {
        this.fetchUser();
        this.fetchCountries();
    },
    methods: {
        async fetchUser() {
            try {
                const response = await axios.get('/api/user', {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('token')}`
                    }
                });
                this.user = response.data;
            } catch (error) {
                console.error('Error fetching user:', error);
            }
        },
        async fetchCountries() {
            try {
                const response = await axios.get('/api/countries');
                this.countries = response.data;
            } catch (error) {
                console.error('Error fetching countries:', error);
            }
        },
        onFileChange(event) {
            this.user.image = event.target.files[0];
        },
        async updateProfile() {
            try {
                const formData = new FormData();
                formData.append('name', this.user.name);
                formData.append('email', this.user.email);
                formData.append('mobile', this.user.mobile);
                formData.append('address', this.user.address);
                formData.append('country_id', this.user.country_id);
                if (this.user.image) {
                    formData.append('image', this.user.image);
                }

                await axios.post('/api/user/update', formData, {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('token')}`,
                        'Content-Type': 'multipart/form-data',
                    }
                });
                this.$router.push('/dashboard');  // Redirect to dashboard or profile view
            } catch (error) {
                if (error.response) {
                    this.error = error.response.data.message || 'Failed to update profile';
                } else {
                    this.error = 'Failed to update profile';
                }
            }
        },
    },
};
</script>

<style scoped>
.update-profile-page {
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