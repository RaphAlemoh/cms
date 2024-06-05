<script>
import axios from '../axiosConfig';

export default {
  data() {
    return {
      email: '',
      password: '',
      error: ''
    }
  },
  methods: {
    login() {
      axios.post('/login', {
        email: this.email,
        password: this.password,
      }).then(response => {
        localStorage.setItem('authToken', response.data.data.token);
        this.$router.push('/dashboard');
      })
        .catch(error => {
          this.error = error.data.data.error;
        });
    }
  }
}
</script>
<template>
  <div>
    <form @submit.prevent="login" class="needs-validation" novalidate>
      <div class="form-group">
        <label for="email">Email</label>
        <input v-model="email" type="email" class="form-control" id="email" placeholder="Enter email" required>
        <div class="invalid-feedback">
          Please enter a valid email address.
        </div>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input v-model="password" type="password" class="form-control" id="password" placeholder="Password" required>
        <div class="invalid-feedback">
          Please enter your password.
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Login</button>
    </form>

    <div v-if="error" class="error">{{ error }}</div>
  </div>
</template>
