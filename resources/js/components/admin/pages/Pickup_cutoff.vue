<template>
  <div class="container">
    <div class="row justify-content-center" v-if="$gate.isAdmin()">
      <div class="col-md-12 mt-2">
        <div class="card">
          <div class="card-header">
            <h5>Customer Pick-up time cut-off</h5>
          </div>

          <div class="card-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="">Set Time Start</label>
                  <input
                    v-model="form.customer_pickup_time_start"
                    type="time"
                    name="customer_pickup_time_start"
                    class="form-control form-control-sm"
                    :class="{
                      'is-invalid': form.errors.has('customer_pickup_time_start'),
                    }"
                  />
                  <has-error :form="form" field="customer_pickup_time_start"></has-error>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="">Set Time End</label>
                  <input
                    v-model="form.customer_pickup_time_end"
                    type="time"
                    name="customer_pickup_time_end"
                    class="form-control form-control-sm"
                    :class="{
                      'is-invalid': form.errors.has('customer_pickup_time_end'),
                    }"
                  />
                  <has-error :form="form" field="customer_pickup_time_end"></has-error>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <input
              type="button"
              class="btn btn-primary btn-sm float-right"
              value="Save"
              @click="updatePickuptime()"
            />
          </div>
        </div>
      </div>
    </div>
    <div v-if="!$gate.isAdmin()">
      <page404></page404>
    </div>
  </div>
</template>

<script>
import Form from "vform";
export default {
  data() {
    return {
      form: new Form({
        id: "",
        customer_pickup_time_start: "",
        customer_pickup_time_end: "",
      }),
    };
  },
  methods: {
    async loadSetup() {
      const { data } = await axios.get("api/gettimepickup");
      this.form.id = data[0].id;
      this.form.customer_pickup_time_start = data[0].start;
      this.form.customer_pickup_time_end = data[0].end;
    },
    updatePickuptime() {
      this.form.put("api/pickuptime_edit/" + this.form.id).then(() => {
        this.form.customer_pickup_time_start = "";
        this.form.customer_pickup_time_end = "";
        toast.fire({
          icon: "success",
          title: "Success",
          text: "Successfully saved",
        });
        Fire.$emit("refresh_time");
      });
    },
  },
  mounted() {
    this.loadSetup();
    Fire.$on("refresh_time", () => {
      this.loadSetup();
    });
  },
};
</script>
