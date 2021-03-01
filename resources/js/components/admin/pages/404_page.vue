<template>
  <div class="container mt-4">
    <center class="mt-4">
      <h1 class="lead">404 | NOT FOUND</h1>
      <router-link to="/" class="nav-link">
        <button class="btn btn-primary btn-sm">GO BACK</button>
      </router-link>
    </center>
  </div>
</template>

<script>
export default {
  mounted() {
    console.log("Component mounted.");
  },
};
</script>
