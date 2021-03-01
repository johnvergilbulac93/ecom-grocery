<template>
  <div class="container">
    <div class="card">
      <div class="card-header">
        <h4>Minimum Order(Delivery)</h4>
      </div>

      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <button
              class="btn btn-success btn-sm float-right mb-1"
              @click="showAddModalMinimum"
              data-toggle="tooltip"
              data-placement="bottom"
              title="Add data"
            >
              <i class="fas fa-folder-plus"></i>
              Add
            </button>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-hover table-sm">
            <thead>
              <tr>
                <th>STORE</th>
                <th>DEPARTMENT</th>
                <th>AMOUNT</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(min, i) in minimum_amounts"
                :key="i"
                @mouseover="selectedMin(min)"
                @mouseleave="unSelectedMin()"
              >
                <td style="width: 30%">{{ min.business_unit }}</td>
                <td style="width: 30%">{{ min.name }}</td>
                <td style="width: 20%">{{ min.amount }}</td>
                <td style="width: 20%">
                  <button
                    class="btn btn-primary btn-sm"
                    @click="showEditModalMinimum(min)"
                    data-toggle="tooltip"
                    data-placement="bottom"
                    title="Edit/Update Details"
                    v-if="min === selectMin"
                  >
                    <i class="far fa-edit"></i>
                    Edit
                  </button>
                  <button
                    class="btn btn-danger btn-sm"
                    @click="deleteMinAmount(min.min_id)"
                    data-toggle="tooltip"
                    data-placement="bottom"
                    title="Delete data"
                    v-if="min === selectMin"
                  >
                    <i class="fas fa-trash"></i>
                    Delete
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer"></div>
    </div>
    <!-- modal minimum order -->
    <div
      class="modal fade"
      id="minimum"
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
            <h5 class="modal-title" id="minimum">
              <h4 v-show="!editMode" class="lead">&nbsp;Add Minimum Amount</h4>
              <h4 v-show="editMode" class="lead">&nbsp;Edit Minimum Amount</h4>
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form v-on:submit.prevent="editMode ? updateMinimum() : createMinimum()">
            <div class="modal-body">
              <div class="form-group">
                <label for="Select Store">Select Store</label>
                <select
                  class="form-control form-control-sm"
                  v-model="form.store"
                  tabindex="1"
                  :class="{ 'is-invalid': form.errors.has('store') }"
                >
                  <option :value="store.bunit_code" v-for="(store, i) in stores" :key="i">
                    {{ store.business_unit }}
                  </option>
                </select>
                <has-error :form="form" field="store"></has-error>
              </div>
              <div class="form-group">
                <label for="Select Department">Select Department</label>
                <select
                  class="form-control form-control-sm"
                  v-model="form.department"
                  tabindex="2"
                  :class="{ 'is-invalid': form.errors.has('department') }"
                >
                  <option :value="dept.dept_id" v-for="(dept, i) in departments" :key="i">
                    {{ dept.name }}
                  </option>
                </select>
                <has-error :form="form" field="department"></has-error>
              </div>
              <div class="form-group"></div>
              <label for="Minimum Amount">Minimum Amount</label>
              <input
                type="number"
                placeholder="0.00"
                class="form-control form-control-sm"
                v-model="form.amount"
                tabindex="3"
                step="0.00"
                :class="{ 'is-invalid': form.errors.has('amount') }"
              />
              <has-error :form="form" field="amount"></has-error>
            </div>
            <div class="modal-footer">
              <input
                type="button"
                class="btn btn-secondary btn-sm"
                data-dismiss="modal"
                tabindex="4"
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
    <!-- /.modal minimum order -->
  </div>
</template>

<script>
import Form from "vform";

export default {
  name: "Minimum-Order",
  data() {
    return {
      stores: [],
      departments: [],
      minimum_amounts: [],
      editMode: false,
      selectMin: false,
      form: new Form({
        id: "",
        store: "",
        department: "",
        amount: "",
      }),
    };
  },
  props: {},
  methods: {
    deleteMinAmount(id) {
      swal
        .fire({
          title: "Confirmation",
          text: "Are you sure you want to delete this data?",
          icon: "question",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
        })
        .then((result) => {
          if (result.isConfirmed) {
            axios({
              method: "delete",
              url: "api/minimum/amounts/delete/" + id,
            })
              .then(() => {
                Fire.$emit("reload");
                swal.fire("Success", "Successfully Deleted", "success");
              })
              .catch((error) => {
                console.log(error);
              });
          }
        });
    },
    selectedMin(min) {
      this.selectMin = min;
    },
    unSelectedMin() {
      this.selectMin = false;
    },
    showAddModalMinimum() {
      this.editMode = false;
      this.form.clear();
      this.form.reset();
      $("#minimum").modal("show");
    },
    showEditModalMinimum(min) {
      this.editMode = true;
      this.form.clear();
      this.form.reset();
      this.form.id = min.min_id;
      this.form.store = min.bunit_code;
      this.form.department = min.department_id;
      this.form.amount = min.amount;
      $("#minimum").modal("show");
    },
    updateMinimum() {
      this.form.put("api/minimum/amounts/edit/" + this.form.id).then(() => {
        $("#minimum").modal("hide");
        Fire.$emit("reload");
      });
    },
    createMinimum() {
      this.form.post("api/minimum/create").then(() => {
        $("#minimum").modal("hide");
        Fire.$emit("reload");
      });
    },
    getMinimum() {
      axios.get("api/minimum/amounts").then((response) => {
        this.minimum_amounts = response.data.data;
      });
    },
    getStore() {
      axios.get("api/stores").then((response) => {
        this.stores = response.data;
      });
    },
    getDepartments() {
      axios.get("api/departments").then((response) => {
        this.departments = response.data;
      });
    },
  },
  created() {
    this.getStore();
    this.getDepartments();
    this.getMinimum();
    Fire.$on("reload", () => {
      this.getMinimum();
    });
  },
};
</script>
