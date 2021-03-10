<template>
  <div class="container">
    <Top></Top>
    <div class="row">
      <div class="col-sm-6">
        <div class="chart">
          <Chart :data="labeldata" :options="chartOptions"></Chart>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="row justify-content-end">
          <div class="col-sm-6">
            <div class="small-box bg-orange">
              <div class="inner text-white">
                <h3>6</h3>

                <p>Today's Order</p>
              </div>
              <div class="icon">
                <i class="fas fa-shopping-cart"></i>
              </div>
              <a class="small-box-footer">
                <span class="text-white">More info</span>
                <i class="fas fa-arrow-circle-right text-white"></i>
              </a>
            </div>
          </div>
        </div>
        <div class="row justify-content-end">
          <div class="col-sm-6">
            <div class="small-box bg-orange">
              <div class="inner text-white">
                <h3>{{ priceCount }}</h3>

                <p>Today's Changed Price</p>
              </div>
              <div class="icon">
                <i class="fas fa-tag"></i>
              </div>
              <a @click="showModalPrice" class="small-box-footer">
                <span class="text-white">More info</span>
                <i class="fas fa-arrow-circle-right text-white"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- <div class="row justify-content-center">
      <div class="col-sm-4">
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
    </div> -->
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
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
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
import Chart from "./Chart";

export default {
  components: { infoprice: InfoPrice, Chart: Chart },

  data() {
    return {
      prices: [],
      loading: true,
      priceCount: null,
      transactionCount: null,
      labeldata: [],
      chartOptions: {
        hoverBorderWidth: 20,
      },
      chartData: {
        hoverBackgroundColor: "red",
        hoverBorderWidth: 10,
        labels: ["Green", "Red", "Blue"],
        datasets: [
          {
            label: "Data One",
            backgroundColor: ["#41B883", "#E46651", "#00D8FF"],
            data: [1, 10, 5],
          },
        ],
      },
    };
  },

  methods: {
    async getCountCategory() {
      const data = await axios.get("api/count/category");
      // this.labeldata = data;
      console.log(data);
      // this.dataChart = {
      //   hoverBackgroundColor: "red",
      //   hoverBorderWidth: 10,
      //   labels: 
      // };
    },
    showModalPrice() {
      $("#price_info").modal("show");
    },
    async getPriceChanged() {
      const { data } = await axios.get("api/price_changed/count");
      this.priceCount = data;
    },
    // async getPriceChanged() {
    //   const { data } = await axios.get("api/price_changed/count");
    //   this.priceCount = data;
    // },
  },
  mounted() {
    this.getPriceChanged();
    this.getCountCategory();
  },
};
</script>

<style scoped>
.chart {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  /* height: 100px; */
  /* margin-top: 60px; */
}
</style>
