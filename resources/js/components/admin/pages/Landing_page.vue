<template>
  <div class="jumbotron text-orange text-center">
    <div class="container text-muted">
      <h1 class="display-4 text-orange">Welcome back</h1>
      <h1 class="display-5 text-orange mt-4 mb-2">{{ name }}</h1>
      <hr />
      <center>
        <p class="lead text-orange my-4 mx-2">ALTURUSH | GROCERY-ADMIN</p>

        <img
          :src="$root.path + 'alturush.png'"
          style="width: 500px; height: 100px; object-fit: contain"
          alt="logo"
        />
      </center>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      name: null,
    };
  },
  mounted() {
    this.name = $("meta[name=name]").attr("content");
  },
};
</script>
