<template>
	<v-layout row wrap>
		<app-card
			colClasses="xl12 lg12 md12 sm12 xs12"
			customClasses="mb-0 sales-widget"
			:fullScreen="true"
			:reloadable="true"
			:closeable="false"
		>
		<v-navigation-drawer
	      fixed
	      v-model="drawerRight"
	      right
	      clipped
	      app>
	      	<v-list dense>
		        <v-list-tile @click.stop="drawerRight = !drawerRight">
			          	<v-list-tile-action>
			            	<v-icon>exit_to_app</v-icon>
			          	</v-list-tile-action>
			          	<v-list-tile-content>
			            	<v-list-tile-title>Exit Your Drawer</v-list-tile-title>
			          	</v-list-tile-content>
		        </v-list-tile>
	      	</v-list>
	      	<v-list-tile>
              	<v-list-tile-content>
                	<v-list-tile-title >ID : {{ items.id }}</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>
            <v-list-tile >
                <v-list-tile-content>
                	<v-list-tile-title class="font-weight-regular">Company Name :</v-list-tile-title>
                	<v-list-tile-sub-title class="font-weight-thin">{{ items.company_name }}</v-list-tile-sub-title>
              	</v-list-tile-content>
            </v-list-tile>
            <v-list-tile >
                <v-list-tile-content>
                	<v-list-tile-title class="font-weight-regular">Invoice :</v-list-tile-title>
                	<v-list-tile-sub-title class="font-weight-thin">{{ items.invoice }}</v-list-tile-sub-title>
              	</v-list-tile-content>
            </v-list-tile>
            <v-list-tile >
                <v-list-tile-content>
                	<v-list-tile-title class="font-weight-regular">Date :</v-list-tile-title>
                	<v-list-tile-sub-title class="font-weight-thin">{{ items.dated }}</v-list-tile-sub-title>
              	</v-list-tile-content>
            </v-list-tile>
            <v-list-tile >
                <v-list-tile-content>
                	<v-list-tile-title class="font-weight-regular">Transaction :</v-list-tile-title>
                	<v-list-tile-sub-title class="font-weight-thin">{{ items.type }}</v-list-tile-sub-title>
              	</v-list-tile-content>
            </v-list-tile>
            <v-list-tile >
                <v-list-tile-content>
                	<v-list-tile-title class="font-weight-regular">Amount :</v-list-tile-title>
                	<v-list-tile-sub-title class="font-weight-thin">{{ items.amount_with_symbol }}</v-list-tile-sub-title>
              	</v-list-tile-content>
            </v-list-tile>
            <v-list-tile >
                <v-list-tile-content>
                	<v-list-tile-title class="font-weight-regular">Credit Card Fee :</v-list-tile-title>
                	<v-list-tile-sub-title class="font-weight-thin">{{ items.credit_card_fee_with_symbol }}</v-list-tile-sub-title>
              	</v-list-tile-content>
            </v-list-tile>
            <v-list-tile >
                <v-list-tile-content>
                	<v-list-tile-title class="font-weight-regular">Status :</v-list-tile-title>
                	<v-list-tile-sub-title>
	                	<v-btn color="success" small v-if="items.status === 'RECIVED'">{{ items.status }}</v-btn>
						<v-btn color="error" small v-else>{{ items.status }}</v-btn>
					</v-list-tile-sub-title>
              	</v-list-tile-content>
            </v-list-tile>
            <v-list-tile >
                <v-list-tile-content>
                	<v-list-tile-title class="font-weight-regular">Package Name :</v-list-tile-title>
                	<v-list-tile-sub-title class="font-weight-thin">{{ items.package_name }}</v-list-tile-sub-title>
              	</v-list-tile-content>
            </v-list-tile>
            <v-list-tile >
                <v-list-tile-content>
                	<v-list-tile-title class="font-weight-regular">Email:</v-list-tile-title>
                	<v-list-tile-sub-title class="font-weight-thin">{{ items.email }}</v-list-tile-sub-title>
              	</v-list-tile-content>
            </v-list-tile>
            <v-list-tile >
                <v-list-tile-content>
                	<v-list-tile-title class="font-weight-regular">Fullname :</v-list-tile-title>
                	<v-list-tile-sub-title class="font-weight-thin">{{ items.fullname }}</v-list-tile-sub-title>
              	</v-list-tile-content>
            </v-list-tile>
            <v-list-tile >
                <v-list-tile-content>
                	<v-list-tile-title class="font-weight-regular">Country :</v-list-tile-title>
                	<v-list-tile-sub-title class="font-weight-thin">{{ items.country }}</v-list-tile-sub-title>
              	</v-list-tile-content>
            </v-list-tile>
            <v-list-tile >
                <v-list-tile-content>
              	</v-list-tile-content>
            </v-list-tile>
	    </v-navigation-drawer>
	    <v-navigation-drawer
	      fixed
	      v-model="drawerRightEdit"
	      right
	      clipped
	      app>
	      	<v-list dense>
		        <v-list-tile @click.stop="drawerRightEdit = !drawerRightEdit">
			          	<v-list-tile-action>
			            	<v-icon>exit_to_app</v-icon>
			          	</v-list-tile-action>
			          	<v-list-tile-content>
			            	<v-list-tile-title>Exit Your Drawer</v-list-tile-title>
			          	</v-list-tile-content>
		        </v-list-tile>
	      	</v-list>
	      	<v-list-tile>
              	<v-list-tile-content>
                	<v-list-tile-title >ID : {{ items.id }}</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>
            <v-list-tile >
                <v-list-tile-content>
                	<v-list-tile-title class="font-weight-regular">Company Name :</v-list-tile-title>
                	<v-list-tile-sub-title class="font-weight-thin">{{ items.company_name }}</v-list-tile-sub-title>
              	</v-list-tile-content>
            </v-list-tile>
	      	<v-list-tile >
                <v-list-tile-content>
              	</v-list-tile-content>
            </v-list-tile>
	      	<v-list-tile>
	            <v-text-field label="Amount" v-model="itemEdit.amount"></v-text-field>
            </v-list-tile>
            <v-list-tile>
	            <v-select
		            :items="listStatus"
		            label="Status"
		            v-model="itemEdit.status"
		        ></v-select>
            </v-list-tile>
            <v-list-tile>
            	<v-spacer></v-spacer>
	           	<v-btn color="primary" @click="editTransaction()">Edit</v-btn>
            </v-list-tile>
	    </v-navigation-drawer>
	      	<v-toolbar flat color="white">
		        <v-toolbar-title ><a href="admin#/mini/transaction/histories"> Transaction Histories Table</a></v-toolbar-title>
		        <v-divider
		          class="mx-2"
		          inset
		          vertical
		        ></v-divider>
	      	</v-toolbar>
	      	<v-toolbar flat color="white">       
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
	      	</v-toolbar>
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
		    		<td>{{ props.item.company_name }}</td>
		    		<td>{{ props.item.invoice }}</td>
					<td>{{ props.item.dated }}</td>
		    		<td>{{ props.item.type }}</td>
		    		<td>{{ props.item.amount_with_symbol }}</td>
		    		<td>
						<v-btn color="success" small v-if="props.item.status === 'RECIVED'">{{ props.item.status }}</v-btn>
						 <v-btn color="error" small v-else>{{ props.item.status }}</v-btn>
		    		</td>
		    		<td> 
		    			<v-icon
				            small
				    		class="mr-2"
				    		@click.stop="drawerRight = !drawerRight"
				    		@click="showTransaction(props.item)">
				            visibility
				        </v-icon>
				         <v-icon
				            small
				    		class="mr-2"
				    		@click.stop="drawerRightEdit = !drawerRightEdit"
				    		@click="showEditTransaction(props.item)"
				        >
				            edit
				        </v-icon>
				        <v-icon
				            small
				    		class="mr-2"
				    		@click="deleteTransaction(props.item.id)"
				        >
				            delete
				        </v-icon>
		    		</td>
		    	</template>
	      	</v-data-table>	
	      	<v-snackbar v-model="snack" :timeout="3000" :color="snackColor" right bottom>
		        {{ snackText }}
		        <v-btn flat @click="snack = false">Close</v-btn>
		    </v-snackbar>			
	   	</app-card>
	</v-layout>
