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
				
					<div class="mt-12 visitor-area-chart background-transparent col-sm-12">
						<div class="d-custom-flex justify-space-between px-4 mb-4 label-wrap">
							<nav class="nav nav-bar-chart">
							  <a class="nav-link" :class="typeTimeReturn === 'revenue' ? 'active' : '' " @click="activeTypeTime('revenue')">Revenue</a>
							  <a class="nav-link" :class="typeTimeReturn === 'day' ? 'active' : '' " @click="activeTypeTime('day')">Day</a>
							  <a class="nav-link" :class="typeTimeReturn === 'week' ? 'active' : '' " @click="activeTypeTime('week')">Week</a>
							  <a class="nav-link" :class="typeTimeReturn === 'month' ? 'active' : '' " @click="activeTypeTime('month')">Month</a>
							  <a class="nav-link" :class="typeTimeReturn === 'year' ? 'active' : '' " @click="activeTypeTime('year')">Year</a>
							</nav>
							<div class="d-custom-flex ">
								<div class="">
									<h3 class="info--text mb-0 active">$ {{total}}</h3>
									<p class="fs-12 grey--text mb-0 total-transaction">Total Transaction</p>
								</div>
							</div>
						</div>
						<line-chart :width="300" >
						</line-chart>
					</div>
				<div class="wrap-card-body">
						<div class="card-body" v-show="typeTime == 'day'">
							<p class="text-primary">(*) Please No choose more than 15 days</p>
							<div class="row">
								<div class="xl3 lg3 md3 sm12 xs12 form-inline btn-date time-default"  >	
									<!-- Fom day -->
									<div class="style-card start-day">
										<p>Start</p>
										<!-- <date-picker v-model="from_day" :append-to-body="true" lang="en" format="YYYY-MM-DD" width="200"
										 ></date-picker> --> 
										<v-menu 
										ref="menu" 
										lazy 
										:close-on-content-click="false" 
										v-model="menu" 
										transition="scale-transition" 
										offset-y 
										full-width 
										:nudge-right="40" 
										min-width="290px" 
										:return-value.sync="from_day"

										>
										<v-text-field slot="activator" label="Start Day" v-model="from_day" prepend-icon="event" readonly></v-text-field>
										<v-date-picker v-model="from_day" no-title scrollable :max="new Date().toISOString().substr(0, 10)">
											<v-spacer></v-spacer>
											<v-btn color="primary" @click="menu = false">Cancel</v-btn>
											<v-btn color="warning" @click="$refs.menu.save(from_day)">OK</v-btn>
										</v-date-picker>
										</v-menu>
									</div>
								</div>
								
								<div class="xl3 lg3 md3 sm12 xs12 form-inline btn-date time-default"  >	
									<!-- Fom day -->
									<div class="style-card">
										<p>End</p>
										<!-- <date-picker v-model="to_day" :append-to-body="true" lang="en" format="YYYY-MM-DD" width="200" 
										 ></date-picker> -->

										 <v-menu 
												ref="menu2" 
												lazy 
												:close-on-content-click="false" 
												v-model="menu2" 
												transition="scale-transition" 
												offset-y 
												full-width 
												:nudge-right="40" 
												min-width="290px" 
												:return-value.sync="to_day"
												>
												<v-text-field slot="activator" label="End Day" v-model="to_day" prepend-icon="event" readonly></v-text-field>
												<v-date-picker v-model="to_day" no-title scrollable :max="new Date().toISOString().substr(0, 10)">
													<v-spacer></v-spacer>
													<v-btn color="primary" @click="menu2 = false">Cancel</v-btn>
													<v-btn color="warning" @click="$refs.menu2.save(to_day)">OK</v-btn>
												</v-date-picker>
											</v-menu>
									</div>
								</div>
							</div>
							

							<div class="xl3 btn-date" >	
								 <button class="btn btn-success"  v-on:click="reportByRangeDay()">Report</button>
							</div>
						</div>	
						<!-- Month -->
						<div class="card-body" v-show="typeTime == 'month'">
							<p class="text-primary">(*) Please No choose more than 12 month</p>
							<div class="row">
								<div class="xl3 lg3 md3 sm12 xs12 form-inline btn-date time-default" >	
									<!-- Fom day -->
									<div class="style-card">
										<p>Start</p>
										<!-- <date-picker v-model="from_month" :append-to-body="true" lang="en" format="YYYY-MM" width="200" type="month" placeholder="Select Month"
										 ></date-picker> -->

										  <v-menu 
												ref="menu3" 
												lazy 
												:close-on-content-click="false" 
												v-model="menu3" 
												transition="scale-transition" 
												offset-y 
												full-width 
												:nudge-right="40" 
												min-width="290px" 
												:return-value.sync="from_month"
												>
												<v-text-field slot="activator" label="Start Month" v-model="from_month" prepend-icon="event" readonly></v-text-field>
												<v-date-picker v-model="from_month" no-title scrollable :max="new Date().toISOString().substr(0, 10)"type="month">
													<v-spacer></v-spacer>
													<v-btn color="primary" @click="menu3 = false">Cancel</v-btn>
													<v-btn color="warning" @click="$refs.menu3.save(from_month)">OK</v-btn>
												</v-date-picker>
											</v-menu>

									</div>
								</div>
								
								<div class="xl3 lg3 md3 sm12 xs12 form-inline btn-date time-default" >	
									<!-- Fom day -->
									<div class="style-card">
										<p>End</p>
										<!-- <date-picker v-model="to_month" :append-to-body="true" lang="en" format="YYYY-MM" width="200"  type="month"  placeholder="Select Month"
										 ></date-picker>  -->

										 <v-menu 
												ref="menu4" 
												lazy 
												:close-on-content-click="false" 
												v-model="menu4" 
												transition="scale-transition" 
												offset-y 
												full-width 
												:nudge-right="40" 
												min-width="290px" 
												:return-value.sync="to_month"
												>
												<v-text-field slot="activator" label="End Month" v-model="to_month" prepend-icon="event" readonly></v-text-field>
												<v-date-picker v-model="to_month" no-title scrollable :max="new Date().toISOString().substr(0, 10)"type="month">
													<v-spacer></v-spacer>
													<v-btn color="primary" @click="menu4 = false">Cancel</v-btn>
													<v-btn color="warning" @click="$refs.menu4.save(to_month)">OK</v-btn>
												</v-date-picker>
											</v-menu>
									</div>
								</div>
							</div>

							<div class="xl3 btn-date">	
								 <button class="btn btn-success"  v-on:click="reportByMonth()">Report</button>
							</div>
						</div>
						<!-- Year -->
						<div class="card-body" v-show="typeTime == 'year'">
							<p class="text-primary">(*) Please No choose more than 5 year</p>

							<div class="row">
								<div class="xl3 lg3 md3 sm12 xs12 form-inline btn-date time-default" >	
								<!-- Fom day -->
								<div class="style-card">
									<p>Start</p>
									<!-- <date-picker v-model="from_year" :append-to-body="true" lang="en" format="YYYY" width="200" type="year" placeholder="Select Year"
									 ></date-picker> -->

									 <v-menu
									      ref="menu5"
									      :close-on-content-click="false"
									      v-model="menu5"
									      :nudge-right="40"
									      lazy
									      transition="scale-transition"
									      offset-y
									      full-width
									      min-width="290px"
									      
									    >
									      <v-text-field
									        slot="activator"
									        v-model="from_year"
									        label="Start Year"
									        prepend-icon="event"
									        readonly
									        
									      ></v-text-field>
									      <v-date-picker
									        ref="picker"
									        v-model="from_year"
									        @input="saveStartYear"
									        reactive
									        no-title
									        :max="defaultYear"
									        type="year"
									      ></v-date-picker>
									    </v-menu>

								</div>
							</div>
							
							<div class="xl3 lg3 md3 sm12 xs12 form-inline btn-date time-default" >	
								<!-- Fom day -->
								<div class="style-card">
									<p>End</p>
									<!-- <date-picker v-model="to_year" :append-to-body="true" lang="en" format="YYYY" width="200"  type="year"  placeholder="Select Year"
									 ></date-picker>  -->


									  <v-menu
									      ref="menu6"
									      :close-on-content-click="false"
									      v-model="menu6"
									      :nudge-right="40"
									      lazy
									      transition="scale-transition"
									      offset-y
									      full-width
									      min-width="290px"
									      
									    >
									      <v-text-field
									        slot="activator"
									        v-model="to_year"
									        label="End Year"
									        prepend-icon="event"
									        readonly
									        
									      ></v-text-field>
									      <v-date-picker
									        ref="picker2"
									        v-model="to_year"
									        @input="saveEndYear"
									        reactive
									        no-title
									        :max="defaultYear"
									        type="year"
									      ></v-date-picker>
									    </v-menu>
								</div>
							</div>
							</div>
							
							<div class="xl3 btn-date" >	
								 <button class="btn btn-success"  v-on:click="reportByYear()">Report</button>
							</div>
						</div>	
						<!-- Week -->
						<div class="card-body" v-show="typeTime == 'week'">
							<p class="text-primary">(*) Please No choose more than 6 week</p>
							
								<div class="row">
									<div class="xl3 lg3 md3 sm12 xs12 form-inline btn-date time-default" >	
									<!-- Fom day -->
									<div class="style-card">
										<p>Start</p>
										<!-- <date-picker v-model="from_day_week" :append-to-body="true" lang="en" format="YYYY-MM-DD" width="200" placeholder="Select date"
										 ></date-picker> -->

										  <v-menu 
												ref="menu7" 
												lazy 
												:close-on-content-click="false" 
												v-model="menu7" 
												transition="scale-transition" 
												offset-y 
												full-width 
												:nudge-right="40" 
												min-width="290px" 
												:return-value.sync="from_day_week"
												>
												<v-text-field slot="activator" label="Select date" v-model="from_day_week" prepend-icon="event" readonly></v-text-field>
												<v-date-picker v-model="from_day_week" no-title scrollable :max="new Date().toISOString().substr(0, 10)">
													<v-spacer></v-spacer>
													<v-btn color="primary" @click="menu7 = false">Cancel</v-btn>
													<v-btn color="warning" @click="$refs.menu7.save(from_day_week)">OK</v-btn>
												</v-date-picker>
											</v-menu>


									</div>
								</div>
								
								<div class="xl3 lg3 md3 sm12 xs12 form-inline btn-date time-default" >	
									<!-- Fom day -->
									<div class="style-card">
										<p>End</p>
										<!-- <date-picker v-model="to_day_week" :append-to-body="true" lang="en" format="YYYY-MM-DD" width="200"  placeholder="Select date"
										 ></date-picker> -->

										 <v-menu 
												ref="menu8" 
												lazy 
												:close-on-content-click="false" 
												v-model="menu8" 
												transition="scale-transition" 
												offset-y 
												full-width 
												:nudge-right="40" 
												min-width="290px" 
												:return-value.sync="to_day_week"
												>
												<v-text-field slot="activator" label="Select date" v-model="to_day_week" prepend-icon="event" readonly></v-text-field>
												<v-date-picker v-model="to_day_week" no-title scrollable :max="new Date().toISOString().substr(0, 10)">
													<v-spacer></v-spacer>
													<v-btn color="primary" @click="menu8 = false">Cancel</v-btn>
													<v-btn color="warning" @click="$refs.menu8.save(to_day_week)">OK</v-btn>
												</v-date-picker>
											</v-menu>
									</div>
								</div>
								</div>
								
					

							<div class="xl3 btn-date" >	
								 <button class="btn btn-success"  v-on:click="reportByWeek()">Report</button>
							</div>
						</div>

						<div class="card-body" v-show="typeTime != 'revenue'">
							<p class="text-primary"> </p>
							<div class="row total-default">
								<div class="xl3 lg3 md3 sm12 xs12 form-inline btn-date time-default">	
									<!-- Fom day -->
									<div class="style-card">
										<!-- <app-card> -->
										

										<div class="d-custom-flex justify-space-between fix-total-storage-company">
											<div class="title-total">
												<h2>{{totalCompany}}</h2>
												Total companies
											</div>
											<div> 
												<span class="icon-style fix-icon-storage-company">
													<i class="material-icons font-2x primary--text">store</i>
												</span>
											</div>
										</div>
									<!-- </app-card> -->

									</div>
								</div>
								<div class="xl3 lg3 md3 sm12 xs12 form-inline btn-date time-default">	
									<!-- Fom day -->
									<div class="style-card">
										<div class="d-custom-flex justify-space-between fix-total-storage-company">
											<div class="title-total">
												<h2>14,200</h2>
												Total Storage MB
											</div>
											<div> 
												<span class="icon-style fix-icon-storage-company">
													<i class="material-icons font-2x success--text">cloud_upload</i>
												</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					
				</div>
				
			</v-layout>

			<transactions></transactions>
			<!--<TransactionHistories></TransactionHistories>-->
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
import Transactions from './Transactions'
import StatsCardV3 from '../../components/StatsCardV3/StatsCardV3.vue'

