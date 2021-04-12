<template>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="province">Province</label>
                    <select
                        class="form-control form-control-sm"
                        tabindex="1"
                        v-model="form.province"
                        :class="{
                            'is-invalid': errors.province
                        }"
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
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="Town">Town</label>
                    <select
                        class="form-control form-control-sm"
                        tabindex="2"
                        v-model="form.town"
                        :class="{
                            'is-invalid': errors.town
                        }"
                    >
                        <option value="">Select Town</option>
                        <option
                            :value="town.town_id"
                            v-for="(town, i) in towns"
                            :key="i"
                            >{{ town.town_name }}</option
                        >
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="brgy">Barangay</label
                    ><small class="text-primary"> (Optional)</small>
                    <select
                        class="form-control form-control-sm"
                        tabindex="3"
                        v-model="form.barangay"
                        :class="{
                            'is-invalid': errors.barangay
                        }"
                    >
                        <option value="">Select Barangay</option>
                        <option
                            :value="brgy.brgy_id"
                            v-for="(brgy, i) in barangays"
                            :key="i"
                            >{{ brgy.brgy_name }}</option
                        >
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="traspo">Transportation Type</label>
                    <select
                        class="form-control form-control-sm"
                        tabindex="4"
                        v-model="form.transportation"
                        :class="{
                            'is-invalid': errors.transportation
                        }"
                    >
                        <option value="">Transportation</option>
                        <option
                            :value="transpo.id"
                            v-for="(transpo, i) in transportations"
                            :key="i"
                            >{{ transpo.transpo_name }}</option
                        >
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="charge">Delivery Charge</label>
                    <input
                        type="number"
                        class="form-control form-control-sm"
                        placeholder="Enter amount"
                        tabindex="5"
                        v-model="form.charge_amount"
                        :class="{
                            'is-invalid': errors.charge_amount
                        }"
                    />
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="share">Rider Share</label>
                    <input
                        type="number"
                        class="form-control form-control-sm"
                        placeholder="Enter amount"
                        tabindex="6"
                        v-model="form.rider_shared"
                        :class="{
                            'is-invalid': errors.rider_shared
                        }"
                    />
                </div>
            </div>
        </div>
        <div class="row">
            <router-link to="/delivery_charges" class="btn btn-secondary btn-sm"
                >Cancel</router-link
            >
            &nbsp;
            <button class="btn btn-success btn-sm" @click="updateCharge">
                Update
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props: ["chrg_id"],
    data() {
        return {
            barangays: [],
            towns: [],
            transportations: [],
            provinces: [],
            errors: {},
            form: {
                province: null,
                town: null,
                barangay: null,
                transportation: null,
                charge_amount: null,
                rider_shared: null
            }
        };
    },
    methods: {
        async getTranspo() {
            const { data } = await axios.get("/api/transportations");
            this.transportations = data;
        },
        async getProvinces() {
            const { data } = await axios.get("/api/province");
            this.provinces = data;
        },
        async getTown() {
            const { data } = await axios.get("/api/view/towns");
            this.towns = data;
        },
        async getBarangay() {
            const { data } = await axios.get("/api/view/brgy");
            this.barangays = data;
        },
        updateCharge() {
            if (confirm("Do you want to save the changes?")) {
                axios
                    .post("/api/charges/update", {
                        id: this.chrg_id,
                        transportation: this.form.transportation,
                        province: this.form.province,
                        barangay: this.form.barangay,
                        town: this.form.town,
                        charge_amount: this.form.charge_amount,
                        rider_shared: this.form.rider_shared
                    })
                    .then(() => {
                        this.$router.push("/delivery_charges");
                    })
                    .catch(error => {
                        if (error.response.status === 422) {
                            this.errors = error.response.data.errors || {};
                        }
                    });
            }
        }
    },
    async mounted() {
        this.getTranspo(), this.getProvinces();
        this.getTown();
        this.getBarangay();

        const { data } = await axios.get(`/api/charges/view/${this.chrg_id}`);
        this.form.province = data.prov_id;
        this.form.town = data.town_id;
        this.form.barangay = data.brgy_id;
        this.form.transportation = data.transpo_id;
        this.form.charge_amount = parseFloat(data.charge_amt);
        this.form.rider_shared = parseFloat(data.rider_shared);
    }
};
</script>
