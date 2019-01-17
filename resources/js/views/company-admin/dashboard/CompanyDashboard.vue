<template>
	<v-container fluid pt-0 grid-list-xl mt-3>
		<v-layout row wrap>
			
			<app-card
				colClasses="xl12 lg12 md12 sm12 xs12"
				customClasses="p-0 elevation-5"
				:fullScreen="true"
				:reloadable="true"
				:closeable="false"
			>
				<div class="visitor-area-chart background-transparent col-sm-12">
					<div class="d-custom-flex justify-space-between label-wrap pt-2">
						<nav class="nav navbar-chart-text">
						  <a class="nav-link no-point pdl">Revenue:</a>
						  <a class="nav-link" :class="typeTimeReturn === 'day' ? 'active' : '' " @click="activeTypeTime('day')">Day</a>
						  <a class="nav-link" :class="typeTimeReturn === 'week' ? 'active' : '' " @click="activeTypeTime('week')">Week</a>
						  <a class="nav-link" :class="typeTimeReturn === 'month' ? 'active' : '' " @click="activeTypeTime('month')">Month</a>
						  <a class="nav-link" :class="typeTimeReturn === 'year' ? 'active' : '' " @click="activeTypeTime('year')">Year</a>
						</nav>
						<div class="d-custom-flex ">
							<div class="">
								<h3 class="info--text mb-0 active">$ {{ computedTotalTransactions }}</h3>
								<p class="fs-12 grey--text mb-0 total-transaction">Total Income</p>
							</div>
						</div>
					</div>
					<line-chart :width="300"></line-chart>
				</div>
				
				<!-- Alert -->
				<div class="pl-4">
					<v-alert class="subheading"  v-model="alertStt" :type="alertType" dismissible>{{ alertMes }}</v-alert>
				</div>
				<!-- Alert -->
				
				<!-- Day Component -->
				<v-layout row wrap mt-3 v-if="typeTime == 'day'">

					<v-flex xs12>
					  <div class="text-primary">(*) Please No choose more than 15 days</div>
					</v-flex>

				  <v-flex xs12 md3>
				  	<v-card class="elevation-5">
			  			<v-card-text>
			  	  		<div class="font-weight-bold">Start</div>
								<v-menu 
									:close-on-content-click="false"
	                v-model="menu1"
	                :nudge-right="40"
	                lazy
	                transition="scale-transition"
	                offset-y
	                full-width
								>
									<v-text-field 
										slot="activator"
										v-model="computedStartDay"
										prepend-icon="event"
										readonly
	              		placeholder="Enter Start Date"
									></v-text-field>
									<v-date-picker 
										v-model="from_day"
										no-title
										scrollable 
										:max="new Date().toISOString().substr(0, 10)"
										@input="reportByRangeDay"
									></v-date-picker>
								</v-menu>
			  			</v-card-text>
				  	</v-card>
				  </v-flex>

				  <v-flex xs12 md3>
				  	<v-card class="elevation-5">
			  			<v-card-text>
			  	  		<div class="font-weight-bold">End</div>
								<v-menu 
									:close-on-content-click="false"
	                v-model="menu2"
	                :nudge-right="40"
	                lazy
	                transition="scale-transition"
	                offset-y
	                full-width
								>
									<v-text-field 
										slot="activator"
										v-model="computedEndDay"
										prepend-icon="event"
										readonly
	              		placeholder="Enter End Date"
									></v-text-field>
									<v-date-picker 
										v-model="to_day" 
										no-title 
										scrollable 
										:max="new Date().toISOString().substr(0, 10)"
										@input="reportByRangeDay"
									></v-date-picker>
								</v-menu>
			  			</v-card-text>
				  	</v-card>
				  </v-flex>

				  <v-flex xs12 md3>
				  	<v-card class="elevation-5">
			  			<v-card-text>
			  				<div class="font-weight-bold">Branch</div>
								<v-select
				         	:items="listBranch"
				         	label="Enter Branch"
				         	v-model="item.branch_id"
				         	item-text="name"
	              	item-value="id"
						      v-on:change="changeBranch(item)"
									@input="reportByRangeDay"
						    ></v-select>
			  			</v-card-text>
				  	</v-card>
				  </v-flex>

				  <v-flex xs12 md3>
				  	<v-card class="elevation-5">
			  			<v-card-text>
			  				<div class="font-weight-bold">Photographer</div>
								<v-select
				         	:items="listPhotographer"
				         	label="Enter Photographer"
				         	v-model="item.photographer_id"
				         	item-text="name"
	          			item-value="id"
									@input="reportByRangeDay"
						    ></v-select>
			  			</v-card-text>
				  	</v-card>
				  </v-flex>

				</v-layout>
				<!-- End Day Component -->

				<!-- Month Component -->
				<v-layout row wrap mt-3 v-if="typeTime == 'month'">
					
					<v-flex xs12>
					  <div class="text-primary">(*) Please No choose more than 12 month</div>
					</v-flex>

				  <v-flex xs12 md3>
				  	<v-card class="elevation-5">
			  			<v-card-text>
			  	  		<div class="font-weight-bold">Start</div>
								<v-menu
									:close-on-content-click="false"
	                v-model="menu3"
	                :nudge-right="40"
	                lazy
	                transition="scale-transition"
	                offset-y
								>
									<v-text-field 
										slot="activator"
										v-model="computedStartMonth"
										prepend-icon="event"
										readonly
                  	placeholder="Enter Start Month"
									></v-text-field>
									<v-date-picker 
										v-model="from_month" 
										no-title 
										scrollable 
										:max="new Date().toISOString().substr(0, 10)"
										@input="reportByMonth"
										type="month"
									></v-date-picker>
								</v-menu>
			  			</v-card-text>
				  	</v-card>
				  </v-flex>

				  <v-flex xs12 md3>
				  	<v-card class="elevation-5">
			  			<v-card-text>
			  	  		<div class="font-weight-bold">End</div>
								<v-menu 
									:close-on-content-click="false"
	                v-model="menu4"
	                :nudge-right="40"
	                lazy
	                transition="scale-transition"
	                offset-y
								>
									<v-text-field 
										slot="activator"
										v-model="computedEndMonth"
										prepend-icon="event"
										readonly
                  	placeholder="Enter End Month"
									></v-text-field>
									<v-date-picker 
										v-model="to_month" 
										no-title 
										scrollable 
										:max="new Date().toISOString().substr(0, 10)"
										@input="reportByMonth"
										type="month"
									></v-date-picker>
								</v-menu>
			  			</v-card-text>
				  	</v-card>
				  </v-flex>

				  <v-flex xs12 md3>
				  	<v-card class="elevation-5">
			  			<v-card-text>
			  				<div class="font-weight-bold">Branch</div>
								<v-select
				         	:items="listBranch"
				         	label="Enter Branch"
				         	v-model="item.branch_id"
				         	item-text="name"
            			item-value="id"
				         	v-on:change="changeBranch(item)"
									@input="reportByMonth"
						    ></v-select>
			  			</v-card-text>
				  	</v-card>
				  </v-flex>

				  <v-flex xs12 md3>
				  	<v-card class="elevation-5">
			  			<v-card-text>
			  				<div class="font-weight-bold">Photographer</div>
								<v-select
				         	:items="listPhotographer"
				         	label="Enter Photographer"
				         	v-model="item.photographer_id"
				         	item-text="name"
            			item-value="id"
									@input="reportByMonth"
						    ></v-select>
						  </v-card-text>
				  	</v-card>
				  </v-flex>

				</v-layout>
				<!-- End Month Component -->

				<!-- Year Component -->
				<v-layout row wrap mt-3 v-if="typeTime == 'year'">
					
					<v-flex xs12>
					  <div class="text-primary">(*) Please No choose more than 5 year</div>
					</v-flex>

				  <v-flex xs12 md3>
				  	<v-card class="elevation-5">
			  			<v-card-text>
			  	  		<div class="font-weight-bold">Start</div>
								<v-menu
									ref="menu5"
									:close-on-content-click="false"
									v-model="menu5"
									:nudge-right="40"
									lazy
									transition="scale-transition"
									offset-y
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
					      	></v-date-picker>
								</v-menu>
			  			</v-card-text>
				  	</v-card>
				  </v-flex>

				  <v-flex xs12 md3>
				  	<v-card class="elevation-5">
			  			<v-card-text>
			  	  		<div class="font-weight-bold">End</div>
								<v-menu
									ref="menu6"
									:close-on-content-click="false"
									v-model="menu6"
									:nudge-right="40"
									lazy
									transition="scale-transition"
									offset-y
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
									></v-date-picker>
								</v-menu>
			  			</v-card-text>
				  	</v-card>
				  </v-flex>

				  <v-flex xs12 md3>
				  	<v-card class="elevation-5">
			  			<v-card-text>
			  				<div class="font-weight-bold">Branch</div>
								<v-select
				         	:items="listBranch"
				         	label="Enter Branch"
				         	v-model="item.branch_id"
				         	item-text="name"
            			item-value="id"
				         	v-on:change="changeBranch(item)"
									@input="reportByYear"
						    ></v-select>
			  			</v-card-text>
				  	</v-card>
				  </v-flex>

				  <v-flex xs12 md3>
				  	<v-card class="elevation-5">
			  			<v-card-text>
			  				<div class="font-weight-bold">Photographer</div>
								<v-select
				         	:items="listPhotographer"
				         	label="Enter Photographer"
				         	v-model="item.photographer_id"
				         	item-text="name"
            			item-value="id"
									@input="reportByYear"
				        ></v-select>
				      </v-card-text>
				  	</v-card>
				  </v-flex>

				</v-layout>
				<!-- End Year Component -->

				<!-- Week Component-->
 				<v-layout row wrap mt-3 v-if="typeTime == 'week'">
					
					<v-flex xs12>
					  <div class="text-primary">(*) Please No choose more than 6 week</div>
					</v-flex>

				  <v-flex xs12 md3>
				  	<v-card class="elevation-5">
			  			<v-card-text>
			  	  		<div class="font-weight-bold">Start</div>
								<v-menu
									:close-on-content-click="false"
	                v-model="menu7"
	                :nudge-right="40"
	                lazy
	                transition="scale-transition"
	                offset-y
								>
									<v-text-field 
										slot="activator"
										v-model="computedStartWeek"
										prepend-icon="event"
										readonly
	              		placeholder="Enter Start Week"
									></v-text-field>
									<v-date-picker 
										v-model="from_day_week" 
										no-title 
										scrollable 
										:max="new Date().toISOString().substr(0, 10)"
										@input="reportByWeek"
									></v-date-picker>
								</v-menu>
			  			</v-card-text>
				  	</v-card>
				  </v-flex>

				  <v-flex xs12 md3>
				  	<v-card class="elevation-5">
			  			<v-card-text>
			  	  		<div class="font-weight-bold">End</div>
								<v-menu 
									:close-on-content-click="false"
	                v-model="menu8"
	                :nudge-right="40"
	                lazy
	                transition="scale-transition"
	                offset-y
								>
									<v-text-field 
										slot="activator"
										v-model="computedEndWeek"
										prepend-icon="event"
										readonly
	              		placeholder="Enter End Week"
									></v-text-field>
									<v-date-picker 
										v-model="to_day_week" 
										no-title 
										scrollable 
										:max="new Date().toISOString().substr(0, 10)"
										@input="reportByWeek"
									></v-date-picker>
								</v-menu>
			  			</v-card-text>
				  	</v-card>
				  </v-flex>

				  <v-flex xs12 md3>
				  	<v-card class="elevation-5">
			  			<v-card-text>
			  				<div class="font-weight-bold">Branch</div>
								<v-select
				         	:items="listBranch"
				         	label="Enter Branch"
				         	v-model="item.branch_id"
				         	item-text="name"
            			item-value="id"
				         	v-on:change="changeBranch(item)"
									@input="reportByWeek"
						    ></v-select>
			  			</v-card-text>
				  	</v-card>
				  </v-flex>

				  <v-flex xs12 md3>
				  	<v-card class="elevation-5">
			  			<v-card-text>
			  				<div class="font-weight-bold">Photographer</div>
								<v-select
				         	:items="listPhotographer"
				         	label="Enter Photographer"
				         	v-model="item.photographer_id"
				         	item-text="name"
	              	item-value="id"
									@input="reportByWeek"
						    ></v-select>
				      </v-card-text>
				  	</v-card>
				  </v-flex>

				</v-layout>
				<!-- End Week Component -->

			</app-card>
		</v-layout>
		<orders :companyId="company_id"></orders>
	</v-container>		
