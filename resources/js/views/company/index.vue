<template>
	<div>
		<page-title-bar></page-title-bar>
		<v-container fluid grid-list-xl pt-0>
			<div id="app">
			    <v-app id="inspire">
		    	<div>
		      	<v-toolbar flat color="white">
			        <v-toolbar-title>Company List</v-toolbar-title>
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
					        	v-model="search.keywords"
						        append-icon="search"
						        label="Search"
						        single-line
						        hide-details
						        @keyup.enter="doSearch"
						       	@keydown.esc="doReset"
					        ></v-text-field>
	                    </v-flex>
	                    <v-flex xs1>

	                    </v-flex>
	                    <v-flex xs3>
	                    	<v-select
	                    		:items="listPackage"
					            label="Package"
					            v-model="search.filterPackage"
					            @keydown.esc="doReset"
					        ></v-select>
	                    </v-flex>
	                </v-flex> 
			        <v-spacer></v-spacer>
			        <v-btn @click="doSearch" color="primary" dark class="mb-2">Search</v-btn>
			        <v-btn color="primary" dark class="mb-2"><a :href="urlExport+'?keywords='+search.keywords+'&filterPackage='+search.filterPackage" target="_blank">Export</a></v-btn>
		      	</v-toolbar>
		      	<v-data-table
		        :headers="headers"
		        :items="desserts"
		        class="elevation-1"
		      	>

		       	<template slot="items" slot-scope="props">
		    		<td>{{ props.item.id }}</td>
			        <td class="text-xs-left">{{ props.item.name }}</td>
			        <td class="text-xs-left">{{ props.item.email }}</td>
			        <td class="text-xs-left">{{ props.item.fullname }}</td>
			        <td class="text-xs-left">{{ props.item.package_name }}</td>
			        <td class="text-xs-left">{{ props.item.address }}</td>
			        <td class="text-xs-left">{{ props.item.description }}</td>
			        <td class="text-xs-left">
			        	<img v-if="props.item.logo != null " v-bind:src="props.item.logo"  width="100px" height="100px"/>
			    	</td>
			        <td class="text-xs-left">{{ props.item.total_income }}</td>
			        <td class="text-xs-left">{{ props.item.total_file_size }}</td>
			        <td class="text-xs-left">{{ props.item.total_income_fee }}</td>
			        <td >
			          <v-icon
			            small
			    		class="mr-2"
			    		@click="showItem(props.item)"
			          >
			            visibility
			          </v-icon>
			          <v-icon
			            small
			    		class="mr-2"
			    		@click.stop="drawerRight = !drawerRight"
			    		@click="showTransaction(props.item)">
			            monetization_on
			        </v-icon>
			        <v-icon
			            small
			    		class="mr-2"
			        >
			    		<!-- @click.stop="drawerRightEdit = !drawerRightEdit"
			    		@click="showEditTransaction(props.item)" -->
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
		    	</div>
				<!-- show money transaction -->

			    </v-app>
				<v-navigation-drawer
			      fixed
			      v-model="drawerRight"
			      right
			      clipped
			      app
				  :width="400"
			      >
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
		    	 	
		            <v-list-tile >
		                <v-list-tile-content>
		                	 <v-toolbar flat class="transparent">
						        <v-list class="pa-0">
						          <v-list-tile avatar>
						            <v-list-tile-content>
						             	Transaction History
						             </v-list-tile-content>
						            <v-list-tile-content>
					              		<input type="text" v-model="search.keywords" class="form-control input-style" placeholder="Search" 
								       	@keydown.esc="doReset">
						            </v-list-tile-content>
						          </v-list-tile>
						        </v-list>
						      </v-toolbar>
		              	</v-list-tile-content>
           		 	</v-list-tile>
           		 	  <v-list-tile >
		                <v-list-tile-content>
		             
								<div class="custom-flex">
								<nav class="nav nav-bar-chart">
								  <a class="nav-link" :class="typeTimeReturn === 'day' ? 'active' : '' " @click="activeTypeTime('day')">Day</a>
								  <a class="nav-link" :class="typeTimeReturn === 'week' ? 'active' : '' " @click="activeTypeTime('week')">Week</a>
								  <a class="nav-link" :class="typeTimeReturn === 'month' ? 'active' : '' " @click="activeTypeTime('month')">Month</a>
								  <a class="nav-link" :class="typeTimeReturn === 'year' ? 'active' : '' " @click="activeTypeTime('year')">Year</a>
								</nav>
								<div class="justify-space-between w-30">
									<div class="text-total text-xs-right">
										<h4 class="primary--text mb-0">{{total}}$</h4>
										
									</div>
	 							</div>			
								</div>
		              	</v-list-tile-content>
           		 	</v-list-tile>
           		 	<v-list two-line>
			            <v-list-tile
							v-for="item in transactionHistories"
            				:key="item.id"
            				class="style-list"
			            >
			              <v-list-tile-content>
			                <v-list-tile-title v-text="item.title"></v-list-tile-title>
			                <v-list-tile-sub-title v-text="item.dated" class="text-style"></v-list-tile-sub-title>
			              </v-list-tile-content>
			  
			              <v-list-tile-action>
			                <p class="success--text mb-0" v-if="item.type == true">+{{item.amount}}</p>
			                <p class="mb-0" v-if="item.type == false">-{{item.amount}}</p>
			              </v-list-tile-action>
			            </v-list-tile>

			        </v-list> 
			        <button type="button" @click="addTenItem()" class="btn btn-primary">Primary</button>  
	   			 </v-navigation-drawer>
	   			 <!-- end -->
			</div>
		</v-container>		
	</div>	
