<template>
  <div class="container">
    <div class="row">
      <div class="col-sm-4">
        <select
          name="filter"
          id="filter"
          class="form-control form-control-sm"
          v-model="filter.by"
          @change="changestore"
        >
          <option value="">Choose Filter</option>
          <option value="all">All Items</option>
          <option value="available">Available Items</option>
          <option value="unavailable">Unavailable Items</option>
        </select>
      </div>
      <div class="col-sm-4"></div>
      <div class="col-sm-2">
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
      </div>
      <div class="col-sm-2">
        <export-excel
          class="btn btn-success btn-sm btn-block"
          :data="results"
          :fields="json_fields"
          type="xls"
          :worksheet="filter.by"
          :name="filename"
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
export default {
  name: "Reports",
  data() {
    return {
      loading: false,
      results: [],
      filename: '',
      filter: {
        by: "",
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
    changestore() {
      this.results = [];
    },
    generateBy() {
      this.loading = true;
      axios
        .get("api/filter_report", { params: this.filter })
        .then((data) => {
          this.loading = false;
          this.results = data.data.items;
          this.filename = data.data.filename;
          swal.fire(
            "Success",
            "Download your excel file now, by clicking the Download Excel button.",
            "info"
          );
        })
        .catch((error) => {
          this.loading = false;
          if (error.response.status == 422) {
            swal.fire("Error", "Please choose filter", "error");
            this.loading = false;
          }
        });
    },
  },
  created() {},
};
</script>