export default {
  components: {
    SocialFeeds,
    NewPost,
    DeviceShare,
    LineChart,
    DatePicker,
    TransactionHistories,
    Transactions,
    StatsCardV3
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
	      from_year:'',
	      to_year:'',
	      typeTime:'day',
	      total:0,
	      from_day_week:'',
	      to_day_week:'',
	      validate:false,
	      menu: false,
	      menu2:false,
	      menu3:false,
	      menu4:false,
	      menu5:false,
	      menu6:false,
	      menu7:false,
	      menu8:false,
	      date: '',
	      defaultYear : new Date().getUTCFullYear() +'/01/01',
	      totalCompany:''

	    };
	},
	methods:{
		formatDate(date) {
          if(date){
              return moment(date, 'YYYY-MM-DD hh:mm:ss').format('MM/DD/YYYY');
          }
      	},

      	saveStartYear(year) {

  			this.$refs.menu5.save(year);
	      	this.$refs.picker.activePicker = 'YEAR'
	      	this.from_year = year.substr(0,4)
	      	this.menu5 = false;
  		},

  		saveEndYear(year2) {
  			this.$refs.menu6.save(year2);
	      	this.$refs.picker2.activePicker = 'YEAR'
	      	this.to_year = year2.substr(0,4)
	      	this.menu6 = false;
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

		Validations(from,to,value){

			if(!from && !to){
				setTimeout(function(){
		            Vue.notify({
		                group: 'loggedIn',
		                type: 'error',
		                text: 'No '+value+' Yet'
		            });
				},500);
			} else if (!to) {
				setTimeout(function(){
		            Vue.notify({
		                group: 'loggedIn',
		                type: 'error',
		                text: 'To '+value+' Required'
		            });
				},500);
			} else if(!from) {
				setTimeout(function(){
		            Vue.notify({
		                group: 'loggedIn',
		                type: 'error',
		                text: 'From '+value+' Required'
		            });
				},500);
			} else { 
				this.validate = true
			}
		},

		reportByRangeDay() {
			this.Validations(this.from_day,this.to_day,'Days')
			if(this.validate == true)
			{	
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
				}  else if(day <=0) {

					setTimeout(function(){
			            Vue.notify({
			                group: 'loggedIn',
			                type: 'error',
			                text: 'To days Large from days'
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
					this.$root.$emit('loadTransactionsWithTime', obj)
					this.validate = false
				}
			}

		},

		reportByMonth(){
			this.Validations(this.from_month,this.to_month,'Month')
			if(this.validate == true)
			{
				var	start_month = moment(this.from_month)
				var	end_month =  moment(this.to_month)

				var month = end_month.diff(start_month,'month')

				if(month > 12) {
					setTimeout(function(){
			            Vue.notify({
			                group: 'loggedIn',
			                type: 'error',
			                text: 'Less than 12 Month'
			            });
					},500);
				} else if(month <=0) {

					setTimeout(function(){
			            Vue.notify({
			                group: 'loggedIn',
			                type: 'error',
			                text: 'To month Large from month'
			            });
					},500);
				
				} else {
					var month = {
			      		start_month: moment(this.from_month, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM-DD'),
			      		end_month:moment(this.to_month, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM-DD')
		      		}
					let obj = {
							params : month,
							chooes : 'Month'
						}
					this.$root.$emit('companyChart', obj)
					this.$root.$emit('loadTransactionsWithTime', obj)

					this.getTotalCompanies(this.typeTime, this.from_month, this.to_month)
					this.validate = false
				}
			}

		},

		reportByYear(){
			this.Validations(this.from_year,this.to_year,'Year')
			if(this.validate == true)
			{
				var	start_year = moment(this.from_year)
				var	end_year =  moment(this.to_year)

				var year = end_year.diff(start_year,'year')

				if(year > 5) {
					setTimeout(function(){
			            Vue.notify({
			                group: 'loggedIn',
			                type: 'error',
			                text: 'Less than 5 Year'
			            });
					},500);
				} else if (year <=0) {

					setTimeout(function(){
			            Vue.notify({
			                group: 'loggedIn',
			                type: 'error',
			                text: 'To year Large from year'
			            });
					},500);

				} else {
					var year = {
	      				start_year:moment(this.from_year, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM'),
	      				end_year:moment(this.to_year, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM')		
			      	}
					let obj = {
							params : year,
							chooes : 'Year'
					}
					this.$root.$emit('companyChart', obj)
					this.$root.$emit('loadTransactionsWithTime', obj)
					this.validate = false
				}
			}
		},

		reportByWeek(){
			this.Validations(this.from_day_week,this.to_day_week,'Days')
			if(this.validate == true)
			{
				var	start_day = moment(this.from_day_week)
				var	end_day =  moment(this.to_day_week)

				var day = end_day.diff(start_day,'days')
		
				if(day > 42) {
					setTimeout(function(){
			            Vue.notify({
			                group: 'loggedIn',
			                type: 'error',
			                text: 'Less than 6 Week'
			            });
					},500);

				}  else if(day <=0) {

					setTimeout(function(){
			            Vue.notify({
			                group: 'loggedIn',
			                type: 'error',
			                text: 'To days Large from days'
			            });
					},500);

				} else {

					let params = {
						start_day_week :  this.formatDate(this.from_day_week),
						end_day_week :   this.formatDate(this.to_day_week)
					}
					let obj = {
							params : params,
							chooes : 'Week'
					}
					this.$root.$emit('companyChart', obj)
					this.$root.$emit('loadTransactionsWithTime', obj)
				}
			}
		
		},

		activeTypeTime(time) {
  			this.typeTime = time

  			if(this.typeTime == "day"){
  				this.defaultReportSevenDay()
  				this.from_day=''
  				this.to_day= ''
  			}

  			if(this.typeTime == "month"){
  				this.defaultReportMonth()
  				this.from_month=''
	      		this.to_month=''
  			}

  			if(this.typeTime == "year") {
  				this.defaultReportYear()
  				this.from_year=''
	      		this.to_year=''
  			}

  			if(this.typeTime == "revenue") {
  				this.defaultReportSevenDay()
  			}

  			if(this.typeTime == "week") {
  				this.defaultReportWeek()
  				this.from_day_week=''
	      		this.to_day_week=''
  			}

  			this.getTotalCompanies(this.typeTime)
  			
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
			this.$root.$emit('loadTransactionsWithTime', obj)
  	
  		},

  		defaultReportMonth(){
  			let params = {
					defaultMonth :  'default'
			}

  			let obj = {
					params : params,
					chooes : 'Month'
			}
			this.$root.$emit('companyChart', obj)
			this.$root.$emit('loadTransactionsWithTime', obj)
  		},

  		defaultReportYear(){
  			let params = {
					defaultYear :  'default'
			}

  			let obj = {
					params : params,
					chooes : 'year'
			}
			this.$root.$emit('companyChart', obj)
			this.$root.$emit('loadTransactionsWithTime', obj)
  		},

  		defaultReportWeek(){
  			let params = {
					defaultWeek :  'default'
			}

  			let obj = {
					params : params,
					chooes : 'Week'
			}
			this.$root.$emit('companyChart', obj)
			this.$root.$emit('loadTransactionsWithTime', obj)
  		},

  		getTotalCompanies(typeTime, fromTime = '', toTime = '') {
  			axios.get(config.API_URL+'transactions/companies/total?choose='+typeTime+'&fromTime='+fromTime+'&toTime='+toTime)
			.then(response => {
				
				if(response && response.data.success) {
					this.totalCompany = response.data.data					
				}
			})
  		}
	},
	created(){
		this.fetchData()

		this.getTotalCompanies(this.typeTime)

		
		//this.typeTime = "revenue"
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
    margin: 0px 10px 0px 0px;;
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
	padding: 5px !important;
	margin-left: 15px;
    background-color: white;
	/*width: 400px;*/

}
.style-card p {
	margin: 0px 0px 5px 0px;
    font-size: 17px;
    font-weight: 700;
}
.card-body p{
	margin: 0px 0px 5px 5px;
}
.card-body {
	flex: 0 0 50%;
    max-width: 50%;
    display: flex;
    flex-direction: column;
}

.card-body2{
	float:right;
	right:0px;
	position: absolute;
}

.background-transparent{
	background-color: transparent !important;
}

.total-transaction{
	float:right;
	font-size: 15px;
	color:red;
}
.time-default {
	flex: 0 0 50%;
    max-width: 50%;
    margin: 0;
}
.wrap-card-body {
	display: flex;
	flex-wrap:wrap;
	width: 100%;

}


.total-default{
	margin-top:22px;
}

.btn-success{
	margin-top:20px;
}

.fix-total-storage-company{
	margin: 20px 0px;
}

.fix-icon-storage-company {
	margin-right: 20px;
}

.title-total{
	margin-left:10px;
}

</style>
