<template>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="province">Province</label>
                    <select class="form-control form-control-sm" tabindex="1" v-model="form.province">
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
                    <select class="form-control form-control-sm" tabindex="2" v-model="form.town">
                        <option value="">Select Town</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="brgy">Barangay</label
                    ><small class="text-primary"> (Optional)</small>
                    <select class="form-control form-control-sm" tabindex="3" v-model="form.brgy">
                        <option value="">Select Barangay</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="traspo">Transportation Type</label>
                    <select class="form-control form-control-sm" tabindex="4" v-model="form.transpo">
                        <option value="">Transportation</option>
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
                    />
                </div>
            </div>
        </div>
        <div class="row">
             <button class="btn btn-danger btn-sm">Cancel</button> &nbsp;
             <button class="btn btn-primary btn-sm">Update</button>

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
            form:{
                 province: null,
                 town: null,
                 brgy: null,
                 transpo: null,
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
        }
        //    getTown(url = "api/town") {
        //        axios.get(url, { params: this.form }).then(response => {
        //            this.towns = response.data;
        //        });
        //    },
        //    getBarangay(url = "api/barangay") {
        //        axios.get(url, { params: this.form }).then(response => {
        //            this.barangays = response.data;
        //        });
        //    }
    },
    created() {
           this.getTranspo(),
           this.getProvinces()
        //    axios.get(`charges/view/${this.chrg_id}`)
    }
};
</script>
