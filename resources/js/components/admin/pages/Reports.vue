<template>
  <div class="container">
    <div class="row mt-1">
      <div class="col-sm-4">
        <select
          name="filter"
          id="filter"
          class="form-control form-control-sm"
          v-model="selectedstore"
          tabindex="1"
          @change="changestore"
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
      <div class="col-sm-4">
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
      <div class="col-sm-2 d-block">
        <!-- <button class="btn btn-outline-info btn-sm float-right" @click="generateBy">
          Download
        </button> -->
        <button
          class="btn btn-primary btn-sm btn-block"
          type="button"
          @click.prevent="generateBy"
        >
          <span
            class="spinner-border spinner-border-sm"
            role="status"
            aria-hidden="true"
            v-if="loading"
          ></span>
          {{ loading ? "Loading..." : "Generate" }}
        </button>
        <!-- <Button
            tabindex="3"
            type="primary"
            :loading="loading"
            @click.prevent="generateBy"
          >
            <span v-if="!loading">Generate</span>
            <span v-else>Generating...</span>
          </Button> -->
      </div>

      <div class="col-sm-2">
        <export-excel
          class="btn btn-success btn-sm btn-block"
          :data="results"
          :fields="json_fields"
          type="xls"
          :worksheet="filter.by"
          :name="selectedstore.text + '-' + filter.by + '-' + 'items' + '.xls'"
          v-if="results.length"
        >
          <i class="far fa-file-excel"></i>
          Download Excel
        </export-excel>
      </div>
    </div>
    <hr class="mb-2 my-2" />

    <div class="container">
      <div class="row justify-content-center">
        <img
          :src="$root.path + 'loading2.gif'"
          alt="loading"
          v-show="loading"
        />
      </div>
    </div>
  </div>
</template>

<script>
// import excel from "vue-excel-export";
// import FileSaver from "file-saver";
export default {
  name: "Reports",
  data() {
    return {
      loading: false,
      stores: [],
      selectedstore: "",
      storeName: "",
      results: [],
      filter: {
        by: "",
        store: "",
      },
      json_fields: {
        CODE: "itemcode",
        DESCRIPTION: "product_name",
        "CATEGORY NO": "category_no",
        "CATEGORY NAME": "category_name",
        UOM: "UOM",
        "RETAIL PRICE": "price_with_vat",
      },
      json_meta: [
        [
          {
            key: "charset",
            value: "utf-8",
          },
        ],
      ],
    };
  },
  methods: {
    forceFileDownload(response) {
      const url = window.URL.createObjectURL(
        new Blob([response.data.data])
      );
      const link = document.createElement("a");
      console.log(url);
      link.href = url;
      link.setAttribute("download", response.data.filename + '.xlsx'); //or any other extension
      document.body.appendChild(link);
      link.click();
    },
    changestore() {
      this.results = [];
    },
    generateBy() {
      let storename = this.selectedstore.text;
      this.loading = true;
      this.filter.store = this.selectedstore.id;
      axios
        .get("api/filter_report_store", { params: this.filter })
        .then((data) => {
          this.loading = false;
          this.results = data.data.items;
          swal.fire(
            "Success",
            "Download your excel file now, by clicking the download excel button.",
            "info"
          );
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
