<template>
  <div class="container">
    <Top></Top>
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-sm-6">
            <div class="row">
              <div class="col-sm-8 py-1">
                <div class="form-group has-search">
                  <span class="fa fa-search form-control-feedback"></span>
                  <input
                    type="text"
                    class="form-control form-control-sm"
                    placeholder="Search"
                    v-model="tableData.search"
                    @keyup.enter="getItems()"
                  />
                </div>
              </div>
              <div class="col-sm-2 py-1">
                <button
                  class="btn btn-primary btn-sm btn-block"
                  @click="getItems()"
                  v-bind:disabled="tableData.search.length === 0"
                >
                  Find
                </button>
              </div>
              <div class="col-sm-2 py-1">
                <button
                  class="btn btn-primary btn-sm btn-block"
                  @click="clearData"
                  v-bind:disabled="tableData.search.length === 0"
                >
                  Clear
                </button>
              </div>
            </div>
          </div>
          <div class="col-sm-6 py-1">
            <div class="row">
              <div class="col-sm-8">
                <select
                  v-model="tableData.category"
                  class="form-control form-control-sm d-block"
                  @change="getItems()"
                >
                  <option value="">Please select category</option>
                  <option
                    :value="data.category_name"
                    v-for="(data, i) in category"
                    :key="i"
                  >
                    {{ data.category_name }}
                  </option>
                </select>
              </div>
              <div class="col-sm-4">
                <select
                  v-model="tableData.length"
                  class="form-control form-control-sm d-block"
                  @change="getItems()"
                >
                  <option
                    v-for="(records, index) in perPage"
                    :key="index"
                    :value="records"
                  >
                    {{ records }}
                  </option>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body">
        <datatable
          :columns="columns"
          :sortKey="sortKey"
          :sortOrders="sortOrders"
          @sort="sortBy"
        >
          <tbody>
            <tr v-if="!items.length" class="tr-hover">
              <td colspan="8" class="text-center">No matching records found</td>
            </tr>

            <tr
              v-for="(item, i) in items"
              :key="i"
              class="tr-hover"
              @mouseover="selected(item)"
              @mouseleave="unSelected()"
            >
              <td style="width: 50px">
                <a
                  @click="preview(item.image, item.product_name)"
                  v-if="item === selectedData"
                  data-toggle="tooltip"
                  data-placement="bottom"
                  title="View Image"
                >
                  <i
                    class="fas fa-eye fa-lg mt-2"
                    v-bind:class="{
                      'text-danger ': item.image == null,
                    }"
                  ></i>
                </a>
                <!-- <a @click="preview(item.image, item.product_name)">
                  <center>
                    <img
                      :src="$root.url + item.image"
                      alt="item-image"
                      class="item-image"
                      v-if="item.image"
                    />
                    <img
                      :src="$root.url + 'noimage.png'"
                      alt="item-image"
                      class="item-image"
                      v-else
                    />
                  </center>
                </a> -->
              </td>
              <td>{{ item.itemcode }}</td>
              <td>{{ item.product_name }}</td>
              <td>{{ item.category_name }}</td>
              <td>
                <select
                  style="width: 100px"
                  class="form-control form-control-sm"
                  @change="getPrice($event, i)"
                >
                  <option
                    v-for="(data, index) in item.item_price"
                    :key="index"
                    :value="data.price_with_vat"
                  >
                    {{ data.UOM }}
                  </option>
                </select>
              </td>
              <td>
                <span :id="`price-${i}`" class="text-blue font-bold">{{
                  item.item_price[0].price_with_vat
                }}</span>
              </td>
              <td class="text-center" v-if="item.status == 'active'">
                <a @click="showPerItemStatusActive(item.itemcode, i)">
                  <span :class="`badge item ${item.status}`">
                    {{ item.status | textformat }}</span
                  >
                </a>
              </td>
              <td class="text-center" v-else>
                <a @click="showPerItemStatusInactive(item.itemcode, i)">
                  <span :class="`badge item ${item.status}`">
                    {{ item.status | textformat }}</span
                  >
                </a>
              </td>
              <td style="width: 50px">
                <a
                  @click="uploadImageItem(item, item.product_id)"
                  v-if="item === selectedData"
                  class="text-danger"
                  data-toggle="tooltip"
                  data-placement="bottom"
                  title="Upload Image"
                >
                  <i class="fas fa-cloud-upload-alt fa-lg text-primary mt-2"></i
                ></a>
                <!-- <Button
                  icon="ios-cloud-upload"
                  type="primary"
                  shape="circle"
                  @click="uploadImageItem(item, item.product_id)"
                ></Button>

                <Button
                  icon="md-trash"
                  type="error"
                  shape="circle"
                  @click="deleteItem(item.product_id, i)"
                ></Button> -->
              </td>
            </tr>
          </tbody>
        </datatable>
      </div>
      <div class="card-footer">
        <pagination
          :pagination="pagination"
          @prev="getItems(pagination.prevPageUrl)"
          @next="getItems(pagination.nextPageUrl)"
        >
        </pagination>
      </div>
    </div>
    <!-- <div v-if="!$gate.isSuperAdmin()">
      <page404></page404>
    </div> -->
    <!-- start modal upload -->
    <div
      class="modal fade"
      id="uploadimageitem"
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
            <h5 class="modal-title" id="uploadimageitem">Upload Image</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="mb-2">
              <div class="row">
                <div class="col-md-12 mt-1">
                  <div class="custom-file">
                    <input
                      @change="onChangeImageItem"
                      type="file"
                      class="custom-file-input"
                      ref="image"
                      :class="{ 'is-invalid': form.errors.has('image') }"
                    />
                    <label class="custom-file-label" for="customFile"
                      >Choose file</label
                    >
                    <has-error :form="form" field="image"></has-error>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <Button
              type="primary"
              :loading="loading"
              @click.prevent="uploadItemImage(form.itemcode)"
            >
              <span v-if="!loading">Upload</span>
              <span v-else>Uploading...</span>
            </Button>
          </div>
        </div>
      </div>
    </div>
    <!-- end modal upload -->

    <!--start modal preview -->
    <div
      class="modal fade"
      id="previewitem"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="previewitem">
              {{ form.product_name }}
            </h5>
          </div>
          <div class="modal-body">
            <center>
              <img
                :src="$root.url + form.previewImage"
                v-if="form.previewImage"
                alt="item-image"
                class="img"
                style="width: 400px; height: 300px; object-fit: contain"
              />
              <img
                :src="$root.url + 'noimage.png'"
                v-else
                alt="item-image"
                class="img"
                style="width: 400px; height: 300px; object-fit: contain"
              />
            </center>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-danger btn-sm"
              data-dismiss="modal"
              aria-label="Close"
            >
              CLOSE
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- end modal preview -->
  </div>
