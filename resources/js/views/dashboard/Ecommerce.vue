<template>
	<v-container fluid pt-0 grid-list-xl>
			<section-tooltip :title="$t('message.overview')" :tooltip="$t('message.dashboardOverview')"></section-tooltip>
			<!-- Dash Cards -->
			<v-layout row wrap border-rad-sm overflow-hidden>
				<stats-card-v2
					colClasses="xl3 lg3 md3 sm6 xs12"
					:heading="$t('message.totalcompany')"
					:amount="count_pack_company"
					:icon="$t('zmdi zmdi-account-calendar')"
					customClasses="style-card-user"
				>
				<!-- <div class="pa-4">
				</div> -->
				</stats-card-v2>
				<stats-card-v2
					colClasses="xl3 lg3 md3 sm6 xs12"
					:heading="$t('message.totalpackagebasic')"
					:amount="count_pack_basic"
					:icon="$t('zmdi zmdi-card')"
					customClasses="style-card-basic"
					
				>
				<!-- <div class="pa-4">
				</div> -->
				</stats-card-v2>
				<stats-card-v2
					colClasses="xl3 lg3 md3 sm12 xs12"
					:heading="$t('message.totalpackagepro')"
					:amount="count_pack_pro"
					:icon="$t('zmdi zmdi-card-membership')"
					customClasses="style-card-pro"


				>
				<!-- <div class="pa-4">
					
				</div> -->
				</stats-card-v2>
				<stats-card-v2
					colClasses="xl3 lg3 md3 sm12 xs12"
					:heading="$t('message.totalimagesuploads')"
					:amount="2145"
					:icon="$t('zmdi zmdi-camera')"
					customClasses="style-card-image"
				>
				<!-- <div class="pa-4">
					<line-chart-shadow
						:dataSet="onlineRevenue"
						:lineTension="0.4"
						:dataLabels="labels"
						:width="370"
						:height="80"
						:borderWidth=3
						:enableGradient='false'
						:enableShadow='false'
						:borderColor="ChartConfig.color.warning">
					</line-chart-shadow>
				</div> -->
				</stats-card-v2>
			</v-layout>
			<!-- Sales -->
			<v-layout row wrap>
				<app-card
					:heading="$t('message.sales')"
					colClasses="xl12 lg12 md12 sm12 xs12"
					customClasses="mb-0 sales-widget"
					:fullScreen="true"
					:reloadable="true"
					:closeable="false"
				>
				<div class="ladgend-wrapper mb-3">
						<div class="col-md-12 form-inline">	
							<div class="col-md-2">
								<select class="search-input-select form-control font-weight-bold" type="select" aria-controls="example" v-model="valueSelectDateMonth">
                                    <option v-for="option in selectDate">
                                        {{option}}
                                    </option>
                                </select>
							</div>
							<!-- Report By Range Day -->
							<div class="btn-date" v-show="valueSelectDateMonth == 'Day'">
								<date-picker v-model="range" :append-to-body="true" range lang="en" format="YYYY-MM-DD" width="200"
								 ></date-picker>
							</div>
							<div class="btn-date" v-show="valueSelectDateMonth == 'Day'">
		                          <button class="btn btn-success"  v-on:click="reportByRangeDay()">Report</button>
		                    </div>
							<!-- Range Day-->
							<!-- Report By Month -->
							<div class="btn-date" v-show="valueSelectDateMonth == 'Month'">
								<date-picker v-model="month" :append-to-body="true" lang="en" type="month" format="YYYY-MM" placeholder="Select Month" ></date-picker>
							</div>
							<div class="btn-date" v-show="valueSelectDateMonth == 'Month'">
		                          <button class="btn btn-success"  v-on:click="reportByMonth()">Report</button>
		                    </div>
							<!-- Report By Year -->
							<div class="btn-date" v-show="valueSelectDateMonth == 'Year'">
								<date-picker v-model="year" :append-to-body="true" lang="en" type="year" format="YYYY" placeholder="Select Year" ></date-picker>
							</div>
							<div class="btn-date" v-show="valueSelectDateMonth == 'Year'">
		                          <button class="btn btn-success"  v-on:click="reportByYear()">Report</button>
		                    </div>
							<!-- end By year -->
							<div class="btn-date" v-show="valueSelectDateMonth == 'Week'">
		                          <button class="btn btn-success"  v-on:click="reportByWeek()">Report</button>
		                    </div>
						</div>
				</div>			
				 <line-chart :options="options" :chart-data="datacollection">
				  </line-chart>
				</app-card>
				<!-- Devices Share -->
				<!-- <app-card
					colClasses="xl4 lg5 md5 sm6 xs12"
					:heading="$t('message.devicesShare')"
					:fullScreen="true"
					:reloadable="true"
					:closeable="true"
					customClasses="device-share-widget"
				>
					<device-share></device-share>
				</app-card> -->
			</v-layout>
			<TransactionHistories></TransactionHistories>
			<!-- Social Feeds -->
