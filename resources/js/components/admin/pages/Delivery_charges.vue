<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4>Delivery Charges</h4>
          </div>
          <div class="card-body">
            <button
              class="float-right btn btn-success btn-sm mb-1"
              @click="showAddModalDCharge()"
              data-toggle="tooltip"
              data-placement="bottom"
              title="Add Data"
            >
              <i class="fas fa-folder-plus"></i>
              Add
            </button>
            <div class="table-responsive">
              <table class="table table-hover table-sm">
                <thead>
                  <tr>
                    <th>Province</th>
                    <th>Town</th>
                    <th>Barangay</th>
                    <th>Transportation Type</th>
                    <th>Charge Amount</th>
                    <th>Rider Share</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="(data, i) in charges"
                    :key="i"
                    @mouseover="selected(data)"
                    @mouseleave="unSelected()"
                  >
                    <td>{{ data.prov_name }}</td>
                    <td>{{ data.town_name }}</td>
                    <td>{{ data.brgy_name }}</td>
                    <td>{{ data.transpo_name }}</td>
                    <td>{{ data.charge_amt }}</td>
                    <td>{{ data.rider_shared }}</td>
                    <td>
                      <button
                        class="btn btn-danger btn-sm"
                        data-toggle="tooltip"
                        data-placement="bottom"
                        title="Delete data"
                        v-if="data === selectedData"
                        @click="deleteCharges(data.chrg_id, i)"
                      >
                        <i class="right far fa-trash-alt"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="card-footer">
            <pagination
              :pagination="pagination"
              @prev="getCharges(pagination.prevPageUrl)"
              @next="getCharges(pagination.nextPageUrl)"
            ></pagination>
          </div>
        </div>
      </div>
    </div>
    <!-- modal store time-->
    <div
      class="modal fade"
      id="d_charges"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
      data-backdrop="static"
      data-keyboard="false"
    >
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="d_charges">
              <h4 v-show="!editMode" class="lead">&nbsp;Setup Delivery Charges</h4>
              <h4 v-show="editMode" class="lead">&nbsp;Edit Delivery Charges</h4>
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form v-on:submit.prevent="editMode ? updateCharge() : createCharge()">
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="province">Select Province</label>
                    <select
                      class="form-control form-control-sm"
                      v-model="form.province"
                      tabindex="1"
                      :class="{ 'is-invalid': form.errors.has('province') }"
                      @change.prevent="getTown()"
                    >
                      <option value="">Select Province</option>
                      <option
                        :value="prov.prov_id"
                        v-for="(prov, i) in provinces"
                        :key="i"
                      >
                        {{ prov.prov_name }}
                      </option>
                    </select>
                    <has-error :form="form" field="province"></has-error>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="Town">Select Town</label>
                    <select
                      class="form-control form-control-sm"
                      v-model="form.town"
                      tabindex="2"
                      :class="{ 'is-invalid': form.errors.has('town') }"
                      @change.prevent="getBarangay()"
                    >
                      <option value="">Select Town</option>
                      <option :value="town.town_id" v-for="(town, i) in towns" :key="i">
                        {{ town.town_name }}
                      </option>
                    </select>
                    <has-error :form="form" field="town"></has-error>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="brgy">Select Barangay</label>
                    <select
                      class="form-control form-control-sm"
                      v-model="form.barangay"
                      tabindex="3"
                      :class="{ 'is-invalid': form.errors.has('barangay') }"
                    >
                      <option value="">Select Barangay</option>
                      <option
                        :value="brgy.brgy_id"
                        v-for="(brgy, i) in barangays"
                        :key="i"
                      >
                        {{ brgy.brgy_name }}
                      </option>
                    </select>
                    <has-error :form="form" field="barangay"></has-error>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="traspo">Select Transportation Type</label>
                    <select
                      class="form-control form-control-sm"
                      v-model="form.transportation"
                      tabindex="4"
                      :class="{ 'is-invalid': form.errors.has('transpo') }"
                    >
                      <option value="">Select Transportation</option>
                      <option
                        :value="transpo.id"
                        v-for="(transpo, i) in transportations"
                        :key="i"
                      >
                        {{ transpo.transpo_name }}
                      </option>
                    </select>
                    <has-error :form="form" field="transportation"></has-error>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="charge">Delivery Charge</label>
                    <input
                      type="number"
                      class="form-control form-control-sm"
                      placeholder="Enter amount"
                      v-model="form.charge"
                      :class="{ 'is-invalid': form.errors.has('charge') }"
                      tabindex="5"
                    />
                    <has-error :form="form" field="charge"></has-error>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="share">Rider Share</label>
                    <input
                      type="number"
                      class="form-control form-control-sm"
                      placeholder="Enter amount"
                      v-model="form.share"
                      :class="{ 'is-invalid': form.errors.has('share') }"
                      tabindex="6"
                    />
                    <has-error :form="form" field="share"></has-error>
                  </div>
                </div>
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
import Pagination from "./Pagination.vue";

export default {
  name: "Delivery-Charged",
  components: { pagination: Pagination },
  data() {
    return {
      charges: [],
      editMode: false,
      stores: [],
      barangays: [],
      towns: [],
      transportations: [],
      provinces: [],
      perPage: ["10", "25", "50", "100"],
      selectedData: false,
      tableData: {
        draw: 0,
        length: 15,
        search: "",
        column: 1,
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
      form: new Form({
        id: "",
        province: "",
        town: "",
        barangay: "",
        transportation: "",
        charge: "",
        share: "",
      }),
      index: -1,
    };
  },
  methods: {
    deleteCharges(id, index) {
      this.form.delete("api/charges/remove/" + id).then(() => {
        this.charges.splice(index, 1);
      });
    },
    selected(data) {
      this.selectedData = data;
    },
    unSelected() {
      this.selectedData = false;
    },

    clearData() {
      this.getCharges();
      this.tableData.search = "";
    },
    async getTranspo() {
      const { data } = await axios.get("api/transportations");
      this.transportations = data;
    },
    async getProvinces() {
      const { data } = await axios.get("api/province");
      this.provinces = data;
    },
    getTown(url = "api/town") {
      axios.get(url, { params: this.form }).then((response) => {
        this.towns = response.data;
      });
    },
    getBarangay(url = "api/barangay") {
      axios.get(url, { params: this.form }).then((response) => {
        this.barangays = response.data;
      });
    },
    showAddModalDCharge() {
      this.form.clear();
      this.form.reset();
      $("#d_charges").modal("show");
    },
    createCharge() {
      this.form.post("api/create/charge").then((response) => {
        // console.log(response);
        if (response.data.error === true) {
          $("#d_charges").modal("hide");
          swal.fire("Double Entry", "Please check your data.", "warning");
        }
        if (response.data.error === false) {
          $("#d_charges").modal("hide");
          Fire.$emit("reload");
        }
      });
    },
    getCharges(url = "api/show/charges") {
      this.tableData.draw++;
      axios
        .get(url, { params: this.tableData })
        .then((response) => {
          let data = response.data;
          if (this.tableData.draw == data.draw) {
            this.charges = data.data.data;
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
      this.getCharges();
    },
    getIndex(array, key, value) {
      return array.findIndex((i) => i[key] == value);
    },
  },
  created() {
    this.getProvinces();
    this.getTranspo();
    this.getCharges();
    Fire.$on("reload", () => {
      this.getCharges();
    });
  },
};
</script>
