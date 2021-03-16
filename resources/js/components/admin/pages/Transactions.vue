<template>
  <div class="container">
    <div class="row mt-1">
      <div class="col-sm-3">
        <div class="form-group">
          <label for="store">Store</label>&nbsp;
          <select
            class="form-control form-control-sm"
            v-model="filter.store"
            tabindex="1"
          >
            <option value="">Select Store</option>
            <option
              v-for="(store, i) in stores"
              :value="store.bunit_code"
              :key="i"
            >
              {{ store.business_unit }}
            </option>
          </select>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="form-group">
          <label for="status">Status</label>&nbsp;
          <select
            class="form-control form-control-sm"
            tabindex="2"
            v-model="filter.status"
          >
            <option value="">Select Status</option>
            <option value="1">Remitted</option>
            <option value="2">Cancelled</option>
          </select>
        </div>
      </div>
      <div class="col-sm-2">
        <div class="form-group">
          <label for="from">Date From:</label>&nbsp;
          <input
            type="date"
            class="form-control form-control-sm"
            tabindex="3"
            v-model="filter.dateFrom"
          />
        </div>
      </div>
      <div class="col-sm-2">
        <div class="form-group">
          <label for="from">Date To:</label>&nbsp;
          <input
            type="date"
            class="form-control form-control-sm"
            tabindex="4"
            v-model="filter.dateTo"
          />
        </div>
      </div>
      <div class="col-sm-2">
        <button
          class="btn btn-primary btn-sm btn-block mt-4"
          @click="generate()"
        >
          <span
            class="spinner-border spinner-border-sm"
            role="status"
            aria-hidden="true"
            v-if="loading"
          ></span>
          {{ loading ? "Loading..." : "Generate" }}
        </button>
      </div>
      <div class="d-flex">
        <!-- <button
          class="btn btn-primary btn-sm mx-2"
          @click="generate()"
          tabindex="4"
        >
          Generate
        </button>
        <button
          tabindex="5"
          class="btn btn-success btn-sm"
          @click="printBtn()"
          v-if="transactions.b_unit != null"
          :disabled="!transactions.data.length"
        >
          <i class="fas fa-print"></i>
          Print
        </button> -->
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Transactions",
  created() {},
  data() {
    return {
      transactions: [],
      stores: [],
      dateNow: null,
      loading: false,
      filter: {
        dateFrom: null,
        dateTo: null,
        store: "",
        status: "",
      },
    };
  },
  methods: {
    async generate() {
      if (this.filter.dateFrom > this.filter.dateTo) {
        swal.fire("Invalid Date!", "Please check.", "warning");
      } else {
        const res = await axios.get("api/transactions/report", {
          params: this.filter,
        });
        this.transactions = res.data;
      }
    },
    async getStores() {
      const res = await axios.get("api/stores");
      this.stores = res.data;
    },
  },
  mounted() {
    this.getStores();
    this.filter.dateFrom = moment(this.$root.serverDateTime).format(
      "YYYY-MM-DD"
    );
    this.filter.dateTo = moment(this.$root.serverDateTime).format("YYYY-MM-DD");
    this.dateNow = moment(this.$root.serverDateTime).format("LLLL");
  },
};
</script>

<style lang="scss" scoped></style>