<!-- 			<v-layout row wrap>
				<app-card
					colClasses="xl3 lg3 md3 sm6 xs12"
					customClasses="social-share-wrap"
				>	
					<social-feeds 
						socialIcon="zmdi zmdi-facebook"
						friends="89K"
						feeds="459"
						type="facebook"
					>
					</social-feeds>
				</app-card>					
				<app-card
					colClasses="xl3 lg3 md3 sm6 xs12"
					customClasses="social-share-wrap"
				>	
					<social-feeds 
						socialIcon="zmdi zmdi-twitter"
						friends="65K"
						feeds="350"
						type="twitter"
					>
					</social-feeds>
				</app-card>
				<app-card
					colClasses="xl3 lg3 md3 sm6 xs12"
					customClasses="social-share-wrap"
				>	
					<social-feeds 
						socialIcon="zmdi zmdi-linkedin"
						friends="35K"
						feeds="689"
						type="linkedin"
					>
					</social-feeds>
				</app-card>
				<app-card
					colClasses="xl3 lg3 md3 sm6 xs12"
					customClasses="social-share-wrap"
				>	
					<social-feeds 
						socialIcon="zmdi zmdi-google"
						friends="90K"
						feeds="1000"
						type="google"
					>
					</social-feeds>
				</app-card>
			</v-layout>
			<v-layout row wrap>	
				<app-card 
					colClasses="xs12 sm12 md4 lg4"
					:heading="$t('message.newPost')"
					:fullScreen="true" 
					:reloadable="true" 
					:closeable="true"
					customClasses="blog-widget"
				>
					<new-post></new-post>
				</app-card>
			</v-layout> -->
		</v-container>
</template>

<script>
// charts component
import LineChart from './LineChart.js'

// widgets
import SocialFeeds from "../../components/Widgets/SocialFeeds";
import NewPost from "../../components/Widgets/AddNewBlog";
import DeviceShare from "../../components/Widgets/DeviceShare";

import { ChartConfig } from "../../constants/chart-config";

//config 
import config from '../../config/index.js'
import { get, getWithData } from '../../api/index.js'
import DatePicker from 'vue2-datepicker'
import moment from 'moment'
import Vue from 'vue'
import TransactionHistories from './TransactionHistories'

export default {
  components: {
    SocialFeeds,
    NewPost,
    DeviceShare,
    LineChart,
    DatePicker,
    TransactionHistories
  },
  data() {
	    return {
	     	
	      ChartConfig,
	      count_pack_basic:0,
	      count_pack_pro:0,
	      count_pack_company:0,
	      datacollection: null,
	      options: {
	        responsive: true, 
	        maintainAspectRatio: false,
	        legend: {
               display: false
            }
	      },
	      selectDate:['---Choose---','Day','Month','Year','Week'],
	      valueSelectDateMonth:'---Choose---',
	      range:'',
	      month:'',
	      year:'',
	      week:'',	      

	    };
	},
	methods:{
		formatDate(date) {
          if(date){
              return moment(date, 'YYYY-MM-DD hh:mm:ss').format('MM/DD/YYYY');
          }
      	},
		fetchData(){
			let url = config.API_URL+'count-packages'
			get(url)
			.then((res)=>{
				if(res.data && res.data.success){
					this.count_pack_basic = res.data.data.count_basic	
					this.count_pack_pro = res.data.data.count_pro	
					this.count_pack_company = res.data.data.total_count_company	
				}
			})
			.catch((err)=>{

			})
		},
		reportByRangeDay() {
			var	start_day = moment(this.range[0])
			var	end_day =  moment(this.range[1])

			var day = end_day.diff(start_day,'days')

			if(day > 30) {
				setTimeout(function(){
		            Vue.notify({
		                group: 'loggedIn',
		                type: 'error',
		                text: 'Less than 30 days'
		            });
				},500);
			}
			else {
				let params = {
					start_day :  this.formatDate(this.range[0]),
					end_day :   this.formatDate(this.range[1])
				}
				this.getData(params);
			}
		},

		reportByMonth(){
			var month = {
	      			month:moment(this.month, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM-DD')
	      	}
			this.getData(month);
		},

		reportByYear(){
			var year = {
	      			year:moment(this.year, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM')
	      	}
			this.getData(year);
		},

		reportByWeek(){
			let params = {
					week :  'week'
			}
			this.getData(params);
			// console.log(this.valueSelectDateMonth)
		},

		getData(params){

			let url = config.API_URL+'report-incomes-package'

			this.week = this.valueSelectDateMonth

			getWithData(url,params)
			.then((res) => {
				if(res.data.success && res){
					if(this.week == "Week") {
						var dataWeek =[];
		                _.forEach(res.data.data,function(value,key){
		                  dataWeek.unshift(value);
		                });
                		this.handleDataWeek(dataWeek);

					}else {
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

	        this.renderData(lables,total);

		},

		handleDataWeek(data){

			var lables = []
	        var total = []
	        _.forEach(data, function(value, key) {
	          lables.push(moment(value['startOfWeek']).format('MMM-DD') + ' / ' + moment(value['endOfWeek']).format('MMM-DD'))
	          total.push(value.total)                      
	        });
	        this.renderData(lables,total);

		},

		renderData(lables,total){
	        this.datacollection = {
				labels: lables,
				datasets: [
					{
						label: 'Total Transaction',
						backgroundColor: '#f87979',
						fill: false,
						lineTension: 0.4,
						borderColor: '#5D92F4',
			            pointBorderColor: '#5D92F4',
			            pointBorderWidth: 2,
			            pointRadius: 3,
			            pointBackgroundColor: '#FFF',
	              		borderWidth: 3,
						data: total
					}
				]
			}
      	},


	},
	created(){
		this.fetchData()
		this.valueSelectDateMonth = "Week"
		this.reportByWeek()
		this.valueSelectDateMonth = "---Choose---"
		
	}

};
</script>


<style lang="css" scoped>
.row {
	/*margin-right: 15px !important;
	margin-left: 15px !important;*/
	
}
.btn-date {
	display: inline-block;
    margin: 15px;
}
</style>
