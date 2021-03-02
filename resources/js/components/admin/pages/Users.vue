<template>
  <div class="container-fluid">
    <div class="row" >
      <div class="col-md-12 mb-1 float-right">
        <button
          type="button"
          class="btn btn-success btn-sm float-right"
          value="Add User"
          @click="showAddUserModal()"
        >
          <i class="fas fa-user-plus"></i> Add User
        </button>
      </div>
      <div class="col-md-12">
        <div class="card">
          <!-- /.card-header -->
          <div class="card-header">
            <div class="row">
              <div class="col-sm-6">
                <div class="row">
                  <div class="col-sm-8">
                    <div class="form-group has-search">
                      <span class="fa fa-search form-control-feedback"></span>
                      <input
                        type="text"
                        class="form-control form-control-sm"
                        placeholder="Search"
                        v-model="tableData.search"
                        @keyup.enter="getUsers()"
                      />
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <button
                      class="btn btn-primary btn-sm"
                      @click="getUsers()"
                      v-bind:disabled="tableData.search.length === 0"
                    >
                      Find
                    </button>
                    <button
                      class="btn btn-primary btn-sm"
                      @click="clearData"
                      v-bind:disabled="tableData.search.length === 0"
                    >
                      Clear
                    </button>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <label for="" class="font-light float-right mx-1 mt-1">Entries</label>
                <select
                  v-model="tableData.length"
                  class="form-control form-control-sm float-right"
                  style="width: 110px"
                  @change="getUsers()"
                >
                  <option
                    v-for="(records, index) in perPage"
                    :key="index"
                    :value="records"
                  >
                    {{ records }}
                  </option>
                </select>
                <label for="" class="font-light float-right mx-1 mt-1">Show</label>
              </div>
            </div>
          </div>
          <div class="card-body">
            <datatable
              :columns="columns"
              :sortKey="sortKey"
              :sortOrders="sortOrders"
              @sort="sortBy"
            >
              <tbody>
                <tr v-if="!users.length">
                  <td colspan="6" class="text-center">No matching records found</td>
                </tr>
                <tr v-for="(user, i) in users" :key="user.id">
                  <td>{{ user.id }}</td>
                  <td>{{ user.name }}</td>
                  <td>{{ user.username }}</td>
                  <td>{{ user.usertype }}</td>
                  <td>{{ user.business_unit }}</td>
                  <td class="text-center" style="width: 120px">
                    <Button
                      icon="md-eye"
                      type="info"
                      shape="circle"
                      @click="viewUser(user, i)"
                    ></Button>
                    <Button
                      icon="md-create"
                      type="success"
                      shape="circle"
                      @click="editUser(user, i)"
                    ></Button>
                    <Button
                      icon="md-trash"
                      type="error"
                      shape="circle"
                      @click="deleteUser(user.id, i)"
                    ></Button>
                  </td>
                </tr>
              </tbody>
            </datatable>
          </div>
          <div class="card-footer">
            <pagination
              :pagination="pagination"
              @prev="getUsers(pagination.prevPageUrl)"
              @next="getUsers(pagination.nextPageUrl)"
            >
            </pagination>
          </div>
        </div>
      </div>
    </div>
    <!-- modal user view-->
    <div
      class="modal fade"
      id="user_view"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="user_view">
              <h4 class="lead"><i class="nav-icon fas fa-user">&nbsp;</i>View User</h4>
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form v-on:submit.prevent="">
            <div class="modal-body">
              <table class="table table-bordered" id="userTable">
                <tbody>
                  <tr>
                    <td style="width: 150px" class="text-bold">ID:</td>
                    <td>{{ form.id }}</td>
                  </tr>
                  <tr>
                    <td class="text-bold">Name</td>
                    <td>{{ form.name }}</td>
                  </tr>
                  <tr>
                    <td class="text-bold">Username</td>
                    <td>{{ form.username }}</td>
                  </tr>
                  <tr>
                    <td class="text-bold">User Type</td>
                    <td>{{ form.usertype }}</td>
                  </tr>
                  <tr>
                    <td class="text-bold">Store</td>
                    <td>{{ form.business_unit }}</td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="modal-footer">
              <input
                type="button"
                class="btn btn-secondary btn-sm"
                data-dismiss="modal"
                value="Close"
              />
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- /.modal user view-->

    <!-- modal user edit-->
    <div
      class="modal fade"
      id="user_edit"
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
            <h5 class="modal-title" id="user_edit">
              <h4 v-show="editMode" class="lead">
                <i class="nav-icon fas fa-user">&nbsp;</i>Edit User
              </h4>
              <h4 v-show="!editMode" class="lead">
                <i class="nav-icon fas fa-user">&nbsp;</i>Add User
              </h4>
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form v-on:submit.prevent="editMode ? updateUser() : createUser()">
            <div class="modal-body">
              <table class="table table-bordered" id="sample">
                <tbody>
                  <tr v-show="!editMode">
                    <td colspan="2">
                      <div class="float-none">
                        <input
                          type="text"
                          class="form-control form-control-sm"
                          v-model="query"
                          name="name"
                          placeholder="Search employee"
                          @keyup="autoComplete"
                        />
                        <div
                          class="panel-footer results"
                          v-if="results.length && query != ''"
                        >
                          <p v-for="(result, i) in results" :key="i">
                            <a @click.prevent="selectEmp(result)">{{ result.name }} </a>
                          </p>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-bold">Name</td>
                    <td>
                      <input
                        type="text"
                        class="form-control form-control-sm"
                        v-model="form.name"
                        name="name"
                      />

                      <has-error :form="form" field="name"></has-error>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-bold">Username</td>
                    <td>
                      <input
                        type="text"
                        class="form-control form-control-sm"
                        v-model="form.username"
                        name="username"
                      />
                      <has-error :form="form" field="username"></has-error>
                      <input
                        type="hidden"
                        class="form-control form-control-sm"
                        v-model="form.emp_id"
                        name="username"
                      />
                    </td>
                  </tr>

                  <tr>
                    <td class="text-bold">User Type</td>
                    <td>
                      <select
                        v-model="form.usertype"
                        class="form-control form-control-sm"
                      >
                        <option v-for="(type, i) in types" :value="type.id" :key="i">
                          {{ type.usertype }}
                        </option>
                      </select>

                      <has-error :form="form" field="usertype"></has-error>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-bold">Store</td>
                    <td>
                      <select v-model="form.store" class="form-control form-control-sm">
                        <option
                          v-for="(store, i) in stores"
                          :value="store.bunit_code"
                          :key="i"
                        >
                          {{ store.business_unit }}
                        </option>
                      </select>
                      <has-error :form="form" field="store"></has-error>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-bold">Password</td>
                    <td>
                      <input
                        type="text"
                        class="form-control form-control-sm"
                        v-model="form.password"
                        name="username"
                      />
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="modal-footer">
              <input
                type="button"
                class="btn btn-secondary btn-sm"
                data-dismiss="modal"
                value="Close"
              />
              <button v-show="editMode" type="submit" class="btn btn-primary btn-sm">
                Submit
              </button>
              <button v-show="!editMode" type="submit" class="btn btn-primary btn-sm">
                Submit
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- /.modal user edit-->
  </div>
