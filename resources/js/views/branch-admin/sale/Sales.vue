<template>
	<div class="sale-table">
		<v-container fluid grid-list-xl pt-0>
			<div id="app">
				<v-app id="inspire">
					<v-card class="p-4">
						<v-toolbar flat color="white">
					        <v-toolbar-title>
					          	Manage Sales
					        </v-toolbar-title>
					    </v-toolbar>
					    <v-divider></v-divider>
					    
					   <v-layout row wrap border-rad-sm overflow-hidden>
						   	<!-- select box photographer -->
							<v-flex xl4 lg4 md4 sm6 xs12>
						        <v-select
						          v-model="valuePhotographer"
						          :items="photographers"
						           autocomplete
					              browserAutocomplete="off"
					              item-text="name"
					              item-value="id"
					              
						        ></v-select>


					      	</v-flex>
						   	<!-- Start day -->
						   	<v-flex xl2 lg2 md2 sm3 xs6>
								<v-menu 
									:close-on-content-click="false"
					                v-model="menu1"
					                :nudge-right="40"
					                lazy
					                transition="scale-transition"
					                offset-y
					                min-width="0"
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
							</v-flex>
							<!-- End day -->
							<v-flex xl2 lg2 md2 sm3 xs6>
								<v-menu 
										:close-on-content-click="false"
						                v-model="menu2"
						                :nudge-right="40"
						                lazy
						                transition="scale-transition"
						                offset-y
						                min-width="0"
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
							</v-flex>
							<v-flex xl2 lg1 md2 sm3 xs6 class="fix-column-btn">
								<v-btn class="btn-style fix-btn-sale" depressed color="primary" @click="filterSale()">Go</v-btn>
					      	</v-flex>
					      	<v-flex xl2 lg1 md2 sm3 xs6 class="fix-column-btn">
							    <v-btn slot="activator" class="fix-btn-sale" color="primary" @click="exportSales()">
									<v-icon small color="white">fas fa-file-excel</v-icon>
								</v-btn>
					      	</v-flex>
						</v-layout>
						
				      		<v-card-title class="fix-v-card-title-sale">
				      		<v-spacer></v-spacer>
				      		<v-flex xs4>
				      			<v-text-field
					        		v-model="search"
							        append-icon="search"
							        label="Enter search value"
							        single-line
							        hide-details
							        class="fix-text-search-sale"
							    ></v-text-field>
				      		</v-flex>
					      		
				    		</v-card-title>
						    <v-data-table 
							:headers="headers" 
							:items="sales" 
							class="elevation-5 custom-table-sale"  
							:pagination.sync="pagination" 
							:rows-per-page-items="rowsPerPageItems" 
							default-sort="id:desc"
							:search="search"
								>

								<template slot="no-data">
							      <v-alert :value="true" color="error" icon="warning">
							        Sorry, nothing to display here :(
							      </v-alert>
							    </template>

							    <template slot="items" slot-scope="props" >
									<td>{{ props.item.id }}</td>
									<td class="text-xs-left" >{{ props.item.branch.name }}</td>
									<td class="text-xs-left">{{ props.item.photographer.name }}</td>
									<td class="text-xs-left">{{ props.item.customer.room.room_hash }}</td>
									<td class="text-xs-left">{{ props.item.total_amount }}</td>
									<td class="text-xs-left">{{ props.item.purchase_date }}</td>
									<td class="text-xs-left">{{ props.item.download_date }}</td>
									<td class="text-xs-left">{{ props.item.customer.user.email }}</td>
									<td class="text-xs-left">{{ props.item.payment_method }}</td>
								</template>
							
							</v-data-table>
				   
						
				    </v-card>
				</v-app>
			</div>
		</v-container>
	</div>
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
				{text: 'ID' }, 
				{text: 'Branch'}, 
				{text:'Photographer', value: 'photographer.name'}, 
				{text: 'Room', value:'user.room.room_hash'}, 
				{text: 'Total Amount', value: 'total_amount'}, 
				{text: 'Purchase Date', value: 'purchase_date'}, 
				{text: 'Download Date', value: 'download_date'}, 
				{text: 'Customer Email', value:'user.email', sortable: false}, 
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
			valueFilter: ''
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
		}

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