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
				<v-toolbar flat color="white">
			        <v-toolbar-title>
			          Manage Sales
			        </v-toolbar-title>
			     </v-toolbar>
	      		<v-divider class="m-0"></v-divider>
			  	<v-layout row wrap>
	      			<!-- Filter Component -->
				  	<v-flex xs11>
				  		<v-layout row wrap>
								<v-flex md3 sm6 xs12>
									<v-card class="elevation-5">
						  				<v-card-text>
									        <v-select
									          v-model="valuePhotographer"
									          :items="photographers"
									           autocomplete
								              browserAutocomplete="off"
								              item-text="name"
								              item-value="id"
							              
								        	></v-select>
						  				</v-card-text>
					  				</v-card>
						    	</v-flex>
						   		<!-- Start day -->
							   	<v-flex md3 sm6 xs12>
							   		<v-card class="elevation-5">
						  				<v-card-text>
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
													v-model="from_day"
													clearable
													readonly
							  						placeholder="Enter Start Date"
												></v-text-field>
												<v-date-picker 
													v-model="from_day"
													no-title
													scrollable 
													@input= "menu1 =false"
													:max="new Date().toISOString().substr(0, 10)"

												></v-date-picker>
											</v-menu>
						  				</v-card-text>
						  			</v-card>
								</v-flex>
								<!-- End day -->
								<v-flex md3 sm6 xs12>
									<v-card class="elevation-5">
						  				<v-card-text>
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
												v-model="to_day"
												clearable
						  						placeholder="Enter End Date"
											></v-text-field>
											<v-date-picker 
												v-model="to_day" 
												no-title 
												scrollable 
												@input="menu2 =false"
												:max="new Date().toISOString().substr(0, 10)"
											></v-date-picker>
											</v-menu>
						  				</v-card-text>
					  				</v-card>
								</v-flex>

								<v-flex md1 sm12 xs12 align-center justify-center>
				  					<v-btn class="btn-gradient-primary" small fab dark @click="filterSale()">Go</v-btn>
				  				</v-flex>
				  		</v-layout>
				  	</v-flex>
				  	
					<v-flex xs12>
						<v-card-title>
					      	<v-spacer></v-spacer>
				        	<div class="w-25">
					  	      	<v-text-field
					  	        	v-model="search"
					  	        	append-icon="search"
					  	        	label="Enter Search Value"
					  	        	single-line
					  	        	hide-details
					  	      	></v-text-field>
				        	</div>
						    <v-tooltip bottom class="icon-style">
						    	<v-btn slot="activator" small fab dark @click="exportSales()" class="ml-2 btn-gradient-primary">
										<v-icon dark>fas fa-file-excel</v-icon>
									</v-btn>
							    <span>Export Sales</span>
						    </v-tooltip>
				    	</v-card-title>
					</v-flex>

				</v-layout>
				
				<v-data-table 
					:headers="headers" 
					:items="sales" 
					class="elevation-5 body-2 global-custom-table"  
					:pagination.sync="pagination" 
					:rows-per-page-items="rowsPerPageItems" 
					default-sort="id:desc"
					:search="search"
					>

					<template slot="headers" slot-scope="props">
			          <tr>
			            <th
			              v-for="header in props.headers"
			              :key="header.text"
			              :class="['column sortable', pagination.descending ? 'desc' : 'asc', header.value === pagination.sortBy ? 'active' : '']"
			              @click="changeSort(header.value)"
			            >
			            	<div class="custom-header">
				              <v-tooltip bottom>
				                <span slot="activator" class="text-capitalize font-weight-bold">
				                  {{ header.text }}
				                </span>
				                <span>
				                  {{ header.text }}
				                </span>
				              </v-tooltip>
				              <v-icon v-if="header.text != 'Branch'">arrow_upward</v-icon>
			            	</div>
			            </th>
			          </tr>
			        </template>

					<template slot="no-data">
				      <v-alert :value="true" color="error" icon="warning">
				        Sorry, nothing to display here :(
				      </v-alert>
				    </template>

				    <template slot="items" slot-scope="props" >
						<td>{{ props.item.id }}</td>
						<td class="text-xs-left" v-if="props.item.branch != null">{{ props.item.branch.name }}</td>
						<td class="text-xs-left" v-if="props.item.photographer != null">{{ props.item.photographer.name }}</td>
						<td class="text-xs-left">{{ props.item.customer.room.room_hash }}</td>
						<td class="text-xs-left">{{ props.item.total_amount }}</td>
						<td class="text-xs-left">{{ props.item.purchase_date }}</td>
						<td class="text-xs-left">{{ props.item.download_date }}</td>
						<td class="text-xs-left">{{ props.item.customer.user.email }}</td>
						<td class="text-xs-left">{{ props.item.payment_method }}</td>
					</template>

					<!--Search no result -->
		    		<v-alert slot="no-results" :value="true" color="error" icon="warning">
		          		Your search for "{{ search }}" found no results.
		        	</v-alert>
							
				</v-data-table>
			</app-card>
		</v-layout>
	</v-container>		    	
</template>

<script>
import {get, post, put, del, getWithData} from '../../../api/index'
import config from '../../../config/index'

export default {
	name: 'Sales',

	data () {
	    return {
	    	menu1:false,
			menu2:false,
			menu3:false,	

			from_day:'',
			to_day:'',
			urlExport:'',
			search:'',
			selected: '',
	        sales: [],
			selected1:'',
			headers:[
				{text: 'ID' , sortable: false}, 
				{text: 'Branch' , sortable: false}, 
				{text:'Photographer', value: 'photographer.name' , sortable: false}, 
				{text: 'Room', value:'customer.room.room_hash', sortable: false}, 
				{text: 'Total Amount', value: 'total_amount', sortable: false}, 
				{text: 'Purchase Date', value: 'purchase_date', sortable: false}, 
				{text: 'Download Date', value: 'download_date', sortable: false}, 
				{text: 'Customer Email', value:'customer.user.email', sortable: false}, 
				{text: 'Payment Method', value: 'payment_method', sortable: false}
			],
			pagination: {
					  	rowsPerPage: 25  	
			    		},
			rowsPerPageItems: [25, 50, 100, { "text": "$vuetify.dataIterator.rowsPerPageAll", "value": -1 }],
			branch: JSON.parse(localStorage.getItem('user')),
			photographers : [{id: '0', name: '--Select Photographers--'}],
			valuePhotographer: '',
			startDay: '',
			endDay:'',
			valueFilter: '',
			loading: false
	    }
	  },
	mounted() {
		this.getPhotographers()
	},

  	created(){
  		this.valuePhotographer = {id: '0', name: '--Select Photographers--'}
  		this.getSalesList()
	},

	methods:{
		getPhotographers() {
			this.photographers = [{id: '0', name: '--Select Photographers--'}]

			get(config.API_URL+'branch/photographers?branchId='+this.branch.branch_id)
			.then(response => {
				if(response && response.data.success) {
					var data = response.data.data
					var _this = this
					_.forEach(data, function(value,key){
						_this.photographers.push({id: value.id, name: value.name})
							
					})
				}
			})
		},
		getSalesList(){
			get(config.API_URL+'branch/sales-list?branchId='+this.branch.branch_id)
			.then(response => {
				if(response && response.data.success) {
					this.sales = response.data.data
					console.log(this.sales)
					
				}
			})
		},
		getValueFilter() {
			let array = []

			if(this.valuePhotographer) {

				if(this.valuePhotographer.id == '0') {
					array.push('photographerId:' + '0')
				} else {
					array.push('photographerId:' + this.valuePhotographer)

				}
			}

			if(this.from_day != '' && this.to_day != '') {

				array.push('fromDate:' + this.from_day)
				array.push('toDate:' + this.to_day)
			}

			this.valueFilter = array.join(';')
		},
		filterSale() {
			this.getValueFilter()

			let params = {
                search:this.valueFilter,
                branchId : this.branch.branch_id
            }

			getWithData(config.API_URL+'branch/sales-list', params)
			.then(response => {
				if(response && response.data.success == true) {
					this.sales = response.data.data	
				}
			})
			.catch(error => {
				console.log(error.response)
				this.sales = []
			})
		},
		exportSales()
		{
			this.getValueFilter()

			let params = {
                search:this.valueFilter,
                branchId : this.branch.branch_id
            }

            getWithData(config.API_URL+'branch/sales-list/export', params)
			.then(response => {
				console.log(response)
				if(response && response.data.status) {
					window.location.href = response.data.link	
				}
			})
			.catch(error => {
				console.log(error.response)
				//this.sales = []
			})
		},
		changeSort (column) {
	      var columnsNoSearch = ['actions']
	      if (columnsNoSearch.indexOf(column) > -1) {
	        return
	      }
	      this.loading = true
	      if (this.pagination.sortBy === column) {
	        this.pagination.descending = !this.pagination.descending
	      } else {
	        this.pagination.sortBy = column
	        this.pagination.descending = false
	      }
	      this.loading = false
	    },

	},
	computed:{
		computedStartDay(){
			return this.from_day
		},
		computedEndDay(){
			return this.to_day
		}
	}
}
</script>

<style lang="scss" scoped>
	.margin-btn-export{
		margin-top:4px;
		padding:10px 0px;
	}
	.sale-table{
		margin-top:30px;
	}
	.fix-column-btn{
		margin-top: 6px;
	}
	.fix-btn-sale{
		min-width: 20px;
		width:100px;
	}
	.fix-text-search-sale{
		min-width:150px !important;
	}
	.fix-v-card-title-sale{
		padding:0px 0px 16px 0px !important;
	}
</style>