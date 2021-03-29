<template>
  <div class="container">
    <div class="d-flex justify-content-between mt-1">
      <div class="d-flex">
        <div class="form-inline mx-2">
          <div class="form-group">
            <label for="store" class="form-label">Store:</label> &nbsp;
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
        <div class="form-inline mx-2">
          <div class="form-group">
            <label for="from">Date From:</label>&nbsp;
            <input
              type="date"
              class="form-control form-control-sm"
              tabindex="2"
              v-model="filter.dateFrom"
            />
          </div>
        </div>
        <div class="form-inline mx-2">
          <div class="form-group">
            <label for="from">Date To:</label>&nbsp;
            <input
              type="date"
              class="form-control form-control-sm"
              tabindex="3"
              v-model="filter.dateTo"
            />
          </div>
        </div>
      </div>
      <div class="d-flex">
        <button
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
        </button>
      </div>
    </div>
    <hr class="mt-1" />
    <div id="section-to-print" class="mt-2">
      <div class="container" v-if="transactions.b_unit != null">
        <div class="row">
          <div class="col-sm-12">
            <center>
              <!-- <img
                alt="logo"
                :src="$root.logo_path + '' + transactions.b_unit.logo"
                style="width: 220px; height: 150px; object-fit: contain"
              /> -->
              <h4>
                {{
                  transactions.hasOwnProperty("b_unit") &&
                  transactions.b_unit.business_unit
                }}
              </h4>
              <h6>ALTURUSH GOODS ORDERING</h6>
              <h6 class="">ACCOUNTABILITY REPORT</h6>
              <span class="text-center font-semibold text-gray-500"
                >{{ filter.dateFrom | formatDateNoTime }} To
                {{ filter.dateTo | formatDateNoTime }}
              </span>
            </center>
          </div>
          <table class="table table-bordered table-sm mt-2">
            <thead>
              <tr>
                <th>CASHIER</th>
                <th>TICKET #</th>
                <th>TRANSACTION #</th>
                <th class="text-right">NET AMOUNT</th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="!transactions.data.length">
                <td colspan="5" class="text-center">NO DATA AVAILABLE</td>
              </tr>
              <tr v-for="(trans, i) in transactions.data" :key="i">
                <td>{{ trans.cashier_monitoring[0].name }}</td>
                <td>{{ trans.ticket }}</td>
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
                <td colspan="5" class="font-weight-bold text-center">
                  SUMMARY
                </td>
              </tr>
              <tr
                v-if="
                  transactions.hasOwnProperty('data') &&
                  transactions.data.length
                "
              >
                <td colspan="2"></td>
                <td class="font-weight-bold text-right text-primary">
                  SUB TOTAL :
                </td>
                <td colspan="2" class="text-right font-weight-bold">
                  {{ orderSummary.lessDiscount | toCurrency }}
                </td>
              </tr>
              <tr
                v-if="
                  transactions.hasOwnProperty('data') &&
                  transactions.data.length
                "
              >
                <td colspan="2"></td>
                <td class="font-weight-bold text-right text-primary">
                  TOTAL PICKING CHARGE :
                </td>
                <td colspan="2" class="text-right font-weight-bold">
                  {{ orderSummary.pickupCharge | toCurrency }}
                </td>
              </tr>
              <tr
                v-if="
                  transactions.hasOwnProperty('data') &&
                  transactions.data.length
                "
              >
                <td colspan="2"></td>
                <td class="font-weight-bold text-right text-primary">
                  GRAND TOTAL :
                </td>
                <td colspan="2" class="text-right font-weight-bold">
                  {{ orderSummary.grandTotal | toCurrency }}
                </td>
              </tr>
            </tbody>
          </table>
          <span class="float-right">Run Time: {{ dateNow }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Accountability",
  data() {
    return {
      transactions: [],
      stores: [],
      logo: null,
      dateNow: null,
      filter: {
        dateFrom: null,
        dateTo: null,
        store: "",
      },
    };
  },
  computed: {
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
    lessDiscount(orders) {
      let orderedAmount = 0,
        discountAmount = 0,
        lessDiscount = 0;

      const uncancelledORders = orders.final_orders.filter(
        (order) => order.canceled_status === 0
      );

      uncancelledORders.forEach(
        (order) => (orderedAmount += parseFloat(order.total_price))
      );

      orders?.discount_amount?.forEach(
        (order) => (discountAmount += parseFloat(order.discount))
      );

      lessDiscount = orderedAmount - discountAmount;

      return lessDiscount;
    },
    orderedAmount(orders) {
      let orderedAmount = 0;
      const uncancelledORders = orders.final_orders.filter(
        (order) => order.canceled_status === 0
      );

      uncancelledORders.forEach(
        (order) => (orderedAmount += parseFloat(order.total_price))
      );
      return orderedAmount;
    },
    discountAmount(orders) {
      let discountAmount = 0;
      orders?.discount_amount?.forEach(
        (order) => (discountAmount += parseFloat(order.discount))
      );
      return discountAmount;
    },
    async generate() {
      if (this.filter.dateFrom > this.filter.dateTo) {
        swal.fire("Invalid Date!", "Please check.", "warning");
      } else {
        const res = await axios.get("api/accountability/report", {
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


