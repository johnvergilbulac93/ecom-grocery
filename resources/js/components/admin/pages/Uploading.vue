<template>
  <div class="container">
    <div class="row justify-content-center mt-2">
      <div class="col-sm-4  ">
        <!-- small box -->
        <div class="small-box bg-orange text-white">
          <div class="inner">
            <h3>{{ itemcount }}</h3>

            <p>Uploaded Item</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="#" class="small-box-footer" @click="uploaditemmodal">
            <span class="text-white">Click here to upload new item</span>
            <i class="fas fa-arrow-circle-right text-white"></i
          ></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-sm-4 ">
        <!-- small box -->
        <div class="small-box bg-orange text-white">
          <div class="inner">
            <h3>{{ pricecount }}</h3>

            <p>Uploaded Price</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="#" class="small-box-footer text-white" @click="uploadpricemodal"
            ><span class="text-white">Click here to update price</span>
            <i class="fas fa-arrow-circle-right text-white"></i
          ></a>
        </div>
      </div>
      <!-- ./col -->
    </div>

    <!-- Modal item -->
    <div
      class="modal fade"
      id="uploadItem"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
      data-backdrop="static"
      data-keyboard="false"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="uploaditem">Upload New Item</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <Upload
              multiple
              type="drag"
              action="/api/uploaditem"
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

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">
              Close
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal price -->
    <div
      class="modal fade"
      id="uploadPrice"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
      data-backdrop="static"
      data-keyboard="false"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="uploaditem">Update Price</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <Upload
              multiple
              type="drag"
              action="/api/uploadprice"
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
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">
              Close
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal uom -->
    <div
      class="modal fade"
      id="uploadUom"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
      data-backdrop="static"
      data-keyboard="false"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="uploaditem">Upload New UOM</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <Upload
              multiple
              type="drag"
              action="/api/uploaduom"
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
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">
              Close
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal preview upload new item format csv -->
    <div
      class="modal fade"
      id="newitemformat"
      tabindex="-1"
      role="dialog"
      aria-labelledby="newitemformat"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <img src="" alt="newitemformat" />
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">
              Close
            </button>
          </div>
        </div>
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
    // newItemFormat() {
    //   $("#newitemformat").modal("show");
    // },
    countItems() {
      axios.get("api/countitem").then(({ data }) => (this.itemcount = data));
    },
    countPrice() {
      axios.get("api/countprice").then(({ data }) => (this.pricecount = data));
    },
    countUOM() {
      axios.get("api/countuom").then(({ data }) => (this.uomcount = data));
    },
    uploaduomodal() {
      $("#uploadUom").modal("show");
    },
    uploaditemmodal() {
      $("#uploadItem").modal("show");
    },
    uploadpricemodal() {
      $("#uploadPrice").modal("show");
    },
    handleSuccess() {
      swal.fire("Success", "Upload Complete.", "success");
      $("#uploadItem").modal("hide");
      $("#uploadUom").modal("hide");
      $("#uploadPrice").modal("hide");
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
    this.countItems();
    this.countPrice();
    // this.countUOM();
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
