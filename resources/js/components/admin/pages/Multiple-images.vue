<template>
  <div class="container" style="min-height: 300px;">
    <Upload
      multiple
      type="drag"
      action="/api/uploadmultiple"
      :headers="{
        'x-csrf-token': token,
        'X-Requested-With': 'XMLHttpRequest',
      }"
      :on-error="handleError"
    >
      <div style="padding: 20px 0">
        <Icon type="ios-cloud-upload" size="52" style="color: orange"></Icon>
        <p>Click or drag files here to upload</p>
      </div>
    </Upload>
  </div>
</template>

<script>
export default {
  data() {
    return {
      token: "",
    };
  },
  methods: {
    handleError(res, file) {
      swal.fire(
        "Warning",
        `${file.errors.file.length ? file.errors.file[0] : "Something went wrong!"}`,
        "warning"
      );
    },
  },
  mounted() {
    this.token = $("meta[name=csrf-token]").attr("content");
  },
};
</script>

<style>
</style>