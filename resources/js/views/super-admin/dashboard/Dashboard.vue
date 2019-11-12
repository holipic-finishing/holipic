<template>
	<v-container fluid px-0 py-0 grid-list-xl>
		<div class="mt-4 visitor-area-chart">
			<div class="d-custom-flex justify-space-between px-4 mb-4 label-wrap ml-3 mr-3">
				<div class="d-custom-flex justify-space-between font-weight-bold">
					<a class="nav-link" :class="typeTimeReturn === 'day' ? 'active' : '' " @click="activeTypeTime('day')">D</a>
					<a class="nav-link" :class="typeTimeReturn === 'week' ? 'active' : '' " @click="activeTypeTime('week')">W</a>
					<a class="nav-link" :class="typeTimeReturn === 'month' ? 'active' : '' " @click="activeTypeTime('month')">M</a>
					<a class="nav-link" :class="typeTimeReturn === 'year' ? 'active' : '' " @click="activeTypeTime('year')">Y</a>
				</div>
				<div class="d-custom-flex ">
					<div class="">
						<!-- <h3 class="info--text mb-0 active">$ {{ computedTotalTransactions }}</h3> -->
			        <!-- <v-btn text color="primary" @click="show = !show">Total Income</v-btn> -->
						<!-- <p class="fs-12 grey--text mb-0 total-transaction" @click="show = !show">Total Income</p> -->
						<div class="dropdown">
						  <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">Total Income</button>
						  <ul class="dropdown-menu pl-3">
						    <li>USD 40000</li>
						    <li>IDR 1000000000</li>
						  </ul>
						</div>
					</div>
				</div>
			</div>

			<div class="px-4 pos-relative">
				<!-- Line Chart -->
				<line-chart :width="300"></line-chart>
				<!-- End Line Chart -->
			</div>
		</div>

		<v-container fluid grid-list-xl class="style-container">
			<!-- Alert -->
			<div class="pl-4">
				<v-alert class="subheading"  v-model="alertStt" :type="alertType" dismissible>{{ alertMes }}</v-alert>
			</div>
			<!-- End Alert -->
			<!-- Start Day -->
			<v-layout row wrap class="stats-card-v4" v-if="typeTime == 'day'">

				<v-flex xl3 lg3 md3 sm6 xs12 b-50>
					<v-card class="elevation-5 custom-stats-card height-box">
						<v-card-text>
							<div class="font-weight-bold">Start</div>
							<v-menu
								ref="menu1"
								:close-on-content-click="false"
								v-model="menu1"
								:nudge-right="40"
								lazy
								transition="scale-transition"
								offset-y
								full-width
								min-width="290"
							>
								<v-text-field
									slot="activator"
									v-model="computedStartDay"
									prepend-icon="event"
									readonly
									placeholder="Enter Start Date"
									hide-details
									clearable
								></v-text-field>
								<v-date-picker
									v-model="from_day"
									no-title
									scrollable
									:max="new Date().toISOString().substr(0, 10)"
									@input="reportByRangeDay"
									type="date"
								></v-date-picker>
							</v-menu>
						</v-card-text>
					</v-card>
				</v-flex>

				<v-flex xl3 lg3 md3 sm6 xs12 b-50>
					<v-card class="elevation-5 custom-stats-card height-box">
						<v-card-text>
							<div class="font-weight-bold">End</div>
							<v-menu
								ref="menu2"
								:close-on-content-click="false"
								v-model="menu2"
								:nudge-right="40"
								lazy
								transition="scale-transition"
								offset-y
								full-width
								min-width="290"
							>
								<v-text-field
									slot="activator"
									v-model="computedEndDay"
									prepend-icon="event"
									readonly
									placeholder="Enter End Date"
									hide-details
									clearable
								></v-text-field>
								<v-date-picker
									v-model="to_day"
									no-title
									scrollable
									:max="new Date().toISOString().substr(0, 10)"
									@input="reportByRangeDay"
									type="date"
								></v-date-picker>
							</v-menu>
						</v-card-text>
					</v-card>
				</v-flex>

				<v-flex xl3 lg3 md3 sm6 xs12 b-50>
					<v-card class="elevation-5 custom-stats-card height-box">
						<div class="style-card height-box">
							<div class="d-custom-flex justify-space-between fix-total-storage-company">
								<div class="title-total">
									<h2>{{ computedTotalCompany }}</h2>
									Total companies
								</div>
								<div>
									<span class="icon-style fix-icon-storage-company">
										<i class="material-icons font-2x primary--text">store</i>
									</span>
								</div>
							</div>
						</div>
					</v-card>
				</v-flex>

				<v-flex xl3 lg3 md3 sm6 xs12 b-50>
					<v-card class="elevation-5 custom-stats-card height-box">
						<div class="style-card height-box">
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
					</v-card>
				</v-flex>

			</v-layout>
			<!-- End Day  -->
			<!-- Start Month -->
			<v-layout row wrap class="stats-card-v4" v-if="typeTime == 'month'">

				<v-flex xl3 lg3 md3 sm6 xs12 b-50>
					<v-card class="elevation-5 custom-stats-card height-box">
						<v-card-text>
							<div class="font-weight-bold">Start</div>
							<v-menu
								ref="menu3"
								:close-on-content-click="false"
								v-model="menu3"
								:nudge-right="40"
								lazy
								transition="scale-transition"
								offset-y
								full-width
								min-width="290"
							>
								<v-text-field
									slot="activator"
									v-model="computedStartMonth"
									prepend-icon="event"
									readonly
									placeholder="Enter Start Month"
									hide-details
									clearable
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

				<v-flex xl3 lg3 md3 sm6 xs12 b-50>
					<v-card class="elevation-5 custom-stats-card height-box">
						<v-card-text>
							<div class="font-weight-bold">End</div>
							<v-menu
								ref="menu4"
								:close-on-content-click="false"
								v-model="menu4"
								:nudge-right="40"
								lazy
								transition="scale-transition"
								offset-y
								full-width
								min-width="290"
							>
								<v-text-field
									slot="activator"
									v-model="computedEndMonth"
									prepend-icon="event"
									readonly
									placeholder="Enter End Month"
									hide-details
									clearable
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

				<v-flex xl3 lg3 md3 sm6 xs12 b-50>
					<v-card class="elevation-5 custom-stats-card height-box">
						<div class="style-card height-box">
							<div class="d-custom-flex justify-space-between fix-total-storage-company">
								<div class="title-total">
									<h2>{{ computedTotalCompany }}</h2>
									Total companies
								</div>
								<div>
									<span class="icon-style fix-icon-storage-company">
										<i class="material-icons font-2x primary--text">store</i>
									</span>
								</div>
							</div>
						</div>
					</v-card>
				</v-flex>

				<v-flex xl3 lg3 md3 sm6 xs12 b-50>
					<v-card class="elevation-5 custom-stats-card height-box">
						<div class="style-card height-box">
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
					</v-card>
				</v-flex>

			</v-layout>
			<!-- End Month -->
			<!-- Start Year -->
			<v-layout row wrap class="stats-card-v4" v-if="typeTime == 'year'">

				<v-flex xl3 lg3 md3 sm6 xs12 b-50>
					<v-card class="elevation-5 custom-stats-card height-box">
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
								full-width
								min-width="290"
							>
								<v-text-field
									slot="activator"
									v-model="from_year"
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

				<v-flex xl3 lg3 md3 sm6 xs12 b-50>
					<v-card class="elevation-5 custom-stats-card height-box">
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
								full-width
								min-width="290"
							>
								<v-text-field
									slot="activator"
									v-model="to_year"
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

				<v-flex xl3 lg3 md3 sm6 xs12 b-50>
					<v-card class="elevation-5 custom-stats-card height-box">
						<div class="style-card height-box">
							<div class="d-custom-flex justify-space-between fix-total-storage-company">
								<div class="title-total">
									<h2>{{ computedTotalCompany }}</h2>
									Total companies
								</div>
								<div>
									<span class="icon-style fix-icon-storage-company">
										<i class="material-icons font-2x primary--text">store</i>
									</span>
								</div>
							</div>
						</div>
					</v-card>
				</v-flex>

				<v-flex xl3 lg3 md3 sm6 xs12 b-50>
					<v-card class="elevation-5 custom-stats-card height-box">
						<div class="style-card height-box">
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
					</v-card>
				</v-flex>

			</v-layout>
			<!-- End Year -->
			<!-- Start Week  -->
			<v-layout row wrap class="stats-card-v4" v-if="typeTime == 'week'">

				<v-flex xl3 lg3 md3 sm6 xs12 b-50>
					<v-card class="elevation-5 custom-stats-card height-box">
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
								min-width="290"
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
									type="date"
								></v-date-picker>
							</v-menu>
						</v-card-text>
					</v-card>
				</v-flex>

				<v-flex xl3 lg3 md3 sm6 xs12 b-50>
					<v-card class="elevation-5 custom-stats-card height-box">
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
								min-width="290"
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
									type="date"
								></v-date-picker>
							</v-menu>
						</v-card-text>
					</v-card>
				</v-flex>

				<v-flex xl3 lg3 md3 sm6 xs12 b-50>
					<v-card class="elevation-5 custom-stats-card height-box">
						<div class="style-card height-box">
							<div class="d-custom-flex justify-space-between fix-total-storage-company">
								<div class="title-total">
									<h2>{{ computedTotalCompany }}</h2>
									Total companies
								</div>
								<div>
									<span class="icon-style fix-icon-storage-company">
										<i class="material-icons font-2x primary--text">store</i>
									</span>
								</div>
							</div>
						</div>
					</v-card>
				</v-flex>

				<v-flex xl3 lg3 md3 sm6 xs12 b-50>
					<v-card class="elevation-5 custom-stats-card height-box">
						<div class="style-card height-box">
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
					</v-card>
				</v-flex>

			</v-layout>
			<!-- Week -->
		</v-container>
		<transactions></transactions>
	</v-container>
