<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <Upload
          multiple
          type="drag"
          action="/api/uploadItemDisable"
          :headers="{
            'x-csrf-token': token,
            'X-Requested-With': 'XMLHttpRequest',
          }"
          :on-success="handleSuccess"
          :on-error="handleError"
          :before-upload="handleBeforeUpload"
        >
          <div style="padding: 20px 0">
            <Icon type="ios-cloud-upload" size="350" style="color: orange"></Icon>
            <p>Click or drag files here</p>
          </div>
        </Upload>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      token: null,
    };
  },
  methods: {
    handleSuccess() {
      swal.fire("Success", "Upload Complete.", "success");
    },
    handleError(res, file) {
      swal.fire(
        "Warning",
        `${file.errors.file.length ? file.errors.file[0] : "Something went wrong!"}`,
        "warning"
      );
    },
    handleBeforeUpload(e) {},
  },
  mounted() {
    this.token = $("meta[name=csrf-token]").attr("content");
  },
};
</script>