</template>

<script>
import Form from "vform";
import _ from "lodash";
import Datatable from "./Datatable.vue";
import Pagination from "./Pagination.vue";
export default {
  components: { datatable: Datatable, pagination: Pagination },

  data() {
    let sortOrders = {};
    let columns = [
      { width: "5%", label: "ID", name: "id" },
      { width: "25%", label: "NAME", name: "name" },
      { width: "15%", label: "USER NAME", name: "username" },
      { width: "15%", label: "USER TYPE", name: "usertype_id" },
      { width: "20%", label: "LOCATION", name: "bunit_code" },
      { width: "15%", label: "ACTION", name: "" },
    ];
    columns.forEach((column) => {
      sortOrders[column.name] = -1;
    });
    return {
      // start pagination
      columns: columns,
      sortKey: "itemcode",
      sortOrders: sortOrders,
      perPage: ["10", "25", "50", "100"],
      tableData: {
        draw: 0,
        length: 10,
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
      // end pagination

      // start form
      editMode: false,
      users: [],
      table: {},
      types: [],
      stores: [],
      loading: true,
      searchUser: null,
      query: "",
      results: [],
      form: new Form({
        id: "",
        name: "",
        username: "",
        usertype: "",
        password: "",
        store: "",
        employee: "",
        business_unit: "",
        date_register: "",
        emp_id: "",
      }),
      index: -1,
      // end form
    };
  },
  methods: {
    clearData() {
      this.getUsers();
      this.tableData.search = "";
    },
    selectEmp(employee) {
      this.query = "";
      this.results = [];
      this.form.name = employee.name;
      this.form.username = employee.emp_id;
      this.form.emp_id = employee.emp_id;
    },
    autoComplete: _.throttle(function () {
      if (this.query.length > 2) {
        axios.get("/api/employee", { params: { query: this.query } }).then((response) => {
          this.results = response.data;
        });
      }
    }, 1000),

    deleteUser(id, index) {
      swal
        .fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
        })
        .then((result) => {
          if (result.isConfirmed) {
            this.form
              .delete("api/delete_user/" + id)
              .then(() => {
                this.users.splice(index, 1);
                swal.fire("User Deleted!", "Successfully.", "success");
              })
              .catch(() => {
                swal.fire({
                  icon: "warning",
                  title: "Oops...",
                  text: "Something went wrong!",
                });
              });
          }
        });
    },
    showAddUserModal() {
      this.editMode = false;
      this.form.clear();
      this.form.reset();
      $("#user_edit").modal("show");
    },
    createUser() {
      this.form
        .post("api/add_super_user")
        .then((res) => {
          $("#user_edit").modal("hide");
          swal.fire("User Added!", "Successfully.", "success");
          Fire.$emit("refresh_users");
        })
        .catch(() => {});
    },
    updateUser() {
      this.form.put("api/edit_super_user/" + this.form.id).then(() => {
        // var _this = this;
        // _this.users[this.index].name = this.form.name;
        // _this.users[this.index].username = this.form.username;
        // _this.users[this.index].user_type = this.form.usertype;
        // _this.users[this.index].business_unit = this.form.usertype;
        Fire.$emit("refresh_users");

        $("#user_edit").modal("hide");
        swal.fire("User successfully", "Updated", "success");
        // Fire.$emit("refresh_users");
      });
    },
    getUsertype() {
      axios.get("api/usertype").then((response) => {
        this.types = response.data;
      });
    },
    editUser(user, i) {
      let obj = {
        id: user.id,
        name: user.name,
        username: user.username,
        usertype: user.usertype_id,
        emp_id: user.emp_id,
        store: user.bunit_code,
      };
      this.editMode = true;
      this.form.clear();
      this.form.reset();
      this.form.fill(obj);
      $("#user_edit").modal("show");
      this.index = i;
    },
    viewUser(user, i) {
      this.form.id = user.id;
      this.form.name = user.name;
      this.form.username = user.username;
      this.form.usertype = user.usertype;
      this.form.business_unit = user.business_unit;

      $("#user_view").modal("show");
    },
    getStores() {
      axios.get("api/stores").then((response) => {
        this.stores = response.data;
      });
    },
    getEmployees() {
      axios.get("api/employee").then((response) => {
        this.employees = response.data;
      });
    },
    getUsers(url = "api/users") {
      this.tableData.draw++;
      axios
        .get(url, { params: this.tableData })
        .then((response) => {
          let data = response.data;
          if (this.tableData.draw == data.draw) {
            this.users = data.data.data;
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
      this.getUsers();
    },
    getIndex(array, key, value) {
      return array.findIndex((i) => i[key] == value);
    },
  },
  mounted() {
    this.getUsers();
    this.getUsertype();
    this.getStores();
    Fire.$on("refresh_users", () => {
      this.getUsers();
    });
  },
};
</script>

<style>
.ex1 {
  height: 150px;
  width: 430px;
  overflow-y: auto;
}
.results {
  position: absolute;
  z-index: 1000;
  border: 1px solid #ccc;
  background: #fff;
  width: 441px;
  height: 150px;
  overflow-y: auto;
  padding: 1px;
  color: #2073cc;
}
</style>
