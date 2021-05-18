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
                  class="btn btn-primary btn-sm col-sm-12"
                  @click="getItems()"
                  v-bind:disabled="tableData.search.length === 0"
                >
                  Find
                </button>
              </div>
              <div class="col-sm-2 py-1">
                <button
                  class="btn btn-primary btn-sm col-sm-12"
                  @click="clearData"
                  v-bind:disabled="tableData.search.length === 0"
                >
                  Clear
                </button>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="row">
              <div class="col-sm-8 py-1">
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
              <div class="col-sm-4 py-1">
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
        <button
          class="btn btn-danger btn-sm mb-2"
          v-if="form.itemIds.length != 0"
          @click="disabledAll"
          data-toggle="tooltip"
          data-placement="bottom"
          title="Disable all selected item/uom"
        >
          <span>Disable</span>
        </button>
        <div class="table-responsive">
          <table class="table table-hover table-sm">
            <thead>
              <tr>
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
                <th>UOM</th>
                <th>PRICE</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, i) in items" :key="i" class="tr-hover">
                <td>
                  <input
                    type="checkbox"
                    class="checkmark-body"
                    :value="item.price_id"
                    v-model="form.itemIds"
                    @click="select"
                  />
                </td>
                <td>{{ item.itemcode }}</td>
                <td>{{ item.product_name }}</td>
                <td>{{ item.category_name }}</td>
                <td>{{ item.UOM }}</td>
                <td>{{ item.price_with_vat }}</td>
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
        ></pagination>
      </div>
    </div>
  </div>
</template>

<script>
import Pagination from "./Pagination.vue";
import Form from "vform";

export default {
  components: { pagination: Pagination },
  name: "Tagging-Disable-UOM",

  data() {
    return {
      items: [],
      selected: [],
      category: [],
      allSelected: false,
      form: new Form({
        itemIds: [],
      }),
      perPage: ["10", "25", "100", "500", "1000", "2000"],
      tableData: {
        draw: 0,
        length: 10,
        search: "",
        column: 1,
        dir: "asc",
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
      index: -1,
    };
  },
  methods: {
    async getCategory() {
      const data = await axios.get("api/count/category");
      this.category = data.data.categories;
      // console.log(data);
    },
    clearData() {
      this.getItems();
      this.tableData.search = "";
      this.form.itemIds = [];
      this.allSelected = false;
    },
    disabledAll() {
      swal
        .fire({
          title: "Confirmation",
          text: "Do you want to  disable this item uom?",
          icon: "question",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, disable it.",
        })
        .then((result) => {
          if (result.isConfirmed) {
            this.form.post("api/tagging/per_uom/disable").then(() => {
              Fire.$emit("reload");
              this.tableData.search = "";
              this.form.itemIds = [];
              this.allSelected = false;
              swal.fire(
                "Success!",
                "Selected item/uom successfully disable.",
                "success"
              );
            });
          }
        });
    },
    selectAll() {
      this.form.itemIds = [];

      // console.log(this.itemIds);
      let item;

      if (!this.allSelected) {
        for (item in this.items) {
          this.form.itemIds.push(this.items[item].price_id.toString());
        }
      }
    },
    select() {
      this.allSelected = false;
    },
    // getItems: _.debounce(function () {
    //   this.tableData.draw++;
    //   this.form.itemIds = [];
    //   this.allSelected = false;
    //   axios
    //     .get("api/tagging_uom/disable", { params: this.tableData })
    //     .then((response) => {
    //       let data = response.data;
    //       if (this.tableData.draw == data.draw) {
    //         this.items = data.data.data;
    //         this.configPagination(data.data);
    //       }
    //     })
    //     .catch((errors) => {
    //       console.log(errors);
    //     });
    // }, 2000),
    getItems(url = "api/tagging_uom/disable") {
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
    Fire.$on("reload", () => {
      this.getItems();
    });
  },
};
</script>
