<template>
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <center class="py-2">
              <h5>ITEM NOT AVAILABLE</h5>
              <hr />
              <h3>{{ countItems }}</h3>
            </center>
          </div>

          <a @click="viewItem" class="small-box-footer"
            >More info <i class="fas fa-arrow-circle-right"></i
          ></a>
        </div>
      </div>
    </div>
    <div
      class="modal fade"
      id="viewitem"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="viewitem">
              <h4 class="lead">&nbsp;ITEM DETAILS</h4>
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form>
            <div class="modal-body">
              <div class="item-per-store-content">
                <div class="table-responsive">
                  <table class="table table-hover table-sm">
                    <thead>
                      <tr>
                        <th>CODE</th>
                        <th>DESCRIPTION</th>
                        <th>CATEGORY NAME</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(data, i) in items.data" :key="i">
                        <td style="width: 10%">{{ data.itemcode }}</td>
                        <td style="width: 60%">{{ data.product_name }}</td>
                        <td style="width: 30%">{{ data.category_name }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <hr />
            <div class="row justify-content-between">
              <div class="col-sm-6 py-2">
                <div class="float-left ml-2">
                  <pagination
                    :limit="-1"
                    :data="items"
                    @pagination-change-page="getResults"
                  >
                    <span slot="prev-nav"><i class="fas fa-angle-left"></i></span>
                    <span slot="next-nav"><i class="fas fa-angle-right"></i></span>
                  </pagination>
                </div>
              </div>
              <div class="col-sm-6 py-2 px-2">
                <div class="float-right mr-2">
                  <input
                    type="button"
                    class="btn btn-danger btn-sm"
                    data-dismiss="modal"
                    value="Close"
                  />
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      items: {},
      countItems: "",
      loading: true,
    };
  },
  methods: {
    viewItem() {
      $("#viewitem").modal("show");
    },
    getResults(page = 1) {
      axios.get("api/itemavailable?page=" + page).then((response) => {
        this.items = response.data;
        this.countItems = response.data.total;
      });
    },
  },
  mounted() {
    this.getResults();
  },
};
</script>
