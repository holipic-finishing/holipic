import { Line } from 'vue-chartjs'
import config from '../../config/index.js'
import Vue from 'vue'
import moment from "moment"
import {ChartConfig} from "../../constants/chart-config"
import {hexToRgbA} from "../../helpers/helpers"
import { get, getWithData } from '../../api/index.js'


export default {
  extends: Line,
  data() {
    return {
      data: [],
      labels: [],
      gradient1: null,
      line: null,
      options: {
        responsive: true, 
        maintainAspectRatio: false,
        scales: {
           yAxes: [{
              ticks: {
                 beginAtZero: true,
                 display: false
              },
              gridLines: {
                 display: false,
                 drawBorder: false,
                 drawTicks: false
              }
           }],
           xAxes: [{
              ticks: {
                 display: true,
                 beginAtZero: true
              },
              gridLines: {
                 display: false,
                 drawBorder: false
              }
           }]
        },
        legend: {
           display: false
        }
  	  },
       chooes:''
    }
  },
  created(){
    this.fetchData();

  },

  mounted() {
    
    this.$root.$on('companyChart', res => {
       	this.getData(res.params)
       	this.chooes = res.chooes
    });
  },

  methods: {
    renderChartData(labels, data){
    
      let gradientColor = ' '
      this.gradient1 = this.$refs.canvas.getContext('2d').createLinearGradient(0, 200, 0, 0)
      this.gradient1.addColorStop(0, hexToRgbA(ChartConfig.color.white, 0.2))
      this.gradient1.addColorStop(0.5, hexToRgbA(ChartConfig.color.info, 0.2))


      this.renderChart({
         labels: labels,
         datasets: [
            {
                label: 'Total Transaction',
                data: data,
                backgroundColor: this.gradient1,
                borderColor: ChartConfig.color.info,
                lineTension: 0.4,
	            // pointBorderColor: '#17a2b8',
	            // pointBorderWidth: 2,
	            // pointRadius: 2,
	            // pointBackgroundColor: '#FFF',
	      		// borderWidth: 3,
                fill: true
            }
         ]
      }, this.options);
    },
 
    fetchData() {
		let params = {
					defaultDay :  'default'
		}
		this.getData(params);
    },

    getData(params){

			let url = config.API_URL+'report-incomes-package'

			getWithData(url,params)
			.then((res) => {
				if(res.data.success && res){
					if(this.chooes == "Week") {
						var dataWeek =[]
						var total = 0
              _.forEach(res.data.data,function(value,key){
                dataWeek.unshift(value);
                total = total + parseFloat(value.total)

              });
              total = total.toFixed(3)

              this.$root.$emit('totalTransaction', total)
          		this.handleDataWeek(dataWeek);


					}else {
						var total = 0
						_.forEach(res.data.data,function(value,key){
		            total = total + parseFloat(value.total)
   
		          });
              total = total.toFixed(3)
		        this.$root.$emit('totalTransaction', total)
						this.handleDataDaily(res.data.data);
					}
				}
				
			})
			.catch((err) => {
				console.log(err)
			})
	},

	handleDataDaily(data){
			var lables = []
	        var total = []
	        _.forEach(data, function(value, key) {
	            lables.push(key)
	            total.push(value.total)
	        });

	        this.renderChartData(lables,total);

		},

	handleDataWeek(data){

			var lables = []
	        var total = []
	        _.forEach(data, function(value, key) {
	          lables.push(moment(value['startOfWeek']).format('MM-DD') + ' / ' + moment(value['endOfWeek']).format('MM-DD'))
	          total.push(value.total)                      
	        });
	        this.renderChartData(lables,total);

	},


  }
}

