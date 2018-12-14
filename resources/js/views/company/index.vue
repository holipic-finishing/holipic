<template>
	<div>
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
				        <td class="text-xs-left">{{ props.item.email }}</td>
				        <td class="text-xs-left">{{ props.item.fullname }}</td>
				        <td class="text-xs-left">{{ props.item.package_name }}</td>
				        <td class="text-xs-left">{{ props.item.address }}</td>
				        <td class="text-xs-left">{{ props.item.description }}</td>
				        <td class="text-xs-left">
				        	<img v-if="props.item.logo != null " v-bind:src="props.item.logo"  width="100px" height="100px"/>
				    	</td>
				        <td class="text-xs-left">
				          <v-icon
				            small
				    		class="mr-2"
				    		@click="showItem(props.item)"
				          >
				            visibility
				          </v-icon>
				        </td>
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
import Lodash from 'lodash'

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
		        { text: 'Action', sortable: false }       
	      	],
	      	desserts:[],
	      	search:{
	      		keywords : '',
	      		filterPackage : ''
	      	},

	      	listPackage : [],
	      	urlExport:config.API_URL+'exportexcel/companies'
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




	},


}
</script>

<style lang="css" scoped>
</style>