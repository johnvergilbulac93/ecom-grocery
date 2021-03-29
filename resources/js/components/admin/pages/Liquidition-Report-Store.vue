<template>
  <div class="container">
    <div class="d-flex justify-content-between mt-1">
      <div class="d-flex">
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
          :disabled="transactions.cashier_details.length >= 0"
        >
          <i class="fas fa-print"></i>
          Print
        </button>
      </div>
    </div>
    <hr class="mt-1" />
    <div id="section-to-print" class="mt-2">
      <div class="container">
        <div class="row">
          <div class="col-sm-12" v-if="transactions.b_unit != null">
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
              <h6 class="">LIQUIDATION REPORT</h6>
              <span class="text-center font-semibold text-gray-500"
                >{{ filter.dateFrom | formatDateNoTime }} To
                {{ filter.dateTo | formatDateNoTime }}
              </span>
            </center>
          </div>
          <div class="col-sm-12">
            <div
              class="mt-2"
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
                  <tr v-if="!cashier.length">
                    <td colspan="10" class="text-center">NO DATA AVAILABLE</td>
                  </tr>

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
                    <th colspan="4" class="text-primary text-center">
                      GRAND TOTAL:
                    </th>
                    <th>{{ cashier.length }}</th>
                    <th>
                      {{ totalOrderAmount(cashier).orderAmount | toCurrency }}
                    </th>
                    <th>
                      {{ totalOrderAmount(cashier).discount | toCurrency }}
                    </th>
                    <th>
                      {{ totalOrderAmount(cashier).lessDiscount | toCurrency }}
                    </th>
                    <th>
                      {{ totalOrderAmount(cashier).pickupCharge | toCurrency }}
                    </th>
                    <th>
                      {{ totalOrderAmount(cashier).grandTotal | toCurrency }}
                    </th>
                  </tr>
                </tbody>
              </table>
              <span class="text-right">Run Time: {{ dateNow }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Liquidation-Report",
  data() {
    return {
      total_result: null,
      transactions: [],
      totalTransaction: null,
      logo: null,
      dateNow: null,
      filter: {
        dateFrom: null,
        dateTo: null,
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
      if (this.filter.dateFrom > this.filter.dateTo) {
        swal.fire("Invalid Date!", "Please check.", "warning");
      } else {
        const res = await axios.get("api/liquidation/store/report", {
          params: this.filter,
        });
        this.transactions = res.data;
        this.totalTransaction = res.data.cashier_details.length;
      }
    },
  },
  mounted() {
    this.filter.dateFrom = moment(this.$root.serverDateTime).format(
      "YYYY-MM-DD"
    );
    this.filter.dateTo = moment(this.$root.serverDateTime).format("YYYY-MM-DD");
    this.dateNow = moment(this.$root.serverDateTime).format("LLLL");
  },
};
</script>


