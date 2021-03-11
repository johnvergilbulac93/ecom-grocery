<script>
import { Doughnut } from "vue-chartjs";

export default {
  extends: Doughnut,
  // mixins: [mixins],
  props: ["chartData", "options"],
  mounted() {
    // console.log(this.chartData);
    // this.renderChart(this.chartData,this.chartOptions);
  },
};
</script>
