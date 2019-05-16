<template>
	<v-container grid-list-xl class="custom-booking">
		<v-toolbar color="white">
		    <v-toolbar-side-icon></v-toolbar-side-icon>
 			<v-layout row wrap class="layout-booking">
	 			<v-flex xs12 lg3 md3 class="header-booking">
			    	<v-toolbar-title >Title</v-toolbar-title>
			   	</v-flex>
			    <v-flex xs12 lg9 md9 justify-center class="header-booking">
			      	<v-layout row wrap>
			      		<v-flex xs12 lg6 md6>
				      	    <v-layout row>
						      	<v-flex grow pa-1>
						          <v-btn @click="reloadToday()">TODAY</v-btn>
						      	</v-flex>
							    <v-flex shrink pa-1>
							        <v-card-text style="padding:0px !important;">
							        	<v-btn icon title="watch">
							        		<v-icon @click="prev()">keyboard_arrow_left</v-icon>
							        	</v-btn>
					        			<v-btn icon title="watch">
					        				<v-icon @click="next()">keyboard_arrow_right</v-icon>
					        			</v-btn>
					        			</v-card-text>
							        </v-card>
							    </v-flex>
							    <v-flex grow pa-1>
									<v-card-text>{{computedDateFormattedMomentjs}}</v-card-text>
								</v-flex>
							</v-layout>
			      		</v-flex>
			      		<v-flex xs12 lg6 md6 class="header-booking-timezone">
			      			<v-layout row>
			      				<v-flex pa-1>
			      					<v-card-text class="text-right">
				      				<span style="float:left;">Timezone:</span>
				      				<span>
				      					<v-select
								          :items="timezones"
								          item-text="offset"
								          item-value="id"
								          v-model="valueTimezone"
								          @change="changeTimezone()"
								          ref="selectItemText"
								        ></v-select>
				      				</span>
				      				</v-card-text>
			      				</v-flex>
			      			</v-layout>
			      		</v-flex>
			      	</v-layout>	
			    </v-flex>
 
		    </v-layout>
  		</v-toolbar>

  		<v-divider class="mt-0"></v-divider>

  		<v-container fluid grid-list-xl pt-3>
	  		<v-layout row wrap>
	  			<v-flex xs12 md12 lg12 sm12 style="display: contents !important;">
	  				
		  			<v-flex xs12 md3 lg3  >
						<v-date-picker v-model="now" no-title scrollable ref="datepicker" @change="reloadDay(now)"> </v-date-picker>
					</v-flex>
				    <v-flex xs12 md9 lg9 >
				    	<v-data-table
					      :headers="headers"
					      :items="desserts"
					    >
					      <template slot="items" slot-scope="props">
					        <td >
					        	<v-dialog
							    	v-model="dialog"
							    	:hide-overlay="true"
							    	width="290"
							    	content-class="dialog-date"
							    	lazy
								    full-width
							    	>
						        	<span slot="activator" @click="getDatePicker(props.item.id)" style="cursor: pointer;">{{props.item.date | moment("dddd, MMMM Do YYYY")}}
						        	</span>
						          	
								    <v-date-picker v-model="props.item.date" :value="props.item.date" no-title scrollable v-if='checkDate == props.item.id' @change="updateDateTime('date',props.item.id, $event)" >      
									</v-date-picker>
								</v-dialog>
					        </td>
					        <td class="text-xs-left">
					        	<v-dialog
								    :hide-overlay="true"
								    ref="v-dialog"
								   	v-model="dialog2"
								    :return-value.sync="timer"
								    persistent
								    lazy
								    full-width
								    width="290px"
								    content-class="dialog-date"
							    	>
								    <template slot="activator">
								    	<span @click="getDatePicker(props.item.id)" style="cursor: pointer;">	{{props.item.time }} 
								    	</span>
								    	{{typeTimer}}
								   	</template>
							    	<v-time-picker v-model="props.item.time" :value="props.item.time" @change="updateDateTime('time',props.item.id, $event)" v-if='checkDate == props.item.id' >
							    	
							    	</v-time-picker>	
								</v-dialog>	
					        </td>
					        <td class="text-xs-left" v-if="props.item.photographer && props.item.photographer.branch">{{ props.item.photographer.branch.name }}</td>
					        <td class="text-xs-left" v-else>No Photographer</td>
					        <td class="text-xs-left" v-if="props.item.photographer">{{ props.item.photographer.name }}</td>
					        <td class="text-xs-left" v-if="props.item.customer">{{ props.item.customer.room.room_hash }}</td>
					        <td class="text-xs-left" v-if="props.item.customer">
					          
					            <div>{{ props.item.customer.name }}</div>
					           
					        </td>
					        <td class="text-xs-left">{{ props.item.country }}</td>
					        <td class="text-xs-left">
					        	<span class="text-danger" v-if="props.item.checkout == 1 "> Booking</span>

				                <span class="text-info" v-else>Cancel</span>
					        </td>
					        <td class="action-width text-xs-left">
					        	<v-icon
									small
									class="mr-6 hover-icon"
									
									@click="showDialog(props.item.id)"
								>
									cancel
								</v-icon>

								<v-icon
									small
									class="mr-6 hover-icon"
									
									@click="sendMail(props.item.id)"
								>
									send
								</v-icon>
					        </td>
					      </template>
					    </v-data-table>
				    </v-flex>
				
				</v-flex>

				<v-dialog v-model="delDialog" persistent max-width="450">
			      	<v-card>
			        	<v-card-title class="headline font-weight-bold grey lighten-3">
					   		<v-icon large color="warning" class="mr-2">
			        			warning
			          		</v-icon>
			          		Do you want delete this item ?
			        	</v-card-title>
			        	<v-divider class="mt-0"></v-divider>
			        	<v-card-actions>
			          		<v-spacer></v-spacer>
			          		<v-btn color="secondary" outline small @click="delDialog = false">Disagree</v-btn>
			          		<v-btn color="warning" outline small @click="deleteItem">Agree</v-btn>
			        	</v-card-actions>
			      	</v-card>
			    </v-dialog>
	  		</v-layout>
  		</v-container>
	</v-container>
