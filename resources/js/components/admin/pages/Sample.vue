<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-md-6">
                <input
                  class="form-control form-control-sm"
                  type="text"
                  placeholder="Search Item"
                  v-model="tableData.search"
                  @input="getItems()"
                />
              </div>

              <div class="col-md-6">
                <div class="row float-right">
                  <div class="col-md-12">
                    <label for="" class="mx-3 mt-1">Show Entry:</label>
                    <select
                      v-model="tableData.length"
                      class="form-control form-control-sm float-right"
                      style="width: 110px"
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
            <datatable :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders">
              <tbody>
                <tr v-for="(item, i) in items" :key="i">
                  <td>{{ item.itemcode }}</td>
                  <td>{{ item.product_name }}</td>
                  <td>{{ item.category_name }}</td>
                  <!-- <td>{{ item.item_price.UOM }}</td> -->
                  <td>
                    <select
                      style="width: 100px"
                      class="form-control form-control-sm"
                      @change="getPrice($event, i)"
                    >
                      <option
                        v-for="(g, index) in item.item_price"
                        :key="index"
                        :value="g.price_with_vat"
                      >
                        {{ g.UOM }}
                      </option>
                    </select>
                  </td>
                  <!-- <td>{{ item.item_price.price_with_vat }}</td> -->
                  <td>
                    <span :id="`price-${i}`">{{
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
                  <td class="text-center" style="width: 40px">
                    <Button
                      icon="md-trash"
                      type="error"
                      shape="circle"
                      @click="deleteItem(item.itemcode, i)"
                    ></Button>
                  </td>
                </tr>
              </tbody>
            </datatable>
            <pagination
              :pagination="pagination"
              @prev="getItems(pagination.prevPageUrl)"
              @next="getItems(pagination.nextPageUrl)"
            >
            </pagination>
          </div>
        </div>
      </div>
    </div>

    <!-- <pagination></pagination> -->
  </div>
</template>

<script>
import Datatable from "./Datatable.vue";
import Pagination from "./Pagination.vue";
export default {
  components: { datatable: Datatable, pagination: Pagination },
  data() {
    let sortOrders = {};
    let columns = [
      { width: "10%", label: "Itemcode", name: "id" },
      { width: "70%", label: "Description", name: "description" },
      { width: "20%", label: "Category", name: "category" },
      { width: "10%", label: "UOM", name: "uom" },
      { width: "10%", label: "Price", name: "price" },
      { width: "10%", label: "Status", name: "status" },
      { width: "10%", label: "Action", name: "action" },
    ];
    columns.forEach((column) => {
      sortOrders[column.name] = -1;
    });
    return {
      items: [],
      columns: columns,
      sortKey: "deadline",
      sortOrders: sortOrders,
      perPage: ["10", "25", "50", "100"],
      tableData: {
        draw: 0,
        length: 10,
        search: "",
        column: 0,
        dir: "desc",
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
    getPrice(e, i) {
      // console.log(e.target.value)
      $("#price-" + i).text(e.target.value);
    },
    getItems(url = "api/sample") {
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
  },
};
</script>
