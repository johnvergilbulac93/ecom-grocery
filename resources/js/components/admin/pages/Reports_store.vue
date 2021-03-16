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
          :name="filter.by + '-' + 'items' + '.xls'"
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
    //     generateBy() {
    //       this.loading = true;
    //       axios
    //         .get("api/filter_report", { params: this.filter }, { responseType: "blob" })
    //         .then((res) => {
    //           this.loading = false;
    //           let anchor = document.createElement("a");
    //           let filename;
    //           let storename = res.data.bunit.acroname;
    //
    //           if (this.filter.by === "all") {
    //             filename = storename +"-"+ "Item_masterfile" + ".xlsx";
    //           }
    //           if (this.filter.by === "available") {
    //             filename = storename +"-"+"available_items" + ".xlsx";
    //           }
    //           if (this.filter.by === "unavailable") {
    //             filename = storename +"-"+"unavailable_items" + ".xlsx";
    //           }
    //           anchor.setAttribute("download", filename);
    //           anchor.setAttribute("href", res.data.data);
    //           document.body.appendChild(anchor);
    //           anchor.click();
    //           document.body.removeChild(anchor);
    //           swal.fire("Success", "Exported to excel successfully.", "success");
    //         })
    //         .catch((error) => {
    //           this.loading = false;
    //           if (error.response.status == 422) {
    //             swal.fire("Error", "Please choose filter", "error");
    //             this.loading = false;
    //           }
    //         });
    //     },
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
