<template>
  <div class="container">
    <Top></Top>
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-md-6">
            <div class="row">
              <div class="col-sm-8">
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
              <div class="col-sm-4">
                <button
                  class="btn btn-primary btn-sm"
                  @click="clearData"
                  v-bind:disabled="tableData.search.length === 0"
                >
                  Clear
                </button>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <label for="" class="font-light float-right mx-1 mt-1">Entries</label>
            <select
              v-model="tableData.length"
              class="form-control form-control-sm float-right"
              style="width: 110px"
              @change="getItems()"
            >
              <option v-for="(records, index) in perPage" :key="index" :value="records">
                {{ records }}
              </option>
            </select>
            <label for="" class="font-light float-right mx-1 mt-1">Show</label>
          </div>
        </div>
      </div>
      <div class="card-body">
        <button
          class="btn btn-success btn-sm mb-2"
          v-if="form.itemIds.length != 0"
          @click="enabledAll"
          data-toggle="tooltip"
          data-placement="bottom"
          title="Disable all selected item/uom"
        >
          <span>Enable</span>
        </button>
        <div class="table-responsive">
          <table class="table table-hover table-sm">
            <thead>
              <tr class="text-center">
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
            <tbody class="text-center">
              <tr v-for="(item, i) in items" :key="i">
                <th>
                  <input
                    type="checkbox"
                    class="checkmark-body"
                    :value="item.price_id"
                    v-model="form.itemIds"
                    @click="select"
                  />
                </th>
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
  name: "Tagging-Enable-UOM",

  data() {
    return {
      items: [],
      selected: [],
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
    };
  },
  methods: {
    clearData() {
      this.getItems();
      this.tableData.search = "";
      this.form.itemIds = [];
      this.allSelected = false;
    },
    enabledAll() {
      // this.form.post("api/tagging/per_uom").then(() => {});
      swal
        .fire({
          title: "Confirmation",
          text: "Do you want to enabled this item/uom?",
          icon: "question",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, enabled it.",
        })
        .then((result) => {
          if (result.isConfirmed) {
            this.form.post("api/tagging/per_uom/enable").then(() => {
              Fire.$emit("reload");
              this.tableData.search = "";
              this.form.itemIds = [];
              this.allSelected = false;
              swal.fire("Success!", "Selected item/uom successfully enabled.", "success");
            });
          }
        });
    },
    selectAll() {
      this.form.itemIds = [];
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
    // getItems: _.throttle(function () {
    //   this.tableData.draw++;
    //   this.form.itemIds = [];
    //   this.allSelected = false;
    //   axios
    //     .get("api/tagging_uom/enable", { params: this.tableData })
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
    getItems(url = "api/tagging_uom/enable") {
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
    Fire.$on("reload", () => {
      this.getItems();
    });
  },
};
</script>
