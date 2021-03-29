<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4>Store Time Set-up</h4>
          </div>

          <div class="card-body">
            <div class="table-responsive">
              <button
                class="btn-block btn btn-primary btn-sm mb-1"
                @click="showAddModalStoreTime()"
                data-toggle="tooltip"
                data-placement="bottom"
                title="Add Store Time"
              >
                <i class="fas fa-folder-plus"></i>
                ADD
              </button>
              <table class="table custom-table table-sm">
                <thead id="header-table">
                  <tr>
                    <th style="width: 40px"></th>
                    <th>Store</th>
                    <th>Opening Time</th>
                    <th>Closing Time</th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="(data, i) in business_units"
                    :key="i"
                    @mouseover="selected(data)"
                    @mouseleave="unSelected()"
                    class="tr-hover"
                  >
                    <td style="width: 40px">
                      <a
                        @click="showEditModalTime(data)"
                        v-if="data === selectedData"
                        data-toggle="tooltip"
                        data-placement="bottom"
                        title="View/Update Details"
                      >
                        <i class="fas fa-info-circle text-primary"></i>
                      </a>
                    </td>
                    <td>{{ data.business_unit }}</td>
                    <td>{{ data.time_in }}</td>
                    <td>{{ data.time_out }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- modal store time-->
    <div
      class="modal fade"
      id="storetime"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
      data-backdrop="static"
      data-keyboard="false"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="storetime">
              <h4 v-show="!editMode" class="lead">&nbsp;ADD STORE TIME</h4>
              <h4 v-show="editMode" class="lead">&nbsp;EDIT STORE TIME</h4>
            </h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form v-on:submit.prevent="editMode ? updateTime() : createTime()">
            <div class="modal-body">
              <div class="form-group">
                <label for="Select Store">Select Store</label>
                <select
                  class="form-control form-control-sm"
                  v-model="form.store"
                  tabindex="1"
                  :class="{ 'is-invalid': form.errors.has('store') }"
                >
                  <option value="">Select Store</option>
                  <option
                    :value="store.bunit_code"
                    v-for="(store, i) in stores"
                    :key="i"
                  >
                    {{ store.business_unit }}
                  </option>
                </select>
                <has-error :form="form" field="store"></has-error>
              </div>
              <div class="form-group">
                <label for="Opening">Opening Time</label>
                <input
                  type="time"
                  class="form-control form-control-sm"
                  tabindex="2"
                  v-model="form.opening_time"
                  :class="{ 'is-invalid': form.errors.has('opening_time') }"
                />
                <has-error :form="form" field="opening_time"></has-error>
              </div>
              <div class="form-group">
                <label for="Closing">Closing Time</label>
                <input
                  type="time"
                  class="form-control form-control-sm"
                  tabindex="3"
                  v-model="form.closing_time"
                  :class="{ 'is-invalid': form.errors.has('closing_time') }"
                />
                <has-error :form="form" field="closing_time"></has-error>
              </div>
            </div>
            <div class="modal-footer">
              <input
                type="button"
                class="btn btn-secondary btn-sm"
                data-dismiss="modal"
                value="Close"
              />
              <button tabindex="4" type="submit" class="btn btn-primary btn-sm">
                Submit
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- /.modal store time -->
  </div>
</template>

<script>
import Form from "vform";

export default {
  name: "Business-Time",
  data() {
    return {
      business_units: [],
      stores: [],
      editMode: false,
      selectedData: false,
      form: new Form({
        id: "",
        store: "",
        opening_time: "",
        closing_time: "",
      }),
    };
  },
  methods: {
    selected(data) {
      this.selectedData = data;
    },
    unSelected() {
      this.selectedData = false;
    },
    loadBu() {
      axios.get("api/business_time").then((response) => {
        this.business_units = response.data;
      });
    },
    getStore() {
      axios.get("api/stores").then((response) => {
        this.stores = response.data;
      });
    },
    showAddModalStoreTime() {
      this.editMode = false;
      this.form.clear();
      this.form.reset();
      $("#storetime").modal("show");
    },
    showEditModalTime(data) {
      this.editMode = true;
      this.form.clear();
      this.form.reset();
      this.form.id = data.id;
      this.form.store = data.bunit_code;
      this.form.opening_time = data.time_in;
      this.form.closing_time = data.time_out;
      $("#storetime").modal("show");
    },
    createTime() {
      this.form
        .post("api/business_time/create")
        .then(() => {
          $("#storetime").modal("hide");
          Fire.$emit("reload");
        })
        .catch(() => {});
    },
    updateTime() {
      this.form.put("api/business_time/edit/" + this.form.id).then(() => {
        $("#storetime").modal("hide");
        Fire.$emit("reload");
      });
    },
  },
  created() {
    this.loadBu();
    this.getStore();
    Fire.$on("reload", () => {
      this.loadBu();
    });
  },
};
</script>
