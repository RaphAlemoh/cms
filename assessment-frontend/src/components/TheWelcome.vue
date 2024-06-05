<script>
export default {
  mounted() {
    const token = localStorage.getItem('authToken');
    if (token) {
      this.$router.push('/dashboard');
    }
  }
};
</script>
<template>
  <div class="container">
    <div class="row justify-content-center align-items-center vh-100">
      <div class="col-md-6 text-center">
        <h1 class="display-4 mb-4">Welcome to Our App</h1>
        <div class="btn-group" role="group" aria-label="User Actions">
          <router-link to="/register" class="btn btn-primary btn-lg mr-2">Sign Up</router-link>
          <router-link to="/login" class="btn btn-secondary btn-lg">Sign In</router-link>
        </div>
      </div>
    </div>
  </div>

</template>
