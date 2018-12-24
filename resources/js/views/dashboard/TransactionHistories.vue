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
	      app
	      :width="400">
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
              	<v-list-tile-content class="drawer-info">
                	<v-list-tile-title class="font-weight-regular drawer-info-tile" >Company ID</v-list-tile-title>
                	<v-list-tile-sub-title class="font-weight-thin ">{{ items.id }}</v-list-tile-sub-title>
                </v-list-tile-content>
            </v-list-tile>
            <v-list-tile >
                <v-list-tile-content  class="drawer-info">
                	<v-list-tile-title class="font-weight-regular drawer-info-tile" >Company Name </v-list-tile-title>
                	<v-list-tile-sub-title class="font-weight-thin">{{ items.company_name }}</v-list-tile-sub-title>
              	</v-list-tile-content>
            </v-list-tile>
            <v-list-tile >
                <v-list-tile-content class="drawer-info">
                	<v-list-tile-title class="font-weight-regular drawer-info-tile">Invoice </v-list-tile-title>
                	<v-list-tile-sub-title class="font-weight-thin">{{ items.invoice }}</v-list-tile-sub-title>
              	</v-list-tile-content>
            </v-list-tile>
            <v-list-tile >
                <v-list-tile-content class="drawer-info">
                	<v-list-tile-title class="font-weight-regular drawer-info-tile">Date </v-list-tile-title>
                	<v-list-tile-sub-title class="font-weight-thin">{{ items.dated }}</v-list-tile-sub-title>
              	</v-list-tile-content>
            </v-list-tile>
            <v-list-tile >
                <v-list-tile-content class="drawer-info">
                	<v-list-tile-title class="font-weight-regular drawer-info-tile">Transaction </v-list-tile-title>
                	<v-list-tile-sub-title class="font-weight-thin">{{ items.title }}</v-list-tile-sub-title>
              	</v-list-tile-content>
            </v-list-tile>
            <v-list-tile >
                <v-list-tile-content class="drawer-info">
                	<v-list-tile-title class="font-weight-regular drawer-info-tile">Amount </v-list-tile-title>
                	<v-list-tile-sub-title class="font-weight-thin">{{ items.amount_with_symbol }}</v-list-tile-sub-title>
              	</v-list-tile-content class="drawer-info">
            </v-list-tile>
            <v-list-tile >
                <v-list-tile-content class="drawer-info">
                	<v-list-tile-title class="font-weight-regular drawer-info-tile">Credit Card Fee </v-list-tile-title>
                	<v-list-tile-sub-title class="font-weight-thin">{{ items.credit_card_fee_with_symbol }}</v-list-tile-sub-title>
              	</v-list-tile-content>
            </v-list-tile>
            <v-list-tile >
                <v-list-tile-content class="drawer-info">
                	<v-list-tile-title class="font-weight-regular drawer-info-tile">Status </v-list-tile-title>
                	<v-list-tile-sub-title>
	                	<v-btn color="success" small v-if="items.status === 'RECIVED'">{{ items.status }}</v-btn>
						<v-btn color="error" small v-else>{{ items.status }}</v-btn>
					</v-list-tile-sub-title>
              	</v-list-tile-content>
            </v-list-tile>
            <v-list-tile >
                <v-list-tile-content class="drawer-info">
                	<v-list-tile-title class="font-weight-regular drawer-info-tile">Package Name </v-list-tile-title>
                	<v-list-tile-sub-title class="font-weight-thin">{{ items.package_name }}</v-list-tile-sub-title>
              	</v-list-tile-content>
            </v-list-tile>
            <v-list-tile >
                <v-list-tile-content class="drawer-info">
                	<v-list-tile-title class="font-weight-regular drawer-info-tile">Email </v-list-tile-title>
                	<v-list-tile-sub-title class="font-weight-thin">{{ items.email }}</v-list-tile-sub-title>
              	</v-list-tile-content>
            </v-list-tile>
            <v-list-tile >
                <v-list-tile-content class="drawer-info">
                	<v-list-tile-title class="font-weight-regular drawer-info-tile">Fullname </v-list-tile-title>
                	<v-list-tile-sub-title class="font-weight-thin">{{ items.fullname }}</v-list-tile-sub-title>
              	</v-list-tile-content>
            </v-list-tile>
            <v-list-tile >
                <v-list-tile-content class="drawer-info">
                	<v-list-tile-title class="font-weight-regular drawer-info-tile">Country </v-list-tile-title>
                	<v-list-tile-sub-title class="font-weight-thin">{{ items.country }}</v-list-tile-sub-title>
              	</v-list-tile-content>
            </v-list-tile>
            <v-list-tile >
                <v-list-tile-content>
              	</v-list-tile-content>
            </v-list-tile>
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
	    </v-navigation-drawer>
	    
	    <v-navigation-drawer
	      fixed
	      v-model="drawerRightEdit"
	      right
	      clipped
	      app
	      :width="400">
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
              	<v-list-tile-content class="drawer-info">
                	<v-list-tile-title class="font-weight-regular drawer-info-tile" >Company ID</v-list-tile-title>
                	<v-list-tile-sub-title class="font-weight-thin ">{{ items.id }}</v-list-tile-sub-title>
                </v-list-tile-content>
            </v-list-tile>
           	<v-list-tile >
                <v-list-tile-content  class="drawer-info">
                	<v-list-tile-title class="font-weight-regular drawer-info-tile" >Company Name </v-list-tile-title>
                	<v-list-tile-sub-title class="font-weight-thin">{{ items.company_name }}</v-list-tile-sub-title>
              	</v-list-tile-content>
            </v-list-tile>
            <v-list-tile >
                <v-list-tile-content  class="drawer-info">
                	<v-list-tile-title class="font-weight-regular drawer-info-tile" >Currency </v-list-tile-title>
                	<v-list-tile-sub-title class="font-weight-thin">{{ items.symbol }}</v-list-tile-sub-title>
              	</v-list-tile-content>
            </v-list-tile>
	      	<v-list-tile >
                <v-list-tile-content>
              	</v-list-tile-content>
            </v-list-tile>
	      	<v-list-tile>	      			
	      		<v-text-field label="Amount" v-model="itemEdit.amount" :rules="[rules.number]"></v-text-field>
            </v-list-tile>
            <v-list-tile>
    			<v-select
		            :items="listStatus"
		            label="Status"
		            v-model="itemEdit.status"
		        ></v-select>		    	
            </v-list-tile>
             <v-list-tile>
    			<v-list-tile-content>
              	</v-list-tile-content>		    	
            </v-list-tile>
            <v-list-tile>
            	<v-spacer></v-spacer>
	           	<v-btn color="primary" @click="editTransaction()" :disabled="!itemEdit.amount">Edit</v-btn>
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
      			:pagination.sync="pagination"
      			:total-items="totalDesserts"
      			:loading="loading"
      			class="elevation-1"
	      	>
		      	<template slot="items" slot-scope="props">
		    		<td>{{ props.item.id }}</td>
		    		<td>{{ props.item.user.company.name }}</td>
		    		<td>{{ props.item.invoice }}</td>
					<td>{{ props.item.dated }}</td>
		    		<td>{{ props.item.title }}</td>
		    		<td>
		    			<div v-if="props.item.type" style="color:green">
		    				+{{ props.item.amount_with_symbol}} 
		    			</div>
		    			<div v-else>
		    				-{{ props.item.amount_with_symbol}} 
		    			</div>

		    		</td>
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
	    	totalDesserts: 0,
	    	loading: true,
	    	headers: [	        
		        { text: 'ID', value: 'id' },	
		        { text: 'Company Name',value: 'company_name'},	       
		        { text: 'Invoice', value: 'invoice' },	
		        { text: 'Date', value: 'dated' },       
		        { text: 'Transaction', value: 'title', align: 'left'},
		        { text: 'Amount', value: 'amount_with_symbol' , width: '15%'},
		        { text: 'Status', value: 'status' },	
		        { text: 'Action', align: 'center'},	   
		  	],
		  	desserts:[],
		  	pagination:{

		  	},

		  	search:{
		  		keywords : ''
		  	},
	      	drawerRight: false,
	      	drawerRightEdit : false,
		  	right: null,
		  	
	        items:{},

	        itemEdit: {
	        	'amount' : '',
	        	'status' : '',
	        	'id' : '',
	        	'symbol' : ''
	        },

	        listStatus: ['RECIVED', 'BEEN SEEN'],

	        rules: {
	          	number: value => {
		            const abc = /^([0-9]*|\d*\.\d{1}?\d*)$/
		            return abc.test(value) || 'Please input number.'
	          	},

        	},


	    }
  	},

  	watch: {
      	pagination: {
	        handler () {
          		this.getDataFromApi()
	            .then(data => {
	              	this.desserts = data.items
	              	this.totalDesserts = data.total
	            })
        	},
        	deep: true
      	}
    },

  	created(){
		this.fetchData();	
	},

	mounted () {
      	this.getDataFromApi()
        .then(data => {
          	this.desserts = data.items
          	this.totalDesserts = data.total
        })
    },

  	methods:{
  		getDataFromApi () {
	        this.loading = true
	        return new Promise((resolve, reject) => {
	          	const { sortBy, descending, page, rowsPerPage } = this.pagination

	          	var items = this.getDesserts()	

	          	console.log(items)
	          	const total = items.length

	          	if (this.pagination.sortBy) {
	            	items = items.sort((a, b) => {
	              		const sortA = a[sortBy]
	              		const sortB = b[sortBy]

	              		if (descending) {
	                		if (sortA < sortB) return 1
	                		if (sortA > sortB) return -1
	                		return 0
          				} else {
           					if (sortA < sortB) return -1
        					if (sortA > sortB) return 1
      						return 0
          				}
	            	})
	         	}

	          	if (rowsPerPage > 0) {
	            	items = items.slice((page - 1) * rowsPerPage, page * rowsPerPage)
	          	}

	          	setTimeout(() => {
	            	this.loading = false
	            	resolve({
		              items,
		              total
	            	})
	          	}, 1000)
	        })
	    },

	    getDesserts () {
      		this.fetchData()

      		return this.desserts
    	},

  		fetchData() {
			get(config.API_URL + 'histories/transactions')
			.then((res) => {
				if(res.data && res.data.success){
					let data = res.data.data
					this.desserts = data
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
	                setTimeout(function(){
	                    Vue.notify({
	                        group: 'loggedIn',
	                        type: 'success',
	                        text: 'Data deleted'
	                    });
	               	},500);
					
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
			this.itemEdit.symbol = items.symbol
		},

		editTransaction(){
			post(config.API_URL+'edit/transactions', this.itemEdit)
			.then((res) => {
				this.drawerRightEdit = false
				this.fetchData()
                setTimeout(function(){
                    Vue.notify({
                        group: 'loggedIn',
                        type: 'success',
                        text: 'Data edited'
                    });
               	},500);
			})
			.catch((e) =>{
				console.log(e)
			})
		}
  	}
};
</script>

<style lang="css" scoped>
	.drawer-info{
		flex-direction:row
	}
	.drawer-info-tile{
		flex: 0 0 40%
	}
</style>