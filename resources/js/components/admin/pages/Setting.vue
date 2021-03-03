<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-12  mt-3">
        <label for="uploadingcategory"> Upload Batch Item Category </label>
        <Upload
          multiple
          type="drag"
          action="/api/uploadcategory"
          :headers="{
            'x-csrf-token': token,
            'X-Requested-With': 'XMLHttpRequest',
          }"
          :on-success="handleSuccess"
          :on-error="handleError"
          :before-upload="handleBeforeUpload"
        >
          <div style="padding: 20px 0">
            <Icon type="ios-cloud-upload" size="52" style="color: orange"></Icon>
            <p>Click or drag files here</p>
          </div>
        </Upload>
      </div>
      <div class="col-lg-12 mt-3">
        <label for="uploadingcategory"> Upload Batch Item Image Filename </label>
        <Upload
          multiple
          type="drag"
          action="/api/uploaditemfilename"
          :headers="{
            'x-csrf-token': token,
            'X-Requested-With': 'XMLHttpRequest',
          }"
          :on-success="handleSuccess"
          :on-error="handleError"
          :before-upload="handleBeforeUpload"
        >
          <div style="padding: 20px 0">
            <Icon type="ios-cloud-upload" size="52" style="color: orange"></Icon>
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
      itemcount: null,
      pricecount: null,
      uomcount: null,
    };
  },
  methods: {
    uploadCategory() {
      $("#uploadCategory").modal("show");
    },
    handleSuccess() {
      swal.fire("Success", "Upload Complete.", "success");
      $("#uploadCategory").modal("hide");
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
  created() {
    this.token = $("meta[name=csrf-token]").attr("content");
  },
};
</script>
<style>
.demo-spin-icon-load {
  animation: ani-demo-spin 1s linear infinite;
}
@keyframes ani-demo-spin {
  from {
    transform: rotate(0deg);
  }
  50% {
    transform: rotate(180deg);
  }
  to {
    transform: rotate(360deg);
  }
}
.demo-spin-col {
  right: 294px;
}
</style>