</template>

<script>
import  { get, post, put, del, getWithData } from '../../api/index.js'
import config from '../../config/index.js'
import Vue from 'vue'
import Lodash from 'lodash'
import moment from 'moment'

export default {

  	name: 'index',

  	data () {
	    return {
	    	headers: [	        
		        { text: 'ID', value: 'id' },	       
		        { text: 'Company Name', value: 'name' },	
		        { text: 'Email', value: 'email'},
		        { text: 'Fullname', value: 'fullname' },		      
		        { text: 'Package', value: 'package_name' },	       
		        { text: 'Address', value: 'address', sortable: false },	       
		        { text: 'Description', value: 'description', sortable: false },	
		        { text: 'Logo' , value: 'logo', sortable: false},
		        { text: 'Total Incomes', value: 'total_income'  },       
		        { text: 'Total File Size', value: 'total_file_size'},       
		        { text: 'Total Income Fee', value: 'total_income_fee'  },
		        { text: 'Action', sortable: false, width: '10%' },         
	      	],
	      	desserts:[],
	      	search:{
	      		keywords : '',
	      		filterPackage : ''
	      	},

	      	listPackage : [],
	      	urlExport:config.API_URL+'exportexcel/companies',
	      	drawerRight: false,
	      	title:'',
	      	typeTime:'',
	      	total:0,
	      	company_id:'',
	      	transactionHistories: {},
	      	paginator: {
                perPage: 1,
                currentPage: 1,
                lastPage: 1,
                total: 0,
                from: 0,
                to: 0,
        	},


	    }
  	},

  	created(){
  		this.fetchData();	
  		this.getListPackage();
		this.typeTime = "day"
	},

	methods:{
		fetchData() {
			get(config.API_URL+'companies')
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
			post(config.API_URL+'search/companies', this.search)
			.then((res) => {
				if(res.data && res.data.success){
					this.desserts = res.data.data
				}
			})
			.catch((e) =>{
				console.log(e)
			})
		},


		getData(value,id){

			let url = config.API_URL+'transaction/history'

			let params = {
                perPage: this.paginator.perPage,
                companyId: this.company_id,
                search: this.searchBy,
                time:value
            }	

			getWithData(url,params)
			.then((res)=>{
				if (res.data && res.data.success) {
					this.transactionHistories= res.data.data.data
					var total_revenue = 0
					var total_expenditure = 0
					 _.forEach(res.data.data.data,function(value,key){
		                if(value.type == true) {
		                	total_revenue = total_revenue + parseFloat(value.amount)
		                } else {
		                	total_expenditure =total_expenditure + parseFloat(value.amount)
		                }
		             });
					this.total = total_revenue - total_expenditure
				}
			})
			.catch((e) =>{
				console.log(e)
			})

		},

		doReset(){
			this.search.keywords = ''
			this.search.filterPackage =''
			this.fetchData()
		},


		getListPackage(){
			var data = []
			data.push('All')

			get(config.API_URL+'list/packages')
			.then((res) => {
				_.forEach(res.data, function(value) {
                  	data.push(value.package_name)
                });
			})
			.catch((e) =>{
				console.log(e)
			}) 

			this.listPackage = data

		},

		showItem(item){
			this.$root.$router.push({
				path: '/default/widgets/mana-company-chart', 
				query: { companyId: item.id}
			})
		},

		showTransaction(items){
			this.drawerRight = true

			this.company_id = items.id

			// this.configParams('day',items.id)
			this.getData('day',items.id)
			

		},

		activeTypeTime(time) {

  			this.typeTime = time

  			if(this.typeTime == "day") {
  				// this.configParams(this.company_id,'day')
  				this.getData('day',this.company_id)

			}

			if(this.typeTime == "week") {

				this.configParams(this.company_id,'week')
			}

			if(this.typeTime == "month") {

				this.configParams(this.company_id,'month')
			}

			if(this.typeTime == "year") {

				// this.configParams(this.company_id,'year')
				this.getData('year',this.company_id)

			}
		}, 

		addTenItem(){
			if(this.typeTime == "day") {
				this.paginator.perPage = this.paginator.perPage + 1
  				// this.configParams(,'day')
  				this.getData('day',this.company_id)
			}
			if(this.typeTime == "year") {
				this.paginator.perPage = this.paginator.perPage + 1
				this.getData('year',this.company_id)
				// this.configParams(this.company_id,'year')
			}
			
		}


	},

	computed:{
	  	typeTimeReturn(){
	  		return this.typeTime
	  	}
	},

}
</script>

<style lang="css" scoped>
.input-style{
	width: 160px ;
}

.nav-bar-chart{
	font-size: 14px;
    font-weight: bold;
    width: 100%;
}

.nav-link {
		color: #6b6d70 !important;
}

.active{
		color: #2196f3 !important;
}
.custom-flex {
	display: flex !important;
    width: 100%;
}
.text-total {
	padding: 7px 15px;
}.style-list {
	border-bottom: 1px solid gray;
    margin: 0px 20px;
}
.text-style {
	font-size: 12px !important;
}
</style>