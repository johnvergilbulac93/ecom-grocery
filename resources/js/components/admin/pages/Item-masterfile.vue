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
        <!-- <a
          class="btn btn-danger btn-sm mb-1"
          v-if="form.itemIds.length != 0"
          @click="disabledAll"
          data-toggle="tooltip"
          data-placement="bottom"
          title="Disable all selected item"
        >
          <i class="fas fa-times fa-lg text-white"></i>
        </a>

        <a
          class="btn btn-primary btn-sm mb-1"
          v-if="form.itemIds.length != 0"
          @click="enabledAll"
          data-toggle="tooltip"
          data-placement="bottom"
          title="Enable all selected item"
        >
          <i class="fas fa-check fa-lg text-white"></i>
        </a> -->
        <div class="btn-group btn-group-toggle mb-1 " data-toggle="buttons" v-if="form.itemIds.length != 0">
          <label class="btn btn-danger btn-sm ">
            <i class="fas fa-times text-white p-1"></i>
            <input type="radio" name="options" id="option1" autocomplete="off" @click="disabledAll"> <small>DISABLE</small>
          </label>
          <label class="btn btn-primary btn-sm">
            <i class="fas fa-check text-white"></i>
            <input type="radio" name="options" id="option2" autocomplete="off" @click="enabledAll"> <small>ENABLE</small>
          </label>
        </div>
        <div class="table-responsive">
          <table class="table custom-table table-sm">
            <thead>
              <tr>
                <th style="width: 45px"></th>
                <th>
                  <input
                    type="checkbox"
                    class="checkmark"
                    @click="selectAll"
                    v-model="allSelected"
                  />
                </th>
                <th>ITEMCODE</th>
                <th>DESCRIPTION</th>
                <th>CATEGORY NAME</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="!items.length">
                <td colspan="4" class="text-center">
                  No matching records found
                </td>
              </tr>
              <tr
                v-for="(item, i) in items"
                :key="i"
                @mouseover="selected(item)"
                @mouseleave="unSelected()"
                class="tr-hover"
              >
                <td style="width: 45px">
                  <a
                    @click="preview(item.image, item.product_name)"
                    data-toggle="tooltip"
                    data-placement="bottom"
                    title="View Image"
                  >
                    <i
                      class="fas fa-eye fa-lg mt-1"
                      v-bind:class="{
                        'text-danger ': item.image == null,
                      }"
                    ></i>
                  </a>
                </td>
                <td>
                  <input
                    type="checkbox"
                    class="checkmark-body"
                    :value="item.itemcode"
                    v-model="form.itemIds"
                    @click="chosen"
                  />
                </td>
                <td
                  v-bind:class="{
                    'text-danger font-weight-bold': item.items !== null,
                  }"
                >
                  {{ item.itemcode }}
                </td>
                <td
                  v-bind:class="{
                    'text-danger font-weight-bold': item.items !== null,
                  }"
                >
                  {{ item.product_name }}
                </td>
                <td
                  v-bind:class="{
                    'text-danger font-weight-bold': item.items !== null,
                  }"
                >
                  {{ item.category_name }}
                </td>
                <td style="width: 45px">
                  <a
                    v-if="item.items !== null"
                    @click="tagItemEnable(item.itemcode, item.product_name)"
                    data-toggle="tooltip"
                    data-placement="bottom"
                    title="Disable Item"
                  >
                    <i class="fas fa-times fa-lg text-danger mt-1 px-1"></i>
                  </a>
                  <a
                    v-else
                    @click="tagItemDisable(item.itemcode, item.product_name)"
                    data-toggle="tooltip"
                    data-placement="bottom"
                    title="Enable Item"
                  >
                    <i class="fas fa-check fa-lg text-success mt-1"></i>
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
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
              class="btn btn-primary btn-sm"
              data-dismiss="modal"
              aria-label="Close"
            >
              Close
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
      { width: "5%", label: "", name: "image" },
      { width: "10%", label: "CODE", name: "itemcode" },
      { width: "40%", label: "DESCRIPTION", name: "description" },
      { width: "20%", label: "CATEGORY", name: "category" },
      { width: "10%", label: "", name: "action" },
    ];
    columns.forEach((column) => {
      sortOrders[column.name] = -1;
    });
    return {
      items: [],
      category: [],
      columns: columns,
      sortKey: "itemcode",
      sortOrders: sortOrders,
      selectedData: false,
      allSelected: false,
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
        itemIds: [],
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
    enabledAll() {
      swal
        .fire({
          title: "Confirmation",
          text: "Do you want to enable the selected item?",
          icon: "question",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, disabled it.",
        })
        .then((result) => {
          if (result.isConfirmed) {
            this.form.post("api/selected/enable/item").then((res) => {
              Fire.$emit("refresh_item");
              this.tableData.search = "";
              this.form.itemIds = [];
              this.allSelected = false;
              // if (res.data === 0) {
              //   swal.fire(
              //     "Success!",
              //     "Selected item successfully enabled.",
              //     "success"
              //   );
              // } else {
              //   swal.fire(
              //     "Information",
              //     `System detect ${res.data} item already enabled.`,
              //     "info"
              //   );
              // }
            });
          }
        });
    },
    disabledAll() {
      swal
        .fire({
          title: "Confirmation",
          text: "Do you want to  disabled selected item?",
          icon: "question",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, disabled it.",
        })
        .then((result) => {
          if (result.isConfirmed) {
            this.form.post("api/selected/disable/item").then((res) => {
              Fire.$emit("refresh_item");
              this.tableData.search = "";
              this.form.itemIds = [];
              this.allSelected = false;
              // if (res.data === 0) {
              //   swal.fire(
              //     "Success!",
              //     "Selected item successfully disabled.",
              //     "success"
              //   );
              // } else {
              //   swal.fire(
              //     "Information",
              //     `System detect ${res.data} item already disabled.`,
              //     "info"
              //   );
              // }
            });
          }
        });
    },
    selectAll() {
      this.form.itemIds = [];
      let item;
      if (!this.allSelected) {
        for (item in this.items) {
          this.form.itemIds.push(this.items[item].itemcode.toString());
        }
      }
    },
    chosen() {
      this.allSelected = false;
    },
    clearData() {
      this.getItems();
      this.tableData.search = "";
      this.form.itemIds = [];
      this.allSelected = false;
    },
    selected(data) {
      this.selectedData = data;
    },
    unSelected() {
      this.selectedData = false;
    },
    preview(image, description) {
      this.form.previewImage = image;
      this.form.product_name = description;
      $("#previewitem").modal("show");
    },
    tagItemDisable(itemcode, description) {
      swal
        .fire({
          title: "Are you sure?",
          text: "you want to disabled this Item",
          icon: "question",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, Disabled it!",
        })
        .then((result) => {
          if (result.isConfirmed) {
            axios({
              method: "post",
              url: "api/tag_item_disable",
              data: {
                itemcode,
              },
            })
              .then(() => {
                Fire.$emit("refresh_item");
                swal.fire(
                  `${itemcode}:${description}`,
                  "Successfully Disabled",
                  "success"
                );
              })
              .catch((error) => {
                console.log(error);
              });
          }
        });
    },
    tagItemEnable(itemcode, description) {
      swal
        .fire({
          title: "Are you sure?",
          text: "you want to enable this item",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, Enabled it!",
        })
        .then((result) => {
          if (result.isConfirmed) {
            axios({
              method: "delete",
              url: "api/tag_item_enable/" + itemcode,
            })
              .then(() => {
                Fire.$emit("refresh_item");
                swal.fire(
                  `${itemcode}:${description}`,
                  "Successfully Enabled",
                  "success"
                );
              })
              .catch((error) => {
                console.log(error);
              });
          }
        });
    },
    getItems(url = "api/item") {
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
    this.getItems();
    this.getCategory();
    Fire.$on("refresh_item", () => {
      this.getItems();
    });
  },
};
</script>
