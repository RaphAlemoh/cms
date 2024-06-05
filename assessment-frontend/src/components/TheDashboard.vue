<script>
</script>

<template>
  <div class="container">
    <div class="row">
      <div class="col-md-8 offset-md-2">
        <div class="dashboard d-flex align-items-center justify-content-between">
          <div>
            <router-link to="/create-company" class="btn btn-primary mr-2">Create New Company</router-link>
            <router-link to="/create-service" class="btn btn-primary mr-2">Create New Service</router-link>
            <router-link to="/update-profile" class="btn btn-primary mr-2">Update Profile</router-link>
          </div>
          <button class="btn btn-danger" @click="logout">Logout</button>
        </div>
        <h1 class="mt-4">Dashboard</h1>
        <p>Welcome to your dashboard!</p>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  methods: {
    logout() {
      axios.post('/logout')
        .then(() => {
          localStorage.removeItem('authToken');
          this.$router.push('/login');
        })
        .catch(error => {
          console.error('Logout failed:', error);
        });
    }
  }
};
</script>
