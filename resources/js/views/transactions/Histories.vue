<template>
	<div class="margin-table">
		<!-- <page-title-bar></page-title-bar> -->
		<v-container fluid grid-list-xl pt-0>
			<div id="app">
			  <v-app id="inspire">
			    <div>
			      	<v-toolbar flat color="white">
				        <h3 class="h3-title">Transactions History</h3>
				        <v-divider
				          class="mx-2"
				          inset
				          vertical
				        ></v-divider>

				        <v-flex xs12 class="row"> 
				        	<v-flex xs7></v-flex>
		                    <v-flex xs5>
		                     	 <v-text-field
							        append-icon="search"
							        label="Search"
							        v-model= "search.keywords"
							        single-line
							        hide-details
							        @keyup.enter="doSearch"
							       	@keydown.esc="doReset"
						        ></v-text-field>
		                    </v-flex>
		                </v-flex> 
			      	</v-toolbar>
			      	<!-- <v-toolbar flat color="white">       
				        <v-flex xs12 class="row"> 
		                    <v-flex xs5>
		                     	 <v-text-field
							        append-icon="search"
							        label="Search"
							        v-model= "search.keywords"
							        single-line
							        hide-details
							        @keyup.enter="doSearch"
							       	@keydown.esc="doReset"
						        ></v-text-field>
		                    </v-flex>
		                </v-flex> 
				        <v-spacer></v-spacer>
				        <v-btn @click="doSearch" color="primary" dark class="mb-2">Search</v-btn>
			      	</v-toolbar> -->
			      	<v-data-table
			        :headers="headers"
			        :items="desserts"
			        class="elevation-1"
			        :disable-initial-sort="true"
			        :pagination.sync="pagination"
			        :rows-per-page-items="rows_per_page"
			      	>
			      	<template slot="items" slot-scope="props">
			    		<td>{{ props.item.id }}</td>
			    		<td>{{ props.item.invoice }}</td>
			    		<td>{{ props.item.company_name }}</td>
			    		<td>{{ props.item.email }}</td>
			    		<td>{{ props.item.fullname }}</td>
			    		<td>{{ props.item.package_name }}</td>
			    		<td>{{ props.item.title }}</td>
			    		<td>
			    			<div v-if="props.item.type == 1" style="color:green">
		    					+{{ props.item.amount_with_symbol}} 
			    			</div>
			    			<div v-else>
			    				-{{ props.item.amount_with_symbol}} 
			    			</div>
			    		
			    		</td>
			    		<td>
			    			<div v-if="props.item.type == 1" style="color:green">
		    					+{{ props.item.system_fee_with_symbol}} 
			    			</div>
			    			<div v-else>
			    				-{{ props.item.system_fee_with_symbol}} 
			    			</div>
			    		</td>
			    		<td>
			    			<div v-if="props.item.type == 1" style="color:green">
		    					+{{ props.item.credit_card_fee_with_symbol}} 
			    			</div>
			    			<div v-else>
			    				-{{ props.item.credit_card_fee_with_symbol}} 
			    			</div>
			    		</td>
			    		<td>
							<v-btn color="success" small v-if="props.item.status === 'RECIVED'">{{ props.item.status }}</v-btn>
							<v-btn color="error" small v-else>{{ props.item.status }}</v-btn>
			    		</td>
			    		<td>{{ props.item.country }}</td>
			    		<td>{{ props.item.dated }}</td>
			    	</template>
			      </v-data-table>
			    </div>
			  </v-app>
			</div>
		</v-container>
	</div>
</template>

<script>
import  { get, post, put, del } from '../../api/index.js'
import config from '../../config/index.js'
import Vue from 'vue'

export default {

  name: 'Histories',

  	data () {
		return {
			headers: [	        
		        { text: 'ID', value: 'id' },	       
		        { text: 'Invoice', value: 'invoice' },	       
		        { text: 'Company Name',value: 'company_name'},	       
		        { text: 'Email', value: 'email'	},	       
		        { text: 'Full Name',value: 'fullname', sortable: false},	       
		        { text: 'Package Name', value: 'package_name', sortable: false },	       
		        { text: 'Transaction', value: 'title', sortable: false },	       
		        { text: 'Amount', value: 'amount_with_symbol'},	       
		        { text: 'System Fee', value: 'system_fee_with_symbol' },	       
		        { text: 'Create Card Fee', value: 'credit_card_fee_with_symbol'},	   
		        { text: 'Status', value: 'status',  sortable: false},	
		        { text: 'Country', value: 'country',  sortable: false},	
		        { text: 'Date', value: 'dated', width : '15%' },	   
		  	],
		  	desserts:[],
		  	pagination:{
		  		rowsPerPage: 20,
		  	},
		  	rows_per_page:[
		  		20, 
		  		40, 
		  		80, 
		  		{ "text": "$vuetify.dataIterator.rowsPerPageAll", "value": -1 }
		  	],

		  	search:{
		  		keywords : ''
		  	},
		}
  	},
  	created(){
		this.fetchData();	
	},

	methods:{
		fetchData() {
			get(config.API_URL+'histories/transactions')
			.then((res) => {
				if(res.data && res.data.success){
					this.desserts = res.data.data
				}
				
			})
			.catch((e) =>{
				console.log(e)
			}) 
		},

		doSearch(){
			post(config.API_URL+'search/transactions', this.search)
			.then((res) => {
				if(res.data && res.data.success){
					this.desserts = res.data.data
				}
			})
			.catch((e) =>{
				console.log(e)
			})
		},

		doReset(){
			this.search.keywords = ''
			this.fetchData()
		}	

	},
}
</script>

<style lang="css" scoped>

.h3-title-transaction{
	width: 290px;
}
</style>

