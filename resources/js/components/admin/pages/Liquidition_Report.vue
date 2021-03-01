<template>
  <div class="container-fluid">
    <div class="row mt-1">
      <div class="col-3">
        <div class="form-inline">
          <div class="form-group">
            <label for="store" class="form-label">Store:</label> &nbsp;
            <select class="form-control form-control-sm" v-model="filter.store">
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
      </div>
      <div class="col-3">
        <div class="form-inline">
          <div class="form-group">
            <label for="from">Date From:</label>&nbsp;
            <input
              type="date"
              class="form-control form-control-sm"
              tabindex="1"
              v-model="filter.dateFrom"
            />
          </div>
        </div>
      </div>
      <div class="col-3">
        <div class="form-inline">
          <div class="form-group">
            <label for="from">Date To:</label>&nbsp;
            <input
              type="date"
              class="form-control form-control-sm"
              tabindex="1"
              v-model="filter.dateTo"
            />
          </div>
        </div>
      </div>
      <div class="col-3">
        <button class="btn btn-primary btn-sm" @click="generate()">
          Generate
        </button>
        <button class="btn btn-success btn-sm" @click="generate()" :disabled="">
          Print
        </button>
      </div>
    </div>
    <hr class="mt-1" />



    <!-- The Modal -->
    <div
      class="modal fade"
      id="liquidation"
      data-backdrop="static"
      data-keyboard="false"
    >
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <!-- Modal body -->
          <div id="print-section">
            <div class="modal-body">
              <div class="container">
                <div class="row">
                  <div class="col-md-6 offset-md-3">
                    <div class="row justify-content-center" id="header-image">
                      <div class="col-4" style="margin-right: 50px">
                        <img
                          class="pr-6 mt-2"
                          alt="logo"
                          :src="$root.logo_path + '' + logo"
                          style="
                            width: 220px;
                            height: 150px;
                            object-fit: contain;
                          "
                        />
                      </div>
                    </div>
                    <center>
                      <div id="header-title">
                        <div class="row justify-content-center">
                          <div class="col-6">
                            <h4>
                              {{
                                transactions.hasOwnProperty("b_unit") &&
                                transactions.b_unit.business_unit
                              }}
                            </h4>
                          </div>
                        </div>
                        <div class="row justify-content-center">
                          <div class="col-6">
                            <h4 class="">LIQUIDATION REPORT</h4>
                          </div>
                        </div>
                      </div>
                      <div id="date">
                        <div class="row justify-content-center">
                          <div class="col-6">
                            <span
                              class="text-center font-semibold text-gray-500"
                              >{{ filter.dateFrom | formatDateNoTime }} To
                              {{ filter.dateTo | formatDateNoTime }}</span
                            >
                          </div>
                        </div>
                      </div>
                    </center>
                  </div>
                </div>
                <br />
                <div
                  class=""
                  id="body-content"
                  v-for="(cashier, index) in transactions.cashier_details"
                  :key="index"
                >
                  <table
                    id="table-body-content"
                    class="table table-bordered table-sm"
                  >
                    <thead>
                      <tr>
                        <th>Cashier</th>
                        <th>Date</th>
                        <th>Ticket #</th>
                        <th>Customer</th>
                        <th>Transaction #</th>
                        <th>Gross Amt.</th>
                        <th>Disc.</th>
                        <th>Less Disc.</th>
                        <th>Picking Charge</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(trans, index) in cashier" :key="index">
                        <td>{{ trans.name }}</td>
                        <td>
                          {{
                            trans.final_order_status[0].order_pickup
                              | formatDateNoTime
                          }}
                        </td>
                        <td>
                          {{ trans.tickets[0].ticket }}
                        </td>
                        <td>
                          {{ trans.tickets[0].customer }}
                        </td>
                        <td>
                          {{ trans.tickets[0].receipt }}
                        </td>
                        <td>
                          {{ orderedAmount(trans) | toCurrency }}
                        </td>
                        <td>
                          {{ discountAmount(trans) | toCurrency }}
                        </td>
                        <td>
                          {{ lessDiscount(trans) | toCurrency }}
                        </td>
                        <td>
                          {{
                            parseFloat(trans.customer_bill[0].delivery_charge)
                              | toCurrency
                          }}
                        </td>
                        <td>
                          {{ parseFloat(totalAmount(trans)) | toCurrency }}
                        </td>
                      </tr>
                      <tr class="font-weight-bold">
                        <th colspan="4" class="text-center">
                          <h6>GRAND TOTAL:</h6>
                        </th>
                        <th>{{ cashier.length }}</th>
                        <th>
                          {{
                            totalOrderAmount(cashier).orderAmount | toCurrency
                          }}
                        </th>
                        <th>
                          {{ totalOrderAmount(cashier).discount | toCurrency }}
                        </th>
                        <th>
                          {{
                            totalOrderAmount(cashier).lessDiscount | toCurrency
                          }}
                        </th>
                        <th>
                          {{
                            totalOrderAmount(cashier).pickupCharge | toCurrency
                          }}
                        </th>
                        <th>
                          {{
                            totalOrderAmount(cashier).grandTotal | toCurrency
                          }}
                        </th>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="row" id="runtime">
                  <div class="col-12">
                    <span class="float-right">Run Time: {{ dateNow }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Modal footer -->
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-success btn-sm"
              @click="printBtn()"
            >
              <i class="fas fa-print"></i> Print
            </button>
            <button
              type="button"
              class="btn btn-danger btn-sm"
              data-dismiss="modal"
            >
              Close
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Liquidition-Report",
  data() {
    return {
      total_result: null,
      transactions: [],
      totalTransaction: null,
      stores: [],
      logo: null,
      dateNow: null,
      filter: {
        dateFrom: null,
        dateTo: null,
        store: 1,
      },
    };
  },
  methods: {
    totalOrderAmount(orders) {
      // console.log(orders)

      let pickupCharge = 0,
        orderAmount = 0,
        discount = 0,
        lessDiscount = 0,
        grandTotal = 0;

      orders.forEach((order) => {
        // console.log(order);
        pickupCharge += parseFloat(order.customer_bill[0].delivery_charge);
        if (order.hasOwnProperty("final_orders") && order.final_orders) {
          order.final_orders
            .filter((order) => order.canceled_status === 0)
            .forEach((order) => {
              orderAmount += parseFloat(order.total_price);
            });
        }
        if (order.hasOwnProperty("discount_amount") && order.discount_amount) {
          order.discount_amount.forEach((order) => {
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

      total = orderedAmount - discountAmount + pickingCharge;
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

      orders.discount_amount.forEach(
        (order) => (discountAmount += parseFloat(order.discount))
      );

      lessDiscount = orderedAmount - discountAmount;

      return lessDiscount;
    },
    discountAmount(orders) {
      let discountAmount = 0;
      orders?.discount_amount?.forEach(
        (order) => (discountAmount += parseFloat(order.discount))
      );
      return discountAmount;
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
    printBtn() {
      window.print();
    },
    async generate() {
      // if (this.filter.store == null) {
      //   swal.fire("Warning!", "Please select store.", "warning");
      // } else if (this.filter.dateFrom == null) {
      //   swal.fire("Warning!", "Date From is empty.", "warning");
      // } else if (this.filter.dateTo == null) {
      //   swal.fire("Warning!", "Date To is empty.", "warning");
      // } else {
      //
      // }
      const res = await axios.get("api/liquidation/report", {
        params: this.filter,
      });
      this.transactions = res.data;
      this.totalTransaction = res.data.cashier_details.length;
      // this.totalOrderAmount(res.data.cashier_details);
      this.logo = res.data.b_unit.logo;
      // $("#liquidation").modal("show");
    },
    async getStores() {
      const res = await axios.get("api/stores");
      this.stores = res.data;
    },
  },
  mounted() {
    // this.generate();
    this.getStores();
    this.filter.dateFrom = moment(this.$root.serverDateTime).format(
      "YYYY-MM-DD"
    );
    this.filter.dateTo = moment(this.$root.serverDateTime).format("YYYY-MM-DD");
    this.dateNow = moment(this.$root.serverDateTime).format(
      "MMMM Do YYYY, h:mm:ss a"
    );
  },
};
</script>


