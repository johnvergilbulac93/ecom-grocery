<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 mt-2">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-md-6">
                <h5>Picker Allowed Time</h5>
              </div>
              <div class="col-md-6 float-right">
                <input
                  type="button"
                  class="btn btn-success btn-sm float-right"
                  value="Add Item"
                  @click="showPickerModal"
                />
              </div>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="col-md-12 my-2">
            <div class="table-responsive">
              <table class="table table-hover table-bordered" id="sample">
                <thead>
                  <tr>
                    <th>Picker Id</th>
                    <th>Time Start</th>
                    <th>Time End</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="data in createdpickers.data" :key="data.id">
                    <td>{{ data.picker }}</td>
                    <td>{{ data.time_start }}</td>
                    <td>{{ data.time_end }}</td>
                    <td class="text-center" style="width: 100px">
                      <Button
                        icon="md-eye"
                        type="primary"
                        shape="circle"
                        @click="editPickerModal(data)"
                      ></Button>

                      <Button
                        icon="md-trash"
                        type="error"
                        shape="circle"
                        @click="deletePickerTime(data.id)"
                      ></Button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <pagination
              :data="createdpickers"
              @pagination-change-page="getResults"
              align="right"
              :limit="-2"
            >
              <span slot="prev-nav"><i class="fas fa-angle-double-left orange"></i></span>
              <span slot="next-nav"
                ><i class="fas fa-angle-double-right orange"></i
              ></span>
            </pagination>
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>

    <!-- modal picker-->
    <div
      class="modal fade"
      id="picker"
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
            <h5 class="modal-title" id="picker">
              <h4 class="lead" v-show="!editMode">
                <i class="nav-icon fas fa-user-clock orange"></i>Set Picker Time
              </h4>
              <h4 class="lead" v-show="editMode">
                <i class="nav-icon fas fa-user-clock orange"></i>Update Picker Time
              </h4>
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form v-on:submit.prevent="editMode ? editPickerTime() : createPickerTime()">
            <div class="modal-body">
              <div class="form-group">
                <label for="">Select Picker</label>
                <Select
                  v-model="form.picker"
                  filterable
                  clearable
                  placeholder="Please select picker"
                  not-found-text="Picker Not Found"
                >
                  <Option
                    v-for="picker in pickers"
                    :value="picker.emp_id"
                    :key="picker.emp_id"
                    >{{ picker.name }} - {{ picker.emp_id }}</Option
                  >
                </Select>
                <has-error :form="form" field="picker"></has-error>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Time Start</label>
                    <input
                      v-model="form.time_start"
                      type="time"
                      name="itemcode"
                      class="form-control form-control-sm"
                    />
                    <has-error :form="form" field="time_start"></has-error>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Time End</label>
                    <input
                      v-model="form.time_end"
                      type="time"
                      name="itemcode"
                      class="form-control form-control-sm"
                    />
                    <has-error :form="form" field="time_end"></has-error>
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
    <!-- /.modal picker-->
  </div>
</template>

<script>
import Form from "vform";
export default {
  data() {
    return {
      editMode: false,
      pickers: [],
      createdpickers: {},
      form: new Form({
        id: "",
        picker: "",
        time_start: "",
        time_end: "",
      }),
    };
  },
  methods: {
    getResults(page = 1) {
      axios.get("api/getpicker?page=" + page).then((response) => {
        this.createdpickers = response.data;
      });
    },
    showPickerModal() {
      this.editMode = false;
      this.form.reset();
      this.form.clear();
      $("#picker").modal("show");
    },
    editPickerModal(data) {
      this.editMode = true;
      this.form.reset();
      this.form.clear();
      this.form.fill(data);
      $("#picker").modal("show");
    },
    deletePickerTime(id) {
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
              .delete("api/deletepicker/" + id)
              .then(() => {
                swal.fire("Deleted!", "Successfully.", "success");
                Fire.$emit("refresh_picker");
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
    editPickerTime() {
      this.form.put("api/pickeredit/" + this.form.id).then(() => {
        toast.fire({
          icon: "success",
          title: "Success",
          text: "Successfully Updated",
        });
        Fire.$emit("refresh_picker");
        $("#picker").modal("hide");
      });
    },
    createPickerTime() {
      this.form
        .post("api/pickercreate")
        .then(() => {
          $("#picker").modal("hide");
          toast.fire({
            icon: "success",
            title: "Success",
            text: "Successfully saved",
          });
          Fire.$emit("refresh_picker");
        })
        .catch(() => {});
    },
    loadPicker() {
      axios.get("api/pickers").then(({ data }) => (this.pickers = data));
    },
    loadCreatedPicker() {
      axios.get("api/getpicker").then(({ data }) => (this.createdpickers = data));
    },
  },
  created() {
    this.loadPicker();
    this.loadCreatedPicker();
    Fire.$on("refresh_picker", () => {
      this.loadCreatedPicker();
    });
  },
};
</script>