</template>

<script>
import  { get, post, put, del } from '../../api/index.js'
import config from '../../config/index.js'
import Vue from 'vue'
export default {

  	name: 'TransactionHistories',

  	data () {
	    return {
	    	headers: [	        
		        { text: 'ID', value: 'id' },	
		        { text: 'Company Name',value: 'company_name'},	       
		        { text: 'Invoice', value: 'invoice' },	
		        { text: 'Date', value: 'dated' },       
		        { text: 'Transaction', value: 'type' },
		        { text: 'Amount', value: 'amount_with_symbol' },
		        { text: 'Status', value: 'status' },	
		        { text: 'Action'},	   
		  	],
		  	desserts:[],
		  	pagination:{
		  		rowsPerPage: 10,
		  	},
		  	rows_per_page:[
		  		10, 
		  		20, 
		  		40,
		  		80, 
		  		{ "text": "$vuetify.dataIterator.rowsPerPageAll", "value": -1 }
		  	],

		  	search:{
		  		keywords : ''
		  	},
	      	drawerRight: false,
	      	drawerRightEdit : false,
		  	right: null,
		  	snack: false,
	        snackColor: '',
	        snackText: '',

	        items:{},

	        itemEdit: {
	        	'amount' : '',
	        	'status' : '',
	        	'id' : ''
	        },

	        listStatus: ['RECIVED', 'BEEN SEEN']
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
			post(config.API_URL+'searchdashboard/transactions', this.search)
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
		},

		deleteTransaction(id){
			if (confirm("Do you really want to delete it?")) {
				del(config.API_URL+'transactions/'+id)
				.then((res) => {
					this.fetchData()
					this.snack = true,
	                this.snackColor = 'success',
	                this.snackText = 'Data deleted'
					
				})
				.catch((e) =>{
					console.log(e)
				}) 
			}
		},

		showTransaction(items){
			this.drawerRightEdit = false
			this.items = items
		},

		showEditTransaction(items){
			this.drawerRight = false
			this.items = items
			this.itemEdit.id = items.id
			this.itemEdit.amount = items.amount
			this.itemEdit.status = items.status
		},

		editTransaction(){
			post(config.API_URL+'edit/transactions', this.itemEdit)
			.then((res) => {
				this.drawerRightEdit = false
				this.fetchData()
				this.snack = true,
                this.snackColor = 'success'
                this.snackText = 'Data edited'
			})
			.catch((e) =>{
				console.log(e)
			})
		}



  	}
}
</script>

<style lang="css" scoped>
</style>