// Line Chart
import { Line, mixins } from 'vue-chartjs'
import { ChartConfig } from "../../constants/chart-config";

export default {
	extends: Line,
	mixins: [mixins.reactiveProp],
  	props: ['data','options'],
	mounted() {
		 this.renderChart(this.chartData,this.options)
	}
}
