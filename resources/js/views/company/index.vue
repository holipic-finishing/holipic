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
				        <v-text-field
				        	v-model="search.company_name"
					        append-icon="search"
					        label="Search Company Name"
					        single-line
					        hide-details
				        ></v-text-field>
				        <v-spacer></v-spacer>
				        <v-btn @click="doSearch" color="primary" dark class="mb-2">Search</v-btn>
				        <v-btn @click="doReset" color="primary" dark class="mb-2">Reset</v-btn>
			      	</v-toolbar>
			      	<v-data-table
			        :headers="headers"
			        :items="desserts"
			        class="elevation-1"
			      	>
			       	<template slot="items" slot-scope="props">
			    		<td>{{ props.item.id }}</td>
				        <td class="text-xs-left">{{ props.item.name }}</td>
				        <td class="text-xs-left">{{ props.item.address }}</td>
				        <td class="text-xs-left">{{ props.item.email }}</td>
				        <td class="text-xs-left">{{ props.item.description }}</td>
				        <td class="text-xs-left">
				        	<img v-if="props.item.logo != null " v-bind:src="props.item.logo"  width="100px" height="100px"/>
				    	</td>
				        <td class="text-xs-left">
				          <v-icon
				            small
				            class="mr-2"
				            @click="editItem(props.item)"
				          >
				            edit
				          </v-icon>
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

export default {

  	name: 'index',

  	data () {
	    return {
	    	headers: [	        
		        { text: 'ID', value: 'id' },	       
		        { text: 'Company Name', value: 'name' },	       
		        { text: 'Address', value: 'address' },	       
		        { text: 'Owner', value: 'email' },	
		        { text: 'Description', value: 'description' },	
		        { text: 'Logo' , value: 'logo', sortable: false},
		        { text: 'Action' }       
	      	],
	      	desserts:[],
	      	search:{
	      		company_name : ''
	      	},
	      	pagination: {},
	    }
  	},

  	created(){
  		this.fetchData();	
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
			this.search.company_name = ''
			this.fetchData()
		},

		showItem(item){
			console.log('show')
		},

		editItem(item){
			console.log('edit')
		}



	},


}
</script>

<style lang="css" scoped>
</style>