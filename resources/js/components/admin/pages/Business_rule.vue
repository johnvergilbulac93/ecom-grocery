<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-4 mt-2">
        <div class="card">
          <div class="card-header">
            <h5>Minimum Order Amount</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label for=""> Amount</label>
                  <input
                    type="number"
                    v-model="form.min_amount"
                    placeholder="0.00"
                    class="form-control form-control-sm"
                    :class="{ 'is-invalid': form.errors.has('min_amount') }"
                  />
                  <has-error :form="form" field="min_amount"></has-error>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <input
              type="button"
              class="btn btn-primary btn-sm float-right"
              value="Save"
              @click="minAmount"
            />
          </div>
        </div>
      </div>

      <div class="col-md-4 mt-2">
        <div class="card">
          <div class="card-header">
            <h5>Pick-Up Charge</h5>
          </div>

          <div class="card-body">
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="">Amount</label>
                  <input
                    type="number"
                    v-model="form.pickup_charge"
                    class="form-control form-control-sm"
                    placeholder="0.00"
                    :class="{ 'is-invalid': form.errors.has('pickup_charge') }"
                  />
                  <has-error :form="form" field="pickup_charge"></has-error>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <input
              type="button"
              class="btn btn-primary btn-sm float-right"
              value="Save"
              @click="chargeAmount"
            />
          </div>
        </div>
      </div>

      <div class="col-md-4 mt-2">
        <div class="card">
          <div class="card-header">
            <h5>Ordering Time Cut-off</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="">Time Start</label>
                  <input
                    v-model="form.order_time_cutoff_start"
                    type="time"
                    name="order_time_cutoff_start"
                    id="order_time_cutoff"
                    :class="{
                      'is-invalid': form.errors.has('order_time_cutoff_start'),
                    }"
                    class="form-control form-control-sm"
                  />
                  <has-error :form="form" field="order_time_cutoff_start"></has-error>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="">Time End</label>
                  <input
                    v-model="form.order_time_cutoff_end"
                    type="time"
                    name="order_time_cutoff_end"
                    id="order_time_cutoff"
                    :class="{
                      'is-invalid': form.errors.has('order_time_cutoff_end'),
                    }"
                    class="form-control form-control-sm"
                  />
                  <has-error :form="form" field="order_time_cutoff_end"></has-error>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <input
              type="button"
              class="btn btn-primary btn-sm float-right"
              value="Save"
              @click="ordertimeCutoff"
            />
          </div>
        </div>
      </div>

      <div class="col-md-4 mt-2">
        <div class="card">
          <div class="card-header">
            <h5>Serving Time</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="">Time Start</label>
                  <input
                    v-model="form.time_start_cutoff"
                    type="time"
                    name="time_start_cutoff"
                    id="time_start_cutoff"
                    class="form-control form-control-sm"
                    :class="{
                      'is-invalid': form.errors.has('time_start_cutoff'),
                    }"
                  />
                  <has-error :form="form" field="time_start_cutoff"></has-error>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="">Time End</label>
                  <input
                    v-model="form.time_end_cutoff"
                    type="time"
                    name="time_end_cutoff"
                    id="time_end_cutoff"
                    class="form-control form-control-sm"
                    :class="{
                      'is-invalid': form.errors.has('time_end_cutoff'),
                    }"
                  />
                  <has-error :form="form" field="time_end_cutoff"></has-error>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <input
              type="button"
              class="btn btn-primary btn-sm float-right"
              value="Save"
              @click="servingTime"
            />
          </div>
        </div>
      </div>

      <div class="col-md-4 mt-2">
        <div class="card">
          <div class="card-header">
            <h5>Maximum no. of order</h5>
          </div>

          <div class="card-body">
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="">Maximum no. of order</label>
                  <input
                    type="number"
                    v-model="form.max_no_order"
                    name="amount"
                    class="form-control form-control-sm"
                    placeholder="Enter maximum order..."
                  />
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <input
              type="button"
              class="btn btn-primary btn-sm float-right"
              value="Save"
              @click="maxOrder"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Form from "vform";
export default {
  data() {
    return {
      form: new Form({
        min_amount: "",
        pickup_charge: "",
        order_time_cutoff_start: "",
        order_time_cutoff_end: "",
        time_start_cutoff: "",
        time_end_cutoff: "",
        max_no_order: "",
      }),
    };
  },
  methods: {
    async loadSetup() {
      const { data } = await axios.get("api/setup_rules");
      this.form.min_amount = parseFloat(data[0].minimum_order_amount);
      this.form.pickup_charge = parseFloat(data[0].pickup_charge);
      this.form.order_time_cutoff_start = data[0].ordering_cutoff_time_start;
      this.form.order_time_cutoff_end = data[0].ordering_cutoff_time_end;
      this.form.time_start_cutoff = data[0].serving_time_start;
      this.form.time_end_cutoff = data[0].serving_time_end;
      this.form.max_no_order = data[0].maximum_no_of_orders;
    },
    minAmount(id) {
      this.form
        .put("api/min_order_amount/" + 1)
        .then(() => {
          this.form.min_amount = "";
          toast.fire({
            icon: "success",
            title: "Success",
            text: "Successfully saved",
          });
          Fire.$emit("refresh_setup");
        })
        .catch(() => {});
    },
    chargeAmount() {
      this.form
        .put("api/pickup_charge/" + 1)
        .then(() => {
          this.form.pickup_charge = "";
          toast.fire({
            icon: "success",
            title: "Success",
            text: "Successfully saved",
          });
          Fire.$emit("refresh_setup");
        })
        .catch(() => {});
    },
    ordertimeCutoff() {
      this.form
        .put("api/order_time_cutoff/" + 1)
        .then(() => {
          this.form.order_time_cutoff_start = "";
          this.form.order_time_cutoff_end = "";
          toast.fire({
            icon: "success",
            title: "Success",
            text: "Successfully saved",
          });
          Fire.$emit("refresh_setup");
        })
        .catch(() => {});
    },
    servingTime() {
      this.form
        .put("api/serving_time/" + 1)
        .then(() => {
          this.form.time_start_cutoff = "";
          this.form.time_end_cutoff = "";
          toast.fire({
            icon: "success",
            title: "Success",
            text: "Successfully saved",
          });
          Fire.$emit("refresh_setup");
        })
        .catch(() => {
          toast.fire({
            icon: "warning",
            title: "Warning",
            text: "Something went wrong",
          });
        });
    },
    maxOrder() {
      this.form
        .put("api/max_order/" + 1)
        .then(() => {
          this.form.max_no_order = "";
          toast.fire({
            icon: "success",
            title: "Success",
            text: "Successfully saved",
          });
          Fire.$emit("refresh_setup");
        })
        .catch(() => {
          toast.fire({
            icon: "warning",
            title: "Warning",
            text: "Something went wrong",
          });
        });
    },
    customerPickup() {
      this.form.put("api/customer_pickup_time/" + 1).then(() => {
        this.form.pickup_charge = "";
        toast.fire({
          icon: "success",
          title: "Success",
          text: "Successfully saved",
        });
        Fire.$emit("refresh_setup");
      });
    },
  },
  created() {
    this.loadSetup();
    Fire.$on("refresh_setup", () => {
      this.loadSetup();
    });
  },
};
</script>
