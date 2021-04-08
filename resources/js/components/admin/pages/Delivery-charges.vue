<template>
    <div class="container">
        <Top></Top>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Delivery Charges</h4>
                        <label for="filter" class="mt-3">Filter By:</label>
                        <div class="row mt-1">
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-4 py-1">
                                        <select
                                            v-model="tableData.province"
                                            class="form-control form-control-sm d-block"
                                            @change="getCharges()"
                                        >
                                            <option value="">Province</option>
                                            <option
                                                v-for="(records,
                                                index) in provinces"
                                                :key="index"
                                                :value="records.prov_id"
                                            >
                                                {{ records.prov_name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4 py-1">
                                        <select
                                            v-model="tableData.town"
                                            class="form-control form-control-sm d-block"
                                            @change="getCharges()"
                                        >
                                            <option value="">Town</option>
                                            <option
                                                v-for="(records,
                                                index) in ArrTowns"
                                                :key="index"
                                                :value="records.town_id"
                                            >
                                                {{ records.town_name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4 py-1">
                                        <select
                                            v-model="tableData.transpo"
                                            class="form-control form-control-sm d-block"
                                            @change="getCharges()"
                                        >
                                            <option value="">
                                                Transportation</option
                                            >
                                            <option
                                                v-for="(records,
                                                index) in transportations"
                                                :key="index"
                                                :value="records.id"
                                            >
                                                {{ records.transpo_name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 py-1">
                                <div class="row justify-content-end">
                                    <div class="col-sm-3">
                                        <label for="" class="my-1 float-right"
                                            >Sort By:</label
                                        >
                                    </div>
                                    <div class="col-sm-3">
                                        <select
                                            v-model="tableData.dir"
                                            class="form-control form-control-sm d-block"
                                            @change="getCharges()"
                                        >
                                            <option value="asc">
                                                ASCENDING
                                            </option>
                                            <option value="desc">
                                                DESCENDING
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="" class="my-1 float-right"
                                            >Show Entry:</label
                                        >
                                    </div>
                                    <div class="col-sm-3">
                                        <select
                                            v-model="tableData.length"
                                            class="form-control form-control-sm d-block"
                                            @change="getCharges()"
                                        >
                                            <option
                                                v-for="(records,
                                                index) in perPage"
                                                :key="index"
                                                :value="records"
                                            >
                                                {{ records }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <button
                            class="btn-block btn btn-primary btn-sm mb-1"
                            @click="showAddModalDCharge()"
                            data-toggle="tooltip"
                            data-placement="bottom"
                            title="Add Data"
                        >
                            <i class="fas fa-folder-plus"></i>
                            ADD
                        </button>
                        <Datatable
                            :columns="columns"
                            :sortKey="sortKey"
                            :sortOrders="sortOrders"
                            @sort="sortBy"
                        >
                            <tbody>
                                <tr
                                    v-for="(data, i) in charges"
                                    :key="i"
                                    @mouseover="selected(data)"
                                    @mouseleave="unSelected()"
                                    class="tr-hover"
                                >
                                    <td>
                                        <a
                                            data-toggle="tooltip"
                                            data-placement="bottom"
                                            title="Delete data"
                                            @click="
                                                deleteCharges(data.chrg_id, i)
                                            "
                                            style="width: 30px"
                                        >
                                            <i
                                                class="far fa-trash-alt text-danger"
                                            ></i>
                                        </a>
                                    </td>
                                    <td>{{ data.prov_name }}</td>
                                    <td>{{ data.town_name }}</td>
                                    <td v-if="data.brgy != null">
                                        {{ data.brgy.brgy_name }}
                                    </td>
                                    <td v-else>{{ " " }}</td>
                                    <td>{{ data.transpo_name }}</td>
                                    <td>{{ data.charge_amt }}</td>
                                    <td>{{ data.rider_shared }}</td>
                                    <td>
                                        <router-link
                                            data-toggle="tooltip"
                                            data-placement="bottom"
                                            title="Update data"
                                            :to="{name: 'viewcharge', params:{chrg_id: data.chrg_id}}"
                                        >
                                            <i class="fas fa-eye"></i>
                                        </router-link>
                                    </td>
                                </tr>
                            </tbody>
                        </Datatable>
                    </div>

                    <div class="card-footer">
                        <Pagination
                            :pagination="pagination"
                            @prev="getCharges(pagination.prevPageUrl)"
                            @next="getCharges(pagination.nextPageUrl)"
                        ></Pagination>
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
            <div
                class="modal-dialog modal-lg modal-dialog-centered"
                role="document"
            >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="d_charges">
                            <h4 v-show="!editMode" class="lead">
                                &nbsp;Setup Delivery Charges
                            </h4>
                            <h4 v-show="editMode" class="lead">
                                &nbsp;Edit Delivery Charges
                            </h4>
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
                        v-on:submit.prevent="
                            editMode ? updateCharge() : createCharge()
                        "
                    >
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="province"
                                            >Select Province</label
                                        >
                                        <select
                                            class="form-control form-control-sm"
                                            v-model="form.province"
                                            tabindex="1"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'province'
                                                )
                                            }"
                                            @change.prevent="getTown()"
                                        >
                                            <option value=""
                                                >Select Province</option
                                            >
                                            <option
                                                :value="prov.prov_id"
                                                v-for="(prov, i) in provinces"
                                                :key="i"
                                            >
                                                {{ prov.prov_name }}
                                            </option>
                                        </select>
                                        <has-error
                                            :form="form"
                                            field="province"
                                        ></has-error>
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
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'town'
                                                )
                                            }"
                                            @change.prevent="getBarangay()"
                                        >
                                            <option value=""
                                                >Select Town</option
                                            >
                                            <option
                                                :value="town.town_id"
                                                v-for="(town, i) in towns"
                                                :key="i"
                                            >
                                                {{ town.town_name }}
                                            </option>
                                        </select>
                                        <has-error
                                            :form="form"
                                            field="town"
                                        ></has-error>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="brgy">Select Barangay</label
                                        ><small class="text-primary">
                                            (Optional)</small
                                        >
                                        <select
                                            class="form-control form-control-sm"
                                            v-model="form.barangay"
                                            tabindex="3"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'barangay'
                                                )
                                            }"
                                        >
                                            <option value=""
                                                >Select Barangay</option
                                            >
                                            <option
                                                :value="brgy.brgy_id"
                                                v-for="(brgy, i) in barangays"
                                                :key="i"
                                            >
                                                {{ brgy.brgy_name }}
                                            </option>
                                        </select>
                                        <has-error
                                            :form="form"
                                            field="barangay"
                                        ></has-error>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="traspo"
                                            >Select Transportation Type</label
                                        >
                                        <select
                                            class="form-control form-control-sm"
                                            v-model="form.transportation"
                                            tabindex="4"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'transpo'
                                                )
                                            }"
                                        >
                                            <option value=""
                                                >Select Transportation</option
                                            >
                                            <option
                                                :value="transpo.id"
                                                v-for="(transpo,
                                                i) in transportations"
                                                :key="i"
                                            >
                                                {{ transpo.transpo_name }}
                                            </option>
                                        </select>
                                        <has-error
                                            :form="form"
                                            field="transportation"
                                        ></has-error>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="charge"
                                            >Delivery Charge</label
                                        >
                                        <input
                                            type="number"
                                            class="form-control form-control-sm"
                                            placeholder="Enter amount"
                                            v-model="form.charge"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'charge'
                                                )
                                            }"
                                            tabindex="5"
                                        />
                                        <has-error
                                            :form="form"
                                            field="charge"
                                        ></has-error>
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
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'share'
                                                )
                                            }"
                                            tabindex="6"
                                        />
                                        <has-error
                                            :form="form"
                                            field="share"
                                        ></has-error>
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
                            <button
                                tabindex="4"
                                type="submit"
                                class="btn btn-primary btn-sm"
                            >
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
import Datatable from "./Datatable.vue";

