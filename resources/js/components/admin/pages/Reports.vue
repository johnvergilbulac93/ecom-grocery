<template>
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <select
          name="filter"
          id="filter"
          class="form-control form-control-sm"
          v-model="selectedstore"
          tabindex="1"
        >
          <option value="">Select Store</option>
          <option
            v-bind:value="{ id: store.bunit_code, text: store.acroname }"
            v-for="(store, i) in stores"
            :key="i"
          >
            {{ store.business_unit }}
          </option>
        </select>
      </div>
      <div class="col-md-4">
        <select
          name="filter"
          id="filter"
          class="form-control form-control-sm"
          v-model="filter.by"
          tabindex="2"
        >
          <option value="">Choose Filter</option>
          <option value="all">All Items</option>
          <option value="available">Available Items</option>
          <option value="unavailable">Unavailable Items</option>
        </select>
      </div>
      <div class="col-md-4">
        <!-- <button class="btn btn-outline-info btn-sm float-right" @click="generateBy">
          Download
        </button> -->
        <div class="float-right">
          <Button
            tabindex="3"
            type="primary"
            :loading="loading"
            @click.prevent="generateBy"
          >
            <span v-if="!loading">Generate</span>
            <span v-else>Generating...</span>
          </Button>
        </div>
      </div>
    </div>
    <hr class="mb-2 my-2" />

    <div class="container">
      <div class="row justify-content-center">
        <img :src="$root.path + 'loading2.gif'" alt="loading" v-show="loading" />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Reports",
  data() {
    return {
      loading: false,
      stores: [],
      selectedstore: "",
      filter: {
        by: "",
        store: "",
      },
    };
  },
  methods: {
    generateBy() {
      let storename = this.selectedstore.text;
      this.loading = true;
      this.filter.store = this.selectedstore.id;
      axios
        .get("api/filter_report_store", { params: this.filter })
        .then((res) => {
          this.loading = false;
          let anchor = document.createElement("a");
          let filename;
          if (this.filter.by === "all") {
            filename = "Item_masterfile " + "-" + storename + ".xlsx";
          }
          if (this.filter.by === "available") {
            filename = "available_items" + "-" + storename + ".xlsx";
          }
          if (this.filter.by === "unavailable") {
            filename = "unavailable_items" + "-" + storename + ".xlsx";
          }
          anchor.setAttribute("download", filename);
          anchor.setAttribute("href", res.data.data);
          document.body.appendChild(anchor);
          anchor.click();
          document.body.removeChild(anchor);
          swal.fire("Success", "Exported to excel successfully.", "success");
        })
        .catch((error) => {
          this.loading = false;
          if (error.response.status == 422) {
            swal.fire("Error", "Please choose Store/filter", "error");
            this.loading = false;
          }
        });
    },
    getStore() {
      axios.get("api/stores").then((response) => {
        this.stores = response.data;
      });
    },
  },
  mounted() {
    this.getStore();
  },
};
</script>
