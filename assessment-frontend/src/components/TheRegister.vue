<template>
  <div>
    <form @submit.prevent="register" class="needs-validation" novalidate>
      <div class="form-group">
        <label for="name">Name</label>
        <input id="name" v-model="name" class="form-control" placeholder="Name" required>
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input id="email" v-model="email" type="email" class="form-control" placeholder="Email" required>
      </div>
      <div class="form-group">
        <label for="mobile">Mobile</label>
        <input id="mobile" v-model="mobile" class="form-control" placeholder="Mobile" required>
      </div>
      <div class="form-group">
        <label for="address">Address</label>
        <input id="address" v-model="address" class="form-control" placeholder="Address" required>
      </div>
      <div class="form-group">
        <label for="country">Country</label>
        <select id="country" v-model="country_id" class="form-control" required>
          <option v-for="(country, index) in countries" :value="country.id" :key="index">{{ country.name }}</option>
        </select>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input id="password" v-model="password" type="password" class="form-control" placeholder="Password" required>
      </div>
      <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <input id="password_confirmation" v-model="password_confirmation" type="password" class="form-control"
          placeholder="Confirm Password" required>
      </div>
      <button type="submit" class="btn btn-primary">Register</button>
    </form>
    <div v-if="error" class="error">{{ error }}</div>
  </div>
</template>

<script>
import axios from '../axiosConfig';

export default {
  data() {
    return {
      name: '',
      email: '',
      mobile: '',
      address: '',
      country_id: null,
      password: '',
      password_confirmation: '',
      countries: [],
      error: ''
    }
  },
  mounted() {
    axios.get('/countries').then(response => {
      this.countries = response.data.data;
    });
  },
  methods: {
    register() {
      axios.post('/user', {
        name: this.name,
        email: this.email,
        mobile: this.mobile,
        address: this.address,
        country_id: this.country_id,
        password: this.password,
        password_confirmation: this.password_confirmation
      }).then(() => {
        this.$router.push('/login');
      }).catch(error => {
        this.error = error.response.data.message;
      });
    }
  }
}
</script>