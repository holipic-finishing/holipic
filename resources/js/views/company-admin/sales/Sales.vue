<template>
<div class="company-table">
<!-- <page-title-bar></page-title-bar> -->
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
			    <!-- Filter Component -->
			   <v-layout row wrap border-rad-sm overflow-hidden>
			   	<!-- select box branch -->
				<v-flex xl3 lg3 md3 sm6 xs12>
		       <v-select
		          v-model="selected"
		          :items="items"
		           autocomplete
	              browserAutocomplete="off"
	              item-text="name"
	              item-value="id"
	              v-on:change="changeBranh(selected)"
		        ></v-select>
		      	</v-flex>
			   	<!-- select box photographer -->
				<v-flex xl3 lg3 md3 sm6 xs12>
		        <v-select
		          v-model="selected1"
		          :items="phographer"
		           autocomplete
	              browserAutocomplete="off"
	              item-text="name"
	              item-value="id"
	              label="Select Photographer"
		        ></v-select>
		      	</v-flex>
			   	<!-- Start day -->
			   	<v-flex xl2 lg2 md2 sm6 xs12>
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
						:value="computedStartDay"
  						placeholder="Enter Start Date"
  						clearable
					></v-text-field>
					<v-date-picker 
						v-model="from_day"
						no-title
						@change="menu1 = false"
						scrollable 
						:max="new Date().toISOString().substr(0, 10)"
					></v-date-picker>
				</v-menu>
				</v-flex>
				<!-- End day -->
				<v-flex xl2 lg2 md2 sm6 xs12>
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
					></v-text-field>
					<v-date-picker 
						v-model="to_day" 
						no-title 
						scrollable 
						@change="menu2 = false"
						:max="new Date().toISOString().substr(0, 10)"
					></v-date-picker>
				</v-menu>
				</v-flex>
				<v-flex xl1 lg1 md1 sm6 xs12>
					<v-btn class="btn-style" depressed color="primary" @click="sreachSales()">Go</v-btn>
		      	</v-flex>
		      	<v-flex xl1 lg1 md1 sm6 xs12>
				    <v-tooltip bottom class="icon-style">
					    <a :href="urlExport" target="_blank" slot="activator" class="btn btn-primary pl-2 pr-2 ml-3">
								<v-icon small color="white">fas fa-file-excel</v-icon>
							</a>
					    <span>Export companies</span>
				    </v-tooltip>
		      	</v-flex>
				</v-layout>
				<!--Search Component -->
				<v-card-title class="card-style">
		      		<v-spacer></v-spacer>
		      		<v-text-field
		        		v-model="search"
				        append-icon="search"
				        label="Enter search value"
				        single-line
				        hide-details
				    ></v-text-field>
		    	</v-card-title>
		    	<!--End Search Component -->
				<!--Data Table Component -->
				<v-data-table
				:headers="headers" 
				:items="desserts" 
				class="elevation-5 style-table"
				item-key="id" 
				:pagination.sync="pagination" 
				:rows-per-page-items="rowsPerPageItems" 
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
			                <span slot="activator" class="text-capitalize subheading font-weight-bold">
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
						<td>{{ props.item.total_amount }}</td>
						<td>{{ props.item.purchase_date }}</td>
						<td>{{ props.item.download_date }}</td>
						<td>{{ props.item.customer_email }}</td>
						<td>{{ props.item.payment_method }}</td>

					</template>
				</v-data-table>
		    </v-card>
		</v-app>
	</div>
</v-container>
</div>			    	
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
			urlExport:'',
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
				{ text: 'Total Amount', value: 'total_amount' },		      
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
			this.makeParams()
			let params = {
                search:this.filterSearch,
                company_id : this.authUser.company_id
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
				console.log(err)
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