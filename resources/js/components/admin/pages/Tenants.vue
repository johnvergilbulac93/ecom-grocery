<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4>Tenants</h4>
          </div>

          <div class="card-body">

            <div class="table-responsive">
                          <button
              class="btn-block btn btn-primary btn-sm mb-1"
              @click="showAddModalTenant()"
              data-toggle="tooltip"
              data-placement="bottom"
              title="Add tenant"
            >
              <i class="fas fa-folder-plus"></i>
              ADD
            </button>
              <table class="table custom-table table-sm">
                <thead id="header-table">
                  <tr>
                    <th style="width: 50px"></th>
                    <th>Store</th>
                    <th>Tenant</th>
                    <th style="width: 50px"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="(data, i) in tenants.data"
                    :key="i"
                    @mouseover="selected(data)"
                    @mouseleave="unSelected()"
                    class="tr-hover"
                  >
                    <td style="width: 50px">
                      <a
                        @click="deleteTenant(data.tenant_id)"
                        data-toggle="tooltip"
                        data-placement="bottom"
                        title="Delete data"
                        v-if="data === selectedData"
                      >
                        <i class="fas fa-trash-alt text-danger"></i>
                      </a>
                    </td>
                    <td>{{ data.business_unit }}</td>
                    <td>{{ data.name }}</td>
                    <td style="width: 50px">
                      <a
                        @click="showEditModalTenant(data)"
                        data-toggle="tooltip"
                        data-placement="bottom"
                        title="Show/Edit this tenant"
                        v-if="data === selectedData"
                      >
                        <i class="far fa-edit text-primary"></i>
                      </a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer">
            <!-- <pagination :data="tenants" @pagination-change-page="loadTenant"></pagination> -->
            <pagination
              :data="tenants"
              @pagination-change-page="loadTenant"
              :limit="-1"
            >
              <span slot="prev-nav"><i class="fas fa-chevron-left"></i></span>
              <span slot="next-nav"><i class="fas fa-chevron-right"></i></span>
            </pagination>
          </div>
        </div>
      </div>
    </div>
    <!-- modal tenants edit-->
    <div
      class="modal fade"
      id="tenant"
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
            <h5 class="modal-title" id="tenant">
              <h4 v-show="!editMode" class="lead">&nbsp;ADD TENANT</h4>
              <h4 v-show="editMode" class="lead">&nbsp;EDIT TENANT</h4>
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
          <form
            v-on:submit.prevent="editMode ? updateTenant() : createTenant()"
          >
            <div class="modal-body">
              <div class="form-group">
                <label for="Select Store">Select Store</label>
                <select
                  class="form-control form-control-sm"
                  v-model="form.store"
                  tabindex="1"
                  :class="{ 'is-invalid': form.errors.has('store') }"
                >
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
                <label for="department">Department Name</label>
                <select
                  class="form-control form-control-sm"
                  v-model="form.department"
                  tabindex="2"
                  :class="{ 'is-invalid': form.errors.has('department') }"
                >
                  <option
                    :value="dept.dept_id"
                    v-for="(dept, i) in departments"
                    :key="i"
                  >
                    {{ dept.name }}
                  </option>
                </select>
                <has-error :form="form" field="department"></has-error>
              </div>
              <div class="form-group">
                <label for="Select Store">Tenant Status</label>
                <select
                  class="form-control form-control-sm"
                  v-model="form.status"
                  tabindex="3"
                  :class="{ 'is-invalid': form.errors.has('status') }"
                >
                  <option value="0">Inactive</option>
                  <option value="1">Active</option>
                </select>
                <has-error :form="form" field="status"></has-error>
              </div>
              <!-- <div class="form-group">
                <label for="Logo">Logo</label>
              </div>
              <div class="custom-file">
                <input type="file" class="custom-file-input" ref="image" />
                <label class="custom-file-label" for="customFile">Choose file</label>
              </div> -->
            </div>

            <div class="modal-footer">
              <input
                type="button"
                class="btn btn-secondary btn-sm"
                data-dismiss="modal"
                value="Close"
                tabindex="4"
              />
              <button tabindex="4" type="submit" class="btn btn-primary btn-sm">
                Submit
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- /.modal tenants time -->
  </div>
</template>

<script>
import Form from "vform";

export default {
  name: "Tenants",
  data() {
    return {
      editMode: false,
      tenants: {},
      stores: [],
      departments: [],
      selectedData: false,
      form: new Form({
        id: "",
        store: "",
        department: "",
        status: "",
        logo: "",
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
    deleteTenant(id) {
      swal
        .fire({
          title: "Confirmation",
          text: "Are you sure you want to delete this tenant?",
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
              url: "api/tenant/delete/" + id,
            }).then(() => {
              Fire.$emit("reload");
              swal.fire("success", "Successfully Deleted", "success");
            });
          }
        });
    },
    showAddModalTenant() {
      this.editMode = false;
      this.form.clear();
      this.form.reset();
      $("#tenant").modal("show");
    },
    showEditModalTenant(data) {
      this.editMode = true;
      this.form.clear();
      this.form.reset();
      this.form.id = data.tenant_id;
      this.form.store = data.bunit_code;
      this.form.department = data.dept_id;
      this.form.status = data.status;
      $("#tenant").modal("show");
    },
    createTenant() {
      this.form.post("api/tenant/create").then((response) => {
        if (response.data.error === true) {
          $("#tenant").modal("hide");
          swal.fire("Double Entry", "Please check your data.", "warning");
          
        }
        if (response.data.error === false) {
          $("#tenant").modal("hide");
          Fire.$emit("reload");
        }
      });
    },
    updateTenant() {
      this.form
        .put("api/tenant/edit/" + this.form.id)
        .then(() => {
          $("#tenant").modal("hide");
          Fire.$emit("reload");
        })
        .catch(() => {});
    },
    loadTenant(page = 1) {
      axios.get("api/tenants?page=" + page).then((response) => {
        this.tenants = response.data;
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
    this.loadTenant();
    this.getDepartments();
    Fire.$on("reload", () => {
      this.loadTenant();
    });
  },
};
</script>
