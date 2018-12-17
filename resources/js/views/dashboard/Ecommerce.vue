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
					<div class="mt-4 visitor-area-chart">
						<div class="d-custom-flex justify-space-between px-4 mb-4 label-wrap">
							<nav class="nav nav-bar-chart">
							  <a class="nav-link" :class="typeTimeReturn === 'revenue' ? 'active' : '' " @click="activeTypeTime('revenue')">Revenue</a>
							  <a class="nav-link" :class="typeTimeReturn === 'day' ? 'active' : '' " @click="activeTypeTime('day')">Day</a>
							  <a class="nav-link" :class="typeTimeReturn === 'week' ? 'active' : '' " @click="activeTypeTime('week')">Week</a>
							  <a class="nav-link" :class="typeTimeReturn === 'month' ? 'active' : '' " @click="activeTypeTime('month')">Month</a>
							  <a class="nav-link" :class="typeTimeReturn === 'year' ? 'active' : '' " @click="activeTypeTime('year')">Year</a>
							</nav>
							<div class="d-custom-flex justify-space-between w-30">
								<div class="w-50">
									<h4 class="info--text mb-0">$ {{total}}</h4>
									<p class="fs-12 grey--text mb-0">Total Transaction</p>
								</div>
							</div>
						</div>
					</div>	
					<line-chart :width="300" >
					</line-chart>
					
					<div class="xl3 lg3 md3 sm12 xs12 form-inline btn-date" style="background-color:red" v-show="typeTime == 'day'">	
						<!-- Fom day -->
						<div class="style-card">
							<p>Start</p>
							<date-picker v-model="from_day" :append-to-body="true" lang="en" format="YYYY-MM-DD" width="200"
							 ></date-picker>
						</div>
					</div>
					
					<div class="xl3 lg3 md3 sm12 xs12 form-inline btn-date" style="background-color:red" v-show="typeTime == 'day'">	
						<!-- Fom day -->
						<div class="style-card">
							<p>End</p>
							<date-picker v-model="to_day" :append-to-body="true" lang="en" format="YYYY-MM-DD" width="200" 
							 ></date-picker> 
						</div>
					</div>

					<div class="xl3 btn-date" style="background-color:red" v-show="typeTime == 'day'">	
						 <button class="btn btn-success"  v-on:click="reportByRangeDay()">Report</button>
					</div>

					<!-- Month -->
					<div class="xl3 lg3 md3 sm12 xs12 form-inline btn-date" style="background-color:red" v-show="typeTime == 'month'">	
						<!-- Fom day -->
						<div class="style-card">
							<p>Start</p>
							<date-picker v-model="from_month" :append-to-body="true" lang="en" format="YYYY-MM" width="200" type="month" placeholder="Select Month"
							 ></date-picker>
						</div>
					</div>
					
					<div class="xl3 lg3 md3 sm12 xs12 form-inline btn-date" style="background-color:red" v-show="typeTime == 'month'">	
						<!-- Fom day -->
						<div class="style-card">
							<p>End</p>
							<date-picker v-model="to_month" :append-to-body="true" lang="en" format="YYYY-MM" width="200"  type="month"  placeholder="Select Month"
							 ></date-picker> 
						</div>
					</div>

					<div class="xl3 btn-date" style="background-color:red" v-show="typeTime == 'month'">	
						 <button class="btn btn-success"  v-on:click="reportByMonth()">Report</button>
					</div>


					</app-card>
				
									
							<!-- <div class="btn-date" v-show="valueSelectDateMonth == 'Day'">
		                          <button class="btn btn-success"  v-on:click="reportByRangeDay()">Report</button>
		                    </div> -->
							<!-- Range Day-->
							<!-- Report By Month -->
							<!-- <div class="btn-date" v-show="valueSelectDateMonth == 'Month'">
								<date-picker v-model="month" :append-to-body="true" lang="en" type="month" format="YYYY-MM" placeholder="Select Month" ></date-picker>
							</div>
							<div class="btn-date" v-show="valueSelectDateMonth == 'Month'">
		                          <button class="btn btn-success"  v-on:click="reportByMonth()">Report</button>
		                    </div> -->
							<!-- Report By Year -->
							<!-- <div class="btn-date" v-show="valueSelectDateMonth == 'Year'">
								<date-picker v-model="year" :append-to-body="true" lang="en" type="year" format="YYYY" placeholder="Select Year" ></date-picker>
							</div>
							<div class="btn-date" v-show="valueSelectDateMonth == 'Year'">
		                          <button class="btn btn-success"  v-on:click="reportByYear()">Report</button>
		                    </div> -->
							<!-- end By year -->
							<!-- <div class="btn-date" v-show="valueSelectDateMonth == 'Week'">
		                          <button class="btn btn-success"  v-on:click="reportByWeek()">Report</button>
		                    </div> -->
				
			</v-layout>
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