</template>

<script>
import Vue from 'vue'
// charts component
import LineChart from './LineChart.js'
import { ChartConfig } from "../../../constants/chart-config";
//config
import config from '../../../config/index.js'
import { get, getWithData } from '../../../api/index.js'
import moment from 'moment'
import Transactions from './Transactions'

export default {

	name: 'Dashboard',

	components: {
		LineChart,
		Transactions,
	},
	data() {
		return {
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
			show: false,
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
			this.validations(this.from_day, this.to_day, 'Day')

			if(this.validate == true){

				var	start_day = moment(this.from_day)
				var	end_day =  moment(this.to_day)
				var day = end_day.diff(start_day,'days')

				if(day <=0) {
					this.errorAlert('To days Large from days')
				}else if(0 < day && day <= 7){

					let params = {
						start_day :  this.formatDate(this.from_day),
						end_day :   this.formatDate(this.to_day),
						type: 'day'
					}

					let obj = {
						params : params,
						chooes : 'Day',
					}

					this.$root.$emit('companyChart', obj)
					this.$root.$emit('loadTransactionsWithTime', obj)
					this.validate = false

				}else if(7 < day && day <= 42){

					let params = {
						start_day_week :  this.formatDate(this.from_day),
						end_day_week :   this.formatDate(this.to_day),
						type:'week'
					}

					let obj = {
						params : params,
						chooes : 'Week'
					}
					this.$root.$emit('companyChart', obj)
					this.$root.$emit('loadOdersWithTime', obj)

				}else if(42 < day && day <= 365){
					//view mode month
					var params = {
						start_month : moment(this.from_day, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM-DD'),
						end_month : moment(this.to_day, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM-DD'),
						type : 'month'
					}
					let obj = {
						params : params,
						chooes : 'Month'
					}
					this.$root.$emit('companyChart', obj)
					this.$root.$emit('loadTransactionsWithTime', obj)

					this.validate = false
				} else{
					//view mode year
					var params = {
						start_year : moment(this.from_day, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM'),
						end_year : moment(this.to_day, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM'),
						type :'year'
					}
					let obj = {
						params : params,
						chooes : 'Year'
					}
					this.$root.$emit('companyChart', obj)
					this.$root.$emit('loadTransactionsWithTime', obj)
					this.validate = false
				}
			}
			this.resetTime()
		},

		reportByMonth(){
			this.validations(this.from_month, this.to_month, 'Month')

			if(this.validate == true){
				var	start_month = moment(this.from_month)
				var	end_month =  moment(this.to_month)
				var month = end_month.diff(start_month,'month')

				if(month > 12) {
					this.errorAlert('Less than 12 months')
				} else if(month <=0) {
					this.errorAlert('To month large from month')
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

					this.validate = false
				}
			}
			this.resetTime()

		},

		reportByYear(){
			this.validations(this.from_year, this.to_year, 'Year')

			if(this.validate == true){

				var	start_year = moment(this.from_year)
				var	end_year =  moment(this.to_year)
				var year = end_year.diff(start_year,'year')

				if(year > 5) {
					this.errorAlert('Less than 5 years')
				} else if (year <=0) {
					this.errorAlert('To year large from year')
				} else {
					var year = {
						start_year:moment(this.from_year, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM'),
						end_year:moment(this.to_year, 'YYYY-MM-DD hh:mm:ss').add(12, 'M').format('YYYY-MM')
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
			this.resetTime()
		},

		reportByWeek(){
			this.validations(this.from_day_week, this.to_day_week, 'Day')

			if(this.validate == true){

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
		}
	},
	created(){
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

		this.$root.$on('load-time-in-menu-filter', res => {
			if (res) {
				switch(res.typeTime) {
					case "SevenDay":
					this.from_day = res.firstTime
					this.to_day = res.lastTime
					break;
					case "Week":
					this.from_day_week = res.firstTime
					this.to_day_week = res.lastTime
					break;
					case "Month":
					this.from_month = res.firstTime
					this.to_month = res.lastTime
					break;
					case "year":
					this.from_year = res.firstTime
					this.to_year = res.lastTime
					break;
					default:
					this.from_day = res.firstTime
					this.to_day = res.lastTime
					break;
				}
			}
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