export default {
    name: "Delivery-Charged",
    components: { Pagination, Datatable },

    data() {
        let sortOrders = {};
        let columns = [
            { width: "10%", label: "", name: "id" },
            { width: "15%", label: "Province", name: "prov_id" },
            { width: "15%", label: "Town", name: "town_id" },
            { width: "15%", label: "Barangay", name: "brgy_id" },
            { width: "15%", label: "Transportation", name: "transpo_id" },
            { width: "15%", label: "Charge Amount", name: "charge_amt" },
            { width: "15%", label: "Rider Share", name: "rider_shared" },
            { width: "10%", label: "", name: "" }
        ];
        columns.forEach(column => {
            sortOrders[column.name] = -1;
        });
        return {
            charges: [],
            editMode: false,
            stores: [],
            barangays: [],
            towns: [],
            transportations: [],
            provinces: [],
            ArrTowns: [],
            columns: columns,
            sortKey: "id",
            sortOrders: sortOrders,
            perPage: ["10", "25", "50", "100"],
            selectedData: false,
            tableData: {
                draw: 0,
                length: 10,
                search: "",
                town: "",
                province: "",
                transpo: "",
                column: 1,
                dir: "desc"
            },
            pagination: {
                lastPage: "",
                currentPage: "",
                total: "",
                lastPageUrl: "",
                nextPageUrl: "",
                prevPageUrl: "",
                from: "",
                to: ""
            },
            form: new Form({
                id: "",
                province: "",
                town: "",
                barangay: "",
                transportation: "",
                charge: "",
                share: ""
            }),
            index: -1
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
            axios.get(url, { params: this.form }).then(response => {
                this.towns = response.data;
            });
        },
        async getFilterTown() {
            const { data } = await axios.get("api/filter/towns");
            this.ArrTowns = data;
        },
        getBarangay(url = "api/barangay") {
            axios.get(url, { params: this.form }).then(response => {
                this.barangays = response.data;
            });
        },
        showAddModalDCharge() {
            this.form.clear();
            this.form.reset();
            $("#d_charges").modal("show");
        },
        createCharge() {
            this.form.post("api/create/charge").then(response => {
                // console.log(response);
                if (response.data.error === true) {
                    $("#d_charges").modal("hide");
                    swal.fire(
                        "Double Entry",
                        "Please check your data.",
                        "warning"
                    );
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
                .then(response => {
                    let data = response.data;
                    if (this.tableData.draw == data.draw) {
                        this.charges = data.data.data;
                        this.configPagination(data.data);
                    }
                })
                .catch(errors => {
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
            return array.findIndex(i => i[key] == value);
        }
    },
    created() {
        this.getProvinces();
        this.getTranspo();
        this.getCharges();
        this.getFilterTown();
        Fire.$on("reload", () => {
            this.getCharges();
        });
    }
};
</script>
