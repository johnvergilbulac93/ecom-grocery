<template>
  <div class="container">
    <div class="row mt-1">
      <div class="col-md-3">
        <div class="form-group">
          <label for="type">Report Type</label>
          <select class="form-control form-control-sm" v-model="filter.type">
            <option value="">Select Report Type</option>
            <option value="DETAILED">DETAILED</option>
            <option value="SUMMARY">SUMMARY</option>
          </select>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="store">Store</label>&nbsp;
          <select
            class="form-control form-control-sm"
            v-model="filter.store"
            tabindex="1"
            @change="clearData"
          >
            <option value="">Select Store</option>
            <option value="all">ALL STORE</option>
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
      <!-- <div class="col-sm-2">
        <div class="form-group">
          <label for="status">Status</label>&nbsp;
          <select
            class="form-control form-control-sm"
            tabindex="2"
            v-model="filter.status"
            @change="clearData"
          >
            <option value="">Select Status</option>
            <option value="1">Remitted</option>
            <option value="2">Cancelled</option>
          </select>
        </div>
      </div> -->
      <div class="col-md-2">
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
      <div class="col-md-2">
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
      <div class="col-md-2">
        <div class="row">
          <div class="col-sm-6">
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
          <div class="col-sm-6">
            <button
              class="btn btn-success btn-sm btn-block mt-4"

              @click="printBtn()"
            >
              <i class="fas fa-print"></i>
              Print
            </button>
          </div>
        </div>
      </div>
    </div>
    <hr class="mt-1" />
    <div id="section-to-print" class="mt-4">
      <div class="container" v-if="transactions.b_unit != null">
        <div class="row">
          <div class="col-sm-12">
            <center class="p-4">
              <!-- <img
                alt="logo"
                :src="$root.logo_path + '' + transactions.b_unit.logo"
                style="width: 220px; height: 150px; object-fit: contain"
              /> -->
              <h4 class="font-weight-bold">
                {{
                  transactions.hasOwnProperty("b_unit") &&
                  transactions.b_unit.business_unit
                }}
              </h4>
              <h5>ALTURUSH GOODS ORDERING</h5>
              <h6 class="lead">
                TOTAL ORDERS REPORT(<span class="text-danger">{{
                  filter.type
                }}</span
                >)
              </h6>
              <span class="text-center font-semibold text-gray-500"
                >{{ filter.dateFrom | formatDateNoTime }} To
                {{ filter.dateTo | formatDateNoTime }}
              </span>
            </center>
          </div>
          <div class="container" v-if="filter.store != 'all'">
            <table class="table table-bordered table-sm mt-1">
              <thead>
                <tr>
                  <th>DATE</th>
                  <th>CUSTOMER</th>
                  <th>TRANSACTION #</th>
                  <th class="text-right">TOTAL AMOUNT</th>
                </tr>
              </thead>
              <tbody>
                <tr v-if="!transactions.data.length">
                  <td colspan="4" class="text-center">NO DATA AVAILABLE</td>
                </tr>
                <tr v-for="(trans, i) in transactions.data" :key="i">
                  <td>
                    {{ trans.order_pickup | formatDateNoTime }}
                  </td>
                  <td>{{ trans.customer }}</td>
                  <td>{{ trans.receipt }}</td>
                  <td class="text-right">
                    {{ parseFloat(totalAmount(trans)) | toCurrency }}
                  </td>
                </tr>
                <tr
                  v-if="
                    transactions.hasOwnProperty('data') &&
                    transactions.data.length
                  "
                >
                  <td
                    colspan="2"
                    class="font-weight-bold text-right text-primary"
                  >
                    GRAND TOTAL :
                  </td>
                  <td>{{ totalTransaction }}</td>
                  <td colspan="2" class="text-right font-weight-bold">
                    {{ orderSummary.lessDiscount | toCurrency }}
                  </td>
                </tr>
              </tbody>
            </table>
            <span class="float-left" v-if="transactions.data.length"
              >Run Time: {{ dateNow }}</span
            >
          </div>
          <!-- <div class="container">
            <table>
              <thead>
                <tr>
                  <th>DATE</th>
                  <th>CUSTOMER</th>
                  <th>TRANSACTION #</th>
                  <th class="text-right">TOTAL AMOUNT</th>
                </tr>
              </thead>
            </table>
          </div> -->
          <!-- <div class="container">
            <span class="mt-2 font-weight-bold">STATUS:</span>
            <span class="text-primary">CANCELLED</span>
            <table class="table table-bordered table-sm mt-1">
              <thead>
                <tr>
                  <th>DATE</th>
                  <th>CUSTOMER</th>
                  <th>TICKET #</th>
                  <th class="text-right">TOTAL AMOUNT</th>
                </tr>
              </thead>
              <tbody>
                <tr v-if="!transactions.data.length">
                  <td colspan="4" class="text-center">NO DATA AVAILABLE</td>
                </tr>
                <tr v-for="(trans, i) in transactions.data" :key="i">
                  <td>
                    {{
                      trans.final_order_status[0].cancelled_at
                        | formatDateNoTime
                    }}
                  </td>
                  <td>{{ trans.customer }}</td>
                  <td>{{ trans.ticket }}</td>
                  <td class="text-right">
                    {{ parseFloat(totalAmountCancel(trans)) | toCurrency }}
                  </td>
                </tr>
                <tr
                  v-if="
                    transactions.hasOwnProperty('data') &&
                    transactions.data.length
                  "
                >
                  <td
                    colspan="2"
                    class="font-weight-bold text-right text-primary"
                  >
                    GRAND TOTAL :
                  </td>
                  <td>{{ totalTransaction }}</td>
                  <td colspan="2" class="text-right font-weight-bold">
                    {{ orderSummaryCancelled.lessDiscount | toCurrency }}
                  </td>
                </tr>
              </tbody>
            </table>
            <span class="float-left" v-if="transactions.data.length"
              >Run Time: {{ dateNow }}</span
            >
          </div> -->
        </div>
      </div>
      <div
        class="container"
        v-if="transactions.data != null || filter.store === 'all'"
      >
        <div class="row">
          <div class="col-sm-12">
            <center class="p-4">
              <!-- <img
                alt="logo"
                :src="$root.logo_path + '' + transactions.b_unit.logo"
                style="width: 220px; height: 150px; object-fit: contain"
              /> -->
              <h4 class="font-weight-bold">ALL STORES</h4>
              <h5>ALTURUSH GOODS ORDERING</h5>
              <h6 class="lead">
                TOTAL ORDERS REPORT(<span class="text-danger">{{
                  filter.type
                }}</span
                >)
              </h6>
              <span class="text-center font-semibold text-gray-500"
                >{{ filter.dateFrom | formatDateNoTime }} To
                {{ filter.dateTo | formatDateNoTime }}
              </span>
            </center>
          </div>
          <div class="container" v-for="(bu, i) in groupByStore" :key="i">
            <span class="font-weight-bold text-primary">{{ bu }}</span>
            <table class="table table-bordered table-sm mt-1">
              <thead>
                <tr>
                  <th>DATE</th>
                  <th>CUSTOMER</th>
                  <th>TRANSACTION #</th>
                  <th class="text-right">TOTAL AMOUNT</th>
                </tr>
              </thead>
              <tbody>
                <tr v-if="!transactions.length">
                  <td colspan="4" class="text-center">NO DATA AVAILABLE</td>
                </tr>
                <tr
                  v-for="(data, innerIndex) in finalData(bu)"
                  :key="innerIndex"
                >
                  <td>{{ data.order_pickup | formatDateNoTime }}</td>
                  <td>{{ data.customer }}</td>
                  <td></td>
                  <td></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
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
      totalTransaction: null,
      filter: {
        dateFrom: null,
        dateTo: null,
        store: "",
        type: "",
      },
      groups: [],
    };
  },
  computed: {
    groupByStore() {
      const Bystore = new Set();
      this.transactions.forEach((trans) => Bystore.add(trans.business_unit));
      return Array.from(Bystore);
      // console.log(sample);
    },
    transactionByDate() {
      let self = this;
      this.groups = _.groupBy(self.transactions.data, function (d) {
        return (newdate = moment(d.updated_at).year());
      });
    },
    orderSummaryCancelled() {
      let grandTotal = 0,
        pickupCharge = 0,
        orderAmount = 0,
        discount = 0,
        lessDiscount = 0;

      this.transactions.data.forEach((transaction) => {
        pickupCharge += parseFloat(
          transaction.customer_bill[0].delivery_charge
        );
        if (
          transaction.hasOwnProperty("final_orders") &&
          transaction.final_orders
        ) {
          transaction.final_orders
            .filter(
              (order) =>
                order.canceled_status === 0 || order.canceled_status === 1
            )
            .forEach((order) => {
              orderAmount += parseFloat(order.total_price);
            });
        }
      });
      lessDiscount = orderAmount - discount;
      grandTotal = orderAmount - discount + pickupCharge;
      return {
        grandTotal,
        orderAmount,
        discount,
        pickupCharge,
        lessDiscount,
      };
    },
    orderSummary() {
      let grandTotal = 0,
        pickupCharge = 0,
        orderAmount = 0,
        discount = 0,
        lessDiscount = 0;

      this.transactions.data.forEach((transaction) => {
        pickupCharge += parseFloat(
          transaction.customer_bill[0].delivery_charge
        );
        if (
          transaction.hasOwnProperty("final_orders") &&
          transaction.final_orders
        ) {
          transaction.final_orders
            .filter((order) => order.canceled_status === 0)
            .forEach((order) => {
              orderAmount += parseFloat(order.total_price);
            });
        }
        if (
          transaction.hasOwnProperty("discount_amount") &&
          transaction.discount_amount
        ) {
          transaction.discount_amount.forEach((order) => {
            discount += parseFloat(order.discount);
          });
        }
      });
      lessDiscount = orderAmount - discount;
      grandTotal = orderAmount - discount + pickupCharge;
      return {
        grandTotal,
        orderAmount,
        discount,
        pickupCharge,
        lessDiscount,
      };
    },
  },
  methods: {
    finalData(store) {
      return this.transactions.filter((bu) => bu.business_unit === store);
      // .map((bu) => bu.model);
    },
    clearData() {
      this.transactions = [];
    },
    printBtn() {
      window.print();
    },
    totalAmount(orders) {
      let total = 0,
        orderedAmount = 0,
        discountAmount = 0,
        pickingCharge = 0;

      const uncancelledORders = orders.final_orders.filter(
        (order) => order.canceled_status === 0
      );

      uncancelledORders.forEach(
        (order) => (orderedAmount += parseFloat(order.total_price))
      );

      orders?.discount_amount?.forEach(
        (order) => (discountAmount += parseFloat(order.discount))
      );

      orders?.customer_bill?.forEach(
        (order) => (pickingCharge += parseFloat(order.delivery_charge))
      );

      // total = orderedAmount - discountAmount + pickingCharge
      total = orderedAmount - discountAmount;
      return parseFloat(total).toFixed(2);
    },

    totalAmountCancel(orders) {
      let total = 0,
        orderedAmount = 0,
        discountAmount = 0,
        pickingCharge = 0;

      const uncancelledORders = orders.final_orders.filter(
        (order) => order.canceled_status === 0 || order.canceled_status === 1
      );

      uncancelledORders.forEach(
        (order) => (orderedAmount += parseFloat(order.total_price))
      );

      orders?.discount_amount?.forEach(
        (order) => (discountAmount += parseFloat(order.discount))
      );

      orders?.customer_bill?.forEach(
        (order) => (pickingCharge += parseFloat(order.delivery_charge))
      );

      // total = orderedAmount - discountAmount + pickingCharge
      total = orderedAmount - discountAmount;
      return parseFloat(total).toFixed(2);
    },
    async generate() {
      if (this.filter.dateFrom > this.filter.dateTo) {
        swal.fire("Invalid Date!", "Please check.", "warning");
      } else {
        const res = await axios.get("api/transactions/report", {
          params: this.filter,
        });
        this.transactions = res.data.data;
        this.totalTransaction = res.data.data.length;

        //         const filterDate = _.groupBy(this.transactions.data, 'updated_at')
        //
        // console.log(filterDate);
        //         let self = this;
        //         const newData = _.groupBy(self.transactions.data.update, function (d) {
        //           // console.log(moment(d.updated_at).month());
        //           return moment(d.updated_at).month();
        //         });
        //
        //         // var result = [];
        //         Object.keys(newData).forEach((key) => {
        //           console.log(newData[key]);
        //           // this.groups.push(...newData[key]);
        //         });

        // console.log(result);
        // console.log(Object.keys(newData))
        // this.groups = newData;
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