</template>

<script>

import { mapGetters } from "vuex";
import Vue from 'vue'
// charts component
import LineChart from './LineChart.js'
import { ChartConfig } from "../../../constants/chart-config";
//config 
import config from '../../../config/index.js'
import { get, getWithData } from '../../../api/index.js'
import moment from 'moment'
import Orders from './Orders'

export default {

  name: 'CompanyDashboard',
  components: {
  	LineChart,
    Orders,
  },
	data() {
    return {
    	count_pack_company:20,
    	count_pack_basic:20,
    	count_pack_pro:20,
    	lorem: `Lorem ipsum dolor sit amet, mel at clita quando. Te sit oratio vituperatoribus, nam ad ipsum posidonium mediocritatem, explicari dissentiunt cu mea. Repudiare disputationi vim in, mollis iriure nec cu, alienum argumentum ius ad. Pri eu justo aeque torquatos.`,
    	authUser : JSON.parse(localStorage.getItem('user')),
     	alertStt: false,
		alertType: 'success',
		alertMes: '',
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
		menu1:false,
		menu2:false,
		menu3:false,
		menu4:false,
		menu5:false,
		menu6:false,
		menu7:false,
		menu8:false,
		date: '',
		defaultYear : new Date().getUTCFullYear() + '/31/12',
		totalCompany:0,
		tweenedNumber: 0,
		tweenedNumberTransactions: 0,
		company_id:JSON.parse(localStorage.getItem('user')).company_id,
		listBranch: [],
		listPhotographer: [],
		item : {
			branch_id: '',
			photographer_id:''
		},
	  }
	},
	methods:{
		formatDate(date) {
      if(date){
          return moment(date, 'YYYY-MM-DD hh:mm:ss').format('MM/DD/YYYY');
      }
  	},

    saveStartYear(from_year) {
			this.$refs.menu5.save(from_year)
      	this.$refs.picker.activePicker = 'YEAR'
      	this.from_year = from_year.substr(0,4)
      	this.menu5 = false;
      	this.reportByYear()
		},

		saveEndYear(to_year) {
			this.$refs.menu6.save(to_year)
    	this.$refs.picker2.activePicker = 'YEAR'
    	this.to_year = to_year.substr(0,4)
    	this.menu6 = false
    	this.reportByYear()
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

		validations(from,to,value){

			if(!from && !to){
				this.errorAlert('No ' + value + ' Yet')
			} else if (!to) {
				this.errorAlert('Please choose End ' + value)
			} else if(!from) {
				this.errorAlert('Please choose Start ' + value)
			} else { 
				this.validate = true
			}
		},

		errorAlert(errorMesg){
			this.alertStt = true
    	this.alertType = 'error'
    	this.alertMes = errorMesg
    	setTimeout(() => {this.alertStt = false}, 1500)					
		},

		resetTime(){
			this.menu1 = false
			this.menu2 = false
			// this.from_day = ''
			// this.to_day = ''

			this.menu3 = false
			this.menu4 = false
			// this.from_month = ''
			// this.to_month = ''

			this.menu5 = false
			this.menu6 = false
			// this.from_year = ''
			// this.to_year = ''

			this.menu7 = false
			this.menu8 = false
			// this.from_day_week = ''
			// this.to_day_week = ''
		},

		reportByRangeDay() {
			var	start_day = moment(this.from_day)
			var	end_day =  moment(this.to_day)
			var day = end_day.diff(start_day,'days')

			if(day > 15) {
				this.errorAlert('Less than 15 days')
			} else if(day <=0) {
				this.errorAlert('To days Large from days')
			} else {
				let params = {
					start_day :  this.formatDate(this.from_day),
					end_day :   this.formatDate(this.to_day),
					branch_id : this.item.branch_id,
					photographer_id : this.item.photographer_id,
					type: 'day'
				}
				let obj = {
					params : params,
					chooes : 'Day',
				}
				this.$root.$emit('companyChart', obj)
				this.$root.$emit('loadTransactionsWithTime', obj)
				this.validate = false
			}
		
			this.resetTime()
		},

		reportByMonth(){
			var	start_month = moment(this.from_month)
			var	end_month =  moment(this.to_month)
			var month = end_month.diff(start_month,'month')

			if(month > 12) {
				this.errorAlert('Less than 12 months')
			} else if(month <=0) {
				this.errorAlert('To month large from month')
			} else {
				var params = {
		      		start_month: moment(this.from_month, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM-DD'),
		      		end_month:moment(this.to_month, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM-DD'),
		      		branch_id : this.item.branch_id,
					photographer_id : this.item.photographer_id,
					type: 'month'
	      		}
				let obj = {
					params : params,
					chooes : 'Month'
				}
				this.$root.$emit('companyChart', obj)
				this.$root.$emit('loadTransactionsWithTime', obj)

				this.validate = false
			}
			
			this.resetTime()
		},

		reportByYear(){
			var	start_year = moment(this.from_year)
			var	end_year =  moment(this.to_year)
			var year = end_year.diff(start_year,'year')

			if(year > 5) {
				this.errorAlert('Less than 5 years')
			} else if (year <=0) {
				this.errorAlert('To year large from year')
			} else {
				var params = {
      				start_year:moment(this.from_year, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM'),
      				end_year:moment(this.to_year, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM'),
      				branch_id : this.item.branch_id,
					photographer_id : this.item.photographer_id	,
					type:'year'	
		      	}
				let obj = {
					params : params,
					chooes : 'Year'
				}
				this.$root.$emit('companyChart', obj)
				this.$root.$emit('loadTransactionsWithTime', obj)
				this.validate = false
			}
			
			this.resetTime()
		},

		reportByWeek(){
			var	start_day = moment(this.from_day_week)
			var	end_day =  moment(this.to_day_week)
			var day = end_day.diff(start_day,'days')
	
			if(day > 42) {
				this.errorAlert('Less than 6 weeks')
			} else if(day <=0) {
				this.errorAlert('To days Large from days')
			} else {

				let params = {
					start_day_week :  this.formatDate(this.from_day_week),
					end_day_week :   this.formatDate(this.to_day_week),
					branch_id : this.item.branch_id,
					photographer_id : this.item.photographer_id,
					type:'week'
				}
				let obj = {
					params : params,
					chooes : 'Week'
				}
				this.$root.$emit('companyChart', obj)
				this.$root.$emit('loadTransactionsWithTime', obj)
			}
			this.resetTime()
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

			if(this.typeTime == "week") {
				this.defaultReportWeek()
				this.from_day_week=''
      		this.to_day_week=''
			}  			
		},

		defaultReportSevenDay(){

			let params = {
				defaultDay :  'default',
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
				defaultMonth :  'default',
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
				defaultYear :  'default',
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
				defaultWeek :  'default',
				
			}

  			let obj = {
				params : params,
				chooes : 'Week'
			}
			this.$root.$emit('companyChart', obj)
			this.$root.$emit('loadTransactionsWithTime', obj)
		},

		getListBranch(){
			var url = config.API_URL+'company/branch-company?companyId='+this.company_id
			get(url)
			.then((response) => {
				if(response.data && response.data.success){
					var data = response.data.data
					var vm = this
					_.forEach(data, function(value,key){
						vm.listBranch.push(value)					
					})				    
				}
			})
			.catch((err) => {
				console.log(err)
			})
		},

		changeBranch(item){		
			var url = config.API_URL+'photographer/photographer-branch?branchId='+item.branch_id
			get(url)
			.then(res => {
				if(res.data && res.data.success){
					var data = res.data.data
					var vm = this
					_.forEach(data, function(value,key){
						vm.listPhotographer.push(value)
					})
				}
			})	
			.catch(err =>{
				console.log(err)
			})
		},
	},
	created(){
		var user = this.authUser  
  		this.$store.dispatch("connectionPushNotification", {user});
		this.fetchData()
		this.getListBranch()		
		
	},
	computed:{
  	typeTimeReturn(){
  		return this.typeTime
  	},
  	computedStartDay(){
  		return this.from_day
  	},
  	computedEndDay(){
  		return this.to_day
  	},
  	computedStartMonth(){
  		return this.from_month
  	},
  	computedEndMonth(){
  		return this.to_month
  	},
  	computedStartYear(){
  		return this.from_year
  	},
  	computedEndYear(){
  		return this.to_year
  	},
  	computedStartWeek(){
  		return this.from_day_week
  	},
  	computedEndWeek(){
  		return this.to_day_week
  	},
  	computedTotalCompany(){
  		return this.tweenedNumber.toFixed(0);
  	},
  	computedTotalTransactions(){
  		return this.tweenedNumberTransactions.toFixed(3)
  	}
	},
	mounted() {
    this.$root.$on('totalTransaction', res => {
       	this.total = res
    });

    this.$root.$on('total-companies', res => {
    	this.totalCompany = res
    })
	},

	watch: {
    menu5 (val) {
      val && this.$nextTick(() => (this.$refs.picker.activePicker = 'YEAR'))
    },
    menu6 (val) {
      val && this.$nextTick(() => (this.$refs.picker2.activePicker = 'YEAR'))
    },
    totalCompany: function(newValue) {
      TweenLite.to(this.$data, 0.5, { tweenedNumber: newValue })
    },
    total: function(newValue) {
      TweenLite.to(this.$data, 0.5, { tweenedNumberTransactions: newValue })
    }
	},
};
</script>

<style lang="css" scoped>

.navbar-chart-text{
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
	margin-top:28px;
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

.no-point{
	cursor: auto;
}

.pdl{
	padding-left: 8px !important;
}

</style>
