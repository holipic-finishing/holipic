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
			   			<!-- select box branch -->
							<v-flex md3 sm6 xs12>
								<v-card class="elevation-5">
				  				<v-card-text>
						       	<v-autocomplete
						          v-model="selected"
						          :items="items"
					            item-text="name"
					            item-value="id"
					            v-on:change="changeBranh(selected)"
						        ></v-autocomplete>
				  				</v-card-text>
				  			</v-card>
			      	</v-flex>
					   	<!-- select box photographer -->
							<v-flex md3 sm6 xs12>
								<v-card class="elevation-5">
				  				<v-card-text>
						        <v-autocomplete
						          v-model="selected1"
						          :items="phographer"
					            item-text="name"
					            item-value="id"
						        ></v-autocomplete>
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
										>
											<v-text-field 
												slot="activator"
												prepend-icon="event"
												readonly
												:value="computedStartDay"
					  						placeholder="Enter Start Date"
					  						clearable
					  						@click:clear="clearSearchDate"
											></v-text-field>
											<v-date-picker 
												v-model="from_day"
												no-title
												@change="menu1 = false"
												scrollable 
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
										>
											<v-text-field 
												slot="activator"
												prepend-icon="event"
												readonly
												:value="computedEndDay"
					  						placeholder="Enter End Date"
					  						clearable
					  						@click:clear="clearSearchEndDate"
											></v-text-field>
											<v-date-picker 
												v-model="to_day" 
												no-title 
												scrollable 
												@change="menu2 = false"
												:max="new Date().toISOString().substr(0, 10)"
											></v-date-picker>
										</v-menu>
				  				</v-card-text>
				  			</v-card>
							</v-flex>
			  		</v-layout>
			  	</v-flex>
			  	<v-flex md1 sm12 xs12 align-center justify-center>
			  		<v-btn class="btn-gradient-primary" fab dark @click="sreachSales()">Go</v-btn>
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
					    	<v-btn slot="activator" small fab dark @click="exportFile" class="ml-2 btn-gradient-primary">
									<v-icon dark>fas fa-file-excel</v-icon>
								</v-btn>
						    <span>Export Sales</span>
					    </v-tooltip>
				    </v-card-title>
					</v-flex>
				</v-layout>
				<v-data-table
					:headers="headers" 
					:items="desserts" 
					class="elevation-5 body-2 global-custom-table"
					item-key="id" 
					:pagination.sync="pagination" 
					:rows-per-page-items="rowsPerPageItems" 
					:search="search"
				>
					<v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear>
					<!--Header -->
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
		              <v-icon v-if="header.value != 'actions'">arrow_upward</v-icon>
	            	</div>
	            </th>
	          </tr>
	        </template>
				
					<template slot="items" slot-scope="props">
						<td>{{ props.item.id }}</td>
						<td>{{ props.item.branch_name }}</td>
						<td>{{ props.item.photographer_name }}</td>
						<td>{{ props.item.room_has_number }}</td>
						<td>{{ formatTotal(props.item.total_amount) }}</td>
						<td>{{ props.item.purchase_date }}</td>
						<td>{{ props.item.download_date }}</td>
						<td>{{ props.item.customer_email }}</td>
						<td>{{ props.item.payment_method }}</td>
					</template>

					<!--No data -->
				  <template slot="no-data">
			      <v-alert :value="true" color="error" icon="warning">
			        Sorry, nothing to display here :(
			      </v-alert>
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
import { get, post, put, getWithData } from '../../../api/index.js'
import config from '../../../config/index.js'
export default {

	name: 'Sales',

	data () {
	return {
			menu1:false,
			menu2:false,	
			from_day:'',
			to_day:'',
			search:'',
			selected: {id:'0',name:"-- Select Branch --" },
      items: [{id:'0',name:"-- Select Branch --" }],
      phographer:[{id:'0',name:'-- Select Photographer --'}],
			selected1:'',
			authUser:JSON.parse(localStorage.getItem('user')),
			filterSearch:'',
			pagination: {
			  rowsPerPage: 25  	
	    },
	    rowsPerPageItems: [25, 50, 100, { "text": "$vuetify.dataIterator.rowsPerPageAll", "value": -1 }],
	    headers:[
	    	{ text: 'ID', value: 'id',align: 'left',width: '3%'},	       
				{ text: 'Branch', value: 'branch_name' },
				{ text: 'Photographer', value: 'photographer_name'},	
				{ text: 'Room Number', value: 'room_has_number',align: 'left',width: '10%'},	
				{ text: 'Total Amount', value: 'total_amount',align: 'left' },		      
				{ text: 'Purchase Date', value: 'purchase_date' },
				{ text: 'Download Date', value: 'download_date' },	
				{ text: 'Customer Email', value: 'customer_email' },	
				{ text: 'Payment Method', value: 'payment_method',align: 'left',width: '3%' },	
	    ],
	    desserts:[]
		}
	},
	created(){
		this.fetchDataBranch()
		this.fetchData()
    this.selected1 = {
    	id:'0',
    	name:'-- Select Photographer --'	
    }
	},
	methods:{
		fetchDataBranch(){
		
			var url = config.API_URL+'company/branch-company?companyId='+this.authUser.company_id

			get(url)
			.then(res => {
				if(res.data && res.data.success){
					var data = res.data.data
					var vm = this
					_.forEach(data, function(value,key){
						vm.items.push(value)					
					})				    
				}
			})
			.catch(err => {
				console.log(err)
			})
		},
		changeBranh(item){		
			if(item == 0) {
				this.phographer =  [{
		        	id:'0',
		        	name:'-- Select Photographer --'	
		        }]
		        this.selected1 = {
	        		id:'0',
	        		name:'-- Select Photographer --'	
	       	 	}
			} 
			var url = config.API_URL+'photographer/photographer-branch?branchId='+item
			get(url)
			.then(res => {
				if(res.data && res.data.success){
					var data = res.data.data
					var vm = this
					_.forEach(data, function(value,key){
						vm.phographer.push(value)
							
					})
				}
			})	
			.catch(err =>{

			})
		},
		fetchData(){
			this.makeParams()
			let params = {
                search:this.filterSearch,
                company_id:this.authUser.company_id
            }	
			let url = config.API_URL+'order/orders-company'
			getWithData(url,params)
			.then(res => {
				if(res.data && res.data.success){
					let data = res.data.data
					this.desserts = data
				}
			})
			.catch(err => {

			})
		},

		makeParams(){

			let searchValues = []
			var setsearch = ''

			if(_.trim(this.selected)){
				if(this.selected.id == 0 ) {
                searchValues.push('branch_id:' + '0')

				} else {

                searchValues.push('branch_id:' + this.selected)
				}
      }
      if(_.trim(this.selected1)){
       	if(this.selected == 0){
       		searchValues.push('photographer_id:' +'0')
       	}  else if(this.selected1.id == 0) {
       		searchValues.push('photographer_id:' +'0')
       	} else {
          	searchValues.push('photographer_id:' + this.selected1)
       	}
      }
      if(_.trim(this.from_day)){
          searchValues.push('from_day:' + this.from_day)
      }
      if(_.trim(this.to_day)){
          searchValues.push('to_day:' + this.to_day)
      }

			this.filterSearch = searchValues.join(";")
		},

		sreachSales(){
			this.fetchData()
		},

		clearSearchDate(){
			this.from_day = ""
		},

		clearSearchEndDate(){
			this.to_day = ""
		},

		formatTotal($total){
			let totalAmount = parseFloat($total).toFixed(3)

			return totalAmount;
		},

		exportFile(){
			this.makeParams()
			let params = {
                search:this.filterSearch,
                company_id : this.authUser.company_id
            }	
			let url = config.API_URL+'order/sales/company/export'
			getWithData(url,params)
			.then(res => {
				if(res.data && res.data.status){
					window.location.href = res.data.link
				}
			})
			.catch(err => {
				console.log(err)
			})
		},
		toggleAll () {
      if (this.selected.length) this.selected = []
      else{
	    	this.selected = this.desserts.slice()
      }
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
		},
	}
};
</script>

<style lang="css" scoped>
.btn-style{
	margin: auto 0px;
}
.icon-style {
	margin: auto 0px;
}
.card-style {
	padding: 0px !important;
}
.style-table{
	margin-top:15px !important;
}
</style>