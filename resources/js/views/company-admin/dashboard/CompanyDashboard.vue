<template>
	<div>
		<v-container fluid px-0 py-0 grid-list-xl>
			<div class="mt-4 visitor-area-chart">
				<div class="d-custom-flex justify-space-between px-4 mb-4 label-wrap ml-3 mr-3">
					<div class="d-custom-flex justify-space-between font-weight-bold">
						<a class="nav-link" :class="typeTimeReturn === 'day' ? 'active' : '' " @click="activeTypeTime('day')">D</a>
						<a class="nav-link" :class="typeTimeReturn === 'week' ? 'active' : '' " @click="activeTypeTime('week')">W</a>
						<a class="nav-link" :class="typeTimeReturn === 'month' ? 'active' : '' " @click="activeTypeTime('month')">M</a>
						<a class="nav-link" :class="typeTimeReturn === 'year' ? 'active' : '' " @click="activeTypeTime('year')">Y</a>
					</div>
					<div class="d-custom-flex justify-space-between w-30">
						<div>
							<h4 class="info--text mb-0">0</h4>
							<p class="fs-12 grey--text mb-0">Customers</p>
						</div>
						<div>
							<h4 class="primary--text mb-0"> {{ computedCash }}</h4>
							<p class="fs-12 grey--text mb-0">Cash</p>
						</div>
						<div>
							<h4 class="primary--text mb-0"> {{ computedCC }}</h4>
							<p class="fs-12 grey--text mb-0">CC</p>
						</div>
						<div>
							<h4 class="primary--text mb-0"> {{ computedWeb }}</h4>
							<p class="fs-12 grey--text mb-0">Online</p>
						</div>
						<div>
							<h4 class="primary--text mb-0"> {{ computedTotalIncome }}</h4>
							<p class="fs-12 grey--text mb-0">Total Income</p>
						</div>
					</div>
				</div>
				<div class="px-4 pos-relative">
					<line-chart :width="300"></line-chart>
				</div>
			</div>
		</v-container>

		<v-container fluid grid-list-xl class="style-container">
			<!-- Alert -->
			<div>
				<v-alert class="subheading"  v-model="alertStt" :type="alertType" dismissible>{{ alertMes }}</v-alert>
			</div>
			<!-- Alert -->

			<!-- Day Component -->
			<v-layout row wrap class="stats-card-v4" v-if="typeTime == 'day'">

			  <v-flex xl3 lg3 md3 sm6 xs12 b-50>
			  	<v-card class="elevation-5 custom-stats-card">
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
            		hide-details
              	clearable
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

			  <v-flex xl3 lg3 md3 sm6 xs12 b-50>
			  	<v-card class="elevation-5 custom-stats-card">
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
            		hide-details
            		clearable
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

			  <v-flex xl3 lg3 md3 sm6 xs12 b-50>
			  	<v-card class="elevation-5 custom-stats-card">
		  			<v-card-text>
		  				<div class="font-weight-bold">Branch</div>
						<v-select
							clearable
				         	:items="listBranch"
				         	label="Enter Branch"
				         	v-model="item.branch_id"
				         	item-text="name"
	          				item-value="id"
					    	v-on:change="changeBranch(item)"
							@input="reportByRangeDay"
							hide-details
				    	></v-select>
		  			</v-card-text>
			  	</v-card>
			  </v-flex>

			  <v-flex xl3 lg3 md3 sm6 xs12 b-50>
			  	<v-card class="elevation-5 custom-stats-card">
		  			<v-card-text>
		  				<div class="font-weight-bold">Photographer</div>
						<v-select
							clearable
				         	:items="listPhotographer"
				         	label="Enter Photographer"
				         	v-model="item.photographer_id"
				         	item-text="name"
      						item-value="id"
							@input="reportByRangeDay"
							hide-details
				    	></v-select>
		  			</v-card-text>
			  	</v-card>
			  </v-flex>

			</v-layout>
			<!-- End Day Component -->

			<!-- Month Component -->
			<v-layout row wrap class="stats-card-v4" v-if="typeTime == 'month'">

			  <v-flex xl3 lg3 md3 sm6 xs12 b-50>
			  	<v-card class="elevation-5 custom-stats-card">
		  			<v-card-text>
		  	  		<div class="font-weight-bold">Start</div>
							<v-menu
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
			  	<v-card class="elevation-5 custom-stats-card">
		  			<v-card-text>
		  	  		<div class="font-weight-bold">End</div>
							<v-menu
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
			  	<v-card class="elevation-5 custom-stats-card">
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
								hide-details
					    ></v-select>
		  			</v-card-text>
			  	</v-card>
			  </v-flex>

			  <v-flex xl3 lg3 md3 sm6 xs12 b-50>
			  	<v-card class="elevation-5 custom-stats-card">
		  			<v-card-text>
		  				<div class="font-weight-bold">Photographer</div>
							<v-select
					         	:items="listPhotographer"
					         	label="Enter Photographer"
					         	v-model="item.photographer_id"
					         	item-text="name"
		      					item-value="id"
								@input="reportByMonth"
								hide-details
					    ></v-select>
					  </v-card-text>
			  	</v-card>
			  </v-flex>

			</v-layout>
			<!-- End Month Component -->

			<!-- Year Component -->
			<v-layout row wrap class="stats-card-v4" v-if="typeTime == 'year'">

			  <v-flex xl3 lg3 md3 sm6 xs12 b-50>
			  	<v-card class="elevation-5 custom-stats-card">
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
						        label="Start Year"
						        prepend-icon="event"
						        readonly
						        hide-details
						        clearable
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
			  	<v-card class="elevation-5 custom-stats-card">
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
									label="End Year"
									prepend-icon="event"
									readonly
									hide-details
									clearable
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
			  	<v-card class="elevation-5 custom-stats-card">
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
								hide-details
					    ></v-select>
		  			</v-card-text>
			  	</v-card>
			  </v-flex>

			  <v-flex xl3 lg3 md3 sm6 xs12 b-50>
			  	<v-card class="elevation-5 custom-stats-card">
		  			<v-card-text>
		  				<div class="font-weight-bold">Photographer</div>
							<v-select
					         	:items="listPhotographer"
					         	label="Enter Photographer"
					         	v-model="item.photographer_id"
					         	item-text="name"
		          				item-value="id"
								@input="reportByYear"
								hide-details
			        ></v-select>
			      </v-card-text>
			  	</v-card>
			  </v-flex>

			</v-layout>
			<!-- End Year Component -->

			<!-- Week Component-->
			<v-layout row wrap class="stats-card-v4" v-if="typeTime == 'week'">

			  <v-flex xl3 lg3 md3 sm6 xs12 b-50>
			  	<v-card class="elevation-5 custom-stats-card">
		  			<v-card-text>
		  	  		<div class="font-weight-bold">Start</div>
							<v-menu
								:close-on-content-click="false"
				                v-model="menu7"
				                :nudge-right="40"
				                lazy
				                transition="scale-transition"
				                offset-y
				                full-width
				                min-width="290"
							>
								<v-text-field
									slot="activator"
									v-model="computedStartWeek"
									prepend-icon="event"
									readonly
				              		placeholder="Enter Start Week"
				              		hide-details
				              		clearable
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

			  <v-flex xl3 lg3 md3 sm6 xs12 b-50>
			  	<v-card class="elevation-5 custom-stats-card">
		  			<v-card-text>
		  	  		<div class="font-weight-bold">End</div>
						<v-menu
							:close-on-content-click="false"
			                v-model="menu8"
			                :nudge-right="40"
			                lazy
			                transition="scale-transition"
			                offset-y
			                full-width
			                min-width="290"
						>
							<v-text-field
								slot="activator"
								v-model="computedEndWeek"
								prepend-icon="event"
								readonly
			              		placeholder="Enter End Week"
			              		hide-details
			              		clearable
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

			  <v-flex xl3 lg3 md3 sm6 xs12 b-50>
			  	<v-card class="elevation-5 custom-stats-card">
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
								hide-details
					    ></v-select>
		  			</v-card-text>
			  	</v-card>
			  </v-flex>

			  <v-flex xl3 lg3 md3 sm6 xs12 b-50>
			  	<v-card class="elevation-5 custom-stats-card">
		  			<v-card-text>
		  				<div class="font-weight-bold">Photographer</div>
							<v-select
					         	:items="listPhotographer"
					         	label="Enter Photographer"
					         	v-model="item.photographer_id"
					         	item-text="name"
              					item-value="id"
								@input="reportByWeek"
								hide-details
					    ></v-select>
			      </v-card-text>
			  	</v-card>
			  </v-flex>

			</v-layout>
			<!-- End Week Component-->

			<v-layout row wrap class="stats-card-v4">

			  	<v-flex xl2 lg2 md2 sm6 xs12 b-50>
			  		<v-chip
			  			class="chip-style"
			  			color="green"
			  			text-color="white"
			  			@click = "searchTag(done.name)"
			  			outline
			  		>
				        <v-avatar class="green darken-4 chip-style">{{done.value}}</v-avatar>
				        <span style="color: #1b5e20"> {{done.name}}</span>
				    </v-chip>
			  	</v-flex>

			  	<v-flex xl2 lg2 md2 sm6 xs12 b-50>
			  		<v-chip class="chip-style" color="indigo" text-color="white" outline @click = "searchTag(paid.name)">
				        <v-avatar class="indigo darken-4 chip-style">{{paid.value}}</v-avatar>
				         
				        <span style="color: #1a237e"> {{paid.name}}</span>
				    </v-chip>
			  	</v-flex>

			  	<v-flex xl2 lg2 md2 sm6 xs12 b-50>
			  		<v-chip class="chip-style" color="orange" text-color="white" outline @click = "searchTag(pending.name)">
				        <v-avatar class="orange darken-4 chip-style">{{pending.value}}</v-avatar>
				        <span style="color: #e65100"> {{pending.name}}</span>
				        
				    </v-chip>
			  	</v-flex>

			  	<v-flex xl2 lg2 md2 sm6 xs12 b-50>
			  		<v-chip class="chip-style" color="red" text-color="white" outline @click = "searchTag(cancel.name)">
				        <v-avatar class="red darken-4 chip-style">{{cancel.value}}</v-avatar>
				        <span style="color: #b71c1c"> {{cancel.name}}</span>
				    </v-chip>
			  	</v-flex>
			  	<v-flex xl2 lg2 md2 sm6 xs12 b-50>
			  		<v-chip class="chip-style" color="primary" text-color="white" outline @click = "searchTag(booking.name)">
				        <v-avatar class="primary darken-4 chip-style">{{booking.value}}</v-avatar>
				        <span style="color: #003385"> {{booking.name}}</span>
				        
				    </v-chip>
			  	</v-flex>

			</v-layout>
			<!-- End Week Component -->
		</v-container>
		<orders :companyId="company_id"></orders>
	</div>