</template>

<script>
import moment from 'moment'
import moment_timezone from 'moment-timezone'

import { Constants, Sorts, Calendar, Day, Units, Weekday, Month, DaySpan, PatternMap, Time, Op } from 'dayspan';
import  { get, post, put, del, getWithData } from '../../../api/index.js'
import config from '../../../config/index.js'

export default {

  name: 'Booking',
  data () {
    return {
    	now: new Date().toISOString().substr(0,10),
        max25chars: v => v.length <= 25 || 'Input too long!',
        pagination: {},
        dialog: false,
        dialog2: false,
        delDialog: false,
        headers: [
          {
            text: 'Date',
            align: 'left',
            sortable: false,
            value: 'name'
          },
          { text: 'Time', sortable: false},
          { text: 'Branch', sortable: false},
          { text: 'Photographer', sortable: false},
          { text: 'Room', sortable: false},
          { text: 'Customer', sortable: false},
          { text: 'Country', sortable: false},
          { text: 'Checkout', sortable: false},
          { text: 'Action', sortable: false },
        ],
 		desserts: [],
        todayDate: new Date(),
        menu: false,
        checkDate: '',
        timer: '11:30',
        booleanHide: true,
        typeTimer : '',
        calendar: Calendar.months(),
        company: JSON.parse(localStorage.getItem('user')),
        timezones: [{id: '', offset: ''}],
        timezonesData: [],
    	valueTimezone: '',
    	newNow: '',
    	defaultToday:'',
    	itemIdToDelete:''
      
    	}
  	},
  	watch:{
  		'calendar': 'applyEvents'
  	},
	computed:{
		checkPersistent()
		{
			if(!this.booleanHide) {
				return true
			}

			return false
		},
		computedDateFormattedMomentjs () {
        	return this.now ? moment(this.now).format('dddd, MMMM Do YYYY') : ''
      	}
	},
	created() {
		this.fetchData(this.now)
		this.getTimezone()
	},
   	methods: {
		getDatePicker(id)
		{
			this.checkDate = id
		},
		updateDateTime(type, id, value)
		{
			let params = {}

			if(type == 'date') {
				params = {date: value, timezoneId: this.valueTimezone}
			}

			if(type == 'time') {
				params = {time: value, timezoneId: this.valueTimezone}
			}

			getWithData(config.API_URL+'booking/update/'+id, params)
			.then(response => {
				if(response && response.data.success)
				{
					this.$notify({
			          title: 'Success',
			          message: response.data.message,
			          type: 'success',
			          duration: 2000,
			        })
				}
			})
			.catch(response => {
				console.log(error.response)
			})

			this.dialog = false
			this.booleanHide = false
			this.dialog2 = false
		},
		prev()
		{	
			this.now = moment(this.now).add(-1, 'days').format('YYYY-MM-DD');
			// console.log(moment(this.now).format('YYYY-MM-DD hh:mm:ss'))
			// 
			var tmpNow = this.getNow(this.now)

			this.changeDate(tmpNow)

		},
		next()
		{	
			this.now = moment(this.now).add(1, 'days').format('YYYY-MM-DD');

			var tmpNow = this.getNow(this.now)

			this.changeDate(tmpNow)
		},
		reloadToday()
		{
			let tmpNow = ''

			if(this.valueTimezone == '') {
				this.now = new Date().toISOString().substr(0,10)
				tmpNow = this.now
			} else {
				this.now = new Date().toISOString().substr(0,10)
				tmpNow = this.getNow(this.now)
			}

			this.changeDate(tmpNow)				
		},
		reloadDay(day)
		{
			let tmpNow = this.getNow(day)

			this.changeDate(tmpNow)
		},
		changeDate(value){
			let params = {companyId: this.company.company_id, date: value, timezone: this.valueTimezone }

			getWithData(config.API_URL+'bookings', params)
			.then(response => {
				if(response && response.data.success) {
					if(response.data.data == false) {
						this.desserts = []
					} else {
						this.desserts = response.data.data
					}
					this.$notify({
			          title: 'Success',
			          message: response.data.message,
			          type: 'success',
			          duration: 2000,
			        })
				}
			})
			.catch(error => {
				console.log(error.response)
			})
		},
		fetchData(now)
		{
			let params = {companyId: this.company.company_id, date: now }
			getWithData(config.API_URL+'bookings', params)
			.then(response => {
				if(response && response.data.success) {
					this.desserts = response.data.data
				}
			})
			.catch(error => {
				console.log(error.response)
			})
		},
		getTimezone()
		{
			get(config.API_URL+'timezones')
			.then(response => {
				if(response && response.data.success)
				{	
					var data =  response.data.data
					
					this.timezonesData = response.data.data
					var _this = this
					_.forEach(data, function(value,key){
						_this.timezones.push({id: value.id, offset: value.gmt_offset+' ' +value.zone_name})
						// _this.timezones.push({id:value.id, offset: value.text})
					})
				}
			})
			.catch(error => {
			})
		},
		changeTimezone()
		{
			let time = ''

			if(this.valueTimezone == '') {
				// time = new Date().toISOString().substr(0,10)
				// this.now = time
				this.fetchData(this.now)
			} else {
				let timezoneSelected = _.find(this.timezonesData, (item) => {
					return item.id == this.valueTimezone;
				})

				time = moment_timezone.tz(this.getNow(this.now), timezoneSelected['zone_name']).format();

				this.defaultToday = this.now

				let params = {companyId: this.company.company_id, 
						  	  datetime: time, 
						      timezoneId: this.valueTimezone 
						     }

				getWithData(config.API_URL+'booking/timezone/convert', params)
				.then(response => {
					if(response && response.data.success) {
						this.desserts = response.data.data

						this.$notify({
				          title: 'Success',
				          message: 'Convert timezone success',
				          type: 'success',
				          duration: 2000,
				        })
					}
				})
				.catch(error => {
					console.log(error.response)
					this.desserts = []
					this.$notify({
				          title: 'Success',
				          message: 'Booking not data',
				          type: 'success',
				          duration: 2000,
				        })
				})
			}	
		},
		getNow(now) {
			return moment(now  + ' ' + moment().format('HH:mm:ss')).format('YYYY-MM-DD HH:mm:ss');
		},
		showDialog(item) {
	  		this.delDialog = true
	  		this.itemIdToDelete = item
	  	},
		deleteItem()
		{
			del(config.API_URL+'booking/'+this.itemIdToDelete)
			.then(response => {
				if(response && response.data.success) {
					this.delDialog = false
	  				this.fetchData(this.now)
					this.$notify({
			          title: 'Success',
			          message: 'Deleted success',
			          type: 'success',
			          duration: 2000,
			        })
				}
			})
			.catch(error => {
				console.log(error.response)
			})
		},
		sendMail(id)
		{
			get(config.API_URL+'booking/sendmail/'+id)
			.then(response => {
				if(response && response.data.success) {
					this.$notify({
			          title: 'Success',
			          message: response.data.message,
			          type: 'success',
			          duration: 2000,
			        })
				}
			})
			.catch(error => {
				console.log(error.response)
			})
		}

		// triggerChange()
	 //    {
	 //      	this.$emit('change', {
	 //        	calendar: this.calendar
	 //      	});
	 //    },
	    // applyEvents()
	    // {
	    //   if (this.events)
	    //   {
	    //     this.calendar.removeEvents();
	    //     this.calendar.addEvents(this.events);
	    //   }
	    // },
    }	
}
</script>

<style lang="scss" scoped>
	.dialog-date{
		box-shadow: none;
	}
	.v-dialog{
		box-shadow: none;

	}
	.hover-icon{
	    &:hover{
	      color: blue !important;
	    }
    }
</style>