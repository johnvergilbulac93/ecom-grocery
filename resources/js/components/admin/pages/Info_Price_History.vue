<template>
  <div class="container">
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
              />
            </div>
          </div>
          <div class="col-sm-4">
            <button
              class="btn btn-primary btn-sm"
              @click.prevent="getItems()"
              v-bind:disabled="tableData.search.length === 0"
            >
              Find
            </button>

            <button
              class="btn btn-primary btn-sm"
              @click.prevent="clearData"
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
    <div class="table-responsive">
      <table class="table table-hover table-sm">
        <thead>
          <tr>
            <th>CODE</th>
            <th>DESCRIPTION</th>
            <th>UOM</th>
            <th>PREV. PRICE</th>
            <th>NEW PRICE</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="!prices.length">
            <td colspan="5" class="text-center">NO CHANGED PRICE TODAY</td>
          </tr>
          <tr v-for="(data, i) in prices" :key="i">
            <td>{{ data.itemcode }}</td>
            <td>{{ data.product_name }}</td>
            <td class="text-center">{{ data.UOM }}</td>
            <td class="text-center text-red">{{ data.prev_price }}</td>
            <td class="text-center text-blue">{{ data.new_price }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="card-footer">
      <pagination
        :pagination="pagination"
        @prev="getItems(pagination.prevPageUrl)"
        @next="getItems(pagination.nextPageUrl)"
      ></pagination>
    </div>
  </div>
</template>

<script>
import Pagination from "./Pagination.vue";

export default {
  name: "Price-Changed-Today",
  components: { pagination: Pagination },

  data() {
    return {
      prices: [],
      perPage: ["10", "25", "50", "100"],
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
    },
    getItems(url = "api/price_changed/info") {
      this.tableData.draw++;
      axios
        .get(url, { params: this.tableData })
        .then((response) => {
          let data = response.data;
          if (this.tableData.draw == data.draw) {
            this.prices = data.data.data;
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
  },
};
</script>
