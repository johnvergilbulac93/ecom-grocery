<template>
  <div class="container">
    <div class="row mt-1">
      <div class="col-md-3">
        <div class="form-group">
          <label for="type">Report Type</label>
          <select
            class="form-control form-control-sm"
            v-model="filter.type"
            @change="clearData"
          >
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
              v-if="ArrDataStore.b_unit != null"
              :disabled="orderSummary.gTotalTransaction == 0"
            >
              <i class="fas fa-print"></i>
              Print
            </button>
          </div>
        </div>
      </div>
    </div>
    <hr class="mt-1" />
    <div id="section-to-print" class="mt-2">
      <div class="container" v-if="filter.type === 'DETAILED'">
        <div class="container" v-if="ArrDataStore.b_unit != null">
          <div class="row" v-if="filter.store != 'all'">
            <div class="col-sm-12">
              <center class="p-4">
                <h4>
                  {{
                    ArrDataStore.hasOwnProperty("b_unit") &&
                    ArrDataStore.b_unit.business_unit
                  }}
                </h4>
                <h6>ALTURUSH GOODS ORDERING</h6>
                <h6>
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
            <div class="container">
              <table
                class="table table-bordered table-sm"
                v-for="(byMonth, i) in get_results_by_month"
                :key="i"
              >
                <thead>
                  <tr>
                    <th style="width: 120px">DATE</th>
                    <th style="width: 250px">CUSTOMER</th>
                    <th style="width: 250px">TRANSACTION #</th>
                    <th class="text-right" style="width: 200px">
                      GROSS AMOUNT
                    </th>
                    <th class="text-right" style="width: 200px">
                      PICKING CHARGE
                    </th>
                    <th class="text-right" style="width: 200px">
                      TOTAL AMOUNT
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-if="!byMonth.length">
                    <td colspan="6" class="text-center">NO DATA AVAILABLE</td>
                  </tr>
                  <tr v-for="(trans, innerIndex) in byMonth" :key="innerIndex">
                    <td>
                      {{ trans.order_pickup | formatDateNoTime }}
                    </td>
                    <td>{{ trans.customer }}</td>
                    <td>{{ trans.receipt }}</td>
                    <td class="text-right">
                      {{ orderedAmount(trans) | toCurrency }}
                    </td>
                    <td class="text-right">
                      {{
                        parseFloat(trans.customer_bill[0].delivery_charge)
                          | toCurrency
                      }}
                    </td>
                    <td class="text-right">
                      {{ parseFloat(totalAmount(trans)) | toCurrency }}
                    </td>
                  </tr>
                  <tr
                    v-if="
                      ArrDataStore.hasOwnProperty('data') &&
                      ArrDataStore.data.length
                    "
                  >
                    <td
                      colspan="2"
                      class="font-weight-bold text-right text-primary"
                    >
                      SUB TOTAL
                    </td>
                    <td class="text-center font-weight-bold">
                      {{ byMonth.length }}
                    </td>
                    <td class="text-right font-weight-bold">
                      {{ totalOrderAmount(byMonth).orderAmount | toCurrency }}
                    </td>
                    <td class="text-right font-weight-bold">
                      {{ totalOrderAmount(byMonth).pickupCharge | toCurrency }}
                    </td>
                    <td class="text-right font-weight-bold">
                      {{ totalOrderAmount(byMonth).grandTotal | toCurrency }}
                    </td>
                  </tr>
                </tbody>
              </table>
              <table
                class="table table-bordered table-sm mt-2"
                v-if="orderSummary.gTotalTransaction != 0"
              >
                <thead>
                  <tr>
                    <th colspan="2" style="width: 232px"></th>
                    <th style="width: 180px">TRANSACTION NO</th>
                    <th class="text-right">GROSS AMOUNT</th>
                    <th class="text-right">PICKING CHARGE</th>
                    <th class="text-right">TOTAL AMOUNT</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td
                      colspan="2"
                      class="font-weight-bold text-primary text-center"
                    >
                      GRAND TOTAL
                    </td>
                    <td class="text-center font-weight-bold">
                      {{ orderSummary.gTotalTransaction }}
                    </td>
                    <td class="text-right font-weight-bold">
                      {{ orderSummary.orderAmount | toCurrency }}
                    </td>
                    <td class="text-right font-weight-bold">
                      {{ orderSummary.pickupCharge | toCurrency }}
                    </td>
                    <td class="text-right font-weight-bold">
                      {{ orderSummary.grandTotal | toCurrency }}
                    </td>
                  </tr>
                </tbody>
              </table>
              <span class="float-left" v-if="ArrDataStore.data.length"
                >Run Time: {{ dateNow }}</span
              >
            </div>
          </div>
        </div>
        <div class="container" v-if="ArrDataStore.b_unit != null">
          <div class="row" v-if="filter.store === 'all'">
            <div class="col-sm-12">
              <center class="p-4">
                <h4>ALL STORES</h4>
                <h6>ALTURUSH GOODS ORDERING</h6>
                <h6>
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
            <div class="container">
              <table
                class="table table-bordered table-sm mt-1"
                v-for="(store, i) in get_results_by_store"
                :key="i"
              >
                <thead>
                  <tr>
                    <td colspan="6" class="text-center">
                      <span class="font-weight-bold text-primary p-3">{{
                        store[0].business_unit
                      }}</span>
                    </td>
                  </tr>
                  <tr>
                    <th style="width: 120px">DATE</th>
                    <th style="width: 250px">CUSTOMER</th>
                    <th style="width: 200px">TRANSACTION NO.</th>
                    <th class="text-right" style="width: 200px">
                      GROSS AMOUNT
                    </th>
                    <th class="text-right" style="width: 200px">
                      PICKING CHARGE
                    </th>
                    <th class="text-right" style="width: 200px">
                      TOTAL AMOUNT
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-if="!store.length">
                    <td colspan="6" class="text-center">NO DATA AVAILABLE</td>
                  </tr>
                  <tr v-for="(trans, innerIndex) in store" :key="innerIndex">
                    <td>{{ trans.order_pickup | formatDateNoTime }}</td>
                    <td>{{ trans.customer }}</td>
                    <td>{{ trans.receipt }}</td>
                    <td class="text-right">
                      {{ orderedAmount(trans) | toCurrency }}
                    </td>
                    <td class="text-right">
                      {{
                        parseFloat(trans.customer_bill[0].delivery_charge)
                          | toCurrency
                      }}
                    </td>
                    <td class="text-right">
                      {{ parseFloat(totalAmount(trans)) | toCurrency }}
                    </td>
                  </tr>
                  <tr>
                    <th colspan="2" class="text-center font-weight-bold">
                      SUB TOTAL
                    </th>
                    <td class="text-center font-weight-bold">
                      {{ store.length }}
                    </td>
                    <td class="text-right font-weight-bold">
                      {{ totalOrderAmount(store).orderAmount | toCurrency }}
                    </td>
                    <td class="text-right font-weight-bold">
                      {{ totalOrderAmount(store).pickupCharge | toCurrency }}
                    </td>
                    <td class="text-right font-weight-bold">
                      {{ totalOrderAmount(store).grandTotal | toCurrency }}
                    </td>
                  </tr>
                </tbody>
              </table>
              <table
                class="table table-bordered table-sm mt-2"
                v-if="orderSummary.gTotalTransaction != 0"
              >
                <thead>
                  <tr>
                    <th colspan="2" style="width: 232px"></th>
                    <th style="width: 180px">TRANSACTION NO</th>
                    <th class="text-right">GROSS AMOUNT</th>
                    <th class="text-right">PICKING CHARGE</th>
                    <th class="text-right">TOTAL AMOUNT</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td
                      colspan="2"
                      class="font-weight-bold text-primary text-center"
                    >
                      GRAND TOTAL
                    </td>
                    <td class="text-center font-weight-bold">
                      {{ orderSummary.gTotalTransaction }}
                    </td>
                    <td class="text-right font-weight-bold">
                      {{ orderSummary.orderAmount | toCurrency }}
                    </td>
                    <td class="text-right font-weight-bold">
                      {{ orderSummary.pickupCharge | toCurrency }}
                    </td>
                    <td class="text-right font-weight-bold">
                      {{ orderSummary.grandTotal | toCurrency }}
                    </td>
                  </tr>
                </tbody>
              </table>
              <span class="float-left" v-if="ArrDataStore.data.length"
                >Run Time: {{ dateNow }}</span
              >
            </div>
          </div>
        </div>
      </div>
      <div class="container" v-else>
        <div class="container" v-if="ArrDataStore.b_unit != null">
          <div class="row" v-if="filter.store === 'all'">
            <div class="col-sm-12">
              <center class="p-4">
                <h4>ALL STORES</h4>
                <h6>ALTURUSH GOODS ORDERING</h6>
                <h6>
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
            <div class="container">
              <table class="table table-bordered table-sm mt-1">
                <thead>
                  <tr>
                    <th>STORE NAME</th>
                    <th class="text-center">TOTAL ORDERS</th>
                    <th class="text-right">GROSS AMOUNT</th>
                    <th class="text-right">PICKING CHARGE</th>
                    <th class="text-right">TOTAL</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- <tr v-if="!store.length">
                    <td colspan="6" class="text-center">NO DATA AVAILABLE</td>
                  </tr> -->
                  <tr v-for="(store, i) in get_results_by_store" :key="i">
                    <td>{{ store[0].business_unit }}</td>
                    <td class="text-center">{{ store.length }}</td>
                    <td  class="text-right">
                      {{ totalOrderAmount(store).orderAmount | toCurrency }}
                    </td>
                    <td  class="text-right">
                      {{ totalOrderAmount(store).pickupCharge | toCurrency }}
                    </td>
                    <td  class="text-right">
                      {{ totalOrderAmount(store).grandTotal | toCurrency }}
                    </td>
                  </tr>
                  <tr>
                    <th class="text-center font-weight-bold">GRAND TOTAL</th>
                    <td class="text-center font-weight-bold">
                      {{ orderSummary.gTotalTransaction }}
                    </td>
                    <td class="text-right font-weight-bold">
                      {{ orderSummary.orderAmount | toCurrency }}
                    </td>
                    <td class="text-right font-weight-bold">
                      {{ orderSummary.pickupCharge | toCurrency }}
                    </td>
                    <td class="text-right font-weight-bold">
                      {{ orderSummary.grandTotal | toCurrency }}
                    </td>
                  </tr>
                </tbody>
              </table>
              <span class="float-left" v-if="ArrDataStore.data.length"
                >Run Time: {{ dateNow }}</span
              >
            </div>
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
      ArrDataStore: [],
      stores: [],
      dateNow: null,
      loading: false,
      filter: {
        dateFrom: null,
        dateTo: null,
        store: "",
        type: ""
      }
    };
  },
  computed: {
    get_results_by_store() {
      return _.groupBy(this.ArrDataStore.data, "acroname");
    },
    get_results_by_month() {
      const ArrResultsByMonth = this.ArrDataStore.data;
      const newData = _.groupBy(ArrResultsByMonth, function(d) {
        return moment(d.order_pickup).month();
      });
      return newData;
    },
    orderSummary() {
      let grandTotal = 0,
        pickupCharge = 0,
        orderAmount = 0,
        discount = 0,
        lessDiscount = 0,
        gTotalTransaction = this.ArrDataStore.data.length;

      //       if (this.filter.store === "all") {
      //         Object.keys(ArrGrandTotal).forEach(key => {
      //           // console.log(ArrGrandTotal[key]);
      //           ArrResults.push(...ArrGrandTotal[key]);
      //         });
      this.ArrDataStore.data.forEach(transaction => {
        pickupCharge += parseFloat(
          transaction.customer_bill[0].delivery_charge
        );
        if (
          transaction.hasOwnProperty("final_orders") &&
          transaction.final_orders
        ) {
          transaction.final_orders
            .filter(order => order.canceled_status === 0)
            .forEach(order => {
              orderAmount += parseFloat(order.total_price);
            });
        }
        if (
          transaction.hasOwnProperty("discount_amount") &&
          transaction.discount_amount
        ) {
          transaction.discount_amount.forEach(order => {
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
        gTotalTransaction
      };
    }
  },
  methods: {
    clearData() {
      this.ArrDataStore = [];
    },
    printBtn() {
      if (this.ArrDataStore.data == null) {
        swal.fire("Invalid Date!", "Please check.", "warning");
      } else {
        window.print();
      }
    },
    orderedAmount(orders) {
      let orderedAmount = 0;

      const uncancelledORders = orders.final_orders.filter(
        order => order.canceled_status === 0
      );

      uncancelledORders.forEach(
        order => (orderedAmount += parseFloat(order.total_price))
      );

      return orderedAmount;
    },
    totalOrderAmount(orders) {
      let pickupCharge = 0,
        orderAmount = 0,
        discount = 0,
        lessDiscount = 0,
        grandTotal = 0;
      orders.forEach(order => {
        // console.log(order);
        pickupCharge += parseFloat(order.customer_bill[0].delivery_charge);
        if (order.hasOwnProperty("final_orders") && order.final_orders) {
          order.final_orders
            .filter(order => order.canceled_status === 0)
            .forEach(order => {
              orderAmount += parseFloat(order.total_price);
            });
        }
        if (order.hasOwnProperty("discount_amount") && order.discount_amount) {
          order.discount_amount.forEach(order => {
            discount += parseFloat(order.discount);
          });
        }
      });

      lessDiscount = orderAmount - discount;
      grandTotal = orderAmount - discount + pickupCharge;
      return { grandTotal, orderAmount, discount, pickupCharge, lessDiscount };
    },
    totalAmount(orders) {
      let total = 0,
        orderedAmount = 0,
        discountAmount = 0,
        pickingCharge = 0;
      if (orders.final_orders != null) {
        const uncancelledORders = orders.final_orders.filter(
          order => order.canceled_status === 0
        );

        uncancelledORders.forEach(
          order => (orderedAmount += parseFloat(order.total_price))
        );

        orders?.discount_amount?.forEach(
          order => (discountAmount += parseFloat(order.discount))
        );

        orders?.customer_bill?.forEach(
          order => (pickingCharge += parseFloat(order.delivery_charge))
        );

        total = orderedAmount - discountAmount + pickingCharge;
        return parseFloat(total).toFixed(2);
      }
    },
    async generate() {
      if (this.filter.dateFrom > this.filter.dateTo) {
        swal.fire("Invalid Date!", "Please check.", "warning");
      } else {
        const res = await axios.get("api/transactions/report", {
          params: this.filter
        });
        this.ArrDataStore = res.data;
      }
    },
    async getStores() {
      const res = await axios.get("api/stores");
      this.stores = res.data;
    }
  },
  mounted() {
    this.getStores();
    this.filter.dateFrom = moment(this.$root.serverDateTime).format(
      "YYYY-MM-DD"
    );
    this.filter.dateTo = moment(this.$root.serverDateTime).format("YYYY-MM-DD");
    this.dateNow = moment(this.$root.serverDateTime).format("LLLL");
  }
};
</script>