</template>

<script>
import Form from "vform";
import Datatable from "./Datatable.vue";
import Pagination from "./Pagination.vue";
export default {
  components: { datatable: Datatable, pagination: Pagination },

  data() {
    let sortOrders = {};
    let columns = [
      { width: "10%", label: "", name: "image" },
      { width: "10%", label: "CODE", name: "itemcode" },
      { width: "20%", label: "DESCRIPTION", name: "description" },
      { width: "15%", label: "CATEGORY", name: "category" },
      { width: "8%", label: "UOM", name: "uom" },
      { width: "10%", label: "PRICE", name: "price" },
      { width: "12%", label: "STATUS", name: "status" },
      { width: "12%", label: "", name: "" },
    ];
    columns.forEach((column) => {
      sortOrders[column.name] = -1;
    });
    return {
      loading: false,
      token: null,
      items: [],
      category: [],
      columns: columns,
      sortKey: "itemcode",
      sortOrders: sortOrders,
      selectedData: false,
      perPage: ["10", "25", "50", "100"],
      tableData: {
        draw: 0,
        length: 10,
        search: "",
        column: 1,
        dir: "desc",
        category: "",
      },
      pagination: {
        lastPage: "",
        currentPage: "",
        total: "",
        lastPageUrl: "",
        nextPageUrl: "",
        prevPageUrl: "",
        from: "",
        to: "",
      },
      form: new Form({
        product_id: "",
        itemcode: "",
        quantity: "",
        product_name: "",
        image: "",
        status: "",
        previewImage: "",
      }),
      index: -1,
    };
  },
  methods: {
    async getCategory() {
      const data = await axios.get("api/count/category");
      this.category = data.data.categories;
      // console.log(data);
    },
    selected(data) {
      this.selectedData = data;
    },
    unSelected() {
      this.selectedData = false;
    },
    clearData() {
      this.getItems();
      this.tableData.search = "";
    },
    preview(image, description) {
      this.form.previewImage = image;
      this.form.product_name = description;
      $("#previewitem").modal("show");
    },

    uploadItemImage(itemcode) {
      this.loading = true;
      this.form
        .put("api/imageitem/" + itemcode)
        .then(() => {
          this.loading = false;
          swal.fire("Uploaded!", "Successfully.", "success");
          $("#uploadimageitem").modal("hide");
          Fire.$emit("refresh_item");
        })
        .catch(() => {
          this.loading = false;
        });
    },
    onChangeImageItem(e) {
      let file = e.target.files[0];
      let reader = new FileReader();
      reader.onloadend = (file) => {
        this.form.image = reader.result;
      };
      reader.readAsDataURL(file);
      // this.form.image = this.$refs.image.files[0];
      // this.form.image = e.target.files[0];
    },
    uploadImageItem(item, id) {
      this.form.clear();
      this.form.reset();
      this.form.itemcode = item.itemcode;
      this.form.product_name = item.product_name;
      if (item.image != null) {
        swal
          .fire({
            title: "IMAGE",
            text: "ITEM HAS ALREADY AN IMAGE.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, change it!",
          })
          .then((result) => {
            if (result.isConfirmed) {
              $("#uploadimageitem").modal("show");
            }
          });
      } else {
        $("#uploadimageitem").modal("show");
      }
    },
    getPrice(e, i) {
      $("#price-" + i).text(e.target.value);
    },
    showPerItemStatusActive(itemcode) {
      swal
        .fire({
          title: "Do you want",
          text: "to change the status to inactive this item?",
          icon: "question",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, change it!",
        })
        .then((result) => {
          if (result.isConfirmed) {
            this.form.put("api/item_Active/" + itemcode).then(() => {
              Fire.$emit("refresh_item");
              toast.fire({
                icon: "success",
                title: "Success",
                text: "Successfully changed",
              });
            });
          }
        });
    },
    showPerItemStatusInactive(itemcode) {
      swal
        .fire({
          title: "Do you want",
          text: "to change the status to active this item?",
          icon: "question",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, change it!",
        })
        .then((result) => {
          if (result.isConfirmed) {
            this.form.put("api/item_Inactive/" + itemcode).then(() => {
              Fire.$emit("refresh_item");
              toast.fire({
                icon: "success",
                title: "Success",
                text: "Successfully changed",
              });
            });
          }
        });
    },
    editItem() {
      console.log(this.form.product_id);
      this.form.put("api/edit_item/" + this.form.product_id).then(() => {
        var _this = this;
        _this.items[this.index].itemcode = this.form.itemcode;
        _this.items[this.index].product_name = this.form.product_name;
        _this.items[this.index].status = this.form.status;

        toast.fire({
          icon: "success",
          title: "Success",
          text: "Successfully Updated",
        });
        $("#itemModal").modal("hide");
      });
    },
    deleteItem(id, index) {
      swal
        .fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
        })
        .then((result) => {
          if (result.isConfirmed) {
            this.form
              .delete("api/delete_item/" + id)
              .then(() => {
                this.items.splice(index, 1);
                swal.fire("Deleted!", "Successfully.", "success");
              })
              .catch(() => {
                swal.fire({
                  icon: "warning",
                  title: "Oops...",
                  text: "Something went wrong!",
                });
              });
          }
        });
    },
    editModal(item, index) {
      this.editMode = true;
      this.form.clear();
      this.form.reset();
      $("#itemModal").modal("show");
      this.form.fill(item);
      this.index = index;
    },
    createModal() {
      this.editMode = false;
      this.form.clear();
      this.form.reset();
      $("#itemModal").modal("show");
    },
    getItems(url = "api/central_item") {
      this.tableData.draw++;
      axios
        .get(url, { params: this.tableData })
        .then((response) => {
          let data = response.data;
          if (this.tableData.draw == data.draw) {
            this.items = data.data.data;
            this.configPagination(data.data);
          }
        })
        .catch((errors) => {
          console.log(errors);
        });
    },
    configPagination(data) {
      this.pagination.lastPage = data.last_page;
      this.pagination.currentPage = data.current_page;
      this.pagination.total = data.total;
      this.pagination.lastPageUrl = data.last_page_url;
      this.pagination.nextPageUrl = data.next_page_url;
      this.pagination.prevPageUrl = data.prev_page_url;
      this.pagination.from = data.from;
      this.pagination.to = data.to;
    },
    sortBy(key) {
      this.sortKey = key;
      this.sortOrders[key] = this.sortOrders[key] * -1;
      this.tableData.column = this.getIndex(this.columns, "name", key);
      this.tableData.dir = this.sortOrders[key] === 1 ? "asc" : "desc";
      this.getItems();
    },
    getIndex(array, key, value) {
      return array.findIndex((i) => i[key] == value);
    },
  },
  created() {
    this.token = $("meta[name=csrf-token]").attr("content");
    this.getCategory();
    this.getItems();
    Fire.$on("refresh_item", () => {
      this.getItems();
    });
  },
};
</script>
<style scoped>
.table {
  width: 100%;
}
.table .sorting_both {
  background-image: url("/images/sort_both.png");
  background-repeat: no-repeat;
  background-position: 100%;
}
.table .sorting_up {
  background-image: url("/images/sort_asc.png");
  background-repeat: no-repeat;
  background-position: 100%;
}
.table .sorting_down {
  background-image: url("/images/sort_desc.png");
  background-repeat: no-repeat;
  background-position: 100%;
}
h1 {
  text-align: center;
  font-size: 30px;
}
</style>
