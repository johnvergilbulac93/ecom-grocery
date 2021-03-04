<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-4">
        <!-- small box -->
        <div class="small-box bg-orange ">
          <div class="inner text-white">
            <center>
              <h5>CHANGED PRICE COUNT</h5>
              <hr />
              <h3>{{ priceCount }}</h3>
            </center>
            <p>Today's Price Changed</p>
          </div>

          <a @click="showModalPrice" class="small-box-footer "
            > <span class="text-white">More info</span>  <i class="fas fa-arrow-circle-right text-white"></i
          ></a>
        </div>
      </div>
    </div>
    <div
      class="modal fade"
      id="price_info"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
      data-backdrop="static"
      data-keyboard="false"
    >
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="price_info">
              <h4 class="lead">&nbsp;TODAY'S PRICE CHANGED</h4>
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form>
            <div class="modal-body">
              <infoprice></infoprice>
            </div>
            <div class="modal-footer">
              <input
                type="button"
                class="btn btn-danger btn-sm"
                data-dismiss="modal"
                value="Close"
              />
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- modal end -->
  </div>
</template>

<script>
import InfoPrice from "./Info_Price_History.vue";

export default {
  components: { infoprice: InfoPrice },

  data() {
    return {
      prices: [],
      loading: true,
      priceCount: null,
    };
  },

  methods: {
    showModalPrice() {
      $("#price_info").modal("show");
    },
    async getPriceChanged() {
      const { data } = await axios.get("api/price_changed/count");
      this.priceCount = data;
    },
  },

  mounted() {
    this.getPriceChanged();
  },
};
</script>
