<template>
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <select
          name="filter"
          id="filter"
          class="form-control form-control-sm"
          v-model="filter.by"
        >
          <option value="">Choose Filter</option>
          <option value="all">All Items</option>
          <option value="available">Available Items</option>
          <option value="unavailable">Unavailable Items</option>
        </select>
      </div>
      <div class="col-md-4 offset-md-4">
        <!-- <button class="btn btn-outline-info btn-sm float-right" @click="generateBy">
          Download
        </button> -->
        <div class="float-right">
          <Button type="primary" :loading="loading" @click.prevent="generateBy">
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
      filter: {
        by: "",
      },
    };
  },
  methods: {
    generateBy() {
      this.loading = true;
      axios
        .get("api/filter_report", { params: this.filter }, { responseType: "blob" })
        .then((res) => {
          this.loading = false;
          let anchor = document.createElement("a");
          let filename;
          if (this.filter.by === "all") {
            filename = "Item_masterfile.xlsx";
          }
          if (this.filter.by === "available") {
            filename = "available_items.xlsx";
          }
          if (this.filter.by === "unavailable") {
            filename = "unavailable_items.xlsx";
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
            swal.fire("Error", "Please choose filter", "error");
            this.loading = false;
          }
        });
    },
  },
  created() {},
};
</script>