export default {
  components: {
    SocialFeeds,
    NewPost,
    DeviceShare,
    LineChart,
    DatePicker
  },
  data() {
	    return {
	     	
	      ChartConfig,
	      count_pack_basic:0,
	      count_pack_pro:0,
	      count_pack_company:0,
	      from_day:'',
	      to_day:'',
	      from_month:'',
	      to_month:'',
	      typeTime:'',
	      total:0
	      

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
			if(!this.from_day && !this.to_day){
				setTimeout(function(){
		            Vue.notify({
		                group: 'loggedIn',
		                type: 'error',
		                text: 'No Date Yet'
		            });
				},500);
			} else if (!this.to_day) {
				setTimeout(function(){
		            Vue.notify({
		                group: 'loggedIn',
		                type: 'error',
		                text: 'To Day Required'
		            });
				},500);
			} else if(!this.from_day) {
				setTimeout(function(){
		            Vue.notify({
		                group: 'loggedIn',
		                type: 'error',
		                text: 'From Day Required'
		            });
				},500);
			} else {

				var	start_day = moment(this.from_day)
				var	end_day =  moment(this.to_day)

				var day = end_day.diff(start_day,'days')

				if(day > 15) {
					setTimeout(function(){
			            Vue.notify({
			                group: 'loggedIn',
			                type: 'error',
			                text: 'Less than 15 days'
			            });
					},500);
				} else {
					let params = {
					start_day :  this.formatDate(this.from_day),
					end_day :   this.formatDate(this.to_day)
					}
					let obj = {
						params : params,
						chooes : 'Day'
					}
					this.$root.$emit('companyChart', obj)
				}
			}
		},

		reportByMonth(){
			var month = {
	      		start_month: moment(this.from_month, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM-DD'),
	      		end_month:moment(this.to_month, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM-DD')
	      	}
			let obj = {
					params : month,
					chooes : 'Month'
				}
			this.$root.$emit('companyChart', obj)
		},

		reportByYear(){
			var year = {
	      			year:moment(this.year, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM')
	      	}
			let obj = {
					params : year,
					chooes : 'Year'
				}
			this.$root.$emit('companyChart', obj)

		},

		reportByWeek(){
			let params = {
					week :  'week'
			}
			let obj = {
					params : params,
					chooes : 'Week'
			}
			this.$root.$emit('companyChart', obj)

		},

		activeTypeTime(time) {
  			this.typeTime = time

  			if(this.typeTime == "day"){
  				this.defaultReportSevenDay()
  			}
  		},

  		defaultReportSevenDay(){

  			let params = {
					defaultDay :  'default'
			}

  			let obj = {
					params : params,
					chooes : 'SevenDay'
			}
			this.$root.$emit('companyChart', obj)
  	
  		}
		// getData(params){

		// 	let url = config.API_URL+'report-incomes-package'

		// 	this.week = this.valueSelectDateMonth

		// 	getWithData(url,params)
		// 	.then((res) => {
		// 		if(res.data.success && res){
		// 			if(this.week == "Week") {
		// 				var dataWeek =[];
		//                 _.forEach(res.data.data,function(value,key){
		//                   dataWeek.unshift(value);
		//                 });
  //               		this.handleDataWeek(dataWeek);

		// 			}else {
		// 				this.handleDataDaily(res.data.data);
		// 			}
		// 		}
				
		// 	})
		// 	.catch((err) => {
		// 		console.log(err)
		// 	})
		// },

		// handleDataDaily(data){
		// 	var lables = []
	 //        var total = []
	 //        _.forEach(data, function(value, key) {
	 //            lables.push(key)
	 //            total.push(value.total)
	 //        });

	 //        this.renderData(lables,total);

		// },

		// handleDataWeek(data){

		// 	var lables = []
	 //        var total = []
	 //        _.forEach(data, function(value, key) {
	 //          lables.push(moment(value['startOfWeek']).format('MMM-DD') + ' / ' + moment(value['endOfWeek']).format('MMM-DD'))
	 //          total.push(value.total)                      
	 //        });
	 //        this.renderData(lables,total);

		// },

		// renderData(lables,total){
			
	 //        this.datacollection = {
		// 		labels: lables,
		// 		datasets: [
		// 			{
		// 				label: 'Total Transaction',
		// 				backgroundColor: '#f87979',
		// 				fill: false,
		// 				lineTension: 0.4,
		// 				borderColor: '#5D92F4',
		// 	            pointBorderColor: '#5D92F4',
		// 	            pointBorderWidth: 2,
		// 	            pointRadius: 3,
		// 	            pointBackgroundColor: '#FFF',
	 //              		borderWidth: 3,
		// 				data: total
		// 			}
		// 		]
		// 	}
  //     	},


	},
	created(){
		this.fetchData()
		
	},
	computed:{

	  	typeTimeReturn(){
	  		return this.typeTime
	  	}
	},
	mounted() {

	    this.$root.$on('totalTransaction', res => {
	       	this.total = res
	    });
  	}


};
</script>


<style lang="css" scoped>
.btn-date {
	display: inline-block;
    margin: 30px 10px 0px 0px;;
}
.nav-bar-chart{
	font-size:20px;
	font-weight: bold;
}

.nav-link {
		color: #6b6d70 !important;
}

.active{
		color: #2196f3 !important;
}
.style-card {
	padding: 15px !important;
}
.style-card p {
	margin: 0px 0px 5px 5px;
    font-size: 17px;
}
</style>
