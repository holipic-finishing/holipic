<template>
	<div >
		<page-title-bar></page-title-bar>
		<v-container fluid grid-list-xl pt-0>
			<div id="app">

			  <v-app id="inspire">
			    <div>
			      	<v-toolbar flat color="white">
				        <v-toolbar-title>Company Table</v-toolbar-title>
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
				        <td class="text-xs-left">{{ props.item.fullname }}</td>
				        <td class="text-xs-left">{{ props.item.email }}</td>
				        <td class="text-xs-left">{{ props.item.phone }}</td>

				        <!-- <td class="text-xs-left">{{ props.item.package_name }}</td> -->
				        <!-- <td class="text-xs-left">{{ props.item.address }}</td> -->
				        <!-- <td class="text-xs-left">{{ props.item.description }}</td> -->
				        <!-- <td class="text-xs-left">
				        	<img v-if="props.item.logo != null " v-bind:src="props.item.logo"  width="100px" height="100px"/>
				    	</td>
				        <td class="text-xs-left">{{ props.item.total_income }}</td>
				        <td class="text-xs-left">{{ props.item.total_file_size }}</td>
				        <td class="text-xs-left">{{ props.item.total_income_fee }}</td> -->
				        <td class="text-xs-left">
				         <!--  <v-icon
				            small
				    		class="mr-2"
				    		@click="showItem(props.item)"
				          >
				            visibility
				          </v-icon> -->
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
				           <v-icon
				            small
				    		class="mr-2"
				    		@click="showInfo(props.item)"
				          >
				            visibility
				          </v-icon>

				        </td>
			    	</template>
			      </v-data-table>
			       <company-information></company-information>
			    </div>
			  </v-app>
			  <show-transaction></show-transaction>


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
import ShowTransaction from './ShowTransaction.vue'
import CompanyInformation from './NavigationCompanyInformation'


export default {

  	name: 'index',
  	components: {
  		ShowTransaction,
  		'company-information' : CompanyInformation
  	},

  	data () {
	    return {
	    	headers: [	        
		        { text: 'ID', value: 'id' },	       
		        { text: 'Company Name', value: 'name' },	
		        { text: 'Owner/ Manager', value: 'fullname' },
		        { text: 'Email', value: 'email'},	
		        { text: 'Phone', value: 'phone' },		      

		        // { text: 'Package', value: 'package_name' },	       
		        // { text: 'Address', value: 'address', sortable: false },	       
		        // { text: 'Description', value: 'description', sortable: false },	
		        // { text: 'Logo' , value: 'logo', sortable: false},
		        // { text: 'Total Incomes', value: 'total_income'  },       
		        // { text: 'Total File Size', value: 'total_file_size'},       
		        // { text: 'Total Income Fee', value: 'total_income_fee'  },
		        { text: 'Action', sortable: false },         
		        
	      	],
	      	desserts:[],
	      	search:{
	      		keywords : '',
	      		filterPackage : ''
	      	},

	      	listPackage : [],
	      	urlExport:config.API_URL+'exportexcel/companies',
	      	drawerRight: false,
	
	    }
  	},

  	created(){
  		this.fetchData();	
  		this.getListPackage();
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
			
			let obj = {
				typeTime : 'Day',
				showDrawerRight : true,
				companyId : items.id
			}

			this.$root.$emit('showTransactionStatus', obj)

	
		},


		showInfo(item) {
			this.$root.$emit('sendEventCompanyInformation', {
				showNavigation: true,
				data: item
			});
		}


	},


}
</script>

<style lang="css" scoped>

.input-style{
	width: 160px ;
}


</style>