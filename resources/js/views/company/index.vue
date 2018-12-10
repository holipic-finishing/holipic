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
				        <v-spacer></v-spacer>
			        
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
				        <td class="text-xs-left">{{ props.item.logo }}</td>
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
			        <template slot="no-data">
			          <v-btn color="primary" >Reset</v-btn>
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
		        { text: 'Logo' , value: 'logo', sortable: false},
		        { text: 'Action' }       
	      	],
	      	desserts:[]
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

		showItem(item){
			alert(1)
			this.$root.$router.push({
    			path: '/default/widgets/mana-company-chart', 
    			query: { companyId: item.id, name: item.name, description: item.description, address: item.address }
			})
		},

		editItem(item){
			console.log('edit')
		}

	},


}
</script>

<style lang="css" scoped>
</style>