</template>

<script>

import { mapGetters } from "vuex";
import Vue from 'vue'
// charts component
import LineChart from './LineChart.js'
import { ChartConfig } from "../../../constants/chart-config";
//config
import config from '../../../config/index.js'
import { get, getWithData, post } from '../../../api'
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
			tweenedNumberOders: 0,
			tweenedNumberCash: 0,
			tweenedNumberCC: 0,
			tweenedNumberWeb: 0,
			tweenedNumberIncome: 0,
			company_id:JSON.parse(localStorage.getItem('user')).company_id,
			listBranch: [],
			listPhotographer: [],
			item : {
				branch_id: '',
				photographer_id:''
			},
			income:{
				cash : 0,
				cc : 0	,
				web: 0,
			},
			totalImcome : 0,
			done : {
				name : 'DONE',
				value : 0
			},
			paid : {
				name : 'PAID',
				value : 0
			},
			pending : {
				name : 'PENDING',
				value : 0
			},
			cancel : {
				name : 'CANCEL',
				value : 0
			},
			booking : {
				name : 'BOOKING',
				value : 0
			},
			paramsSearchTag : {
				status : ''
			}

	  }
	},
	methods:{
		searchTag(params){
			this.paramsSearchTag.status = params
			this.$root.$emit('searchTag', this.paramsSearchTag)
		},
		countValuesOfTag(){
			var url = config.API_URL + 'order/countValuesOfTag?companyId=' + this.company_id
			get(url)
			.then((response) => {
				if(response.data && response.data.success){
					this.done.value = response.data.data.done
					this.paid.value = response.data.data.paid
					this.pending.value = response.data.data.pending
					this.cancel.value = response.data.data.cancel
					this.booking.value = response.data.data.booking
				}
			})
			.catch((err) => {
				console.log(err)
			})
		},
		formatDate(date) {
      if(date){
          return moment(date, 'YYYY-MM-DD hh:mm:ss').format('MM/DD/YYYY');
      }
  	},

    saveStartYear(from_year) {
			this.$refs.menu5.save(from_year)
    	this.$refs.picker.activePicker = 'YEAR'
    	this.from_year = from_year.substr(0,4)
    	this.menu5 = false
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

			this.menu3 = false
			this.menu4 = false

			this.menu5 = false
			this.menu6 = false

			this.menu7 = false
			this.menu8 = false
		},

		reportByRangeDay() {
			var	start_day = moment(this.from_day)
			var	end_day =  moment(this.to_day)
			var day = end_day.diff(start_day,'days')

			if (day <= 0) {
				this.errorAlert('The end date must be after the start date')
			}else if(0 < day && day <= 7){

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
				this.$root.$emit('loadOdersWithTime', obj)
				this.validate = false
			}else if(7 < day && day <= 42){

				let params = {
					start_day_week :  this.formatDate(this.from_day),
					end_day_week :   this.formatDate(this.to_day),
					branch_id : this.item.branch_id,
					photographer_id : this.item.photographer_id,
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
		      		branch_id : this.item.branch_id,
					photographer_id : this.item.photographer_id,
					type : 'month'
	      		}
				let obj = {
					params : params,
					chooes : 'Month'
				}
				this.$root.$emit('companyChart', obj)
				this.$root.$emit('loadOdersWithTime', obj)

				this.validate = false
			}else{

				//view mode year
				var params = {
      				start_year : moment(this.from_day, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM'),
      				end_year : moment(this.to_day, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM'),
      				branch_id : this.item.branch_id,
					photographer_id : this.item.photographer_id	,
					type :'year'
		      	}
				let obj = {
					params : params,
					chooes : 'Year'
				}
				this.$root.$emit('companyChart', obj)
				this.$root.$emit('loadOdersWithTime', obj)
				this.validate = false
			}

			this.resetTime()
		},

		reportByMonth(){
			var	start_month = moment(this.from_month)
			var	end_month =  moment(this.to_month)
			var month = end_month.diff(start_month,'month')

			if (month <= 0) {

				this.errorAlert('The end month must be after the start month')
			}else if(0 < month && month <= 12){

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
				this.$root.$emit('loadOdersWithTime', obj)

				this.validate = false
			}else{

				var params = {
      				start_year : moment(this.from_month, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM'),
      				end_year : moment(this.to_month, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM'),
      				branch_id : this.item.branch_id,
					photographer_id : this.item.photographer_id	,
					type:'year'
		      	}
				let obj = {
					params : params,
					chooes : 'Year'
				}
				this.$root.$emit('companyChart', obj)
				this.$root.$emit('loadOdersWithTime', obj)
				this.validate = false
			}

			this.resetTime()
		},

		reportByYear(){
			var	start_year = moment(this.from_year)
			var	end_year =  moment(this.to_year)
			var year = end_year.diff(start_year,'year')

			if(year > 5) {

				this.errorAlert('Please choose less than 5 years')
			} else if (year <= 0) {

				this.errorAlert('The end year must be after the start year')
			} else {

				var params = {
      				start_year : moment(this.from_year, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM'),
      				end_year : moment(this.to_year, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM'),
      				branch_id : this.item.branch_id,
					photographer_id : this.item.photographer_id	,
					type : 'year'
		      	}
				let obj = {
					params : params,
					chooes : 'Year'
				}
				this.$root.$emit('companyChart', obj)
				this.$root.$emit('loadOdersWithTime', obj)
				this.validate = false
			}

			this.resetTime()
		},

		reportByWeek(){
			var	start_day = moment(this.from_day_week)
			var	end_day =  moment(this.to_day_week)
			var day = end_day.diff(start_day,'days')

			if (day <= 0) {

				this.errorAlert('The end week must be after the start week')
			}else if(0 < day && day <= 7){

				let params = {
					start_day :  this.formatDate(this.from_day_week),
					end_day :   this.formatDate(this.to_day_week),
					branch_id : this.item.branch_id,
					photographer_id : this.item.photographer_id,
					type: 'day'
				}
				let obj = {
					params : params,
					chooes : 'Day',
				}
				this.$root.$emit('companyChart', obj)
				this.$root.$emit('loadOdersWithTime', obj)
				this.validate = false
			}else if(7 < day && day <= 42) {

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
				this.$root.$emit('loadOdersWithTime', obj)
			}else if(42 < day && day <= 365) {

				var params = {
		      		start_month : moment(this.from_day_week, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM-DD'),
		      		end_month:moment(this.to_day_week, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM-DD'),
		      		branch_id : this.item.branch_id,
					photographer_id : this.item.photographer_id,
					type: 'month'
	      		}
				let obj = {
					params : params,
					chooes : 'Month'
				}
				this.$root.$emit('companyChart', obj)
				this.$root.$emit('loadOdersWithTime', obj)
			}else{

				var params = {
      				start_year : moment(this.from_day_week, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM'),
      				end_year : moment(this.to_day_week, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM'),
      				branch_id : this.item.branch_id,
					photographer_id : this.item.photographer_id	,
					type : 'year'
		      	}
				let obj = {
					params : params,
					chooes : 'Year'
				}
				this.$root.$emit('companyChart', obj)
				this.$root.$emit('loadOdersWithTime', obj)
				this.validate = false
			}

			this.resetTime()
		},

		activeTypeTime(time) {
			this.typeTime = time

			if(this.typeTime == "day"){
				this.defaultReportSevenDay()
			}

			if(this.typeTime == "month"){
				this.defaultReportMonth()
			}

			if(this.typeTime == "year") {
				this.defaultReportYear()
			}

			if(this.typeTime == "week") {
				this.defaultReportWeek()
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
			this.$root.$emit('loadOdersWithTime', obj)

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
			this.$root.$emit('loadOdersWithTime', obj)
		},

		defaultReportYear(){
			let params = {
				defaultYear :  'default',
			}

  			let obj = {
				params : params,
				chooes : 'Year'
			}
			this.$root.$emit('companyChart', obj)
			this.$root.$emit('loadOdersWithTime', obj)
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
			this.$root.$emit('loadOdersWithTime', obj)
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
		this.countValuesOfTag()
	},
	computed:{
	  	typeTimeReturn(){
	  		return this.typeTime
	  	},
	  	computedStartDay: {
	  		get: function () {
	  			return this.from_day
	  		},
	  		set: function (newValue) {
	  			this.from_day = ''
	  		}
	  	},
	  	computedEndDay: {
	  		get: function () {
	  			return this.to_day
	  		},
	  		set: function (newValue) {
	  			this.to_day = ''
	  		}
	  	},
		computedStartMonth: {
	  		get: function () {
	  			return this.from_month
	  		},
	  		set: function (newValue) {
	  			this.from_month = ''
	  		}
	  	},
	  	computedEndMonth: {
	  		get: function () {
	  			return this.to_month
	  		},
	  		set: function (newValue) {
	  			this.to_month = ''
	  		}
	  	},
	  	computedStartYear: {
	  		get: function () {
	  			return this.from_year
	  		},
	  		set: function (newValue) {
	  			this.to_year = ''
	  		}
	  	},
	  	computedEndYear: {
	  		get: function () {
	  			return this.to_year
	  		},
	  		set: function (newValue) {
	  			this.to_year = ''
	  		}
	  	},
	  	computedStartWeek: {
	  		get: function () {
	  			return this.from_day_week
	  		},
	  		set: function (newValue) {
	  			this.from_day_week = ''
	  		}
	  	},
	  	computedEndWeek: {
	  		get: function () {
	  			return this.to_day_week
	  		},
	  		set: function (newValue) {
	  			this.to_day_week = ''
	  		}
	  	},
	  	computedTotalCompany(){
	  		return this.tweenedNumber.toFixed(0);
	  	},
	  	computedTotalOders(){
	  		return this.tweenedNumberOders.toFixed(3)
	  	},
	  	computedTotalIncome(){
	  		this.totalImcome = this.income.cc + this.income.cash + this.income.web
	  		return this.tweenedNumberIncome.toFixed(3)
	  	},
	  	computedCash(){
	  		return this.tweenedNumberCash.toFixed(3)
	  	},
	  	computedCC(){
	  		return this.tweenedNumberCC.toFixed(3)
	  	},
	  	computedWeb(){
	  		return this.tweenedNumberWeb.toFixed(3)
	  	},
	  	icomeCash(){
	  		return this.income.cash
	  	},
	  	icomeWeb(){
	  		return this.income.web
	  	},
	  	icomeCC(){
	  		return this.income.cc
	  	},
	},
	mounted() {
    this.$root.$on('totalTransaction', res => {
       	this.total = res
    });

    this.$root.$on('total-companies', res => {
    	this.totalCompany = res
    })

    this.$root.$on('totalImcome', res => {
    	this.income.cash = parseFloat(res.cash.toFixed(3))
    	this.income.cc = parseFloat(res.cc.toFixed(3))
    	this.income.web = parseFloat(res.web.toFixed(3))
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
			  	case "Year":
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
	      TweenLite.to(this.$data, 0.5, { tweenedNumberOders: newValue })
	    },
	    totalImcome: function(newValue) {
	      TweenLite.to(this.$data, 0.5, { tweenedNumberIncome: newValue })
	    },
	    icomeCash(newValue){
	    	TweenLite.to(this.$data, 0.5, { tweenedNumberCash: newValue })
	    },
	    icomeCC(newValue){
	    	TweenLite.to(this.$data, 0.5, { tweenedNumberCC: newValue })
	    },
	    icomeWeb(newValue){
	    	TweenLite.to(this.$data, 0.5, { tweenedNumberWeb: newValue })
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
.chip-style {
	cursor: pointer;
}
.style-container {
	padding-bottom: 0px !important;
}
.stats-card-v4 {
	margin-top: 15px !important;
}
</style>
